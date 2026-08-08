#!/usr/bin/env python3
"""
Static site builder for Online Plants Cart.

Reads:
    _src/site.json       name, phone, address, service area, brand wide settings
    _src/pages/*.json    one file per page, read in filename order
    _src/template.html   the shell every page is poured into
    _src/body/*.html     the main content of each page
    assets/              stylesheet and any images

Writes:
    dist/                the finished site, ready to upload

Run with:
    python3 build.py

No third party packages required.
"""

from __future__ import annotations

import json
import html
import shutil
from datetime import date
from pathlib import Path

ROOT = Path(__file__).resolve().parent
SRC = ROOT / "_src"
DIST = ROOT / "dist"


# --------------------------------------------------------------- helpers ---

def esc(text: str) -> str:
    """Escape a string for use inside an HTML attribute."""
    return html.escape(text, quote=True)


def url_for(slug: str, base: str) -> str:
    """Absolute canonical URL for a page slug. Empty slug is the home page."""
    return f"{base}/" if not slug else f"{base}/{slug}/"


def path_for(slug: str) -> str:
    """Root relative path used for internal links."""
    return "/" if not slug else f"/{slug}/"


# ------------------------------------------------------------- rendering ---

def render_nav(pages: list[dict], current: str) -> str:
    items = []
    for page in pages:
        if not page.get("in_nav"):
            continue
        aria = ' aria-current="page"' if page["slug"] == current else ""
        items.append(
            f'      <a href="{path_for(page["slug"])}"{aria}>{esc(page["nav_label"])}</a>'
        )
    return "\n".join(items)


def render_footer_services(pages: list[dict]) -> str:
    items = []
    for page in pages:
        if page.get("type") != "service":
            continue
        items.append(
            f'          <li><a href="{path_for(page["slug"])}">{esc(page["nav_label"])}</a></li>'
        )
    return "\n".join(items)


def render_breadcrumb(page: dict) -> str:
    trail = page.get("breadcrumb") or []
    if not trail:
        return ""
    parts = ['<nav class="breadcrumb" aria-label="Breadcrumb">', "  <ol>"]
    for label, slug in trail:
        parts.append(f'    <li><a href="{path_for(slug)}">{esc(label)}</a></li>')
    parts.append(f'    <li aria-current="page">{esc(page["nav_label"])}</li>')
    parts.append("  </ol>")
    parts.append("</nav>")
    return "\n".join(parts)


def render_actions(site: dict, page: dict | None = None, style: str = "hero") -> str:
    wa = site["whatsapp"]
    tel = site["phone"]
    primary = (page or {}).get("cta_label", "Get a free quote")
    if style == "hero":
        return (
            '<div class="actions">\n'
            f'  <a class="btn btn-primary" href="/contact/">{esc(primary)}</a>\n'
            f'  <a class="btn btn-secondary" href="tel:{tel}">Call {esc(site["phone_display"])}</a>\n'
            "</div>"
        )
    return (
        '<div class="actions">\n'
        f'  <a class="btn btn-primary" href="tel:{tel}">Call {esc(site["phone_display"])}</a>\n'
        f'  <a class="btn btn-secondary" href="https://wa.me/{wa}">Message on WhatsApp</a>\n'
        "</div>"
    )


def render_leaf_field() -> str:
    """Decorative foliage behind the hero, drawn entirely in CSS."""
    return (
        '<div class="leaf-field" aria-hidden="true">'
        + "<i></i>" * 5
        + "</div>"
    )


def render_hero_panel(page: dict, site: dict) -> str:
    facts = page.get("facts")
    if not facts:
        return ""
    rows = "\n".join(
        f"        <li><b>{esc(k)}</b><span>{v}</span></li>" for k, v in facts.items()
    )
    default = "Service at a glance" if page.get("type") == "service" else "At a glance"
    title = page.get("panel_title", default)
    return (
        '    <aside class="hero-panel">\n'
        f"      <h2>{esc(title)}</h2>\n"
        '      <ul class="panel-list">\n'
        f"{rows}\n"
        "      </ul>\n"
        f'      <a class="panel-phone" href="tel:{site["phone"]}">{esc(site["phone_display"])}</a>\n'
        f'      <p style="margin:0.4rem 0 0;font-size:0.8125rem">{esc(site["hours"])}</p>\n'
        "    </aside>"
    )


def render_hero_trust(page: dict) -> str:
    items = page.get("trust")
    if not items:
        return ""
    spans = "\n".join(f"        <span>{esc(item)}</span>" for item in items)
    return f'      <div class="hero-trust">\n{spans}\n      </div>'


def render_faq(faqs: list[dict]) -> str:
    if not faqs:
        return ""
    blocks = [
        '<section id="faq" aria-labelledby="faq-heading">',
        '  <h2 id="faq-heading">Frequently asked questions</h2>',
        '  <div class="faq">',
    ]
    for item in faqs:
        answer_paras = "\n".join(
            f"      <p>{para}</p>" for para in item["a"]
        )
        blocks.append("    <details>")
        blocks.append(f'      <summary>{item["q"]}</summary>')
        blocks.append('      <div class="answer-body">')
        blocks.append(answer_paras)
        blocks.append("      </div>")
        blocks.append("    </details>")
    blocks.append("  </div>")
    blocks.append("</section>")
    return "\n".join(blocks)


def render_rail(page: dict, pages: list[dict], site: dict) -> str:
    """The facts now live in the hero panel, so the rail carries navigation
    and contact only. Repeating them in both places would be noise."""
    cards = []

    related = page.get("related") or []
    if related:
        by_slug = {p["slug"]: p for p in pages}
        links = "\n".join(
            f'      <li><a href="{path_for(s)}">{esc(by_slug[s]["nav_label"])}</a></li>'
            for s in related
            if s in by_slug
        )
        cards.append(
            "  <div class=\"rail-card\">\n"
            "    <h2>Related services</h2>\n"
            "    <ul class=\"rail-links\">\n"
            f"{links}\n"
            "    </ul>\n"
            "  </div>"
        )

    cards.append(
        "  <div class=\"rail-card\">\n"
        "    <h2>Talk to us</h2>\n"
        f'    <p>Tell us the site, the quantity and the timeline. Most quotes go out the same working day.</p>\n'
        f'    <p><a href="tel:{site["phone"]}"><strong>{esc(site["phone_display"])}</strong></a><br>\n'
        f'    <a href="https://wa.me/{site["whatsapp"]}">WhatsApp</a> &middot; '
        f'<a href="mailto:{site["email"]}">Email</a></p>\n'
        f'    <p class="updated">{esc(site["hours"])}</p>\n'
        "  </div>"
    )

    return "\n".join(cards)


def render_cta(site: dict, page: dict) -> str:
    heading = page.get("cta_heading", "Ready to green your space?")
    text = page.get(
        "cta_text",
        "Share your requirement and we will come back with a clear, itemised quotation.",
    )
    return (
        '<section class="tight">\n'
        '  <div class="wrap">\n'
        '    <div class="cta-band">\n'
        f"      <h2>{heading}</h2>\n"
        f"      <p>{text}</p>\n"
        f"      {render_actions(site, page, 'cta')}\n"
        "    </div>\n"
        "  </div>\n"
        "</section>"
    )


def render_main(page: dict, body: str, pages: list[dict], site: dict) -> str:
    ptype = page.get("type", "page")
    if ptype == "home":
        hero_class = "hero hero-home"
    elif ptype == "service":
        hero_class = "hero hero-service"
    else:
        hero_class = "hero"

    narrow = " wrap-narrow" if ptype == "service" else ""
    panel = render_hero_panel(page, site)
    inner_class = f"wrap{narrow} hero-inner has-panel" if panel else f"wrap{narrow} hero-inner"

    copy_bits = []
    crumb = render_breadcrumb(page)
    if crumb:
        copy_bits.append("      " + crumb.replace("\n", "\n      "))
    if page.get("eyebrow"):
        copy_bits.append(f'      <p class="eyebrow">{esc(page["eyebrow"])}</p>')
    copy_bits.append(f'      <h1>{page["h1"]}</h1>')
    if page.get("lede"):
        copy_bits.append(f'      <p class="lede">{page["lede"]}</p>')
    copy_bits.append("      " + render_actions(site, page).replace("\n", "\n      "))
    trust = render_hero_trust(page)
    if trust:
        copy_bits.append(trust)

    hero_bits = [
        f'<div class="{hero_class}">',
        "  " + render_leaf_field(),
        f'  <div class="{inner_class}">',
        '    <div class="hero-copy">',
        "\n".join(copy_bits),
        "    </div>",
    ]
    if panel:
        hero_bits.append(panel)
    hero_bits.append("  </div>")
    hero_bits.append("</div>")
    hero = "\n".join(hero_bits)

    answer = ""
    if page.get("answer"):
        answer = (
            '<div class="answer">\n'
            '  <p class="eyebrow">In short</p>\n'
            f'  <p>{page["answer"]}</p>\n'
            "</div>"
        )

    faq = render_faq(page.get("faqs") or [])

    if ptype == "service":
        inner = "\n\n".join(bit for bit in (answer, body, faq) if bit)
        main = (
            f"{hero}\n\n"
            '<section class="tight">\n'
            '  <div class="wrap wrap-narrow service-layout">\n'
            '    <div class="prose">\n'
            f"{inner}\n"
            "    </div>\n"
            '    <aside class="rail" aria-label="Service summary">\n'
            f"{render_rail(page, pages, site)}\n"
            "    </aside>\n"
            "  </div>\n"
            "</section>\n\n"
            f"{render_cta(site, page)}"
        )
        return main

    # Home and standalone pages carry their own section markup inside the body.
    tail = ""
    if faq:
        tail = (
            '<section class="tight">\n'
            '  <div class="wrap">\n'
            '    <div class="prose">\n'
            f"{faq}\n"
            "    </div>\n"
            "  </div>\n"
            "</section>"
        )
    return "\n\n".join(bit for bit in (hero, body, tail, render_cta(site, page)) if bit)


# ---------------------------------------------------------------- schema ---

def build_jsonld(page: dict, site: dict, pages: list[dict]) -> str:
    base = site["base"]
    canonical = url_for(page["slug"], base)

    org = {
        "@type": ["LocalBusiness", "GardenStore"],
        "@id": f"{base}/#organization",
        "name": site["name"],
        "url": f"{base}/",
        "telephone": site["phone"],
        "email": site["email"],
        "priceRange": site["price_range"],
        "address": {
            "@type": "PostalAddress",
            "streetAddress": site["street"],
            "addressLocality": site["locality"],
            "addressRegion": site["region"],
            "postalCode": site["postal_code"],
            "addressCountry": "IN",
        },
        "areaServed": [
            {"@type": "City", "name": city} for city in site["cities"]
        ],
        "openingHoursSpecification": [
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                    "Monday", "Tuesday", "Wednesday",
                    "Thursday", "Friday", "Saturday",
                ],
                "opens": site["opens"],
                "closes": site["closes"],
            }
        ],
    }

    website = {
        "@type": "WebSite",
        "@id": f"{base}/#website",
        "url": f"{base}/",
        "name": site["name"],
        "publisher": {"@id": f"{base}/#organization"},
        "inLanguage": "en-IN",
    }

    webpage = {
        "@type": "WebPage",
        "@id": f"{canonical}#webpage",
        "url": canonical,
        "name": page["title"],
        "description": page["description"],
        "isPartOf": {"@id": f"{base}/#website"},
        "about": {"@id": f"{base}/#organization"},
        "inLanguage": "en-IN",
        "dateModified": site["updated"],
    }

    graph = [org, website, webpage]

    trail = page.get("breadcrumb") or []
    if trail:
        items = []
        for i, (label, slug) in enumerate(trail, start=1):
            items.append({
                "@type": "ListItem",
                "position": i,
                "name": label,
                "item": url_for(slug, base),
            })
        items.append({
            "@type": "ListItem",
            "position": len(items) + 1,
            "name": page["nav_label"],
        })
        graph.append({
            "@type": "BreadcrumbList",
            "@id": f"{canonical}#breadcrumb",
            "itemListElement": items,
        })

    if page.get("type") == "service":
        graph.append({
            "@type": "Service",
            "@id": f"{canonical}#service",
            "name": page["service_name"],
            "serviceType": page["service_type"],
            "description": page["description"],
            "url": canonical,
            "provider": {"@id": f"{base}/#organization"},
            "areaServed": [
                {"@type": "City", "name": city} for city in site["cities"]
            ],
            "audience": {
                "@type": "Audience",
                "audienceType": page.get("audience", "Businesses and homeowners"),
            },
        })

    faqs = page.get("faqs") or []
    if faqs:
        graph.append({
            "@type": "FAQPage",
            "@id": f"{canonical}#faq",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": strip_tags(item["q"]),
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": strip_tags(" ".join(item["a"])),
                    },
                }
                for item in faqs
            ],
        })

    return json.dumps(
        {"@context": "https://schema.org", "@graph": graph},
        indent=2,
        ensure_ascii=False,
    )


def strip_tags(text: str) -> str:
    """Remove the light inline markup used in copy so schema stays plain text."""
    out = []
    depth = 0
    for char in text:
        if char == "<":
            depth += 1
        elif char == ">":
            depth = max(0, depth - 1)
        elif depth == 0:
            out.append(char)
    return html.unescape("".join(out)).strip()


# ----------------------------------------------------------------- build ---

def build() -> None:
    site = json.loads((SRC / "site.json").read_text(encoding="utf-8"))
    pages = [
        json.loads(f.read_text(encoding="utf-8"))
        for f in sorted((SRC / "pages").glob("*.json"))
    ]
    template = (SRC / "template.html").read_text(encoding="utf-8")

    if DIST.exists():
        shutil.rmtree(DIST)
    DIST.mkdir(parents=True)

    shutil.copytree(ROOT / "assets", DIST / "assets")

    nav_cache = {}
    footer_services = render_footer_services(pages)

    for page in pages:
        body_file = SRC / "body" / f'{page["file"]}.html'
        body = body_file.read_text(encoding="utf-8").strip()

        slug = page["slug"]
        if slug not in nav_cache:
            nav_cache[slug] = render_nav(pages, slug)

        rendered = template
        replacements = {
            "{{TITLE}}": esc(page["title"]),
            "{{DESCRIPTION}}": esc(page["description"]),
            "{{OG_TITLE}}": esc(page.get("og_title", page["title"])),
            "{{CANONICAL}}": url_for(slug, site["base"]),
            "{{OG_TYPE}}": "website" if page.get("type") == "home" else "article",
            "{{SITE_NAME}}": esc(site["name"]),
            "{{SITE_TAGLINE}}": esc(site["tagline"]),
            "{{NAV}}": nav_cache[slug],
            "{{MAIN}}": render_main(page, body, pages, site),
            "{{FOOTER_SERVICES}}": footer_services,
            "{{PHONE}}": site["phone"],
            "{{PHONE_DISPLAY}}": esc(site["phone_display"]),
            "{{WHATSAPP}}": site["whatsapp"],
            "{{EMAIL}}": site["email"],
            "{{HOURS}}": esc(site["hours"]),
            "{{YEAR}}": str(date.today().year),
            "{{JSONLD}}": build_jsonld(page, site, pages),
        }
        for token, value in replacements.items():
            rendered = rendered.replace(token, value)

        out_dir = DIST if not slug else DIST / slug
        out_dir.mkdir(parents=True, exist_ok=True)
        (out_dir / "index.html").write_text(rendered, encoding="utf-8")
        print(f"  built  {path_for(slug)}")

    write_sitemap(pages, site)
    write_robots(site)
    print(f"\nDone. {len(pages)} pages in {DIST}")


def write_sitemap(pages: list[dict], site: dict) -> None:
    lines = [
        '<?xml version="1.0" encoding="UTF-8"?>',
        '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
    ]
    for page in pages:
        lines.append("  <url>")
        lines.append(f'    <loc>{url_for(page["slug"], site["base"])}</loc>')
        lines.append(f'    <lastmod>{site["updated"]}</lastmod>')
        lines.append(f'    <changefreq>{page.get("changefreq", "monthly")}</changefreq>')
        lines.append(f'    <priority>{page.get("priority", "0.8")}</priority>')
        lines.append("  </url>")
    lines.append("</urlset>")
    (DIST / "sitemap.xml").write_text("\n".join(lines) + "\n", encoding="utf-8")
    print("  built  /sitemap.xml")


def write_robots(site: dict) -> None:
    content = (
        "User-agent: *\n"
        "Allow: /\n\n"
        "# Assistants that read pages to answer questions are welcome here.\n"
        "User-agent: GPTBot\n"
        "Allow: /\n\n"
        "User-agent: ClaudeBot\n"
        "Allow: /\n\n"
        "User-agent: PerplexityBot\n"
        "Allow: /\n\n"
        "User-agent: Google-Extended\n"
        "Allow: /\n\n"
        f"Sitemap: {site['base']}/sitemap.xml\n"
    )
    (DIST / "robots.txt").write_text(content, encoding="utf-8")
    print("  built  /robots.txt")


if __name__ == "__main__":
    build()
