"""Image SEO auditor.

Crawls a site (or a local HTML dump), inventories every image, grades it against
image-SEO and accessibility best practice, generates suggested alt text plus
target keywords, and writes a multi-sheet XLSX report.

Usage:
    python image_seo_audit.py https://example.com/
    python image_seo_audit.py https://example.com/ --max-pages 300 --out audit.xlsx
    python image_seo_audit.py https://example.com/ --html-dir ./saved_pages

Reports are saved to reports/ as timestamped .xlsx files.
"""

import argparse
import io
import os
import re
import sys
import time
from collections import Counter, defaultdict
from datetime import datetime
from pathlib import Path
from urllib.parse import urljoin, urlparse, urlsplit, unquote

import requests
from bs4 import BeautifulSoup

try:
    from PIL import Image
except ImportError:  # dimensions become "unknown", everything else still works
    Image = None

from openpyxl import Workbook
from openpyxl.styles import Alignment, Border, Font, PatternFill, Side
from openpyxl.utils import get_column_letter
from openpyxl.worksheet.table import Table, TableStyleInfo


USER_AGENT = (
    "Mozilla/5.0 (compatible; ImageSEOAudit/1.0; +https://github.com/) "
    "AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0 Safari/537.36"
)

IMAGE_EXTENSIONS = {
    ".jpg", ".jpeg", ".png", ".gif", ".webp", ".avif",
    ".svg", ".bmp", ".tiff", ".tif", ".ico", ".heic",
}
NEXT_GEN_FORMATS = {".webp", ".avif"}
VECTOR_FORMATS = {".svg", ".ico"}

# Attributes that carry a real or deferred image source.
SRC_ATTRS = [
    "src", "data-src", "data-lazy-src", "data-original", "data-lazy",
    "data-echo", "data-image", "data-large_image", "data-full-url",
    "data-srcset", "srcset", "data-lazy-srcset", "data-bg", "data-background",
]

# Alt text that exists but says nothing useful.
GENERIC_ALT_PATTERNS = [
    r"^\s*$", r"^image$", r"^img$", r"^photo$", r"^picture$", r"^pic$",
    r"^logo$", r"^icon$", r"^banner$", r"^thumbnail$", r"^thumb$",
    r"^untitled", r"^img[-_ ]?\d+", r"^dsc[-_ ]?\d+", r"^image[-_ ]?\d+",
    r"^photo[-_ ]?\d+", r"^screenshot", r"^\d+$", r"^[a-f0-9]{8,}$",
    r"^placeholder", r"^default", r"^no[-_ ]?image", r"\.(jpe?g|png|gif|webp)$",
]

# Filename patterns that waste the filename ranking signal.
BAD_FILENAME_PATTERNS = [
    (r"^img[-_]?\d+", "camera default name (IMG_####)"),
    (r"^dsc[-_]?\d+", "camera default name (DSC_####)"),
    (r"^dscn?\d+", "camera default name"),
    (r"^p\d{7,}", "camera default name"),
    (r"^screen[-_ ]?shot", "screenshot default name"),
    (r"^screenshot", "screenshot default name"),
    (r"^untitled", "placeholder name"),
    (r"^\d+$", "digits only"),
    (r"^[a-f0-9]{16,}$", "hash / UUID name"),
    (r"^[a-f0-9]{8}-[a-f0-9]{4}-", "UUID name"),
    (r"^(final|new|copy|temp|test|asset|file|upload)[-_ ]?\d*$", "non-descriptive name"),
]

STOPWORDS = {
    "the", "a", "an", "and", "or", "of", "for", "to", "in", "on", "at", "by",
    "with", "from", "is", "are", "was", "were", "be", "been", "this", "that",
    "it", "its", "as", "our", "your", "you", "we", "us", "all", "new", "best",
    "top", "buy", "shop", "online", "home", "page", "com", "www", "http",
    "https", "html", "php", "index", "default", "img", "image", "images",
    "photo", "photos", "pic", "pics", "jpg", "jpeg", "png", "webp", "gif",
    "svg", "scaled", "copy", "final", "min", "large", "small", "thumb",
    "thumbnail", "cropped", "resized", "edited", "version", "sample",
    # camera / device filename noise
    "dsc", "dscn", "imgp", "pxl", "mvimg", "photo", "shot", "edit",
}

# Words a good alt tag should never open with.
ALT_FILLER_PREFIXES = [
    "image of", "picture of", "photo of", "photograph of", "graphic of",
    "an image of", "a picture of", "a photo of", "this is",
]

COLOR_WORDS = {
    "black", "white", "red", "blue", "green", "pink", "purple", "yellow",
    "orange", "grey", "gray", "beige", "nude", "ivory", "cream", "navy",
    "maroon", "burgundy", "gold", "silver", "bronze", "teal", "turquoise",
    "lavender", "coral", "peach", "mint", "olive", "tan", "brown", "champagne",
}

# Severity ordering drives the sort and the colour banding in the report.
SEVERITY_ORDER = {"Critical": 0, "High": 1, "Medium": 2, "Low": 3, "Pass": 4}

MAX_ALT_LENGTH = 125          # screen readers commonly truncate past this
IDEAL_ALT_MIN_WORDS = 3
SIZE_WARN_BYTES = 150 * 1024
SIZE_HIGH_BYTES = 300 * 1024
SIZE_CRITICAL_BYTES = 600 * 1024
ABOVE_FOLD_COUNT = 2          # first N images treated as likely LCP candidates


# --------------------------------------------------------------------------
# Small helpers
# --------------------------------------------------------------------------

def norm_space(text):
    return re.sub(r"\s+", " ", (text or "")).strip()


def url_extension(url):
    path = urlsplit(url).path
    ext = os.path.splitext(unquote(path))[1].lower()
    return ext if ext in IMAGE_EXTENSIONS else ext


def url_filename(url):
    path = urlsplit(url).path
    return unquote(os.path.basename(path))


def looks_like_image(url):
    if not url:
        return False
    if url.startswith("data:"):
        return url.startswith("data:image")
    ext = url_extension(url)
    if ext in IMAGE_EXTENSIONS:
        return True
    # CDN URLs frequently drop the extension but keep a format hint.
    return bool(re.search(r"(format|fm|f)=(jpe?g|png|webp|avif|gif)", url, re.I))


def first_srcset_url(value):
    """Return the largest candidate from a srcset string."""
    if not value:
        return None
    best_url, best_weight = None, -1.0
    for candidate in value.split(","):
        parts = candidate.strip().split()
        if not parts:
            continue
        url = parts[0]
        weight = 0.0
        if len(parts) > 1:
            descriptor = parts[1].lower()
            match = re.match(r"([\d.]+)(w|x)", descriptor)
            if match:
                weight = float(match.group(1))
                if match.group(2) == "x":
                    weight *= 1000  # keep density and width comparable-ish
        if weight >= best_weight:
            best_url, best_weight = url, weight
    return best_url


def tokenize(text):
    """Split arbitrary text into meaningful lowercase word tokens."""
    text = re.sub(r"[_\-+.]+", " ", (text or ""))
    text = re.sub(r"([a-z])([A-Z])", r"\1 \2", text)
    words = re.findall(r"[a-zA-Z][a-zA-Z']+", text.lower())
    return [w for w in words if w not in STOPWORDS and len(w) > 2]


def title_case(text):
    small = {"and", "or", "of", "for", "in", "on", "at", "by", "with", "the", "a", "an"}
    words = text.split()
    out = []
    for i, word in enumerate(words):
        if i > 0 and word.lower() in small:
            out.append(word.lower())
        elif word.isupper() and len(word) <= 4:
            out.append(word)  # keep acronyms
        else:
            out.append(word[:1].upper() + word[1:])
    return " ".join(out)


def human_bytes(num):
    if num is None:
        return ""
    for unit in ("B", "KB", "MB"):
        if abs(num) < 1024 or unit == "MB":
            return f"{num:.0f} {unit}" if unit == "B" else f"{num:.1f} {unit}"
        num /= 1024.0
    return f"{num:.1f} MB"


# --------------------------------------------------------------------------
# Crawling
# --------------------------------------------------------------------------

class Crawler:
    def __init__(self, base_url, max_pages=200, delay=0.4, timeout=20, verbose=True):
        self.base_url = base_url.rstrip("/") + "/"
        self.host = urlparse(self.base_url).netloc
        self.max_pages = max_pages
        self.delay = delay
        self.timeout = timeout
        self.verbose = verbose
        self.session = requests.Session()
        self.session.headers.update({
            "User-Agent": USER_AGENT,
            "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Language": "en-US,en;q=0.9",
        })
        self.pages = {}       # url -> html
        self.failed = {}      # url -> reason

    def log(self, message):
        if self.verbose:
            print(message, flush=True)

    def same_site(self, url):
        netloc = urlparse(url).netloc
        return netloc == self.host or netloc == "www." + self.host or "www." + netloc == self.host

    def get(self, url, as_xml=False):
        response = self.session.get(url, timeout=self.timeout, allow_redirects=True)
        response.raise_for_status()
        content_type = response.headers.get("Content-Type", "")
        if not as_xml and "html" not in content_type and "xml" not in content_type:
            raise ValueError(f"not an HTML document ({content_type or 'unknown type'})")
        return response

    # -- URL discovery ----------------------------------------------------

    def sitemap_urls(self):
        """Collect page URLs from robots.txt-declared and conventional sitemaps."""
        candidates = []
        try:
            robots = self.session.get(urljoin(self.base_url, "/robots.txt"), timeout=self.timeout)
            if robots.ok:
                candidates += re.findall(r"(?im)^\s*sitemap:\s*(\S+)", robots.text)
        except requests.RequestException:
            pass
        candidates += [
            urljoin(self.base_url, path)
            for path in ("/sitemap.xml", "/sitemap_index.xml", "/wp-sitemap.xml",
                         "/sitemap/sitemap-index.xml", "/product-sitemap.xml")
        ]

        found, seen_sitemaps, queue = [], set(), list(dict.fromkeys(candidates))
        while queue and len(found) < self.max_pages * 4:
            sitemap_url = queue.pop(0)
            if sitemap_url in seen_sitemaps:
                continue
            seen_sitemaps.add(sitemap_url)
            try:
                response = self.get(sitemap_url, as_xml=True)
            except (requests.RequestException, ValueError):
                continue
            soup = BeautifulSoup(response.content, "xml")
            nested = [loc.get_text(strip=True) for loc in soup.select("sitemap > loc")]
            queue.extend(nested)
            page_locs = [loc.get_text(strip=True) for loc in soup.select("url > loc")]
            if not nested and not page_locs:
                page_locs = [loc.get_text(strip=True) for loc in soup.find_all("loc")]
            found.extend(u for u in page_locs if self.same_site(u))
            self.log(f"  sitemap {sitemap_url} -> {len(page_locs)} urls, {len(nested)} nested")

        return list(dict.fromkeys(found))

    def crawl(self):
        self.log(f"Discovering URLs for {self.base_url}")
        queue = self.sitemap_urls()
        if queue:
            self.log(f"  {len(queue)} URLs from sitemaps")
        else:
            self.log("  no sitemap found - falling back to link crawl")
        queue = [self.base_url] + [u for u in queue if u != self.base_url]

        seen = set()
        while queue and len(self.pages) < self.max_pages:
            url = queue.pop(0).split("#")[0]
            if url in seen or not self.same_site(url):
                continue
            seen.add(url)
            if re.search(r"\.(pdf|zip|jpg|jpeg|png|gif|webp|svg|css|js|mp4|xml|json)$", urlsplit(url).path, re.I):
                continue
            try:
                response = self.get(url)
            except (requests.RequestException, ValueError) as exc:
                self.failed[url] = str(exc)[:200]
                self.log(f"  [skip] {url} - {str(exc)[:80]}")
                continue

            final_url = response.url.split("#")[0]
            self.pages[final_url] = response.text
            seen.add(final_url)
            self.log(f"  [{len(self.pages):>4}/{self.max_pages}] {final_url}")

            # Follow internal links so a missing/partial sitemap still gets covered.
            soup = BeautifulSoup(response.text, "lxml")
            for anchor in soup.find_all("a", href=True):
                link = urljoin(final_url, anchor["href"]).split("#")[0]
                if self.same_site(link) and link not in seen and link not in queue:
                    queue.append(link)

            time.sleep(self.delay)

        return self.pages


def load_local_pages(html_dir):
    """Load a directory of saved .html files instead of crawling."""
    pages = {}
    for path in sorted(Path(html_dir).rglob("*.htm*")):
        html = path.read_text(encoding="utf-8", errors="replace")
        canonical = None
        match = re.search(r'<link[^>]+rel=["\']canonical["\'][^>]+href=["\']([^"\']+)', html, re.I)
        if match:
            canonical = match.group(1)
        pages[canonical or path.as_uri()] = html
    return pages


# --------------------------------------------------------------------------
# Page and image parsing
# --------------------------------------------------------------------------

def page_category(url, soup):
    """Best-effort category: breadcrumb text first, then URL path."""
    h1_tag = soup.find("h1")
    current_page = norm_space(h1_tag.get_text()).lower() if h1_tag else ""

    for selector in ('[class*="breadcrumb"] li', '[class*="breadcrumb"] a',
                     'nav[aria-label*="readcrumb"] a', '[itemtype*="BreadcrumbList"] [itemprop="name"]'):
        crumbs = [norm_space(el.get_text()) for el in soup.select(selector)]
        crumbs = [c for c in crumbs if c and c.lower() not in ("home", "/", "»", ">")]
        # Drop the trailing crumb only when it is the current page rather than a
        # real ancestor - link-only selectors already exclude the current page.
        if len(crumbs) > 1 and current_page and crumbs[-1].lower() in current_page:
            crumbs = crumbs[:-1]
        if crumbs:
            return " > ".join(crumbs[:3])

    path = [p for p in urlsplit(url).path.strip("/").split("/") if p]
    if not path:
        return "Homepage"
    ignore = {"product", "products", "page", "p", "index.html", "collections", "en", "fr"}
    parts = [p for p in path[:-1] if p.lower() not in ignore] or path[:1]
    return " > ".join(title_case(p.replace("-", " ").replace("_", " ")) for p in parts[:3])


def page_type(url, soup):
    path = urlsplit(url).path.strip("/")
    if not path:
        return "Homepage"
    if soup.find(attrs={"type": "application/ld+json"}, string=re.compile(r'"@type"\s*:\s*"Product"', re.I)):
        return "Product"
    lowered = path.lower()
    for needle, label in (("product", "Product"), ("collection", "Category"),
                          ("category", "Category"), ("shop", "Category"),
                          ("blog", "Blog"), ("news", "Blog"), ("article", "Blog"),
                          ("about", "Informational"), ("contact", "Informational"),
                          ("cart", "Utility"), ("checkout", "Utility"),
                          ("account", "Utility"), ("policy", "Utility"),
                          ("terms", "Utility"), ("privacy", "Utility")):
        if needle in lowered:
            return label
    return "Content"


def nearest_heading(tag):
    """Walk backwards through the document for the closest preceding heading."""
    for previous in tag.find_all_previous(["h1", "h2", "h3", "h4"], limit=6):
        text = norm_space(previous.get_text())
        if text:
            return text
    return ""


def image_context(tag, soup):
    """Gather nearby text that describes what the image actually shows."""
    context = {}

    figure = tag.find_parent("figure")
    if figure:
        caption = figure.find("figcaption")
        if caption:
            context["caption"] = norm_space(caption.get_text())

    anchor = tag.find_parent("a")
    if anchor:
        context["link_title"] = norm_space(anchor.get("title") or "")
        link_text = norm_space(anchor.get_text())
        if link_text:
            context["link_text"] = link_text
        if anchor.get("href"):
            context["link_href"] = anchor["href"]

    context["heading"] = nearest_heading(tag)

    # A product card usually puts the name in a sibling heading or title element.
    card = tag.find_parent(attrs={"class": re.compile(r"(product|card|item|tile|grid__item)", re.I)})
    if card:
        for selector in ("h1", "h2", "h3", "h4", '[class*="title"]', '[class*="name"]'):
            element = card.select_one(selector)
            if element:
                text = norm_space(element.get_text())
                if text:
                    context["card_title"] = text
                    break

    classes = " ".join(tag.get("class") or [])
    if classes:
        context["css_class"] = classes
    return context


def extract_page_meta(url, html):
    soup = BeautifulSoup(html, "lxml")
    title_tag = soup.find("title")
    h1_tag = soup.find("h1")

    brand = ""
    site_name = soup.find("meta", property="og:site_name")
    if site_name and site_name.get("content"):
        brand = norm_space(site_name["content"])
    if not brand:
        brand = title_case(urlparse(url).netloc.replace("www.", "").split(".")[0])

    meta_description = ""
    description_tag = soup.find("meta", attrs={"name": "description"})
    if description_tag and description_tag.get("content"):
        meta_description = norm_space(description_tag["content"])

    return soup, {
        "url": url,
        "title": norm_space(title_tag.get_text()) if title_tag else "",
        "h1": norm_space(h1_tag.get_text()) if h1_tag else "",
        "meta_description": meta_description,
        "brand": brand,
        "category": page_category(url, soup),
        "page_type": page_type(url, soup),
    }


def extract_images(page_url, soup, page_meta):
    """Return one record per image reference found on the page."""
    records = []
    position = 0

    def add(url, tag, source_kind, alt=None, alt_present=False):
        nonlocal position
        if not url or url.startswith("data:"):
            return
        absolute = urljoin(page_url, url.strip())
        if not looks_like_image(absolute):
            return
        position += 1
        attrs = tag.attrs if tag is not None else {}
        records.append({
            "page_url": page_url,
            "page_title": page_meta["title"],
            "page_h1": page_meta["h1"],
            "page_type": page_meta["page_type"],
            "category": page_meta["category"],
            "brand": page_meta["brand"],
            "image_url": absolute,
            "source_kind": source_kind,
            "position": position,
            "alt_present": alt_present,
            "alt": alt if alt is not None else "",
            "title_attr": norm_space(attrs.get("title", "")),
            "width_attr": str(attrs.get("width", "")).strip(),
            "height_attr": str(attrs.get("height", "")).strip(),
            "loading": str(attrs.get("loading", "")).strip().lower(),
            "decoding": str(attrs.get("decoding", "")).strip().lower(),
            "fetchpriority": str(attrs.get("fetchpriority", "")).strip().lower(),
            "sizes": str(attrs.get("sizes", "")).strip(),
            "has_srcset": bool(attrs.get("srcset") or attrs.get("data-srcset")),
            "is_lazy_attr": any(a in attrs for a in
                                ("data-src", "data-lazy-src", "data-original", "data-srcset")),
            "context": image_context(tag, soup) if tag is not None else {},
        })

    for tag in soup.find_all("img"):
        alt_present = tag.has_attr("alt")
        alt = norm_space(tag.get("alt", ""))
        src = None
        for attribute in SRC_ATTRS:
            value = tag.get(attribute)
            if not value:
                continue
            candidate = first_srcset_url(value) if "srcset" in attribute else value
            if candidate and not candidate.startswith("data:"):
                src = candidate
                break
        if src is None and tag.get("src"):
            src = tag["src"]  # data: placeholder with no real source behind it
        add(src, tag, "img", alt, alt_present)

    # <picture><source> candidates that img never falls back to.
    for source in soup.find_all("source"):
        if not source.find_parent("picture"):
            continue
        candidate = first_srcset_url(source.get("srcset") or source.get("data-srcset"))
        parent_img = source.find_parent("picture").find("img")
        if candidate and parent_img is not None:
            existing = {r["image_url"] for r in records}
            if urljoin(page_url, candidate) not in existing:
                add(candidate, source, "picture-source",
                    norm_space(parent_img.get("alt", "")), parent_img.has_attr("alt"))

    # Images only present inside <noscript> (JS-lazy fallbacks).
    for noscript in soup.find_all("noscript"):
        inner = BeautifulSoup(noscript.decode_contents(), "lxml")
        for tag in inner.find_all("img"):
            if tag.get("src"):
                add(tag["src"], tag, "noscript-img",
                    norm_space(tag.get("alt", "")), tag.has_attr("alt"))

    # CSS background images set inline - invisible to search engines as content.
    for tag in soup.find_all(style=True):
        for match in re.findall(r"background(?:-image)?\s*:[^;]*url\(['\"]?([^'\")]+)", tag["style"], re.I):
            add(match, tag, "css-background", "", False)

    # Social preview images.
    for prop, kind in (("og:image", "og:image"), ("twitter:image", "twitter:image")):
        for meta in soup.find_all("meta", attrs={"property": prop}) + \
                    soup.find_all("meta", attrs={"name": prop}):
            if meta.get("content"):
                add(meta["content"], None, kind, "", False)

    return records


# --------------------------------------------------------------------------
# Image asset inspection
# --------------------------------------------------------------------------

class AssetInspector:
    """Fetch just enough of each image to learn size, type and dimensions."""

    def __init__(self, session, timeout=15, enabled=True, verbose=True):
        self.session = session
        self.timeout = timeout
        self.enabled = enabled
        self.verbose = verbose
        self.cache = {}

    def inspect(self, url):
        if url in self.cache:
            return self.cache[url]
        info = {"status": "", "bytes": None, "content_type": "", "width": None, "height": None}
        if not self.enabled:
            self.cache[url] = info
            return info
        try:
            response = self.session.get(url, timeout=self.timeout, stream=True,
                                        headers={"Accept": "image/*,*/*"})
            info["status"] = str(response.status_code)
            info["content_type"] = response.headers.get("Content-Type", "").split(";")[0]
            length = response.headers.get("Content-Length")
            chunk = b""
            if response.ok:
                for piece in response.iter_content(65536):
                    chunk += piece
                    if len(chunk) >= 65536:
                        break
            info["bytes"] = int(length) if length and length.isdigit() else (
                len(chunk) if response.ok else None)
            if Image is not None and chunk:
                try:
                    with Image.open(io.BytesIO(chunk)) as img:
                        info["width"], info["height"] = img.size
                except Exception:
                    pass
            response.close()
        except requests.RequestException as exc:
            info["status"] = "ERROR"
            info["error"] = str(exc)[:120]
        self.cache[url] = info
        return info


# --------------------------------------------------------------------------
# Alt text + keyword generation
# --------------------------------------------------------------------------

def clean_page_subject(page_meta):
    """The page's own topic, stripped of brand/boilerplate."""
    subject = page_meta.get("h1") or page_meta.get("title") or ""
    brand = page_meta.get("brand", "")
    subject = re.split(r"\s+[|–—·-]\s+", subject)[0]
    if brand:
        subject = re.sub(re.escape(brand), "", subject, flags=re.I)
    subject = re.sub(r"\b(buy|shop|online|official|store|sale|home|page)\b", "", subject, flags=re.I)
    return norm_space(subject)


def filename_descriptor(image_url):
    """Turn the filename into words, dropping size/hash noise."""
    name = os.path.splitext(url_filename(image_url))[0]
    name = re.sub(r"[-_]?\d{2,4}x\d{2,4}", "", name)          # 800x600 crops
    name = re.sub(r"[-_]?(scaled|min|large|small|thumb|thumbnail|cropped|resized|copy|final|v\d+)\b",
                  "", name, flags=re.I)
    name = re.sub(r"[-_]?[a-f0-9]{8,}$", "", name, flags=re.I)  # trailing hashes
    name = re.sub(r"[-_]?\d{3,}$", "", name)                     # trailing ids
    return norm_space(" ".join(tokenize(name)))


def suggest_keywords(record, page_meta):
    """Rank candidate keywords: page subject first, then context, then filename."""
    context = record.get("context", {})
    weighted = Counter()

    def feed(text, weight):
        for token in tokenize(text):
            weighted[token] += weight

    feed(context.get("card_title", ""), 5)
    feed(context.get("caption", ""), 5)
    feed(clean_page_subject(page_meta), 4)
    feed(context.get("heading", ""), 3)
    feed(context.get("link_title", "") or context.get("link_text", ""), 3)
    feed(filename_descriptor(record["image_url"]), 2)
    feed(page_meta.get("category", ""), 2)
    feed(record.get("title_attr", ""), 2)

    primary_source = (context.get("card_title") or context.get("caption")
                      or clean_page_subject(page_meta) or context.get("heading")
                      or filename_descriptor(record["image_url"]))
    primary = norm_space(primary_source)[:70]

    secondary = [word for word, _ in weighted.most_common(8)
                 if word not in tokenize(primary)][:5]
    category_terms = [t for t in tokenize(page_meta.get("category", "")) if t not in tokenize(primary)]
    return {
        "primary": primary.lower(),
        "secondary": ", ".join(dict.fromkeys(secondary + category_terms[:2])),
    }


def suggest_alt_text(record, page_meta, keywords):
    """Build a descriptive, human-first alt string under the length limit.

    Returns (alt, note, overrides) where overrides may replace the keyword and
    filename suggestions for images that are not page content (logos, icons).
    """
    context = record.get("context", {})
    classes = (context.get("css_class") or "").lower()
    filename = url_filename(record["image_url"]).lower()
    brand = page_meta.get("brand", "")
    kind = record["source_kind"]

    # Logos, icons and spacers follow their own rules and must not inherit the
    # page's commercial keyword - they are chrome, not content.
    if "logo" in filename or "logo" in classes:
        return (f"{brand} logo", "Logo - name the brand, no keyword stuffing",
                {"primary": f"{brand} logo".lower(), "secondary": "brand",
                 "slug": f"{brand}-logo"})
    if any(term in filename or term in classes
           for term in ("icon", "sprite", "spacer", "divider", "pixel")):
        return ("", 'Decorative - use alt="" so screen readers skip it',
                {"primary": "(decorative - no keyword)", "secondary": "",
                 "slug": os.path.splitext(filename)[0]})
    if "payment" in filename or ("card" in filename and "credit" in filename):
        return ("Accepted payment methods", "Functional icon - describe the function",
                {"primary": "accepted payment methods", "secondary": "",
                 "slug": "accepted-payment-methods"})

    subject = (context.get("card_title") or context.get("caption")
               or clean_page_subject(page_meta) or context.get("heading") or "")
    descriptor = filename_descriptor(record["image_url"])

    # Colour/variant hints in the filename make gallery images unique.
    variant = [w for w in tokenize(descriptor) if w in COLOR_WORDS]
    detail_words = [w for w in tokenize(descriptor)
                    if w not in tokenize(subject) and w not in COLOR_WORDS][:3]

    parts = []
    if subject:
        parts.append(norm_space(subject))
    elif descriptor:
        parts.append(title_case(descriptor))
    else:
        parts.append(page_meta.get("category", "Page") + " image")

    if variant:
        parts.append("in " + " ".join(dict.fromkeys(variant)))
    if detail_words and len(" ".join(parts)) < 70:
        parts.append("- " + " ".join(detail_words))

    alt = norm_space(" ".join(parts))

    if kind in ("og:image", "twitter:image"):
        alt = norm_space(f"{subject or page_meta.get('title', '')}")[:MAX_ALT_LENGTH]
        return alt, "Social share image - mirror the page subject", {}

    # Gallery images repeat the product; the position keeps each one unique.
    if record["position"] > 1 and context.get("card_title") is None and subject:
        if re.search(r"(gallery|slide|thumb|carousel|swiper)", classes + filename):
            alt = f"{alt} - view {record['position']}"

    for prefix in ALT_FILLER_PREFIXES:
        alt = re.sub(rf"^{re.escape(prefix)}\s+", "", alt, flags=re.I)

    alt = title_case(alt) if alt.islower() else alt
    if len(alt) > MAX_ALT_LENGTH:
        alt = alt[:MAX_ALT_LENGTH].rsplit(" ", 1)[0].rstrip(" -,")

    note = "Describes the subject; primary keyword included naturally"
    if not subject:
        note = "Derived from filename - verify against the actual image"
    return alt, note, {}


def suggest_filename(record, keywords, slug_override=None):
    """SEO-friendly filename: lowercase, hyphenated, descriptive, no stopwords."""
    base = slug_override or keywords["primary"] or filename_descriptor(record["image_url"])
    words = tokenize(base) or re.findall(r"[a-z0-9]+", base.lower())
    slug = "-".join(words[:6]) or "image"
    ext = url_extension(record["image_url"]) or ".jpg"
    if ext not in NEXT_GEN_FORMATS and ext not in VECTOR_FORMATS:
        ext = ".webp"
    return slug + ext


# --------------------------------------------------------------------------
# Issue detection
# --------------------------------------------------------------------------

def audit_image(record, asset, page_meta):
    """Score one image against every check; returns issues + severity."""
    issues = []
    alt = record["alt"]
    alt_present = record["alt_present"]
    filename = url_filename(record["image_url"])
    stem = os.path.splitext(filename)[0].lower()
    ext = url_extension(record["image_url"])
    kind = record["source_kind"]

    # --- Alt text -------------------------------------------------------
    if kind == "css-background":
        issues.append(("Medium", "CSS background image",
                       "Content images set via CSS background are not indexed as images and have no alt. "
                       "If it is content, move it to an <img> tag; if decorative, this is fine."))
        alt_status = "N/A (CSS background)"
    elif kind in ("og:image", "twitter:image"):
        alt_status = "N/A (social meta)"
    elif not alt_present:
        issues.append(("Critical", "Missing alt attribute",
                       "No alt attribute at all. Fails WCAG 1.1.1 and loses the strongest image ranking signal."))
        alt_status = "MISSING"
    elif alt == "":
        issues.append(("Low", "Empty alt (decorative)",
                       'alt="" is correct only for purely decorative images. Confirm this image carries no meaning.'))
        alt_status = "EMPTY"
    else:
        alt_status = "OK"
        lowered = alt.lower()
        if any(re.match(pattern, lowered) for pattern in GENERIC_ALT_PATTERNS):
            issues.append(("High", "Generic / non-descriptive alt",
                           f'Alt text "{alt}" describes nothing. Replace with a specific description.'))
            alt_status = "GENERIC"
        if len(alt) > MAX_ALT_LENGTH:
            issues.append(("Medium", "Alt text too long",
                           f"{len(alt)} characters. Screen readers commonly cut off past {MAX_ALT_LENGTH}."))
        if len(alt.split()) < IDEAL_ALT_MIN_WORDS and alt_status == "OK":
            issues.append(("Medium", "Alt text too short",
                           f'Only {len(alt.split())} word(s). Aim for a short descriptive phrase.'))
        for prefix in ALT_FILLER_PREFIXES:
            if lowered.startswith(prefix):
                issues.append(("Low", "Redundant alt prefix",
                               f'Drop "{prefix}" - assistive tech already announces it as an image.'))
                break
        words = [w for w in re.findall(r"[a-z']+", lowered) if w not in STOPWORDS]
        if words:
            most_common, count = Counter(words).most_common(1)[0]
            if count >= 3 or (len(words) >= 6 and count / len(words) > 0.4):
                issues.append(("High", "Keyword stuffing in alt",
                               f'"{most_common}" repeats {count}x. Reads as spam to Google.'))
        if alt.count(",") >= 4 and len(alt.split()) > 8:
            issues.append(("Medium", "Alt reads as a keyword list",
                           "Comma-separated keyword strings are a manual-action risk. Write a sentence."))
        if re.search(r"\.(jpe?g|png|gif|webp|svg)\b", lowered):
            issues.append(("Medium", "Filename used as alt",
                           "The alt attribute contains a filename instead of a description."))

    # --- Filename -------------------------------------------------------
    for pattern, label in BAD_FILENAME_PATTERNS:
        if re.match(pattern, stem):
            issues.append(("Medium", "Non-descriptive filename",
                           f"{filename} is a {label}. Rename to hyphenated keywords before upload."))
            break
    else:
        if "_" in stem:
            issues.append(("Low", "Underscores in filename",
                           "Google reads hyphens as word separators, underscores as joiners. Use hyphens."))
        if re.search(r"[A-Z]", os.path.splitext(filename)[0]):
            issues.append(("Low", "Uppercase in filename",
                           "Mixed case risks duplicate URLs on case-sensitive servers. Use lowercase."))
        if "%20" in record["image_url"] or " " in unquote(filename):
            issues.append(("Low", "Spaces in filename",
                           "Spaces become %20 and make the URL harder to read and share."))

    # --- Format & weight ------------------------------------------------
    if ext and ext not in NEXT_GEN_FORMATS and ext not in VECTOR_FORMATS:
        if ext == ".gif":
            issues.append(("Medium", "GIF format",
                           "GIFs are heavy. Use WebP for stills or MP4/WebM for animation."))
        else:
            issues.append(("Medium", "Not a next-gen format",
                           f"{ext} adds weight. Serve WebP or AVIF with a {ext} fallback (~25-35% smaller)."))

    size = asset.get("bytes")
    if size:
        if size >= SIZE_CRITICAL_BYTES:
            issues.append(("Critical", "Very large file",
                           f"{human_bytes(size)}. Compress and resize - this will damage LCP."))
        elif size >= SIZE_HIGH_BYTES:
            issues.append(("High", "Large file",
                           f"{human_bytes(size)}. Target under 150 KB for most page images."))
        elif size >= SIZE_WARN_BYTES:
            issues.append(("Low", "Slightly heavy file",
                           f"{human_bytes(size)}. Room to compress further."))

    status = asset.get("status", "")
    if status and status not in ("", "200") and not status.startswith("2"):
        severity = "Critical" if status in ("404", "410", "ERROR") else "High"
        issues.append((severity, f"Image returns {status}",
                       "Broken image URL - fix the reference or restore the asset."))

    # --- Layout & loading ----------------------------------------------
    if kind in ("img", "picture-source", "noscript-img"):
        if not record["width_attr"] or not record["height_attr"]:
            issues.append(("Medium", "Missing width/height attributes",
                           "Without intrinsic dimensions the browser cannot reserve space - causes CLS."))
        if record["position"] <= ABOVE_FOLD_COUNT:
            if record["loading"] == "lazy":
                issues.append(("High", "Above-fold image is lazy-loaded",
                               "Lazy-loading the LCP image delays it measurably. Use loading=\"eager\"."))
            if not record["fetchpriority"] and record["position"] == 1:
                issues.append(("Low", "No fetchpriority on likely LCP image",
                               'Add fetchpriority="high" to the main hero/product image.'))
        else:
            if record["loading"] != "lazy" and not record["is_lazy_attr"]:
                issues.append(("Medium", "Below-fold image not lazy-loaded",
                               'Add loading="lazy" so it does not compete with above-fold content.'))
        if not record["has_srcset"]:
            issues.append(("Low", "No responsive srcset",
                           "Serve a srcset/sizes set so mobile does not download the desktop asset."))

    width, height = asset.get("width"), asset.get("height")
    if width and record["width_attr"].isdigit():
        declared = int(record["width_attr"])
        if declared and width > declared * 2:
            issues.append(("High", "Oversized for display",
                           f"Intrinsic {width}px vs displayed {declared}px. Serve a resized file."))
    if width and height and width * height > 4_000_000 and ext not in VECTOR_FORMATS:
        issues.append(("Medium", "Very large dimensions",
                       f"{width}x{height}px. Resize to the largest size actually rendered."))

    if record["image_url"].startswith("http://"):
        issues.append(("High", "Insecure image URL",
                       "http:// image on an https page triggers mixed-content warnings."))

    if not issues:
        severity = "Pass"
    else:
        severity = min((s for s, _, _ in issues), key=lambda s: SEVERITY_ORDER[s])

    return {
        "alt_status": alt_status,
        "issues": issues,
        "severity": severity,
        "issue_count": len(issues),
    }


# --------------------------------------------------------------------------
# XLSX report
# --------------------------------------------------------------------------

HEADER_FILL = PatternFill("solid", fgColor="1F3864")
HEADER_FONT = Font(color="FFFFFF", bold=True, size=11)
TITLE_FONT = Font(bold=True, size=14, color="1F3864")
SEVERITY_FILLS = {
    "Critical": PatternFill("solid", fgColor="F8CBCB"),
    "High": PatternFill("solid", fgColor="FBD9B5"),
    "Medium": PatternFill("solid", fgColor="FDF2C0"),
    "Low": PatternFill("solid", fgColor="DDEBF7"),
    "Pass": PatternFill("solid", fgColor="D8EFD8"),
}
THIN_BORDER = Border(*[Side(style="thin", color="D0D0D0")] * 4)


def style_sheet(worksheet, headers, widths, freeze="A2", table_name=None):
    for index, (header, width) in enumerate(zip(headers, widths), start=1):
        cell = worksheet.cell(row=1, column=index, value=header)
        cell.fill = HEADER_FILL
        cell.font = HEADER_FONT
        cell.alignment = Alignment(vertical="center", horizontal="left", wrap_text=True)
        worksheet.column_dimensions[get_column_letter(index)].width = width
    worksheet.row_dimensions[1].height = 30
    worksheet.freeze_panes = freeze
    if worksheet.max_row > 1:
        worksheet.auto_filter.ref = (
            f"A1:{get_column_letter(len(headers))}{worksheet.max_row}")


def write_rows(worksheet, rows, wrap_columns=(), severity_column=None):
    for row in rows:
        worksheet.append(row)
    for row_cells in worksheet.iter_rows(min_row=2, max_row=worksheet.max_row):
        for cell in row_cells:
            cell.border = THIN_BORDER
            cell.alignment = Alignment(vertical="top",
                                       wrap_text=cell.column in wrap_columns)
        if severity_column:
            severity = row_cells[severity_column - 1].value
            if severity in SEVERITY_FILLS:
                row_cells[severity_column - 1].fill = SEVERITY_FILLS[severity]


def build_workbook(results, pages, site_url, out_path, crawl_stats):
    workbook = Workbook()

    # ---- Sheet 1: Executive summary ------------------------------------
    summary = workbook.active
    summary.title = "1. Summary"
    total = len(results)
    missing_alt = [r for r in results if r["audit"]["alt_status"] == "MISSING"]
    empty_alt = [r for r in results if r["audit"]["alt_status"] == "EMPTY"]
    generic_alt = [r for r in results if r["audit"]["alt_status"] == "GENERIC"]
    good_alt = [r for r in results if r["audit"]["alt_status"] == "OK"]
    severity_counts = Counter(r["audit"]["severity"] for r in results)
    issue_counts = Counter(name for r in results for _, name, _ in r["audit"]["issues"])
    unique_images = len({r["image_url"] for r in results})
    total_bytes = sum(r["asset"].get("bytes") or 0 for r in results)

    summary["A1"] = "Image SEO Audit"
    summary["A1"].font = Font(bold=True, size=18, color="1F3864")
    summary["A2"] = site_url
    summary["A2"].font = Font(size=12, color="555555")
    summary["A3"] = f"Generated {datetime.now():%d %b %Y %H:%M}"
    summary["A3"].font = Font(size=10, color="888888")

    overview = [
        ("", ""),
        ("SCOPE", ""),
        ("Pages crawled", len(pages)),
        ("Image references found", total),
        ("Unique image files", unique_images),
        ("Total image weight (sampled)", human_bytes(total_bytes)),
        ("Pages that failed to load", crawl_stats.get("failed", 0)),
        ("", ""),
        ("ALT TEXT HEALTH", ""),
        ("Missing alt attribute (Critical)", len(missing_alt)),
        ("Empty alt - verify decorative", len(empty_alt)),
        ("Generic / useless alt (High)", len(generic_alt)),
        ("Descriptive alt present", len(good_alt)),
        ("Alt coverage", f"{(len(good_alt) / total * 100 if total else 0):.1f}%"),
        ("", ""),
        ("SEVERITY BREAKDOWN", ""),
        ("Critical", severity_counts.get("Critical", 0)),
        ("High", severity_counts.get("High", 0)),
        ("Medium", severity_counts.get("Medium", 0)),
        ("Low", severity_counts.get("Low", 0)),
        ("No issues found", severity_counts.get("Pass", 0)),
        ("", ""),
        ("TOP ISSUES BY VOLUME", ""),
    ]
    overview += [(name, count) for name, count in issue_counts.most_common(12)]

    for offset, (label, value) in enumerate(overview, start=5):
        label_cell = summary.cell(row=offset, column=1, value=label)
        summary.cell(row=offset, column=2, value=value)
        if label and value == "":
            label_cell.font = Font(bold=True, size=11, color="FFFFFF")
            label_cell.fill = HEADER_FILL
            summary.cell(row=offset, column=2).fill = HEADER_FILL
        elif label in ("Missing alt attribute (Critical)", "Critical") and value:
            label_cell.font = Font(bold=True, color="C00000")
            summary.cell(row=offset, column=2).font = Font(bold=True, color="C00000")
    summary.column_dimensions["A"].width = 42
    summary.column_dimensions["B"].width = 24

    # ---- Sheet 2: Full inventory ---------------------------------------
    inventory = workbook.create_sheet("2. All Images")
    headers = [
        "Page URL", "Page Title", "Page Type", "Category", "Image URL", "Filename",
        "Format", "Source", "Position", "Alt Status", "Current Alt Text", "Alt Length",
        "Title Attr", "Width Attr", "Height Attr", "Intrinsic W", "Intrinsic H",
        "File Size", "HTTP", "Loading", "Responsive srcset", "Severity",
        "Issue Count", "Issues Found",
    ]
    widths = [42, 30, 12, 24, 52, 28, 9, 12, 9, 13, 40, 10, 22, 11, 11, 11, 11,
              11, 8, 10, 16, 11, 8, 60]
    rows = []
    for record in sorted(results, key=lambda r: (SEVERITY_ORDER[r["audit"]["severity"]],
                                                 r["page_url"], r["position"])):
        audit = record["audit"]
        asset = record["asset"]
        rows.append([
            record["page_url"], record["page_title"], record["page_type"],
            record["category"], record["image_url"], url_filename(record["image_url"]),
            url_extension(record["image_url"]).lstrip("."), record["source_kind"],
            record["position"], audit["alt_status"], record["alt"],
            len(record["alt"]) if record["alt"] else 0, record["title_attr"],
            record["width_attr"], record["height_attr"],
            asset.get("width") or "", asset.get("height") or "",
            human_bytes(asset.get("bytes")), asset.get("status", ""),
            record["loading"] or ("js-lazy" if record["is_lazy_attr"] else "eager (default)"),
            "Yes" if record["has_srcset"] else "No",
            audit["severity"], audit["issue_count"],
            " | ".join(f"[{s}] {n}" for s, n, _ in audit["issues"]),
        ])
    style_sheet(inventory, headers, widths)
    write_rows(inventory, rows, wrap_columns=(11, 24), severity_column=22)

    # ---- Sheet 3: Missing / weak alt + suggestions ---------------------
    alt_sheet = workbook.create_sheet("3. Alt Tag Fix List")
    alt_headers = [
        "Priority", "Page URL", "Category", "Image URL", "Filename",
        "Alt Status", "Current Alt", "SUGGESTED ALT TEXT", "Alt Length",
        "Primary Keyword", "Supporting Keywords", "Ready-to-paste <img> tag",
        "Why this alt", "Suggested Filename",
    ]
    alt_widths = [10, 40, 22, 50, 26, 12, 30, 55, 10, 26, 30, 78, 40, 30]
    alt_rows = []
    priority_pool = [r for r in results
                     if r["audit"]["alt_status"] in ("MISSING", "GENERIC", "EMPTY")
                     or any(n.startswith("Alt") or "alt" in n.lower()
                            for _, n, _ in r["audit"]["issues"])]
    for record in sorted(priority_pool,
                         key=lambda r: (SEVERITY_ORDER[r["audit"]["severity"]], r["page_url"])):
        alt_rows.append([
            record["audit"]["severity"], record["page_url"], record["category"],
            record["image_url"], url_filename(record["image_url"]),
            record["audit"]["alt_status"], record["alt"],
            record["suggested_alt"], len(record["suggested_alt"]),
            record["keywords"]["primary"], record["keywords"]["secondary"],
            record["img_tag"], record["alt_note"], record["suggested_filename"],
        ])
    style_sheet(alt_sheet, alt_headers, alt_widths)
    write_rows(alt_sheet, alt_rows, wrap_columns=(7, 8, 12, 13), severity_column=1)

    # ---- Sheet 4: Every suggested alt tag ------------------------------
    all_alt = workbook.create_sheet("4. All Alt Tags")
    all_headers = ["Page URL", "Category", "Image URL", "Current Alt",
                   "SUGGESTED ALT TEXT", "Primary Keyword", "Supporting Keywords",
                   "Ready-to-paste <img> tag"]
    all_widths = [42, 24, 52, 34, 55, 26, 30, 80]
    all_rows = [[
        r["page_url"], r["category"], r["image_url"], r["alt"], r["suggested_alt"],
        r["keywords"]["primary"], r["keywords"]["secondary"], r["img_tag"],
    ] for r in sorted(results, key=lambda r: (r["page_url"], r["position"]))]
    style_sheet(all_alt, all_headers, all_widths)
    write_rows(all_alt, all_rows, wrap_columns=(4, 5, 8))

    # ---- Sheet 5: Technical issues -------------------------------------
    tech = workbook.create_sheet("5. Technical Issues")
    tech_headers = ["Severity", "Issue", "Page URL", "Category", "Image URL",
                    "Detail / Recommended Fix"]
    tech_widths = [11, 34, 42, 22, 52, 78]
    tech_rows = []
    for record in results:
        for severity, name, detail in record["audit"]["issues"]:
            if name in ("Missing alt attribute", "Empty alt (decorative)",
                        "Generic / non-descriptive alt"):
                continue  # already covered on the alt sheets
            tech_rows.append([severity, name, record["page_url"], record["category"],
                              record["image_url"], detail])
    tech_rows.sort(key=lambda r: (SEVERITY_ORDER[r[0]], r[1]))
    style_sheet(tech, tech_headers, tech_widths)
    write_rows(tech, tech_rows, wrap_columns=(6,), severity_column=1)

    # ---- Sheet 6: Page rollup ------------------------------------------
    page_sheet = workbook.create_sheet("6. By Page")
    page_headers = ["Page URL", "Page Title", "Page Type", "Category", "Images",
                    "Missing Alt", "Empty Alt", "Generic Alt", "Good Alt",
                    "Critical", "High", "Total Issues", "Page Image Weight"]
    page_widths = [46, 34, 13, 24, 9, 12, 11, 12, 10, 10, 8, 12, 18]
    by_page = defaultdict(list)
    for record in results:
        by_page[record["page_url"]].append(record)
    page_rows = []
    for url, records in by_page.items():
        severities = Counter(r["audit"]["severity"] for r in records)
        statuses = Counter(r["audit"]["alt_status"] for r in records)
        page_rows.append([
            url, records[0]["page_title"], records[0]["page_type"], records[0]["category"],
            len(records), statuses.get("MISSING", 0), statuses.get("EMPTY", 0),
            statuses.get("GENERIC", 0), statuses.get("OK", 0),
            severities.get("Critical", 0), severities.get("High", 0),
            sum(r["audit"]["issue_count"] for r in records),
            human_bytes(sum(r["asset"].get("bytes") or 0 for r in records)),
        ])
    page_rows.sort(key=lambda r: (-r[9], -r[5], -r[11]))
    style_sheet(page_sheet, page_headers, page_widths)
    write_rows(page_sheet, page_rows)

    # ---- Sheet 7: Category rollup --------------------------------------
    cat_sheet = workbook.create_sheet("7. By Category")
    cat_headers = ["Category", "Pages", "Images", "Missing Alt", "Generic Alt",
                   "Good Alt", "Alt Coverage %", "Critical", "High", "Total Issues"]
    cat_widths = [34, 9, 9, 12, 12, 10, 15, 10, 8, 12]
    by_category = defaultdict(list)
    for record in results:
        by_category[record["category"] or "(uncategorised)"].append(record)
    cat_rows = []
    for category, records in by_category.items():
        statuses = Counter(r["audit"]["alt_status"] for r in records)
        severities = Counter(r["audit"]["severity"] for r in records)
        good = statuses.get("OK", 0)
        cat_rows.append([
            category, len({r["page_url"] for r in records}), len(records),
            statuses.get("MISSING", 0), statuses.get("GENERIC", 0), good,
            round(good / len(records) * 100, 1),
            severities.get("Critical", 0), severities.get("High", 0),
            sum(r["audit"]["issue_count"] for r in records),
        ])
    cat_rows.sort(key=lambda r: (-r[3], -r[9]))
    style_sheet(cat_sheet, cat_headers, cat_widths)
    write_rows(cat_sheet, cat_rows)

    # ---- Sheet 8: Best-practice checklist ------------------------------
    guide = workbook.create_sheet("8. Best Practices")
    guide_headers = ["Area", "Rule", "Why it matters", "How to implement"]
    guide_widths = [20, 46, 52, 62]
    guide_rows = [
        ["Alt text", "Every content image needs a descriptive alt attribute",
         "WCAG 1.1.1 requirement and the primary relevance signal for Google Images",
         'Describe what the image shows in plain language: alt="Black lace bralette on model, front view"'],
        ["Alt text", "Keep alt under 125 characters",
         "Screen readers commonly truncate longer strings",
         "One clear phrase; move extra detail to a caption or nearby copy"],
        ["Alt text", 'Use alt="" for decorative images',
         "Stops assistive tech announcing meaningless spacers and icons",
         'Spacers, dividers, background flourishes: alt="" (present but empty)'],
        ["Alt text", "Never start with 'image of' / 'photo of'",
         "Screen readers already announce the element as an image",
         "Start with the subject itself"],
        ["Alt text", "No keyword stuffing",
         "Repeated keywords in alt is a documented spam signal and a manual-action risk",
         "Include the target keyword once, naturally, only when it genuinely describes the image"],
        ["Alt text", "Every alt on a page should be unique",
         "Duplicate alt across a gallery gives Google nothing to differentiate",
         "Add the variant or view: 'front view', 'in black', 'detail of lace trim'"],
        ["Filenames", "Descriptive, lowercase, hyphen-separated",
         "The filename is a confirmed ranking input for image search",
         "black-lace-bralette-front.webp — not IMG_4821.JPG"],
        ["Format", "Serve WebP or AVIF",
         "25-50% smaller than JPEG/PNG at the same quality; directly improves LCP",
         "<picture> with WebP/AVIF <source> and a JPEG fallback <img>"],
        ["Weight", "Keep most page images under 150 KB",
         "Image weight is usually the single biggest LCP contributor",
         "Compress at quality 75-85 and resize to the largest rendered size"],
        ["Layout", "Always set width and height attributes",
         "Lets the browser reserve space, preventing Cumulative Layout Shift",
         '<img src="..." width="800" height="1200" alt="...">'],
        ["Loading", "Lazy-load below-fold images only",
         "Lazy-loading the LCP image measurably delays it",
         'loading="lazy" below the fold; loading="eager" fetchpriority="high" on the hero'],
        ["Responsive", "Provide srcset and sizes",
         "Stops mobile downloading desktop-sized files",
         'srcset="img-400.webp 400w, img-800.webp 800w" sizes="(max-width:600px) 100vw, 50vw"'],
        ["Indexing", "Include images in an image sitemap",
         "Helps Google discover images loaded by JavaScript",
         "<image:image><image:loc> entries in the XML sitemap"],
        ["Indexing", "Avoid CSS backgrounds for content images",
         "Background images are not eligible for Google Images",
         "Use <img> for anything that carries meaning"],
        ["Structured data", "Add ImageObject / Product image schema",
         "Enables rich results and image licence metadata",
         "JSON-LD ImageObject with contentUrl, license, creditText"],
        ["Context", "Surround images with relevant text",
         "Google uses captions, headings and nearby copy to understand images",
         "Add a <figcaption> and keep the image near the copy it illustrates"],
        ["Delivery", "Serve from a CDN with long cache headers",
         "Cuts latency and repeat-visit bandwidth",
         "Cache-Control: public, max-age=31536000, immutable on hashed filenames"],
    ]
    style_sheet(guide, guide_headers, guide_widths)
    write_rows(guide, guide_rows, wrap_columns=(2, 3, 4))

    out_path.parent.mkdir(parents=True, exist_ok=True)
    workbook.save(out_path)
    return out_path


# --------------------------------------------------------------------------
# Orchestration
# --------------------------------------------------------------------------

def run_audit(site_url, max_pages, out_path, html_dir=None, inspect_assets=True,
              delay=0.4, verbose=True):
    crawler = Crawler(site_url, max_pages=max_pages, delay=delay, verbose=verbose)

    if html_dir:
        pages = load_local_pages(html_dir)
        print(f"Loaded {len(pages)} local HTML files from {html_dir}")
    else:
        pages = crawler.crawl()

    if not pages:
        raise SystemExit(
            "No pages could be fetched. If the host is unreachable from here, save the "
            "pages locally and re-run with --html-dir."
        )

    inspector = AssetInspector(crawler.session, enabled=inspect_assets, verbose=verbose)
    results = []

    print(f"\nAnalysing images across {len(pages)} pages...")
    for page_url, html in pages.items():
        soup, page_meta = extract_page_meta(page_url, html)
        for record in extract_images(page_url, soup, page_meta):
            asset = inspector.inspect(record["image_url"])
            record["asset"] = asset
            record["audit"] = audit_image(record, asset, page_meta)
            keywords = suggest_keywords(record, page_meta)
            suggested_alt, note, overrides = suggest_alt_text(record, page_meta, keywords)
            # Chrome images (logos, icons) carry their own keyword, not the page's.
            if overrides.get("primary"):
                keywords = {"primary": overrides["primary"],
                            "secondary": overrides.get("secondary", "")}
            record["keywords"] = keywords
            record["suggested_alt"] = suggested_alt
            record["alt_note"] = note
            record["suggested_filename"] = suggest_filename(
                record, keywords, slug_override=overrides.get("slug"))
            width = record["width_attr"] or (asset.get("width") or "")
            height = record["height_attr"] or (asset.get("height") or "")
            loading = "eager" if record["position"] <= ABOVE_FOLD_COUNT else "lazy"
            priority = ' fetchpriority="high"' if record["position"] == 1 else ""
            record["img_tag"] = (
                f'<img src="{record["image_url"]}" alt="{suggested_alt}"'
                + (f' width="{width}"' if width else "")
                + (f' height="{height}"' if height else "")
                + f' loading="{loading}" decoding="async"{priority}>'
            )
            results.append(record)

    if not results:
        raise SystemExit("No images found on the crawled pages.")

    crawl_stats = {"failed": len(crawler.failed)}
    path = build_workbook(results, pages, site_url, Path(out_path), crawl_stats)

    missing = sum(1 for r in results if r["audit"]["alt_status"] == "MISSING")
    generic = sum(1 for r in results if r["audit"]["alt_status"] == "GENERIC")
    print(f"\nDone. {len(results)} images across {len(pages)} pages.")
    print(f"  Missing alt: {missing}")
    print(f"  Generic alt: {generic}")
    print(f"  Report: {path}")
    return path


def main():
    parser = argparse.ArgumentParser(description="Audit a site's images for SEO and accessibility.")
    parser.add_argument("url", help="Site URL to audit, e.g. https://example.com/")
    parser.add_argument("--max-pages", type=int, default=200, help="Page crawl limit (default 200)")
    parser.add_argument("--out", default=None, help="Output .xlsx path")
    parser.add_argument("--html-dir", default=None,
                        help="Audit saved .html files from this directory instead of crawling")
    parser.add_argument("--no-asset-check", action="store_true",
                        help="Skip fetching images (faster, no file size or dimension data)")
    parser.add_argument("--delay", type=float, default=0.4, help="Seconds between page requests")
    parser.add_argument("--quiet", action="store_true")
    args = parser.parse_args()

    if args.out:
        out_path = args.out
    else:
        host = urlparse(args.url).netloc.replace("www.", "") or "site"
        out_path = f"reports/{host}-image-seo-audit-{datetime.now():%Y%m%d-%H%M}.xlsx"

    run_audit(args.url, args.max_pages, out_path, html_dir=args.html_dir,
              inspect_assets=not args.no_asset_check, delay=args.delay,
              verbose=not args.quiet)


if __name__ == "__main__":
    main()
