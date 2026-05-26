# Influencer Discovery

Run an OSINT investigation on a social media influencer or username. Discovers their presence across platforms, maps their digital footprint, and generates a structured report.

## Usage
`/influencer-discovery <@username or handle>`

## Instructions

The argument `$ARGUMENTS` contains the username or handle to investigate (strip any leading `@`).

1. **Pre-flight check** — verify Sherlock is installed:
   ```bash
   sherlock --help
   ```
   If Sherlock is not found, stop and tell the user: `sherlock` is not installed. Run `pip install sherlock-project` to install it.

2. **Create output directories**:
   ```bash
   mkdir -p output reports
   ```

3. **Extract the username** from `$ARGUMENTS` — remove any leading `@` symbol.

4. **Run Sherlock** to map the username across 400+ platforms:
   ```bash
   sherlock --print-found --nsfw <username> --output output/sherlock_<username>.txt
   ```

5. **Read the output file** and filter out known false positives:
   - GitHub (rate-limited)
   - Pastebin
   - Myspace
   - Tumblr
   - WordPress
   - LiveJournal
   - About.me

6. **Generate a markdown report** saved to `reports/influencer_<username>_<YYYYMMDD_HHMMSS>.md` with these sections:

   ### Report Sections
   - **Executive Summary** — platform count, top platforms found, estimated reach category
   - **Platform Presence** — confirmed accounts grouped by category (Social, Video, Professional, Community, Adult/NSFW)
   - **Cross-Platform Patterns** — username consistency, profile alignment, content niche signals
   - **Audience & Reach Signals** — inferred audience from platform mix
   - **Evidence Index** — list of output files

   Base all conclusions strictly on confirmed Sherlock findings — no speculation.

7. **Print a brief summary** to the user: how many platforms found, top 5 platforms, and the report path.
