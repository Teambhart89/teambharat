# OSINT Investigation Skill

## Overview

This skill enables Claude to conduct open-source intelligence (OSINT) investigations using three specialized CLI tools: **Holehe**, **Sherlock**, and **GHunt**.

## Trigger Conditions

Use this skill when the user asks to:
- Investigate an email address or Gmail account
- Find social media accounts linked to a username
- Profile someone using publicly available information
- Run an OSINT investigation or digital footprint analysis

## Mandatory Pre-Flight Check

Before any investigation begins, verify all three tools are installed and accessible:

```bash
holehe --help
sherlock --help
ghunt --help
```

If ANY of the three tools (holehe, sherlock, ghunt) is not available: **STOP IMMEDIATELY** — do not proceed. Inform the user which tool is missing and provide installation guidance.

## Tools and Usage

### Holehe — Email Account Discovery

Discovers accounts associated with an email address by testing authentication endpoints across hundreds of websites.

```bash
holehe --only-used <email> | tee output/holehe_<email>.txt
```

- Always use `--only-used` to filter to sites with confirmed registrations
- Save output to `output/` directory

### Sherlock — Username Mapping

Maps a username to social media profiles across 400+ platforms.

```bash
sherlock --print-found --nsfw <username> --output output/sherlock_<username>.txt
```

**Critical rule:** Only run Sherlock when the user explicitly provides a username in their query. **NEVER** infer or deduce usernames from email addresses or other gathered information.

**Known false positives** — filter these domains from reports:
- GitHub (rate-limited results)
- Pastebin
- Myspace
- Tumblr
- WordPress
- LiveJournal
- About.me

### GHunt — Gmail Intelligence

Extracts Google account intelligence: profile data, connected services, calendar events, location reviews, and activity patterns.

```bash
ghunt email <email> --json output/ghunt_<email>.json | tee output/ghunt_<email>.txt
```

- Read both the text output and the JSON file
- Parse JSON for structured calendar and location data — these are critical for temporal and geographic analysis

## Workflow

1. **Verify tools** — run pre-flight check; halt if any tool is missing
2. **Run tools** — execute applicable tools based on what the user provided (email and/or username)
3. **Collect output** — glob `output/` directory and read every file including JSON
4. **Cross-reference** — correlate data across all sources to identify patterns
5. **Generate report** — write a single markdown report to `reports/` with timestamp

## Report Structure

Save report as `reports/investigation_<subject>_<YYYYMMDD_HHMMSS>.md` with these sections:

1. **Executive Summary** — key findings in 3–5 bullets
2. **Email Intelligence** (Holehe results) — confirmed account registrations by category
3. **Google Account Analysis** (GHunt results) — profile, services, calendar patterns, location data
4. **Username Profiles** (Sherlock results, if applicable) — confirmed platform presences
5. **Subject Assessment** — analytical conclusions on:
   - Geographic location patterns
   - Professional profile
   - Interests and communities
   - Behavioral patterns and activity windows
6. **Evidence Index** — list of all output files with brief descriptions

Draw conclusions from collected evidence only — no speculation beyond what the data supports.

## Ethical and Legal Requirements

This skill is for **authorized use only**:
- Personal digital footprint review
- Authorized security testing or penetration work
- Academic or journalistic research with ethical oversight

**Do not use** for surveillance, stalking, or harassment. Misuse violates platform terms of service and may violate applicable laws. Always confirm authorization before beginning any investigation.
