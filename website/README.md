# Online Plants Cart website

A static website for a plant nursery and green space services business in Delhi NCR. No frameworks, no build dependencies, no JavaScript required for anything on the page to work.

---

## Quick start

```bash
cd website
python3 build.py          # generates dist/
python3 check.py          # runs the SEO and quality checks
python3 -m http.server 8000 --directory dist
```

Then open `http://localhost:8000`. You need the local server rather than opening the files directly, because internal links use root relative paths the way they will on the live domain.

**Upload the contents of `dist/` to your web host.** Nothing else needs to go up.

---

## Before you publish

Search the repository for `REPLACE` and fill in the real values. Nothing here is guessed at silently, so every placeholder is visible.

| Where | What to change |
|---|---|
| `_src/site.json` | Email address, street address, postal code |
| `_src/body/about.html` | Founding year, real numbers, nursery address |
| `_src/body/contact.html` | Email, address, and the form endpoint |
| `_src/pages/*.json` | The discount percentages in the wholesale slab table |

Two content notes worth taking seriously:

1. **The wholesale discount slabs are placeholders.** They are set at 10, 18 and 25 percent as a sensible starting structure. Put your real numbers in, or remove the percentage column and leave "quote on request".
2. **There are no testimonials on the site.** That is deliberate. Invented reviews are both a trust problem and a legal one. Add real ones with real names once you have permission to use them, and the pages will convert noticeably better for it.

### The contact form needs an endpoint

A static site cannot process form submissions. The form in `_src/body/contact.html` has `action="REPLACE_WITH_YOUR_FORM_ENDPOINT"` and will do nothing until you point it somewhere. Use a form service such as Formspree, Basin or Web3Forms, which give you a URL to paste in. If you would rather not set one up, delete the form block. The phone and WhatsApp links are enough to launch with.

---

## How the site is put together

```
website/
├── build.py              assembles dist/ from the sources below
├── check.py              SEO and quality checks, run after every build
├── KEYWORD-RESEARCH.md   keyword clusters, URL map, linking plan
├── assets/
│   └── style.css         the whole design system, one file
├── _src/
│   ├── site.json         name, phone, address, service area
│   ├── template.html     the shell every page is poured into
│   ├── pages/*.json      one file per page: meta, schema data, FAQs
│   └── body/*.html       the main content of each page
└── dist/                 generated output, this is what you upload
```

### To edit content

Change the file in `_src/body/`, run `python3 build.py`, run `python3 check.py`. Never edit anything inside `dist/`, it is overwritten on every build.

### To change a page title, description or FAQ

Those live in `_src/pages/`, not in the body files, because the same data feeds both the visible page and the structured data. Editing it in one place keeps them from drifting apart.

### To add a new service page

1. Add `_src/pages/13-your-service.json`, copying an existing service file
2. Add `_src/body/your-service.html` with the content
3. Run the build

The navigation, the footer, the sitemap and the internal link structure all update themselves.

---

## What `check.py` verifies

Run it after every content change. It fails the build if any of these break.

- **No em dashes or en dashes** anywhere in visible copy
- **Exactly one H1 per page**, and heading levels that never skip a step
- **Valid JSON-LD** on every page, with the schema types listed
- **Every internal link** points at a page that exists
- **Title length** between 30 and 75 characters
- **Meta description length** between 110 and 165 characters
- **A canonical tag** on every page
- **No term above 3 percent density** within `<main>`, measured excluding the repeated header and footer
- **At least 400 words** per page

---

## SEO built into the pages

**Technical.** Unique title, meta description and canonical per page. Open Graph and Twitter card tags. `sitemap.xml` and `robots.txt` generated at build time. Semantic HTML with one H1 and a clean heading outline. A skip link, visible keyboard focus, and `prefers-reduced-motion` support. No external requests at all, which means nothing to block the render and no third party fonts to wait on.

**Structured data.** Every page carries a `@graph` containing `LocalBusiness`, `WebSite` and `WebPage`. Service pages add `Service` and `BreadcrumbList`. Pages with FAQs add `FAQPage`, which is what makes questions eligible to appear directly in search results.

**Written for AI assistants as well as search engines.** Each service page opens with a short, self contained summary paragraph that answers the page's core question in plain language. Headings are phrased as questions where a reader would ask one. Facts sit in lists, tables and definition lists rather than being buried in prose. Every claim that depends on your specifics is attributed to Online Plants Cart by name rather than left as an unattributed statement. `robots.txt` explicitly allows GPTBot, ClaudeBot, PerplexityBot and Google-Extended.

**Internal linking.** Every service page links to two or three genuinely related services with descriptive anchor text, and the services hub links to all eight. See the linking plan in `KEYWORD-RESEARCH.md`.

---

## After launch

1. Submit `sitemap.xml` in Google Search Console
2. Create a Google Business Profile with the name, address and phone matching the footer exactly. Inconsistency here quietly damages local ranking
3. Test a service page in Google's Rich Results Test to confirm the FAQ schema is picked up
4. Add real project photographs. In this category nothing converts like proof
5. Wait 60 days, then read Search Console and reprioritise from real impression data rather than from the assumptions in the keyword document
