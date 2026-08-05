# URL structure and site map

## Permalink settings applied by the setup

```
WordPress permalink structure    /%postname%/
WooCommerce product base         /plant-gift
WooCommerce category base        plant-gifts
WooCommerce tag base             plant-tag
WooCommerce attribute base       (empty, attribute archives disabled)
```

Two deliberate choices worth understanding before you change them.

**Why `/plant-gift/` and not `/product/`.** The default WooCommerce base
contributes nothing. A keyword relevant base adds a small but real signal and
reads better when a URL is pasted into an email or a WhatsApp message.

**Why categories are one level deep, not nested.** WooCommerce nests child
categories into the URL, so a two level tree produces
`/plant-gifts/occasions/diwali-corporate-plant-gifts/`. That is longer, dilutes
the keyword position and makes future restructuring painful. Keeping all
eighteen categories at the top level gives every one of them a short,
keyword led URL.

---

## Full URL map

### Service pages

| URL | Page | Targets |
|---|---|---|
| `/corporate-plant-gifting/` | Corporate Plant Gifting for Employees, Clients and Events | corporate plant gifting |
| `/bulk-plant-gifts-for-companies/` | Bulk Plant Gifts for Companies | bulk plant gifts for companies |
| `/custom-branded-planters/` | Custom Branded Planters and Logo Printed Pots | custom branded planters |
| `/employee-onboarding-plant-gifts/` | Employee Onboarding Plant Gifts and Welcome Kits | employee onboarding plant gifts |
| `/client-gifting-programme/` | Client Gifting Programme with Live Plants | client gifting plants |
| `/event-plant-giveaway-service/` | Event Plant Giveaway Service | event plant giveaways |
| `/festival-corporate-plant-gifts/` | Festival and Diwali Corporate Plant Gifts | diwali corporate plant gifts |
| `/office-plant-subscription/` | Office Plant Subscription and Maintenance | office plant subscription |
| `/plant-care-guide/` | Plant Care Guide for Office and Desk Plants | office plant care guide |
| `/pan-india-plant-delivery/` | Pan India Plant Delivery for Corporate Orders | pan india plant delivery |

### Product categories

| URL | Category |
|---|---|
| `/plant-gifts/succulent-corporate-gifts/` | Succulent Corporate Gifts |
| `/plant-gifts/air-plant-gifts/` | Air Plant Gifts |
| `/plant-gifts/desk-plants-for-office/` | Desk Plants for Office |
| `/plant-gifts/air-purifying-plant-gifts/` | Air Purifying Plant Gifts |
| `/plant-gifts/bonsai-corporate-gifts/` | Bonsai Corporate Gifts |
| `/plant-gifts/lucky-bamboo-gifts/` | Lucky Bamboo Gifts |
| `/plant-gifts/money-plant-gifts/` | Money Plant Gifts |
| `/plant-gifts/terrarium-gift-sets/` | Terrarium Gift Sets |
| `/plant-gifts/low-maintenance-plant-gifts/` | Low Maintenance Plant Gifts |
| `/plant-gifts/flowering-plant-gifts/` | Flowering Plant Gifts |
| `/plant-gifts/hanging-plant-gifts/` | Hanging Plant Gifts |
| `/plant-gifts/plant-gift-hampers/` | Plant Gift Hampers |
| `/plant-gifts/employee-welcome-kit-plants/` | Employee Welcome Kit Plants |
| `/plant-gifts/work-anniversary-plant-gifts/` | Work Anniversary Plant Gifts |
| `/plant-gifts/client-appreciation-plant-gifts/` | Client Appreciation Plant Gifts |
| `/plant-gifts/corporate-event-plant-giveaways/` | Corporate Event Plant Giveaways |
| `/plant-gifts/diwali-corporate-plant-gifts/` | Diwali Corporate Plant Gifts |
| `/plant-gifts/branded-logo-planters/` | Branded Logo Planters |

### Core pages

| URL | Page |
|---|---|
| `/` | Home |
| `/shop/` | Shop, all products |
| `/about-us/` | About Our Corporate Plant Gifting Studio |
| `/contact/` | Contact the Corporate Gifting Desk |
| `/faq/` | Frequently Asked Questions About Corporate Plant Gifts |
| `/blog/` | Plant Gifting Journal |
| `/shipping-and-returns/` | Shipping, Delivery and Replacement Policy |
| `/privacy-policy/` | Privacy Policy |
| `/terms-and-conditions/` | Terms and Conditions |
| `/cart/`, `/checkout/`, `/my-account/` | WooCommerce, noindexed via robots.txt |

### Products

All 43 products live at `/plant-gift/<slug>/`. Examples:

```
/plant-gift/haworthia-zebra-succulent-desk-gift/
/plant-gift/tillandsia-ionantha-air-plant-gift/
/plant-gift/snake-plant-air-purifying-desk-gift/
/plant-gift/ficus-bonsai-corporate-gift/
/plant-gift/logo-engraved-ceramic-planter-succulent/
```

---

## Slug rules used throughout

1. **Lowercase, hyphen separated, no underscores.**
2. **Keyword first, qualifier second.** `succulent-corporate-gifts`, not
   `corporate-gifts-succulent`.
3. **No stop words.** No "for", "the", "and" unless removing them changes the
   meaning, as in `desk-plants-for-office`.
4. **Three to five words.** Long enough to be descriptive, short enough to
   paste into a message without wrapping.
5. **No dates, no years.** A slug with 2026 in it needs replacing next year.
6. **No category prefix on service pages.** They sit at the root because they
   are top level commercial pages, not products.
7. **British or American spelling, pick one and hold it.** This build uses
   British spelling in body copy and neutral spelling in slugs.

---

## Internal linking design

The link graph is built so authority flows toward the commercial pages without
any page being orphaned.

```
Home
 ├─→ all 18 category pages (category grid)
 ├─→ 8 service pages (service grid)
 └─→ /corporate-plant-gifting/ (header button, hero, footer CTA)

/corporate-plant-gifting/  (the hub)
 ├─→ 4 related category pages (sidebar)
 ├─→ every other service page (sidebar "Other gifting services")
 └─→ /contact/

Each service page
 ├─→ its related categories (sidebar)
 ├─→ sibling service pages (sidebar)
 └─→ /contact/ (hero button, sidebar, footer CTA)

Each category page
 ├─→ its products (grid)
 ├─→ sibling categories (pill row)
 └─→ /bulk-plant-gifts-for-companies/ (body copy)

Each product page
 ├─→ its categories (breadcrumb, product meta)
 ├─→ /bulk-plant-gifts-for-companies/ (bulk pricing panel)
 └─→ 4 related products

Footer (on every page)
 ├─→ 6 categories
 ├─→ 10 service pages
 ├─→ 5 company pages
 └─→ 3 legal pages
```

Every page is reachable within three clicks of the home page, and no page has
fewer than four internal links pointing at it.

---

## Redirects to set up if you are replacing an existing site

If this is going over an existing store, map the old URLs before you launch.
Use a redirect plugin such as Redirection, or server level rules.

```
Old WooCommerce defaults, if you had them
/product/<slug>/          -> /plant-gift/<slug>/
/product-category/<slug>/ -> /plant-gifts/<slug>/
```

WooCommerce inserts these redirects automatically when you change the
permalink bases on an existing store, but verify a sample of them rather than
assuming.

**Do not skip this.** Changing permalink bases on a site with existing rankings
without redirects is the fastest way to lose them.

---

## Sitemap

WordPress core generates `/wp-sitemap.xml`. The plugin adjusts it to:

- exclude product variations, which should never be indexed on their own
- exclude attribute archives, which are disabled anyway
- include product categories

The generated `robots.txt` points at the sitemap and blocks cart, checkout,
account, add to cart links, sort parameters and filter parameters.

If you install Yoast or Rank Math, they take over sitemap generation. Submit
whichever sitemap is live to Google Search Console, not both.
