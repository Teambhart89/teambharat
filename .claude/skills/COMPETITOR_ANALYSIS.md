# Competitor Analysis Skill

## Overview

This skill enables Claude to conduct structured competitive intelligence research for a brand or business using publicly available web data.

## Trigger Conditions

Use this skill when the user asks to:
- Analyze competitors for a brand or store
- Research the competitive landscape for a business
- Compare a brand against its competitors
- Find gaps or opportunities relative to competitors
- Run a competitive intelligence report

## Usage

```bash
python competitor_analysis.py analyze <brand-or-url>
python competitor_analysis.py analyze <brand-or-url> competitors: <competitor1>, <competitor2>
```

**Examples:**
```bash
python competitor_analysis.py analyze amoursecrt.com
python competitor_analysis.py analyze amoursecrt.com competitors: scentbird.com, scentbox.com
```

## What Gets Analyzed

For each brand (subject + competitors), the agent researches:

1. **Brand & Positioning** — value proposition, target audience, price tier, messaging
2. **Product Catalog** — categories, range, featured products
3. **Digital Presence** — website UX patterns, social media footprint
4. **Marketing & Promotions** — discount strategies, loyalty programs, signup offers
5. **Customer Signals** — publicly visible reviews and engagement

## Data Collection Constraints

- Only publicly available information (public websites, public social profiles, public reviews)
- Uses `curl`, `grep`, and related shell tools to fetch and parse web content
- Raw data saved to `output/` for reference
- Never accesses authenticated, gated, or private content

## Report Output

Report saved to `reports/competitor_analysis_<brand>_<YYYYMMDD_HHMMSS>.md` with:

1. Executive Summary (top strategic takeaways)
2. Brand Overview (subject brand positioning)
3. Competitive Landscape (comparison table)
4. Competitor Profiles (one section per competitor)
5. Gap Analysis (opportunities for the subject brand)
6. Recommendations (3-5 actionable next steps)
7. Data Sources (all URLs and files referenced)

## Ethics

For legitimate business intelligence purposes only, using publicly available data.
