"use strict";

/**
 * Mailer: sends real email when SMTP_* env vars are configured,
 * otherwise writes each email to ./outbox as an .html file so the
 * full flow can be tested without credentials.
 *
 * Env vars:
 *   SMTP_HOST, SMTP_PORT, SMTP_USER, SMTP_PASS  — SMTP credentials
 *   MAIL_FROM — from address (default "SaltStayz <no-reply@saltstayz.com>")
 *
 * Gmail example: SMTP_HOST=smtp.gmail.com SMTP_PORT=465
 *   SMTP_USER=you@gmail.com SMTP_PASS=<app password>
 */

const fs = require("fs");
const path = require("path");
const nodemailer = require("nodemailer");

const OUTBOX = process.env.OUTBOX_DIR || path.join(__dirname, "..", "outbox");
const FROM = process.env.MAIL_FROM || "SaltStayz <no-reply@saltstayz.com>";

let transporter = null;
if (process.env.SMTP_HOST && process.env.SMTP_USER && process.env.SMTP_PASS) {
  transporter = nodemailer.createTransport({
    host: process.env.SMTP_HOST,
    port: Number(process.env.SMTP_PORT || 465),
    secure: Number(process.env.SMTP_PORT || 465) === 465,
    auth: { user: process.env.SMTP_USER, pass: process.env.SMTP_PASS },
  });
  console.log(`[mailer] SMTP configured (${process.env.SMTP_HOST}) — real emails will be sent.`);
} else {
  console.log("[mailer] SMTP not configured — emails will be saved to ./outbox instead.");
}

async function send(to, { subject, html, text }) {
  if (transporter) {
    const info = await transporter.sendMail({ from: FROM, to, subject, html, text });
    console.log(`[mailer] sent "${subject}" to ${to} (${info.messageId})`);
    return { delivered: true, via: "smtp", id: info.messageId };
  }
  fs.mkdirSync(OUTBOX, { recursive: true });
  const stamp = new Date().toISOString().replace(/[:.]/g, "-");
  const safeSubject = subject.replace(/[^a-z0-9]+/gi, "_").slice(0, 60);
  const file = path.join(OUTBOX, `${stamp}__${safeSubject}.html`);
  const wrapped = `<!-- To: ${to}\n     Subject: ${subject}\n     From: ${FROM} -->\n${html}`;
  fs.writeFileSync(file, wrapped);
  console.log(`[mailer] (outbox) "${subject}" -> ${to} saved to ${file}`);
  return { delivered: false, via: "outbox", file };
}

module.exports = { send, isConfigured: () => Boolean(transporter) };
