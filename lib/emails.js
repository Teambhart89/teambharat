"use strict";

/**
 * Brand-styled HTML email templates for the SaltStayz guest journey.
 * All templates return { subject, html, text }.
 */

const BRAND = {
  green: "#4f7134",
  greenDark: "#405c2a",
  cream: "#f5f3ec",
  ink: "#1a1a1a",
  white: "#ffffff",
};

function fmtDate(iso) {
  if (!iso) return "—";
  const d = new Date(iso + "T00:00:00");
  if (isNaN(d)) return iso;
  return d.toLocaleDateString("en-IN", { weekday: "short", day: "numeric", month: "short", year: "numeric" });
}

function nights(checkIn, checkOut) {
  const a = new Date(checkIn), b = new Date(checkOut);
  const n = Math.round((b - a) / 86400000);
  return isNaN(n) || n < 1 ? 1 : n;
}

function layout(title, bodyHtml) {
  return `<!DOCTYPE html>
<html lang="en">
<body style="margin:0;padding:0;background:${BRAND.cream};font-family:Calibri,Carlito,'Trebuchet MS','Segoe UI',sans-serif;color:${BRAND.ink};">
  <div style="max-width:560px;margin:0 auto;padding:20px;">
    <div style="background:${BRAND.green};border-radius:16px 16px 0 0;padding:20px;text-align:center;">
      <span style="font-size:22px;font-weight:bold;color:${BRAND.white};letter-spacing:2px;">SALTSTAYZ</span><br>
      <span style="font-size:12px;color:${BRAND.cream};letter-spacing:1px;">SERVICED APARTMENTS &amp; STUDIOS</span>
    </div>
    <div style="background:${BRAND.white};border-radius:0 0 16px 16px;padding:24px;line-height:24px;font-size:16px;">
      <h1 style="font-size:22px;margin:0 0 14px;color:${BRAND.ink};">${title}</h1>
      ${bodyHtml}
      <p style="margin:20px 0 0;">Warm regards,<br><strong>Team SaltStayz</strong><br>
      <a href="https://saltstayz.com" style="color:${BRAND.green};">saltstayz.com</a></p>
    </div>
    <p style="text-align:center;font-size:12px;color:#5f5f5f;margin-top:14px;">
      You are receiving this email about your SaltStayz reservation.
    </p>
  </div>
</body>
</html>`;
}

function detailsTable(b) {
  const rows = [
    ["Booking ID", b.id],
    ["Guest", b.name],
    ["Property", b.property],
    ["Apartment", b.apartmentType],
    ["Check-in", fmtDate(b.checkIn)],
    ["Check-out", fmtDate(b.checkOut)],
    ["Guests", String(b.guests)],
    ["Nights", String(nights(b.checkIn, b.checkOut))],
  ];
  return `<table style="width:100%;border-collapse:collapse;font-size:15px;margin:14px 0;">
    ${rows.map(([k, v]) => `<tr>
      <td style="padding:8px 10px;background:${BRAND.cream};font-weight:bold;border-bottom:2px solid ${BRAND.white};width:40%;">${k}</td>
      <td style="padding:8px 10px;background:${BRAND.cream};border-bottom:2px solid ${BRAND.white};">${v}</td>
    </tr>`).join("")}
  </table>`;
}

function detailsText(b) {
  return [
    `Booking ID: ${b.id}`,
    `Guest: ${b.name}`,
    `Property: ${b.property}`,
    `Apartment: ${b.apartmentType}`,
    `Check-in: ${fmtDate(b.checkIn)}`,
    `Check-out: ${fmtDate(b.checkOut)}`,
    `Guests: ${b.guests}`,
    `Nights: ${nights(b.checkIn, b.checkOut)}`,
  ].join("\n");
}

/* 1. Booking request received (sent automatically when guest books) */
function bookingReceived(b) {
  return {
    subject: `We've received your booking request — ${b.id}`,
    html: layout("Thanks — your request is in!", `
      <p>Hi ${b.name},</p>
      <p>Thanks for choosing SaltStayz. We've received your booking request and our team is
      reviewing availability. You'll get a confirmation email shortly.</p>
      ${detailsTable(b)}
      <p>Need to change anything? Just reply to this email or call us at
      <a href="tel:+919000000000" style="color:${BRAND.green};">+91 90000 00000</a>.</p>`),
    text: `Hi ${b.name},\n\nThanks for choosing SaltStayz. We've received your booking request (${b.id}) and will confirm it shortly.\n\n${detailsText(b)}\n\nTeam SaltStayz`,
  };
}

/* 2. Booking confirmed (sent when admin confirms) */
function bookingConfirmed(b) {
  return {
    subject: `Booking confirmed ✔ ${b.property}, ${fmtDate(b.checkIn)} — ${b.id}`,
    html: layout("Your booking is confirmed!", `
      <p>Hi ${b.name},</p>
      <p>Great news — your SaltStayz booking is <strong style="color:${BRAND.green};">confirmed</strong>.
      We look forward to hosting you.</p>
      ${detailsTable(b)}
      <div style="background:${BRAND.cream};border-radius:12px;padding:14px 16px;margin:14px 0;">
        <strong>Good to know</strong>
        <ul style="margin:8px 0 0;padding-left:18px;">
          <li>Check-in from 1:00 PM, check-out by 11:00 AM</li>
          <li>Free high-speed Wi-Fi, housekeeping and 24×7 front desk</li>
          <li>Carry a government-issued photo ID for check-in</li>
        </ul>
      </div>
      <p>See you soon!</p>`),
    text: `Hi ${b.name},\n\nYour SaltStayz booking is CONFIRMED.\n\n${detailsText(b)}\n\nCheck-in from 1:00 PM, check-out by 11:00 AM. Please carry a photo ID.\n\nTeam SaltStayz`,
  };
}

/* 3. Check-out email (sent when admin checks the guest out) */
function checkoutEmail(b) {
  return {
    subject: `Checked out — summary of your stay ${b.id}`,
    html: layout("You're all checked out", `
      <p>Hi ${b.name},</p>
      <p>This confirms your check-out from <strong>${b.property}</strong>. Here's a summary of your stay:</p>
      ${detailsTable(b)}
      <p>If you left anything behind or have a billing question, reply to this email and
      we'll sort it out right away.</p>`),
    text: `Hi ${b.name},\n\nThis confirms your check-out from ${b.property}.\n\n${detailsText(b)}\n\nTeam SaltStayz`,
  };
}

/* 4. Thanks-for-staying + feedback request */
function thanksFeedback(b, feedbackUrl) {
  return {
    subject: `Thank you for staying with SaltStayz, ${b.name}! 🌿`,
    html: layout("Thank you for staying with us", `
      <p>Hi ${b.name},</p>
      <p>It was a pleasure hosting you at <strong>${b.property}</strong>. We hope your stay
      felt like home — that's what we aim for, every single time.</p>
      <p>Could you spare 60 seconds to tell us how we did? Your feedback directly shapes
      how we improve.</p>
      <p style="text-align:center;margin:22px 0;">
        <a href="${feedbackUrl}" style="background:${BRAND.green};color:${BRAND.white};text-decoration:none;padding:12px 28px;border-radius:9999px;font-weight:bold;display:inline-block;">Share your feedback</a>
      </p>
      <p style="font-size:13px;color:#5f5f5f;">Or copy this link: <a href="${feedbackUrl}" style="color:${BRAND.green};">${feedbackUrl}</a></p>
      <p>We'd love to welcome you back — your next stay is on us to make even better.</p>`),
    text: `Hi ${b.name},\n\nThank you for staying at ${b.property}! We'd love your feedback (takes 60 seconds):\n${feedbackUrl}\n\nHope to host you again soon.\n\nTeam SaltStayz`,
  };
}

module.exports = { bookingReceived, bookingConfirmed, checkoutEmail, thanksFeedback };
