# Content map, heading structure and SEO implementation

## What is in the build

| Item | Count |
|---|---|
| Product categories with long form copy | 18 |
| Products (variable) | 43 |
| Product variations (pot size x material x design) | 550 |
| Service pages | 10 |
| Core pages (home, about, contact, FAQ, journal, policies) | 8 |
| Questions and answers | 210 |
| Global attributes | 6 |
| Attribute options | 34 |
| Words of body copy | approx 23,500 |

Question and answer breakdown: 100 across the ten service pages (ten each), 90
across the categories (five each), 10 on the home page and 10 on the FAQ page.

---

## Heading structure

Every page follows the same hierarchy. Exactly one H1, no skipped levels, and
headings used for structure rather than for styling.

### Service pages

```
H1  Page title, carries the focus keyword
    (intro paragraph, focus keyword appears once in the first 100 words)
H2  Main section
    H3  Sub topic
        H4  Specific detail or a named option
    H3  Sub topic
H2  Main section
    H3  Sub topic
H2  Frequently asked questions
    (ten questions rendered as an accordion, plus FAQPage schema)
```

Live example, `/corporate-plant-gifting/`:

```
H1  Corporate Plant Gifting for Employees, Clients and Events
H2  What our corporate plant gifting service actually covers
    H3  Curation against your real constraints
    H3  Pot selection and branding
        H4  Size
        H4  Material
        H4  Branding method
    H3  Growing, hardening and potting
    H3  Packing that survives a courier
    H3  Delivery, tracking and the aftermath
H2  Who this service is built for
    H3  Human resources and people teams
    H3  Marketing and events teams
    H3  Account and relationship teams
    H3  Facilities and workplace teams
H2  How an order runs, start to finish
    H3  Step one: the brief
    ... through step five
H2  Pricing structure
H2  What we will tell you not to do
H2  Frequently asked questions
```

### Category pages

```
H1  Category name (rendered by the theme)
    (intro paragraph under the H1)
    [product grid]
H2  Opening section explaining the category
    H3  Sub topic
        H4  Specific plant, material or option
    H3  Sub topic
H2  Frequently asked questions
```

The long form copy sits **below** the product grid deliberately. Shoppers reach
the catalogue immediately, and search engines still index the full page. This
is the pattern that top ranking category pages use.

### Product pages

```
H1  Product name
H2  Opening statement about the plant
    H3  Sub topic, for example what arrives in the box
        H4  Water
        H4  Light
        H4  The mistake to avoid
```

---

## Meta titles and descriptions

Every category, service page and product ships with a written meta title and
description stored in post or term meta.

Rules applied:

- **Meta title** under 60 characters, keyword near the front, no site name in
  the stored value since WordPress appends it
- **Meta description** 140 to 158 characters, leads with the benefit, names the
  service once, ends with a concrete detail rather than a call to action

Example:

```
Title:  Succulent Corporate Gifts for Employees and Clients
Desc:   Low maintenance succulent gifts for teams, clients and events. Pick
        the pot size, material and design, add your logo and order from 25 units.
```

Edit these at:
- **Categories**: Products, Categories, edit a category
- **Pages**: the "Questions and answers" box on the page editor
- **Products**: the "Search snippet" box on the product editor (only shown when
  no dedicated SEO plugin is active)

---

## Structured data

| Type | Where | Emitted by |
|---|---|---|
| Organization | Home page | Theme (steps aside for SEO plugins) |
| WebSite with SearchAction | Home page | Theme (steps aside for SEO plugins) |
| BreadcrumbList | All inner pages | Theme (steps aside for SEO plugins) |
| FAQPage | Home, FAQ, service pages, category pages | Plugin, always |
| Service with OfferCatalog | Service pages | Plugin, always |
| ItemList | Category archives | Plugin, always |
| Product with Offer and AggregateRating | Product pages | WooCommerce |
| Product additionalProperty (pot size, material, design, plant type, light) | Product pages | Plugin, extends WooCommerce output |

FAQPage is printed **once per page** even if several FAQ blocks are rendered.
Google only reads one, and stacking them is an error.

Validate after launch with the Rich Results Test and the Schema Markup
Validator.

---

## Writing rules followed throughout

These were applied to every word in the build.

1. **No em dashes.** Zero occurrences. Verified programmatically.
2. **No en dashes.** Zero occurrences. Verified programmatically.
3. **Hyphens only inside genuinely hyphenated words**, not as sentence
   punctuation.
4. **No keyword stuffing.** The focus keyword appears in the H1, one H2, the
   first paragraph, the meta title, the meta description and the slug. Body
   density sits around 0.5 to 1.0 percent and is reached naturally.
5. **Specific over vague.** "Water every twelve to fourteen days" rather than
   "water occasionally". Every claim that can carry a number carries one.
6. **Honest about limits.** The air purifying category states plainly that a
   handful of plants will not measurably change the air in a large office. The
   bonsai pages say a Carmona is difficult. The low maintenance page names the
   plants we refuse to ship. Content that acknowledges limits is more credible
   to readers and more citable by AI systems.
7. **Second person, active voice.** "Send us your headcount", not "headcount
   should be provided".
8. **Short paragraphs.** Two to four sentences, because most of this is read on
   a phone.
9. **No filler openers.** No "In today's fast paced world", no "As we all
   know". Every section starts with something the reader did not already know.

---

## Generative engine optimisation

Choices made specifically so AI answer engines can use this content.

**Answer first structure.** Every one of the 210 answers opens with the direct
answer, then explains. Retrieval systems extract the first sentence.

**Chunk independence.** Each H2 section stands alone. If a system pulls only
the "Timing, which is the whole game" section from the festive page, it still
makes complete sense without the surrounding page.

**Facts in tables.** Watering intervals by species, pot sizes by use case,
transit times by destination, pricing slabs by quantity, branding minimums by
method. Tables parse far more reliably than the same facts in prose.

**Named entities throughout.** Species names are given in full, both common and
botanical. Pot materials, branding methods, occasions and cities are named
rather than implied. This is what lets a model connect your page to a query it
has never seen.

**Verifiable specificity.** Numbers, intervals, minimum quantities and lead
times are stated concretely. Generic content is not quotable.

**Stated trade offs.** Sections such as "What we will tell you not to do" and
"Where bulk gifting budgets usually go wrong" give a model something to cite
that a purely promotional page cannot provide.

---

## Editing the content after install

### Category copy

Products, Categories, edit any category. You get five fields:

- **Meta title** and **Meta description**, for search results
- **Intro under the H1**, one or two sentences above the product grid
- **Long form body**, HTML, rendered below the grid. Start headings at H2
- **Questions and answers**, plain text format

### Page copy

Edit the page normally in the block editor. Below the content you get:

- **Questions and answers**, the same plain text format
- **Eyebrow label**, the small text above the H1
- **Highlight strip**, up to four comma separated points
- **Related category slugs**, comma separated, shown in the sidebar and in the
  Service structured data
- **Meta title**

### The questions and answers format

```
Q: What is the minimum order for corporate plant gifts?
A: Bulk pricing starts at 25 units. Below that you can order at listed retail
prices directly from any product page.

Q: How long does an order take?
A: Ten to twelve working days for unbranded plants in stock pots.
```

Questions start with `Q:`, answers with `A:`, blocks separated by a blank line.
Answers can wrap across lines. Everything is rendered as an accordion and
published as FAQPage schema.

---

## Shortcodes

Drop these into any page or post.

| Shortcode | What it does |
|---|---|
| `[plantgift_categories limit="8" columns="4"]` | Category card grid |
| `[plantgift_categories slugs="air-plant-gifts,bonsai-corporate-gifts"]` | Specific categories |
| `[plantgift_faq page="bulk-plant-gifts-for-companies"]` | Pull another page's questions in |
| `[plantgift_faq category="succulent-corporate-gifts" title="Common questions"]` | Pull a category's questions in |
| `[plantgift_bulk_table]` | The five quantity slabs |
| `[plantgift_pot_guide]` | Pot size to use case table |
| `[plantgift_cta title="..." button="..." url="..."]Text[/plantgift_cta]` | Call to action block |
