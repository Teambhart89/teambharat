"""
Remote part-time / freelance GL / R2R accounting job search queries.

Usage
-----
  python job_queries.py

Each query is printed as a single line ready to paste into Google.
After pasting, apply these filters on the job portal:
  • Date posted  → last 7–15 days
  • Job type     → Part-time / Contract / Freelance / Independent contractor

Regions covered : US, UK, EU/EMEA, Middle East, Canada, Australia
Extra section   : Freelance platforms (Upwork, Toptal, Guru, Contra, Freelancer)
Optional add-on : ERP / tool keywords (see build_erp_addon)
"""

# ---------------------------------------------------------------------------
# Shared building blocks
# ---------------------------------------------------------------------------

CORE_ROLES = (
    '"General Ledger Accountant" OR "GL Accountant" OR "R2R Accountant" OR '
    '"Record to Report Accountant" OR "Senior Accountant" OR "Revenue Accountant" OR '
    '"Technical Accountant" OR "Consolidation Accountant" OR '
    '"Lease Accountant" OR "Intercompany Accountant"'
)

WORK_TYPES = (
    '"part-time" OR "freelance" OR "contract" OR '
    '"independent contractor" OR "consulting" OR "interim"'
)

ACCOUNTING_SKILLS = (
    '"fixed assets" OR "month end close" OR "balance sheet reconciliation" OR '
    '"general ledger" OR "IFRS 16" OR "ASC 842" OR "lease accounting" OR '
    '"intercompany" OR "journal entries" OR "trial balance" OR "R2R" OR '
    '"record to report"'
)


# ---------------------------------------------------------------------------
# Job-site groups by region
# ---------------------------------------------------------------------------

SITES = {
    "us": (
        "site:remote.co OR site:flexjobs.com OR site:weworkremotely.com OR "
        "site:remoteok.com OR site:workingnomads.com OR site:linkedin.com OR "
        "site:indeed.com OR site:ziprecruiter.com OR site:accountingfly.com OR "
        "site:accountingjobstoday.com OR site:glassdoor.com"
    ),
    "uk": (
        "site:flexjobs.com OR site:weworkremotely.com OR site:remoteok.com OR "
        "site:workingnomads.com OR site:linkedin.com OR site:reed.co.uk OR "
        "site:cv-library.co.uk OR site:totaljobs.com OR site:accountingfly.com OR "
        "site:glassdoor.co.uk"
    ),
    "eu": (
        "site:euremotejobs.com OR site:remote.co OR site:flexjobs.com OR "
        "site:weworkremotely.com OR site:remoteok.com OR site:workingnomads.com OR "
        "site:linkedin.com OR site:glassdoor.com OR site:europawork.eu"
    ),
    "me": (
        "site:bayt.com OR site:gulftalent.com OR site:naukrigulf.com OR "
        "site:dubizzle.com OR site:remote.co OR site:flexjobs.com OR "
        "site:workingnomads.com OR site:linkedin.com OR site:weworkremotely.com"
    ),
    "ca": (
        "site:remote.co OR site:flexjobs.com OR site:weworkremotely.com OR "
        "site:remoteok.com OR site:workingnomads.com OR site:linkedin.com OR "
        "site:indeed.ca OR site:ziprecruiter.com OR site:accountingfly.com OR "
        "site:glassdoor.ca"
    ),
    "au": (
        "site:remote.co OR site:flexjobs.com OR site:weworkremotely.com OR "
        "site:remoteok.com OR site:workingnomads.com OR site:linkedin.com OR "
        "site:seek.com.au OR site:indeed.com.au OR site:careerone.com.au OR "
        "site:accountingfly.com"
    ),
    "freelance": (
        "site:upwork.com OR site:toptal.com OR site:guru.com OR "
        "site:freelancer.com OR site:contra.com OR site:fiverr.com OR "
        "site:solidgigs.com OR site:worksome.com"
    ),
}


# ---------------------------------------------------------------------------
# Optional ERP / tool add-on
# ---------------------------------------------------------------------------

def build_erp_addon() -> str:
    """
    Append this string to any query to target roles that mention specific ERP tools.
    Useful for narrowing to your strongest platforms.
    """
    return (
        '("SAP" OR "Oracle" OR "NetSuite" OR "Workday" OR '
        '"QuickBooks" OR "Sage" OR "Xero" OR "Blackline")'
    )


# ---------------------------------------------------------------------------
# Query builders
# ---------------------------------------------------------------------------

def _q(*parts: str) -> str:
    """Join query parts with a single space, stripping excess whitespace."""
    return " ".join(p.strip() for p in parts if p.strip())


def build_us_query(include_erp: bool = False) -> str:
    erp = build_erp_addon() if include_erp else ""
    return _q(
        '"Remote"',
        f"({CORE_ROLES})",
        f"({WORK_TYPES})",
        f"({ACCOUNTING_SKILLS})",
        '("US GAAP" OR "United States" OR "USA")',
        '("USD" OR "dollar" OR "$")',
        '-"India"',
        erp,
        f"({SITES['us']})",
    )


def build_uk_query(include_erp: bool = False) -> str:
    uk_roles = (
        '"General Ledger Accountant" OR "Financial Accountant" OR "R2R Accountant" OR '
        '"Revenue Accountant" OR "Senior Accountant" OR "Lease Accountant" OR '
        '"Consolidation Accountant"'
    )
    erp = build_erp_addon() if include_erp else ""
    return _q(
        '"Remote"',
        f"({uk_roles})",
        f"({WORK_TYPES})",
        f"({ACCOUNTING_SKILLS})",
        '("UK" OR "United Kingdom")',
        '("GBP" OR "£")',
        '-"India"',
        erp,
        f"({SITES['uk']})",
    )


def build_eu_query(include_erp: bool = False) -> str:
    erp = build_erp_addon() if include_erp else ""
    return _q(
        '"Remote"',
        f"({CORE_ROLES})",
        f"({WORK_TYPES})",
        '("IFRS" OR "IFRS 16" OR "IFRS 9")',
        f"({ACCOUNTING_SKILLS})",
        '("EMEA" OR "Europe" OR "EU" OR "eurozone")',
        '("EUR" OR "€")',
        '-"India"',
        erp,
        f"({SITES['eu']})",
    )


def build_me_query(include_erp: bool = False) -> str:
    me_roles = (
        '"Accountant" OR "General Ledger Accountant" OR "Senior Accountant" OR '
        '"Financial Accountant" OR "R2R Accountant" OR "Revenue Accountant"'
    )
    erp = build_erp_addon() if include_erp else ""
    return _q(
        '"Remote"',
        f"({me_roles})",
        f"({WORK_TYPES})",
        '("reconciliation" OR "financial statements" OR "month end closing" OR "general ledger")',
        '("UAE" OR "Saudi Arabia" OR "Qatar" OR "Kuwait" OR "Bahrain" OR "Middle East" OR "GCC")',
        '("USD" OR "EUR" OR "GBP" OR "AED")',
        '-"India"',
        erp,
        f"({SITES['me']})",
    )


def build_canada_query(include_erp: bool = False) -> str:
    erp = build_erp_addon() if include_erp else ""
    return _q(
        '"Remote"',
        f"({CORE_ROLES})",
        f"({WORK_TYPES})",
        f"({ACCOUNTING_SKILLS})",
        '("IFRS" OR "ASPE" OR "Canada" OR "Canadian")',
        '("CAD" OR "CA$" OR "Canadian dollar")',
        '-"India"',
        erp,
        f"({SITES['ca']})",
    )


def build_australia_query(include_erp: bool = False) -> str:
    erp = build_erp_addon() if include_erp else ""
    return _q(
        '"Remote"',
        f"({CORE_ROLES})",
        f"({WORK_TYPES})",
        f"({ACCOUNTING_SKILLS})",
        '("IFRS" OR "AASB" OR "Australia" OR "Australian")',
        '("AUD" OR "AU$" OR "Australian dollar")',
        '-"India"',
        erp,
        f"({SITES['au']})",
    )


def build_freelance_platform_query() -> str:
    """
    Freelance-platform query — no region filter, currency-neutral.
    Targets Upwork, Toptal, Guru, Contra, Freelancer, etc.
    """
    freelance_roles = (
        '"GL Accountant" OR "R2R Accountant" OR "General Ledger" OR '
        '"Record to Report" OR "Fixed Assets Accountant" OR "Lease Accountant" OR '
        '"Revenue Accountant" OR "Consolidation Accountant" OR "Financial Accountant"'
    )
    return _q(
        f"({freelance_roles})",
        f"({WORK_TYPES})",
        '("USD" OR "EUR" OR "GBP" OR "CAD" OR "AUD")',
        '-"India"',
        f"({SITES['freelance']})",
    )


# ---------------------------------------------------------------------------
# WhatsApp basic contact details
# ---------------------------------------------------------------------------

def whatsapp_basic_contacts() -> None:
    info = """
===== WHATSAPP – BASIC CONTACT DETAILS =====

[Core URLs]
- Main website          : https://www.whatsapp.com
- Help Center           : https://faq.whatsapp.com
- General contact page  : https://www.whatsapp.com/contact
- WhatsApp Business     : https://whatsappbusiness.com

[Support contact]
- Recommended : in-app path → Settings → Help → Contact Us
- Web forms   : https://www.whatsapp.com/contact
- Support email domain  : @support.whatsapp.com

[Careers / jobs]
- Jobs are managed via Meta (Facebook) Careers portal.
  Filter by team/product = WhatsApp.
- Also search LinkedIn Jobs: company = Meta, keyword = WhatsApp.
"""
    print(info.strip())


# ---------------------------------------------------------------------------
# Main
# ---------------------------------------------------------------------------

def build_job_queries(include_erp: bool = False) -> None:
    """
    Print all regional queries plus the freelance-platform query.

    Args:
        include_erp: If True, appends ERP/tool keywords (SAP, Oracle, NetSuite…)
                     to each regional query for more targeted results.
    """
    regions = {
        "US (USD / US GAAP)":               build_us_query(include_erp),
        "UK (GBP)":                          build_uk_query(include_erp),
        "EU / EMEA (EUR / IFRS)":            build_eu_query(include_erp),
        "Middle East / GCC (USD / EUR)":     build_me_query(include_erp),
        "Canada (CAD / IFRS or ASPE)":       build_canada_query(include_erp),
        "Australia (AUD / AASB-IFRS)":       build_australia_query(include_erp),
        "Freelance Platforms – Global":      build_freelance_platform_query(),
    }

    print("=" * 70)
    print("  REMOTE PART-TIME GL / R2R ACCOUNTING JOB QUERIES")
    print("=" * 70)
    print()
    print("INSTRUCTIONS")
    print("  1. Copy a query below and paste it directly into Google.")
    print("  2. On each job portal that opens, set:")
    print("       • Date posted  → last 7–15 days")
    print("       • Job type     → Part-time / Contract / Freelance / Contractor")
    print("  3. For freelance platforms (Upwork etc.) use their built-in")
    print("     search box with role keywords + hourly/fixed-price filter.")
    if include_erp:
        print()
        print("  ERP add-on is ENABLED — queries include SAP / Oracle / NetSuite etc.")
    print()

    for region, query in regions.items():
        print(f"--- {region} ---")
        print(query)
        print()

    print("-" * 70)
    print("TIP: Re-run with  build_job_queries(include_erp=True)  to narrow")
    print("     results to roles mentioning specific ERP / accounting tools.")
    print("=" * 70)


if __name__ == "__main__":
    build_job_queries(include_erp=False)
    print("\n\n")
    whatsapp_basic_contacts()
