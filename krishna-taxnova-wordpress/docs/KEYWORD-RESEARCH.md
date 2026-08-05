# Eaccountingcart — SEO Keyword Research and Content Map

This document records the keyword strategy built into the website. Every service page ships with a mapped primary keyword, supporting keywords, an SEO friendly URL, a meta title and description, heading structure (H1 → H4) and 10 FAQs with FAQPage structured data.

## Methodology

1. **Intent first**: Keywords were chosen for transactional and commercial intent ("gst registration online", "trademark objection reply") rather than purely informational terms, because service pages convert that intent.
2. **Head + long tail pairing**: Each page targets one head term in the H1 and title, with long tail variants ("...in delhi", "...for startups", form numbers like "form 8 form 11") worked naturally into H2s, body copy and FAQs.
3. **Geo modifiers**: "Delhi" appears on high value pages (the firm's base) while body copy consistently reinforces "across India / all India" for national reach.
4. **Form and section numbers**: Indian compliance searches are heavy on official identifiers (SPICe+, GSTR-9, DIR-3 KYC, Form 24, 12A, 80G, CSR-1, 15CB). These are embedded in headings and FAQ questions, where they match search phrasing.
5. **Question keywords**: Each page's 10 FAQs use natural question phrasing ("How long does…", "What documents are needed…", "Is … mandatory") which targets People Also Ask and voice/AI answers.
6. **No stuffing**: Primary keywords appear in the title, H1, first paragraph, one H2 and the meta description. Density is kept natural; synonyms and related entities carry the rest.

## Generative AI (AEO) optimisation

The content is structured so AI assistants and search AI overviews can quote it accurately:

- Direct answer paragraphs immediately under each H2 (definition-style openings).
- "At a glance" fact blocks (timeline, authority, validity, fees) in labelled H4 groups.
- FAQPage, Service, BreadcrumbList and Organization/ProfessionalService JSON-LD on every relevant page.
- Consistent entity naming ("Eaccountingcart", service names matching common search phrasing).
- Plain sentence style with no decorative dashes and no filler.

## URL architecture

| Level | Pattern | Example |
|---|---|---|
| All services | `/services/` | `/services/` |
| Category | `/ca-services/{category}/` | `/ca-services/gst-services/` |
| Service page | `/services/{service-slug}/` | `/services/gst-registration/` |
| Core pages | `/{page}/` | `/about-us/`, `/contact-us/` |

Slugs are short, lowercase, hyphenated and keyword exact (e.g. `private-limited-company-registration`, `gst-return-filing`, `trademark-objection-reply`).

## Primary keyword map (per category)

### Company Registration (11 pages)
| Page | Primary keyword | Supporting keywords |
|---|---|---|
| Private Limited Company Registration | private limited company registration | pvt ltd company registration online, company registration in delhi |
| LLP Registration | llp registration online | limited liability partnership registration, llp incorporation india |
| One Person Company Registration | one person company registration | opc registration online |
| Partnership Firm Registration | partnership firm registration | partnership deed registration |
| Sole Proprietorship Registration | sole proprietorship registration | proprietorship firm registration online |
| Public Limited Company Registration | public limited company registration | public company incorporation india |
| Nidhi Company Registration | nidhi company registration | mutual benefit company india |
| Producer Company Registration | producer company registration | farmer producer company, fpo registration |
| Indian Subsidiary Registration | indian subsidiary registration | foreign subsidiary company india |
| Startup India Registration | startup india registration | dpiit recognition online, 80 iac exemption |
| Section 8 Company Registration | section 8 company registration | ngo company registration |

### GST Services (8 pages)
| Page | Primary keyword | Supporting keywords |
|---|---|---|
| GST Registration | gst registration online | new gst registration, gst number apply |
| GST Return Filing | gst return filing online | gstr 1 filing, gstr 3b filing |
| GST Annual Return Filing | gstr 9 filing online | gst annual return, gstr 9c |
| GST LUT Filing | lut filing online | export without igst |
| GST Cancellation | gst cancellation online | surrender gst number, gstr 10 |
| GST Refund Claim | gst refund claim online | export gst refund, inverted duty refund |
| GST Notice Reply | gst notice reply | asmt 10 reply, drc 01 response |
| GST Advisory | gst advisory services | gst consultant delhi |

### Income Tax (7 pages)
| Page | Primary keyword |
|---|---|
| Income Tax Return Filing | income tax return filing online, itr filing by ca |
| TDS Return Filing | tds return filing online, 24q 26q filing |
| Tax Audit | tax audit services, section 44ab audit |
| Income Tax Notice Reply | income tax notice reply, section 148 notice |
| Business Tax Planning | business tax planning india |
| Form 15CA 15CB Filing | form 15ca 15cb filing, foreign remittance certificate |
| PAN and TAN Application | pan card apply online, tan application |

### Trademark & IPR (10 pages)
trademark registration online · trademark objection reply · trademark opposition india · trademark renewal online · trademark assignment india · trademark rectification · international trademark registration / madrid protocol india · copyright registration online · patent registration india · design registration india

### MCA & ROC Compliance (11 pages)
private limited company annual compliance · llp annual compliance (form 8, form 11) · add or remove director (dir 12) · registered office change (inc 22) · company name change procedure · increase authorised capital (sh 7) · share transfer procedure (sh 4) · moa amendment procedure · company strike off (stk 2) · llp closure (form 24) · secretarial audit (mr 3)

### Licenses & Registrations (15 pages)
fssai license online · iso certification online · import export code (iec) · udyam registration online · shop and establishment registration · trade license online · drug license online · psara license · digital signature certificate (class 3 dsc) · professional tax registration · epf registration online · esi registration online · gem registration online · bis certification (isi mark, crs) · barcode registration (gs1)

### NGO Services (6 pages)
trust registration online · society registration online · 12a 80g registration · fcra registration · csr 1 registration · ngo darpan registration

### NBFC & FinTech (8 pages)
nbfc registration online · nbfc compliance services · nbfc takeover · microfinance company registration · p2p lending license india · payment aggregator license rbi · ppi / prepaid wallet license · ffmc license

### Environmental & EPR (6 pages)
pollution noc (cte cto) · epr registration e waste · epr registration plastic waste · battery waste epr registration · hazardous waste authorization · environmental clearance (eia)

### Accounting & Finance (8 pages)
accounting and bookkeeping services · virtual cfo services india · payroll outsourcing india · project report for bank loan / cma data · business plan preparation · due diligence services · internal audit services · business valuation services

## On-page SEO checklist implemented on every service page

- One H1 (service name with keyword)
- H2 sections: What is / Who should apply / Benefits / Documents Required / Step by Step Process / At a Glance / Why Choose Eaccountingcart / FAQs
- H3s: individual benefits, process steps, FAQ questions
- H4s: quick fact labels (Timeline, Authority, Validity, Fees)
- Meta title ≤ 60 chars, meta description ≤ 160 chars, canonical URL, Open Graph tags
- FAQPage + Service + BreadcrumbList JSON-LD
- Internal links: breadcrumbs, related services, mega menu, footer columns
- Conversion elements: document upload form, WhatsApp CTA, click to call

## Recommended next steps after launch

1. Install an XML sitemap plugin (Rank Math or Yoast — the theme steps aside automatically) and submit to Google Search Console.
2. Create a Google Business Profile for "Eaccountingcart" (Delhi) and link the site.
3. Add a blog and publish supporting informational content (e.g. "GST registration documents checklist 2026") interlinked to service pages.
4. Build citations on JustDial, Sulekha, IndiaMART and CA directories with a consistent NAP (name, address, phone).
5. Collect Google reviews and add Review schema once genuine reviews exist.
