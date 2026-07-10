=== SaltStayz ===
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
License: GPLv2 or later

Serviced-apartment website theme with a complete built-in booking system.

== What you get ==

* Guest website with hero, apartment types, locations, amenities,
  testimonials and a booking form (front page, automatic).
* Booking panel inside wp-admin ("SaltStayz Bookings" menu):
  - Confirm ✉  — sets the booking to Confirmed and emails the guest.
  - Check out ✉✉ — sets Checked out and sends TWO emails: the check-out
    summary and a thanks-for-staying email containing a unique feedback link.
  - Cancel — cancels the booking.
* Four automated guest emails (HTML, branded): request received, booking
  confirmed, check-out summary, thanks + feedback request.
* Guest feedback page (tokenized link, star rating + comments, one
  submission per stay) — results appear under "Guest Feedback" in wp-admin.

== Installation ==

1. In wp-admin go to Appearance → Themes → Add New Theme → Upload Theme.
2. Choose saltstayz-theme.zip, click Install Now, then Activate.
3. Done — the front page, booking form, booking panel and emails are live.

No plugins or configuration required. Bookings appear under
"SaltStayz Bookings" in the wp-admin menu.

== Email deliverability (recommended) ==

Emails are sent with wp_mail(). Most hosts deliver these out of the box,
but for reliable inbox placement install any SMTP plugin
(e.g. "WP Mail SMTP") and connect your Gmail or other email provider account.

== Customising ==

* Site name in the header/emails comes from Settings → General → Site Title.
* Properties and apartment types: edit ssz_properties() and
  ssz_apartments() in functions.php.
* Prices and page copy: edit front-page.php.
* Colors, fonts and spacing: design tokens at the top of style.css.
