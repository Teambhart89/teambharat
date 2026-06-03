import openpyxl
from openpyxl.styles import (
    PatternFill, Font, Alignment, Border, Side, GradientFill
)
from openpyxl.utils import get_column_letter
from openpyxl.chart import BarChart, Reference
from openpyxl.chart.series import DataPoint

wb = openpyxl.Workbook()

# ── colour palette ──────────────────────────────────────────────────────────
PINK_DARK   = "C2185B"   # header bg
PINK_MID    = "F48FB1"   # sub-header bg
PINK_LIGHT  = "FCE4EC"   # alternate row tint
GOLD        = "F9A825"   # accent / warning
RED         = "B71C1C"
GREEN_DARK  = "1B5E20"
GREEN_LIGHT = "E8F5E9"
GREY        = "F5F5F5"
WHITE       = "FFFFFF"
BLACK       = "000000"
ORANGE      = "E65100"

def hdr_fill(hex_col):
    return PatternFill("solid", fgColor=hex_col)

def hdr_font(hex_col=WHITE, bold=True, sz=11):
    return Font(color=hex_col, bold=bold, size=sz, name="Calibri")

def body_font(bold=False, sz=10, color=BLACK):
    return Font(bold=bold, size=sz, name="Calibri", color=color)

def center():
    return Alignment(horizontal="center", vertical="center", wrap_text=True)

def left():
    return Alignment(horizontal="left", vertical="center", wrap_text=True)

def thin_border():
    s = Side(style="thin", color="BDBDBD")
    return Border(left=s, right=s, top=s, bottom=s)

def set_col_widths(ws, widths):
    for col, w in enumerate(widths, 1):
        ws.column_dimensions[get_column_letter(col)].width = w

def write_header_row(ws, row, values, bg=PINK_DARK, fg=WHITE, sz=11, height=22):
    for col, val in enumerate(values, 1):
        c = ws.cell(row=row, column=col, value=val)
        c.fill = hdr_fill(bg)
        c.font = hdr_font(fg, True, sz)
        c.alignment = center()
        c.border = thin_border()
    ws.row_dimensions[row].height = height

def write_data_row(ws, row, values, bg=WHITE, bold=False, sz=10, aligns=None):
    for col, val in enumerate(values, 1):
        c = ws.cell(row=row, column=col, value=val)
        c.fill = hdr_fill(bg)
        c.font = body_font(bold, sz)
        c.alignment = (aligns[col-1] if aligns else left())
        c.border = thin_border()

def add_title_block(ws, title, subtitle, row=1):
    ws.merge_cells(start_row=row, start_column=1, end_row=row, end_column=12)
    c = ws.cell(row=row, column=1, value=title)
    c.fill = hdr_fill(PINK_DARK)
    c.font = Font(color=WHITE, bold=True, size=16, name="Calibri")
    c.alignment = center()
    ws.row_dimensions[row].height = 32

    ws.merge_cells(start_row=row+1, start_column=1, end_row=row+1, end_column=12)
    c2 = ws.cell(row=row+1, column=1, value=subtitle)
    c2.fill = hdr_fill(PINK_MID)
    c2.font = Font(color=WHITE, bold=False, size=10, name="Calibri")
    c2.alignment = center()
    ws.row_dimensions[row+1].height = 18

# ════════════════════════════════════════════════════════════════════════════
# SHEET 1 — BRAND PRESENCE AUDIT
# ════════════════════════════════════════════════════════════════════════════
ws1 = wb.active
ws1.title = "1. Brand Presence Audit"
add_title_block(ws1, "AMOUR SECRET — Brand Presence Audit", "Amazon India & Myntra | June 2026")

# Amazon section
r = 4
ws1.merge_cells(start_row=r, start_column=1, end_row=r, end_column=6)
c = ws1.cell(row=r, column=1, value="AMAZON INDIA PROFILE")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(); c.alignment = center(); ws1.row_dimensions[r].height = 20

r += 1
write_header_row(ws1, r, ["Dimension","Status","Detail","Category","Price Range","FBA/Prime"], PINK_MID, WHITE, 10, 18)

amazon_data = [
    ("Brand Store","✅ Active","amazon.in/stores/AmourSecret/","All","—","❌ Not Confirmed"),
    ("Seller Entity","Active","M/S Magpie Impex Pvt. Ltd.","All","—","❌ Not Confirmed"),
    ("A+ Content","⚠️ Likely","Brand Registry enrolled; quality unverified","All","—","—"),
    ("Brand Registry","✅ Enrolled","Required for Brand Store — confirmed","All","—","—"),
    ("Overall Rating","~78% positive","1,000+ customer ratings","All","—","—"),
    ("Bras (padded, seamless, T-shirt, sports, tube)","✅ Active","Multiple styles listed","Bras","₹175 – ₹999","❌"),
    ("Panties / Briefs","✅ Active","Hipster, boyshort, nylon multipacks","Briefs","₹175 – ₹399","❌"),
    ("Lingerie Sets","✅ Active","Bra + panty coordinated sets","Sets","₹649 – ₹999","❌"),
    ("Camisoles","✅ Active","Lightly padded","Camisoles","₹430 – ₹649","❌"),
    ("Bra Inserts / Foam Pads","✅ Active","Enhancer foam packs","Inserts","₹175 – ₹350","❌"),
    ("Shapewear","❌ MISSING","Not listed on Amazon","—","—","—"),
    ("Nightwear","❌ MISSING","Not listed on Amazon","—","—","—"),
    ("Activewear","❌ MISSING","Not listed on Amazon","—","—","—"),
]
for i, row_data in enumerate(amazon_data):
    bg = GREY if i % 2 == 0 else WHITE
    if "MISSING" in str(row_data[1]):
        bg = "FFEBEE"
    write_data_row(ws1, r+1+i, list(row_data), bg)

r += len(amazon_data) + 2

# Myntra section
ws1.merge_cells(start_row=r, start_column=1, end_row=r, end_column=6)
c = ws1.cell(row=r, column=1, value="MYNTRA PROFILE")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(); c.alignment = center(); ws1.row_dimensions[r].height = 20

r += 1
write_header_row(ws1, r, ["Category","SKU Count","% of Catalog","Avg Rating","Price Range","Notes"], PINK_MID, WHITE, 10, 18)
myntra_data = [
    ("Bras","~1,734","58%","4.1–4.4★","₹175–₹1,499","Largest category"),
    ("Briefs / Panties","~1,119","37%","4.1–4.3★","₹175–₹399","Strong multi-pack SKUs"),
    ("Lingerie Sets","~101","3.4%","4.1–4.4★","₹499–₹1,499","Growth opportunity"),
    ("Camisoles","~27","0.9%","~4.0★","₹350–₹649","Minimal presence"),
    ("Capris","~3","0.1%","—","—","Negligible"),
    ("Shapewear","❌ 0","0%","—","—","MISSING — high opportunity"),
    ("Nightwear","❌ 0","0%","—","—","MISSING — high opportunity"),
    ("Total","~2,984","100%","4.1–4.4★","₹175–₹1,499","#7 by padded bra catalog depth"),
]
for i, row_data in enumerate(myntra_data):
    bg = GREY if i % 2 == 0 else WHITE
    if "MISSING" in str(row_data[5]):
        bg = "FFEBEE"
    if row_data[0] == "Total":
        bg = PINK_LIGHT
    write_data_row(ws1, r+1+i, list(row_data), bg)

set_col_widths(ws1, [28, 14, 14, 14, 16, 38])

# ════════════════════════════════════════════════════════════════════════════
# SHEET 2 — COMPETITOR BENCHMARK
# ════════════════════════════════════════════════════════════════════════════
ws2 = wb.create_sheet("2. Competitor Benchmark")
add_title_block(ws2, "COMPETITOR BENCHMARK REPORT", "Amazon India & Myntra | All Major Competitors")

r = 4
write_header_row(ws2, r, [
    "Brand","Amazon\nBrand Store","FBA/Prime","Highest Reviewed\nProduct (Reviews)","Top Product\nRating",
    "Typical\nDiscount","Bra Price Range","Shapewear","Nightwear","Myntra Position","Score /100"
], PINK_DARK, WHITE, 10, 30)

comp_data = [
    ("Enamor","✅ Multi-page","✅ Cocoblu","17,606 (SB06 Sports Bra)","4.2★","20–50%","₹600–₹1,800","❌ Minimal","❌ Minimal","High organic","85"),
    ("Clovia","✅ Multi-page","✅ Cocoblu + own","~962 (growing via ads)","4.4★","50–70%","₹250–₹1,800","✅ Strong","✅ Strong","Very strong all-cat","91"),
    ("Nykd by Nykaa","✅ Multi-page","✅ Cocoblu","2,810 (Everyday Bra)","4.1★","Up to 50%","₹399–₹999","❌ Minimal","❌ Minimal","Growing rapidly","80"),
    ("Zivame","✅ Multi-page","✅ Prime","~273 (Amazon)","4.2★","50–60%","₹267–₹1,500","✅ Active","❌ Minimal","Medium (own site stronger)","78"),
    ("Wacoal India","✅ Best Sellers pg","✅ Prime","Not disclosed","~4.2★","20–50%","₹799–₹2,600+","✅ Shapewear","❌","Premium filter","73"),
    ("Amante","✅ Active","✅ Prime","Not disclosed","Positive","60%+30% checkout","₹600–₹2,000","❌","❌","Mid-premium","72"),
    ("Soie","✅ Multi-page","⚠️ Partial","~231 (T-Shirt Bra)","4.3★","20–40%","₹999–₹1,441","❌","❌","Niche/premium","59"),
    ("Lovable","⚠️ Partial","❌ Unconfirmed","~219 (Cotton Bra)","4.0★","20–40%","₹500–₹900","❌","❌","Moderate (Flipkart stronger)","52"),
    ("PrettySecrets","❌ Not confirmed","❌ Unconfirmed","Low","—","Up to 50%","₹300–₹1,000","❌","❌","Mid (Myntra/AJIO stronger)","—"),
    ("Kyando","—","—","—","—","—","—","—","—","—","—"),
    ("Naidu Hall","—","—","—","—","—","—","—","—","—","—"),
    ("AMOUR SECRET","✅ Active","❌ NOT CONFIRMED","17–162 / SKU","4.1–4.4★","40–80%","₹175–₹1,499","❌ MISSING","❌ MISSING","#7 padded bra catalog","50"),
]
score_map = {"91":GREEN_DARK,"85":GREEN_DARK,"80":"2E7D32","78":"388E3C","73":"558B2F","72":"689F38","59":GOLD,"52":ORANGE,"50":RED,"—":WHITE}
for i, row_data in enumerate(comp_data):
    is_as = row_data[0] == "AMOUR SECRET"
    bg = PINK_LIGHT if is_as else (GREY if i % 2 == 0 else WHITE)
    write_data_row(ws2, r+1+i, list(row_data[:-1]), bg)
    score_cell = ws2.cell(row=r+1+i, column=11, value=row_data[-1])
    score_color = score_map.get(row_data[-1], WHITE)
    score_cell.fill = hdr_fill(score_color)
    score_cell.font = Font(color=WHITE, bold=True, size=10, name="Calibri")
    score_cell.alignment = center()
    score_cell.border = thin_border()

set_col_widths(ws2, [18,14,14,24,12,16,16,12,12,24,10])

# ════════════════════════════════════════════════════════════════════════════
# SHEET 3 — TOP 100 KEYWORDS
# ════════════════════════════════════════════════════════════════════════════
ws3 = wb.create_sheet("3. Top 100 Keywords")
add_title_block(ws3, "TOP 100 AMAZON INDIA KEYWORDS — Lingerie & Innerwear", "Tier 1 (High Volume) → Tier 3 (Long-Tail/High Conversion) | June 2026")

r = 4
write_header_row(ws3, r, ["#","Keyword","Tier","Est. Monthly Volume","Category","India-Unique?","Priority","Recommended Placement"], PINK_DARK, WHITE, 10, 22)

keywords = [
    (1,"bra for women","1","100K+","Bra","No","🔴 Critical","Title + Bullets + Backend"),
    (2,"sports bra","1","80K+","Sports","No","🔴 Critical","Title + Bullets + Backend"),
    (3,"padded bra","1","70K+","Bra","No","🔴 Critical","Title + Bullets + Backend"),
    (4,"bra","1","60K+","Bra","No","🔴 Critical","Title + Backend"),
    (5,"cotton bra","1","50K+","Bra","No","🔴 Critical","Title + Bullets"),
    (6,"push up bra","1","40K+","Bra","No","🔴 Critical","Title + Bullets"),
    (7,"nightwear for women","1","35K+","Nightwear","No","🔴 Critical","Title (new category)"),
    (8,"shapewear","1","30K+","Shapewear","No","🔴 Critical","Title (new category)"),
    (9,"lingerie set","1","25K+","Sets","No","🔴 Critical","Title + Bullets"),
    (10,"t-shirt bra","1","20K+","Bra","No","🔴 Critical","Title + Bullets"),
    (11,"padded bra for women","2","High","Bra","No","🟠 High","Title"),
    (12,"sports bra for women","2","High","Sports","No","🟠 High","Title"),
    (13,"non padded bra","2","High","Bra","No","🟠 High","Title + Backend"),
    (14,"wireless bra","2","High","Bra","No","🟠 High","Title + Bullets"),
    (15,"seamless bra","2","High","Bra","No","🟠 High","Title + Bullets"),
    (16,"bra panty set","2","High","Sets","No","🟠 High","Title"),
    (17,"night dress for women","2","High","Nightwear","No","🟠 High","Title (new cat)"),
    (18,"night suit for women","2","High","Nightwear","🇮🇳 Yes","🟠 High","Title (new cat)"),
    (19,"body shaper for women","2","Med-High","Shapewear","No","🟠 High","Title (new cat)"),
    (20,"tummy control shapewear","2","Med-High","Shapewear","No","🟠 High","Title + Backend"),
    (21,"full coverage bra","2","Med-High","Bra","No","🟠 High","Title + Bullets"),
    (22,"non wired bra","2","Medium","Bra","No","🟠 High","Title + Backend"),
    (23,"wired bra","2","Medium","Bra","No","🟠 High","Backend"),
    (24,"push up bra for women","2","Medium","Bra","No","🟠 High","Title"),
    (25,"gym bra","2","Medium","Sports","No","🟠 High","Title + Backend"),
    (26,"yoga bra","2","Medium","Sports","No","🟠 High","Bullets + Backend"),
    (27,"nighty for women","2","Medium","Nightwear","🇮🇳 Yes","🟠 High","Title (new cat)"),
    (28,"cotton night suit","2","Medium","Nightwear","🇮🇳 Yes","🟠 High","Title (new cat)"),
    (29,"saree shapewear","2","Medium","Shapewear","🇮🇳 Yes","🟠 High","Title + Backend"),
    (30,"bralette","2","Medium","Bra","No","🟠 High","Title + Backend"),
    (31,"minimizer bra","2","Medium","Bra","No","🟡 Med","Title + Backend"),
    (32,"strapless bra","2","Medium","Bra","No","🟡 Med","Backend"),
    (33,"maternity bra","2","Medium","Bra","No","🟡 Med","Backend"),
    (34,"nursing bra","2","Medium","Bra","No","🟡 Med","Backend"),
    (35,"plunge bra","2","Medium","Bra","No","🟡 Med","Backend"),
    (36,"balconette bra","2","Medium","Bra","No","🟡 Med","Backend"),
    (37,"multiway bra","2","Medium","Bra","No","🟡 Med","Backend"),
    (38,"high impact sports bra","2","Medium","Sports","No","🟡 Med","Title + Bullets"),
    (39,"racerback sports bra","2","Medium","Sports","No","🟡 Med","Backend"),
    (40,"padded sports bra","2","Medium","Sports","No","🟡 Med","Title"),
    (41,"lingerie for women","2","Medium","Lingerie","No","🟡 Med","Backend"),
    (42,"sexy lingerie","2","Medium","Lingerie","No","🟡 Med","Backend"),
    (43,"honeymoon lingerie","2","Medium","Lingerie","No","🟡 Med","Backend — seasonal"),
    (44,"babydoll nightwear","2","Medium","Nightwear","No","🟡 Med","Backend (new cat)"),
    (45,"satin nightwear","2","Medium","Nightwear","No","🟡 Med","Title (new cat)"),
    (46,"night gown","2","Medium","Nightwear","No","🟡 Med","Backend"),
    (47,"pyjama set for women","2","Medium","Nightwear","No","🟡 Med","Title (new cat)"),
    (48,"high waist shapewear","2","Medium","Shapewear","No","🟡 Med","Title (new cat)"),
    (49,"shapewear shorts","2","Medium","Shapewear","No","🟡 Med","Backend"),
    (50,"seamless shapewear","2","Medium","Shapewear","No","🟡 Med","Backend"),
    (51,"cotton padded bra for women","3","Med-Low","Bra","No","🟡 Med","Title variation"),
    (52,"full coverage padded sports bra for women","3","Med-Low","Sports","No","🟡 Med","Long-tail title"),
    (53,"cotton non padded bra","3","Med-Low","Bra","No","🟡 Med","Title"),
    (54,"seamless wireless bra for women","3","Med-Low","Bra","No","🟡 Med","Title"),
    (55,"t shirt bra for women","3","Med-Low","Bra","No","🟡 Med","Title variation"),
    (56,"push up bra with underwire","3","Med-Low","Bra","No","🟡 Med","Backend"),
    (57,"non padded non wired bra","3","Med-Low","Bra","No","🟡 Med","Title"),
    (58,"soft cup bra","3","Med-Low","Bra","No","🟡 Med","Backend"),
    (59,"lace bra","3","Med-Low","Bra","No","🟡 Med","Backend"),
    (60,"backless bra","3","Med-Low","Bra","No","🟡 Med","Backend"),
    (61,"adhesive bra","3","Low","Bra","No","🟢 Low","Backend"),
    (62,"strapless backless bra","3","Low","Bra","No","🟢 Low","Backend"),
    (63,"sports bra with zipper","3","Low","Sports","No","🟢 Low","Backend"),
    (64,"front open sports bra","3","Low","Sports","No","🟢 Low","Backend"),
    (65,"cross back sports bra","3","Low","Sports","No","🟢 Low","Backend"),
    (66,"high support sports bra","3","Low","Sports","No","🟢 Low","Bullets"),
    (67,"medium support sports bra","3","Low","Sports","No","🟢 Low","Bullets"),
    (68,"moisture wicking sports bra","3","Low","Sports","No","🟢 Low","Bullets"),
    (69,"bra panty set for women","3","Low","Sets","No","🟢 Low","Title"),
    (70,"bridal lingerie set","3","Low","Sets","No","🟢 Low","Backend — seasonal"),
    (71,"honeymoon lingerie set","3","Low","Sets","No","🟢 Low","Backend — seasonal"),
    (72,"saree shapewear petticoat","3","Low","Shapewear","🇮🇳 Yes","🟡 Med","Title (new cat)"),
    (73,"tummy tucker","3","Low","Shapewear","🇮🇳 Yes","🟡 Med","Backend"),
    (74,"belly fat control shapewear","3","Low","Shapewear","🇮🇳 Yes","🟡 Med","Backend"),
    (75,"body shaping shorts","3","Low","Shapewear","No","🟢 Low","Backend"),
    (76,"butt lifter shapewear","3","Low","Shapewear","No","🟢 Low","Backend"),
    (77,"full body shaper","3","Low","Shapewear","No","🟢 Low","Backend"),
    (78,"waist cincher","3","Low","Shapewear","No","🟢 Low","Backend"),
    (79,"shapewear for saree","3","Low","Shapewear","🇮🇳 Yes","🟡 Med","Title + Backend"),
    (80,"cotton night suit for women","3","Low","Nightwear","🇮🇳 Yes","🟡 Med","Title (new cat)"),
    (81,"printed night suit","3","Low","Nightwear","No","🟢 Low","Backend"),
    (82,"satin night dress","3","Low","Nightwear","No","🟢 Low","Backend"),
    (83,"korean night suit","3","Low","Nightwear","🇮🇳 Yes","🟠 High","Title — TRENDING 2024-25"),
    (84,"half sleeve night suit","3","Low","Nightwear","🇮🇳 Yes","🟢 Low","Backend"),
    (85,"maxi night gown","3","Low","Nightwear","No","🟢 Low","Backend"),
    (86,"nighty gown","3","Low","Nightwear","🇮🇳 Yes","🟢 Low","Backend — colloquial"),
    (87,"slip dress nightwear","3","Low","Nightwear","No","🟢 Low","Backend"),
    (88,"pack of 3 bra","3","Med-Low","Multi-pack","No","🟠 High","Title — high conversion"),
    (89,"pack of 2 sports bra","3","Med-Low","Multi-pack","No","🟠 High","Title — high conversion"),
    (90,"cotton bra pack of 3","3","Med-Low","Multi-pack","No","🟠 High","Title"),
    (91,"bra size 34","3","Med-Low","Bra","No","🟡 Med","Backend"),
    (92,"bra size 36","3","Med-Low","Bra","No","🟡 Med","Backend"),
    (93,"bra size 32","3","Med-Low","Bra","No","🟡 Med","Backend"),
    (94,"plus size bra","3","Low","Bra","No","🟡 Med","Title + Backend"),
    (95,"everyday bra","3","Low","Bra","No","🟡 Med","Title + Backend"),
    (96,"comfortable bra","3","Low","Bra","No","🟢 Low","Bullets + Backend"),
    (97,"wire free bra for women","3","Low","Bra","No","🟡 Med","Title"),
    (98,"front hook bra","3","Low","Bra","🇮🇳 Yes","🟡 Med","Backend"),
    (99,"seamless tube bra","3","Low","Bra","No","🟢 Low","Backend"),
    (100,"inner wear for women","3","Low","Innerwear","No","🟡 Med","Backend"),
]

tier_colors = {"1": "FCE4EC", "2": WHITE, "3": GREY}
priority_colors = {
    "🔴 Critical": "FFEBEE",
    "🟠 High": "FFF3E0",
    "🟡 Med": "FFFDE7",
    "🟢 Low": GREEN_LIGHT,
}
for kw in keywords:
    row_num = r + kw[0]
    bg = tier_colors.get(kw[2], WHITE)
    for col, val in enumerate(kw, 1):
        c = ws3.cell(row=row_num, column=col, value=val)
        c.fill = hdr_fill(bg)
        c.font = body_font(sz=9)
        c.alignment = left() if col > 2 else center()
        c.border = thin_border()
    # priority colour override on col 7
    p_cell = ws3.cell(row=row_num, column=7)
    p_cell.fill = hdr_fill(priority_colors.get(str(kw[6]), WHITE))
    p_cell.font = body_font(bold=True, sz=9)
    p_cell.alignment = center()

set_col_widths(ws3, [5, 32, 6, 18, 14, 14, 14, 28])

# ════════════════════════════════════════════════════════════════════════════
# SHEET 4 — LISTING QUALITY SCORECARD
# ════════════════════════════════════════════════════════════════════════════
ws4 = wb.create_sheet("4. Listing Quality Scorecard")
add_title_block(ws4, "PRODUCT LISTING QUALITY SCORECARD", "10 Dimensions × 10 Points Each | All Major Brands")

r = 4
dims = ["Brand","Title\n/10","Images\n/10","Reviews\n/10","Ratings\n/10","A+ Content\n/10","Videos\n/10","Pricing\n/10","Discounts\n/10","Keywords\n/10","Conversion\n/10","TOTAL\n/100","Rank"]
write_header_row(ws4, r, dims, PINK_DARK, WHITE, 10, 28)

scores = [
    ("Clovia",9,9,7,8,10,9,10,10,9,10,91,1),
    ("Enamor",9,9,10,8,9,7,8,7,9,9,85,2),
    ("Nykd by Nykaa",8,9,7,8,8,7,9,8,8,8,80,3),
    ("Zivame",8,8,5,7,8,9,8,9,8,8,78,4),
    ("Wacoal India",8,9,5,8,8,6,7,7,7,8,73,5),
    ("Amante",8,8,5,7,7,5,8,10,7,7,72,6),
    ("Soie",7,7,3,8,7,4,6,5,6,6,59,7),
    ("Lovable",6,7,3,7,5,3,6,5,5,5,52,8),
    ("AMOUR SECRET",5,6,2,8,5,2,7,6,5,4,50,9),
]

score_gradient = {
    range(85,101): GREEN_DARK,
    range(75,85): "2E7D32",
    range(65,75): "F57F17",
    range(55,65): ORANGE,
    range(0,55): RED,
}

def score_color(val):
    for rng, col in score_gradient.items():
        if val in rng:
            return col
    return WHITE

for i, row_data in enumerate(scores):
    is_as = row_data[0] == "AMOUR SECRET"
    base_bg = PINK_LIGHT if is_as else (GREY if i % 2 == 0 else WHITE)
    for col, val in enumerate(row_data, 1):
        c = ws4.cell(row=r+1+i, column=col, value=val)
        if col == 1:
            c.fill = hdr_fill(base_bg)
            c.font = body_font(bold=is_as, sz=10)
        elif col == 12:  # total
            total_val = val
            c.fill = hdr_fill(score_color(total_val))
            c.font = Font(color=WHITE, bold=True, size=11, name="Calibri")
        elif col == 13:  # rank
            c.fill = hdr_fill(base_bg)
            c.font = body_font(bold=True, sz=10)
        elif isinstance(val, int) and col > 1:
            intensity = val / 10.0
            if intensity >= 0.8:
                bg = "C8E6C9"
            elif intensity >= 0.6:
                bg = "FFF9C4"
            elif intensity >= 0.4:
                bg = "FFE0B2"
            else:
                bg = "FFCDD2"
            c.fill = hdr_fill(bg)
            c.font = body_font(bold=(val <= 3), sz=10)
        else:
            c.fill = hdr_fill(base_bg)
            c.font = body_font(sz=10)
        c.alignment = center()
        c.border = thin_border()

# Gap analysis note
gap_row = r + len(scores) + 3
ws4.merge_cells(start_row=gap_row, start_column=1, end_row=gap_row, end_column=13)
note = ws4.cell(row=gap_row, column=1,
    value="AMOUR SECRET GAP ANALYSIS: Reviews (2/10) and Videos (2/10) are the most critical gaps. FBA enrollment fixes Pricing/Conversion. A+ Content + Images fixable in 30 days. Review velocity via Amazon Vine takes 90 days.")
note.fill = hdr_fill("FFF9C4")
note.font = Font(bold=True, size=10, color=ORANGE, name="Calibri")
note.alignment = left()
ws4.row_dimensions[gap_row].height = 22

set_col_widths(ws4, [18,9,9,9,9,11,9,9,10,10,11,10,7])

# ════════════════════════════════════════════════════════════════════════════
# SHEET 5 — PRICING INTELLIGENCE
# ════════════════════════════════════════════════════════════════════════════
ws5 = wb.create_sheet("5. Pricing Intelligence")
add_title_block(ws5, "PRICING & PROMOTION INTELLIGENCE", "Amazon India & Myntra | All Competitor Brands")

r = 4
write_header_row(ws5, r, ["Brand","Bra MRP Range","Bra Selling Price","Typical Discount","Discount Architecture","Bundle Strategy","Festival Peak Discount","Ideal Position vs AS"], PINK_DARK, WHITE, 10, 22)

pricing = [
    ("Clovia","₹800–₹1,800","₹250–₹900","50–70%","High MRP, aggressive % off; bundle '4 bras ₹699'","4-pack, 3-pack, starter kit","Up to 80% (GIF/EORS)","Direct competitor — match pricing"),
    ("Enamor","₹600–₹1,800","₹400–₹1,200","20–50%","Premium mid-discount; FBA Prime badge does work","Minimal bundles","Up to 50% (GIF)","Premium — AS should undercut by 15–20%"),
    ("Nykd by Nykaa","₹500–₹999","₹299–₹799","Up to 50%","Accessible; FBA gives prime advantage","Multi-packs on cotton basics","Up to 50% (GIF)","Direct competitor — match or beat"),
    ("Zivame","₹500–₹1,499","₹267–₹900","50–60%","'Min 50 + 5% off' Amazon landing page featured","2-packs, gift sets","Up to 65%","Direct competitor — match"),
    ("Amante","₹600–₹2,000","₹350–₹1,400","60%+30% at checkout","Most aggressive stacked structure on Amazon","Minimal","Up to 70%","Premium — AS should undercut"),
    ("Wacoal India","₹999–₹2,600+","₹799–₹2,000","20–50%","Premium; festival sales only significant discount","Minimal","Up to 50%","Premium — AS should not compete here"),
    ("Soie","₹999–₹1,441","₹700–₹1,200","20–40%","Niche premium; moderate discount","Minimal","Up to 40%","Above AS — AS should target below Soie"),
    ("Lovable","₹500–₹900","₹350–₹700","20–40%","Value everyday; lower discount depth","Minimal","Up to 50%","AS should match or beat on multi-packs"),
    ("AMOUR SECRET\n(Current)","₹500–₹1,499","₹175–₹999","40–80%","Good range — MRP architecture needs raising","Minimal (needs work)","40–80%","—"),
    ("AMOUR SECRET\n(Recommended)","₹799–₹1,999","₹299–₹999","50–70%","Raise MRP → show larger % discount; build bundles","3-pack bra, starter kit, gift set","70–80% (EORS mandatory)","₹399–₹699 sweet spot (Clovia/Nykd zone)"),
]

for i, row_data in enumerate(pricing):
    is_as = "AMOUR SECRET" in str(row_data[0])
    is_rec = "Recommended" in str(row_data[0])
    if is_rec:
        bg = GREEN_LIGHT
    elif is_as:
        bg = PINK_LIGHT
    else:
        bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws5, r+1+i, list(row_data), bg, bold=is_as)

# Festival calendar
r2 = r + len(pricing) + 3
ws5.merge_cells(start_row=r2, start_column=1, end_row=r2, end_column=8)
c = ws5.cell(row=r2, column=1, value="FESTIVAL SALE CALENDAR")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(sz=12); c.alignment = center(); ws5.row_dimensions[r2].height = 22

r2 += 1
write_header_row(ws5, r2, ["Sale Event","Platform","Timing","Target Discount","Required Action","PLA Budget Multiplier","Inventory Lead Time","Revenue Opportunity"], PINK_MID, WHITE, 10, 22)

festivals = [
    ("Great Indian Festival","Amazon India","Sep–Oct","60–70%","Lightning Deals + Sponsored Brands Video + FBA stock pre-positioned","3×","90 days ahead","High"),
    ("Big Billion Days","Flipkart","Sep–Oct","60%+","Bundle + Flash Deals","3×","60 days ahead","High"),
    ("EORS (End of Reason Sale)","Myntra","June & December","70–80% MANDATORY","Sub-60% = invisible; hero images 2000px; PLA 3×","4×","60 days ahead","Very High"),
    ("Big Fashion Festival","Myntra","Sep–Oct","60–70%","PLA budget 3×; editorial feature submission 6 weeks ahead","3×","60 days ahead","High"),
    ("Hot Pink Sale","Nykaa","Oct–Nov","30–50%","If listed on Nykaa","2×","30 days ahead","Medium"),
    ("Monsoon Sale","Myntra","July","50–70%","Clear seasonal inventory; test new shapewear/nightwear SKUs","2×","30 days ahead","Medium"),
    ("Valentine's Day","All","Feb 14","30–50%","Lingerie set gift bundles; honeymoon/bridal SKU boost","2×","45 days ahead","Medium"),
    ("Wedding Season","All","Oct–Dec, Feb–Mar","—","Bridal lingerie sets; honeymoon sets; festive gift packaging","2×","60 days ahead","High"),
]
for i, row_data in enumerate(festivals):
    bg = GREY if i % 2 == 0 else WHITE
    if "EORS" in row_data[0]:
        bg = "FFEBEE"
    write_data_row(ws5, r2+1+i, list(row_data), bg)

set_col_widths(ws5, [22,18,16,16,42,18,18,14])

# ════════════════════════════════════════════════════════════════════════════
# SHEET 6 — IMAGE OPTIMIZATION
# ════════════════════════════════════════════════════════════════════════════
ws6 = wb.create_sheet("6. Image Optimization")
add_title_block(ws6, "IMAGE OPTIMIZATION REPORT", "Amazon India & Myntra Standards + Gap Analysis")

# Amazon standards
r = 4
ws6.merge_cells(start_row=r, start_column=1, end_row=r, end_column=7)
c = ws6.cell(row=r, column=1, value="AMAZON INDIA — IMAGE STANDARDS")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(); c.alignment = center(); ws6.row_dimensions[r].height = 20

r += 1
write_header_row(ws6, r, ["Slot","Image Type","Purpose","Resolution","Ratio","Priority","Amour Secret Status"], PINK_MID, WHITE, 10, 20)

amazon_imgs = [
    ("1 (Hero)","White background — product front view","Mandatory; product fills 85%+ frame","2,000×2,000px","1:1 Square","🔴 Mandatory","⚠️ Present — verify resolution"),
    ("2","Model shot — front, full silhouette","Shows fit, body proportion","2,000×2,000px","1:1 Square","🔴 Critical","⚠️ Present"),
    ("3","Model shot — back view","Back coverage, hook closure, straps","2,000×2,000px","1:1 Square","🔴 Critical","❓ Needs verification"),
    ("4","Lifestyle image","Real-life context (home, gym, office)","2,000×2,000px","1:1 Square","🟠 High","❓ Likely missing"),
    ("5","Feature infographic","Fabric properties, wire type, padding, moisture-wicking — text overlays","2,000×2,000px","1:1 Square","🔴 Critical","❌ MISSING — major gap"),
    ("6","Size guide / fit chart","How to measure underbust + overbust — reduces returns","2,000×2,000px","1:1 Square","🔴 Critical","❌ MISSING — major gap"),
    ("7","Fabric/texture close-up","Weave quality, lace detail, seam","2,000×2,000px","1:1 Square","🟠 High","❓ Needs verification"),
    ("8","Multi-pack/packaging","Pack contents or gift presentation","2,000×2,000px","1:1 Square","🟡 Medium","❓ Needs verification"),
    ("9","Color/variant comparison chart","All colors, style comparison","2,000×2,000px","1:1 Square","🟡 Medium","❓ Needs verification"),
    ("Video","15–30 sec product/fit demonstration","3.6× conversion lift documented","HD 1080p","16:9","🟠 High","❌ MISSING — major gap"),
]
for i, row_data in enumerate(amazon_imgs):
    bg = GREY if i % 2 == 0 else WHITE
    if "MISSING" in str(row_data[6]):
        bg = "FFEBEE"
    write_data_row(ws6, r+1+i, list(row_data), bg)

# Myntra standards
r2 = r + len(amazon_imgs) + 3
ws6.merge_cells(start_row=r2, start_column=1, end_row=r2, end_column=7)
c = ws6.cell(row=r2, column=1, value="MYNTRA — IMAGE STANDARDS (3:4 PORTRAIT RATIO MANDATORY)")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(); c.alignment = center(); ws6.row_dimensions[r2].height = 20

r2 += 1
write_header_row(ws6, r2, ["Slot","Image Type","Requirement","Min Resolution","Ratio","Priority","Critical Rule"], PINK_MID, WHITE, 10, 20)

myntra_imgs = [
    ("1 (Primary)","Model shot — front, white background","Full model visible; eyes to camera or 3/4 angle","1,080×1,440px","3:4 Portrait","🔴 MANDATORY","Wrong ratio = auto-rejection — #1 rejection cause"),
    ("2","Model shot — back","Full garment from behind; hands at sides","1,080×1,440px","3:4 Portrait","🔴 Critical","Same model as plate 1"),
    ("3","Detail/close-up","Most distinctive feature — fabric, lace, strap","1,080×1,440px","3:4 Portrait","🟠 High","Different model = QC rejection"),
    ("4","Lifestyle/contextual","Model in environment; slight movement OK","1,080×1,440px","3:4 Portrait","🟠 High","Women's wear MUST use female model"),
    ("5","Alternate view","Side, 3/4 angle, or styled ensemble","1,080×1,440px","3:4 Portrait","🟡 Medium","Headless/cropped shots PROHIBITED in primary"),
    ("6","Size guide / infographic","Measurement chart; fabric benefits","1,080×1,440px","3:4 Portrait","🟠 High","EORS hero placements need 2,000×2,000px"),
    ("7","Additional angle","Closure detail, strap construction","1,080×1,440px","3:4 Portrait","🟡 Low","Max 7 images per SKU"),
]
for i, row_data in enumerate(myntra_imgs):
    bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws6, r2+1+i, list(row_data), bg)

set_col_widths(ws6, [10,24,36,16,14,14,40])

# ════════════════════════════════════════════════════════════════════════════
# SHEET 7 — SEO & LISTING FORMULAS
# ════════════════════════════════════════════════════════════════════════════
ws7 = wb.create_sheet("7. SEO & Listing Formulas")
add_title_block(ws7, "SEO & LISTING OPTIMIZATION FORMULAS", "Title Templates | Bullet Frameworks | Backend Keyword Strategy")

r = 4
ws7.merge_cells(start_row=r, start_column=1, end_row=r, end_column=4)
c = ws7.cell(row=r, column=1, value="AMAZON INDIA TITLE FORMULAS (125-char limit for apparel)")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(); c.alignment = center(); ws7.row_dimensions[r].height = 20

r += 1
write_header_row(ws7, r, ["Sub-Category","Title Formula","Example (Amour Secret)","Character Count"], PINK_MID, WHITE, 10, 20)

titles = [
    ("Padded Bra","[Brand] Women's [Material] Padded [Wired/Non-Wired] [Coverage] [Type] Bra – [Feature], [Size Range]","Amour Secret Women's Cotton Padded Non-Wired Full Coverage T-Shirt Bra – Breathable, All Day Comfort, 32B–40D","118"),
    ("Sports Bra","[Brand] Sports Bra for Women – [Padding], [Back Design] & [Fabric Feature], [Support Level] for [Activity]","Amour Secret Sports Bra for Women – Padded, Cross Back & Moisture-Wicking, Medium Support for Gym Yoga Running","116"),
    ("Seamless/Wireless","[Brand] Women's Seamless Wire-Free Bra – [Coverage], [Feature 1], [Feature 2], [Size Range]","Amour Secret Women's Seamless Wire-Free Bra – Full Coverage, Skin-Friendly, Everyday Comfort, Free Size 30–40","116"),
    ("Lingerie Set","[Brand] Women's [Material] [Padded/Non-Padded] Bra Panty Set – [Style], [Color Options]","Amour Secret Women's Lace Padded Bra Panty Set – Bridal Lingerie, Available in 8 Colors, Sizes 30B–38D","108"),
    ("Multi-Pack Bra","[Brand] Women's [Material] [Type] Bra – Pack of [N], [Feature], [Color Options], [Size Range]","Amour Secret Women's Cotton Non-Padded Bra – Pack of 3, Non-Wired Full Coverage, Black White Nude, 30B–40D","116"),
    ("Shapewear (new)","[Brand] Women's [High Waist] Tummy Control [Type] – Seamless, For Under Dress/Saree, [Size Range]","Amour Secret Women's High Waist Tummy Control Shorts – Seamless Saree Shapewear, S–3XL","87"),
    ("Nightwear (new)","[Brand] Women's [Material] [Printed/Solid] [Type] – [Sleeve], [Size]","Amour Secret Women's Cotton Printed Night Suit – Half Sleeve Pyjama Set, XS–3XL","80"),
    ("Korean Night Suit (new)","[Brand] Women's [Material] Korean [Type] Set – [Feature], [Size Range]","Amour Secret Women's Cotton Korean Night Suit Pyjama Set – Elasticated Waist, XS–2XL, Free Size","96"),
]
for i, row_data in enumerate(titles):
    bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws7, r+1+i, list(row_data), bg)

# Bullet framework
r2 = r + len(titles) + 3
ws7.merge_cells(start_row=r2, start_column=1, end_row=r2, end_column=4)
c = ws7.cell(row=r2, column=1, value="BULLET POINT FRAMEWORK (5 bullets per listing)")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(); c.alignment = center(); ws7.row_dimensions[r2].height = 20

r2 += 1
write_header_row(ws7, r2, ["Bullet #","ALL CAPS Headline","Body Template","Conversion Purpose"], PINK_MID, WHITE, 10, 20)

bullets = [
    ("1","PERFECT FIT & SUPPORT","[Cup shape, wire type, coverage]. Designed for [activity/occasion]. Available in sizes [32A–42D].","Primary benefit — sizing confidence"),
    ("2","ULTRA-SOFT [COTTON/MODAL] FABRIC","Made from [X]% [material] for all-day breathability and moisture control. Seamless construction — no irritation. Skin-friendly.","Material justification"),
    ("3","[KEY DESIGN FEATURE]","[Closure type], [strap details], [padding info]. Invisible under clothing. No visible panty lines.","Feature detail — removes objections"),
    ("4","WEAR IT YOUR WAY","Ideal for [T-shirts / sarees / gym / yoga / daily wear]. Pack of 2/3 available. Multiway straps — halter/criss-cross/straight.","Versatility — increases basket size"),
    ("5","EASY CARE & SIZING","[Hand/machine wash]. Refer to size chart image — measure underbust and overbust in inches. Runs true to size. Made in India for Indian proportions.","Returns prevention — sizing guidance"),
]
for i, row_data in enumerate(bullets):
    bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws7, r2+1+i, list(row_data), bg)

# Backend keyword note
r3 = r2 + len(bullets) + 3
ws7.merge_cells(start_row=r3, start_column=1, end_row=r3, end_column=4)
c = ws7.cell(row=r3, column=1, value="BACKEND KEYWORD STRATEGY — 250 Byte Limit (Exceed = NONE indexed)")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(); c.alignment = center(); ws7.row_dimensions[r3].height = 20

r3 += 1
write_header_row(ws7, r3, ["Term Category","Example Terms","Why Include","Priority"], PINK_MID, WHITE, 10, 20)

backend = [
    ("Misspellings / Alternate spellings","brassiere brasier brazier lingeri andarwear","Indian misspellings — real search behaviour","🔴 Must-have"),
    ("Hindi / vernacular transliterations","nighty tummy tucker saree chaddi","High-intent Indian searches not in English tools","🔴 Must-have"),
    ("India-specific shapewear terms","saree shapewear petticoat shapewear tummy tucker belly fat","Zero competition from international brands on these","🔴 Must-have"),
    ("Fabric synonyms","lycra elastane spandex microfiber modal polyamide","Indexed for fabric-specific searches","🟠 High"),
    ("Feature synonyms","wirefree wire free no wire soft cup unpadded unlined","Captures alternate phrasing of same feature","🟠 High"),
    ("Size numbers","32 34 36 38 40 A B C D 32B 34C 36D","High purchase-intent size-specific searches","🟠 High"),
    ("Occasion terms","bridal honeymoon anniversary gym office everyday","Seasonal + occasion-driven discovery","🟡 Medium"),
    ("Color terms","skin colour nude colour black white beige","Colour-specific searches common in India","🟡 Medium"),
    ("Pack terms","combo value pack set of 2 set of 3 multipack","Multi-pack searchers convert at higher rate","🟠 High"),
    ("Trending 2024-25","korean night suit korean pyjama","Trending search — include while relevant","🟠 High"),
]

sample_string = "brassiere brasier brazier innerwear inner wear undergarment 32B 34B 34C 36B 36C wirefree wire free soft cup unpadded unlined modal microfiber lycra elastane everyday office combo pack value pack nighty skin colour tummy tucker saree andarwear"
for i, row_data in enumerate(backend):
    bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws7, r3+1+i, list(row_data), bg)

sample_row = r3 + len(backend) + 2
ws7.merge_cells(start_row=sample_row, start_column=1, end_row=sample_row, end_column=4)
c = ws7.cell(row=sample_row, column=1, value=f"SAMPLE BACKEND STRING (244 chars): {sample_string}")
c.fill = hdr_fill("E8F5E9")
c.font = Font(bold=False, size=9, italic=True, name="Calibri", color="1B5E20")
c.alignment = left()
ws7.row_dimensions[sample_row].height = 30

set_col_widths(ws7, [24,50,40,18])

# ════════════════════════════════════════════════════════════════════════════
# SHEET 8 — 90-DAY GROWTH PLAN
# ════════════════════════════════════════════════════════════════════════════
ws8 = wb.create_sheet("8. 90-Day Growth Plan")
add_title_block(ws8, "90-DAY MARKETPLACE GROWTH PLAN", "Quick Wins | Mid-Term Wins | Targets & KPIs")

r = 4
write_header_row(ws8, r, ["Phase","Week/Month","Platform","Action","Priority","Owner","Expected Impact","Status"], PINK_DARK, WHITE, 10, 22)

plan = [
    # Quick wins
    ("QUICK WIN\n(Days 1–30)","Week 1","Amazon","Enroll top 30 hero SKUs in FBA — ship inventory to Amazon FC","🔴 #1 Priority","Ops/Seller Central","Prime badge + 30–50% conversion lift + algorithm rank boost","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 1","Amazon","Rewrite all titles to 125-char formula: Brand+Material+Padding+Wire+Coverage+Type+Feature","🔴 Critical","Content","Indexed for 3–5× more keyword variants","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 1","Amazon","Complete backend keywords for all ASINs — include India-unique terms","🔴 Critical","Content","Broader keyword indexing","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 1","Amazon","Access Brand Analytics → export Search Query Performance → find keyword gaps","🔴 Critical","Marketing","Identify real search data (only authoritative source)","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 1","Myntra","Audit all listings for 3:4 portrait ratio compliance — re-upload non-compliant images","🔴 Critical","Creative","Avoid auto-rejection; improve CTR","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 1","Myntra","Apply for M-Express fulfillment — contact Myntra seller support","🔴 Critical","Ops","Direct ranking boost on Myntra","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 1","Myntra","Complete all attribute fields — fabric %, closure type, padding, wire, coverage, occasion","🔴 Critical","Content","Appear in filter searches","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 1","Myntra","Launch first PLA campaign — ₹10,000/campaign; target: padded bra, cotton bra, bra for women","🔴 Critical","Marketing","Immediate visibility while organic builds","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 2","Amazon","Commission 6-module A+ Content for top 10 ASINs (size guide + fabric + comparison + cross-sell)","🟠 High","Content","~8% conversion lift","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 2","Both","Produce Feature Infographic image for all hero bra SKUs","🟠 High","Creative","Reduces return rate; improves conversion","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 2","Both","Produce Size Guide image for all bra ASINs — show measurement in cm/inches","🔴 Critical","Creative","Reduces wrong-size purchases and negative reviews","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 2","Amazon","Pre-seed 10 FAQ answers per hero ASIN","🟠 High","Content","Reduces purchase hesitation","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 3","Amazon","Enroll 20 new/under-reviewed ASINs in Amazon Vine","🔴 Critical","Marketing","+15–30 reviews per enrolled ASIN","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 3","Amazon","Activate Request-a-Review button for all orders 7–14 days old","🟠 High","Marketing","Steady review accumulation","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 4","Both","Raise MRP to ₹799–₹1,999 range; show 50–65% visible discount","🟠 High","Pricing","Higher perceived value; larger discount signal","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 4","Amazon","Create 3 Virtual Bundle ASINs: 3-pack bra, starter kit, gift set","🟠 High","Catalog","+180–300% AOV vs. single item","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 4","Amazon","Enable ₹200–₹300 coupon on top 5 ASINs","🟠 High","Marketing","Coupons appear in search; +20–30% CTR","☐ TODO"),
    ("QUICK WIN\n(Days 1–30)","Week 4","Amazon","Launch Sponsored Products — ₹500/day; target top 50 keywords from Brand Analytics","🔴 Critical","Marketing","Sales velocity → organic rank uplift","☐ TODO"),
    # Mid-term
    ("MID-TERM\n(Days 31–90)","Month 2","Amazon","Restructure Brand Store: sub-pages for Everyday Bras, Sports Bras, Sets, Multi-Packs, New Arrivals","🟠 High","Marketing","Improved brand Store conversion","☐ TODO"),
    ("MID-TERM\n(Days 31–90)","Month 2","Amazon","Add Brand Story module across all ASINs — persistent lifestyle banner","🟠 High","Content","Brand authority building","☐ TODO"),
    ("MID-TERM\n(Days 31–90)","Month 2","Amazon","Complete A+ Content rollout — top 50 ASINs by Day 60","🔴 Critical","Content","Full catalog conversion optimization","☐ TODO"),
    ("MID-TERM\n(Days 31–90)","Month 2","Amazon","Produce 3 product videos: fit demo, fabric showcase, lifestyle brand film","🟠 High","Creative","3.6× conversion lift documented","☐ TODO"),
    ("MID-TERM\n(Days 31–90)","Month 2","Amazon","Monitor Vine reviews — respond to negatives within 48 hrs; fix product issues","🟠 High","CX","Review quality improvement","☐ TODO"),
    ("MID-TERM\n(Days 31–90)","Month 3","Both","Launch 3–5 shapewear SKUs: high waist shorts, saree shapewear, full body shaper","🔴 Critical","Catalog","Capture 30%+ CAGR category; 30K+ monthly searches","☐ TODO"),
    ("MID-TERM\n(Days 31–90)","Month 3","Both","Launch 3–5 nightwear SKUs: cotton night suit, satin nighty, Korean pyjama set","🔴 Critical","Catalog","Capture 35K+ monthly searches; zero current presence","☐ TODO"),
    ("MID-TERM\n(Days 31–90)","Month 3","Amazon","Scale ads — Sponsored Products 60% + Sponsored Brands 25% + Sponsored Display 15%","🔴 Critical","Marketing","Full-funnel strategy (Clovia model)","☐ TODO"),
    ("MID-TERM\n(Days 31–90)","Month 3","Myntra","Scale PLA to ₹30,000–₹50,000/month across 10+ campaigns","🔴 Critical","Marketing","Sustained visibility during organic buildup","☐ TODO"),
    ("MID-TERM\n(Days 31–90)","Month 3","Myntra","Launch Myntra Minis (short video clips) on top 10 listings","🟠 High","Creative","Improves engagement and dwell time","☐ TODO"),
]

phase_colors = {
    "QUICK WIN\n(Days 1–30)": "FCE4EC",
    "MID-TERM\n(Days 31–90)": "E3F2FD",
}
priority_bg = {
    "🔴 #1 Priority": "FFEBEE",
    "🔴 Critical": "FFEBEE",
    "🟠 High": "FFF3E0",
    "🟡 Medium": "FFFDE7",
}

for i, row_data in enumerate(plan):
    bg = phase_colors.get(row_data[0], WHITE)
    write_data_row(ws8, r+1+i, list(row_data), bg)
    # priority cell colour
    p_cell = ws8.cell(row=r+1+i, column=5)
    p_cell.fill = hdr_fill(priority_bg.get(row_data[4], WHITE))
    p_cell.font = body_font(bold=True, sz=9)
    p_cell.alignment = center()

# 30/90 day targets
tgt_row = r + len(plan) + 3
ws8.merge_cells(start_row=tgt_row, start_column=1, end_row=tgt_row, end_column=8)
c = ws8.cell(row=tgt_row, column=1, value="30-DAY & 90-DAY KPI TARGETS")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(sz=12); c.alignment = center(); ws8.row_dimensions[tgt_row].height = 22

tgt_row += 1
write_header_row(ws8, tgt_row, ["Metric","Current (est.)","30-Day Target","90-Day Target","Priority","Category","Measurement","Notes"], PINK_MID, WHITE, 10, 20)

targets = [
    ("FBA-enrolled SKUs","0","30+ hero SKUs","100+","🔴","Amazon","Seller Central FBA inventory","Single highest-ROI action"),
    ("ASINs with complete A+ Content","Unknown","10 hero ASINs","50+","🔴","Amazon","A+ Content Manager","6-module framework"),
    ("Amazon Vine enrollments","0","20 ASINs","40+","🔴","Amazon","Seller Central Vine","Launch within first week"),
    ("Amazon Sponsored Products","Inactive","₹500/day","₹2,000/day","🔴","Amazon","Amazon Ads dashboard","ACOS target <30%"),
    ("Myntra PLA campaigns","Inactive","3 active campaigns","10+ campaigns","🔴","Myntra","Myntra Ads","₹10K/campaign minimum"),
    ("Myntra M-Express status","No","Applied","Active","🔴","Myntra","Myntra seller support","Direct ranking boost"),
    ("Myntra attribute completeness","Unknown","100% top 100 SKUs","100% all active SKUs","🔴","Myntra","Myntra seller portal","Filters visibility"),
    ("New shapewear SKUs","0","0","3–5 launched","🟠","Catalog","Amazon/Myntra listings","FBA-enroll from day 1"),
    ("New nightwear SKUs","0","0","3–5 launched","🟠","Catalog","Amazon/Myntra listings","FBA-enroll from day 1"),
    ("Bundle ASINs active","0","3 (Amazon)","5+","🟠","Catalog","Amazon Virtual Bundles","3-pack, starter kit, gift set"),
    ("Hero ASINs with 50+ reviews","0","0","10 ASINs","🟠","Reviews","Amazon product pages","Via Vine + organic"),
    ("Myntra 3:4 ratio compliance","Unknown","100% compliant","100% compliant","🔴","Creative","Myntra QC dashboard","#1 rejection reason"),
]
for i, row_data in enumerate(targets):
    bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws8, tgt_row+1+i, list(row_data), bg)

set_col_widths(ws8, [22,18,18,18,12,12,22,36])

# ════════════════════════════════════════════════════════════════════════════
# SHEET 9 — 12-MONTH EXPANSION PLAN
# ════════════════════════════════════════════════════════════════════════════
ws9 = wb.create_sheet("9. 12-Month Expansion Plan")
add_title_block(ws9, "12-MONTH MARKETPLACE EXPANSION PLAN", "Category Domination | Bestseller Strategy | Revenue Targets")

r = 4
write_header_row(ws9, r, ["Quarter","Month","Platform","Initiative","Category","Target KPI","Revenue Impact","Notes"], PINK_DARK, WHITE, 10, 22)

roadmap = [
    ("Q1\n(M1–3)","Month 1","Amazon","FBA enrollment — 30 hero SKUs","Operations","Prime badge active","High","Most impactful single action"),
    ("Q1\n(M1–3)","Month 1","Both","Title + keyword rewrite — all active ASINs","SEO","3× keyword coverage","High","Use Brand Analytics data"),
    ("Q1\n(M1–3)","Month 1","Amazon","Amazon Vine enrollment — 20 ASINs","Reviews","15–30 reviews/ASIN","High","Do in Week 1"),
    ("Q1\n(M1–3)","Month 1","Myntra","M-Express application + PLA launch","Visibility","Search rank improvement","High","₹10K/campaign"),
    ("Q1\n(M1–3)","Month 2","Both","A+ Content — top 50 ASINs; size guide + fabric tech + comparison","Conversion","+8% conversion rate","High","6-module framework"),
    ("Q1\n(M1–3)","Month 2","Both","Feature infographic + size guide images for all hero SKUs","Creative","Return rate -15%","High","Most impactful creative action"),
    ("Q1\n(M1–3)","Month 2","Both","Bundle ASINs: 3-pack bra, starter kit, gift set","Catalog","+180–300% AOV","High","Clovia's proven model"),
    ("Q1\n(M1–3)","Month 3","Both","Launch shapewear (3–5 SKUs) + nightwear (3–5 SKUs)","Catalog","New category revenue","Very High","FBA enroll from day 1"),
    ("Q1\n(M1–3)","Month 3","Amazon","Full-funnel ads: Sponsored Products + Brands + Display","Marketing","NTB orders +50%","High","Clovia model: ACOS <30%"),
    ("Q2\n(M4–6)","Month 4","Amazon","Target Bestseller Badge — sports bra sub-category","SEO/Brand","Bestseller badge","Very High","Niche sub-category strategy"),
    ("Q2\n(M4–6)","Month 4","Amazon","Register Lightning Deals for Great Indian Festival (90 days ahead)","Promotions","GIF revenue spike","Very High","Book 90 days in advance"),
    ("Q2\n(M4–6)","Month 4","Amazon","Amazon Marketing Cloud — cross-target bra buyers with panty/set retargeting","Advertising","Basket size +37%","High","Clovia's proven tactic"),
    ("Q2\n(M4–6)","Month 5","Amazon","Subscribe & Save enrollment for multi-packs","Retention","Repeat purchase revenue","Medium","Subscription revenue stream"),
    ("Q2\n(M4–6)","Month 5","Myntra","Editor's Choice pursuit for 2 hero products (4.2+ rating required)","Brand","CTR boost","High","Engage Myntra editorial team"),
    ("Q2\n(M4–6)","Month 5","Myntra","Myntra Minis (video clips) on top 20 listings","Engagement","Dwell time increase","Medium","Improves conversion"),
    ("Q2\n(M4–6)","Month 5","Both","June EORS preparation: 70% min discount; inventory buffer; PLA 4×","Promotions","EORS revenue peak","Very High","Mandatory for Myntra visibility"),
    ("Q2\n(M4–6)","Month 6","Both","Expand shapewear to 10 SKUs; nightwear to 10 SKUs","Catalog","Category revenue growth","Very High","'Saree shapewear' keyword domination"),
    ("Q2\n(M4–6)","Month 6","Amazon","Target 500+ reviews on 5 hero ASINs","Reviews","Algorithm rank lock-in","High","Via Vine + organic + Request-a-Review"),
    ("Q3\n(M7–9)","Month 7","Both","Great Indian Festival prep: Lightning Deals; festival bundles; FBA stock pre-position","Promotions","GIF peak revenue","Very High","60–70% discount target; 3× ad budget"),
    ("Q3\n(M7–9)","Month 7","Both","Bridal/honeymoon lingerie sets for wedding season (Oct–Dec)","Catalog","Seasonal revenue","High","Keyword: honeymoon lingerie set, bridal set"),
    ("Q3\n(M7–9)","Month 8","Amazon","Great Indian Festival — live campaigns; ACOS monitoring daily","Advertising","Peak revenue month","Very High","Target ₹7L+ Amazon GIF revenue"),
    ("Q3\n(M7–9)","Month 8","Myntra","Big Fashion Festival — 65–75% off; editorial feature; PLA ₹1L+","Promotions","BFF revenue peak","Very High","Submit editorial 6 weeks ahead"),
    ("Q3\n(M7–9)","Month 9","Both","Post-festival analysis: review insights → product/listing improvements","Analytics","Conversion optimization","Medium","Feed into Q4 planning"),
    ("Q4\n(M10–12)","Month 10","Amazon","Bestseller Badge strategy — 2nd sub-category: seamless wireless bra","SEO/Brand","2nd bestseller badge","Very High","Lightning Deal during GIF for velocity spike"),
    ("Q4\n(M10–12)","Month 10","Both","December EORS preparation: 75–80% off; 2,000px images; PLA ₹1.5L","Promotions","Year's largest sale","Very High","150M+ visitors in Dec EORS"),
    ("Q4\n(M10–12)","Month 11","Myntra","December EORS — live; PLA at maximum; hero products at 75% off","Promotions","Q4 revenue peak","Very High","Largest revenue opportunity of year"),
    ("Q4\n(M10–12)","Month 12","Both","Year-end audit: category position, review counts, bestseller badges, revenue","Analytics","Full year review","High","Set targets for Year 2"),
    ("Q4\n(M10–12)","Month 12","Both","Year 2 catalog: expand to AJIO, Nykaa Fashion; launch men's innerwear pilot","Expansion","New channel revenue","Medium","Multi-channel diversification"),
]

q_colors = {
    "Q1\n(M1–3)": "FCE4EC",
    "Q2\n(M4–6)": "E3F2FD",
    "Q3\n(M7–9)": "E8F5E9",
    "Q4\n(M10–12)": "FFF8E1",
}
impact_colors = {
    "Very High": "1B5E20",
    "High": "388E3C",
    "Medium": "F57F17",
}

for i, row_data in enumerate(roadmap):
    bg = q_colors.get(row_data[0], WHITE)
    write_data_row(ws9, r+1+i, list(row_data), bg)
    imp_cell = ws9.cell(row=r+1+i, column=7)
    imp_cell.fill = hdr_fill(impact_colors.get(row_data[6], WHITE))
    imp_cell.font = Font(color=WHITE, bold=True, size=9, name="Calibri")
    imp_cell.alignment = center()

# 12-month targets
tgt_row = r + len(roadmap) + 3
ws9.merge_cells(start_row=tgt_row, start_column=1, end_row=tgt_row, end_column=8)
c = ws9.cell(row=tgt_row, column=1, value="12-MONTH KPI TARGETS")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(sz=12); c.alignment = center(); ws9.row_dimensions[tgt_row].height = 22

tgt_row += 1
write_header_row(ws9, tgt_row, ["Metric","Current","3-Month Target","6-Month Target","12-Month Target","Category","Priority","Notes"], PINK_MID, WHITE, 10, 20)

annual_targets = [
    ("Amazon FBA SKUs","0","30","100","200+","Operations","🔴","Most impactful single metric"),
    ("Amazon monthly revenue","Baseline","1.5×","2×","3×","Revenue","🔴","Driven by FBA + ads + reviews"),
    ("Myntra monthly revenue","Baseline","1.3×","1.7×","2×","Revenue","🔴","Driven by M-Express + PLAs"),
    ("Hero ASINs with 100+ reviews","0","0","10","30","Reviews","🔴","Via Vine + organic velocity"),
    ("Hero ASINs with 500+ reviews","0","0","2","10","Reviews","🟠","Sustained FBA + ad investment"),
    ("Total reviews (all ASINs)","<5,000","5,000+","10,000+","15,000+","Reviews","🟠","Long-term trust signal"),
    ("Shapewear SKUs active","0","0","5","15+","Catalog","🔴","New category — high opportunity"),
    ("Nightwear SKUs active","0","0","5","15+","Catalog","🔴","New category — 35K+ monthly searches"),
    ("Amazon Bestseller badges","0","0","1","2–3","Brand","🟠","Niche sub-category strategy"),
    ("Myntra Trending/Editor's Choice","0","0","2","5+","Brand","🟠","4.2+ rating required"),
    ("Active bundle ASINs","0","3","5","10+","Catalog","🟠","3-pack, starter kit, gift set"),
    ("Myntra M-Express status","No","Applied","Active","Active","Operations","🔴","Direct search rank boost"),
    ("Amazon ad ACOS","—","<35%","<30%","<25%","Marketing","🟠","Clovia achieved 24.96%"),
    ("Myntra monthly PLA spend","₹0","₹10K","₹40K","₹1–1.5L","Marketing","🔴","EORS months: 3–4× spike"),
]

for i, row_data in enumerate(annual_targets):
    bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws9, tgt_row+1+i, list(row_data), bg)

set_col_widths(ws9, [28,14,16,16,16,14,10,36])

# ════════════════════════════════════════════════════════════════════════════
# SHEET 10 — WHY COMPETITORS OUTRANK
# ════════════════════════════════════════════════════════════════════════════
ws10 = wb.create_sheet("10. Why Competitors Win")
add_title_block(ws10, "WHY CLOVIA, ZIVAME, ENAMOR, WACOAL, AMANTE & LOVABLE OUTRANK AMOUR SECRET", "8 Root Causes | Detailed Analysis | Remediation Actions")

r = 4
write_header_row(ws10, r, ["#","Root Cause","Severity","Detail","Competitor Advantage","Amour Secret Gap","Remediation","Timeline"], PINK_DARK, WHITE, 10, 22)

root_causes = [
    (1,"No FBA / No Prime Badge","🔴 CRITICAL",
     "Amazon's A10 algorithm boosts FBA listings. Non-FBA = no Prime badge = invisible to Prime customers (highest-spending segment). Also loses Buy Box by default.",
     "Enamor, Clovia, Nykd, Triumph ALL on FBA via Cocoblu Retail. Amazon curates 'Upto 50% Off – Triumph, Enamor, NYKD, Clovia' pages.",
     "Seller-fulfilled (M/S Magpie Impex). No Prime badge. 30–50% lower conversion rate vs. FBA competitors.",
     "Enroll top 30 hero SKUs in FBA immediately. Ship inventory to Amazon FC. Even partial FBA enrollment produces measurable rank improvement.",
     "Week 1 — Day 1"),

    (2,"Review Volume Chasm","🔴 CRITICAL",
     "Amazon's algorithm weights review count heavily. <30 reviews = rarely page 1. <100 = can't compete for top 5 in competitive keywords. 500+ = sustained top-page placement.",
     "Enamor SB06: 17,606 reviews (single product). Nykd Everyday Bra: 2,810. Products with 1,000+ reviews lock organic ranking via flywheel effect.",
     "17–162 reviews per SKU. No confirmed Amazon Vine enrollment. No review automation (Request-a-Review) confirmed. No 10,000+ review product exists.",
     "Week 1: Enroll 20 ASINs in Amazon Vine. Activate Request-a-Review automation for all orders 7–14 days post-delivery. Add packaging insert card.",
     "Week 1 (start) — 90 days (results)"),

    (3,"No Advertising Investment","🔴 CRITICAL",
     "Myntra: 'Brands that refuse to invest in PLAs are increasingly pushed to bottom.' Amazon: PPC sales velocity feeds organic rank. Both platforms are pay-to-play in competitive innerwear (50,000+ SKUs in bra category alone).",
     "Clovia: Amazon Ads drove NTB orders +80%, ad revenue +49%, total sales +31%. ACOS: 24.96%. Full funnel: Sponsored Products + Brands + Display + AMC.",
     "Minimal or no Sponsored Products (Amazon). No Myntra PLAs confirmed. Organic-only strategy fails in saturated category.",
     "Amazon: Launch Sponsored Products ₹500/day targeting top 50 Brand Analytics keywords. Myntra: ₹10,000/campaign × 3 campaigns immediately.",
     "Week 1 — ongoing"),

    (4,"Missing Shapewear & Nightwear","🟠 HIGH",
     "Shapewear: 30%+ CAGR, 'saree shapewear' is India-unique with zero international brand competition. Nightwear: 35,000+ monthly searches 'nightwear for women'; 'night suit for women' is high-intent India-unique term.",
     "Clovia active in both. Dermawear (shapewear). Fasense (nightwear). DressBerry (Myntra private label) dominates nightwear. None of these categories have Amour Secret.",
     "Not listed on Amazon or Myntra in shapewear or nightwear. Only D2C site carries these. Zero marketplace revenue from 2 high-growth categories.",
     "Month 3: Launch 3–5 shapewear SKUs (high waist shorts, saree shapewear, body shaper). Launch 3–5 nightwear SKUs (cotton night suit, korean pyjama, satin nighty). FBA-enroll from day 1.",
     "Month 3"),

    (5,"Title & Keyword Optimization Deficit","🟠 HIGH",
     "Amazon apparel titles are capped at 125 characters. Formula: Brand+Material+Padding+Wire+Coverage+Type+Feature. India-unique search terms (nighty, tummy tucker, saree shapewear, korean night suit) must appear in titles and backend.",
     "Enamor title example: 'SB06 Low Impact Cotton Sports Bra – Non-Padded, Wirefree & High Coverage' — indexed for 8+ keyword variants. Boldfit titles are full 125 chars with all features named.",
     "Titles likely too short or missing key qualifiers. Backend keywords not optimized with Indian misspellings, vernacular terms (brassiere, brasier, andarwear, nighty).",
     "Week 1: Rewrite all titles to full formula. Week 1: Complete backend with India-specific terms. Access Brand Analytics to find actual search query gaps.",
     "Week 1"),

    (6,"Content Quality Gap — A+ Content, Images, Videos","🟠 HIGH",
     "A+ Content: +8% conversion (basic), +20% (Premium). Size guide module reduces returns 15%+. Feature infographic reduces pre-purchase questions 50%+. Videos: 3.6× conversion lift documented.",
     "Clovia, Enamor, Nykd, Wacoal, Soie all have confirmed multi-page A+ Content. Clovia and Zivame both use product videos extensively. Size guide images are standard for all top brands.",
     "No confirmed feature infographic images. No confirmed size guide image. No product videos. A+ Content quality unverified.",
     "Week 2: Produce feature infographic + size guide images for all hero SKUs. Commission 6-module A+ Content for top 10 ASINs. Produce 3 videos (fit demo, fabric, lifestyle).",
     "Week 2 (images) — Month 2 (videos)"),

    (7,"Myntra DressBerry Private Label Advantage","🟡 STRUCTURAL",
     "DressBerry is Myntra's own private label. It receives structurally preferential search placement in bra, nightwear, and shapewear searches — appearing at top without commensurate review/rating advantage. All external brands face this.",
     "DressBerry appears first/top in nightwear and shapewear searches on Myntra by default. This is inherent to Myntra's business model — same as Amazon Basics on Amazon.",
     "All external brands face this disadvantage. Cannot be resolved organically. Must be mitigated with paid advertising (PLAs).",
     "Only mitigation: Myntra PLAs (sponsored placements appear above organic DressBerry results). Budget: ₹10,000/campaign minimum. Target: 3+ active campaigns.",
     "Week 1 — ongoing"),

    (8,"Brand Authority & Time-in-Market","🟡 MANAGEABLE",
     "Enamor (est. 2001, online ~2013): 17,606 reviews = 10+ years of organic accumulation. Cannot replicate instantly. However, Lovable (est. 1987, only 219 Amazon reviews) proves age alone doesn't determine success — digital strategy does.",
     "Enamor: 100,000+ Amazon customer ratings, 50K+ customers. Clovia: 10M+ customers. But Clovia was founded 2012 — digital-first investment, not age, explains their success.",
     "Amour Secret is newer to marketplace. However, Lovable is 40 years old and weaker than Amour Secret on Myntra. Age is not destiny — digital execution is.",
     "Follow Clovia's playbook (not Enamor's). Clovia was newer than most competitors but won via: digital-first strategy, aggressive ad investment, Amazon Vine, Brand Store optimization, bundle pricing.",
     "12 months (sustained)"),
]

sev_colors = {
    "🔴 CRITICAL": "FFCDD2",
    "🟠 HIGH": "FFE0B2",
    "🟡 STRUCTURAL": "FFF9C4",
    "🟡 MANAGEABLE": "FFF9C4",
}
for i, row_data in enumerate(root_causes):
    bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws10, r+1+i, list(row_data), bg)
    sev_cell = ws10.cell(row=r+1+i, column=3)
    sev_cell.fill = hdr_fill(sev_colors.get(row_data[2], WHITE))
    sev_cell.font = body_font(bold=True, sz=9)
    sev_cell.alignment = center()

set_col_widths(ws10, [5,22,14,40,36,32,36,18])

# ════════════════════════════════════════════════════════════════════════════
# SHEET 11 — REVIEW & SOCIAL PROOF
# ════════════════════════════════════════════════════════════════════════════
ws11 = wb.create_sheet("11. Reviews & Social Proof")
add_title_block(ws11, "REVIEW & SOCIAL PROOF ANALYSIS", "Why Competitors Convert Better | Review Strategy")

r = 4
write_header_row(ws11, r, ["Brand","Top Product Review Count","Brand Avg Rating","Total Reviews (est.)","Review Strategy","Conversion Driver","Why Customers Repeat-Buy"], PINK_DARK, WHITE, 10, 22)

reviews = [
    ("Enamor","17,606 (SB06 Sports Bra)","4.2★","100,000+","FBA + organic 10-yr accumulation + Vine","Dominant review volume creates overwhelming trust","Consistent fit/quality; size availability (30–42DD)"),
    ("Nykd by Nykaa","2,810 (Everyday Bra)","4.1★","20,000+","Nykaa's 50M+ customer base cross-promotes Amazon reviews","Nykaa ecosystem loyalty transfers to Amazon","Nykaa loyalty program; accessible price ₹397+"),
    ("Clovia","~962 (growing fast via ads)","4.2★","Growing rapidly","Amazon Vine + Request-a-Review automation + 10M+ customer base","Ad-driven velocity generates reviews; AI fit test reduces wrong purchases","CloviaCurve fit tech; 75+ sizes; loyalty program"),
    ("Zivame","~273 (Amazon); higher on own site","4.0★","7M+ on own platform","Education-first content reduces poor reviews; 10–15 videos/month","Fit Code AI (5M+ users) reduces returns = better reviews","Zivame app (10M+ downloads); fit consultation"),
    ("Wacoal India","Not disclosed","~4.2★","Niche volume","Premium retail presence builds trust; 17 exclusive stores","Premium brand heritage; offline trust transfers online","Quality consistency; Wacoal Basics entry-level pricing"),
    ("Amante","Not disclosed","Positive","Unknown","60%+30% checkout discount drives purchase velocity","Aggressive discount creates price-value perception","Price-value ratio at checkout; quality premium feel"),
    ("Soie","~231 (T-Shirt Bra)","4.3★","~2,000–5,000","Niche premium — slow but quality accumulation","High rating compensates for low volume in niche segment","Premium quality for dedicated fan segment"),
    ("Lovable","~219 (Cotton Bra)","4.0★","~5,000","Weak digital strategy despite 40-yr brand age","Brand recognition carries legacy customers only","Physical retail network; legacy brand recall"),
    ("AMOUR SECRET","17–162 per SKU","4.1–4.4★","<5,000 est.","No confirmed Vine, no confirmed automation","Good ratings hurt by low review count = low trust signal","Product quality (4.1–4.4★) is competitive — volume is the only gap"),
]

for i, row_data in enumerate(reviews):
    is_as = row_data[0] == "AMOUR SECRET"
    bg = PINK_LIGHT if is_as else (GREY if i % 2 == 0 else WHITE)
    write_data_row(ws11, r+1+i, list(row_data), bg, bold=is_as)

# Why customers buy competitors
r2 = r + len(reviews) + 3
ws11.merge_cells(start_row=r2, start_column=1, end_row=r2, end_column=7)
c = ws11.cell(row=r2, column=1, value="WHY CUSTOMERS BUY & REPEAT-PURCHASE COMPETITORS (NOT AMOUR SECRET)")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(sz=12); c.alignment = center(); ws11.row_dimensions[r2].height = 22

r2 += 1
write_header_row(ws11, r2, ["Reason","Detail","Amour Secret Impact","Fix"], PINK_MID, WHITE, 10, 20)

why_buy = [
    ("1. Trust from review volume","17,606 vs. 162 — identical ratings, but Enamor wins trust by volume. Indian e-commerce buyers are review-sensitive.","Lower conversion on identical-quality products","Amazon Vine enrollment + Request-a-Review automation"),
    ("2. Prime delivery expectation","Prime customers filter by Prime badge. Non-FBA = invisible to India's 100M+ Prime subscribers.","Invisible to largest-spending customer segment","FBA enrollment — Week 1"),
    ("3. Fit confidence from AI tools","Clovia's CloviaCurve + Zivame's Fit Code (5M+ users) reduce wrong-size fear. Fit education = lower hesitation.","Higher pre-purchase anxiety = lower conversion","Size guide image + FAQ seeding + A+ Content size module"),
    ("4. Faster delivery","FBA competitors deliver in 1–2 days. Seller-fulfilled takes 5–7 days. Speed wins in impulse category.","Lower conversion and higher cart abandonment","FBA enrollment resolves this immediately"),
    ("5. Post-purchase ecosystem","Clovia loyalty program; Zivame app (10M+ downloads); Nykaa's 50M+ ecosystem keep customers inside brand.","No post-purchase retention mechanism","Build email list via packaging inserts; D2C website retargeting"),
    ("6. Visual content superiority","Clovia/Zivame use 9 images + video + infographic. Amour Secret likely missing infographic, size guide, video.","Lower CTR and conversion despite good products","Week 2: Produce infographic + size guide images + 3 videos"),
    ("7. Discount visibility","Competitors show 50–70% off (via high MRP + aggressive selling price). Amour Secret's MRP architecture may show smaller % off.","Lower perceived value; lower search filter visibility","Raise MRP to ₹799–₹1,999; restructure discount architecture"),
]

for i, row_data in enumerate(why_buy):
    bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws11, r2+1+i, list(row_data), bg)

set_col_widths(ws11, [20,28,24,24,18,24,36])

# ════════════════════════════════════════════════════════════════════════════
# SHEET 12 — MARKET CONTEXT
# ════════════════════════════════════════════════════════════════════════════
ws12 = wb.create_sheet("12. Market Context")
add_title_block(ws12, "INDIA INNERWEAR MARKET CONTEXT", "Market Size | Growth Projections | Consumer Insights | Sources")

r = 4
ws12.merge_cells(start_row=r, start_column=1, end_row=r, end_column=5)
c = ws12.cell(row=r, column=1, value="MARKET SIZE & GROWTH PROJECTIONS")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(); c.alignment = center(); ws12.row_dimensions[r].height = 20

r += 1
write_header_row(ws12, r, ["Segment","2024 Value","2033 Projection","CAGR","Source"], PINK_MID, WHITE, 10, 20)

market = [
    ("Total India Innerwear Market (men + women)","USD 10.24 billion","USD 19.25 billion","6.7%","IMARC Group 2024"),
    ("Women's Lingerie Sub-segment","USD 5.4 billion","USD 12.0 billion","8.4%","IMARC Group 2024"),
    ("Online Lingerie Channel","Growing segment","USD 717M growth by 2030","11.7%","Technavio 2025"),
    ("Premium Lingerie Segment","USD 4.3 billion","Growing rapidly","10%+ est.","DFU Publications 2024"),
    ("Indian Rupee Innerwear Market","Rs 61,091 crore (2023)","Rs 91,306 crore (2025)","22%","KenResearch"),
    ("Women who purchased innerwear online (2024)","20 million+","—","—","KenResearch"),
    ("Tier 2/3 city online innerwear share","25–28% of online sales","Growing","18% YoY","KenResearch"),
    ("Myntra market share — Indian fashion e-comm","35–45%","—","—","Coherent MI / multiple"),
]

for i, row_data in enumerate(market):
    bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws12, r+1+i, list(row_data), bg)

# Consumer insights
r2 = r + len(market) + 3
ws12.merge_cells(start_row=r2, start_column=1, end_row=r2, end_column=5)
c = ws12.cell(row=r2, column=1, value="KEY CONSUMER INSIGHTS")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(); c.alignment = center(); ws12.row_dimensions[r2].height = 20

r2 += 1
write_header_row(ws12, r2, ["Insight","Data","Implication for Amour Secret","Source","Priority"], PINK_MID, WHITE, 10, 20)

insights = [
    ("80% of women wear wrong bra size","80% self-reported wrong size","Size guide image + FAQ + A+ size module = conversion + retention tool","Clovia/Zivame site data; industry standard","🔴 Critical"),
    ("Comfort is #1 purchase driver","94% report dissatisfaction with bra fit","Lead with comfort messaging in all titles + bullets","Industry surveys 2024","🔴 Critical"),
    ("Cotton is dominant fabric preference","Cotton demand +10M units in 2024","Ensure cotton SKUs are front-and-center in catalog and SEO","KenResearch 2024","🔴 Critical"),
    ("Privacy drives online discovery","Indian women prefer to buy intimate wear online","Online channels are the primary growth vector — prioritize marketplace investment","Industry analysis","🟠 High"),
    ("Tier 2/3 price sensitivity","₹300–₹500 sweet spot for Tier 2/3","Multi-pack strategy at ₹399–₹499 targets this segment perfectly","KenResearch","🟠 High"),
    ("Self-expression growing","15M+ women prefer fashion+comfort balance","Expand lingerie set / fashion bra catalog; increase model diversity in images","Industry analysis","🟠 High"),
    ("Seamless & functional demand rising","Trending: seamless, no-pad, moisture-wicking","Ensure seamless/wireless SKUs are prominently titled and SEO-optimized","Industry trends 2024","🟡 Medium"),
    ("Korean aesthetic trending","'Korean night suit' emerging as a high-traffic search term 2024-25","Launch Korean pyjama/night suit SKU immediately — first-mover opportunity","Google Trends India","🟠 High"),
]

for i, row_data in enumerate(insights):
    bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws12, r2+1+i, list(row_data), bg)
    p_cell = ws12.cell(row=r2+1+i, column=5)
    p_cell.fill = hdr_fill(priority_bg.get(row_data[4], WHITE))
    p_cell.font = body_font(bold=True, sz=9)
    p_cell.alignment = center()

# Sources
r3 = r2 + len(insights) + 3
ws12.merge_cells(start_row=r3, start_column=1, end_row=r3, end_column=5)
c = ws12.cell(row=r3, column=1, value="VERIFIED SOURCES")
c.fill = hdr_fill(PINK_DARK); c.font = hdr_font(); c.alignment = center(); ws12.row_dimensions[r3].height = 20

r3 += 1
write_header_row(ws12, r3, ["#","Source","URL / Reference","Type","Date"], PINK_MID, WHITE, 10, 20)

sources = [
    (1,"Amazon Ads Case Study — Clovia (Adbrew)","advertising.amazon.com/library/case-studies/adbrew-clovia","Primary — Official Amazon","2023"),
    (2,"Adbrew Case Study — Clovia AMC","adbrew.io/case-studies/clovia","Primary — Case Study","2023"),
    (3,"IMARC Group — India Lingerie Market","imarcgroup.com/india-lingerie-market","Market Research","2024"),
    (4,"IMARC Group — India Innerwear Market","imarcgroup.com/india-innerwear-market","Market Research","2024"),
    (5,"Technavio — India Online Lingerie Market","technavio.com/report/online-lingerie-market-industry-in-india-analysis","Market Research","2025"),
    (6,"DFU Publications — Clovia FY23 Revenue","dfupublications.com","News/Financial","2023"),
    (7,"Inc42 — Zivame Lingerie Market Analysis","inc42.com/features/can-zivame-sway-indias-7-bn-lingerie-market","News/Analysis","2024"),
    (8,"KenResearch — India Women Innerwear","kenresearch.com/industry-reports/india-women-innerwear-market","Market Research","2024"),
    (9,"GlobalWebsters — Myntra Listing Optimization","globalwebsters.com/blog/master-myntra-product-listing-optimization","Seller Guide","2025"),
    (10,"DreamGrow Digital — Myntra Strategy 2026","dreamgrowdigital.in/blog/myntra-sales-strategy-2026-growth-guide","Seller Guide","2026"),
    (11,"HRL Infotechs — Amazon Vine India 2026","hrlinfotechs.com/blog/amazon-vine-india","Platform Guide","2026"),
    (12,"Blue Wheel Media — Amazon A+ Content 2025","bluewheelmedia.com/blog/amazon-a-plus-content-in-2025","Platform Guide","2025"),
    (13,"Amazon India Clothing Style Guide","m.media-amazon.com/images/G/65/SG3P/SU/Listing/Clothing_Style_Guide_Final.pdf","Official Amazon","2024"),
    (14,"Amazon.in Bra Category Bestsellers","amazon.in/gp/bestsellers/apparel/1968467031","Marketplace Data","June 2026"),
    (15,"Myntra Amour Secret Brand Page","myntra.com/amour-secret","Marketplace Data","June 2026"),
    (16,"Myntra Padded Bra Search","myntra.com/padded-bra","Marketplace Data","June 2026"),
    (17,"Amour Secret Brand Store — Amazon.in","amazon.in/stores/AmourSecret/","Marketplace Data","June 2026"),
    (18,"Unicommerce — Myntra EORS Seller Guide","unicommerce.com/blog/myntra-end-of-reason-sale-seller-guide/","Seller Guide","2025"),
    (19,"Storyboard18 — Myntra Private Label","storyboard18.com/brand-marketing/nykaa-myntra-amazon-push-private-labels","News/Analysis","2024"),
    (20,"Amoursecrt.com — Official D2C Website","amoursecrt.com","Primary Brand","2026"),
    (21,"DFU Publications — India Premium Lingerie $4.3Bn","dfupublications.com/news/apparel/indias-premium-lingerie-market","News/Analysis","2024"),
    (22,"Marketing Monk — Zivame Marketing Strategy","marketingmonk.so/p/zivame-s-marketing-strategies","Analysis","2024"),
    (23,"Indian Retailer — Clovia FY24 Growth","indianretailer.com/news/retail-india-news-clovia-charts-aggressive-growth","News","2024"),
    (24,"Ecom-Hub — Myntra Catalog Requirements 2026","ecom-hub.in/learn/myntra-catalog-requirements-2026","Technical Guide","2026"),
    (25,"Amazon.in — Cocoblu Retail (FBA seller page)","amazon.in/Cocoblu-Retail-Fashion/s?rh=n:100141828031,p_6:A1WYWER0W24N8S","Marketplace Data","June 2026"),
]

for i, row_data in enumerate(sources):
    bg = GREY if i % 2 == 0 else WHITE
    write_data_row(ws12, r3+1+i, list(row_data), bg)

set_col_widths(ws12, [5,36,55,18,10])

# ════════════════════════════════════════════════════════════════════════════
# FREEZE PANES & FINAL SETUP
# ════════════════════════════════════════════════════════════════════════════
for ws in wb.worksheets:
    ws.freeze_panes = "A4"
    ws.sheet_view.showGridLines = True

# Remove default sheet name if still exists and is empty (openpyxl won't have it after reassigning active)
# Save
output_path = "/home/user/teambharat/amour-secret-marketplace-intelligence-report.xlsx"
wb.save(output_path)
print(f"Saved: {output_path}")
