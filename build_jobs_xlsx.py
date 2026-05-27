"""
Compile all job search results into an xlsx file.
Run: python build_jobs_xlsx.py
"""
import pandas as pd
from datetime import datetime

jobs = [
    # ── US ──────────────────────────────────────────────────────────────────
    {
        "Region": "US",
        "Job Title": "General Ledger Accountant (Remote, Part-Time)",
        "Company": "Wesley International",
        "Location": "Stone Mountain, GA (Remote)",
        "Country": "United States",
        "Job Type": "Part-Time / Remote",
        "Salary / Rate": "Not disclosed",
        "Currency": "USD",
        "Date Posted": "2026 (recent)",
        "Source Platform": "Glassdoor",
        "Job URL": "https://www.glassdoor.com/job-listing/general-ledger-accountant-remote-part-time-stone-mountain-ga-wesley-international-JV_KO0,60_KE61,81.htm?jl=1009607480055",
        "Key Skills": "GL, Journal Entries, Month-End Close, P&L Reporting",
        "Notes": "Fractional / part-time remote role; US GAAP",
    },
    {
        "Region": "US",
        "Job Title": "GL Accountant (Remote, Part-Time)",
        "Company": "The Ensign Group Inc",
        "Location": "Remote – United States",
        "Country": "United States",
        "Job Type": "Part-Time / Remote",
        "Salary / Rate": "Not disclosed",
        "Currency": "USD",
        "Date Posted": "March 2026",
        "Source Platform": "Lensa / LinkedIn",
        "Job URL": "https://lensa.com/job-v1/the-ensign-group-inc/remote/general-ledger-accountant-part-time/b0892c203f37f8c7c1366a8cd0faf803",
        "Key Skills": "General Ledger, Fixed Assets, Reconciliation, Journal Entries",
        "Notes": "Part-time support role; healthcare sector",
    },
    {
        "Region": "US",
        "Job Title": "General Ledger Accountant (Remote)",
        "Company": "Mattermost",
        "Location": "Denver, CO (Remote)",
        "Country": "United States",
        "Job Type": "Full-Time / Remote",
        "Salary / Rate": "Not disclosed",
        "Currency": "USD",
        "Date Posted": "2026 (recent)",
        "Source Platform": "LinkedIn",
        "Job URL": "https://www.linkedin.com/jobs/view/general-ledger-accountant-remote-at-mattermost-3814762343",
        "Key Skills": "GL, US GAAP, Month-End Close, Reconciliation",
        "Notes": "Remote-first global company",
    },
    {
        "Region": "US",
        "Job Title": "GL Accountant (Remote)",
        "Company": "Teamshares",
        "Location": "Remote – United States",
        "Country": "United States",
        "Job Type": "Full-Time / Remote",
        "Salary / Rate": "Not disclosed",
        "Currency": "USD",
        "Date Posted": "February 2026",
        "Source Platform": "RemoteOK",
        "Job URL": "https://remoteok.com/remote-jobs/remote-gl-accountant-teamshares-1130157",
        "Key Skills": "General Ledger, US GAAP, Month-End Close",
        "Notes": "Employee-owned small business platform",
    },
    {
        "Region": "US",
        "Job Title": "GL Mapping Accountant (Remote, Contract)",
        "Company": "Robert Half (Banking Client)",
        "Location": "Remote – United States",
        "Country": "United States",
        "Job Type": "Contract / Temporary",
        "Salary / Rate": "$30 – $37 / hour",
        "Currency": "USD",
        "Date Posted": "2026 (recent)",
        "Source Platform": "Robert Half",
        "Job URL": "https://www.roberthalf.com/us/en/jobs/all/remote-accounting",
        "Key Skills": "GL Mapping, Chart of Accounts, US GAAP",
        "Notes": "Temporary/contract; banking sector; fully remote",
    },
    {
        "Region": "US",
        "Job Title": "Senior GL Accountant (Contract / Contract-to-Hire)",
        "Company": "Robert Half (Client Undisclosed)",
        "Location": "Reston, VA (Hybrid)",
        "Country": "United States",
        "Job Type": "Contract / Hybrid",
        "Salary / Rate": "$50 – $70 / hour",
        "Currency": "USD",
        "Date Posted": "2026 (recent)",
        "Source Platform": "Robert Half",
        "Job URL": "https://www.roberthalf.com/us/en/jobs/all/remote-accounting",
        "Key Skills": "Senior GL, Month-End Close, Reconciliation, US GAAP",
        "Notes": "Contract with potential hire; hybrid Reston VA",
    },
    {
        "Region": "US",
        "Job Title": "General Ledger Accountant I",
        "Company": "Augusta ENT, P.C.",
        "Location": "Remote – United States",
        "Country": "United States",
        "Job Type": "Full-Time / Remote",
        "Salary / Rate": "Not disclosed",
        "Currency": "USD",
        "Date Posted": "2026 (recent)",
        "Source Platform": "LinkedIn",
        "Job URL": "https://www.linkedin.com/jobs/view/general-ledger-accountant-i-at-augusta-ent-p-c-4381456923",
        "Key Skills": "GL, Journal Entries, Reconciliation",
        "Notes": "Healthcare sector; entry-level GL role",
    },
    {
        "Region": "US",
        "Job Title": "Partnership Accountant (Part-Time, Remote)",
        "Company": "Pathway",
        "Location": "Remote – United States",
        "Country": "United States",
        "Job Type": "Part-Time / Remote",
        "Salary / Rate": "10–20 hrs/week (rate undisclosed)",
        "Currency": "USD",
        "Date Posted": "2026 (recent)",
        "Source Platform": "Robert Half / Job Boards",
        "Job URL": "https://www.roberthalf.com/us/en/jobs/all/part-time-accounting-remote",
        "Key Skills": "Partnership Accounting, Reporting, GL",
        "Notes": "Part-time with potential to grow; US GAAP",
    },

    # ── UK ──────────────────────────────────────────────────────────────────
    {
        "Region": "UK",
        "Job Title": "General Ledger Accountant (Contract)",
        "Company": "Undisclosed (via Recruitment Agency)",
        "Location": "Belfast, Northern Ireland (Remote/Hybrid)",
        "Country": "United Kingdom",
        "Job Type": "Contract (10-Month)",
        "Salary / Rate": "£32.75 / hour",
        "Currency": "GBP",
        "Date Posted": "April – May 2026",
        "Source Platform": "Reed.co.uk / CV-Library",
        "Job URL": "https://www.reed.co.uk/jobs/accountant-fully-remote-jobs",
        "Key Skills": "GL, Month-End Close, Reconciliation, IFRS",
        "Notes": "10-month contract; £32.75/hr; Belfast based, remote eligible",
    },
    {
        "Region": "UK",
        "Job Title": "Financial Accountant (Global Consumer)",
        "Company": "Undisclosed (via Marc Daniels Recruitment)",
        "Location": "West London (Hybrid – 2 days office)",
        "Country": "United Kingdom",
        "Job Type": "Contract (5-Month) / Hybrid",
        "Salary / Rate": "£250 – £290 / day (PAYE)",
        "Currency": "GBP",
        "Date Posted": "April – May 2026",
        "Source Platform": "CV-Library / LinkedIn",
        "Job URL": "https://www.cv-library.co.uk/remote-accountancy-jobs",
        "Key Skills": "Financial Accounting, Month-End, Stakeholder Reporting",
        "Notes": "Day rate PAYE; 5-month contract; 2 days in West London office",
    },
    {
        "Region": "UK",
        "Job Title": "Financial Accountant (Paternity Cover)",
        "Company": "Undisclosed Retail Company",
        "Location": "South West London (Hybrid)",
        "Country": "United Kingdom",
        "Job Type": "Contract (2-Month) / Hybrid",
        "Salary / Rate": "£55,000 – £70,000 / year (pro-rata)",
        "Currency": "GBP",
        "Date Posted": "April – May 2026",
        "Source Platform": "CV-Library / Reed",
        "Job URL": "https://www.cv-library.co.uk/remote-accountancy-jobs",
        "Key Skills": "Financial Accounting, GL, Month-End, Retail",
        "Notes": "2-month cover; retail sector; hybrid South West London",
    },
    {
        "Region": "UK",
        "Job Title": "Remote Accountant (Multiple Openings)",
        "Company": "Various (341 openings on LinkedIn UK)",
        "Location": "Remote – United Kingdom",
        "Country": "United Kingdom",
        "Job Type": "Contract / Part-Time / Remote",
        "Salary / Rate": "Market rate (GBP)",
        "Currency": "GBP",
        "Date Posted": "May 2026",
        "Source Platform": "LinkedIn UK",
        "Job URL": "https://uk.linkedin.com/jobs/remote-accountant-jobs",
        "Key Skills": "GL, R2R, Financial Accounting, IFRS",
        "Notes": "341 remote accountant openings on LinkedIn UK as of May 2026",
    },
    {
        "Region": "UK",
        "Job Title": "Accountant – Fully Remote (Multiple)",
        "Company": "Various (200 openings on Reed)",
        "Location": "Remote – United Kingdom",
        "Country": "United Kingdom",
        "Job Type": "Full-Time / Part-Time / Contract",
        "Salary / Rate": "Market rate (GBP)",
        "Currency": "GBP",
        "Date Posted": "May 2026",
        "Source Platform": "Reed.co.uk",
        "Job URL": "https://www.reed.co.uk/jobs/accountant-fully-remote-jobs",
        "Key Skills": "Accounting, GL, Reconciliation, Reporting",
        "Notes": "200 fully-remote accountant jobs on Reed as of May 2026",
    },

    # ── EU / EMEA ────────────────────────────────────────────────────────────
    {
        "Region": "EU / EMEA",
        "Job Title": "General Ledger Accountant",
        "Company": "Taxfix",
        "Location": "Remote – Europe",
        "Country": "Germany / EU",
        "Job Type": "Full-Time / Remote",
        "Salary / Rate": "Not disclosed",
        "Currency": "EUR",
        "Date Posted": "2026 (recent)",
        "Source Platform": "Remotive.com",
        "Job URL": "https://remotive.com/remote/jobs/finance-legal/general-ledger-accountant-1765374",
        "Key Skills": "GL, IFRS, IFRS 16, Consolidation, Journal Entries",
        "Notes": "FinTech company; IFRS conversion/reporting; EU remote",
    },
    {
        "Region": "EU / EMEA",
        "Job Title": "Experienced GL Accountant",
        "Company": "Akamai Technologies",
        "Location": "Remote – EMEA / Americas / APJ",
        "Country": "EU / Global",
        "Job Type": "Full-Time / Remote",
        "Salary / Rate": "Not disclosed",
        "Currency": "USD / EUR",
        "Date Posted": "2026 (recent)",
        "Source Platform": "Remotive.com",
        "Job URL": "https://remotive.com/remote/jobs/finance/experienced-gl-accountant-4435012",
        "Key Skills": "GL, IFRS, US GAAP, International Accounting, 40 countries",
        "Notes": "Supports international operations in EMEA, Americas, APJ",
    },
    {
        "Region": "EU / EMEA",
        "Job Title": "IFRS Accountant (Multi-Jurisdiction)",
        "Company": "Flag Theory",
        "Location": "Remote – Europe Time Zone",
        "Country": "EU (any country)",
        "Job Type": "Full-Time / Remote",
        "Salary / Rate": "Not disclosed",
        "Currency": "EUR / USD",
        "Date Posted": "2026 (recent)",
        "Source Platform": "We Work Remotely",
        "Job URL": "https://weworkremotely.com/remote-jobs/flag-theory-ifrs-accountant-with-multiple-jurisdiction-experience",
        "Key Skills": "IFRS, Multi-Jurisdiction, Financial Statements, EU Compliance",
        "Notes": "Full IFRS reporting; multiple jurisdictions; EU TZ required",
    },
    {
        "Region": "EU / EMEA",
        "Job Title": "Freelance GL Accountant – Logistics",
        "Company": "Undisclosed Logistics Company (Brussels)",
        "Location": "Brussels, Belgium",
        "Country": "Belgium / EU",
        "Job Type": "Freelance",
        "Salary / Rate": "Negotiable (day rate)",
        "Currency": "EUR",
        "Date Posted": "2026 (recent)",
        "Source Platform": "LinkedIn",
        "Job URL": "https://www.linkedin.com/pulse/freelance-gl-accountant-logistics-brussels-bilal-tariq-ydrze",
        "Key Skills": "GL, Logistics Industry, IFRS, Month-End Close",
        "Notes": "Freelance engagement via recruiter; logistics sector; Brussels",
    },
    {
        "Region": "EU / EMEA",
        "Job Title": "Remote Accountant – Europe (Multiple)",
        "Company": "Various (129 openings)",
        "Location": "Remote – Europe",
        "Country": "EU (any country)",
        "Job Type": "Remote / Contract / Freelance",
        "Salary / Rate": "Market rate (EUR)",
        "Currency": "EUR",
        "Date Posted": "May 2026",
        "Source Platform": "RemoteRocketship / euremotejobs",
        "Job URL": "https://www.remoterocketship.com/country/europe/jobs/accounting/",
        "Key Skills": "IFRS, GL, R2R, Reconciliation",
        "Notes": "129 remote accountant roles listed for Europe May 2026",
    },

    # ── Middle East / GCC ────────────────────────────────────────────────────
    {
        "Region": "Middle East",
        "Job Title": "General Ledger Accountant (Fixed-Term Contract)",
        "Company": "Undisclosed Company",
        "Location": "Dubai, UAE",
        "Country": "United Arab Emirates",
        "Job Type": "Contract (1 Year)",
        "Salary / Rate": "Not disclosed",
        "Currency": "AED / USD",
        "Date Posted": "April – May 2026",
        "Source Platform": "Bayt.com / Glassdoor",
        "Job URL": "https://www.bayt.com/en/international/jobs/remote-accounting-jobs/",
        "Key Skills": "GL, IFRS, ERP Implementation, Day-to-Day GL Activities",
        "Notes": "1-year FTC; Dubai; IFRS and ERP implementation focus",
    },
    {
        "Region": "Middle East",
        "Job Title": "Senior General Ledger Accountant",
        "Company": "Undisclosed Company",
        "Location": "Riyadh, Saudi Arabia",
        "Country": "Saudi Arabia",
        "Job Type": "Full-Time (On-site / Hybrid)",
        "Salary / Rate": "Not disclosed",
        "Currency": "SAR / USD",
        "Date Posted": "April – May 2026",
        "Source Platform": "Bayt.com / LinkedIn",
        "Job URL": "https://www.bayt.com/en/international/jobs/ledger-jobs/",
        "Key Skills": "GL, Financial Statements, Audit Support, General Ledger Integrity",
        "Notes": "Senior level; Riyadh; SAR; audit support role",
    },
    {
        "Region": "Middle East",
        "Job Title": "Part-Time Accountant (10–20 hrs/week)",
        "Company": "Undisclosed",
        "Location": "Remote – Middle East",
        "Country": "UAE / GCC",
        "Job Type": "Part-Time / Remote",
        "Salary / Rate": "Not disclosed (AED rate)",
        "Currency": "AED",
        "Date Posted": "2026 (recent)",
        "Source Platform": "Bayt.com / Indeed AE",
        "Job URL": "https://ae.indeed.com/q-accounts-payable,-remote-jobs.html",
        "Key Skills": "AP/AR, Financial Reporting, GL, 10+ years experience",
        "Notes": "Part-time remote; 10-20 hrs/week; 10+ yrs exp required",
    },
    {
        "Region": "Middle East",
        "Job Title": "Remote Accounting Jobs – GCC (Multiple)",
        "Company": "Various (38,000+ vacancies Q1 2026)",
        "Location": "Qatar / UAE / Saudi Arabia",
        "Country": "GCC",
        "Job Type": "Full-Time / Contract / Remote",
        "Salary / Rate": "AED 22,672 avg/year (27 remote openings)",
        "Currency": "AED / USD",
        "Date Posted": "Q1 2026",
        "Source Platform": "Bayt.com / Glassdoor / RemoteRocketship",
        "Job URL": "https://www.remoterocketship.com/country/middle-east/jobs/accounting/",
        "Key Skills": "IFRS, VAT, UAE Corporate Tax (9%), ERP, ACCA/CPA",
        "Notes": "38,000+ F&A vacancies in GCC Q1 2026; ACCA/CPA/ICAI accepted",
    },

    # ── Canada ───────────────────────────────────────────────────────────────
    {
        "Region": "Canada",
        "Job Title": "Senior Accountant (Remote)",
        "Company": "KOHO",
        "Location": "Remote – Canada",
        "Country": "Canada",
        "Job Type": "Full-Time / Remote",
        "Salary / Rate": "Not disclosed",
        "Currency": "CAD",
        "Date Posted": "February 2026",
        "Source Platform": "RemoteRocketship",
        "Job URL": "https://www.remoterocketship.com/company/koho/jobs/senior-accountant-canada-remote/",
        "Key Skills": "IFRS 9, Loan Provisioning, Debt Facility Covenants, Senior Accounting",
        "Notes": "FinTech; IFRS 9 loan provisioning; fully remote Canada",
    },
    {
        "Region": "Canada",
        "Job Title": "Remote Accounting Jobs – Canada (Multiple)",
        "Company": "Various (1,081 openings on Indeed CA)",
        "Location": "Remote – Canada",
        "Country": "Canada",
        "Job Type": "Full-Time / Part-Time / Freelance / Contract",
        "Salary / Rate": "Market rate (CAD)",
        "Currency": "CAD",
        "Date Posted": "May 2026",
        "Source Platform": "Indeed Canada",
        "Job URL": "https://ca.indeed.com/Remote-Accounting-jobs",
        "Key Skills": "IFRS, ASPE, GL, Reconciliation, CPA",
        "Notes": "1,081 remote accounting jobs on Indeed CA as of May 2026",
    },
    {
        "Region": "Canada",
        "Job Title": "Freelance Accounting (Remote)",
        "Company": "Various (Upwork)",
        "Location": "Remote – Canada",
        "Country": "Canada",
        "Job Type": "Freelance / Contract",
        "Salary / Rate": "Negotiable (CAD/USD)",
        "Currency": "CAD / USD",
        "Date Posted": "May 2026",
        "Source Platform": "Upwork",
        "Job URL": "https://www.upwork.com/freelance-jobs/accounting/",
        "Key Skills": "GL, IFRS, QuickBooks, Xero, Month-End Close",
        "Notes": "1,630 freelance accounting jobs on Upwork globally incl. Canada",
    },

    # ── Australia ─────────────────────────────────────────────────────────────
    {
        "Region": "Australia",
        "Job Title": "Remote Financial Accountant (Multiple Openings)",
        "Company": "Various (42 remote openings)",
        "Location": "Remote – Australia",
        "Country": "Australia",
        "Job Type": "Full-Time / Contract / Freelance",
        "Salary / Rate": "A$152,187 avg/year",
        "Currency": "AUD",
        "Date Posted": "April – May 2026",
        "Source Platform": "RemoteRocketship / DailyRemote",
        "Job URL": "https://www.remoterocketship.com/country/australia/jobs/accounting/",
        "Key Skills": "IFRS, AASB, GL, Financial Statements, Multi-Jurisdiction",
        "Notes": "42 remote F&A openings in AU; avg AUD 152k/yr; AASB/IFRS",
    },
    {
        "Region": "Australia",
        "Job Title": "Freelance Financial Accountant – Australia",
        "Company": "Various (Upwork AU)",
        "Location": "Remote – Australia",
        "Country": "Australia",
        "Job Type": "Freelance / Contract",
        "Salary / Rate": "Negotiable (AUD)",
        "Currency": "AUD",
        "Date Posted": "April 2026",
        "Source Platform": "Upwork",
        "Job URL": "https://www.upwork.com/hire/financial-accountants/au/",
        "Key Skills": "IFRS, AASB, GL, Financial Accounting, Xero/QuickBooks",
        "Notes": "Leading Financial Accountants listed on Upwork AU; NZ/UK/AU/CA exp valued",
    },
    {
        "Region": "Australia",
        "Job Title": "Remote Finance & Accounting Jobs – Australia (Multiple)",
        "Company": "Various (75 on Indeed AU)",
        "Location": "Remote – Australia",
        "Country": "Australia",
        "Job Type": "Full-Time / Part-Time / Remote",
        "Salary / Rate": "Market rate (AUD)",
        "Currency": "AUD",
        "Date Posted": "May 2026",
        "Source Platform": "Indeed Australia",
        "Job URL": "https://au.indeed.com/q-remote-accounting-jobs.html",
        "Key Skills": "Accounting, GL, AASB, IFRS, Reporting",
        "Notes": "75 remote accounting jobs on Indeed AU; multi-jurisdictional roles",
    },

    # ── Freelance Platforms (Global) ─────────────────────────────────────────
    {
        "Region": "Freelance / Global",
        "Job Title": "General Ledger Accounting Freelance Jobs",
        "Company": "Multiple Clients (Upwork)",
        "Location": "Remote – Worldwide",
        "Country": "Global",
        "Job Type": "Freelance",
        "Salary / Rate": "Negotiable (USD/EUR/GBP/CAD/AUD)",
        "Currency": "USD / Multi",
        "Date Posted": "May 2026",
        "Source Platform": "Upwork",
        "Job URL": "https://www.upwork.com/freelance-jobs/general-ledger/",
        "Key Skills": "GL, Journal Entries, Reconciliation, Fixed Assets, R2R",
        "Notes": "1,506 open GL accounting freelance jobs on Upwork globally",
    },
    {
        "Region": "Freelance / Global",
        "Job Title": "Financial Accounting Freelance Jobs",
        "Company": "Multiple Clients (Upwork)",
        "Location": "Remote – Worldwide",
        "Country": "Global",
        "Job Type": "Freelance",
        "Salary / Rate": "Negotiable (USD/EUR/GBP/CAD/AUD)",
        "Currency": "USD / Multi",
        "Date Posted": "May 2026",
        "Source Platform": "Upwork",
        "Job URL": "https://www.upwork.com/freelance-jobs/financial-accounting/",
        "Key Skills": "Financial Accounting, GL, Reporting, IFRS, US GAAP",
        "Notes": "3,449 open financial accounting freelance jobs on Upwork",
    },
    {
        "Region": "Freelance / Global",
        "Job Title": "IFRS Freelance Accounting Experts",
        "Company": "Multiple Clients (Upwork)",
        "Location": "Remote – Worldwide",
        "Country": "Global",
        "Job Type": "Freelance / Contract",
        "Salary / Rate": "Negotiable (USD)",
        "Currency": "USD",
        "Date Posted": "May 2026",
        "Source Platform": "Upwork",
        "Job URL": "https://www.upwork.com/hire/ifrs-freelancers/",
        "Key Skills": "IFRS, IFRS 16, ASC 842, Multi-Jurisdiction, Financial Reporting",
        "Notes": "27 IFRS specialist freelancers available for hire; global clients",
    },
    {
        "Region": "Freelance / Global",
        "Job Title": "Remote Accounting Jobs (Finance & Legal)",
        "Company": "Multiple (Remotive listing)",
        "Location": "Remote – Worldwide",
        "Country": "Global",
        "Job Type": "Full-Time / Contract / Freelance",
        "Salary / Rate": "Varies by company",
        "Currency": "USD / EUR / Multi",
        "Date Posted": "May 2026",
        "Source Platform": "Remotive.com",
        "Job URL": "https://remotive.com/remote-accounting-jobs",
        "Key Skills": "GL, R2R, IFRS, US GAAP, Financial Accounting",
        "Notes": "160,000+ vetted remote jobs on Remotive; accounting category active",
    },
]

df = pd.DataFrame(jobs)

# Column order
cols = [
    "Region", "Job Title", "Company", "Location", "Country",
    "Job Type", "Salary / Rate", "Currency", "Date Posted",
    "Source Platform", "Job URL", "Key Skills", "Notes",
]
df = df[cols]

out_path = "remote_gl_r2r_jobs.xlsx"
with pd.ExcelWriter(out_path, engine="openpyxl") as writer:
    df.to_excel(writer, index=False, sheet_name="All Jobs")

    wb = writer.book
    ws = writer.sheets["All Jobs"]

    from openpyxl.styles import PatternFill, Font, Alignment, Border, Side
    from openpyxl.utils import get_column_letter

    # Region colour map
    region_colours = {
        "US":                   "DDEEFF",
        "UK":                   "DDF0DD",
        "EU / EMEA":            "FFF3CD",
        "Middle East":          "FFE0CC",
        "Canada":               "E8DAFF",
        "Australia":            "FFD6E0",
        "Freelance / Global":   "E0F7FA",
    }

    header_fill   = PatternFill("solid", fgColor="1F4E79")
    header_font   = Font(bold=True, color="FFFFFF", size=11)
    header_align  = Alignment(horizontal="center", vertical="center", wrap_text=True)
    thin_side     = Side(style="thin", color="AAAAAA")
    thin_border   = Border(left=thin_side, right=thin_side, top=thin_side, bottom=thin_side)

    # Header row
    for col_idx, col_name in enumerate(cols, start=1):
        cell = ws.cell(row=1, column=col_idx)
        cell.fill   = header_fill
        cell.font   = header_font
        cell.alignment = header_align
        cell.border = thin_border

    # Data rows
    for row_idx, row in enumerate(df.itertuples(index=False), start=2):
        region = getattr(row, "Region")
        fill_colour = region_colours.get(region, "FFFFFF")
        row_fill = PatternFill("solid", fgColor=fill_colour)
        for col_idx in range(1, len(cols) + 1):
            cell = ws.cell(row=row_idx, column=col_idx)
            cell.fill      = row_fill
            cell.alignment = Alignment(vertical="top", wrap_text=True)
            cell.border    = thin_border

    # Column widths
    col_widths = {
        "Region": 18, "Job Title": 45, "Company": 32, "Location": 30,
        "Country": 20, "Job Type": 22, "Salary / Rate": 20, "Currency": 10,
        "Date Posted": 15, "Source Platform": 20, "Job URL": 60,
        "Key Skills": 45, "Notes": 50,
    }
    for col_idx, col_name in enumerate(cols, start=1):
        ws.column_dimensions[get_column_letter(col_idx)].width = col_widths.get(col_name, 20)

    ws.row_dimensions[1].height = 30

    # Freeze header row
    ws.freeze_panes = "A2"

    # ── Summary sheet ──
    ws2 = wb.create_sheet("Summary")
    summary_header_fill = PatternFill("solid", fgColor="1F4E79")
    summary_header_font = Font(bold=True, color="FFFFFF", size=11)

    summary_cols = ["Region", "Total Jobs", "Colour Code"]
    for c_idx, ch in enumerate(summary_cols, start=1):
        cell = ws2.cell(row=1, column=c_idx, value=ch)
        cell.fill = summary_header_fill
        cell.font = summary_header_font
        cell.alignment = Alignment(horizontal="center")
        cell.border = thin_border

    region_counts = df["Region"].value_counts().to_dict()
    for r_idx, (region, count) in enumerate(region_counts.items(), start=2):
        colour = region_colours.get(region, "FFFFFF")
        ws2.cell(row=r_idx, column=1, value=region).fill = PatternFill("solid", fgColor=colour)
        ws2.cell(row=r_idx, column=2, value=count).fill  = PatternFill("solid", fgColor=colour)
        ws2.cell(row=r_idx, column=3, value=colour).fill = PatternFill("solid", fgColor=colour)
        for c in range(1, 4):
            ws2.cell(row=r_idx, column=c).border = thin_border
            ws2.cell(row=r_idx, column=c).alignment = Alignment(horizontal="center")

    # Total row
    total_row = len(region_counts) + 2
    ws2.cell(row=total_row, column=1, value="TOTAL").font = Font(bold=True)
    ws2.cell(row=total_row, column=2, value=len(df)).font = Font(bold=True)
    for c in range(1, 3):
        ws2.cell(row=total_row, column=c).border = thin_border
        ws2.cell(row=total_row, column=c).alignment = Alignment(horizontal="center")

    ws2.column_dimensions["A"].width = 25
    ws2.column_dimensions["B"].width = 15
    ws2.column_dimensions["C"].width = 15

    ws2.cell(row=total_row + 2, column=1,
             value="Generated on:").font = Font(italic=True)
    ws2.cell(row=total_row + 3, column=1,
             value=datetime.now().strftime("%Y-%m-%d %H:%M")).font = Font(italic=True)
    ws2.cell(row=total_row + 4, column=1,
             value="Source: Web search (Google / job boards, last ~30 days)").font = Font(italic=True, color="555555")

print(f"Saved: {out_path}")
print(f"Total jobs: {len(df)}")
print(df.groupby('Region')['Job Title'].count().to_string())
