=== Rajdhani Nursery ===
Contributors: rajdhaninursery
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Complete WordPress theme for Rajdhani Nursery, Delhi. Mali on rent and gardener
booking website with online maali booking, SEO ready service pages, pricing
plans, FAQ schema and a floating WhatsApp button.

== Installation ==

1. In your WordPress admin go to Appearance > Themes > Add New Theme.
2. Click "Upload Theme", choose rajdhani-nursery.zip and click "Install Now".
3. Click "Activate".

On activation the theme automatically:

* Creates all pages with SEO friendly URLs (mali-on-rent-delhi,
  gardener-on-rent-delhi, garden-maintenance-services-delhi,
  plant-care-services-delhi, terrace-garden-maintenance-delhi,
  maali-service-plans, book-maali-online, faqs, about-us, contact-us)
* Sets the home page and the primary navigation menu
* Switches permalinks to pretty /page-name/ URLs
* Adds hand written meta descriptions and schema markup
  (LocalBusiness, Service, FAQPage, BreadcrumbList) to every page

== After Activation: 3 Required Steps ==

1. UPDATE YOUR CONTACT DETAILS
   Go to Appearance > Customize > Business Details and enter your real
   phone number, WhatsApp number (digits only with country code, for
   example 919876543210), email and nursery address. The WhatsApp
   floating button and all contact links use these values.

2. CHECK YOUR EMAIL ADDRESS
   Booking notifications are sent to the admin email under
   Settings > General. Make sure it is correct. For reliable delivery
   we recommend installing any free SMTP plugin (for example
   "WP Mail SMTP") and connecting your email account.

3. TEST A BOOKING
   Open the Book Maali Online page, submit a test booking and confirm
   it appears under "Maali Bookings" in the admin menu and that the
   notification email arrives.

== Managing Bookings ==

All bookings appear in the WordPress admin under "Maali Bookings" with
the customer's phone, area, visit date, time, duration and estimated
price. Open any booking to see full details including address, garden
type and special instructions. Call or WhatsApp the customer to confirm.

== Editing Content ==

* All service pages are normal WordPress pages, edit them under Pages.
* Pricing plans and FAQs are managed in one place so they stay in sync
  with the schema markup: edit rn_get_plans() and rn_get_faqs() in
  functions.php, or ask your developer.
* The booking durations and prices are in rn_get_durations() in
  functions.php.
* Shortcodes: [maali_booking_form] shows the booking form,
  [rn_plans] shows the pricing cards, [rn_faqs] shows the FAQ accordion.
  You can drop these on any page.

== SEO Notes ==

* Every page ships with a unique title, meta description, Open Graph
  tags and JSON-LD schema, ready for Google and AI search.
* Verify your site in Google Search Console and submit the sitemap at
  /wp-sitemap.xml (WordPress generates this automatically).
* Add your Google Business Profile and link it to the contact page for
  stronger local rankings.
