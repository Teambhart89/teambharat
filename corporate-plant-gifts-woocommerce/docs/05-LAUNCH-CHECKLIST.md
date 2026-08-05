# Launch checklist

Work through this before the site goes public. The items marked **blocking**
will cost you money or rankings if skipped.

---

## Content and branding

- [ ] **Blocking.** Replace every placeholder image. The setup generates
      gradients so nothing looks broken, but they are not photography
- [ ] Upload a logo at Appearance, Customize, Site Identity
- [ ] Set the hero image and hero copy in Customize, Home page hero
- [ ] Fill in phone, email, working hours and address in Customize, Contact
      details. These appear in the header, the footer and the schema
- [ ] Fill in Customize, Business information for search engines: registered
      name, city, state, postcode, country code, price range
- [ ] Add your social profile URLs so the Organization `sameAs` is populated
- [ ] **Blocking.** Read the Privacy Policy and Terms pages and replace the
      placeholder entity details, jurisdiction and governing law. Have them
      reviewed by a qualified adviser
- [ ] Review the Shipping and Returns page against your real courier terms
- [ ] Set the site title and tagline at Settings, General

## Catalogue

- [ ] **Blocking.** Review the generated prices against your real costs. Use
      the Variations bulk actions to shift prices by percentage or amount
- [ ] Confirm which pot materials and sizes you actually stock, and remove
      variations you cannot fulfil
- [ ] Set stock management if you need it. The build ships with stock
      management off and everything in stock
- [ ] Add product galleries. One image per product is the minimum, three is
      better
- [ ] Check that every product sits in the right categories
- [ ] Set the shop page ordering at WooCommerce, Settings, Products

## Commerce

- [ ] **Blocking.** Currency and selling locations at WooCommerce, Settings,
      General
- [ ] **Blocking.** Tax rules. GST rates and whether prices include tax
- [ ] **Blocking.** Shipping zones and rates, including the per shipment charge
      for individual home delivery if you offer it
- [ ] **Blocking.** Payment gateways, tested with a real transaction
- [ ] Order confirmation and shipping emails, at WooCommerce, Settings, Emails.
      Set the from name, from address and header image
- [ ] Test the full checkout flow end to end, including a variable product with
      all three pot options chosen
- [ ] Test the checkout on a phone

## Technical

- [ ] **Blocking.** HTTPS enabled and forced. Check for mixed content warnings
- [ ] Settings, Permalinks, Save Changes once, to flush rewrite rules
- [ ] Confirm `/wp-sitemap.xml` loads and lists categories, products and pages
- [ ] Confirm `/robots.txt` blocks cart, checkout and account
- [ ] **Blocking.** If replacing an existing site, set up redirects from every
      old URL. See `03-URL-STRUCTURE.md`
- [ ] Install a caching plugin. Page caching plus object caching if your host
      supports it
- [ ] Set up automated backups before you take the first order
- [ ] Check the 404 page loads and shows the category pills

## SEO

- [ ] Verify the site in Google Search Console and submit the sitemap
- [ ] Set up Google Analytics 4, or your preferred analytics
- [ ] Run the Rich Results Test on the home page, a service page, a category
      page and a product page. Confirm FAQPage, Service, ItemList and Product
      all validate
- [ ] Spot check meta titles and descriptions in Search Console once pages are
      indexed. Look for truncation
- [ ] Confirm exactly one H1 per page. Use any browser heading inspector
- [ ] Check that the focus keyword for each page matches the map in
      `02-KEYWORD-RESEARCH.md`, and that no two pages target the same one
- [ ] Set up Google Business Profile if you have a physical location
- [ ] **Replace the estimated keyword volumes** in the research doc with real
      figures from Keyword Planner or SemRush before allocating budget

## Accessibility

- [ ] Every image has meaningful alt text. Decorative images should have empty
      alt, not a filename
- [ ] Tab through the header, the navigation and a product page. Confirm the
      focus outline is visible everywhere
- [ ] Check colour contrast if you change the palette. The shipped palette
      passes WCAG AA for body text
- [ ] Test the mobile menu with a keyboard, including Escape to close
- [ ] Confirm the skip link works. Press Tab as the first action on any page

## Performance

- [ ] Compress every image before upload. Aim under 200KB for product images
- [ ] Run PageSpeed Insights on the home page, a category page and a product
      page. Fix anything scoring below 70 on mobile
- [ ] Confirm the hero image is not lazy loaded. It should carry
      `fetchpriority="high"`
- [ ] Check Largest Contentful Paint. On a store like this it is almost always
      the hero image
- [ ] Consider a CDN if you sell nationally

## Legal and operational

- [ ] Cookie consent banner if you serve regions that require one
- [ ] GST number on invoices if applicable
- [ ] Confirm the 48 hour damage claim window in the returns policy matches
      what your operations team can actually honour
- [ ] Decide who monitors the contact form and how fast they reply. The pages
      promise a shortlist within one working day

---

## The first thirty days after launch

**Week one.** Watch Search Console for crawl errors and coverage issues. Fix
anything reported as excluded that should be indexed.

**Week two.** Check which pages Google has indexed. If service pages are
missing, check internal links point at them and request indexing manually.

**Week three.** Look at the Search Console queries report. You will usually
find queries you did not plan for. Add them to the relevant page rather than
building a new one.

**Week four.** Review analytics for the pages with traffic but no conversions.
Usually the fix is a clearer call to action or a missing piece of information
such as minimum order quantity, not more traffic.

**Ongoing.** Publish to the journal on a schedule you can actually keep. One
good post a month beats four rushed ones. Start with the comparison posts
listed at the end of `02-KEYWORD-RESEARCH.md`, they are the lowest competition
and highest intent content available to you.
