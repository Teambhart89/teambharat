#!/usr/bin/env python3
"""
Quality checks for the built site in dist/.

Checks:
    1. Em dashes and en dashes do not appear in visible copy
    2. Exactly one H1 per page, and heading levels never skip a step
    3. Every JSON-LD block parses as valid JSON
    4. Every internal link points at a page that exists
    5. Title and meta description lengths sit in the useful range
    6. No single word or phrase is repeated often enough to read as stuffing
    7. Word count per page

Run with:
    python3 check.py
"""

from __future__ import annotations

import json
import re
import sys
from collections import Counter
from pathlib import Path

ROOT = Path(__file__).resolve().parent
DIST = ROOT / "dist"

problems: list[str] = []
notes: list[str] = []

STOPWORDS = {
    "the", "and", "a", "an", "to", "of", "in", "is", "it", "for", "on", "that",
    "with", "as", "are", "be", "or", "at", "you", "we", "your", "our", "this",
    "not", "but", "from", "by", "will", "can", "if", "so", "do", "have", "has",
    "they", "them", "what", "which", "than", "then", "there", "their", "was",
    "one", "more", "most", "how", "who", "into", "out", "up", "does", "no",
    "us", "all", "also", "any", "some", "when", "where", "while", "would",
    "about", "after", "before", "over", "under", "through", "much", "many",
    "own", "same", "other", "those", "these", "its", "it.", "far", "very",
    "usually", "often", "rather", "well", "just", "even", "still", "because",
    "get", "got", "need", "needs", "make", "makes", "made", "way", "thing",
    "things", "every", "each", "both", "few", "less", "least", "first",
    "second", "third", "last", "next", "why", "here", "s", "t", "re",
}


def visible_text(html: str) -> str:
    """Strip script, style, comments and tags, leaving reader visible copy."""
    html = re.sub(r"<!--.*?-->", " ", html, flags=re.S)
    html = re.sub(r"<script\b.*?</script>", " ", html, flags=re.S | re.I)
    html = re.sub(r"<style\b.*?</style>", " ", html, flags=re.S | re.I)
    html = re.sub(r"<[^>]+>", " ", html)
    return re.sub(r"\s+", " ", html).strip()


def check_dashes(name: str, html: str) -> None:
    text = visible_text(html)
    for char, label in (("—", "em dash"), ("–", "en dash")):
        if char in text:
            snippets = [
                text[max(0, m.start() - 40):m.start() + 40]
                for m in re.finditer(re.escape(char), text)
            ][:3]
            problems.append(
                f"{name}: {text.count(char)} {label}(s) in visible copy. "
                f"First: ...{snippets[0]}..."
            )


def check_headings(name: str, html: str) -> None:
    levels = [int(m.group(1)) for m in re.finditer(r"<h([1-6])\b", html, re.I)]
    h1_count = levels.count(1)
    if h1_count != 1:
        problems.append(f"{name}: found {h1_count} H1 tags, expected exactly 1")

    used = sorted(set(levels))
    previous = 0
    for level in levels:
        if previous and level > previous + 1:
            problems.append(
                f"{name}: heading jumps from H{previous} to H{level}, "
                "which breaks the outline"
            )
            break
        previous = level
    notes.append(f"{name}: heading levels used {used}")


def check_jsonld(name: str, html: str) -> None:
    blocks = re.findall(
        r'<script type="application/ld\+json">(.*?)</script>', html, re.S
    )
    if not blocks:
        problems.append(f"{name}: no JSON-LD structured data found")
        return
    for block in blocks:
        try:
            data = json.loads(block)
        except json.JSONDecodeError as exc:
            problems.append(f"{name}: JSON-LD does not parse. {exc}")
            continue
        types = [node.get("@type") for node in data.get("@graph", [])]
        flat = []
        for entry in types:
            flat.extend(entry if isinstance(entry, list) else [entry])
        notes.append(f"{name}: schema types {sorted(set(flat))}")


def check_meta(name: str, html: str) -> None:
    title_match = re.search(r"<title>(.*?)</title>", html, re.S)
    desc_match = re.search(
        r'<meta name="description" content="(.*?)"', html, re.S
    )
    if not title_match:
        problems.append(f"{name}: missing title tag")
    else:
        length = len(title_match.group(1))
        if not 30 <= length <= 75:
            problems.append(
                f"{name}: title is {length} characters, aim for 30 to 75"
            )
    if not desc_match:
        problems.append(f"{name}: missing meta description")
    else:
        length = len(desc_match.group(1))
        if not 110 <= length <= 165:
            problems.append(
                f"{name}: meta description is {length} characters, aim for 110 to 165"
            )
    if '<link rel="canonical"' not in html:
        problems.append(f"{name}: missing canonical link")


def check_links(name: str, html: str, valid: set[str]) -> None:
    for href in re.findall(r'href="(/[^"#?]*)"', html):
        if href.startswith("/assets/"):
            continue
        if href not in valid:
            problems.append(f"{name}: internal link {href} has no matching page")


def main_content(html: str) -> str:
    """Only the <main> region. Header and footer boilerplate repeats on every
    page and would otherwise inflate the density figure on short pages."""
    match = re.search(r"<main\b[^>]*>(.*?)</main>", html, re.S | re.I)
    return match.group(1) if match else html


def check_density(name: str, html: str) -> None:
    text = visible_text(main_content(html)).lower()
    words = re.findall(r"[a-z]+", text)
    total = len(words)
    if total < 400:
        problems.append(f"{name}: only {total} words, thin for a service page")

    counts = Counter(w for w in words if w not in STOPWORDS and len(w) > 2)
    for word, count in counts.most_common(4):
        density = count / total * 100
        if density > 3.0:
            problems.append(
                f'{name}: "{word}" appears {count} times, '
                f"{density:.1f} percent of the page, which reads as stuffing"
            )
    top = ", ".join(f"{w} {c}" for w, c in counts.most_common(3))
    notes.append(f"{name}: {total} words. Top terms: {top}")


def main() -> int:
    if not DIST.exists():
        print("dist/ not found. Run build.py first.")
        return 1

    pages = sorted(DIST.rglob("index.html"))
    valid = {
        "/" + str(p.parent.relative_to(DIST)).replace("\\", "/").strip(".") + "/"
        for p in pages
    }
    valid = {v.replace("//", "/") for v in valid}
    valid.add("/")

    for page in pages:
        rel = str(page.parent.relative_to(DIST)).replace("\\", "/")
        name = "/" if rel == "." else f"/{rel}/"
        html = page.read_text(encoding="utf-8")

        check_dashes(name, html)
        check_headings(name, html)
        check_jsonld(name, html)
        check_meta(name, html)
        check_links(name, html, valid)
        check_density(name, html)

    print("=" * 68)
    print(f"Checked {len(pages)} pages")
    print("=" * 68)
    for note in notes:
        print("  " + note)

    print()
    if problems:
        print(f"{len(problems)} problem(s) found:")
        for problem in problems:
            print("  ! " + problem)
        return 1

    print("No problems found.")
    return 0


if __name__ == "__main__":
    sys.exit(main())
