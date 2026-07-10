# SaltStayz — Serviced Apartment Website + Booking Backend

A full-stack clone-style website inspired by saltstayz.com (original content), with a
working booking backend, operator admin panel, and automated guest emails.

## Features

- **Guest site** (`/`) — hero, apartment types, 4 Gurgaon locations, amenities,
  testimonials and a live booking form with validation.
- **Admin booking panel** (`/admin.html`) — password-protected. View bookings,
  **Confirm** (sends confirmation email), **Check out** (sends check-out email +
  thank-you email with a feedback link), **Cancel**, stats tiles, and a guest
  feedback tab.
- **Guest emails** (4 automated flows):
  1. Booking request received (on submit)
  2. Booking confirmed (operator clicks *Confirm*)
  3. Check-out summary (operator clicks *Check out*)
  4. Thanks-for-staying + feedback request with a unique link
- **Feedback page** (`/feedback.html?token=...`) — 1–5 star rating + comments,
  one submission per stay, results shown in the admin panel.

## Run locally

```bash
npm install
npm start
# Guest site : http://localhost:3000/
# Admin panel: http://localhost:3000/admin.html   (password: saltstayz123)
```

Without SMTP configured the app runs in **demo mail mode**: every email is saved
as an HTML file in `./outbox/` so you can open and inspect exactly what the guest
would receive.

## Send real emails (Gmail example)

1. Create an App Password: https://myaccount.google.com/apppasswords
2. Set environment variables (see `.env.example`):

```bash
SMTP_HOST=smtp.gmail.com
SMTP_PORT=465
SMTP_USER=yourname@gmail.com
SMTP_PASS=your-16-char-app-password
MAIL_FROM="SaltStayz <yourname@gmail.com>"
ADMIN_PASSWORD=choose-a-strong-password
BASE_URL=https://your-deployed-url.example.com
```

## Deploy for a live link (free)

**Render** (recommended): create a new *Web Service* from this repo,
build command `npm install`, start command `node server.js`, then add the
env vars above. Railway, Fly.io or any Node host works the same way.
`BASE_URL` must be set to the public URL so feedback links in emails work.

> Note: bookings are stored in `data/db.json`. On hosts with ephemeral disks,
> attach a persistent disk (Render: add a Disk mounted at `/opt/render/project/src/data`)
> or set `DATA_DIR` to a persisted path.

## Project layout

```
server.js          Express app + API routes
lib/store.js       JSON file storage (data/db.json)
lib/mailer.js      SMTP via nodemailer, or ./outbox fallback
lib/emails.js      Branded HTML email templates
public/index.html  Guest website + booking form
public/admin.html  Operator booking panel
public/feedback.html  Guest feedback form
```

---

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
