"""Image SEO audit driven by the Shopify Admin API.

Consumes product/collection JSON pulled from the Shopify Admin GraphQL API and
produces the same style of image-SEO report as image_seo_audit.py, but sourced
from the store's own data rather than a crawl. This is the authoritative view:
alt text lives on the media record in Shopify, so auditing it here catches gaps
that a themed storefront may paper over.

Usage:
    python shopify_image_audit.py --input-dir ./shopify_json --out reports/audit.xlsx

Expects one or more .json files each shaped like the Admin API response:
    {"data": {"products": {"nodes": [...]}}}
"""

import argparse
import json
import os
import re
from collections import Counter, defaultdict
from datetime import datetime
from pathlib import Path

from openpyxl import Workbook
from openpyxl.styles import Alignment, Font

from image_seo_audit import (
    HEADER_FILL,
    MAX_ALT_LENGTH,
    SEVERITY_ORDER,
    audit_image,
    human_bytes,
    norm_space,
    style_sheet,
    title_case,
    tokenize,
    url_extension,
    url_filename,
    write_rows,
)

# Colour codes used in this store's filenames, e.g. PD1802_Blk-1.webp.
# Only confident mappings belong here - a wrong colour in alt text is worse than
# no colour, so unmapped codes are dropped rather than guessed.
COLOUR_CODES = {
    "blk": "black", "black": "black",
    "gry": "grey", "grey": "grey", "gray": "grey",
    "dgry": "dark grey", "lgry": "light grey",
    "skn": "skin", "skin": "skin",
    "grn": "green", "lgrn": "light green",
    "wht": "white", "white": "white",
    "blu": "blue", "lblu": "light blue", "dblu": "dark blue",
    "nblu": "navy blue", "sblu": "sky blue",
    "pnk": "pink", "pink": "pink",
    "pch": "peach", "prl": "pearl",
    "bwn": "brown", "ylw": "yellow", "red": "red",
    "nud": "nude", "mrn": "maroon", "org": "orange",
    "rst": "rust", "crl": "coral", "muv": "mauve",
    "crm": "cream", "rose": "rose", "waxberry": "waxberry",
    "hna": "henna", "ivry": "ivory", "beige": "beige",
    "lav": "lavender", "mint": "mint", "teal": "teal",
    "purple": "purple", "olive": "olive", "navy": "navy",
    # full-word variants that appear alongside the abbreviations
    "maroon": "maroon", "nude": "nude", "blue": "blue", "green": "green",
    "peach": "peach", "rust": "rust", "coral": "coral", "brown": "brown",
    "khaki": "khaki", "yellow": "yellow", "orange": "orange", "cream": "cream",
    "grey_": "grey",
    # shade qualifiers
    "pk": "pink", "lpnk": "light pink", "dpnk": "dark pink", "bpnk": "pink",
    "olv": "olive", "gld": "gold", "prpl": "purple", "mov": "mauve",
    "win": "wine", "owht": "off white", "sblue": "sky blue",
    "navyblue": "navy blue", "rani": "rani pink", "redbean": "red bean",
    # broader family when the exact shade is not certain but the family is
    "agrn": "green", "pgrn": "green", "ablu": "blue",
}

# Filename tokens that name the camera angle. Real angles beat a generic
# "view 2", so these are used verbatim when present.
VIEW_WORDS = {
    "front": "front view", "back": "back view", "side": "side view",
    "left": "left side view", "right": "right side view",
    "top": "top view", "detail": "detail view", "closeup": "close-up",
    "close": "close-up", "flat": "flat lay", "flatlay": "flat lay",
    "model": "on model",
}

# Brand and boilerplate noise stripped from product titles before use as alt.
TITLE_NOISE = re.compile(
    r"\b(amour\s*sec?rt?|amoursecret|women'?s?|womens|ladies|girls)\b",
    re.I,
)
STYLE_CODE = re.compile(r"\b([A-Z]{1,3}\d{3,5}|[A-Z]\d{3,5})\b")


def clean_product_title(title):
    """Trim a keyword-stuffed product title down to a usable subject phrase."""
    text = norm_space(title or "")
    # Keep only the leading clause - these titles append long use-case lists.
    text = re.split(r"\s+[-–—]\s+|,\s", text)[0]
    text = TITLE_NOISE.sub(" ", text)
    text = STYLE_CODE.sub("", text)
    text = re.sub(r"\s*[/\\]\s*", "/", text)
    text = norm_space(re.sub(r"\s{2,}", " ", text)).strip(" -–—/&")
    if len(text) > 90:
        text = text[:90].rsplit(" ", 1)[0].rstrip(" -,/&")
    return text


def style_code(title, filename):
    """Recover the SKU-ish style code from the title or the filename."""
    match = STYLE_CODE.search(title or "")
    if match:
        return match.group(1).upper()
    stem = os.path.splitext(url_filename(filename))[0]
    match = re.match(r"([A-Za-z]{1,3}\d{3,5})", stem)
    return match.group(1).upper() if match else ""


def parse_filename(image_url):
    """Pull the colour and view index out of a product image filename."""
    stem = os.path.splitext(url_filename(image_url))[0]
    stem = re.sub(r"_\d+x\d+", "", stem)                     # _1024x1024
    stem = re.sub(r"_[0-9a-f]{8}-[0-9a-f-]{20,}", "", stem)  # trailing uuid
    parts = re.split(r"[_\-]", stem)

    colour, view, angle = "", None, ""
    for part in parts[1:]:
        lowered = part.lower()
        if not colour and lowered in COLOUR_CODES:
            colour = COLOUR_CODES[lowered]
        elif not angle and lowered in VIEW_WORDS:
            angle = VIEW_WORDS[lowered]
        elif view is None and lowered.isdigit() and len(lowered) <= 2:
            view = int(lowered)
    return colour, view, angle, stem


def build_alt(subject, colour, view, angle, position):
    """Compose alt text: subject, colour when known, and a uniqueness marker.

    Uses a real camera angle when the filename names one. Otherwise falls back
    to a neutral 'view N' rather than guessing 'front view' - a confident wrong
    description is worse than an accurate vague one.
    """
    parts = [subject] if subject else []
    if colour:
        parts.append(f"in {colour}")
    alt = norm_space(" ".join(parts))

    if angle:
        alt = f"{alt} - {angle}"
    else:
        index = view if view is not None else position
        if index and index > 1:
            alt = f"{alt} - view {index}"

    if len(alt) > MAX_ALT_LENGTH:
        alt = alt[:MAX_ALT_LENGTH].rsplit(" ", 1)[0].rstrip(" -,")
    return alt


def load_products(input_dir):
    """Read every Admin API page in the directory, de-duplicating by product id."""
    products = {}
    for path in sorted(Path(input_dir).glob("*.json")):
        with open(path, encoding="utf-8") as handle:
            try:
                payload = json.load(handle)
            except json.JSONDecodeError:
                continue
        if not isinstance(payload, dict):
            continue  # e.g. the collections list living in the same directory
        nodes = (payload.get("data", {}).get("products", {}) or {}).get("nodes")
        if not nodes:
            continue
        for node in nodes:
            products[node["id"]] = node
    return list(products.values())


def build_records(products, store_domain, brand):
    """Flatten products into one audit record per image."""
    records = []
    for product in products:
        title = product.get("title") or ""
        handle = product.get("handle") or ""
        status = product.get("status") or ""
        collections = [c["title"] for c in
                       (product.get("collections", {}) or {}).get("nodes", [])]
        category = collections[0] if collections else (product.get("productType") or "")
        page_url = product.get("onlineStoreUrl") or f"https://{store_domain}/products/{handle}"
        subject = clean_product_title(title)

        page_meta = {
            "url": page_url, "title": title, "h1": title,
            "meta_description": (product.get("seo") or {}).get("description") or "",
            "brand": brand, "category": category, "page_type": "Product",
        }

        media = (product.get("media", {}) or {}).get("nodes", []) or []
        for position, item in enumerate(media, start=1):
            image = item.get("image") or {}
            image_url = image.get("url")
            if not image_url:
                continue

            alt_raw = item.get("alt")
            alt = norm_space(alt_raw or "")
            # In Shopify an empty alt means "never set". These are product
            # photos, never decorative, so empty is a genuine miss.
            alt_present = bool(alt)

            colour, view, angle, _ = parse_filename(image_url)
            code = style_code(title, image_url)

            record = {
                "page_url": page_url,
                "page_title": title,
                "page_h1": title,
                "page_type": "Product",
                "category": category,
                "brand": brand,
                "image_url": image_url,
                "source_kind": "shopify-media",
                "position": position,
                "alt_present": alt_present,
                "alt": alt,
                "title_attr": "",
                "width_attr": "", "height_attr": "",
                "loading": "", "decoding": "", "fetchpriority": "", "sizes": "",
                "has_srcset": False, "is_lazy_attr": False,
                "context": {"card_title": subject, "heading": subject},
                # Shopify reports exact dimensions; the CDN gives no size here.
                "asset": {"status": "", "bytes": None, "content_type": "",
                          "width": image.get("width"), "height": image.get("height")},
                # Shopify-specific extras
                "product_handle": handle,
                "product_status": status,
                "collections": collections,
                "media_id": item.get("id", ""),
                "style_code": code,
                "colour": colour,
                "view_index": view,
                "angle": angle,
                "subject": subject,
            }

            record["audit"] = audit_image(record, record["asset"], page_meta)
            suggested = build_alt(subject, colour, view, angle, position)
            record["suggested_alt"] = suggested
            record["keywords"] = {
                "primary": subject.lower(),
                "secondary": ", ".join(dict.fromkeys(
                    [c.lower() for c in collections[:3]]
                    + ([colour] if colour else []))),
            }
            record["alt_note"] = (
                "Colour from filename code" if colour
                else "Colour not derivable from filename - confirm against the image")
            slug_words = tokenize(subject)[:6] + ([colour] if colour else [])
            slug = "-".join(slug_words) or "product-image"
            if code:
                slug = f"{slug}-{code.lower()}"
            if view:
                slug = f"{slug}-{view}"
            record["suggested_filename"] = slug + (url_extension(image_url) or ".webp")
            records.append(record)
    return records


def build_shopify_workbook(records, products, collections_without_images,
                           store_name, store_domain, out_path):
    workbook = Workbook()
    total = len(records)
    missing = [r for r in records if r["audit"]["alt_status"] == "MISSING"]
    have_alt = [r for r in records if r["audit"]["alt_status"] == "OK"]
    by_status = Counter(r["product_status"] for r in records)
    live = [r for r in records if r["product_status"] == "ACTIVE"]
    issue_counts = Counter(name for r in records for _, name, _ in r["audit"]["issues"])

    # ---- Summary --------------------------------------------------------
    summary = workbook.active
    summary.title = "1. Summary"
    summary["A1"] = f"Image SEO Audit - {store_name}"
    summary["A1"].font = Font(bold=True, size=18, color="1F3864")
    summary["A2"] = f"{store_domain} - sourced from the Shopify Admin API"
    summary["A2"].font = Font(size=12, color="555555")
    summary["A3"] = f"Generated {datetime.now():%d %b %Y %H:%M}"
    summary["A3"].font = Font(size=10, color="888888")

    coverage = (len(have_alt) / total * 100) if total else 0
    live_missing = sum(1 for r in live if r["audit"]["alt_status"] == "MISSING")
    rows = [
        ("", ""),
        ("SCOPE", ""),
        ("Products audited", len(products)),
        ("Product images audited", total),
        ("Collections audited", len(collections_without_images)),
        ("", ""),
        ("ALT TEXT - THE HEADLINE", ""),
        ("Images with NO alt text", len(missing)),
        ("Images with alt text", len(have_alt)),
        ("Alt text coverage", f"{coverage:.2f}%"),
        ("Images missing alt on LIVE products", live_missing),
        ("", ""),
        ("PRODUCT STATUS (images by status)", ""),
        ("ACTIVE (live, indexable)", by_status.get("ACTIVE", 0)),
        ("DRAFT (not published)", by_status.get("DRAFT", 0)),
        ("UNLISTED", by_status.get("UNLISTED", 0)),
        ("", ""),
        ("COLLECTIONS", ""),
        ("Collections with no image set", len(collections_without_images)),
        ("", ""),
        ("ALL ISSUES BY VOLUME", ""),
    ]
    rows += [(name, count) for name, count in issue_counts.most_common(15)]

    for offset, (label, value) in enumerate(rows, start=5):
        cell = summary.cell(row=offset, column=1, value=label)
        summary.cell(row=offset, column=2, value=value)
        if label and value == "":
            cell.font = Font(bold=True, size=11, color="FFFFFF")
            cell.fill = HEADER_FILL
            summary.cell(row=offset, column=2).fill = HEADER_FILL
        elif label.startswith("Images with NO") or label.startswith("Images missing alt on LIVE"):
            cell.font = Font(bold=True, color="C00000")
            summary.cell(row=offset, column=2).font = Font(bold=True, color="C00000")
    summary.column_dimensions["A"].width = 46
    summary.column_dimensions["B"].width = 26

    # ---- Full inventory with suggested alt ------------------------------
    sheet = workbook.create_sheet("2. All Images + Alt Tags")
    headers = ["Priority", "Product", "Product URL", "Status", "Category",
               "All Collections", "Style Code", "Image URL", "Filename",
               "Colour", "View", "Angle", "Width", "Height", "Format",
               "Current Alt", "SUGGESTED ALT TEXT", "Alt Len",
               "Primary Keyword", "Supporting Keywords",
               "Suggested Filename", "Issues"]
    widths = [10, 46, 46, 9, 22, 34, 11, 60, 34, 12, 7, 14, 8, 8, 8,
              26, 58, 8, 40, 34, 40, 46]
    data = []
    for record in sorted(records, key=lambda r: (
            SEVERITY_ORDER[r["audit"]["severity"]],
            r["product_status"] != "ACTIVE", r["page_title"], r["position"])):
        asset = record["asset"]
        data.append([
            record["audit"]["severity"], record["page_title"], record["page_url"],
            record["product_status"], record["category"],
            ", ".join(record["collections"]), record["style_code"],
            record["image_url"], url_filename(record["image_url"]),
            record["colour"], record["view_index"] or record["position"],
            record["angle"], asset.get("width") or "", asset.get("height") or "",
            url_extension(record["image_url"]).lstrip("."),
            record["alt"], record["suggested_alt"], len(record["suggested_alt"]),
            record["keywords"]["primary"], record["keywords"]["secondary"],
            record["suggested_filename"],
            " | ".join(f"[{s}] {n}" for s, n, _ in record["audit"]["issues"]),
        ])
    style_sheet(sheet, headers, widths)
    write_rows(sheet, data, wrap_columns=(16, 17, 22), severity_column=1)

    # ---- Live products first - the fix list that moves rankings ---------
    priority = workbook.create_sheet("3. Fix First (Live)")
    priority_headers = ["Product", "Product URL", "Category", "Image URL",
                        "SUGGESTED ALT TEXT", "Primary Keyword", "Colour", "Angle"]
    priority_widths = [46, 48, 24, 62, 58, 40, 12, 14]
    priority_rows = [[
        r["page_title"], r["page_url"], r["category"], r["image_url"],
        r["suggested_alt"], r["keywords"]["primary"], r["colour"], r["angle"],
    ] for r in sorted(live, key=lambda r: (r["page_title"], r["position"]))
        if r["audit"]["alt_status"] == "MISSING"]
    style_sheet(priority, priority_headers, priority_widths)
    write_rows(priority, priority_rows, wrap_columns=(5,))

    # ---- Per-product rollup ---------------------------------------------
    product_sheet = workbook.create_sheet("4. By Product")
    product_headers = ["Product", "Product URL", "Status", "Category", "Style Code",
                       "Images", "Missing Alt", "Has Alt", "Alt Coverage %"]
    product_widths = [50, 48, 9, 24, 11, 9, 12, 10, 15]
    grouped = defaultdict(list)
    for record in records:
        grouped[record["page_url"]].append(record)
    product_rows = []
    for url, group in grouped.items():
        statuses = Counter(r["audit"]["alt_status"] for r in group)
        missing_count = statuses.get("MISSING", 0)
        product_rows.append([
            group[0]["page_title"], url, group[0]["product_status"],
            group[0]["category"], group[0]["style_code"], len(group),
            missing_count, statuses.get("OK", 0),
            round(statuses.get("OK", 0) / len(group) * 100, 1),
        ])
    product_rows.sort(key=lambda r: (r[2] != "ACTIVE", -r[6]))
    style_sheet(product_sheet, product_headers, product_widths)
    write_rows(product_sheet, product_rows)

    # ---- Per-collection rollup ------------------------------------------
    collection_sheet = workbook.create_sheet("5. By Collection")
    collection_headers = ["Collection", "Products in collection", "Images",
                          "Missing Alt", "Has Alt", "Alt Coverage %",
                          "Collection Image Set?"]
    collection_widths = [40, 22, 10, 12, 10, 15, 22]
    by_collection = defaultdict(list)
    for record in records:
        for name in (record["collections"] or [record["category"] or "(none)"]):
            by_collection[name].append(record)
    collection_rows = []
    for name, group in by_collection.items():
        statuses = Counter(r["audit"]["alt_status"] for r in group)
        collection_rows.append([
            name, len({r["page_url"] for r in group}), len(group),
            statuses.get("MISSING", 0), statuses.get("OK", 0),
            round(statuses.get("OK", 0) / len(group) * 100, 1),
            "No" if name in collections_without_images else "Yes",
        ])
    collection_rows.sort(key=lambda r: -r[3])
    style_sheet(collection_sheet, collection_headers, collection_widths)
    write_rows(collection_sheet, collection_rows)

    # ---- Collections missing a banner image -----------------------------
    empty_sheet = workbook.create_sheet("6. Collections No Image")
    empty_headers = ["Collection", "Handle", "Products", "Collection URL",
                     "Suggested Image Alt Text"]
    empty_widths = [40, 32, 11, 52, 58]
    empty_rows = [[
        name, handle, count, f"https://{store_domain}/collections/{handle}",
        f"{name} collection at {store_name}",
    ] for name, handle, count in sorted(
        collections_without_images.values(), key=lambda c: -c[2])]
    style_sheet(empty_sheet, empty_headers, empty_widths)
    write_rows(empty_sheet, empty_rows, wrap_columns=(5,))

    # ---- How to apply ----------------------------------------------------
    guide = workbook.create_sheet("7. How To Apply")
    guide_headers = ["Step", "Where", "What to do"]
    guide_widths = [8, 40, 96]
    guide_rows = [
        ["1", "Shopify admin > Products > [product] > Media",
         "Click an image, then 'Add alt text'. Paste the SUGGESTED ALT TEXT column. "
         "Alt text lives on the media record, so it applies everywhere the image is used."],
        ["2", "Sheet '3. Fix First (Live)'",
         "Work this sheet first. These are images on ACTIVE products, the only ones "
         "search engines can currently index."],
        ["3", "Verify the colour",
         "Colour is decoded from the filename code (Blk = black, Skn = skin). Rows where "
         "the code was unrecognised have an empty Colour cell - check those against the image."],
        ["4", "Confirm the view",
         "Suggested alt says 'view 2', not 'front view' - the angle cannot be known from the "
         "data. Replace with the real angle where you can see the image."],
        ["5", "Bulk editing",
         "For large batches use Shopify's bulk editor or the Admin API "
         "fileUpdate mutation with the media id from the audit."],
        ["6", "Collections",
         "Sheet 6 lists every collection with no image. Adding a banner image with alt text "
         "gives category pages an image to rank and improves the visual browse experience."],
        ["7", "Draft products",
         "DRAFT images are not indexable today. Fix them before publishing, not after, so "
         "the pages launch complete."],
        ["8", "Filenames",
         "Suggested Filename applies to future uploads. Renaming existing files changes their "
         "CDN URL and drops accumulated image-search equity, so only rename on re-upload."],
    ]
    style_sheet(guide, guide_headers, guide_widths)
    write_rows(guide, guide_rows, wrap_columns=(3,))

    Path(out_path).parent.mkdir(parents=True, exist_ok=True)
    workbook.save(out_path)
    return out_path


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--input-dir", required=True,
                        help="Directory of Shopify Admin API JSON pages")
    parser.add_argument("--collections-file", default=None,
                        help="JSON file listing collections (name, handle, count, hasImage)")
    parser.add_argument("--store-name", default="Store")
    parser.add_argument("--store-domain", default="example.com")
    parser.add_argument("--out", default=None)
    args = parser.parse_args()

    products = load_products(args.input_dir)
    if not products:
        raise SystemExit(f"No product data found in {args.input_dir}")

    collections_without_images = {}
    if args.collections_file and os.path.exists(args.collections_file):
        with open(args.collections_file, encoding="utf-8") as handle:
            for entry in json.load(handle):
                if not entry.get("hasImage"):
                    collections_without_images[entry["title"]] = (
                        entry["title"], entry["handle"], entry.get("products", 0))

    records = build_records(products, args.store_domain, args.store_name)
    out_path = args.out or (
        f"reports/{args.store_domain}-image-seo-audit-{datetime.now():%Y%m%d-%H%M}.xlsx")

    build_shopify_workbook(records, products, collections_without_images,
                           args.store_name, args.store_domain, out_path)

    missing = sum(1 for r in records if r["audit"]["alt_status"] == "MISSING")
    print(f"Products: {len(products)}")
    print(f"Images:   {len(records)}")
    print(f"Missing alt: {missing} ({missing / len(records) * 100:.2f}%)")
    print(f"Report: {out_path}")


if __name__ == "__main__":
    main()
