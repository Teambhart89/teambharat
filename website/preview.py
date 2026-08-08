#!/usr/bin/env python3
"""
Bundles the built site into one self contained HTML file for review.

Every page becomes a section in a single scrollable document, the stylesheet is
inlined, and internal links are rewritten to in page anchors so navigation still
works. This is for previewing only. Upload dist/ to your host, not this file.

    python3 build.py && python3 preview.py
"""

from __future__ import annotations

import re
from pathlib import Path

ROOT = Path(__file__).resolve().parent
DIST = ROOT / "dist"
OUT = ROOT / "preview.html"


def anchor(slug: str) -> str:
    return "page-home" if slug in ("", "/") else "page-" + slug.strip("/").replace("/", "-")


def main() -> None:
    css = (DIST / "assets" / "style.css").read_text(encoding="utf-8")

    pages = []
    for path in sorted(DIST.rglob("index.html")):
        rel = str(path.parent.relative_to(DIST)).replace("\\", "/")
        slug = "" if rel == "." else rel
        html = path.read_text(encoding="utf-8")
        title = re.search(r"<title>(.*?)</title>", html, re.S).group(1)
        body = re.search(r"<body>(.*?)</body>", html, re.S).group(1)
        body = re.sub(r'<a class="skip".*?</a>', "", body, flags=re.S)
        pages.append((slug, title, body))

    order = {slug: i for i, (slug, _, _) in enumerate(pages)}
    # Home first, then the services hub, then everything else in build order.
    pages.sort(key=lambda p: (p[0] != "", p[0] != "services", order[p[0]]))

    def rewrite(body: str) -> str:
        def repl(match: re.Match) -> str:
            href = match.group(1)
            if href.startswith("/assets/"):
                return match.group(0)
            return f'href="#{anchor(href)}"'
        return re.sub(r'href="(/[^"#?]*)"', repl, body)

    sections = []
    for slug, title, body in pages:
        sections.append(
            f'<div class="preview-page" id="{anchor(slug)}">\n'
            f'  <div class="preview-label">/{slug + "/" if slug else ""}'
            f'<span>{title}</span></div>\n'
            f"{rewrite(body)}\n"
            "</div>"
        )

    doc = f"""<title>Online Plants Cart, full site preview</title>
<style>
{css}

/* Preview chrome only. None of this ships with the site. */
.preview-page {{ border-top: 6px solid var(--brand-deep); }}
.preview-page:first-of-type {{ border-top: 0; }}
.preview-page .site-header {{ position: static; }}
.preview-label {{
  background: var(--ink); color: #ffffff;
  font-family: var(--body); font-size: 0.75rem; font-weight: 700;
  letter-spacing: 0.08em; text-transform: uppercase;
  padding: 0.55rem 1.35rem;
  display: flex; flex-wrap: wrap; gap: 0.35rem 1rem; justify-content: space-between;
}}
.preview-label span {{ font-weight: 400; letter-spacing: 0.02em; text-transform: none; opacity: 0.72; }}
.preview-note {{
  background: var(--accent); color: #2a2103;
  font-family: var(--body); font-size: 0.9rem;
  padding: 0.9rem 1.35rem; text-align: center;
}}
</style>
<div class="preview-note">
  Preview build. All {len(pages)} pages stacked into one file, navigation rewritten to in page links.
  The real site is the <strong>dist</strong> folder.
</div>
{chr(10).join(sections)}
"""
    OUT.write_text(doc, encoding="utf-8")
    print(f"Wrote {OUT} with {len(pages)} pages")


if __name__ == "__main__":
    main()
