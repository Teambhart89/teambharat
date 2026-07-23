# Avdesh SEO - Pre-Launch Checklist

Work through these steps once, in order, before you announce the site. Most take a few minutes. Boxes you can tick as you go.

## 1. Content and branding
- [ ] **Business details** set in `Appearance > Customize > Business Details` (name, phone, email, location, LinkedIn).
- [ ] **Homepage hero tagline** set in `Customize > Homepage Hero Text`.
- [ ] **Stat numbers** updated in `Customize > Homepage Stats Bar` with your real figures.
- [ ] **Logo** uploaded in `Customize > Site Identity` (about 220 x 60 px, PNG transparent).
- [ ] **Real images** replace the samples in `Customize > Images`, `Brand Logos` and `Testimonials`.
- [ ] **Page text** reviewed in `Pages` (Home, Services, Case Studies, Contact) and `Posts` for the blog.
- [ ] **Site Title and Tagline** set in `Settings > General`.

## 2. SEO plugin (recommended)
The theme already outputs titles, meta descriptions and schema, but a dedicated SEO plugin adds per-page control and a richer sitemap.
- [ ] Install **Rank Math** or **Yoast SEO** (`Plugins > Add New`).
- [ ] Run its setup wizard and connect it to your Google account if offered.
- [ ] Set a default social share image and confirm titles look right.
- [ ] Leave the theme's own schema on, or turn it off in the plugin to avoid duplicates (either is fine, just avoid two FAQ blocks on the same page).

## 3. XML sitemap
- [ ] Your sitemap is live at **`https://yourdomain.com/wp-sitemap.xml`** (built into WordPress). If you installed Rank Math or Yoast, use the sitemap it provides instead (for example `/sitemap_index.xml`).
- [ ] Open the sitemap URL in a browser and confirm your pages are listed.

## 4. Google Search Console
- [ ] Go to `search.google.com/search-console` and add your domain.
- [ ] Choose the **HTML tag** method, copy the code, and paste it into `Customize > Analytics & Verification > Google Search Console verification code`.
- [ ] Click Verify in Search Console.
- [ ] Submit your sitemap URL under `Sitemaps`.

## 5. Google Analytics 4
- [ ] Create a GA4 property at `analytics.google.com` and copy the **Measurement ID** (starts with `G-`).
- [ ] Paste it into `Customize > Analytics & Verification > Google Analytics 4 Measurement ID`.
- [ ] Open your site in a private window and confirm a live visit shows in GA4 Realtime. (Logged in admins are not tracked on purpose.)

## 6. Performance
- [ ] Install a caching plugin (for example **WP Super Cache** or **LiteSpeed Cache**).
- [ ] Compress images before upload (for example at tinypng.com) and upload at about twice the display size.
- [ ] Test with PageSpeed Insights (`pagespeed.web.dev`) and aim for green Core Web Vitals.

## 7. Technical
- [ ] Permalinks are set to Post name (the theme sets this automatically; confirm in `Settings > Permalinks`).
- [ ] SSL is active and the site loads on `https://` (ask your host if unsure).
- [ ] `Settings > Reading` has Homepage set to **Home** and Posts page set to **Blog**.
- [ ] `Settings > Reading` "Discourage search engines" is **unchecked** before launch.
- [ ] Set a **favicon** (Site Icon) in `Customize > Site Identity`.

## 8. Final checks
- [ ] Every menu link and button works, including the Contact form.
- [ ] The Contact form reaches your inbox (test it, or connect Contact Form 7 or WPForms).
- [ ] The site looks good on mobile (resize your browser or use a phone).
- [ ] No sample text remains ("Sample Photo", "Case Study 1", placeholder stats).
- [ ] Check for broken links.

## 9. After launch
- [ ] Request indexing of your key pages in Search Console (URL Inspection).
- [ ] Publish new blog posts regularly to keep growing rankings.
- [ ] Review Search Console and GA4 every few weeks and double down on what works.
