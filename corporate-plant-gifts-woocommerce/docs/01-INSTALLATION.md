# Installation

Total time: about fifteen minutes, most of which is the catalogue build running
in the background.

---

## Before you start

You need a working WordPress site with:

- WordPress 6.0 or newer
- PHP 7.4 or newer (8.1 or 8.2 recommended)
- WooCommerce 7.0 or newer, installed and activated
- The PHP GD extension, so the setup can generate placeholder images. If GD is
  missing everything still installs, you just get WooCommerce grey placeholders
  instead
- At least 128MB PHP memory limit, 256MB is more comfortable

If WooCommerce is not installed yet, install it first and run its own setup
wizard so the cart, checkout and account pages exist. The PlantGift setup links
its menus to those pages.

---

## Step 1: install WooCommerce

WordPress admin, then **Plugins, Add New**. Search for WooCommerce, install and
activate. Work through its short setup wizard and set your country, currency
and the units you sell in. You can skip payment gateways for now.

---

## Step 2: install the theme

1. Go to **Appearance, Themes, Add New, Upload Theme**
2. Choose `theme/plantgift-pro.zip` from this package
3. Click **Install Now**, then **Activate**

If WordPress rejects the upload with a file size error, your host has a low
`upload_max_filesize`. Either raise it, or upload the folder to
`wp-content/themes/` over SFTP instead.

---

## Step 3: install the plugin

1. Go to **Plugins, Add New, Upload Plugin**
2. Choose `plugin/plantgift-core.zip` from this package
3. Click **Install Now**, then **Activate**

You are redirected to the **PlantGift** setup screen automatically. If not, find
it in the admin sidebar under the palm tree icon.

---

## Step 4: run the setup

On the PlantGift screen, click **Run every step**. The six steps run in order:

| Step | What it builds | Roughly |
|---|---|---|
| Pot attributes | 6 global attributes, 34 options | seconds |
| Gift categories | 18 categories with full SEO copy | 10 to 20 seconds |
| Plant catalogue | 43 products, 550 variations | 2 to 6 minutes |
| Service and core pages | 18 pages, 210 questions and answers | 10 to 30 seconds |
| Navigation menus | primary, 3 footer columns, legal | seconds |
| Permalinks and options | URL structure, catalogue defaults, widgets | seconds |

**Leave the browser tab open** while the catalogue step runs. It works through
the products in batches of four and shows a progress bar. If the tab is closed
mid way, reopen the screen and click **Run this step** on the catalogue row.
It resumes without duplicating anything.

Every step is safe to run again. Re running updates existing content rather
than creating a second copy.

---

## Step 5: check the result

Visit your site. You should see:

- A home page with a hero, category grid, service grid, process steps and ten
  questions and answers
- A shop at `/shop/` with categories at `/plant-gifts/<category>/`
- Products at `/plant-gift/<product>/` with pot size, material and design
  dropdowns that change the price
- Ten service pages, each with a table of contents and ten questions

If categories 404, go to **Settings, Permalinks** and click **Save Changes**
once. That flushes the rewrite rules.

---

## Step 6: make it yours

### Business details

**Appearance, Customize, PlantGift Pro options**:

- **Contact details**: phone, email, working hours, address, top bar message
- **Home page hero**: heading, paragraph, hero image, header button
- **Footer and social**: footer text, column headings, social links
- **Business information for search engines**: registered name, city, state,
  postcode, country code, price range. These feed the Organization structured
  data, so fill them in before launch

### Logo

**Appearance, Customize, Site Identity**. Upload a logo around 240 by 64
pixels. Without one, the theme prints your site name beside a leaf mark.

### Images

The setup generates gradient placeholders so nothing looks broken. Replace them
with real photography:

- **Categories**: Products, Categories, edit each one, change the thumbnail
- **Products**: edit each product, set the featured image and gallery
- **Hero**: Customize, Home page hero, hero image

Use 1200 by 1200 pixel square images for products, and compress them before
upload. Image weight is the single biggest page speed factor on a store like
this one.

### Prices

The generated prices are placeholders built from a base price plus modifiers
for each pot size, material and design. Review them against your real costs:

1. Products, then open any product
2. **Variations** tab
3. Edit prices individually, or use the bulk actions dropdown to shift all
   variation prices by a percentage or a fixed amount

### WooCommerce settings

- **WooCommerce, Settings, General**: currency, selling locations
- **WooCommerce, Settings, Tax**: your GST or VAT rules
- **WooCommerce, Settings, Shipping**: zones and rates, including the per
  shipment charge if you offer individual home delivery
- **WooCommerce, Settings, Payments**: gateways

---

## Optional: an SEO plugin

The theme and plugin ship with their own light SEO layer: meta descriptions,
canonicals, Open Graph, robots rules and structured data. It is enough to
launch with.

If you install Yoast SEO, Rank Math, SEOPress or All in One SEO, the built in
layer **detects them and steps aside automatically** so nothing is output
twice. The stored meta titles and descriptions are handed to Yoast and Rank
Math as fallbacks, so no content is lost.

Structured data behaviour with an SEO plugin active:

- Organization, WebSite and BreadcrumbList: handled by your SEO plugin
- FAQPage, Service and ItemList: still handled by PlantGift Core, because SEO
  plugins do not generate these from the stored content

---

## Troubleshooting

**The catalogue step stalls or errors**
Usually a PHP timeout or memory limit. Raise `max_execution_time` to 120 and
`memory_limit` to 256M, then click **Run this step** again. It resumes from
where it stopped.

**Category pages return 404**
Settings, Permalinks, Save Changes.

**Variation dropdowns show no options**
The attributes step did not finish. Run it again, then run the catalogue step
again.

**Placeholder images are missing**
The PHP GD extension is not installed. Ask your host to enable it, or upload
your own images, which you were going to do anyway.

**Prices show as a range rather than a single figure**
That is correct for a variable product. The price resolves once the shopper
picks a size, material and design.

**I want to start over**
PlantGift setup screen, bottom of the page, **Delete generated content**. This
removes the generated categories, products and pages. Attributes, menus and
settings are left in place so you can rebuild quickly.

---

## Uninstalling

Deactivating the plugin leaves all content in place, since it is normal
WordPress and WooCommerce data. To remove the generated content first, use the
**Delete generated content** button, then deactivate and delete.
