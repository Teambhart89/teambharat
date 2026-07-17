# epoojabooking.com WordPress Package

A complete, ready-to-upload WordPress package for **epoojabooking.com**: a premium, mobile-first Hindu spiritual marketplace for online puja booking, chadhava offerings, abhishek, havan, pandit services and astrology consultations.

## What is in this package

```
epoojabooking-theme.zip          → Upload via Appearance → Themes → Add New → Upload
epoojabooking-core-plugin.zip    → Upload via Plugins → Add New → Upload
themes/epoojabooking/            → Same theme, unzipped (for FTP upload to wp-content/themes/)
plugins/epoojabooking-core/      → Same plugin, unzipped (for FTP upload to wp-content/plugins/)
docs/seo-keyword-research.md     → Keyword research and content strategy
README.md                        → This file
```

## Installation (5 minutes)

1. Install WordPress 6.0+ on your hosting (PHP 7.4 or newer).
2. Go to **Appearance → Themes → Add New → Upload Theme**, upload `epoojabooking-theme.zip`, and **Activate**.
3. Go to **Plugins → Add New → Upload Plugin**, upload `epoojabooking-core-plugin.zip`, and **Activate**.
4. Done. Activating the plugin automatically:
   - creates all service pages with SEO content, clean URLs and meta descriptions,
   - creates the FAQ, About and Contact pages,
   - sets the homepage and builds the primary menu,
   - enables pretty permalinks (`/%postname%/`),
   - adds the booking form to every service page.

Visit **Settings → ePoojaBooking** to configure:
- **Razorpay Key ID and Secret** for online payments (UPI, cards, net banking, wallets)
- **Currency** (INR, USD, GBP, CAD, AUD, AED, SGD)
- **Notification email** for new booking alerts
- **WhatsApp number** for the floating chat button

## What the theme delivers

- **Design**: temple-inspired saffron, gold and warm white palette; Rozha One display type with Mukta body type; signature mandapa arch section dividers; diya glow hero.
- **Mobile-first and responsive**: tested breakpoints at 375, 768, 1024 and 1440 px; hamburger navigation; 44px+ touch targets.
- **SEO built in**: one H1 per page, structured H2/H3/H4 content, meta descriptions, Open Graph tags, and JSON-LD schema (Organization, WebSite, Service, BreadcrumbList, FAQPage).
- **Core Web Vitals friendly**: system font fallbacks with `display=swap`, no jQuery, no framework CSS, tiny JS (under 3 KB), lazy loading, reduced motion respected.
- **Accessibility**: WCAG AA contrast, visible focus rings, skip link, keyboard navigable menu and accordions.
- **Generative AI optimized content**: direct answers under each heading, FAQ schema, conversational phrasing that matches voice and AI search queries.

## What the plugin delivers

- **Booking form** with devotee name, email, phone/WhatsApp, seva selection, preferred date, gotra, nakshatra, sankalp, prasad delivery address and live streaming option.
- **Bookings dashboard** in wp-admin with service, date, contact and payment columns.
- **Email automation**: instant alert to you, warm confirmation to the devotee.
- **Razorpay payments** with server-side order creation and signature verification. Set a price per service with the `epb_booking_amount_paise` filter, for example:
  ```php
  add_filter( 'epb_booking_amount_paise', function ( $amount, $service ) {
      $prices = array( 'online-puja' => 110000, 'chadhava' => 51000 ); // in paise
      return $prices[ $service ] ?? $amount;
  }, 10, 2 );
  ```
- **WhatsApp chat button** sitewide once you save your number.
- **Pujas catalogue** post type for listing individual pujas with photos and prices.
- **Temple directory** at `/temples/`: 18 famous temples pre-loaded with original descriptions (history, significance, what to experience), darshan and aarti timings, city filter chips, and HinduTemple schema markup. Manage them under **Temples** in wp-admin.
- **Homepage banner slider**: manage slides under **Banners** in wp-admin. Each banner has a headline (the title), supporting text, button label and link, and a background photo set via the **Banner Image** (featured image) box. Reorder slides with the Order attribute. The slider auto-plays gently, pauses on hover and keyboard focus, respects reduced motion, and shows arrows and dots. A saffron trust strip appears below it.
- **Special Pujas**: manage under **Pujas** in wp-admin. Each puja card shows a thumbnail (the **Featured Image**, your image upload option), a badge label (like "Shravan Special"), title, description, temple location, puja date and a Participate button. Three sample special pujas are pre-loaded; edit or replace them with your own events. Each puja gets its own page with details and the booking form.
- **Login option**: a Login link with an account icon appears in the header, opening the WordPress login. Logged-in users see **My Account** instead. To let devotees register themselves, enable **Settings → General → Anyone can register** and set the new-user role to Subscriber. For full customer accounts with order history, add WooCommerce and its My Account page.
- **Astro Tools** in the menu with four free calculators, each on its own SEO page plus a hub page at `/astro-tools/`:
  - `/nakshatra-calculator/` — Free Nakshatra Calculator | Birthstar Calculator | Janma Nakshatra Calculator (nakshatra, pada and lord)
  - `/moon-sign-calculator/` — Free Moon Sign Calculator | Rashi Calculator | Janma Rashi Calculator (janma rashi and rashi lord)
  - `/mangal-dosha-calculator/` — Manglik check from both the Lagna and Moon chart, with traditional cancellations noted
  - `/kaal-sarp-dosha-calculator/` — complete/partial detection and the exact yoga type from all 12 (Anant to Sheshnag)

  The calculators compute real planetary positions in the visitor's browser (verified against standard astronomical references; Lahiri ayanamsa) — no external API, no per-use cost, and birth details are never stored or sent to a server. Each result includes a note recommending a detailed kundli for births near a sign boundary, and links to your puja and consultation pages for remedies. The menu shows Astro Tools as a dropdown with all four tools. an "Upcoming Online Pujas" page with a compact promo banner (reuses your Banners), a filter bar with Deity, Tithi, Dosha, Benefits and Location dropdowns, and the full puja card grid. Filters work instantly without reloading and combine with each other; a Clear all button resets them. Assign filter values while editing any puja using the **Deities, Tithis, Doshas, Benefits and Locations** boxes (they are normal WordPress taxonomies, so you can add unlimited values like "Ganesh", "Ekadashi", "Pitra Dosh" or "Katra, Jammu"). Filter dropdowns only show values that are actually assigned to at least one puja.

## Adding your own images (important for copyright)

No photos are bundled in this package. Bundling images scraped from other websites would violate their copyright, so every image slot is an option you fill with your own or licensed photos:

- **Temple card and hero photo**: edit the temple in wp-admin and set a **Featured Image**. It appears on the directory card and as the large gallery image on the temple page.
- **Temple photo gallery**: while editing a temple, upload additional images via **Add Media** (they attach to that temple). Up to four attached images automatically appear beside the featured image in the srimandir-style gallery grid.
- **Until you add images**, an elegant temple-art placeholder in the site's saffron and gold palette is shown, so pages never look broken.
- Good free sources for licensed temple photos: Wikimedia Commons (check each photo's license), Unsplash and Pexels, or your own visits. Always keep attribution where the license requires it.

Timings are pre-filled with commonly published values; verify them with each temple, as they change on festival days.

## Recommended companion plugins (free)

| Need | Plugin |
|---|---|
| Advanced SEO, sitemaps, schema extras | Rank Math SEO |
| Caching and Core Web Vitals | LiteSpeed Cache or WP Super Cache |
| WooCommerce store for spiritual products and prasad | WooCommerce |
| Stripe, PayPal and multi-currency checkout | WooCommerce Payments / Stripe for WooCommerce |
| Multilingual (Hindi, Tamil, Telugu, Bengali…) | TranslatePress or Polylang |
| Social login (Google, Facebook) | Nextend Social Login |
| PWA (installable app experience) | Super Progressive Web Apps |
| Email deliverability | WP Mail SMTP |
| Backups | UpdraftPlus |

The theme declares WooCommerce support, so you can add a product catalogue for devotional products, prasad and rudraksha whenever you are ready.

## Elementor note

You asked about Elementor Pro. It is a paid product with per-site licensing, so it cannot legally be bundled in this package. The good news: this theme does not need it. Every page ships ready-made with clean, fast HTML. If you later buy Elementor Pro, the theme is fully compatible; simply edit any page with Elementor.

## Roadmap features (phase 2)

The brief includes several platform features that need live services or paid APIs rather than static code. Recommended path:

| Feature | Recommended approach |
|---|---|
| AI kundli and horoscope tools | Integrate an astrology API (e.g. Prokerala) behind a custom page, or a "Talk to astrologer" flow first |
| Live darshan | Embed temple YouTube live streams on temple pages |
| Live chat with astrologers | WhatsApp deep links first, then a chat SaaS if volume grows |
| User dashboards, invoices, loyalty, referrals | WooCommerce accounts + a points plugin once the store is live |
| Daily panchang | Panchang API or a daily blog automation |
| Temple directory | Extend the included `epb_puja` pattern with a temple post type per partnership |

Launch with the booking core first, add these as revenue grows.

## SEO checklist after go-live

1. Install Rank Math, run the setup wizard, submit the sitemap to Google Search Console.
2. Point your domain, enable HTTPS, and set the site title to "epoojabooking" with the tagline from the homepage.
3. Add your logo under Appearance → Customize → Site Identity.
4. Read `docs/seo-keyword-research.md` and start the blog plan.
