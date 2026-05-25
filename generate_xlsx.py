import openpyxl
from openpyxl.styles import (
    Font, PatternFill, Alignment, Border, Side, GradientFill
)
from openpyxl.utils import get_column_letter

wb = openpyxl.Workbook()

# ── Colour palette ──────────────────────────────────────────────
BRAND_PINK   = "E91E8C"   # Amour Secrt accent
DARK_GREY    = "2D2D2D"
MID_GREY     = "5A5A5A"
LIGHT_GREY   = "F5F5F5"
WHITE        = "FFFFFF"
TIER1_BG     = "FCE4EC"   # light pink
TIER2_BG     = "FFF9C4"   # light yellow
TIER3_BG     = "E8F5E9"   # light green
TIER4_BG     = "E3F2FD"   # light blue
HEADER_BG    = "E91E8C"
ALT_ROW      = "FFF0F6"

def hdr_font(size=11, bold=True, color=WHITE):
    return Font(name="Calibri", size=size, bold=bold, color=color)

def body_font(size=10, bold=False, color=DARK_GREY):
    return Font(name="Calibri", size=size, bold=bold, color=color)

def fill(hex_color):
    return PatternFill("solid", fgColor=hex_color)

def thin_border():
    s = Side(style="thin", color="DDDDDD")
    return Border(left=s, right=s, top=s, bottom=s)

def center(wrap=False):
    return Alignment(horizontal="center", vertical="center", wrap_text=wrap)

def left(wrap=True):
    return Alignment(horizontal="left", vertical="center", wrap_text=wrap)

def apply_header(ws, row, cols, bg=HEADER_BG):
    for c in range(1, cols + 1):
        cell = ws.cell(row=row, column=c)
        cell.fill = fill(bg)
        cell.font = hdr_font()
        cell.alignment = center(wrap=True)
        cell.border = thin_border()

def apply_row(ws, row, cols, bg=WHITE):
    for c in range(1, cols + 1):
        cell = ws.cell(row=row, column=c)
        if cell.fill.fgColor.rgb in ("00000000", "FFFFFFFF", WHITE):
            cell.fill = fill(bg)
        cell.font = body_font()
        cell.alignment = left()
        cell.border = thin_border()

# ════════════════════════════════════════════════════════════════
# SHEET 1 — Content Calendar (20 Blog Topics)
# ════════════════════════════════════════════════════════════════
ws1 = wb.active
ws1.title = "Content Calendar"
ws1.sheet_view.showGridLines = False
ws1.freeze_panes = "A3"

# Title banner
ws1.merge_cells("A1:L1")
title_cell = ws1["A1"]
title_cell.value = "AMOUR SECRT — 20 Blog Content Calendar"
title_cell.font = Font(name="Calibri", size=14, bold=True, color=WHITE)
title_cell.fill = fill(BRAND_PINK)
title_cell.alignment = center()
ws1.row_dimensions[1].height = 30

headers = [
    "Priority", "Tier", "Blog Title", "Primary Keyword",
    "Search Intent", "Estimated Volume", "Competition",
    "Content Angle / Hook", "Target Audience",
    "Internal Links To", "Word Count", "Status"
]
for col, h in enumerate(headers, 1):
    ws1.cell(row=2, column=col, value=h)
apply_header(ws1, 2, len(headers))
ws1.row_dimensions[2].height = 22

TIER_COLORS = {
    "Tier 1": TIER1_BG,
    "Tier 2": TIER2_BG,
    "Tier 3": TIER3_BG,
    "Tier 4": TIER4_BG,
}

blogs = [
    # (priority, tier, title, primary_kw, intent, vol, comp, angle, audience, internal_links, wc, status)
    (1, "Tier 1",
     "How to Measure Bra Size at Home — Complete India Guide",
     "how to measure bra size at home india",
     "Informational", "Very High", "High",
     "Step-by-step guide using measuring tape; Indian size chart included; opens with 'Most women wearing wrong size don't even know it'",
     "All women, especially first-time online buyers",
     "Bras collection, Lightly padded bras, Bra size chart",
     "1800–2000", "To Do"),

    (2, "Tier 1",
     "Types of Bras for Indian Women — The Complete Guide",
     "types of bras for indian women",
     "Informational", "Very High", "Medium",
     "Cover 12+ bra types with India-relevant use cases; link to each product category; anchor content for the entire blog",
     "All women, shoppers comparing options",
     "All bra category pages, Padded bra guide, Non-padded bras",
     "2000+", "To Do"),

    (3, "Tier 1",
     "How to Know If Your Bra Fits Correctly — 7 Signs to Check",
     "how to know if bra fits correctly",
     "Informational", "High", "Medium",
     "Problem-solution format; 7 visible signs of wrong fit with fixes; opens with 'If your straps dig in, it's not your shoulders — it's your bra size'",
     "Women experiencing discomfort",
     "Bra size guide, Everyday bras collection",
     "1500–1800", "To Do"),

    (4, "Tier 1",
     "Best Sports Bra in India — Complete Buying Guide 2025",
     "best sports bra in india",
     "Commercial", "High", "High",
     "Impact levels (low/medium/high), activity types, fabric guide for Indian summers; honest brand mentions",
     "Fitness women, gym-goers, yoga lovers",
     "Activewear collection, Sports bra category",
     "1800–2000", "To Do"),

    (5, "Tier 1",
     "Best Bra for Daily Wear in India — What to Actually Look For",
     "best bra for daily wear in india",
     "Commercial", "Very High", "High",
     "Debunk the idea of one 'best' bra; segment by comfort need, outfit, climate; honest picks",
     "Working women, college girls, everyday buyers",
     "Everyday bras, Lightly padded, Non-padded bras",
     "1600–1800", "To Do"),

    (6, "Tier 2",
     "What Bra to Wear with Kurti — The Indian Woman's Guide",
     "what bra to wear with kurti",
     "Informational", "High", "Low",
     "India-specific gap content; cover deep-neck, round-neck, shirt-style, cold-shoulder kurtis with right bra for each",
     "Women aged 18–35 who wear kurtis daily",
     "T-shirt bras, Non-padded bras, Tube bras",
     "1400–1600", "To Do"),

    (7, "Tier 2",
     "What to Wear Under White Tops and Shirts — No More Bra Show-Through",
     "bra for white top india",
     "Informational", "High", "Low",
     "Very practical, solves an everyday Indian wardrobe problem; cover nude vs white bra myth; skin tone note for Indian women",
     "College girls, working women",
     "Non-padded bras, Seamless bras, Sets collection",
     "1400–1600", "To Do"),

    (8, "Tier 2",
     "T-Shirt Bra Guide — What It Is, How It Works & Who Needs One",
     "t-shirt bra india guide",
     "Informational", "Medium", "Low",
     "Explain why T-shirt bras differ from regular padded bras; moulded cup benefit for Indian summers; top styling occasions",
     "Women who wear fitted tops, kurtas, western wear",
     "T-shirt bras category, Padded bra guide",
     "1400–1600", "To Do"),

    (9, "Tier 2",
     "Push-Up Bra Guide for Indian Women — Lift, Fit & Occasion Guide",
     "push up bra india",
     "Commercial", "High", "Medium",
     "Demystify push-up bras; padding levels explained; when to wear vs when to avoid (Indian summers); occasion-specific advice",
     "Women aged 20–35, occasion dressers",
     "Push-up / heavily padded bras, Sets",
     "1500–1800", "To Do"),

    (10, "Tier 2",
     "Lingerie Trends in India 2025–26 — What's Actually Wearable",
     "lingerie trends india 2025",
     "Informational", "High", "Medium",
     "Focus on wearable Indian trends (not international runway); wireless, inclusive nudes, bralettes as outerwear, cotton-first",
     "Fashion-forward women, 20–35",
     "New Arrivals, Activewear, Bras collection",
     "1400–1600", "To Do"),

    (11, "Tier 3",
     "First Bra Guide for Girls — What to Expect and How to Choose",
     "first bra guide for girls india",
     "Informational", "Medium", "Low",
     "Gentle, reassuring tone; cover beginner/starter bras; size guidance; what to tell their parent; not clinical",
     "Girls 12–16, mothers buying for daughters",
     "Beginner bras category, Non-padded bras",
     "1400–1600", "To Do"),

    (12, "Tier 3",
     "Panty Guide — Types, Fabrics & Which Style to Wear When",
     "types of panties for women india",
     "Informational", "Medium", "Low",
     "Full gap content — Amour Secrt has zero panty blogs; cover briefs, hipster, thong, boyshort, period panties with use cases",
     "All women, everyday buyers",
     "Sets collection, Panties category",
     "1600–1800", "To Do"),

    (13, "Tier 3",
     "How to Wash Bras Correctly — and Why It Matters More Than You Think",
     "how to wash bras correctly",
     "Informational", "Medium", "Low",
     "Trust-building evergreen; open with 'Your bra lasts 2 years or 6 months — the difference is how you wash it'; India water hardness note",
     "All bra buyers",
     "All bra categories",
     "1200–1500", "To Do"),

    (14, "Tier 3",
     "Bra Myths vs Facts — What Indian Women Are Told Wrong About Bras",
     "bra myths india",
     "Informational", "Medium", "Low",
     "Myth-busting format (highly shareable); cover: wearing a bra too young hurts growth / underwire causes cancer / bra size doesn't change / white is safest",
     "All women, especially first-time buyers",
     "Bra size guide, Types of bras",
     "1400–1600", "To Do"),

    (15, "Tier 3",
     "How Long Should a Bra Last? — When to Replace and Signs to Watch",
     "how long should a bra last",
     "Informational", "Medium", "Low",
     "Builds trust via honest, specific guidance (6–12 months for daily-wear); signs the bra is worn out; Indian washing habit context",
     "All women",
     "Everyday bras, Bra care article",
     "1200–1400", "To Do"),

    (16, "Tier 4",
     "Seamless and Wire-Free Bras — Who Should Wear Them?",
     "wireless bra india guide",
     "Commercial", "Growing", "Low",
     "Post-COVID comfort shift; who benefits (heavy bust, WFH, travel); who shouldn't; how to choose the right one",
     "WFH women, comfort-first buyers",
     "Non-padded bras, Everyday bras",
     "1400–1600", "To Do"),

    (17, "Tier 4",
     "Bra for Different Body Types — Indian Women's Complete Guide",
     "bra for body type india",
     "Informational", "Medium", "Medium",
     "Segmented by body type (petite, curvy, broad shoulders, plus-size); body-positive, non-clinical tone",
     "Women searching by body type",
     "All bra category pages",
     "1600–1800", "To Do"),

    (18, "Tier 4",
     "Bra for Backless Blouses and Sarees — India Guide",
     "bra for backless blouse india",
     "Informational", "Medium", "Low",
     "India-specific occasion content; cover adhesive, strapless, plunge for saree blouses; festive + wedding angle",
     "Women dressing for Indian occasions",
     "Tube bras, Bandeau bras, Sets",
     "1400–1600", "To Do"),

    (19, "Tier 4",
     "Cotton Bra vs Padded Bra — Which Is Better for Indian Summers?",
     "cotton bra vs padded bra india",
     "Informational", "Medium", "Low",
     "Comparison format; honest trade-offs; Indian heat + humidity context; recommend blended fabrics for best of both",
     "Summer buyers, comfort-first women",
     "Non-padded bras, Lightly padded bras, Padded bra guide",
     "1400–1500", "To Do"),

    (20, "Tier 4",
     "Activewear for Women — How to Choose the Right Workout Innerwear",
     "activewear bra india women",
     "Commercial", "Medium", "Medium",
     "Expand beyond bras into activewear category; cover impact level, fabric, sweat management, Indian gym culture",
     "Fitness women, gym-goers, yogis",
     "Activewear collection, Sports bra guide",
     "1500–1800", "To Do"),
]

tier_color_map = {
    "Tier 1": TIER1_BG,
    "Tier 2": TIER2_BG,
    "Tier 3": TIER3_BG,
    "Tier 4": TIER4_BG,
}

for i, row_data in enumerate(blogs):
    row_num = i + 3
    tier = row_data[1]
    bg = tier_color_map.get(tier, WHITE)
    for col, val in enumerate(row_data, 1):
        c = ws1.cell(row=row_num, column=col, value=val)
        c.fill = fill(bg)
        c.font = body_font(bold=(col == 1))
        c.alignment = left()
        c.border = thin_border()
    ws1.row_dimensions[row_num].height = 40

col_widths_1 = [6, 8, 45, 40, 14, 12, 12, 60, 35, 45, 12, 10]
for i, w in enumerate(col_widths_1, 1):
    ws1.column_dimensions[get_column_letter(i)].width = w


# ════════════════════════════════════════════════════════════════
# SHEET 2 — SEO Keyword Map
# ════════════════════════════════════════════════════════════════
ws2 = wb.create_sheet("SEO Keyword Map")
ws2.sheet_view.showGridLines = False
ws2.freeze_panes = "A3"

ws2.merge_cells("A1:H1")
ws2["A1"].value = "AMOUR SECRT — SEO Keyword Map"
ws2["A1"].font = Font(name="Calibri", size=14, bold=True, color=WHITE)
ws2["A1"].fill = fill(BRAND_PINK)
ws2["A1"].alignment = center()
ws2.row_dimensions[1].height = 30

kw_headers = [
    "Blog #", "Primary Keyword", "Intent", "Volume Est.",
    "Competition", "Secondary Keywords (use naturally)", "URL Slug", "Featured Snippet Target?"
]
for col, h in enumerate(kw_headers, 1):
    ws2.cell(row=2, column=col, value=h)
apply_header(ws2, 2, len(kw_headers))
ws2.row_dimensions[2].height = 22

kw_data = [
    (1, "how to measure bra size at home india", "Informational", "Very High", "High",
     "bra size calculator india, bra size chart india, bra measurement guide",
     "/blogs/news/how-to-measure-bra-size-india", "Yes — Step-by-step list"),

    (2, "types of bras for indian women", "Informational", "Very High", "Medium",
     "different bra types india, bra styles guide, bra types explained",
     "/blogs/news/types-of-bras-for-indian-women", "Yes — List format"),

    (3, "how to know if bra fits correctly", "Informational", "High", "Medium",
     "signs of wrong bra size, bra fit guide, bra fitting tips india",
     "/blogs/news/how-to-know-if-bra-fits", "Yes — Numbered list"),

    (4, "best sports bra in india", "Commercial", "High", "High",
     "sports bra for gym india, sports bra for running, activewear bra india",
     "/blogs/news/best-sports-bra-india", "Possible — Definition block"),

    (5, "best bra for daily wear in india", "Commercial", "Very High", "High",
     "everyday bra india, comfortable bra daily wear, best bra for work india",
     "/blogs/news/best-bra-daily-wear-india", "Yes — List format"),

    (6, "what bra to wear with kurti", "Informational", "High", "Low",
     "bra for kurti deep neck, bra for indian outfits, innerwear for kurti",
     "/blogs/news/bra-for-kurti-india", "Yes — Q&A format"),

    (7, "bra for white top india", "Informational", "High", "Low",
     "nude bra india, invisible bra white shirt, no show bra white top",
     "/blogs/news/bra-for-white-top-india", "Yes — Definition block"),

    (8, "t-shirt bra india guide", "Informational", "Medium", "Low",
     "what is t-shirt bra, t-shirt bra vs padded bra, moulded bra india",
     "/blogs/news/t-shirt-bra-guide-india", "Possible"),

    (9, "push up bra india", "Commercial", "High", "Medium",
     "push up bra guide, best push up bra india, padded push up bra",
     "/blogs/news/push-up-bra-guide-india", "Possible"),

    (10, "lingerie trends india 2025", "Informational", "High", "Medium",
     "bra trends india 2025, lingerie fashion india, innerwear trends 2025",
     "/blogs/news/lingerie-trends-india-2025", "No"),

    (11, "first bra guide for girls india", "Informational", "Medium", "Low",
     "beginner bra india, starter bra guide, first bra for teenagers india",
     "/blogs/news/first-bra-guide-girls-india", "Yes — Q&A format"),

    (12, "types of panties for women india", "Informational", "Medium", "Low",
     "panty types india, best panty for daily wear india, underwear types women",
     "/blogs/news/panty-guide-india", "Yes — List format"),

    (13, "how to wash bras correctly", "Informational", "Medium", "Low",
     "bra washing tips, how to hand wash bra, bra care india",
     "/blogs/news/how-to-wash-bras-correctly", "Yes — Steps list"),

    (14, "bra myths india", "Informational", "Medium", "Low",
     "bra facts and myths, bra misconceptions india, underwire bra myths",
     "/blogs/news/bra-myths-vs-facts-india", "No — Engaging format"),

    (15, "how long should a bra last", "Informational", "Medium", "Low",
     "bra lifespan india, when to replace bra, bra wear out signs",
     "/blogs/news/how-long-bra-last", "Yes — Direct answer"),

    (16, "wireless bra india guide", "Commercial", "Growing", "Low",
     "wire-free bra india, seamless bra comfort, non-wired bra benefits",
     "/blogs/news/wireless-wire-free-bra-india", "Possible"),

    (17, "bra for body type india", "Informational", "Medium", "Medium",
     "best bra for body type, bra for curvy women india, bra for petite indian women",
     "/blogs/news/bra-for-body-type-india", "Yes — List format"),

    (18, "bra for backless blouse india", "Informational", "Medium", "Low",
     "backless bra india, strapless bra for saree, bra for saree blouse",
     "/blogs/news/bra-for-backless-blouse-saree-india", "Yes — Q&A"),

    (19, "cotton bra vs padded bra india", "Informational", "Medium", "Low",
     "cotton bra benefits india, padded bra vs cotton, summer bra india",
     "/blogs/news/cotton-bra-vs-padded-bra-india", "Possible"),

    (20, "activewear bra india women", "Commercial", "Medium", "Medium",
     "workout bra india, gym bra women india, yoga bra india",
     "/blogs/news/activewear-bra-guide-india", "No"),
]

for i, row_data in enumerate(kw_data):
    row_num = i + 3
    bg = ALT_ROW if i % 2 == 0 else WHITE
    for col, val in enumerate(row_data, 1):
        c = ws2.cell(row=row_num, column=col, value=val)
        c.fill = fill(bg)
        c.font = body_font(bold=(col == 1))
        c.alignment = left()
        c.border = thin_border()
    ws2.row_dimensions[row_num].height = 35

col_widths_2 = [7, 42, 14, 12, 12, 55, 48, 22]
for i, w in enumerate(col_widths_2, 1):
    ws2.column_dimensions[get_column_letter(i)].width = w


# ════════════════════════════════════════════════════════════════
# SHEET 3 — Competitor Analysis
# ════════════════════════════════════════════════════════════════
ws3 = wb.create_sheet("Competitor Analysis")
ws3.sheet_view.showGridLines = False
ws3.freeze_panes = "A3"

ws3.merge_cells("A1:I1")
ws3["A1"].value = "AMOUR SECRT — Competitor Content Analysis"
ws3["A1"].font = Font(name="Calibri", size=14, bold=True, color=WHITE)
ws3["A1"].fill = fill(BRAND_PINK)
ws3["A1"].alignment = center()
ws3.row_dimensions[1].height = 30

comp_headers = [
    "Brand", "Blog URL", "Price Point", "Content Tone",
    "Top Content Categories", "What They Do Best",
    "Writing Style Notes", "SEO Strengths",
    "Gap / Opportunity for Amour Secrt"
]
for col, h in enumerate(comp_headers, 1):
    ws3.cell(row=2, column=col, value=h)
apply_header(ws3, 2, len(comp_headers))
ws3.row_dimensions[2].height = 22

comp_data = [
    ("Clovia", "clovia.com/blog", "Mid", "Expert, Solution-Oriented",
     "Lingerie 101, Fit Guide, How-Tos, Bras, Panties, Activewear, Buying Guide, Festive, Health",
     "Most comprehensive blog in India. Deep evergreen content, tool-backed (CloviaCurve fit quiz), covers all life stages from teens to maternity",
     "Knowledgeable but slightly clinical. Structured guides. Every article has FAQs. Uses numbered lists heavily.",
     "Owns 'bra size calculator India', 'sports bra guide', 'how to find right bra size'. Very strong internal linking.",
     "Amour Secrt can be warmer and more relatable. Write like a friend, not a textbook. Add more India-climate-specific depth."),

    ("Zivame", "zivame.com/blog/v1", "Mid–Premium", "Educational, Empathetic",
     "Bra size & fit, FitCode (breast profiles), lingerie layering, seasonal, bridal, panty types, nightwear",
     "Owns the 'bra size calculator' keyword completely. FitCode concept (breast profile beyond size) is unique. Strong inclusive sizing content.",
     "Educational and empathetic. Every article solves one specific problem. Strong body-positive language.",
     "Ranks #1 for 'how to measure bra size India'. Very high domain authority for lingerie content.",
     "Amour Secrt can go deeper on Indian outfit-specific styling (kurti, saree, white tops) — Zivame is less India-occasion-specific."),

    ("Enamor", "enamor.co.in/blogs/news", "Premium", "Aspirational, Fashion-Magazine",
     "Seasonal collections, Style Your Bra, Festive Glam, Athleisure, specialised bra types (nursing, maternity, strapless)",
     "Strong brand storytelling. Covers specialised types competitors miss (nursing, maternity, backless, strapless). Innovation-forward.",
     "Aspirational and polished. More like editorial content. Premium photography assumed. Shorter articles, high-quality imagery.",
     "Ranks well for brand-specific queries and premium styling content.",
     "Amour Secrt can offer more practical how-to depth that Enamor's editorial style lacks. More relatable everyday tone."),

    ("Soie", "soie.in/blogs/news", "Premium", "Lifestyle, Comfort-Led",
     "Seasonal trends, wedding season guide, summer breathable bras, party bra guide, winter lingerie",
     "Strong seasonal angle — content aligns perfectly with Indian occasions (wedding season, Diwali, summer). Ranks well for breathable bra queries.",
     "Comfort-first in every sentence. Premium feel without being stiff. Short, punchy paragraphs.",
     "Ranks for 'best lingerie for Indian summer', 'breathable bra India'.",
     "Amour Secrt can publish occasion-specific content (Navratri, summer, monsoon) with more practical product guidance."),

    ("Wacoal India", "wacoalindia.com/blogs/stories", "Luxury", "Editorial, Sophisticated",
     "Daily wear comfort, fabric education, styling as outerwear (bralettes under blazers), sustainability, bridal luxury",
     "Best fabric education in competitor set. 'Lingerie as outerwear' styling content is ahead of the market. Sustainability angle.",
     "Aspirational, editorial. Not chatty. Fashion magazine style. Very refined language.",
     "Strong on premium styling and fabric guides. Luxury positioning reinforced in content.",
     "Amour Secrt can offer the same fabric education in a friendlier, more accessible tone — making it useful for everyday buyers not just luxury shoppers."),

    ("Kyando", "kyando.com/blogs", "Mid", "Modern, Confident, Minimal",
     "Everyday comfort philosophy, confidence content, India's new woman messaging",
     "Very clear brand voice — comfort as confidence. Short, punchy. Never sounds salesy.",
     "Minimal, confident, modern. Doesn't over-explain. Lifestyle-led, not product-led.",
     "Good for brand-specific and confidence-adjacent queries.",
     "Amour Secrt should match Kyando's clarity of voice but add longer-form educational depth that Kyando's shorter posts don't cover."),

    ("Amante", "amantelingerie.in/blogs", "Mid", "Detailed, Methodical",
     "Detailed product type guides, cotton bra types, fabric breakdowns, occasion guides",
     "Very thorough product education. '11 Types of Cotton Bras' style articles are highly specific and rank well.",
     "Methodical and detailed. Each type gets its own section. Thorough but can feel dense.",
     "Ranks well for specific product type queries ('types of cotton bras').",
     "Amour Secrt can match this depth but write in a more engaging, scannable format with better hooks and shorter paragraphs."),

    ("Lovable India", "lovableindia.in/blogs", "Affordable", "Trustworthy, Traditional",
     "Daily wear bra guide, comfort and fit, classic everyday innerwear content",
     "Long-standing brand authority. Trustworthy for 'best bra for daily wear' queries.",
     "Traditional, practical, friendly. Doesn't try to be trendy.",
     "Ranks for 'best bra for daily wear India' due to brand authority.",
     "Amour Secrt can take this topic and add more modern styling angle + Indian climate context that Lovable's older content lacks."),
]

for i, row_data in enumerate(comp_data):
    row_num = i + 3
    bg = ALT_ROW if i % 2 == 0 else WHITE
    for col, val in enumerate(row_data, 1):
        c = ws3.cell(row=row_num, column=col, value=val)
        c.fill = fill(bg)
        c.font = body_font(bold=(col == 1))
        c.alignment = left()
        c.border = thin_border()
    ws3.row_dimensions[row_num].height = 65

col_widths_3 = [14, 28, 12, 20, 45, 50, 45, 40, 55]
for i, w in enumerate(col_widths_3, 1):
    ws3.column_dimensions[get_column_letter(i)].width = w


# ════════════════════════════════════════════════════════════════
# SHEET 4 — Brand Voice & Writing Guide
# ════════════════════════════════════════════════════════════════
ws4 = wb.create_sheet("Brand Voice Guide")
ws4.sheet_view.showGridLines = False

ws4.merge_cells("A1:D1")
ws4["A1"].value = "AMOUR SECRT — Brand Voice & Writing Style Guide"
ws4["A1"].font = Font(name="Calibri", size=14, bold=True, color=WHITE)
ws4["A1"].fill = fill(BRAND_PINK)
ws4["A1"].alignment = center()
ws4.row_dimensions[1].height = 30

sections = [
    # (section_title, left_label, wrong_example, right_example)
    ("RULE 1: Open with a real moment, not a definition",
     "❌ WRONG",
     "A sports bra is a specialized bra designed to provide support during physical activity.",
     "You've been halfway through a Zumba class when your regular bra starts slipping, digging, and doing everything except supporting you. That's when you realize a sports bra isn't optional — it's essential."),

    ("RULE 2: Be honest about trade-offs",
     "❌ WRONG",
     "Push-up bras are the best choice for enhancing your look.",
     "Push-up bras add lift and cleavage — but in 40°C Indian summers, the extra foam can make all-day wear uncomfortable. Here's exactly when to wear them and when not to."),

    ("RULE 3: Make every tip India-specific",
     "❌ WRONG",
     "Choose breathable fabrics for summer.",
     "Indian summers mean humidity plus heat — cotton breathes but stretches out after washing, while nylon-spandex keeps its shape but can feel slightly warmer. For most Indian women, a cotton-blend with some lycra is the sweet spot."),

    ("RULE 4: Never hard-sell — mention brand once or twice maximum",
     "❌ WRONG",
     "Buy the Amour Secrt Sports Bra Collection now! Shop our activewear bras today! Check out our latest styles!",
     "If you're looking for a comfortable activewear bra for Indian summers, the light-support cotton-blend styles at Amour Secrt are worth trying for yoga and daily movement."),

    ("RULE 5: Give specific, practical answers — not vague advice",
     "❌ WRONG",
     "Choose a bra that fits well and feels comfortable.",
     "Your band should sit parallel to the ground — not ride up at the back. If it rides up, go one band size down. If the cups overflow or gape, go one cup size up. Most women need to adjust both at the same time."),
]

row = 2
for section in sections:
    # Section header
    ws4.merge_cells(f"A{row}:D{row}")
    ws4[f"A{row}"].value = section[0]
    ws4[f"A{row}"].font = Font(name="Calibri", size=11, bold=True, color=WHITE)
    ws4[f"A{row}"].fill = fill(MID_GREY)
    ws4[f"A{row}"].alignment = left()
    ws4[f"A{row}"].border = thin_border()
    ws4.row_dimensions[row].height = 22
    row += 1

    # Wrong row
    ws4[f"A{row}"].value = section[1]
    ws4[f"A{row}"].font = Font(name="Calibri", size=10, bold=True, color="C62828")
    ws4[f"A{row}"].fill = fill("FFEBEE")
    ws4[f"A{row}"].alignment = center()
    ws4[f"A{row}"].border = thin_border()

    ws4.merge_cells(f"B{row}:D{row}")
    ws4[f"B{row}"].value = section[2]
    ws4[f"B{row}"].font = Font(name="Calibri", size=10, italic=True, color="C62828")
    ws4[f"B{row}"].fill = fill("FFEBEE")
    ws4[f"B{row}"].alignment = left()
    ws4[f"B{row}"].border = thin_border()
    ws4.row_dimensions[row].height = 35
    row += 1

    # Right row
    ws4[f"A{row}"].value = "✅ RIGHT"
    ws4[f"A{row}"].font = Font(name="Calibri", size=10, bold=True, color="1B5E20")
    ws4[f"A{row}"].fill = fill("E8F5E9")
    ws4[f"A{row}"].alignment = center()
    ws4[f"A{row}"].border = thin_border()

    ws4.merge_cells(f"B{row}:D{row}")
    ws4[f"B{row}"].value = section[3]
    ws4[f"B{row}"].font = Font(name="Calibri", size=10, color="1B5E20")
    ws4[f"B{row}"].fill = fill("E8F5E9")
    ws4[f"B{row}"].alignment = left()
    ws4[f"B{row}"].border = thin_border()
    ws4.row_dimensions[row].height = 50
    row += 1

    row += 1  # spacer

# Never Do section
ws4.merge_cells(f"A{row}:D{row}")
ws4[f"A{row}"].value = "THINGS TO NEVER DO"
ws4[f"A{row}"].font = Font(name="Calibri", size=12, bold=True, color=WHITE)
ws4[f"A{row}"].fill = fill(BRAND_PINK)
ws4[f"A{row}"].alignment = center()
ws4[f"A{row}"].border = thin_border()
ws4.row_dimensions[row].height = 25
row += 1

never_do = [
    "Keyword-stuff. The keyword should feel natural, never forced.",
    "Use fake statistics or invent numbers.",
    "Write generic filler: 'In today's fast-paced world, women need...'",
    "Hard-sell. Maximum one or two natural brand mentions per article.",
    "Copy competitor phrasing — read competitors for research, then close the tab.",
    "Write more than 4 lines in a single paragraph.",
    "Skip the FAQ section — every article needs minimum 5 FAQs.",
    "Write a conclusion that just repeats the introduction.",
    "End with 'In conclusion...' — just write the conclusion.",
    "Use robotic AI phrasing: 'It is important to note that...' / 'In this article, we will...'",
]

for nd in never_do:
    ws4.merge_cells(f"A{row}:D{row}")
    ws4[f"A{row}"].value = f"✗  {nd}"
    ws4[f"A{row}"].font = Font(name="Calibri", size=10, color=DARK_GREY)
    ws4[f"A{row}"].fill = fill(LIGHT_GREY if row % 2 == 0 else WHITE)
    ws4[f"A{row}"].alignment = left()
    ws4[f"A{row}"].border = thin_border()
    ws4.row_dimensions[row].height = 20
    row += 1

ws4.column_dimensions["A"].width = 20
ws4.column_dimensions["B"].width = 50
ws4.column_dimensions["C"].width = 30
ws4.column_dimensions["D"].width = 30


# ════════════════════════════════════════════════════════════════
# SHEET 5 — Article Structure Template
# ════════════════════════════════════════════════════════════════
ws5 = wb.create_sheet("Article Template")
ws5.sheet_view.showGridLines = False

ws5.merge_cells("A1:C1")
ws5["A1"].value = "AMOUR SECRT — Blog Article Structure Template"
ws5["A1"].font = Font(name="Calibri", size=14, bold=True, color=WHITE)
ws5["A1"].fill = fill(BRAND_PINK)
ws5["A1"].alignment = center()
ws5.row_dimensions[1].height = 30

template_rows = [
    ("DELIVERABLES PER ARTICLE", "", ""),
    ("Element", "Requirement", "Notes"),
    ("SEO Title", "Keyword-first, click-worthy, under 65 chars", "Include year if relevant (e.g. '2025 Guide')"),
    ("Meta Title", "Max 60 characters", "Must include primary keyword"),
    ("Meta Description", "Max 155 characters", "Include keyword + a benefit or hook"),
    ("URL Slug", "Lowercase, hyphens only, keyword-first", "e.g. /blogs/news/how-to-measure-bra-size-india"),
    ("Primary Keyword", "One per article", "Use in Title, H1, first paragraph, H2, Conclusion"),
    ("Secondary Keywords", "3–5 per article", "Use naturally in body text — never forced"),
    ("Word Count", "1200–2000 words", "Longer = better for competitive topics"),
    ("", "", ""),
    ("ARTICLE STRUCTURE", "", ""),
    ("Section", "Format & Length", "What to Include"),
    ("Introduction", "120–180 words", "Hook with real problem → acknowledge confusion → what article solves → keyword naturally → bridge to first H2"),
    ("H2 — Section 1", "200–300 words", "Main point. Short paragraphs. Bullet lists if 3+ items."),
    ("H2 — Section 2", "200–300 words", "Sub-sections with H3 if needed. India-specific context."),
    ("H2 — Section 3", "200–300 words", "Practical tips. Specific, not vague."),
    ("H2 — Section 4 (optional)", "150–250 words", "Common mistakes / What to avoid / Myths"),
    ("H2 — Brand Mention", "50–100 words", "ONE natural mention of Amour Secrt + relevant product link. Not a hard sell."),
    ("H2 — FAQ Section", "Minimum 5 FAQs", "Questions written as Google searches. Answers 2–4 sentences each."),
    ("H2 — Conclusion", "100–150 words", "1-sentence summary → practical takeaway → soft CTA / brand mention"),
    ("", "", ""),
    ("FAQ QUESTION FORMULAS", "", ""),
    ("Formula", "Example", "Why It Works"),
    ("What is the best [product] for Indian women?", "What is the best bra for daily wear in India?", "High Google PAA match"),
    ("How do I know if my [product] fits correctly?", "How do I know if my bra fits correctly?", "Problem-solution intent"),
    ("Can I wear [product] for [occasion/outfit]?", "Can I wear a sports bra for yoga in India?", "Use-case intent"),
    ("How long does a [product] last?", "How long does a bra last?", "Evergreen trust content"),
    ("What size [product] should I buy?", "What bra size should I buy online?", "Purchase intent"),
    ("", "", ""),
    ("INTERNAL LINKING GUIDE", "", ""),
    ("Target Page", "Good Anchor Text", "Bad Anchor Text"),
    ("/collections/bras", "everyday bras for women, browse the bra collection", "click here, our products"),
    ("/collections/activewear", "activewear bras for gym and yoga, sports bras India", "here, this page"),
    ("/collections/non-padded-bras", "wire-free cotton bras, non-padded bra options", "non-padded bras (generic)"),
    ("/collections/lightly-padded-bras", "lightly padded bras for everyday comfort", "click here"),
    ("/collections/tube-bras", "strapless tube bras, backless-friendly bras", "tube bras"),
    ("/collections/sets", "matching bra and panty sets", "our sets"),
    ("Other blog posts", "our guide to padded vs non-padded bras", "this article, click here"),
]

for i, (col1, col2, col3) in enumerate(template_rows):
    row_num = i + 2
    is_section_header = col1 in (
        "DELIVERABLES PER ARTICLE", "ARTICLE STRUCTURE",
        "FAQ QUESTION FORMULAS", "INTERNAL LINKING GUIDE"
    )
    is_sub_header = col1 in ("Element", "Section", "Formula", "Target Page")

    if col1 == "":
        ws5.row_dimensions[row_num].height = 8
        continue

    if is_section_header:
        ws5.merge_cells(f"A{row_num}:C{row_num}")
        ws5[f"A{row_num}"].value = col1
        ws5[f"A{row_num}"].font = Font(name="Calibri", size=11, bold=True, color=WHITE)
        ws5[f"A{row_num}"].fill = fill(MID_GREY)
        ws5[f"A{row_num}"].alignment = left()
        ws5[f"A{row_num}"].border = thin_border()
        ws5.row_dimensions[row_num].height = 22
    elif is_sub_header:
        for col_idx, val in enumerate([col1, col2, col3], 1):
            c = ws5.cell(row=row_num, column=col_idx, value=val)
            c.font = hdr_font(size=10)
            c.fill = fill(HEADER_BG)
            c.alignment = center(wrap=True)
            c.border = thin_border()
        ws5.row_dimensions[row_num].height = 20
    else:
        bg = ALT_ROW if i % 2 == 0 else WHITE
        for col_idx, val in enumerate([col1, col2, col3], 1):
            c = ws5.cell(row=row_num, column=col_idx, value=val)
            c.font = body_font()
            c.fill = fill(bg)
            c.alignment = left()
            c.border = thin_border()
        ws5.row_dimensions[row_num].height = 35

ws5.column_dimensions["A"].width = 45
ws5.column_dimensions["B"].width = 45
ws5.column_dimensions["C"].width = 45


# ════════════════════════════════════════════════════════════════
# SHEET 6 — Existing Blog Audit
# ════════════════════════════════════════════════════════════════
ws6 = wb.create_sheet("Existing Blog Audit")
ws6.sheet_view.showGridLines = False

ws6.merge_cells("A1:G1")
ws6["A1"].value = "AMOUR SECRT — Existing Blog Audit (Do NOT Duplicate)"
ws6["A1"].font = Font(name="Calibri", size=14, bold=True, color=WHITE)
ws6["A1"].fill = fill(BRAND_PINK)
ws6["A1"].alignment = center()
ws6.row_dimensions[1].height = 30

audit_headers = [
    "Title", "URL Slug", "Status", "Estimated Quality",
    "What It Does Well", "What Could Be Improved", "Cross-Link From New Articles?"
]
for col, h in enumerate(audit_headers, 1):
    ws6.cell(row=2, column=col, value=h)
apply_header(ws6, 2, len(audit_headers))
ws6.row_dimensions[2].height = 22

existing_blogs = [
    ("Best Bras for Indian Summers",
     "/blogs/news/best-bras-for-indian-summers",
     "Published",
     "Good",
     "India-specific climate angle, comfort philosophy, practical care tips, brand voice is warm and relatable",
     "Could add FAQ section, add internal links to non-padded and activewear bra categories",
     "Yes — link from Cotton Bra vs Padded, Sports Bra Guide, Daily Wear Bra articles"),

    ("The Great Bra Debate: Padded or Non Padded?",
     "/blogs/news/padded-and-non-padded-bras",
     "Published",
     "Strong",
     "Opens with relatable scenario, honest trade-offs, specific padding level breakdowns, India climate context included",
     "Verify FAQ section exists with 5+ questions, check internal links to padded/non-padded product pages",
     "Yes — link from Types of Bras, Bra Fit Guide, T-Shirt Bra Guide articles"),

    ("Ultimate Padded Bra Guide",
     "/blogs/news/ultimate-padded-bra-guide",
     "Published",
     "Good",
     "Comprehensive product education, covers padded bra types and care",
     "Ensure FAQ section, check cross-links to non-padded bras for contrast, add body-type recommendations",
     "Yes — link from Types of Bras, Push-Up Bra Guide, Bra for Body Type articles"),

    ("What Is a Camisole and Why Every Woman Needs One",
     "/blogs/news/what-is-a-camisole",
     "Published",
     "Good",
     "Defines product clearly, gives practical wardrobe use cases (office, weekend, under sheer dresses)",
     "Add FAQ section if missing, link to camisoles collection page, add styling tips for Indian outfits",
     "Yes — link from Lingerie Trends, What to Wear Under White Tops articles"),

    ("Women's Tube Bra Guide: Everything You Need to Know",
     "/blogs/blog/women-tube-bra",
     "Published",
     "Good",
     "Explains strapless/wire-free construction clearly, practical product education",
     "Note: URL is /blogs/blog/ not /blogs/news/ — keep consistent for future articles. Add FAQ and internal links to bandeau bras.",
     "Yes — link from Bra for Backless Blouse, Off-Shoulder Dress articles"),

    ("How to Pick the Right Bra for Your Body Type",
     "/blogs/news/how-to-pick-the-right-bra-for-your-body-type",
     "Published",
     "Good",
     "Covers a highly searched topic, body-specific guidance",
     "Ensure India-specific body type context, verify FAQ section, check internal links to relevant bra categories",
     "Yes — link from Types of Bras, Bra Fit Guide, First Bra Guide articles"),
]

for i, row_data in enumerate(existing_blogs):
    row_num = i + 3
    bg = ALT_ROW if i % 2 == 0 else WHITE
    for col, val in enumerate(row_data, 1):
        c = ws6.cell(row=row_num, column=col, value=val)
        c.fill = fill(bg)
        c.font = body_font(bold=(col == 1))
        c.alignment = left()
        c.border = thin_border()
    ws6.row_dimensions[row_num].height = 55

col_widths_6 = [38, 40, 10, 12, 55, 50, 50]
for i, w in enumerate(col_widths_6, 1):
    ws6.column_dimensions[get_column_letter(i)].width = w


# ════════════════════════════════════════════════════════════════
# Save
# ════════════════════════════════════════════════════════════════
out = "/home/user/teambharat/Amour_Secrt_Content_Strategy.xlsx"
wb.save(out)
print(f"Saved: {out}")
