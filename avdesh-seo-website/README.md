# Avdesh SEO Website (WordPress Theme)

A ready to upload WordPress theme for **Avdesh Kumar, SEO & AI Search Optimization Specialist (Delhi, India)**. The design matches the supplied portfolio: cream background, navy text, warm orange accent, Poppins typography, lowercase section titles with an orange dot, numbered service cards, a dark stats bar and a service ticker.

## Deliverables

- **`avdesh-seo.zip`** - the main theme. Upload in WordPress via `Appearance > Themes > Add New > Upload Theme`, then Activate. All pages, posts, menu and SEO friendly URLs are created automatically.
- **`avdesh-seo-child.zip`** - matching child theme. Activate this instead of the parent to keep custom CSS/PHP safe across theme updates.
- **`avdesh-seo-demo-content.xml`** - optional WXR demo-content export for `Tools > Import` (backup / second-site use). Not needed for a normal install since content auto-creates on activation.
- **`avdesh-seo/`** and **`avdesh-seo-child/`** - the theme sources.

Full install, child-theme and import instructions are in `avdesh-seo/README.txt`.

## Keyword research and SEO friendly URL map

Each service targets a researched primary keyword plus a set of natural secondary keywords, on a clean, keyword rich URL. Keywords are used naturally in the H1 to H4 headings and body copy, without stuffing.

| Page | SEO friendly URL | Primary keyword | Secondary keywords |
|------|------------------|-----------------|--------------------|
| SEO Services | `/seo-services/` | seo services | seo expert, seo company, search engine optimization services, organic traffic, seo strategy, affordable seo |
| Technical SEO | `/technical-seo-services/` | technical seo services | technical seo audit, core web vitals, site speed, crawlability, indexing, schema markup |
| On-Page SEO | `/on-page-seo-services/` | on-page seo services | on-page optimization, content optimization, title tags, meta descriptions, internal linking, seo content |
| Off-Page SEO | `/off-page-seo-link-building/` | link building services | off-page seo, white hat link building, backlinks, guest posting, digital pr, domain authority |
| Local SEO | `/local-seo-services/` | local seo services | google business profile, map pack, near me searches, local citations, gmb optimization, local rankings |
| eCommerce SEO | `/ecommerce-seo-services/` | ecommerce seo services | shopify seo, woocommerce seo, product page seo, category page seo, online store seo |
| AI Search Optimization | `/ai-search-optimization/` | ai search optimization | generative engine optimization, geo, aeo, chatgpt seo, google ai overviews, ai visibility |
| Google Ads | `/google-ads-management/` | google ads management | ppc management, google ads agency, pay per click, search ads, cost per lead, quality score |

Supporting pages: Home `/`, About `/about/`, Services hub `/services/`, Case Studies `/case-studies/`, Blog `/blog/`, Contact `/contact/`.

**Content standards applied to every page:** one exact-match H1 (page title), a logical H2 / H3 / H4 structure, a "quick answer" summary for AI engines, **10 frequently asked questions with answers** on each service page, natural keyword use with no stuffing, and minimal use of dashes for clean, reader-friendly copy.

## SEO and AI (GEO) features built in

- One `H1` per page with a logical `H2` / `H3` / `H4` hierarchy on every service page.
- Reader friendly content that avoids excessive dashes and reads naturally.
- Meta description, Open Graph and Twitter Card tags.
- Schema.org JSON-LD: `ProfessionalService`, `Person`, `BreadcrumbList` and `FAQPage`.
- Answer ready FAQ blocks and concise "quick answer" summaries that help generative AI engines cite the content.
- Clean permalinks, breadcrumbs, internal linking and a fast, mobile first responsive layout.

## Editing text (no code)

All page text is editable from the WordPress dashboard:

- **Homepage & service pages** - edit in `Pages` like a normal document. The page **title** is the H1, the **excerpt** is the intro line, and the editor body holds the H2/H3/H4 content. FAQ schema is generated automatically from any H3 that ends with a question mark.
- **Homepage "about" text** - `Pages > Home`.
- **Hero name/title** - `Customize > Business Details`; **hero tagline** - `Customize > Homepage Hero Text`; **stats** - `Customize > Homepage Stats Bar`.

## Image upload sections

Every picture in the design is a Customizer controlled slot (`Appearance > Customize > Images`). Where an image has not been added yet, the site shows a labelled dashed placeholder with the **recommended size** so the owner knows exactly where and what to upload.

| Slot | Recommended size |
|---|---|
| Hero portrait (homepage top) | 800 × 900 px (PNG transparent) |
| About section photo | 700 × 800 px |
| Contact / footer profile | 600 × 600 px |
| Case study images 1–4 | 600 × 400 px |
| Results / campaign images | 800 × 600 px |
| Logo | 220 × 60 px (PNG transparent) |

Images inside a service page or blog post are added directly in the page editor.

## Testimonials and brand logos

- **Testimonials** (`Customize > Testimonials`) - up to 6 client reviews, each with an optional photo (200 × 200 px), quote, name and role. Empty quotes are hidden automatically.
- **Brand logos** (`Customize > Brand Logos`) - up to 12 client logos (200 × 100 px, PNG transparent). Empty slots show an "Add logo" placeholder on the homepage.

## Blog and case studies

- **Blog starter** - three ready-to-publish SEO articles are created on activation under an "SEO Insights" category (AI Search Optimization/GEO, a Technical SEO checklist, and a Local SEO map-pack guide), each with Article schema. Blog lives at `/blog/`.
- **Case studies page** (`/case-studies/`) - headline metric cards (editable in `Customize > Case Study Metrics`), project cards with image-upload slots, and editable intro copy.

## Sample images pre-loaded

The theme bundles branded SVG placeholders (hero, about, profile, 4 case studies, 6 brand logos, 3 testimonial avatars) so the demo looks complete on first activation. Each is clearly marked as a sample; replace them anytime in `Customize > Images`, `Brand Logos`, or `Testimonials`.

## Informative, SEO-friendly content

Every page ships with substantial, reader-friendly and keyword-rich content: a clear H1/H2/H3/H4 structure, a "quick answer" summary for AI engines, an "Industries I serve" section on the homepage, a "Results you can expect" block and internal "Related services" links on each service page (which strengthens internal linking for SEO), plus FAQ sections that auto-generate FAQ schema.
