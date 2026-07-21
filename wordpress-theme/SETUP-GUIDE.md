# Avdesh SEO — WordPress Theme Setup Guide

A fast, responsive, SEO and AI-search optimized WordPress theme built for
**Avdesh Kumar, SEO & AI Search Optimization Specialist (Delhi, India)**.
The design matches the uploaded portfolio: cream background, marigold orange
accent, bold lowercase headings, Poppins + Caveat fonts, numbered service cards
and a dark stats bar.

The deliverable is **`avdesh-seo.zip`** — ready to upload and activate.

---

## 1. What you get

- A complete custom WordPress theme (no page builder required, loads fast).
- **17 pages created automatically** on activation, each with a clean,
  keyword-rich, SEO-friendly URL.
- Full **H1 → H2 → H3 → H4** heading structure on every service page.
- **10 service pages** with reader-friendly, white-hat, GEO-optimized content.
- Built-in **Schema.org** markup (Person, ProfessionalService, Service, FAQPage),
  Open Graph and Twitter cards, so you are ready for Google **and** AI answer
  engines (ChatGPT, Gemini, Perplexity, Google AI Overviews).
- A homepage that mirrors the portfolio layout (hero, stats bar, services grid,
  process, results, case studies, tools, brands, FAQ, CTA).
- Easy **image replacement** — every image spot is a clearly marked upload box.
- A **Customizer panel** for contact details, social links, images and stats.
- Fully **responsive** and mobile friendly.

---

## 2. Install the theme (2 minutes)

1. Log in to **WordPress Admin** (`yoursite.com/wp-admin`).
2. Go to **Appearance → Themes → Add New → Upload Theme**.
3. Choose **`avdesh-seo.zip`** and click **Install Now**.
4. Click **Activate**.

On activation the theme automatically:
- Creates all pages (Home, About, Services + 10 service pages, Portfolio, Blog, Contact).
- Sets the homepage and blog page.
- Builds the primary navigation menu (with a Services dropdown).
- Switches permalinks to `/%postname%/` for clean URLs.

> If menus or URLs look off, go to **Settings → Permalinks** and click **Save**
> once to flush the rewrite rules.

---

## 3. Add your details (Customizer)

Go to **Appearance → Customize**:

- **Contact & Identity** — phone, WhatsApp, email, location, booking link.
- **Social Links** — LinkedIn, Instagram, Facebook, X, YouTube.
- **Site Images** — hero portrait, about photos, social share image.
- **Homepage Stats Bar** — the five numbers shown under the hero.

Click **Publish** when done.

---

## 4. Replace images

Anywhere you see a dashed **"upload image"** box, add your own picture:

- **Hero & About photos, social share image:** Customizer → **Site Images**.
- **Blog / page featured images:** edit the page → set **Featured image**.
- **Portfolio & logo placeholders:** see `assets/images/README.txt` inside the theme.

Recommended sizes are listed in that README. Compress images before uploading
to keep the site fast (good for Core Web Vitals and SEO).

---

## 5. Pages and their SEO-friendly URLs

| Page | URL |
|------|-----|
| Home | `/` |
| About | `/about/` |
| Services (overview) | `/services/` |
| SEO Services | `/seo-services/` |
| AI Search Optimization (GEO) | `/ai-search-optimization/` |
| Technical SEO | `/technical-seo-services/` |
| On-Page SEO | `/on-page-seo-services/` |
| Off-Page SEO & Link Building | `/off-page-seo-link-building/` |
| Local SEO | `/local-seo-services/` |
| E-commerce SEO | `/ecommerce-seo-services/` |
| Google Ads Management | `/google-ads-management/` |
| SEO Content Writing | `/seo-content-writing/` |
| SEO Audit | `/seo-audit-services/` |
| Portfolio | `/portfolio/` |
| Blog | `/blog/` |
| Contact | `/contact/` |

Full keyword mapping is in **`SEO-KEYWORD-STRATEGY.md`**.

---

## 6. Edit service content

Service page copy lives in one file so it stays consistent and easy to update:

```
avdesh-seo/inc/services-data.php
```

Each service has its H1, tagline, meta title/description, feature blocks (H3/H4),
process steps, benefits and FAQ. Edit the text there and every matching page,
its Schema and its meta tags update together.

Prefer editing in the dashboard? You can also rebuild any page with the block
editor — but keep the primary keyword in the H1 and one clear H1 per page.

---

## 7. Contact form

The Contact page ships with a working email (mailto) form so it functions out of
the box. For a database-backed form with spam protection:

1. Install a free plugin (**WPForms Lite** or **Contact Form 7**).
2. Build your form and copy its **shortcode**.
3. Paste it in **Customize → Contact & Identity → Contact form shortcode**.

The theme will use your plugin form instead of the default one.

---

## 8. Recommended next steps for SEO & AI visibility

- **Set the site title** under Settings → General (defaults to "Avdesh Kumar").
- Install **Google Search Console** and submit your sitemap.
- Add **Google Analytics 4** (GA4) for traffic tracking.
- Optional: install **Rank Math** or **Yoast** for advanced SEO controls. If you
  do, add `define( 'AVDESH_DISABLE_SEO', true );` to `wp-config.php` to let the
  plugin own meta tags and avoid duplicates (Schema will then come from the plugin).
- Publish blog posts targeting long-tail keywords and link them to your service
  pages to build topical authority.
- Keep your **name, phone and address consistent** everywhere for local SEO and
  a stable AI knowledge-graph entry.

---

## 9. Technical notes

- **Requires:** WordPress 6.0+, PHP 7.4+ (PHP 8.x supported).
- **No paid dependencies.** Google Fonts load from Google's CDN.
- **Standards-based:** uses the WordPress template hierarchy, Customizer API,
  nav menus and Schema.org. Works with caching and most SEO plugins.
- To disable the built-in SEO/meta output (when using an SEO plugin), define
  `AVDESH_DISABLE_SEO` in `wp-config.php`.

Enjoy your new site. Everything is white-hat, fast and built to grow.
