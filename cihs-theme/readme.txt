=== CIHS – Centre for Integrated and Holistic Studies ===
Contributors: cihs
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Complete website theme for the Centre for Integrated and Holistic Studies (CIHS),
a non-partisan independent think tank headquartered in New Delhi, India.

== Description ==

Upload, activate, done. On activation the theme automatically creates the
entire website:

* PAGES — Home, About CIHS, Mission & Vision, Our Team, Careers & Internships
  (with live job-openings grid + application form), Support CIHS (donation
  page with preset amounts, pledge form and bank/UPI details), Research &
  Focus Areas (with 5 focus-area sub-pages: Geopolitics & Security, Policy &
  Governance, Economy & Technology, Culture & Civilisation, Diaspora &
  Global Engagement), Analysis & Commentary (blog), Media & Press,
  Contact Us, Privacy Policy, Terms of Use.
* MENUS — Primary menu (with About and Research drop-downs), Footer quick
  links and Legal menu, all created and assigned automatically.
* CONTENT — Sample publications, events, analysis posts and placeholder team
  members so every section of the site looks complete from minute one.
* SETTINGS — Front page, posts page, tagline and pretty permalinks are all
  configured automatically.

Features:

* Custom post types: Publications (with Publication Type + Focus Area
  taxonomies), Events (with date/time/venue/registration fields + featured
  thumbnail image), Team, Job Openings (location/type/deadline fields) and
  Impact Gallery (image + caption items shown on the homepage).
* Homepage: hero slider (3 slides with optional banner IMAGES, editable in
  the Customizer), focus-area grid, "Our Latest Reports" — 4 newest
  publications with thumbnails, event cards with image + date ribbon +
  venue + Event Details button, stats band, "Our Impact" image gallery,
  latest commentary, newsletter signup and call-to-action band.
* Header: search toggle with slide-down search bar, and a Donate button.
* Careers: openings grid, single opening pages, and a plugin-free
  application form (CV link, portfolio, statement of interest) emailed to
  your inbox.
* Donations: pledge form with preset ₹ amounts, PAN field for receipts,
  payment-mode selection, automatic thank-you email to the donor, and a
  bank/UPI details card managed from the Customizer.
* Built-in contact form (shortcode [cihs_contact_form]) with honeypot and
  nonce protection — no plugin needed.
* Customizer panels for contact details, social links and hero slides.
* SEO: meta descriptions, Open Graph and Twitter cards, JSON-LD Organization
  schema.
* Block editor ready: editor styles, custom color palette, block patterns,
  wide/full alignments.
* Accessible: skip links, focus styles, reduced-motion support, semantic
  markup. Fully responsive with a mobile drawer menu.

== Installation ==

1. In WordPress admin go to Appearance → Themes → Add New Theme → Upload Theme.
2. Choose cihs-theme.zip and click Install Now.
3. Click Activate. The theme builds all pages, menus and sample content
   automatically (a few seconds).
4. Visit the site — the full website is live.

== After activation (10-minute checklist) ==

1. Appearance → Customize → Site Identity: upload the CIHS logo.
2. Appearance → Customize → CIHS: Contact Details / Social Links: confirm
   phone, email and addresses.
3. Appearance → Customize → CIHS: Homepage Hero Slides: upload a banner
   image for each slide (recommended 1920×800px).
4. Appearance → Customize → CIHS: Donation Details: enter the real bank
   account, IFSC and UPI ID for the Support CIHS page.
5. Events → set a Featured Image on each event (shown as the card
   thumbnail with the date ribbon).
6. Impact Gallery → add items with a Featured Image; they appear in the
   "Our Impact" section on the homepage automatically.
7. Job Openings → replace the three sample openings with real vacancies.
8. Team / Publications / Posts: replace the sample entries with real
   content (each sample is clearly marked).

== Updating from version 1.0 ==

Upload the new zip via Appearance → Themes → Add New → Upload Theme and
choose "Replace active with uploaded". The 1.1 upgrade routine runs
automatically: it creates the Support CIHS page, upgrades the Careers page
with the openings grid + application form, seeds sample job openings and
adds Donate links to your menus — without touching any content you have
already edited.

Re-activating the theme never duplicates content (guarded by the
cihs_setup_done option). To re-run the setup on a fresh site, delete that
option from the database first.

== Changelog ==

= 1.1.0 =
* Careers: Job Openings post type, openings grid and application form.
* Donations: Support CIHS page with pledge form, preset amounts and
  bank/UPI details managed from the Customizer.
* Homepage hero slides now support banner images with automatic overlay.
* Events: thumbnail image cards with date ribbon on homepage and archive.
* New "Our Latest Reports" homepage section (4 newest publications with
  thumbnails).
* New "Our Impact" homepage image gallery (Impact Gallery post type).
* Header search toggle and Donate button.
* Automatic, non-destructive upgrade routine for sites on 1.0.

= 1.0.0 =
* Initial release: full site auto-setup, CPTs, hero slider, contact form,
  SEO schema, block patterns.
