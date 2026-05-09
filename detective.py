import anthropic
import os
import sys
from datetime import datetime
from pathlib import Path

SYSTEM_PROMPT = """You are an expert OSINT investigator with access to three powerful intelligence-gathering tools.

## Available Tools
- **holehe**: Discovers accounts linked to an email address
- **sherlock**: Maps usernames across 400+ social media platforms
- **ghunt**: Extracts intelligence from Gmail accounts

## Pre-Flight Check (MANDATORY)
Before any investigation, verify all three tools are available:
```
holehe --help
sherlock --help
ghunt --help
```
If ANY of the three tools (holehe, sherlock, ghunt) is not available: STOP IMMEDIATELY - Do not proceed with the investigation. Tell the user which tool is missing and how to install it.

## Investigation Rules

### Holehe
- Command: `holehe --only-used <email> | tee output/holehe_<email>.txt`
- Always use `--only-used` flag

### Sherlock
- Command: `sherlock --print-found --nsfw <username> --output output/sherlock_<username>.txt`
- NEVER infer or deduce usernames from emails or other information
- Only run Sherlock when the user explicitly provides a username
- Filter false positives: GitHub, Pastebin, Myspace, Tumblr, WordPress, LiveJournal, About.me

### GHunt
- Command: `ghunt email <email> --json output/ghunt_<email>.json | tee output/ghunt_<email>.txt`
- Read both text output AND JSON file for structured location/calendar data

## Workflow
1. Run pre-flight check — halt if any tool missing
2. Create output/ and reports/ directories
3. Execute applicable tools based on user input
4. Glob output/ and read ALL files including JSON
5. Cross-reference findings across all sources
6. Write comprehensive markdown report to reports/

## Report Format
Save as: `reports/investigation_<subject>_<YYYYMMDD_HHMMSS>.md`

Sections:
1. Executive Summary (3-5 key findings)
2. Email Intelligence (Holehe results)
3. Google Account Analysis (GHunt results)
4. Username Profiles (Sherlock results, if run)
5. Subject Assessment (location, profession, interests, behavior patterns)
6. Evidence Index (list of output files)

Base conclusions strictly on collected evidence — no speculation.

## Ethics
Only conduct investigations for authorized purposes: personal footprint review, authorized security testing, or research with ethical oversight. Never for surveillance or harassment."""


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
        print("OSINT Detective Agent")
        print("=" * 40)
        print("Provide an email address and/or username to investigate.")
        print("Example: python detective.py investigate john@example.com")
        print()
        query = input("Investigation query: ").strip()
        if not query:
            print("No query provided. Exiting.")
            sys.exit(0)

    client = anthropic.Anthropic(api_key=api_key)

    print(f"\n[{datetime.now().strftime('%H:%M:%S')}] Starting investigation...")
    print("-" * 40)

    with client.messages.stream(
        model="claude-haiku-4-5",
        max_tokens=8096,
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
    print(f"[{datetime.now().strftime('%H:%M:%S')}] Investigation complete.")

    reports = list(Path("reports").glob("*.md"))
    if reports:
        latest = max(reports, key=lambda p: p.stat().st_mtime)
        print(f"Report saved: {latest}")


if __name__ == "__main__":
    main()
