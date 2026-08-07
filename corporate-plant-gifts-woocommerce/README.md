# Corporate Plant Gifts, WooCommerce store package

A complete, ready to upload WordPress and WooCommerce store for selling plants
as corporate gifts, with the catalogue, the pot variants, the service pages and
the SEO content already written.

---

## What is in this package

```
corporate-plant-gifts-woocommerce/
├── README.md                      you are here
├── theme/
│   └── plantgift-pro.zip          upload at Appearance, Themes, Add New
├── plugin/
│   └── plantgift-core.zip         upload at Plugins, Add New
├── tools/
│   ├── swap-font.sh               change the site font in one command
│   └── install-font.py            the installer it calls
├── docs/
│   ├── 01-INSTALLATION.md         start here
│   ├── 02-KEYWORD-RESEARCH.md     clusters, intent and the keyword to URL map
│   ├── 03-URL-STRUCTURE.md        every URL, slug rules, internal link graph
│   ├── 04-CONTENT-AND-SEO.md      heading structure, schema, editing guide
│   ├── 05-LAUNCH-CHECKLIST.md     what to do before going live
│   ├── 06-DESIGN-SYSTEM.md        every colour, font and component explained
│   ├── colour-system.png          visual palette sheet with contrast data
│   └── keyword-seed-list.csv      120 keywords mapped to target URLs
└── source/                        unpacked theme and plugin, for editing
```

---

## Quick start

1. Install and activate **WooCommerce**
2. Upload and activate `theme/plantgift-pro.zip`
3. Upload and activate `plugin/plantgift-core.zip`
4. On the **PlantGift** admin screen, click **Run every step**
5. Wait for the catalogue step to finish, roughly two to six minutes
6. Open your site

Full detail, including requirements and troubleshooting, is in
`docs/01-INSTALLATION.md`.

---

## What gets built

| | |
|---|---|
| Product categories | 18, each with a written intro, long form body copy and five questions and answers |
| Products | 43 variable products |
| Variations | 550 combinations of pot size, pot material and pot design |
| Service pages | 10, each with ten questions and answers |
| Core pages | Home, About, Contact, FAQ, Journal, Shipping, Privacy, Terms |
| Questions and answers | 210 in total, all published as FAQPage structured data |
| Global attributes | Pot size, pot material, pot design, plant type, light requirement, gift packaging |
| Body copy | Approximately 23,500 words, all original |
| Menus | Primary with dropdowns, three footer columns, legal menu |

### The pot variant system

Every product is a variable product. The shopper chooses:

- **Pot size**: 3, 4, 5, 6 and 8 inch
- **Pot material**: glazed ceramic, natural terracotta, self watering, brushed
  metal, jute wrapped, glass terrarium, cast concrete
- **Pot design**: matte plain, glossy two tone, geometric facet, minimal white,
  hand painted, textured ribbed, logo engraved, custom brand printed

The price updates as the selection changes, driven by per option price
modifiers you can edit from the attribute term screens.

Two further attributes, **plant type** and **light requirement**, are shown in
the product details tab and included in the Product structured data, but they
do not create variations.

---

## SEO built in

- **Keyword led slugs**, one owner page per keyword, mapped in
  `docs/02-KEYWORD-RESEARCH.md` so nothing cannibalises anything else
- **Full H1 to H4 structure** on every service page, category page and product
- **Written meta titles and descriptions** on all categories, service pages and
  products, editable from the admin
- **Structured data**: Organization, WebSite, BreadcrumbList, FAQPage, Service
  with OfferCatalog, ItemList, and Product extended with the pot attributes
- **Core sitemap tuned** to exclude variations and attribute archives
- **robots.txt rules** for cart, checkout, account and filter parameters
- **Steps aside for Yoast, Rank Math, SEOPress and All in One SEO**
  automatically, so nothing is ever emitted twice

### Content rules applied

- No em dashes and no en dashes anywhere, verified programmatically
- No keyword stuffing. Focus keyword in the H1, one H2, the opening paragraph,
  the meta title, the meta description and the slug. Nothing more
- Concrete numbers instead of vague advice, throughout
- Stated limitations where the honest answer is a qualified one, which reads
  better to humans and is more citable by AI answer engines
- Answer first structure on all 210 questions

---

## Design system

Built from the two palettes you supplied. All five of your exact hex values are
used unchanged: `19381F`, `EEE82C`, `91CB3E`, `53A548`, `4C934C`, extended into
a full scale so body text, borders and hover states stay readable.

**The colour rule that shapes everything.** Your two brightest values fail as
text: `EEE82C` measures 1.30:1 on white and `91CB3E` measures 1.94:1. So they
are used as **fills with near black text on top**, which turns the weakness into
the strongest asset on the page. The primary button is yellow with `#14201A`
text at **12.96:1, AAA**, and it is the highest contrast object on any screen.

Four button levels, used strictly:

| Level | Look | Contrast | Where |
|---|---|---|---|
| Primary | Yellow fill, near black text, 4px hard shadow | 12.96:1 | One per screen. Get a quote, Add to cart |
| Secondary | Forest `19381F` fill, white text | 12.91:1 | Browse catalogue, View category |
| Tertiary | Ghost, forest text, soft green border | 10.13:1 | Alternate paths |
| Urgent | Ember fill, white text | 4.93:1 | Festive cut off dates only |

**Typography.** Montserrat across headings and body, in Regular, SemiBold, Bold
and Italic. SIL Open Font Licence, self hosted, subset to Latin and Latin
Extended A, served as WOFF2. **62 KB total**, with Regular and Bold preloaded.
No Google Fonts at runtime, no external requests anywhere on the site.

The files are built from the complete family rather than the Google Fonts CSS
API, because that API's Latin subset omits the rupee sign and every price on
the store would fall back to a system font mid-line.

Changing the font is one command, with no CSS edits:

```bash
./tools/swap-font.sh "Poppins"
```

Full reference with every hex, RGB, HSL, contrast ratio and usage rule is in
`docs/06-DESIGN-SYSTEM.md`, with a visual sheet at `docs/colour-system.png`.

## Built to convert

- **Sticky action bar on phones** with call, WhatsApp and the primary action.
  Appears after a scroll, hides over the footer. On a product page it scrolls
  back to the pot picker and moves keyboard focus there
- **Floating quote button on desktop**, same reveal logic
- **WhatsApp integration** with a prefilled message, set from the Customizer
- **Value strip** under the hero and every category header, answering the four
  objections a corporate buyer has before they will click anything
- **Hero benefit pills and star rating** above the fold
- **Pot options tag** on variable product cards, so shoppers know there is a
  choice before they open the product
- **Reassurance line under add to cart** covering the replacement promise and
  the bulk threshold, placed exactly where hesitation happens
- **Testimonial section** with star ratings, ready for your real client quotes
- **Sticky sidebar quote card** that follows the reader down long service pages

## Front end quality

- Responsive from 320px upward, with a proper mobile drawer navigation
- Accessible: skip link, 3px focus rings, 44px touch targets, keyboard operable
  menu and accordions, AAA contrast on body text, reduced motion support
- FAQ uses native `<details>`, so it works with JavaScript disabled
- Print stylesheet
- Block editor styles and `theme.json` matched to the front end, so the editor
  preview looks like the published page

Performance work included: emoji scripts removed, block library CSS dropped on
pages without blocks, cart fragments dequeued outside shop pages, the theme
script deferred, fonts preloaded, the first image kept eager with high fetch
priority, and realistic `sizes` attributes on card images.

---

## Editing after install

Everything is normal WordPress and WooCommerce data. There is no proprietary
storage and no lock in.

- **Category copy**: Products, Categories, edit any category. Meta title, meta
  description, intro, long form body and questions all have their own fields
- **Page copy**: the block editor, plus a box below the content for questions,
  eyebrow label, highlight strip, related categories and meta title
- **Prices**: the Variations tab on any product, with bulk actions for shifting
  every variation at once
- **Design**: Appearance, Customize. Colours are CSS custom properties on
  `:root` in `assets/css/main.css`, with a semantic layer so changing one line
  retones the whole site
- **Shortcodes** for category grids, FAQ blocks, the bulk pricing table, the pot
  size guide and CTA blocks. Listed in `docs/04-CONTENT-AND-SEO.md`

---

## Before you go live

Three things genuinely must not be skipped:

1. **Replace the placeholder images.** The setup generates gradient tiles so
   nothing looks broken, but they are not photography
2. **Review the prices.** They are generated from a base plus modifiers and are
   placeholders, not a pricing strategy
3. **Replace the placeholder details in the Privacy Policy and Terms pages**,
   and have them reviewed by a qualified adviser
4. **Replace the placeholder testimonials** on the home page with real client
   quotes. Named people and companies convert considerably better than
   anonymous job titles

The keyword volume figures in the research document are **estimated bands from
SERP research, not measured data**. No paid keyword API was available when this
was built. Run `docs/keyword-seed-list.csv` through Google Keyword Planner or
SemRush for your market before committing budget. The clusters, the intent
classification and the URL mapping are reliable regardless.

The full pre launch list is in `docs/05-LAUNCH-CHECKLIST.md`.

---

## Requirements

- WordPress 6.0 or newer
- PHP 7.4 or newer, 8.1 or 8.2 recommended
- WooCommerce 7.0 or newer
- PHP GD extension, for the generated placeholder images. Optional
- 128MB PHP memory minimum, 256MB recommended for the catalogue build

Compatible with WooCommerce High Performance Order Storage and the cart and
checkout blocks.

---

## Licence

GPL v2 or later, matching WordPress and WooCommerce.
