"use strict";

const path = require("path");
const crypto = require("crypto");
const express = require("express");

const store = require("./lib/store");
const mailer = require("./lib/mailer");
const emails = require("./lib/emails");

const app = express();
const PORT = process.env.PORT || 3000;
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD || "saltstayz123";
const BASE_URL = process.env.BASE_URL || `http://localhost:${PORT}`;

app.use(express.json());
app.use(express.static(path.join(__dirname, "public")));

/* ---------- admin auth (token in memory) ---------- */
const sessions = new Set();

function requireAdmin(req, res, next) {
  const token = (req.headers.authorization || "").replace(/^Bearer\s+/i, "");
  if (token && sessions.has(token)) return next();
  res.status(401).json({ error: "Unauthorized. Please log in." });
}

app.post("/api/admin/login", (req, res) => {
  const { password } = req.body || {};
  if (password !== ADMIN_PASSWORD) {
    return res.status(401).json({ error: "Incorrect password." });
  }
  const token = crypto.randomBytes(24).toString("hex");
  sessions.add(token);
  res.json({ token });
});

app.post("/api/admin/logout", requireAdmin, (req, res) => {
  const token = (req.headers.authorization || "").replace(/^Bearer\s+/i, "");
  sessions.delete(token);
  res.json({ ok: true });
});

/* ---------- validation helpers ---------- */
const PROPERTIES = ["Golf Course Road", "Sector 39", "MG Road", "Cyber City"];
const APARTMENTS = ["Studio Apartment", "1 BHK Apartment", "2 BHK Apartment", "Premium Suite"];

function validateBooking(body) {
  const errors = [];
  const b = {
    name: String(body.name || "").trim(),
    email: String(body.email || "").trim().toLowerCase(),
    phone: String(body.phone || "").trim(),
    property: String(body.property || "").trim(),
    apartmentType: String(body.apartmentType || "").trim(),
    checkIn: String(body.checkIn || "").trim(),
    checkOut: String(body.checkOut || "").trim(),
    guests: Math.max(1, Math.min(10, parseInt(body.guests, 10) || 1)),
    notes: String(body.notes || "").trim().slice(0, 500),
  };
  if (b.name.length < 2) errors.push("Please enter the guest's full name.");
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(b.email)) errors.push("Please enter a valid email address.");
  if (b.phone.replace(/\D/g, "").length < 10) errors.push("Please enter a valid phone number.");
  if (!PROPERTIES.includes(b.property)) errors.push("Please choose a property.");
  if (!APARTMENTS.includes(b.apartmentType)) errors.push("Please choose an apartment type.");
  if (!/^\d{4}-\d{2}-\d{2}$/.test(b.checkIn)) errors.push("Please pick a check-in date.");
  if (!/^\d{4}-\d{2}-\d{2}$/.test(b.checkOut)) errors.push("Please pick a check-out date.");
  if (!errors.length && new Date(b.checkOut) <= new Date(b.checkIn)) {
    errors.push("Check-out must be after check-in.");
  }
  return { booking: b, errors };
}

/* ---------- public API ---------- */

app.get("/api/meta", (req, res) => {
  res.json({ properties: PROPERTIES, apartments: APARTMENTS, mailMode: mailer.isConfigured() ? "smtp" : "outbox" });
});

/* Guest creates a booking request */
app.post("/api/bookings", async (req, res) => {
  const { booking, errors } = validateBooking(req.body || {});
  if (errors.length) return res.status(400).json({ errors });

  const db = store.load();
  const record = {
    id: store.newBookingId(),
    ...booking,
    status: "pending",
    feedbackToken: store.newToken(),
    emailsSent: [],
    createdAt: new Date().toISOString(),
  };
  db.bookings.unshift(record);
  store.save(db);

  try {
    const mail = await mailer.send(record.email, emails.bookingReceived(record));
    record.emailsSent.push({ type: "received", at: new Date().toISOString(), via: mail.via });
    store.save(db);
  } catch (err) {
    console.error("[mail] booking-received failed:", err.message);
  }

  res.status(201).json({ id: record.id, status: record.status });
});

/* Feedback: fetch stay info by token */
app.get("/api/feedback/:token", (req, res) => {
  const db = store.load();
  const b = db.bookings.find((x) => x.feedbackToken === req.params.token);
  if (!b) return res.status(404).json({ error: "This feedback link is invalid or has expired." });
  const already = db.feedback.some((f) => f.bookingId === b.id);
  res.json({ bookingId: b.id, name: b.name, property: b.property, alreadySubmitted: already });
});

/* Feedback: submit */
app.post("/api/feedback/:token", (req, res) => {
  const db = store.load();
  const b = db.bookings.find((x) => x.feedbackToken === req.params.token);
  if (!b) return res.status(404).json({ error: "This feedback link is invalid or has expired." });
  if (db.feedback.some((f) => f.bookingId === b.id)) {
    return res.status(409).json({ error: "Feedback for this stay has already been submitted. Thank you!" });
  }
  const rating = Math.max(1, Math.min(5, parseInt(req.body.rating, 10) || 0));
  if (!rating) return res.status(400).json({ error: "Please choose a rating from 1 to 5." });
  db.feedback.unshift({
    bookingId: b.id,
    guest: b.name,
    property: b.property,
    rating,
    comments: String(req.body.comments || "").trim().slice(0, 1000),
    createdAt: new Date().toISOString(),
  });
  store.save(db);
  res.status(201).json({ ok: true });
});

/* ---------- admin API ---------- */

app.get("/api/admin/bookings", requireAdmin, (req, res) => {
  const db = store.load();
  res.json({ bookings: db.bookings });
});

app.get("/api/admin/feedback", requireAdmin, (req, res) => {
  const db = store.load();
  res.json({ feedback: db.feedback });
});

function findBooking(db, id, res) {
  const b = db.bookings.find((x) => x.id === id);
  if (!b) res.status(404).json({ error: "Booking not found." });
  return b;
}

/* Confirm booking → confirmation email to guest */
app.post("/api/admin/bookings/:id/confirm", requireAdmin, async (req, res) => {
  const db = store.load();
  const b = findBooking(db, req.params.id, res);
  if (!b) return;
  if (b.status !== "pending") {
    return res.status(409).json({ error: `Booking is already ${b.status}.` });
  }
  b.status = "confirmed";
  let mail = null;
  try {
    mail = await mailer.send(b.email, emails.bookingConfirmed(b));
    b.emailsSent.push({ type: "confirmed", at: new Date().toISOString(), via: mail.via });
  } catch (err) {
    console.error("[mail] confirm failed:", err.message);
  }
  store.save(db);
  res.json({ booking: b, mail: mail ? mail.via : "failed" });
});

/* Check out → checkout email + thanks/feedback email */
app.post("/api/admin/bookings/:id/checkout", requireAdmin, async (req, res) => {
  const db = store.load();
  const b = findBooking(db, req.params.id, res);
  if (!b) return;
  if (b.status !== "confirmed") {
    return res.status(409).json({ error: `Only confirmed bookings can be checked out (current: ${b.status}).` });
  }
  b.status = "checked_out";
  const feedbackUrl = `${BASE_URL}/feedback.html?token=${b.feedbackToken}`;
  const sent = [];
  try {
    const m1 = await mailer.send(b.email, emails.checkoutEmail(b));
    b.emailsSent.push({ type: "checkout", at: new Date().toISOString(), via: m1.via });
    sent.push("checkout");
    const m2 = await mailer.send(b.email, emails.thanksFeedback(b, feedbackUrl));
    b.emailsSent.push({ type: "thanks_feedback", at: new Date().toISOString(), via: m2.via });
    sent.push("thanks_feedback");
  } catch (err) {
    console.error("[mail] checkout failed:", err.message);
  }
  store.save(db);
  res.json({ booking: b, emailsSent: sent, feedbackUrl });
});

/* Cancel */
app.post("/api/admin/bookings/:id/cancel", requireAdmin, (req, res) => {
  const db = store.load();
  const b = findBooking(db, req.params.id, res);
  if (!b) return;
  if (b.status === "checked_out") {
    return res.status(409).json({ error: "Checked-out bookings cannot be cancelled." });
  }
  b.status = "cancelled";
  store.save(db);
  res.json({ booking: b });
});

/* ---------- start ---------- */
app.listen(PORT, () => {
  console.log(`SaltStayz running at http://localhost:${PORT}`);
  console.log(`  Guest site : ${BASE_URL}/`);
  console.log(`  Admin panel: ${BASE_URL}/admin.html  (password: ${ADMIN_PASSWORD === "saltstayz123" ? "saltstayz123 — change via ADMIN_PASSWORD" : "set via env"})`);
});
