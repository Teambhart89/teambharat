# Design system: colours, typography and conversion components

Everything in this document is already built into the theme. This is the
reference for what each value is, why it is that value, and where you are and
are not allowed to use it.

---

## 1. Where the palette came from

You supplied two references. Both are used, and they do different jobs.

**Reference one** gave the deep forest to bright leaf greens plus a warm earth
row of terracotta, clay, blush and warm grey. That is a brand identity palette:
it says plants, pots and craft.

**Reference two** gave five exact values: `19381F`, `EEE82C`, `91CB3E`,
`53A548`, `4C934C`. That set is more energetic and includes a vivid yellow that
the first palette has no answer to.

The system merges them like this:

| Source | Role in the system |
|---|---|
| `19381F` (yours, exact) | The brand green. Headers, dark sections, secondary buttons |
| `4C934C`, `53A548` (yours, exact) | The mid green scale for accents and states |
| `91CB3E` (yours, exact) | The freshness accent. Rules, check marks, dark section highlights |
| `EEE82C` (yours, exact) | The single attention colour. Every primary action on the site |
| Forest greens from reference one | Extended into a full 11 step scale so text stays readable |
| Terracotta and orange from reference one | Urgency, bulk pricing panels, sale badges, pot cues |
| Clay and blush from reference one | Warm neutral surfaces so the site is not all green and white |
| Warm grey `6F6A6D` from reference one | Kept as a neutral for secondary UI |

All five of your exact hex values survive unchanged. The rest of the scale
exists because a five colour palette cannot carry an entire store: you need
readable body text, hairlines, disabled states and hover states, and those have
to be derived rather than guessed.

---

## 2. The rule that matters most

Your two brightest colours, `EEE82C` and `91CB3E`, are beautiful and almost
unreadable as text.

| Colour | Contrast on white | Verdict |
|---|---|---|
| `EEE82C` yellow | **1.30:1** | Fails badly. Never use as text |
| `91CB3E` lime | **1.94:1** | Fails. Never use as text |
| `53A548` leaf | 3.07:1 | Large text only, never body copy |
| `4C934C` green | 3.76:1 | Large text only, never body copy |
| `19381F` forest | 12.91:1 | Safe anywhere |

WCAG AA needs 4.5:1 for body text and 3:1 for large text. So the system splits
every colour into one of two groups:

**Fill only colours.** Used as backgrounds with dark text on top. Never as text,
never as an icon on a light background, never as a thin border on white.
`EEE82C`, `91CB3E`, `E27B3A`, `F6F274`, and every tint below 300.

**Text safe colours.** `19381F`, `1F4A2B`, `286539`, `14201A`, `26332C`,
`55655C`, `B4551D`, `6E3C27`.

This is why the primary button is a **yellow fill with near black text**, which
measures 12.96:1, rather than yellow text on anything. You get the maximum
possible attention and AAA accessibility from the same decision.

---

## 3. Full colour reference

Every value below is a CSS custom property on `:root`. Change it there and it
changes everywhere.

### Forest greens: the brand spine

| Token | Hex | RGB | HSL | On white | Use for |
|---|---|---|---|---|---|
| `--pg-forest-950` | `#0B2412` | 11, 36, 18 | 137° 53% 9% | 16.47:1 | Footer, dark sections, CTA panels |
| `--pg-forest-900` | `#19381F` | 25, 56, 31 | 132° 38% 16% | 12.91:1 | **Brand colour.** Secondary buttons, logo mark, table headers |
| `--pg-forest-800` | `#1F4A2B` | 31, 74, 43 | 137° 41% 21% | 10.13:1 | Button hover, H4 headings, strong text |
| `--pg-forest-700` | `#286539` | 40, 101, 57 | 137° 43% 28% | 6.97:1 | **Links**, prices, eyebrow labels |
| `--pg-forest-600` | `#33874A` | 51, 135, 74 | 136° 45% 36% | 4.46:1 | Icons, focus rings, form borders on focus |
| `--pg-forest-500` | `#4C934C` | 76, 147, 76 | 120° 32% 44% | 3.76:1 | List markers, decorative. Not body text |
| `--pg-forest-400` | `#53A548` | 83, 165, 72 | 113° 39% 46% | 3.07:1 | Hover borders, decorative. Not body text |
| `--pg-forest-300` | `#7FBE68` | 127, 190, 104 | 104° 40% 58% | 2.22:1 | Step numbers, dividers. Fill only |
| `--pg-forest-200` | `#AEDCA1` | 174, 220, 161 | 107° 46% 75% | 1.55:1 | Ghost button borders. Fill only |
| `--pg-forest-100` | `#D9EFCF` | 217, 239, 207 | 101° 50% 87% | 1.22:1 | Card tints, dark section text |
| `--pg-forest-50` | `#F1F8EE` | 241, 248, 238 | 102° 42% 95% | 1.08:1 | Section backgrounds, hover fills |

### Lime accent, from your `91CB3E`

| Token | Hex | RGB | HSL | Use for |
|---|---|---|---|---|
| `--pg-lime-700` | `#5E8F22` | 94, 143, 34 | 87° 62% 35% | Text safe version at 3.87:1, large text only |
| `--pg-lime-600` | `#74AC2E` | 116, 172, 46 | 87° 58% 43% | Deep fills, hover on lime elements |
| `--pg-lime-500` | `#91CB3E` | 145, 203, 62 | 85° 58% 52% | **Your value.** Eyebrow rules, check marks, active tab underline, logo leaf |
| `--pg-lime-300` | `#B9E077` | 185, 224, 119 | 82° 63% 67% | Links inside dark sections, 10.97:1 on forest-950 |
| `--pg-lime-100` | `#E9F7D2` | 233, 247, 210 | 83° 70% 90% | Hero glow, icon backgrounds |

### Signal yellow, from your `EEE82C`

This is the most important colour in the system and the most disciplined. It
appears **only** on the single primary action in any given view. That scarcity
is what makes it work. Use it on five things per page and it stops meaning
anything.

| Token | Hex | RGB | HSL | Use for |
|---|---|---|---|---|
| `--pg-yellow-700` | `#9C9A12` | 156, 154, 18 | 59° 79% 34% | The 4px hard shadow under primary buttons |
| `--pg-yellow-600` | `#CBC61E` | 203, 198, 30 | 58° 74% 46% | Pressed state |
| `--pg-yellow-500` | `#EEE82C` | 238, 232, 44 | 58° 85% 55% | **Your value.** Primary buttons, sale badges, hero ribbon, skip link |
| `--pg-yellow-300` | `#F6F274` | 246, 242, 116 | 58° 88% 71% | Button hover, text highlight marker |
| `--pg-yellow-100` | `#FCFBD6` | 252, 251, 214 | 58° 86% 91% | Very light callout backgrounds |

**Contrast when used correctly:** `#14201A` on `#EEE82C` is **12.96:1 (AAA)`.
`#19381F` on `#EEE82C` is 9.97:1 (AAA). Both are safe.

### Ember and clay: warmth, urgency, pots

Taken from the terracotta row of your first reference. This family stops the
site being green and white only, and it carries every "act now" signal so that
green never has to.

| Token | Hex | RGB | HSL | Use for |
|---|---|---|---|---|
| `--pg-ember-700` | `#B4551D` | 180, 85, 29 | 22° 72% 41% | Urgent buttons with white text, 4.93:1 |
| `--pg-ember-600` | `#D0692A` | 208, 105, 42 | 23° 66% 49% | Cart count badge, bulk panel accent border |
| `--pg-ember-500` | `#E27B3A` | 226, 123, 58 | 23° 74% 56% | Star ratings, decorative fills. **Fill only**, white text on it fails at 2.95:1 |
| `--pg-ember-200` | `#F8DCC6` | 248, 220, 198 | 26° 78% 87% | Urgency callout backgrounds |
| `--pg-clay-800` | `#6E3C27` | 110, 60, 39 | 18° 48% 29% | Text on clay and ember backgrounds, 8.98:1 |
| `--pg-clay-700` | `#8F5138` | 143, 81, 56 | 17° 44% 39% | Secondary text on clay surfaces |
| `--pg-clay-600` | `#A5674A` | 165, 103, 74 | 19° 38% 47% | Decorative, pot colour cues |
| `--pg-clay-400` | `#C7A492` | 199, 164, 146 | 20° 32% 68% | Soft dividers on warm surfaces |
| `--pg-clay-200` | `#EBD9CD` | 235, 217, 205 | 24° 43% 86% | Prefooter borders |
| `--pg-clay-100` | `#F6ECE4` | 246, 236, 228 | 27° 50% 93% | Prefooter background, bulk pricing panel |

### Neutrals

| Token | Hex | RGB | HSL | On white | Use for |
|---|---|---|---|---|---|
| `--pg-ink-900` | `#14201A` | 20, 32, 26 | 150° 23% 10% | 16.78:1 | Headings, text on yellow buttons |
| `--pg-ink-800` | `#26332C` | 38, 51, 44 | 148° 15% 17% | 13.19:1 | **Body text** |
| `--pg-ink-700` | `#3B4B42` | 59, 75, 66 | 146° 12% 26% | 9.25:1 | Secondary body, lede paragraphs |
| `--pg-ink-600` | `#55655C` | 85, 101, 92 | 146° 9% 36% | 6.17:1 | Muted text, captions, metadata |
| `--pg-ink-500` | `#6F6A6D` | 111, 106, 109 | 324° 2% 43% | 5.31:1 | The warm grey from your reference. Logo placeholders |
| `--pg-ink-400` | `#8B978F` | 139, 151, 143 | 140° 5% 57% | 3.03:1 | Placeholder text, struck through prices. Not body copy |
| `--pg-line` | `#E4E9E3` | 228, 233, 227 | 110° 12% 90% | 1.23:1 | Borders, dividers |
| `--pg-line-soft` | `#EFF3EE` | 239, 243, 238 | 108° 17% 94% | 1.12:1 | Inner dividers |
| `--pg-sand` | `#FBF6F1` | 251, 246, 241 | 30° 56% 96% | 1.07:1 | Alternate section background, sidebar cards |
| `--pg-paper` | `#FFFFFF` | 255, 255, 255 | 0° 0% 100% | 1.00:1 | Page background, cards |

Note the neutrals are green tinted rather than pure grey. Body text at `#26332C`
sits at 148° hue, which reads as calm and slightly organic beside the greens.
A pure `#333333` next to this palette looks cold and slightly dirty.

---

## 4. Semantic tokens

You should not reach for the raw scale in day to day work. Use these instead,
because changing one of them retones the whole site consistently.

```css
--pg-bg          : var(--pg-paper);        /* page background          */
--pg-bg-alt      : var(--pg-sand);         /* alternate sections       */
--pg-bg-tint     : var(--pg-forest-50);    /* mint sections            */
--pg-bg-dark     : var(--pg-forest-950);   /* dark sections and footer */

--pg-text        : var(--pg-ink-800);      /* body copy                */
--pg-heading     : var(--pg-ink-900);      /* headings                 */
--pg-muted       : var(--pg-ink-600);      /* captions, metadata       */
--pg-link        : var(--pg-forest-700);
--pg-link-hover  : var(--pg-forest-600);

--pg-brand       : var(--pg-forest-900);   /* your 19381F              */
--pg-accent      : var(--pg-lime-500);     /* your 91CB3E              */
--pg-action      : var(--pg-yellow-500);   /* your EEE82C              */
--pg-action-ink  : var(--pg-ink-900);      /* text that sits on action */
--pg-urgent      : var(--pg-ember-600);
--pg-star        : var(--pg-ember-500);
```

**To retheme the entire site**, change only the semantic block. For example,
swapping `--pg-action` to `--pg-ember-600` moves every primary button from
yellow to terracotta in one edit, and you would then also set
`--pg-action-ink` to `#FFFFFF`.

---

## 5. Button hierarchy

There are four levels and they are not interchangeable. This hierarchy is the
main reason the redesign should convert better than the first version, where
every button looked the same.

| Class | Look | Contrast | Use |
|---|---|---|---|
| `.pg-btn--action` | Yellow fill, near black text, 4px hard shadow | 12.96:1 | **One per screen.** Get a quote, Add to cart, Request sample |
| `.pg-btn` (default) | Forest fill, white text | 12.91:1 | Secondary. Browse catalogue, View category |
| `.pg-btn--ghost` | Transparent, forest text, soft green border | 10.13:1 | Tertiary. Alternate paths |
| `.pg-btn--urgent` | Ember fill, white text | 4.93:1 | Time sensitive only. Festive cut off dates |

Two extra variants exist for dark backgrounds: `.pg-btn--light` (white fill) and
`.pg-btn--outline-light` (white outline).

The hard shadow under the primary button is deliberate. It makes the button read
as a physical, pressable object, and it presses down 2px on `:active`, which
gives tactile feedback that flat buttons do not.

---

## 6. Typography

### The two typefaces

Both are self hosted, subset to Latin and Latin Extended A, and served as WOFF2.
There are **no external font requests**, so nothing leaks to Google Fonts and
there is no third party blocking your first paint.

| Role | Family | Licence | File | Size |
|---|---|---|---|---|
| Display | **Young Serif** | SIL OFL 1.1 | `pg-display-400.woff2` | 19 KB |
| Interface and body | **Instrument Sans** | SIL OFL 1.1 | `pg-sans-400.woff2` | 18 KB |
| Bold | Instrument Sans Bold | SIL OFL 1.1 | `pg-sans-700.woff2` | 18 KB |
| Italic | Instrument Sans Italic | SIL OFL 1.1 | `pg-sans-400i.woff2` | 19 KB |

**Total font payload: 74 KB.** The two files needed for first paint are
preloaded from `wp_head`; bold and italic load normally, because preloading
everything delays the files that actually matter.

**Why Young Serif.** It has thick, slightly organic strokes and blunt terminals.
It reads as grown rather than manufactured, which suits a plant business, and it
holds up at very large sizes where a delicate serif would look weak. It is used
for H1, H2, H3, big statistics and pull quotes only.

**Why Instrument Sans.** A neutral modern grotesque with a tall x height and
open apertures, which is what you want for product names, prices, variant
labels and long body copy. It has a true italic rather than a slanted roman.

**Why not a serif for body copy.** Serif body text at 16px on a phone screen
loses legibility, and roughly two thirds of a store like this is read on a
phone. The serif stays where it earns its keep, in headlines.

### The scale

Fluid, using `clamp()`, so it responds to viewport width without breakpoints.

| Token | Min | Max | Used for |
|---|---|---|---|
| `--pg-step--2` | 0.72rem | 0.78rem | Badges, uppercase micro labels |
| `--pg-step--1` | 0.84rem | 0.92rem | Captions, metadata, table body |
| `--pg-step-0` | 1.00rem | 1.09rem | Body copy |
| `--pg-step-1` | 1.15rem | 1.38rem | H4, lede paragraphs, card titles |
| `--pg-step-2` | 1.38rem | 1.90rem | H3, product price |
| `--pg-step-3` | 1.72rem | 2.70rem | H2 |
| `--pg-step-4` | 2.10rem | 3.90rem | H1 |
| `--pg-step-5` | 2.50rem | 4.90rem | Hero display, optional |

Line heights: `1.08` for the H1, `1.16` for other display headings, `1.68` for
body. Letter spacing is `-0.015em` on display headings, because large serif type
sets too loose at default tracking.

### Heading rules

- H1, H2, H3 use Young Serif at weight 400. There is no bold cut, and none is
  needed at these sizes
- H4, H5, H6 switch to Instrument Sans Bold. They function as labels rather than
  statements, and a serif at 1.2rem competes with the H3 above it
- H4 is coloured `--pg-forest-800` so the fourth level is visually distinct from
  body copy without needing more size

### The highlight marker

`.pg-mark` draws your yellow underneath the bottom 42% of a line of text:

```html
<h1>Corporate plant gifts for <span class="pg-mark">Employees</span></h1>
```

This is the single highest impact typographic device on the page. It puts your
brightest colour on the most important word without any accessibility cost,
because the text colour is unchanged.

---

## 7. Shape, depth and motion

| Token | Value | Applied to |
|---|---|---|
| `--pg-r-xs` | 6px | Focus outlines, code |
| `--pg-r-sm` | 10px | Inputs, small tags |
| `--pg-r` | 16px | Panels, FAQ items, widgets |
| `--pg-r-lg` | 24px | Cards, product tiles |
| `--pg-r-xl` | 32px | Hero art, CTA panels |
| `--pg-r-pill` | 999px | Buttons, badges, pills |

Shadows are tinted with the brand green (`rgba(11, 36, 18, ...)`) rather than
pure black. Black shadows over a warm palette look muddy.

Motion uses two easings: `cubic-bezier(0.22, 0.61, 0.36, 1)` for small state
changes and `cubic-bezier(0.16, 1, 0.3, 1)` for entrances. Cards lift 5px on
hover, images scale 1.04 inside their frame. Everything is disabled under
`prefers-reduced-motion`.

---

## 8. Conversion components added in this version

These are new. They exist to move a visitor toward buying or contacting.

### Sticky action bar, phones only
Pinned to the bottom of the viewport, revealed after 60% of a screen height of
scroll, hidden again once the footer comes into view so it never covers the
contact details. Contains call, WhatsApp and the primary action. On a product
page the primary action scrolls back to the variation picker and moves keyboard
focus there.

Toggle: Customize, PlantGift Pro options, Conversion helpers.

### Floating quote button, desktop
Same reveal logic, bottom right, yellow. Hidden on the contact page, where it
would be pointless.

### WhatsApp integration
Set a number in the Customizer and the sticky bar gains a WhatsApp button with a
prefilled message. Falls back to the phone number if no separate WhatsApp number
is given.

### Value strip
Four icon and text pairs in a white card that overlaps the section above it.
Appears under the hero and under every shop and category header. Answers the
four objections a corporate buyer has before they will click anything: will it
arrive, can I brand it, what if it dies, what does bulk cost.

### Hero benefit pills and rating row
Three short proof points with green check marks directly under the lede, then a
star rating line. Both sit above the fold on desktop.

### Product card variant hint
Variable products get a "Pot options" tag on the image, so shoppers know there
is a choice before they open the product.

### Reassurance under add to cart
A one line note directly beneath the buy button covering the replacement promise
and the bulk threshold. This is where hesitation happens, so this is where the
answer belongs.

### Testimonial section
Three cards with star ratings on a dark section on the home page. **Replace the
placeholder quotes with real client quotes before launch.** Named people and
companies convert considerably better than anonymous job titles, and the current
copy says so on the page itself so you cannot forget.

### Sidebar quote card
The sidebar contact card on service pages is now a dark, sticky panel that
follows the reader down the page rather than scrolling away.

---

## 9. Accessibility summary

Every combination shipped in the theme was measured, not estimated.

| Pair | Ratio | Level |
|---|---|---|
| Body text on white | 13.19:1 | AAA |
| Headings on white | 16.78:1 | AAA |
| Muted text on white | 6.17:1 | AA |
| Muted text on sand | 5.75:1 | AA |
| Links on white | 6.97:1 | AA |
| Primary button: ink on yellow | 12.96:1 | AAA |
| Secondary button: white on forest | 12.91:1 | AAA |
| Urgent button: white on ember-700 | 4.93:1 | AA |
| Badge: forest on lime | 6.65:1 | AA |
| Dark section text: forest-100 on forest-950 | 13.49:1 | AAA |
| Dark section links: lime-300 on forest-950 | 10.97:1 | AAA |

Other guarantees: a 3px `--pg-forest-600` focus ring on every interactive
element, 44px minimum touch targets, the mobile drawer traps and returns focus
and closes on Escape, the FAQ uses native `<details>` so it works without
JavaScript, and all motion respects `prefers-reduced-motion`.

---

## 10. How to change things

### Change the brand green
Edit `--pg-brand` in `assets/css/main.css`. If you change it to something
lighter than `#286539`, also check the white-on-brand button contrast.

### Change the action colour
Edit `--pg-action` and `--pg-action-ink` together. If you move from yellow to a
dark colour, set `--pg-action-ink` to `#FFFFFF` and update
`--pg-shadow-action` to a darker shade of your new colour.

### Change the fonts
Replace the WOFF2 files in `assets/fonts/` keeping the same filenames, or edit
the `@font-face` blocks at the top of `main.css` and `editor.css`. If you drop
the custom fonts entirely, the stack falls back to system fonts and nothing
breaks.

### Add a colour to the block editor
Add it to the palette array in `theme.json`. It then appears in the editor
colour picker for every block.

### Tone the whole site warmer or cooler
Change `--pg-bg-alt` from `--pg-sand` to `--pg-forest-50` for a cooler, greener
site, or to `--pg-clay-100` for a warmer, more artisanal one. One line each.
