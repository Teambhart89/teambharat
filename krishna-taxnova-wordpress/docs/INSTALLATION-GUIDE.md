# Krishna TaxNova WordPress Website — Installation Guide

Everything you need is in the ZIP: a custom theme, a core plugin (services, forms, WhatsApp, SEO, schema) and one click content import that creates all 10 categories, 90 service pages, the homepage, About, Contact and Privacy Policy pages.

## What is in the package

```
krishna-taxnova-wordpress.zip
├── krishna-taxnova-theme.zip     → WordPress theme (upload via Appearance)
├── ktn-core-plugin.zip           → Core plugin (upload via Plugins)
└── docs/
    ├── INSTALLATION-GUIDE.md     → this file
    └── KEYWORD-RESEARCH.md       → SEO keyword map for every page
```

## Requirements

- WordPress 6.0 or newer
- PHP 7.4 or newer (8.x recommended)
- Any standard hosting (shared hosting works fine)

## Step by step installation (about 10 minutes)

### Step 1 — Install the plugin
1. In WordPress admin go to **Plugins → Add New Plugin → Upload Plugin**.
2. Choose `ktn-core-plugin.zip`, click **Install Now**, then **Activate**.

### Step 2 — Install the theme
1. Go to **Appearance → Themes → Add New Theme → Upload Theme**.
2. Choose `krishna-taxnova-theme.zip`, click **Install Now**, then **Activate**.

### Step 3 — Enter your business details
1. Go to the new **Krishna TaxNova** menu in the admin sidebar.
2. Fill in:
   - **Phone number** (shown in header, footer and click to call)
   - **WhatsApp number** — digits only with country code, e.g. `919876543210`. Every WhatsApp button on the site uses this.
   - **Email address** — enquiry notifications with document links are sent here.
   - Office address, working hours and social media links.
   - Optional: paste a Google Maps iframe embed for the contact page.
3. Click **Save Changes**.

### Step 4 — Import all content (one click)
1. Go to **Krishna TaxNova → Import Content**.
2. Click **Import All Content Now**.
3. Wait for the success message. This creates:
   - 10 service categories with SEO descriptions
   - 90 service pages, each with full content, meta tags and 10 FAQs
   - Home, About Us, Contact Us and Privacy Policy pages
   - Sets the homepage and pretty permalinks automatically
4. The import is safe to run again later; it updates rather than duplicates.

### Step 5 — Final checks
1. Go to **Settings → Permalinks** and click **Save Changes** once (refreshes URL rules).
2. Visit the site: the mega menu, homepage, service pages, forms and the floating WhatsApp button should all be live.
3. Send a test enquiry with a document from any service page and confirm the email arrives (check spam the first time).

## Where things live day to day

| Task | Where |
|---|---|
| View enquiries + uploaded documents | **Enquiries** menu in admin |
| Edit a service page or its FAQs | **Services** menu (FAQs are in the SEO and Service Details box) |
| Change phone/WhatsApp/email | **Krishna TaxNova** settings |
| Add a new service | Services → Add New, assign a category; it appears in menus automatically |
| Upload your logo | Appearance → Customize → Site Identity |

## Recommended free plugins (optional)

- **Rank Math SEO** or **Yoast SEO** — for XML sitemaps and Search Console. The theme's built in SEO output steps aside automatically when either is active, so there is no conflict.
- **LiteSpeed Cache** or **WP Super Cache** — page speed.
- **UpdraftPlus** — backups.
- **WP Mail SMTP** — reliable email delivery for enquiry notifications (recommended on shared hosting).

## Notes

- **Forms and document upload** are built into the plugin — no form plugin needed. Uploads accept PDF, JPG, PNG, DOC/DOCX, XLS/XLSX and ZIP, up to 5 files of 10 MB each, with spam protection.
- **WhatsApp buttons** appear site wide (floating button) and on every service page ("WhatsApp Us Your Documents") with a pre-filled message naming the service.
- **Structured data** (Organization, Service, FAQPage, BreadcrumbList) is output automatically for rich results.
- **Menus are automatic**: the header mega menu and footer link columns build themselves from your service categories, so new services appear without touching menu settings.

## Support tips

- If service URLs show 404 after import, re-save Settings → Permalinks.
- If enquiry emails do not arrive, install WP Mail SMTP and connect your email account.
- To change homepage statistics (clients served, rating), edit them under the `ktn_home_data` option or ask your developer; defaults are sensible placeholders.
