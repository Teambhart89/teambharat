# Avdesh SEO — WordPress Theme Setup Guide

A premium, fast, responsive WordPress theme that positions **Avdesh Kumar** as a
world-class freelance **SEO, AI Search Optimization (AISO), GEO & Google Ads
consultant**. Modern international-agency design: deep navy base, indigo → violet
gradients, an emerald "growth" accent, Sora + Inter typography, animated counters,
data-viz graphs, and sticky contact buttons.

The deliverable is **`avdesh-seo.zip`** — ready to upload and activate.

---

## 1. What you get

- A premium custom theme (no page builder, loads fast, Core Web Vitals friendly).
- **28 pages created automatically** on activation, each with a clean, keyword-rich URL.
- **15 service pages** with full **H1 → H2 → H3 → H4** structure and white-hat, GEO-optimized copy.
- Conversion-focused homepage: hero with rating badge + metric cards, animated
  stat counters, trust bar, services grid, why-hire-me, SEO process, results with
  **traffic & ranking graphs** and GSC/Analytics placeholders, industries, tools,
  testimonials, case studies, certifications, FAQ and CTAs.
- Dedicated pages: **Case Studies, SEO Results, Testimonials, Industries, Pricing
  (3 packages), FAQs, Book a Free SEO Audit, About, Services, Portfolio, Blog, Contact.**
- **Sticky floating contact buttons** (WhatsApp, Free Audit, Email) on every page.
- Built-in **Schema.org** (Person, ProfessionalService, Service, FAQPage), Open
  Graph and Twitter cards — ready for Google **and** AI answer engines.
- Clearly marked **image-upload sections** everywhere a photo/screenshot belongs.
- A **Customizer** panel for contact details, socials, images, stats and pricing.
- Fully responsive, mobile-first and accessible (reduced-motion aware, focus states).

---

## 2. Install (2 minutes)

1. **WordPress Admin → Appearance → Themes → Add New → Upload Theme**.
2. Choose **`avdesh-seo.zip`** → **Install Now** → **Activate**.

On activation the theme auto-creates all pages, sets the homepage/blog, builds the
navigation menu (with Services and Case Studies dropdowns) and switches permalinks
to `/%postname%/`.

> If menus or URLs look off, open **Settings → Permalinks** and click **Save** once.

---

## 3. Add your details (Customizer)

**Appearance → Customize**:

- **Contact & Identity** — phone, WhatsApp, email, location, booking link, form shortcodes.
- **Social Links** — LinkedIn, Instagram, Facebook, X, YouTube.
- **Site Images** — hero portrait, about photos, social share (Open Graph) image.
- **Homepage Stats Bar** — the numbers under the hero.
- **Pricing** — currency symbol and the Starter/Growth prices.

The sticky WhatsApp button appears once you set your WhatsApp number.

---

## 4. Replace images & screenshots

Every dashed **"upload"** box is a spot for your own image:

- **Hero / About / OG images:** Customizer → **Site Images**.
- **SEO Results & Case Studies screenshots** (GSC, Analytics, keyword growth):
  edit the page in the block editor and drop your images into the marked boxes,
  or set page **Featured images**.
- See `assets/images/README.txt` for recommended sizes. Compress before uploading.

---

## 5. Pages & SEO-friendly URLs

| Page | URL |
|------|-----|
| Home | `/` |
| About | `/about/` |
| Services (overview) | `/services/` |
| Case Studies | `/case-studies/` |
| SEO Results | `/seo-results/` |
| Portfolio | `/portfolio/` |
| Testimonials | `/testimonials/` |
| Industries | `/industries/` |
| Pricing | `/pricing/` |
| FAQs | `/faqs/` |
| Book a Free SEO Audit | `/book-free-seo-audit/` |
| Blog | `/blog/` |
| Contact | `/contact/` |

**15 service pages:** `/seo-services/`, `/ai-search-optimization/`,
`/technical-seo-services/`, `/on-page-seo-services/`, `/off-page-seo-link-building/`,
`/local-seo-services/`, `/ecommerce-seo-services/`, `/international-seo-services/`,
`/google-ads-management/`, `/seo-content-writing/`, `/content-strategy-services/`,
`/keyword-research-services/`, `/website-migration-services/`,
`/core-web-vitals-optimization/`, `/seo-audit-services/`.

Full keyword mapping is in **`SEO-KEYWORD-STRATEGY.md`**.

---

## 6. Edit service content

All service copy lives in one file so it stays consistent:

```
avdesh-seo/inc/services-data.php
```

Each service has its H1, tagline, meta title/description, feature blocks (H3/H4),
process steps, benefits and FAQ. Edit there and the page, its Schema and its meta
tags update together. Site-wide FAQs live in `inc/template-helpers.php`
(`avdesh_faq_list()`), which also powers the FAQ schema.

---

## 7. Contact & audit forms

Both the Contact and Book-a-Free-Audit pages ship with a working email (mailto)
form. For a database-backed form with spam protection:

1. Install **WPForms Lite** or **Contact Form 7**.
2. Copy your form **shortcode**.
3. Paste it in **Customize → Contact & Identity** (separate fields for the contact
   form and the audit form).

---

## 8. SEO & AI visibility checklist

- Set your **site title** under Settings → General.
- Verify **Google Search Console** and submit your sitemap.
- Add **Google Analytics 4**.
- Optional: install **Rank Math** or **Yoast**; if you do, add
  `define( 'AVDESH_DISABLE_SEO', true );` to `wp-config.php` so the plugin owns
  meta tags (avoids duplicates).
- Publish blog posts targeting long-tail keywords and link them to service pages.
- Keep your **name, phone and address consistent** everywhere for a stable AI
  knowledge-graph entry.

---

## 9. Technical notes

- **Requires:** WordPress 6.0+, PHP 7.4+ (PHP 8.x supported).
- **No paid dependencies.** Google Fonts load from Google's CDN.
- **Performance:** minimal CSS/JS, inline SVG charts (no chart library), lazy images.
- **Accessibility:** semantic headings, focus styles, `prefers-reduced-motion` support.
- Disable the built-in SEO output with `AVDESH_DISABLE_SEO` when using an SEO plugin.

Your premium SEO consultant site is ready to win clients worldwide.
