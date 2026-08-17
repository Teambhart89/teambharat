# OSINT Detective Agent

An autonomous AI agent powered by Claude that conducts OSINT investigations by combining Holehe, Sherlock, and GHunt to profile individuals from publicly available data.

## Requirements

- Python 3.8+
- [Holehe](https://github.com/megadose/holehe) — `pip install holehe`
- [Sherlock](https://github.com/sherlock-project/sherlock) — `pip install sherlock-project`
- [GHunt](https://github.com/mxrch/GHunt) — follow repo instructions
- Anthropic API key

## Setup

```bash
pip install -r requirements.txt
export ANTHROPIC_API_KEY=your_key_here
```

## Usage

```bash
python detective.py investigate john@example.com
python detective.py investigate --email john@example.com --username johndoe
```

Reports are saved to `reports/` as timestamped markdown files.

## Claude Skill

The `.claude/skills/SKILL.md` file defines this capability as a Claude Code skill. Claude will automatically apply the investigation workflow when you ask it to investigate an email or username.

## Ethics

For authorized use only: personal digital footprint review, authorized security testing, or research with ethical oversight. Never for surveillance or harassment.

---

# Image SEO Auditor

`image_seo_audit.py` crawls a site, inventories every image, grades each one against
image-SEO and accessibility best practice, generates suggested alt text plus target
keywords, and writes a multi-sheet XLSX report.

## Usage

```bash
pip install -r requirements.txt

# Crawl a live site
python image_seo_audit.py https://example.com/

# Render each page in headless Chromium first - required for JS-built image grids
playwright install chromium
python image_seo_audit.py https://example.com/ --render

# Larger crawl, explicit output path
python image_seo_audit.py https://example.com/ --max-pages 500 --out reports/audit.xlsx

# Audit saved HTML instead of crawling (useful when the host is unreachable)
python image_seo_audit.py https://example.com/ --html-dir ./saved_pages
```

Options: `--max-pages` (default 200), `--out`, `--html-dir`, `--render`,
`--no-asset-check` (skip downloading images, so no file-size or dimension data),
`--delay`, `--quiet`.

### `--render` mode

Without it the crawler only sees the HTML the server sends, so anything a
framework paints client-side is invisible. Against a test page with a
JS-built grid, the static crawl found 1 of 3 homepage images; `--render` found
all 3.

Rendering loads each page in headless Chromium, waits for the network to settle,
auto-scrolls to trigger lazy-loading, then measures every image in place. That
replaces three static guesses with real data:

- **Above-the-fold** is the image's laid-out position, not its document order,
  so the LCP and lazy-loading checks stop misfiring on sticky headers
- **Displayed width** is the rendered box, so "oversized for display" compares
  against what the browser actually painted
- **Load failures** surface images that resolve but never decode

It also adds runtime-only checks: alt attributes stripped by JS, images that
never finish loading, and images with zero intrinsic width after load.

Set `CHROMIUM_PATH` if you need to point at a specific Chromium binary.

Reports are written to `reports/` as timestamped `.xlsx` files.

## What it finds

URLs are discovered from `robots.txt`, sitemap indexes and nested sitemaps, then
topped up by following internal links. Images are extracted from `<img>` (including
`data-src`, `data-lazy-src` and other lazy-load attributes), `<picture><source>`,
`<noscript>` fallbacks, inline CSS `background-image`, and `og:image` /
`twitter:image` meta tags.

Each image is checked for:

- **Alt text** — missing attribute, empty alt, generic alt (`image`, `IMG_1234`),
  over 125 characters, too short, `image of` prefixes, keyword stuffing,
  comma-separated keyword lists, filenames used as alt text
- **Filenames** — camera defaults (`IMG_####`, `DSC_####`), hashes and UUIDs,
  underscores, uppercase, spaces
- **Format and weight** — non-next-gen formats, GIFs, oversized files, broken URLs
- **Core Web Vitals** — missing `width`/`height` (CLS), lazy-loaded above-fold
  images, missing `fetchpriority` on the likely LCP image, below-fold images not
  lazy-loaded, missing `srcset`, images served far larger than displayed
- **Security** — `http://` images on HTTPS pages

## Report sheets

| Sheet | Contents |
| --- | --- |
| 1. Summary | Scope, alt-text health, severity breakdown, top issues by volume |
| 2. All Images | Full inventory: page, category, image URL, alt, dimensions, displayed size, above-fold, weight, issues |
| 3. Alt Tag Fix List | Priority-sorted images needing alt work, with suggested alt text |
| 4. All Alt Tags | Suggested alt text and a ready-to-paste `<img>` tag for every image |
| 5. Technical Issues | One row per non-alt issue with the recommended fix |
| 6. By Page | Per-page rollup of image counts, alt gaps and issue totals |
| 7. By Category | Per-category rollup with alt coverage percentage |
| 8. Best Practices | Reference checklist behind every rule the auditor applies |

Suggested alt text is derived from the page H1, breadcrumbs, product card titles,
figure captions and cleaned filename tokens, capped at 125 characters. Logos,
decorative icons and payment badges are detected and given their own treatment
rather than inheriting the page's commercial keyword. Every suggestion should be
checked against the actual image before publishing.
