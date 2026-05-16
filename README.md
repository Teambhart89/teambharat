# OSINT Detective Agent

An autonomous AI agent powered by Claude that conducts OSINT investigations by combining Holehe, Sherlock, and GHunt to profile individuals from publicly available data.

## Requirements

- Python 3.8+
- [Holehe](https://github.com/megadose/holehe) — `pip install holehe`
- [Sherlock](https://github.com/sherlock-project/sherlock) — `pip install sherlock-project`
- [GHunt](https://github.com/mxrch/GHunt) — follow repo instructions
- Anthropic API key

## Setup

```bash
pip install -r requirements.txt
export ANTHROPIC_API_KEY=your_key_here
```

## Usage

```bash
python detective.py investigate john@example.com
python detective.py investigate --email john@example.com --username johndoe
```

Reports are saved to `reports/` as timestamped markdown files.

## Claude Skill

The `.claude/skills/SKILL.md` file defines this capability as a Claude Code skill. Claude will automatically apply the investigation workflow when you ask it to investigate an email or username.

## Ethics

For authorized use only: personal digital footprint review, authorized security testing, or research with ethical oversight. Never for surveillance or harassment.

---

# Competitor Analysis Agent

An autonomous AI agent powered by Claude that conducts competitive intelligence research using publicly available web data.

## Usage

```bash
python competitor_analysis.py analyze amoursecrt.com
python competitor_analysis.py analyze amoursecrt.com competitors: scentbird.com, scentbox.com
```

Reports are saved to `reports/` as timestamped markdown files (`competitor_analysis_*.md`).

## What It Analyzes

- **Brand & Positioning** — value proposition, target audience, pricing tier
- **Product Catalog** — categories, range, featured products
- **Digital Presence** — website patterns, social media footprint
- **Marketing** — promotions, loyalty programs, signup offers
- **Customer Signals** — publicly visible reviews and sentiment

## Claude Skill

The `.claude/skills/COMPETITOR_ANALYSIS.md` file defines this capability as a Claude Code skill.

## Ethics

Uses only publicly available information for legitimate business intelligence purposes.
