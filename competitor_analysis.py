import anthropic
import os
import sys
from datetime import datetime
from pathlib import Path

SYSTEM_PROMPT = """You are an expert competitive intelligence analyst. Your job is to research and analyze competitors for a given brand or business.

## Available Tools
- **bash**: Run shell commands (curl, wget, grep, etc.) to gather publicly available data
- **str_replace_based_edit_tool**: Read and write files for storing findings and reports

## Investigation Scope

For the given brand/business, research the following:

### 1. Brand & Positioning
- Core value proposition and target audience
- Pricing strategy (budget, mid-range, premium, luxury)
- Brand tone and messaging style
- Unique selling points

### 2. Product Catalog
- Product categories and range
- Best-selling or featured products
- Product naming conventions and descriptions

### 3. Digital Presence
- Website structure and UX patterns
- Social media platforms and follower counts (if publicly accessible)
- Content strategy (frequency, format, themes)

### 4. Marketing & Promotions
- Discount and promotion strategies
- Email/SMS marketing signals (popups, signup offers)
- Loyalty or rewards programs

### 5. Customer Signals
- Review sentiment (if publicly visible)
- Community engagement

## Data Collection Rules
- Only use publicly available information (websites, public social profiles, public reviews)
- Use curl to fetch web pages; parse with grep/sed for key signals
- Save raw data to output/ directory as you collect it
- Never attempt to access private, gated, or authenticated content

## Workflow
1. Create output/ and reports/ directories
2. Research the primary brand to understand the baseline
3. Identify and research each competitor systematically
4. Cross-reference findings to identify patterns and differentiators
5. Write a structured markdown report to reports/

## Report Format
Save as: `reports/competitor_analysis_<brand>_<YYYYMMDD_HHMMSS>.md`

### Report Sections
1. **Executive Summary** — top 3-5 strategic takeaways
2. **Brand Overview** — the subject brand's positioning
3. **Competitive Landscape** — table of competitors with key attributes
4. **Competitor Profiles** — one section per competitor with:
   - Positioning & target audience
   - Pricing tier
   - Product strengths
   - Marketing approach
   - Estimated digital footprint
5. **Gap Analysis** — opportunities the subject brand could exploit
6. **Recommendations** — 3-5 actionable strategic recommendations
7. **Data Sources** — list of URLs and files consulted

Base all conclusions strictly on collected evidence. Note confidence level (high/medium/low) for each major finding.

## Ethics
Only analyze publicly available information for legitimate business intelligence purposes."""


def main():
    api_key = os.environ.get("ANTHROPIC_API_KEY")
    if not api_key:
        print("Error: ANTHROPIC_API_KEY environment variable not set.")
        sys.exit(1)

    Path("output").mkdir(exist_ok=True)
    Path("reports").mkdir(exist_ok=True)

    if len(sys.argv) > 1:
        query = " ".join(sys.argv[1:])
    else:
        print("Competitor Analysis Agent")
        print("=" * 40)
        print("Provide a brand name and/or URL to analyze, plus any known competitors.")
        print("Example: python competitor_analysis.py analyze amoursecrt.com")
        print("Example: python competitor_analysis.py analyze amoursecrt.com competitors: scentbird.com, scentbox.com")
        print()
        query = input("Analysis query: ").strip()
        if not query:
            print("No query provided. Exiting.")
            sys.exit(0)

    client = anthropic.Anthropic(api_key=api_key)

    print(f"\n[{datetime.now().strftime('%H:%M:%S')}] Starting competitor analysis...")
    print("-" * 40)

    with client.messages.stream(
        model="claude-opus-4-7",
        max_tokens=16000,
        system=SYSTEM_PROMPT,
        tools=[
            {
                "type": "bash_20250124",
                "name": "bash",
            },
            {
                "type": "text_editor_20250124",
                "name": "str_replace_based_edit_tool",
            },
        ],
        messages=[{"role": "user", "content": query}],
        betas=["computer-use-2025-01-24"],
    ) as stream:
        for event in stream:
            if hasattr(event, "type"):
                if event.type == "content_block_delta":
                    if hasattr(event.delta, "text"):
                        print(event.delta.text, end="", flush=True)
                elif event.type == "content_block_start":
                    if hasattr(event.content_block, "type"):
                        if event.content_block.type == "tool_use":
                            print(
                                f"\n[Tool: {event.content_block.name}]",
                                flush=True,
                            )

    print("\n" + "-" * 40)
    print(f"[{datetime.now().strftime('%H:%M:%S')}] Analysis complete.")

    reports = list(Path("reports").glob("competitor_analysis_*.md"))
    if reports:
        latest = max(reports, key=lambda p: p.stat().st_mtime)
        print(f"Report saved: {latest}")


if __name__ == "__main__":
    main()
