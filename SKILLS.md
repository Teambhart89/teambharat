# Installed Skills: Full Reference

Every skill installed in this Claude Code session, with a detailed explanation of what it does, when to use it, and an example.

**How to use a skill:** type `/<skill-name>` (for example `/seo-audit`) or just ask for it by name. Skills outside the Built-in / Core group are invoked with the `anthropic-skills:` prefix (for example `anthropic-skills:osint`).

**Legend:** the system shipped some skills with a full description and others with only a name. Entries marked **†** are inferred from the skill's name, so run the skill to confirm its exact behaviour.

---

## 1. Built-in / Core (Claude Code)

### `session-start-hook`
Creates a startup hook script committed to your repository that runs automatically every time a Claude Code cloud session starts. Use it to install dependencies, set up linters, or prepare test tooling so every new session is ready to work immediately.
*Example:* "Add a session start hook that runs `npm install` and sets up the test environment."

### `update-config`
Edits Claude Code's `settings.json` to change how the harness behaves. It covers automated hooks ("whenever X happens, do Y"), permission rules (which commands run without asking), and environment variables. This is the only reliable way to make behaviour automatic, because memory alone cannot trigger actions.
*Example:* "From now on, run the formatter after every file edit."

### `keybindings-help`
Customises keyboard shortcuts in Claude Code. You can rebind keys, create multi-key chord shortcuts, or change the submit key by editing `~/.claude/keybindings.json`.
*Example:* "Rebind Ctrl+S to submit my message."

### `code-review`
Reviews your current code changes, a specific PR, a branch, or a file path for real correctness bugs. You choose an effort level from `low` (a few high-confidence findings) to `max` (exhaustive, uses many reviewer agents). It can post findings as inline PR comments with `--comment` or fix them automatically with `--fix`.
*Example:* `/code-review high --fix`

### `simplify`
Reviews changed code for quality rather than bugs: duplicated logic, needlessly complex code, inefficient patterns, and code written at the wrong level of abstraction. It then applies the cleanups directly. Use it after a feature works and you want the code tidy before merging.

### `security-review`
Runs a full security audit of the pending changes on your current branch. It looks for injection flaws, authentication and authorisation gaps, exposed secrets, unsafe input handling, and other vulnerabilities before they ship.

### `fewer-permission-prompts`
Scans your past session transcripts for safe, read-only commands you approve repeatedly (such as `git status`, `ls`, or MCP read calls). It then adds them to an allowlist in the project's `.claude/settings.json` so Claude stops asking every time, which cuts friction without opening up dangerous commands.

### `loop`
Runs a prompt or slash command on a repeating interval (for example `/loop 5m /check-deploy`). Without an interval, Claude paces itself. Use it for monitoring deployments, polling status, or babysitting PRs. Do not use it for one-off tasks.

### `claude-api`
A full reference for building on Anthropic's Claude API and SDKs. It covers current model IDs, pricing, parameters, streaming, tool use, MCP, agents, prompt caching, token counting, and migrating between models. It is loaded automatically whenever you build anything LLM-powered with Claude.

### `run`
Launches your project's app (CLI, web server, TUI, Electron, browser app, or library) and drives it to prove a change actually works in the real app, not just in tests. It can take screenshots as proof.
*Example:* "Run the app and show me the new login page works."

### `plugin-authoring`
Builds "mods" that change Claude's own interface and behaviour: colour themes, side panels that update live, status bars, toast notifications, custom slash commands, and hooks on tool calls. It also helps debug existing mods.

### `init`
Analyses your codebase and generates a `CLAUDE.md` file documenting its structure, build commands, conventions, and key architecture. Future Claude sessions read this file to understand the project instantly.

### `dataviz`
A design system for every chart, graph, dashboard, or KPI tile in any tool (HTML, React, D3, matplotlib, Plotly, Recharts, PNG). It gives rules for choosing the right chart type, an accessible colour palette that works in light and dark mode, and consistent styling for axes, legends, and tooltips. Load it before writing any chart code.

### `artifact-design`
The design rulebook for Artifacts, the private web pages Claude publishes on claude.ai. It covers layout, typography, theming, dark mode, mobile responsiveness, and the technical contract every page must follow. It must be loaded before building any Artifact.

### `artifact-diagramming`
Teaches when a diagram actually helps and how to draw one that shows the real mechanism rather than decorative boxes. It covers inline-SVG techniques that stay readable in both light and dark themes.

### `artifact-capabilities`
Adds live, interactive features to published Artifacts: shared databases (polls, sign-up sheets, trackers), knowing who is viewing, file uploads, asking Claude questions from the page, camera and microphone access, and documents that save new versions of themselves.

### `cowork-plugin-management:cowork-plugin-customizer`
Adapts an existing Claude Code plugin to your organisation's specific tools, connectors, and workflows. It tweaks skills, settings, and connector configuration so a generic plugin fits your team.

### `cowork-plugin-management:create-cowork-plugin`
Walks you step by step through building a brand-new plugin from scratch inside a Cowork session, from design through scaffolding to a packaged `.plugin` file ready to distribute.

---

## 2. OSINT, Investigation and Counter-Propaganda

### `anti-bharat-osint-expose`
Builds comprehensive open-source intelligence (OSINT) dossiers on individuals running anti-India, anti-Hindu, anti-Hindutva, anti-BJP, or anti-RSS campaigns, online and offline, at home and abroad. It traces Khalistani sympathisers, foreign-funded propaganda operatives, and coordinated anti-Hindu narrative networks across multiple platforms, using Python-assisted deep research. Use it for structured, evidence-backed exposés rather than ad hoc digging.

### `background-checker`
Runs background verification and ideological assessment of individuals who have applied to associate with the RSS, working from a spreadsheet of applicants. It checks each person against publicly available online sources and produces a structured report per individual.

### `osint` †
General-purpose open-source intelligence gathering: finding public information about people, organisations, domains, usernames, and events from search engines, social media, public records, and archives. It is the foundation skill for any investigation.

### `osint-narrative-analysis` †
Tracks how a narrative or propaganda line is born and spread: who started it, which accounts amplified it, whether the amplification looks coordinated or organic, and how it moved across platforms. It is ideal for dismantling hate campaigns and fake trends.

### `security-osint` †
OSINT focused on security: finding exposed servers, leaked credentials, vulnerable infrastructure, and an organisation's attack surface from public data. It is used for defensive security assessments.

### `cti-expert` †
Cyber threat intelligence analysis. It profiles hacker groups and state-backed actors, maps their tactics, techniques and procedures (MITRE ATT&CK), and tracks indicators of compromise. Use it to understand who is attacking and how.

### `journalism-osint-master` †
Advanced investigative OSINT built for journalists: verifying people, tracing money and company ownership, geolocating images and video, and building timelines that will stand up to legal and editorial scrutiny.

### `journalist-osint-analysis` †
Turns raw OSINT findings into publishable journalism. It evaluates the strength of evidence, connects the dots between findings, and structures the material into a defensible story.

### `individual-profile` †
Compiles a profile of a single person from public sources: identity, online accounts, affiliations, public statements, and activity history.

### `individual-analyst-profile` †
A deeper, analyst-grade version of `individual-profile`. It adds assessment of the person's network, influence, behaviour patterns, and the credibility of each finding.

### `social-media-intelligence` †
Monitors and analyses social media (SOCMINT): tracking hashtags, mapping account networks, spotting bot activity, and identifying influential nodes in a conversation.

### `social-sentiment-analyzer` †
Measures public sentiment (positive, negative, neutral) about a topic, person, or brand across social platforms, and shows how it shifts over time.

### `fact-check-workflow` †
A structured, step-by-step process for verifying or debunking a claim. It isolates the claim, traces its origin, checks primary sources, and issues a clear verdict with evidence. This is your weapon against fake news.

### `source-verification` †
Verifies whether a source, document, image, or video is authentic. It uses reverse image search, metadata checks, account history, and cross-referencing to catch doctored or out-of-context material.

### `web-archiving` †
Captures and preserves web pages (for example through the Wayback Machine and archive.today) before they are edited or deleted, so you keep timestamped proof of what someone posted.

### `digital-archive` †
Organises and preserves collected evidence (screenshots, archived links, documents, and media) in a structured, searchable, verifiable archive.

### `page-monitoring` †
Watches specific web pages and alerts you when they change: edited statements, deleted posts, updated policies.

### `web-scraping` †
Extracts structured data from websites (tables, lists, posts, profiles) for analysis, handling pagination and different page layouts.

### `twitter-data-export` †
Exports posts, followers, and account data from X/Twitter for analysis or archiving.

### `reddit` †
Reads, searches, and pulls posts and comments from Reddit.

### `reddit-research` †
Researches topics, communities, and public opinion on Reddit: what people are saying, which subreddits matter, and recurring themes.

### `youtube-downloader` †
Downloads YouTube videos, audio, or transcripts for offline analysis, archiving, or quoting.

---

## 3. Journalism, Writing and Editorial

### `academic-writing` †
Supports scholarly work: research papers, literature reviews, grant proposals, methodology design, citation management, and peer-review preparation.

### `ai-writing-detox` †
Removes the tell-tale patterns of AI-generated text (filler phrases, robotic structure, overused words like "delve") so articles, press releases, and documentation sound authentically human and keep reader trust.

### `ai-content-collaboration`
Defines how humans and AI should split content work: where AI helps, where humans must own the result, how to keep a genuine voice, how to avoid "AI slop", and when to disclose AI use. Use it to set a team's AI writing policy.

### `content-research-writer` †
Researches a topic from multiple sources and then writes a well-sourced article, report, or explainer on it.

### `copywriting` †
Writes persuasive marketing copy for ads, websites, emails, and product pages, built to grab attention and drive action.

### `copy-editing` †
Edits existing text for grammar, clarity, flow, consistency, and tightness, keeping the author's voice intact.

### `data-journalism` †
Finds stories hidden in datasets: cleaning data, analysing trends, and presenting findings with charts readers can understand.

### `newsroom-style` †
Applies and enforces a consistent house style (spelling, terminology, formatting, attribution rules) across all published writing.

### `editorial-workflow` †
Sets up the pipeline content moves through: assignment, drafting, editing, fact-checking, approval, and publishing, with clear roles at each stage.

### `story-pitch` †
Crafts compelling story pitches for editors, publications, or media outlets: the angle, why it matters now, and why you are the right person to tell it.

### `interview-prep` †
Prepares you for an interview, whether as interviewer or interviewee: background research on the subject, sharp questions, and anticipated follow-ups.

### `interview-transcription` †
Transcribes recorded interviews and turns them into clean, quotable text with summaries and key takeaways.

### `thread-writer` †
Writes punchy, high-engagement threads for X/Twitter, with a strong hook, a logical flow from post to post, and a closing call to action.

### `write-blog` †
Writes complete blog posts, from headline and structure through the body to the conclusion, optimised for readers and search.

### `write-landing` †
Writes full landing pages: headline, value proposition, benefits, social proof, and call to action.

### `newsletter-publishing` †
Plans, writes, and publishes email newsletters, including subject lines, layout, and growing the subscriber list.

### `deep-research` †
Conducts thorough, multi-source research on a complex question and produces a structured, cited report rather than a quick surface answer.

### `content-translation` †
Translates content between languages while keeping its meaning, tone, and cultural nuance intact, not just word-for-word conversion.

### `i18n` †
Internationalisation for websites and apps: preparing code and content for multiple languages, locales, date and currency formats, and right-to-left scripts.

---

## 4. SEO and Search

### `seo-audit` †
A complete health check of a website's search performance: technical issues, on-page problems, content quality, and backlinks, with a prioritised fix list.

### `seo-audit-orchestration` †
Coordinates several specialised SEO audits (technical, content, backlinks, competitors) into one combined report and action plan.

### `seo-site-health-audit` †
Focuses on site-level technical health: crawl errors, broken pages, redirect chains, slow load times, and mobile problems.

### `seo-technical` / `technical-seo` †
Fixes the technical foundations Google needs: crawlability, indexing, site speed, Core Web Vitals, sitemaps, robots.txt, canonical tags, and site architecture.

### `seo-onpage` / `on-page-seo` †
Optimises individual pages: title tags, headings, keyword placement, content depth, internal links, and image alt text.

### `seo-offpage` †
Builds authority from outside your site through backlinks, brand mentions, digital PR, and outreach strategy.

### `seo-aeo-geo` †
Optimises content for the new search: Answer Engine Optimisation (AEO) and Generative Engine Optimisation (GEO), so ChatGPT, Perplexity, and Google AI Overviews cite your content.

### `ai-visibility`
Analyses and improves how your brand shows up in AI-generated answers from ChatGPT, Claude, Gemini, and Perplexity: whether you are mentioned, how you are described, and how to get recommended.

### `seo-keyword` / `keyword-research` †
Finds the search terms worth targeting, weighing search volume, difficulty, intent, and business value.

### `keyword-clustering` †
Groups hundreds of keywords into clusters by topic and search intent, so each page targets a coherent group instead of competing terms.

### `seo-keyword-gap-audit` †
Finds the keywords your competitors rank for and you don't, which shows you ready-made opportunities.

### `dataforseo-keywords` †
Pulls keyword volumes, difficulty, and search result data from the DataForSEO API for data-driven research.

### `seo-content-audit` †
Reviews all existing content to decide what to keep, update, merge, or delete based on traffic, rankings, and quality.

### `seo-content-brief` †
Creates detailed briefs for writers: target keywords, search intent, recommended structure, questions to answer, and competitor benchmarks.

### `seo-content-gap-audit` / `content-gap-analysis` †
Identifies topics your audience searches for that your site doesn't cover yet, so you know exactly what content to create.

### `seo-backlink-audit` †
Reviews every link pointing to your site to measure authority, spot spammy or toxic links, and find link-building opportunities.

### `backlink-audit`
Backlink analysis through the SemRush API: referring domains, anchor text, toxic links, disavow lists, and link-building opportunities.

### `seo-competitor` †
Reverse-engineers competitors' SEO: their top pages, keywords, backlink sources, and content strategy.

### `seo-rank-tracking` †
Tracks where your pages rank for target keywords over time and flags gains and drops.

### `seo-traffic-diagnosis` †
Investigates why organic traffic dropped (algorithm update, technical error, lost rankings, seasonality) and how to recover it.

### `seo-weekly-report` †
Generates a recurring weekly SEO report: traffic, rankings, wins, problems, and next actions.

### `serp-analyzer` †
Analyses a Google results page for a query: who ranks, what content type wins, which SERP features appear, and what it takes to break in.

### `cannibalization-check`
Detects keyword cannibalisation, where several of your own pages compete for the same query and drag each other down, and recommends fixes such as merging or redirecting.

### `internal-linking` †
Plans and improves links between your own pages to spread authority, help Google understand your structure, and keep readers on site.

### `broken-links`
Scans a website or codebase for broken links and 404s, then helps repair or redirect them.

### `indexing-audit` †
Checks which pages Google has and hasn't indexed, and why, so important pages don't stay invisible.

### `meta-tags-optimizer` †
Rewrites page titles and meta descriptions to improve click-through from search results.

### `schema-markup` †
Adds structured data (JSON-LD schema) so your pages qualify for rich results: stars, FAQs, articles, events, breadcrumbs.

### `programmatic-seo` †
Generates large numbers of SEO pages from templates and data (for example "Best X in [city]") without creating thin or spammy content.

### `pillar-content-architecture` †
Designs a pillar-and-cluster structure: one comprehensive pillar page per core topic, linked to detailed supporting articles, to build topical authority.

### `gsc-based-seo-article-writing` †
Uses your real Google Search Console data (queries you almost rank for) to write or update articles that capture that traffic.

### `search-console` †
Pulls and analyses Google Search Console data: queries, impressions, clicks, CTR, positions, and indexing status.

### `google-indexing` †
Submits new or updated URLs to Google for faster indexing and checks their indexing status.

### `semrush-research` †
Runs keyword, competitor, traffic, and backlink research using SemRush data.

### `ahrefs-python`
Uses the Ahrefs API from Python through the `ahrefs-python` library: backlinks, keywords, domain rating, organic traffic, site audits, rank tracking, and brand monitoring, with typed requests and error handling.

---

## 5. Marketing, Ads and Growth

### `ads-creative-development`
Produces ad creative that converts at scale: hook patterns, format choice, video pacing, systems for making variations, testing methods, spotting creative fatigue, and platform norms for Meta, TikTok, and LinkedIn.

### `ads-performance-analytics`
Teaches you to read paid-media dashboards without fooling yourself. It covers attribution models, platform reporting quirks, reconciling multiple platforms, the ROAS-versus-LTV trap, statistical noise, and incrementality testing (geo holdouts, lift studies). Use it before scaling or killing a campaign.

### `paid-media-strategy` †
Plans your paid advertising: which channels, what budget split, audience targeting, campaign structure, and goals.

### `google-ads` †
Sets up and manages Google Ads campaigns (Search, Display, YouTube, Performance Max), including keywords, bids, and ad copy.

### `google-ads-report` †
Builds clear performance reports from Google Ads data: spend, conversions, CPA, ROAS, and recommendations.

### `linkedin-ads` †
Plans and runs LinkedIn ad campaigns for B2B audiences, including targeting by job title, company, and industry.

### `competitive-ads-extractor`
Pulls competitors' ads from public ad libraries (Facebook, LinkedIn, and others) and analyses what messaging, pain points, and creative approaches they rely on, so you can do better.

### `video-ad-analysis` †
Breaks down video ads scene by scene (hook, pacing, message, call to action) and explains why they perform well or badly.

### `ab-test-setup`
Designs statistically sound A/B tests: hypothesis, sample size, test duration, significance, and how to read the results without false winners.

### `page-cro` †
Conversion rate optimisation for web pages: finds what stops visitors from acting and recommends layout, copy, and design fixes.

### `landing-page-copy` †
Writes landing page copy built specifically to convert visitors into signups, leads, or buyers.

### `affiliate-marketing`
Builds and grows an affiliate or partner program: commission structures, tracking, recruiting partners, and choosing an affiliate network.

### `referral-program` †
Designs customer referral programs (rewards, mechanics, messaging) that turn users into promoters.

### `lead-magnet` †
Creates free, valuable offers (ebooks, checklists, templates, tools) that people exchange their email address for.

### `lead-research-assistant` †
Finds and qualifies potential leads or prospects who match your target profile, with contact and company context.

### `demand-gen` †
Builds demand generation strategy: creating awareness and interest in your product before people are actively shopping.

### `growth-strategy` †
Develops an overall growth plan: acquisition channels, retention, monetisation, and the experiments to run first.

### `launch-strategy` †
Plans a product or campaign launch end to end: pre-launch buzz, launch day, channels, messaging, and follow-through.

### `marketing-ideas` †
Brainstorms creative, practical marketing ideas tailored to your product, audience, and budget.

### `pricing-strategy` †
Designs pricing models, tiers, and packaging, and tests what customers will actually pay.

### `product-marketing` †
Product positioning, messaging, competitive differentiation, and sales enablement material.

### `email-sequence` †
Writes automated email series (welcome, nurture, onboarding, re-engagement) that move people toward action.

### `icp-builder` †
Defines your Ideal Customer Profile: who your best customers are, their pain points, and how to find more of them.

### `influencer-discovery` †
Finds influencers and creators relevant to your niche and evaluates their reach, engagement, and audience fit.

### `social-content` †
Creates social media posts across platforms, adapted to each one's format and culture.

### `linkedin-content` †
Writes LinkedIn posts and articles that build professional authority and reach.

### `twitter-algorithm-optimizer` †
Shapes your X/Twitter posts to work with the algorithm (hooks, formatting, timing, engagement triggers) for maximum reach.

### `reddit-marketing` †
Markets on Reddit the right way, adding value to communities rather than spamming them, so you avoid bans and backlash.

### `content-strategy` †
Builds an overall content plan: audience, goals, themes, formats, channels, and how to measure success.

### `content-calendar` †
Schedules content across weeks or months, showing what gets published where and when.

### `content-brief` / `content-brief-authoring` †
Writes clear briefs for content creators: goal, audience, key messages, structure, and references.

### `content-repurposing` †
Turns one piece of content (for example a video or long article) into many formats: threads, posts, clips, newsletters, infographics.

### `content-opportunities` †
Spots high-value content you should create, based on demand, gaps, and trending topics.

### `content-and-copy` †
General help with all kinds of content and copy tasks.

### `competitive-intel` †
Gathers ongoing intelligence on competitors: product moves, pricing, messaging, hiring, and strategy shifts.

### `competitor-analysis` †
A detailed side-by-side comparison with competitors covering strengths, weaknesses, positioning, and openings you can exploit.

### `analytics-strategy`
Designs your measurement system: KPI hierarchy, event tracking plan, dashboard architecture, attribution model, and GA4 or Mixpanel setup.

### `google-analytics` †
Sets up, audits, and analyses Google Analytics 4: traffic, user behaviour, conversions, and reports.

### `youtube-analytics` †
Analyses YouTube channel performance (views, watch time, retention, subscriber growth, traffic sources) and how to improve it.

### `google-reviews` †
Monitors, analyses, and responds to Google Business reviews to protect and build reputation.

---

## 6. Brand and Design

### `brand-discovery`
Upstream brand research done before any design: who the audience is, the competitive landscape, category dynamics, the problem you solve, and possible positioning territory.

### `brand-ideation`
Early-stage brand creation: generating and narrowing positioning options, name candidates, mood directions, and narrative angles until one direction wins.

### `brand-identity`
Designs or evaluates the visual identity system: logo, colour palette, typography, imagery style, iconography, and motion principles.

### `brand-voice`
Defines how your brand sounds in writing: voice attributes, how tone shifts by context, vocabulary, grammar rules, and before-and-after copy examples.

### `brand-style-guide`
Builds or audits a complete brand book documenting the whole system (story, logo rules, colour, type, imagery, voice, and dos and don'ts) for designers, developers, and vendors.

### `brand-design`
Generates ready-to-export branded HTML designs for LinkedIn: carousels, article headers, profile banners, infographics, and single posts, with PNG and PDF download built in.

### `brand-dev`
Fetches a company's brand info (name, description, logos, industry) from the brand.dev API and saves the logos locally.

### `brand-monitor`
Tracks where and how your brand is mentioned online, along with sentiment, logo usage, and PR opportunities, using the Brand.dev API.

### `art-direction`
Directs creative work for campaigns: photography briefs, illustration direction, video treatments, mood boards, and evaluating whether creative fits the brand.

### `creative-brief` †
Writes the creative brief that kicks off a campaign or design project: objective, audience, insight, message, and deliverables.

### `banner-design`
Designs banners for Facebook, X, LinkedIn, YouTube, Instagram, Google Display, website heroes, and print, with multiple art-direction options from minimalist to neon to editorial.

### `visual-explainer` †
Turns complex topics into clear visual explanations: diagrams, step-by-step graphics, and illustrated breakdowns.

### `pdf-design`
Designs and edits professional PDF reports and proposals with a live preview while you work.

### `generate-image` †
Generates images from text descriptions using AI.

### `nano-banana-image-gen` †
Generates and edits images with Google's Nano Banana (Gemini image) model, which is strong at consistent characters and edits.

### `image-enhancer` †
Improves image quality by upscaling, sharpening, denoising, and fixing lighting and colour.

### `animated-sprite-gen`
Creates animated sprite sheets and consistent multi-frame pixel-art character animations for 2D games.

### `domain-name-brainstormer` †
Generates catchy, available-sounding domain name ideas for a brand or project.

### `domain-research` †
Researches a domain's availability, ownership history, past content, and reputation before you buy or trust it.

---

## 7. Documents and Files

### `docx` †
Creates, reads, and edits Microsoft Word documents with proper formatting, headings, tables, and styles.

### `pdf` †
Creates PDFs, extracts text and data from them, fills forms, merges and splits files, and edits existing PDFs.

### `pptx` †
Builds PowerPoint presentations with structured slides, layouts, charts, and speaker notes.

### `xlsx` †
Creates and edits Excel spreadsheets, including formulas, formatting, charts, and data analysis.

### `docs` †
Works with Claude Docs, living documents you create and edit collaboratively on claude.ai.

### `file-organizer` †
Sorts, renames, and organises messy folders of files into a clean, logical structure.

### `media-asset-management` †
Organises image, video, and audio libraries with tagging, metadata, naming conventions, and searchability.

### `content-migration` †
Moves content between platforms or CMSs (for example WordPress to another system) while keeping URLs, formatting, and SEO intact.

---

## 8. Engineering, Ops and Security

### `api-hardening`
Secures APIs against abuse with rate limiting, input validation, CORS configuration, API key management, and request throttling, with practical code for Express, FastAPI, and serverless.

### `accessibility-audit`
Runs a full WCAG audit (perceivable, operable, understandable, robust) covering screen readers, keyboard navigation, and contrast, and delivers a remediation plan.

### `accessibility-compliance`
Accessibility patterns built for news sites, journalism tools, and academic platforms: alt text for news images, accessible charts, and WCAG compliance.

### `performance-optimization` †
Speeds up websites and applications through load times, bundle size, caching, database queries, and Core Web Vitals.

### `cost-optimization` †
Cuts cloud and infrastructure spending by finding waste, rightsizing resources, and choosing cheaper architectures.

### `backup-and-disaster-recovery`
Plans backups and disaster recovery: recovery targets (RPO and RTO), backup architecture, plans for a full outage, and restore drills that prove backups actually work.

### `after-action-report`
Runs blameless postmortems and retrospectives after a launch or incident, covering the timeline, root cause (five whys), contributing factors, and concrete lessons learned.

### `code-review-web` †
Reviews web application code (frontend and backend) for bugs, security problems, and best practices.

---

## 9. Tools, Connectors and Misc

### `built-in-browser` / `chrome-browser` †
Controls a web browser to visit sites, click, fill forms, take screenshots, and automate web tasks.

### `computer-use` †
Operates a full desktop through screenshots, mouse, and keyboard for tasks that need a GUI rather than a command line.

### `connect` / `connect-apps` †
Connects Claude to outside apps and services (Gmail, Slack, Notion, CRMs, and others) so it can read and act on them.

### `content-access` †
Accesses content stored behind connected services and integrations.

### `google-workspace` †
Works across Gmail, Google Drive, Docs, Sheets, and Calendar: reading, drafting, organising, and scheduling.

### `import-memory` †
Imports saved memories, preferences, or context from another tool or past sessions so Claude knows your background.

### `morning` †
A daily morning briefing that summarises your calendar, priorities, messages, and news to start the day.

### `skill-creator` †
Builds new custom skills: packaging your own repeatable workflows and instructions so Claude can reuse them.

### `skill-share` †
Shares your custom skills with teammates or your organisation.

### `tailored-resume-generator` †
Rewrites your resume to match a specific job description, highlighting the most relevant experience and keywords.
