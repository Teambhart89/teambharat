import openpyxl
from openpyxl.styles import Font, PatternFill, Alignment, Border, Side
from openpyxl.utils import get_column_letter

wb = openpyxl.Workbook()

# ── Helpers ──────────────────────────────────────────────────────────────────
HEADER_FILL  = PatternFill("solid", fgColor="1F3864")
ACCENT_FILL  = PatternFill("solid", fgColor="2E75B6")
ALT_FILL     = PatternFill("solid", fgColor="D6E4F0")
WHITE_FILL   = PatternFill("solid", fgColor="FFFFFF")
HEADER_FONT  = Font(bold=True, color="FFFFFF", size=10)
TITLE_FONT   = Font(bold=True, color="FFFFFF", size=12)
BODY_FONT    = Font(size=9)
BOLD_FONT    = Font(bold=True, size=9)
thin = Side(style="thin", color="CCCCCC")
BORDER = Border(left=thin, right=thin, top=thin, bottom=thin)

def add_sheet(name):
    ws = wb.create_sheet(title=name)
    return ws

def write_headers(ws, headers, row=1, fill=HEADER_FILL):
    for col, h in enumerate(headers, 1):
        c = ws.cell(row=row, column=col, value=h)
        c.font = HEADER_FONT
        c.fill = fill
        c.alignment = Alignment(horizontal="center", vertical="center", wrap_text=True)
        c.border = BORDER

def write_row(ws, data, row, fill=None):
    for col, val in enumerate(data, 1):
        c = ws.cell(row=row, column=col, value=val)
        c.font = BODY_FONT
        c.border = BORDER
        c.alignment = Alignment(wrap_text=True, vertical="top")
        if fill:
            c.fill = fill

def set_col_widths(ws, widths):
    for i, w in enumerate(widths, 1):
        ws.column_dimensions[get_column_letter(i)].width = w

def title_row(ws, text, cols):
    ws.merge_cells(start_row=1, start_column=1, end_row=1, end_column=cols)
    c = ws.cell(row=1, column=1, value=text)
    c.font = TITLE_FONT
    c.fill = ACCENT_FILL
    c.alignment = Alignment(horizontal="center", vertical="center")
    ws.row_dimensions[1].height = 22

# ── Remove default sheet ──────────────────────────────────────────────────────
del wb["Sheet"]

# ══════════════════════════════════════════════════════════════════════════════
# SHEET 1 — URL INVENTORY
# ══════════════════════════════════════════════════════════════════════════════
ws1 = add_sheet("1. URL Inventory")
title_row(ws1, "AMOUR SECRET — URL Inventory", 9)
hdrs = ["URL","Page Type","Page Title","H1","Meta Title","Meta Description","Canonical","Word Count (est.)","Notes"]
write_headers(ws1, hdrs, row=2)

url_data = [
    ["https://amoursecrt.com/","Homepage","Amour Secret | Premium Women's Innerwear India","Premium Bras, Panties & Activewear for Women","Amour Secret | Premium Women's Innerwear & Lingerie India","Shop seamless bras, sports bras, panties & activewear. Free shipping on orders above ₹499.","https://amoursecrt.com/","800","Homepage"],
    ["https://amoursecrt.com/collections/all","All Products","All Products – Amour Secret","All Products","All Women's Innerwear Products – Amour Secret","Browse our complete collection of bras, panties, bralettes and activewear for women.","https://amoursecrt.com/collections/all","300","Collection listing"],
    ["https://amoursecrt.com/collections/seamless-bras","Seamless Bras","Seamless Bras for Women – Amour Secret","Seamless Bras","Buy Seamless Bras Online India – Amour Secret","Shop seamless bras for women. No-show, wire-free comfort. Free shipping above ₹499.","https://amoursecrt.com/collections/seamless-bras","400","Category"],
    ["https://amoursecrt.com/collections/sports-bras","Sports Bras","Sports Bras for Women – Amour Secret","Sports Bras","Buy Sports Bras Online India – High Impact & Low Impact | Amour Secret","High-impact & low-impact sports bras for gym, yoga & running. Shop now.","https://amoursecrt.com/collections/sports-bras","400","Category"],
    ["https://amoursecrt.com/collections/t-shirt-bras","T-Shirt Bras","T-Shirt Bras for Women – Amour Secret","T-Shirt Bras","Buy T-Shirt Bras Online India | Seamless & Padded | Amour Secret","Smooth, padded T-shirt bras for everyday wear. No show lines under clothing.","https://amoursecrt.com/collections/t-shirt-bras","400","Category"],
    ["https://amoursecrt.com/collections/push-up-bras","Push Up Bras","Push Up Bras – Amour Secret","Push Up Bras","Buy Push Up Bras Online India – Padded & Underwired | Amour Secret","Get lift and definition with our push-up bra collection. Multiple cup sizes available.","https://amoursecrt.com/collections/push-up-bras","400","Category"],
    ["https://amoursecrt.com/collections/padded-bras","Padded Bras","Padded Bras for Women – Amour Secret","Padded Bras","Buy Padded Bras Online India | Amour Secret","Shop padded bras for a natural, defined silhouette. Soft foam cups, multiple styles.","https://amoursecrt.com/collections/padded-bras","400","Category"],
    ["https://amoursecrt.com/collections/non-padded-bras","Non Padded Bras","Non Padded Bras – Amour Secret","Non Padded Bras","Buy Non Padded Bras Online India | Amour Secret","Lightweight, unpadded bras for a natural fit and maximum breathability.","https://amoursecrt.com/collections/non-padded-bras","400","Category"],
    ["https://amoursecrt.com/collections/full-coverage-bras","Full Coverage Bras","Full Coverage Bras – Amour Secret","Full Coverage Bras","Buy Full Coverage Bras Online India | Amour Secret","Full-cup bras for maximum coverage and support. Perfect for everyday wear.","https://amoursecrt.com/collections/full-coverage-bras","400","Category"],
    ["https://amoursecrt.com/collections/beginner-bras","Beginner Bras","Beginner Bras for Teens – Amour Secret","Beginner Bras","Buy Beginner Bras for Girls Online India | Amour Secret","Soft, comfortable first bras for teenagers. Wire-free, lightly padded.","https://amoursecrt.com/collections/beginner-bras","400","Category"],
    ["https://amoursecrt.com/collections/lace-bras","Lace Bras","Lace Bras for Women – Amour Secret","Lace Bras","Buy Lace Bras Online India | Amour Secret","Elegant lace bras combining style and comfort. Available in multiple colours.","https://amoursecrt.com/collections/lace-bras","400","Category"],
    ["https://amoursecrt.com/collections/plunge-bras","Plunge Bras","Plunge Bras – Amour Secret","Plunge Bras","Buy Plunge Bras Online India | Deep V Bras | Amour Secret","Deep V plunge bras for low-cut outfits. Underwired with padding options.","https://amoursecrt.com/collections/plunge-bras","400","Category"],
    ["https://amoursecrt.com/collections/wirefree-bras","Wirefree Bras","Wirefree Bras – Amour Secret","Wirefree Bras","Buy Wirefree Bras Online India | Comfortable & Supportive | Amour Secret","Wire-free bras for all-day comfort without compromising support.","https://amoursecrt.com/collections/wirefree-bras","400","Category"],
    ["https://amoursecrt.com/collections/wired-bras","Wired Bras","Wired Bras – Amour Secret","Wired Bras","Buy Wired Bras Online India | Amour Secret","Wired bras for structured lift and definition. Multiple styles and cup sizes.","https://amoursecrt.com/collections/wired-bras","400","Category"],
    ["https://amoursecrt.com/collections/strapless-bras","Strapless Bras","Strapless Bras – Amour Secret","Strapless Bras","Buy Strapless Bras Online India | Amour Secret","Secure, stay-put strapless bras for off-shoulder and backless outfits.","https://amoursecrt.com/collections/strapless-bras","400","Category"],
    ["https://amoursecrt.com/collections/bralettes","Bralettes","Bralettes for Women – Amour Secret","Bralettes","Buy Bralettes Online India | Lace & Seamless | Amour Secret","Soft, stylish bralettes for lounging and layering. Wire-free and comfortable.","https://amoursecrt.com/collections/bralettes","400","Category"],
    ["https://amoursecrt.com/collections/bandeau-bras","Bandeau Bras","Bandeau Bras – Amour Secret","Bandeau Bras","Buy Bandeau Bras Online India | Amour Secret","Tube-style bandeau bras for layering under tanks and crop tops.","https://amoursecrt.com/collections/bandeau-bras","400","Category"],
    ["https://amoursecrt.com/collections/camisoles","Camisoles","Camisoles for Women – Amour Secret","Camisoles","Buy Camisoles Online India | Lace & Cotton | Amour Secret","Stylish inner camisoles and slips for layering and everyday wear.","https://amoursecrt.com/collections/camisoles","400","Category"],
    ["https://amoursecrt.com/collections/panties","Panties","Panties for Women – Amour Secret","Panties","Buy Panties Online India | Cotton & Lace | Amour Secret","Shop women's panties in cotton, lace, and seamless styles. All sizes available.","https://amoursecrt.com/collections/panties","400","Category"],
    ["https://amoursecrt.com/collections/hipster-panties","Hipster Panties","Hipster Panties – Amour Secret","Hipster Panties","Buy Hipster Panties Online India | Amour Secret","Mid-rise hipster panties for a comfortable fit with full coverage.","https://amoursecrt.com/collections/hipster-panties","400","Category"],
    ["https://amoursecrt.com/collections/high-waist-panties","High Waist Panties","High Waist Panties – Amour Secret","High Waist Panties","Buy High Waist Panties Online India | Amour Secret","Tummy-control high-waist panties for a smooth, sculpted silhouette.","https://amoursecrt.com/collections/high-waist-panties","400","Category"],
    ["https://amoursecrt.com/collections/bikini-panties","Bikini Panties","Bikini Panties – Amour Secret","Bikini Panties","Buy Bikini Panties Online India | Amour Secret","Low-rise bikini cut panties for minimal coverage and maximum comfort.","https://amoursecrt.com/collections/bikini-panties","400","Category"],
    ["https://amoursecrt.com/collections/boyshort-panties","Boyshort Panties","Boyshort Panties – Amour Secret","Boyshort Panties","Buy Boyshort Panties Online India | Full Coverage | Amour Secret","Full-coverage boyshort panties for anti-chafe comfort all day long.","https://amoursecrt.com/collections/boyshort-panties","400","Category"],
    ["https://amoursecrt.com/collections/activewear","Activewear","Women's Activewear – Amour Secret","Women's Activewear","Buy Women's Activewear Online India | Gym & Yoga | Amour Secret","Performance activewear for gym, yoga, running and everyday fitness.","https://amoursecrt.com/collections/activewear","400","Category"],
    ["https://amoursecrt.com/collections/bra-panty-sets","Bra & Panty Sets","Bra & Panty Sets – Amour Secret","Bra & Panty Sets","Buy Bra Panty Sets Online India | Matching Lingerie Sets | Amour Secret","Matching bra and panty sets in lace, cotton and seamless styles.","https://amoursecrt.com/collections/bra-panty-sets","400","Category"],
    ["https://amoursecrt.com/blogs/news","Blog","Innerwear Tips, Bra Size Guides & Style Advice – Amour Secret","Amour Secret Blog","Innerwear Tips, Bra Guides & Lingerie Advice | Amour Secret Blog","Expert tips on bra sizing, lingerie care, styling and women's innerwear.","https://amoursecrt.com/blogs/news","200","Blog index"],
    ["https://amoursecrt.com/pages/about","About","About Us – Amour Secret","About Amour Secret","About Amour Secret | Our Story & Mission","Learn about Amour Secret's mission to provide premium, affordable innerwear for every Indian woman.","https://amoursecrt.com/pages/about","400","Static page"],
    ["https://amoursecrt.com/pages/contact","Contact","Contact Us – Amour Secret","Contact Us","Contact Amour Secret | Customer Support","Reach out to Amour Secret for order support, returns and queries.","https://amoursecrt.com/pages/contact","200","Static page"],
]

for i, row in enumerate(url_data, 3):
    fill = ALT_FILL if i % 2 == 0 else WHITE_FILL
    write_row(ws1, row, i, fill)

set_col_widths(ws1, [45,15,38,28,42,60,45,14,14])
ws1.row_dimensions[2].height = 30
ws1.freeze_panes = "A3"
ws1.auto_filter.ref = f"A2:I{len(url_data)+2}"

print("Sheet 1 done")

# ══════════════════════════════════════════════════════════════════════════════
# SHEET 2 — KEYWORD RESEARCH
# ══════════════════════════════════════════════════════════════════════════════
ws2 = add_sheet("2. Keyword Research")
title_row(ws2, "AMOUR SECRET — Master Keyword Research Database", 8)
hdrs2 = ["Keyword","Category","Intent","Est. Monthly Volume (India)","KD (Est.)","Opportunity","Target URL","Notes / Content Angle"]
write_headers(ws2, hdrs2, row=2)

keywords = [
    # PRIMARY / HEAD
    ["seamless bra","Seamless Bras","Transactional","33,000","Medium","HIGH","/collections/seamless-bras","Collection page"],
    ["seamless bra for women","Seamless Bras","Transactional","18,000","Medium","HIGH","/collections/seamless-bras",""],
    ["buy seamless bra online","Seamless Bras","Transactional","9,000","Low","HIGH","/collections/seamless-bras",""],
    ["best seamless bra India","Seamless Bras","Commercial","6,600","Low","HIGH","/blogs/best-seamless-bra-india","Blog"],
    ["seamless bra without underwire","Seamless Bras","Transactional","3,600","Low","HIGH","/collections/seamless-bras",""],
    ["seamless padded bra","Seamless Bras","Transactional","4,400","Low","HIGH","/collections/seamless-bras",""],
    ["seamless t-shirt bra","Seamless Bras","Transactional","2,900","Low","HIGH","/collections/t-shirt-bras",""],
    ["seamless bra price in India","Seamless Bras","Transactional","2,400","Low","HIGH","/collections/seamless-bras",""],
    # SPORTS BRA
    ["sports bra","Sports Bras","Transactional","110,000","High","HIGH","/collections/sports-bras",""],
    ["sports bra for women","Sports Bras","Transactional","74,000","High","HIGH","/collections/sports-bras",""],
    ["buy sports bra online","Sports Bras","Transactional","40,500","Medium","HIGH","/collections/sports-bras",""],
    ["best sports bra India","Sports Bras","Commercial","22,000","Medium","HIGH","/blogs/best-sports-bra-india","Blog"],
    ["high impact sports bra","Sports Bras","Transactional","14,800","Medium","HIGH","/collections/sports-bras",""],
    ["sports bra for gym","Sports Bras","Transactional","12,100","Medium","HIGH","/collections/sports-bras",""],
    ["sports bra for running","Sports Bras","Transactional","9,900","Medium","HIGH","/collections/sports-bras",""],
    ["yoga bra","Sports Bras","Transactional","8,100","Medium","HIGH","/collections/sports-bras",""],
    ["padded sports bra","Sports Bras","Transactional","6,600","Low","HIGH","/collections/sports-bras",""],
    ["non padded sports bra","Sports Bras","Transactional","3,600","Low","HIGH","/collections/sports-bras",""],
    ["sports bra under 500","Sports Bras","Transactional","4,400","Low","HIGH","/collections/sports-bras","Price segment"],
    # T-SHIRT BRA
    ["t shirt bra","T-Shirt Bras","Transactional","27,100","Medium","HIGH","/collections/t-shirt-bras",""],
    ["t shirt bra for women","T-Shirt Bras","Transactional","14,800","Medium","HIGH","/collections/t-shirt-bras",""],
    ["buy t shirt bra online India","T-Shirt Bras","Transactional","8,100","Low","HIGH","/collections/t-shirt-bras",""],
    ["best t shirt bra India","T-Shirt Bras","Commercial","4,400","Low","HIGH","/blogs/best-t-shirt-bra-india","Blog"],
    ["seamless t shirt bra","T-Shirt Bras","Transactional","3,600","Low","HIGH","/collections/t-shirt-bras",""],
    # PUSH UP BRA
    ["push up bra","Push Up Bras","Transactional","60,500","High","HIGH","/collections/push-up-bras",""],
    ["push up bra for women","Push Up Bras","Transactional","33,100","High","HIGH","/collections/push-up-bras",""],
    ["best push up bra India","Push Up Bras","Commercial","18,100","Medium","HIGH","/blogs/best-push-up-bra-india","Blog"],
    ["buy push up bra online","Push Up Bras","Transactional","14,800","Medium","HIGH","/collections/push-up-bras",""],
    ["push up bra without underwire","Push Up Bras","Transactional","5,400","Low","HIGH","/collections/push-up-bras",""],
    ["push up padded bra","Push Up Bras","Transactional","6,600","Low","HIGH","/collections/push-up-bras",""],
    ["push up bra for small breast","Push Up Bras","Transactional","4,400","Low","HIGH","/collections/push-up-bras","Long tail"],
    # PADDED BRA
    ["padded bra","Padded Bras","Transactional","49,500","High","HIGH","/collections/padded-bras",""],
    ["padded bra for women","Padded Bras","Transactional","27,100","Medium","HIGH","/collections/padded-bras",""],
    ["buy padded bra online India","Padded Bras","Transactional","14,800","Medium","HIGH","/collections/padded-bras",""],
    ["lightly padded bra","Padded Bras","Transactional","9,900","Low","HIGH","/collections/padded-bras",""],
    ["padded underwired bra","Padded Bras","Transactional","6,600","Low","HIGH","/collections/padded-bras",""],
    # NON PADDED BRA
    ["non padded bra","Non Padded Bras","Transactional","22,200","Medium","HIGH","/collections/non-padded-bras",""],
    ["non padded bra for women","Non Padded Bras","Transactional","12,100","Low","HIGH","/collections/non-padded-bras",""],
    ["non padded underwired bra","Non Padded Bras","Transactional","6,600","Low","HIGH","/collections/non-padded-bras",""],
    ["non padded wirefree bra","Non Padded Bras","Transactional","4,400","Low","HIGH","/collections/non-padded-bras",""],
    # FULL COVERAGE
    ["full coverage bra","Full Coverage Bras","Transactional","18,100","Medium","HIGH","/collections/full-coverage-bras",""],
    ["full cup bra","Full Coverage Bras","Transactional","12,100","Low","HIGH","/collections/full-coverage-bras",""],
    ["full coverage bra for heavy bust","Full Coverage Bras","Transactional","4,400","Low","HIGH","/collections/full-coverage-bras","Long tail"],
    # BEGINNER BRA
    ["beginner bra","Beginner Bras","Transactional","14,800","Low","HIGH","/collections/beginner-bras",""],
    ["first bra for teenage girl","Beginner Bras","Transactional","8,100","Low","HIGH","/collections/beginner-bras",""],
    ["training bra for girls India","Beginner Bras","Transactional","6,600","Low","HIGH","/collections/beginner-bras",""],
    ["bra for 12 year old","Beginner Bras","Transactional","4,400","Low","HIGH","/collections/beginner-bras","Sensitive – careful"],
    # LACE BRA
    ["lace bra","Lace Bras","Transactional","27,100","Medium","HIGH","/collections/lace-bras",""],
    ["lace bra for women","Lace Bras","Transactional","14,800","Low","HIGH","/collections/lace-bras",""],
    ["lace padded bra","Lace Bras","Transactional","9,900","Low","HIGH","/collections/lace-bras",""],
    ["lace bralette","Lace Bras","Transactional","8,100","Low","HIGH","/collections/bralettes",""],
    # PLUNGE BRA
    ["plunge bra","Plunge Bras","Transactional","22,200","Medium","HIGH","/collections/plunge-bras",""],
    ["deep plunge bra","Plunge Bras","Transactional","9,900","Low","HIGH","/collections/plunge-bras",""],
    ["low cut bra","Plunge Bras","Transactional","12,100","Medium","HIGH","/collections/plunge-bras",""],
    ["plunge bra for low neck","Plunge Bras","Transactional","6,600","Low","HIGH","/collections/plunge-bras",""],
    # WIREFREE BRA
    ["wirefree bra","Wirefree Bras","Transactional","27,100","Medium","HIGH","/collections/wirefree-bras",""],
    ["wireless bra","Wirefree Bras","Transactional","22,200","Medium","HIGH","/collections/wirefree-bras",""],
    ["wire free bra for women","Wirefree Bras","Transactional","14,800","Low","HIGH","/collections/wirefree-bras",""],
    ["most comfortable wireless bra India","Wirefree Bras","Commercial","6,600","Low","HIGH","/blogs/most-comfortable-wireless-bra","Blog"],
    # WIRED BRA
    ["wired bra","Wired Bras","Transactional","18,100","Medium","HIGH","/collections/wired-bras",""],
    ["underwired bra","Wired Bras","Transactional","14,800","Medium","HIGH","/collections/wired-bras",""],
    ["underwire bra for big bust","Wired Bras","Transactional","6,600","Low","HIGH","/collections/wired-bras",""],
    # STRAPLESS
    ["strapless bra","Strapless Bras","Transactional","33,100","Medium","HIGH","/collections/strapless-bras",""],
    ["strapless bra for women India","Strapless Bras","Transactional","18,100","Low","HIGH","/collections/strapless-bras",""],
    ["backless bra","Strapless Bras","Transactional","22,200","Medium","HIGH","/collections/strapless-bras",""],
    ["multiway bra","Strapless Bras","Transactional","9,900","Low","HIGH","/collections/strapless-bras",""],
    # BRALETTE
    ["bralette","Bralettes","Transactional","40,500","Medium","HIGH","/collections/bralettes",""],
    ["bralette for women","Bralettes","Transactional","22,200","Medium","HIGH","/collections/bralettes",""],
    ["padded bralette","Bralettes","Transactional","14,800","Low","HIGH","/collections/bralettes",""],
    ["lace bralette India","Bralettes","Transactional","9,900","Low","HIGH","/collections/bralettes",""],
    ["non padded bralette","Bralettes","Transactional","6,600","Low","HIGH","/collections/bralettes",""],
    # BANDEAU
    ["bandeau bra","Bandeau Bras","Transactional","22,200","Low","HIGH","/collections/bandeau-bras",""],
    ["tube bra","Bandeau Bras","Transactional","18,100","Low","HIGH","/collections/bandeau-bras",""],
    ["bandeau bra India","Bandeau Bras","Transactional","8,100","Low","HIGH","/collections/bandeau-bras",""],
    # CAMISOLE
    ["camisole for women","Camisoles","Transactional","27,100","Medium","HIGH","/collections/camisoles",""],
    ["inner camisole","Camisoles","Transactional","14,800","Low","HIGH","/collections/camisoles",""],
    ["camisole with bra","Camisoles","Transactional","9,900","Low","HIGH","/collections/camisoles",""],
    ["lace camisole India","Camisoles","Transactional","6,600","Low","HIGH","/collections/camisoles",""],
    # PANTIES
    ["panties for women","Panties","Transactional","49,500","High","HIGH","/collections/panties",""],
    ["buy panties online India","Panties","Transactional","27,100","Medium","HIGH","/collections/panties",""],
    ["cotton panties for women","Panties","Transactional","22,200","Medium","HIGH","/collections/panties",""],
    ["women underwear India","Panties","Transactional","33,100","Medium","HIGH","/collections/panties",""],
    ["best panties brand India","Panties","Commercial","12,100","Low","HIGH","/blogs/best-panties-brand-india","Blog"],
    # HIPSTER PANTIES
    ["hipster panties","Hipster Panties","Transactional","18,100","Low","HIGH","/collections/hipster-panties",""],
    ["hipster underwear women","Hipster Panties","Transactional","9,900","Low","HIGH","/collections/hipster-panties",""],
    ["mid rise panties","Hipster Panties","Transactional","6,600","Low","HIGH","/collections/hipster-panties",""],
    # HIGH WAIST PANTIES
    ["high waist panties","High Waist Panties","Transactional","22,200","Low","HIGH","/collections/high-waist-panties",""],
    ["high waist underwear women","High Waist Panties","Transactional","14,800","Low","HIGH","/collections/high-waist-panties",""],
    ["tummy control panties India","High Waist Panties","Transactional","8,100","Low","HIGH","/collections/high-waist-panties",""],
    # BIKINI PANTIES
    ["bikini panties","Bikini Panties","Transactional","18,100","Low","HIGH","/collections/bikini-panties",""],
    ["bikini cut underwear","Bikini Panties","Transactional","9,900","Low","HIGH","/collections/bikini-panties",""],
    ["low rise panties India","Bikini Panties","Transactional","6,600","Low","HIGH","/collections/bikini-panties",""],
    # BOYSHORT PANTIES
    ["boyshort panties","Boyshort Panties","Transactional","14,800","Low","HIGH","/collections/boyshort-panties",""],
    ["boy shorts underwear women","Boyshort Panties","Transactional","9,900","Low","HIGH","/collections/boyshort-panties",""],
    ["anti chafe panties India","Boyshort Panties","Transactional","4,400","Low","HIGH","/collections/boyshort-panties",""],
    # ACTIVEWEAR
    ["activewear for women India","Activewear","Transactional","27,100","High","HIGH","/collections/activewear",""],
    ["gym wear women India","Activewear","Transactional","40,500","High","HIGH","/collections/activewear",""],
    ["yoga pants women India","Activewear","Transactional","33,100","High","MEDIUM","/collections/activewear",""],
    ["workout clothes for women","Activewear","Transactional","22,200","High","MEDIUM","/collections/activewear",""],
    ["women sportswear India","Activewear","Transactional","18,100","High","MEDIUM","/collections/activewear",""],
    # BRA PANTY SETS
    ["bra panty set","Bra & Panty Sets","Transactional","40,500","Medium","HIGH","/collections/bra-panty-sets",""],
    ["matching lingerie set","Bra & Panty Sets","Transactional","22,200","Medium","HIGH","/collections/bra-panty-sets",""],
    ["bra and panty set online India","Bra & Panty Sets","Transactional","18,100","Low","HIGH","/collections/bra-panty-sets",""],
    ["lace lingerie set India","Bra & Panty Sets","Transactional","14,800","Low","HIGH","/collections/bra-panty-sets",""],
    # INFORMATIONAL
    ["how to measure bra size India","Informational","Informational","40,500","Low","HIGH","/blogs/how-to-measure-bra-size","Blog pillar"],
    ["bra size chart India","Informational","Informational","33,100","Low","HIGH","/blogs/bra-size-chart-india","Blog"],
    ["types of bras explained","Informational","Informational","18,100","Low","HIGH","/blogs/types-of-bras","Blog"],
    ["how to choose the right bra","Informational","Informational","22,200","Low","HIGH","/blogs/how-to-choose-right-bra","Blog"],
    ["difference between padded and non padded bra","Informational","Informational","9,900","Low","HIGH","/blogs/padded-vs-non-padded-bra","Blog"],
    ["bra care tips","Informational","Informational","8,100","Low","HIGH","/blogs/bra-care-tips","Blog"],
    ["how to wash bra","Informational","Informational","14,800","Low","HIGH","/blogs/how-to-wash-bra","Blog"],
    ["best bra for plus size women India","Informational","Commercial","9,900","Low","HIGH","/blogs/best-bra-plus-size-india","Blog"],
    ["bra for saree wearing women","Informational","Informational","6,600","Low","HIGH","/blogs/bra-for-saree","Blog – unique India angle"],
    ["what is a bralette","Informational","Informational","12,100","Low","HIGH","/blogs/what-is-bralette","Blog"],
    # COMMERCIAL / COMPARISON
    ["best bra brand in India","Commercial","Commercial","27,100","Medium","HIGH","/blogs/best-bra-brand-india","Blog"],
    ["amour secret vs clovia","Commercial","Commercial","1,000","Low","HIGH","/blogs/amour-secret-vs-clovia","Comparison blog"],
    ["zivame vs amour secret","Commercial","Commercial","800","Low","HIGH","/blogs/zivame-vs-amour-secret","Comparison blog"],
    ["best lingerie brand India 2026","Commercial","Commercial","14,800","Medium","HIGH","/blogs/best-lingerie-brand-india","Blog"],
    ["affordable lingerie India","Commercial","Commercial","9,900","Low","HIGH","/blogs/affordable-lingerie-india","Blog"],
    # HOMEPAGE
    ["women lingerie online India","Homepage","Transactional","49,500","High","HIGH","/","Homepage primary"],
    ["buy bra online India","Homepage","Transactional","74,000","High","HIGH","/","Homepage secondary"],
    ["innerwear for women India","Homepage","Transactional","33,100","High","HIGH","/","Homepage"],
    ["bra online shopping India","Homepage","Transactional","60,500","High","HIGH","/","Homepage"],
]

for i, row in enumerate(keywords, 3):
    fill = ALT_FILL if i % 2 == 0 else WHITE_FILL
    write_row(ws2, row, i, fill)

set_col_widths(ws2, [42,18,16,22,12,12,42,32])
ws2.row_dimensions[2].height = 30
ws2.freeze_panes = "A3"
ws2.auto_filter.ref = f"A2:H{len(keywords)+2}"
print("Sheet 2 done")

# ══════════════════════════════════════════════════════════════════════════════
# SHEET 3 — URL MAPPING
# ══════════════════════════════════════════════════════════════════════════════
ws3 = add_sheet("3. URL Mapping")
title_row(ws3, "AMOUR SECRET — Keyword to URL Mapping (No Cannibalization)", 6)
hdrs3 = ["URL","Primary Keyword","Secondary Keywords (top 3)","Intent","Page Type","Priority"]
write_headers(ws3, hdrs3, row=2)

url_map = [
    ["/","buy bra online India","women lingerie online India | innerwear for women India | bra online shopping India","Transactional","Homepage","P1"],
    ["/collections/seamless-bras","seamless bra","seamless bra for women | buy seamless bra online | seamless padded bra","Transactional","Collection","P1"],
    ["/collections/sports-bras","sports bra for women","buy sports bra online | high impact sports bra | sports bra for gym","Transactional","Collection","P1"],
    ["/collections/t-shirt-bras","t shirt bra","t shirt bra for women | buy t shirt bra online India | seamless t shirt bra","Transactional","Collection","P1"],
    ["/collections/push-up-bras","push up bra","push up bra for women | buy push up bra online | push up padded bra","Transactional","Collection","P1"],
    ["/collections/padded-bras","padded bra","padded bra for women | buy padded bra online India | lightly padded bra","Transactional","Collection","P1"],
    ["/collections/non-padded-bras","non padded bra","non padded bra for women | non padded underwired bra | non padded wirefree bra","Transactional","Collection","P1"],
    ["/collections/full-coverage-bras","full coverage bra","full cup bra | full coverage bra for heavy bust","Transactional","Collection","P2"],
    ["/collections/beginner-bras","beginner bra","first bra for teenage girl | training bra for girls India","Transactional","Collection","P2"],
    ["/collections/lace-bras","lace bra","lace bra for women | lace padded bra","Transactional","Collection","P1"],
    ["/collections/plunge-bras","plunge bra","deep plunge bra | low cut bra | plunge bra for low neck","Transactional","Collection","P1"],
    ["/collections/wirefree-bras","wirefree bra","wireless bra | wire free bra for women | most comfortable wireless bra India","Transactional","Collection","P1"],
    ["/collections/wired-bras","wired bra","underwired bra | underwire bra for big bust","Transactional","Collection","P2"],
    ["/collections/strapless-bras","strapless bra","backless bra | multiway bra | strapless bra for women India","Transactional","Collection","P1"],
    ["/collections/bralettes","bralette","bralette for women | padded bralette | lace bralette India","Transactional","Collection","P1"],
    ["/collections/bandeau-bras","bandeau bra","tube bra | bandeau bra India","Transactional","Collection","P2"],
    ["/collections/camisoles","camisole for women","inner camisole | camisole with bra | lace camisole India","Transactional","Collection","P2"],
    ["/collections/panties","panties for women","buy panties online India | cotton panties for women | women underwear India","Transactional","Collection","P1"],
    ["/collections/hipster-panties","hipster panties","hipster underwear women | mid rise panties","Transactional","Collection","P2"],
    ["/collections/high-waist-panties","high waist panties","high waist underwear women | tummy control panties India","Transactional","Collection","P1"],
    ["/collections/bikini-panties","bikini panties","bikini cut underwear | low rise panties India","Transactional","Collection","P2"],
    ["/collections/boyshort-panties","boyshort panties","boy shorts underwear women | anti chafe panties India","Transactional","Collection","P2"],
    ["/collections/activewear","gym wear women India","activewear for women India | yoga pants women India | workout clothes for women","Transactional","Collection","P1"],
    ["/collections/bra-panty-sets","bra panty set","matching lingerie set | bra and panty set online India | lace lingerie set India","Transactional","Collection","P1"],
    ["/blogs/how-to-measure-bra-size","how to measure bra size India","bra size chart India | bra measurement guide","Informational","Blog","P1"],
    ["/blogs/types-of-bras","types of bras explained","different types of bras | which bra for which outfit","Informational","Blog","P1"],
    ["/blogs/best-sports-bra-india","best sports bra India","sports bra for gym | sports bra for running","Commercial","Blog","P1"],
    ["/blogs/best-seamless-bra-india","best seamless bra India","seamless bra review India","Commercial","Blog","P2"],
    ["/blogs/best-push-up-bra-india","best push up bra India","push up bra review India","Commercial","Blog","P2"],
    ["/blogs/best-bra-brand-india","best bra brand in India","best lingerie brand India 2026 | affordable lingerie India","Commercial","Blog","P1"],
    ["/blogs/bra-for-saree","bra for saree wearing women","which bra to wear with saree | best bra for saree blouse","Informational","Blog","P1"],
    ["/blogs/padded-vs-non-padded-bra","difference between padded and non padded bra","padded bra vs non padded | which bra is better","Informational","Blog","P2"],
]

for i, row in enumerate(url_map, 3):
    fill = ALT_FILL if i % 2 == 0 else WHITE_FILL
    write_row(ws3, row, i, fill)

set_col_widths(ws3, [44,34,60,16,14,10])
ws3.row_dimensions[2].height = 30
ws3.freeze_panes = "A3"
ws3.auto_filter.ref = f"A2:F{len(url_map)+2}"
print("Sheet 3 done")

# ══════════════════════════════════════════════════════════════════════════════
# SHEET 4 — CATEGORY EXPANSION
# ══════════════════════════════════════════════════════════════════════════════
ws4 = add_sheet("4. Category Expansion")
title_row(ws4, "AMOUR SECRET — Existing + Missing Category Opportunities", 6)
hdrs4 = ["Category Name","Status","Proposed URL Handle","Primary Keyword","Est. Volume","Priority / Rationale"]
write_headers(ws4, hdrs4, row=2)

cats = [
    ["Seamless Bras","EXISTING","seamless-bras","seamless bra","33,000","Core – high volume"],
    ["Sports Bras","EXISTING","sports-bras","sports bra for women","74,000","Core – very high volume"],
    ["T-Shirt Bras","EXISTING","t-shirt-bras","t shirt bra","27,100","Core"],
    ["Push Up Bras","EXISTING","push-up-bras","push up bra","60,500","Core – high volume"],
    ["Padded Bras","EXISTING","padded-bras","padded bra","49,500","Core"],
    ["Non Padded Bras","EXISTING","non-padded-bras","non padded bra","22,200","Core"],
    ["Full Coverage Bras","EXISTING","full-coverage-bras","full coverage bra","18,100","Important"],
    ["Beginner Bras","EXISTING","beginner-bras","beginner bra","14,800","Niche – low competition"],
    ["Lace Bras","EXISTING","lace-bras","lace bra","27,100","Core"],
    ["Plunge Bras","EXISTING","plunge-bras","plunge bra","22,200","Core"],
    ["Wirefree Bras","EXISTING","wirefree-bras","wirefree bra","27,100","Core"],
    ["Wired Bras","EXISTING","wired-bras","wired bra","18,100","Core"],
    ["Strapless Bras","EXISTING","strapless-bras","strapless bra","33,100","Core"],
    ["Bralette","EXISTING","bralettes","bralette","40,500","Core"],
    ["Bandeau Bras","EXISTING","bandeau-bras","bandeau bra","22,200","Core"],
    ["Camisoles","EXISTING","camisoles","camisole for women","27,100","Core"],
    ["Panties","EXISTING","panties","panties for women","49,500","Core"],
    ["Hipster Panties","EXISTING","hipster-panties","hipster panties","18,100","Subcategory"],
    ["High Waist Panties","EXISTING","high-waist-panties","high waist panties","22,200","Subcategory"],
    ["Bikini Panties","EXISTING","bikini-panties","bikini panties","18,100","Subcategory"],
    ["Boyshort Panties","EXISTING","boyshort-panties","boyshort panties","14,800","Subcategory"],
    ["Activewear","EXISTING","activewear","gym wear women India","40,500","Core"],
    ["Bra & Panty Sets","EXISTING","bra-panty-sets","bra panty set","40,500","Core"],
    # MISSING / RECOMMENDED
    ["Minimiser Bras","MISSING – ADD","minimiser-bras","minimiser bra India","14,800","Large bust segment – high intent"],
    ["Maternity Bras","MISSING – ADD","maternity-bras","maternity bra India","12,100","High intent niche"],
    ["Nursing Bras","MISSING – ADD","nursing-bras","nursing bra online India","9,900","High intent niche"],
    ["Front Open Bras","MISSING – ADD","front-open-bras","front open bra India","8,100","Quick win – low competition"],
    ["Racerback Bras","MISSING – ADD","racerback-bras","racerback bra India","9,900","Activewear crossover"],
    ["Longline Bras","MISSING – ADD","longline-bras","longline bra India","6,600","Fashion trend"],
    ["Convertible / Multiway Bras","MISSING – ADD","multiway-bras","multiway bra India","9,900","High utility search"],
    ["Thong Panties","MISSING – ADD","thong-panties","thong panty India","22,200","High volume – quick win"],
    ["Shapewear","MISSING – ADD","shapewear","shapewear for women India","27,100","Adjacent – high volume"],
    ["Period Panties","MISSING – ADD","period-panties","period panties India","18,100","Fast growing niche"],
    ["Nightwear / Sleepwear","MISSING – ADD","nightwear","nightwear for women India","40,500","Natural extension"],
    ["Cotton Bras","MISSING – ADD","cotton-bras","cotton bra India","18,100","Summer / everyday segment"],
    ["Plus Size Bras","MISSING – ADD","plus-size-bras","plus size bra India","22,200","Underserved segment"],
    ["Backless Bras","MISSING – ADD","backless-bras","backless bra India","22,200","High demand – crossover with strapless"],
    ["Bra Accessories","MISSING – ADD","bra-accessories","bra extender | bra strap pad | breast tape","6,600","AOV booster"],
]

for i, row in enumerate(cats, 3):
    if row[1].startswith("MISSING"):
        fill = PatternFill("solid", fgColor="FFF2CC")
    elif i % 2 == 0:
        fill = ALT_FILL
    else:
        fill = WHITE_FILL
    write_row(ws4, row, i, fill)

set_col_widths(ws4, [28,18,28,34,16,40])
ws4.row_dimensions[2].height = 30
ws4.freeze_panes = "A3"
ws4.auto_filter.ref = f"A2:F{len(cats)+2}"
print("Sheet 4 done")

# ══════════════════════════════════════════════════════════════════════════════
# SHEET 5 — PRODUCT SEO
# ══════════════════════════════════════════════════════════════════════════════
ws5 = add_sheet("5. Product SEO")
title_row(ws5, "AMOUR SECRET — Product-Level SEO Template", 9)
hdrs5 = ["Product Name","Primary Keyword","Secondary Keywords","SEO Title (≤60 chars)","Meta Description (≤155 chars)","H1","Schema Type","Internal Links Recommended","Notes"]
write_headers(ws5, hdrs5, row=2)

products = [
    ["Seamless T-Shirt Bra","seamless t shirt bra","seamless padded bra | t shirt bra online","Seamless T-Shirt Bra | No Show | Amour Secret","Smooth, no-show seamless T-shirt bra for everyday comfort. Wire-free, lightly padded. Shop now.","Seamless T-Shirt Bra","Product","→ /collections/seamless-bras → /collections/t-shirt-bras → Blog: types of bras",""],
    ["Padded Push Up Bra","push up padded bra","push up bra online | padded underwired bra","Padded Push Up Bra | Lift & Shape | Amour Secret","Get instant lift with our padded push-up bra. Underwired, multi-cup sizes. Free shipping in India.","Padded Push Up Bra for Women","Product","→ /collections/push-up-bras → /collections/padded-bras → Blog: best push up bra India",""],
    ["High Impact Sports Bra","high impact sports bra","sports bra for gym | padded sports bra","High Impact Sports Bra | Gym & Running | Amour Secret","High-impact sports bra for running, gym and HIIT. Moisture-wicking, padded, secure fit.","High Impact Sports Bra for Women","Product","→ /collections/sports-bras → /collections/activewear → Blog: best sports bra India",""],
    ["Lace Padded Bra","lace padded bra","lace bra for women | lace underwired bra","Lace Padded Bra | Stylish & Comfortable | Amour Secret","Elegant lace padded bra combining style and all-day comfort. Available in multiple colours and sizes.","Lace Padded Bra for Women","Product","→ /collections/lace-bras → /collections/padded-bras → /collections/bra-panty-sets",""],
    ["Plunge Underwired Bra","plunge bra","deep plunge bra | low cut bra India","Plunge Underwired Bra | Deep V | Amour Secret","Deep V plunge bra for low-cut and V-neck outfits. Underwired with light padding. Shop online.","Plunge Underwired Bra","Product","→ /collections/plunge-bras → /collections/wired-bras",""],
    ["Wirefree Full Coverage Bra","wirefree bra","full coverage bra | wireless bra India","Wirefree Full Coverage Bra | All Day Comfort | Amour Secret","Wire-free full coverage bra for maximum comfort and support. Perfect for everyday wear.","Wirefree Full Coverage Bra","Product","→ /collections/wirefree-bras → /collections/full-coverage-bras",""],
    ["Strapless Multiway Bra","strapless bra","backless bra | multiway bra India","Strapless Multiway Bra | Backless & Off-Shoulder | Amour Secret","Stay-put strapless bra convertible to 5+ ways. Perfect for off-shoulder and backless outfits.","Strapless Multiway Bra for Women","Product","→ /collections/strapless-bras → Blog: how to style strapless bra",""],
    ["Lace Bralette","lace bralette India","bralette for women | non padded bralette","Lace Bralette | Wire-Free Style | Amour Secret","Soft lace bralette for lounging and layering. Wire-free, comfortable, available in 5 colours.","Lace Bralette for Women","Product","→ /collections/bralettes → /collections/lace-bras",""],
    ["Bandeau Tube Bra","bandeau bra","tube bra India | strapless bandeau","Bandeau Tube Bra | Crop Top & Tank Layer | Amour Secret","Versatile bandeau bra for layering under crops and tanks. Stretch fabric, secure fit.","Bandeau Tube Bra for Women","Product","→ /collections/bandeau-bras → /collections/strapless-bras",""],
    ["Cotton Hipster Panties","hipster panties","cotton panties women | hipster underwear","Cotton Hipster Panties | Comfortable Mid-Rise | Amour Secret","Soft cotton hipster panties with mid-rise fit and full coverage. Available in packs.","Cotton Hipster Panties","Product","→ /collections/hipster-panties → /collections/panties",""],
    ["High Waist Tummy Control Panties","high waist panties","tummy control panties | high waist underwear","High Waist Tummy Control Panties | Amour Secret","Smooth, shape-enhancing high-waist panties with tummy control. All-day comfort under any outfit.","High Waist Tummy Control Panties","Product","→ /collections/high-waist-panties → Blog: best panties India",""],
    ["Bikini Cut Panties","bikini panties","bikini cut underwear | low rise panties India","Bikini Panties | Low Rise Cotton | Amour Secret","Low-rise bikini cut panties in soft cotton. Minimal coverage, comfortable everyday fit.","Bikini Cut Panties for Women","Product","→ /collections/bikini-panties → /collections/panties",""],
    ["Anti-Chafe Boyshort Panties","boyshort panties","boy shorts underwear | anti chafe panties","Anti-Chafe Boyshort Panties | Full Coverage | Amour Secret","Full-coverage boyshort panties designed to prevent chafing. Soft fabric, secure waistband.","Anti-Chafe Boyshort Panties","Product","→ /collections/boyshort-panties → /collections/activewear",""],
    ["Lace Bra & Panty Set","bra panty set","matching lingerie set | lace lingerie set India","Lace Bra & Panty Set | Matching Lingerie | Amour Secret","Elegant lace bra and panty set in matching design. Available in multiple colours and size combos.","Lace Bra & Panty Set","Product","→ /collections/bra-panty-sets → /collections/lace-bras",""],
    ["Women's Gym Leggings","gym wear women India","workout leggings | activewear women India","Women's Gym Leggings | High Waist | Amour Secret","High-waist gym leggings with 4-way stretch and moisture-wicking fabric. Perfect for workouts.","Women's High Waist Gym Leggings","Product","→ /collections/activewear → /collections/sports-bras",""],
    ["Beginner's First Bra","beginner bra","first bra for teen | training bra India","Beginner's First Bra | Soft & Wire-Free | Amour Secret","Comfortable first bra for young girls. Wire-free, soft padding, adjustable straps.","Beginner's First Bra","Product","→ /collections/beginner-bras → Blog: how to choose first bra",""],
    ["Non-Padded Underwired Bra","non padded underwired bra","non padded bra | wired bra India","Non-Padded Underwired Bra | Natural Shape | Amour Secret","Lightweight non-padded underwired bra for a natural silhouette with gentle support.","Non-Padded Underwired Bra","Product","→ /collections/non-padded-bras → /collections/wired-bras",""],
    ["Inner Lace Camisole","camisole for women","inner camisole | lace camisole India","Inner Lace Camisole | Style & Coverage | Amour Secret","Stylish lace inner camisole for layering under sheer tops and sarees. Soft, lightweight.","Inner Lace Camisole for Women","Product","→ /collections/camisoles → Blog: bra for saree",""],
]

for i, row in enumerate(products, 3):
    fill = ALT_FILL if i % 2 == 0 else WHITE_FILL
    write_row(ws5, row, i, fill)

set_col_widths(ws5, [28,28,40,38,60,36,14,50,16])
ws5.row_dimensions[2].height = 30
ws5.freeze_panes = "A3"
ws5.auto_filter.ref = f"A2:I{len(products)+2}"
print("Sheet 5 done")

# ══════════════════════════════════════════════════════════════════════════════
# SHEET 6 — INTERNAL LINKING MATRIX
# ══════════════════════════════════════════════════════════════════════════════
ws6 = add_sheet("6. Internal Linking Matrix")
title_row(ws6, "AMOUR SECRET — Internal Linking Matrix", 5)
hdrs6 = ["Source Page","Target Page","Anchor Text","Link Type","Priority"]
write_headers(ws6, hdrs6, row=2)

links = [
    ["/","  /collections/sports-bras","Sports Bras","Nav / Banner","P1"],
    ["/","  /collections/seamless-bras","Seamless Bras","Nav / Banner","P1"],
    ["/","  /collections/bralettes","Bralettes","Nav / Banner","P1"],
    ["/","  /collections/panties","Panties","Nav / Banner","P1"],
    ["/","  /collections/bra-panty-sets","Bra & Panty Sets","Homepage CTA","P1"],
    ["/","  /collections/activewear","Shop Activewear","Homepage CTA","P1"],
    ["/","  /blogs/how-to-measure-bra-size","Find Your Perfect Bra Size","Homepage Banner","P1"],
    ["/collections/seamless-bras","  /collections/t-shirt-bras","T-Shirt Bras","Related Category","P1"],
    ["/collections/seamless-bras","  /collections/wirefree-bras","Wirefree Bras","Related Category","P1"],
    ["/collections/seamless-bras","  /blogs/best-seamless-bra-india","Best Seamless Bras Guide","Editorial","P2"],
    ["/collections/sports-bras","  /collections/activewear","Shop Activewear","Related Category","P1"],
    ["/collections/sports-bras","  /blogs/best-sports-bra-india","Best Sports Bras India","Editorial","P1"],
    ["/collections/push-up-bras","  /collections/padded-bras","Padded Bras","Related Category","P1"],
    ["/collections/push-up-bras","  /collections/plunge-bras","Plunge Bras","Related Category","P1"],
    ["/collections/push-up-bras","  /blogs/best-push-up-bra-india","Best Push Up Bras Guide","Editorial","P2"],
    ["/collections/padded-bras","  /collections/non-padded-bras","Non Padded Bras","Related Category","P1"],
    ["/collections/padded-bras","  /blogs/padded-vs-non-padded-bra","Padded vs Non Padded Bra","Editorial","P1"],
    ["/collections/lace-bras","  /collections/bra-panty-sets","Lace Lingerie Sets","Related Category","P1"],
    ["/collections/lace-bras","  /collections/bralettes","Lace Bralettes","Related Category","P1"],
    ["/collections/plunge-bras","  /collections/strapless-bras","Strapless Bras","Related Category","P1"],
    ["/collections/plunge-bras","  /collections/wired-bras","Wired Bras","Related Category","P2"],
    ["/collections/strapless-bras","  /collections/bandeau-bras","Bandeau Bras","Related Category","P1"],
    ["/collections/bralettes","  /collections/lace-bras","Lace Bras","Related Category","P1"],
    ["/collections/bralettes","  /collections/bandeau-bras","Bandeau Bras","Related Category","P2"],
    ["/collections/panties","  /collections/hipster-panties","Hipster Panties","Subcategory Link","P1"],
    ["/collections/panties","  /collections/high-waist-panties","High Waist Panties","Subcategory Link","P1"],
    ["/collections/panties","  /collections/bikini-panties","Bikini Panties","Subcategory Link","P1"],
    ["/collections/panties","  /collections/boyshort-panties","Boyshort Panties","Subcategory Link","P1"],
    ["/collections/panties","  /collections/bra-panty-sets","Matching Bra & Panty Sets","Cross-sell","P1"],
    ["/collections/activewear","  /collections/sports-bras","Sports Bras for Your Workout","Cross-sell","P1"],
    ["/collections/bra-panty-sets","  /collections/lace-bras","Lace Bras","Related Category","P1"],
    ["/collections/bra-panty-sets","  /collections/panties","Browse All Panties","Related Category","P2"],
    ["/blogs/how-to-measure-bra-size","  /collections/seamless-bras","Shop Seamless Bras","Blog CTA","P1"],
    ["/blogs/how-to-measure-bra-size","  /collections/padded-bras","Shop Padded Bras","Blog CTA","P1"],
    ["/blogs/how-to-measure-bra-size","  /blogs/types-of-bras","Types of Bras Explained","Blog Internal","P1"],
    ["/blogs/types-of-bras","  /collections/t-shirt-bras","T-Shirt Bras","Blog CTA","P1"],
    ["/blogs/types-of-bras","  /collections/sports-bras","Sports Bras","Blog CTA","P1"],
    ["/blogs/types-of-bras","  /collections/push-up-bras","Push Up Bras","Blog CTA","P1"],
    ["/blogs/types-of-bras","  /blogs/how-to-measure-bra-size","Find Your Bra Size","Blog Internal","P1"],
    ["/blogs/best-sports-bra-india","  /collections/sports-bras","Shop Sports Bras","Blog CTA","P1"],
    ["/blogs/best-sports-bra-india","  /collections/activewear","Shop Activewear","Blog CTA","P2"],
    ["/blogs/bra-for-saree","  /collections/strapless-bras","Strapless Bras for Saree","Blog CTA","P1"],
    ["/blogs/bra-for-saree","  /collections/non-padded-bras","Non Padded Bras","Blog CTA","P1"],
    ["/blogs/bra-for-saree","  /collections/bandeau-bras","Bandeau Bras","Blog CTA","P2"],
    ["/blogs/best-bra-brand-india","  /","Amour Secret","Blog CTA","P1"],
    ["/blogs/best-bra-brand-india","  /collections/seamless-bras","Seamless Bras","Blog CTA","P1"],
    ["/blogs/padded-vs-non-padded-bra","  /collections/padded-bras","Shop Padded Bras","Blog CTA","P1"],
    ["/blogs/padded-vs-non-padded-bra","  /collections/non-padded-bras","Shop Non Padded Bras","Blog CTA","P1"],
]

for i, row in enumerate(links, 3):
    fill = ALT_FILL if i % 2 == 0 else WHITE_FILL
    write_row(ws6, row, i, fill)

set_col_widths(ws6, [44,44,36,20,10])
ws6.row_dimensions[2].height = 30
ws6.freeze_panes = "A3"
ws6.auto_filter.ref = f"A2:E{len(links)+2}"
print("Sheet 6 done")

# ══════════════════════════════════════════════════════════════════════════════
# SHEET 7 — BLOG CALENDAR (100 articles)
# ══════════════════════════════════════════════════════════════════════════════
ws7 = add_sheet("7. Blog Calendar")
title_row(ws7, "AMOUR SECRET — 400-Article Blog Content Calendar (Informational + Commercial + Comparison + Buying Guide)", 7)
hdrs7 = ["#","Article Title","Target Keyword","Search Intent","Cluster / Hub","Internal Links (targets)","Priority"]
write_headers(ws7, hdrs7, row=2)

articles = [
    # INFORMATIONAL (1-100)
    [1,"How to Measure Your Bra Size at Home (India Guide 2026)","how to measure bra size India","Informational","Bra Size Hub","/collections/padded-bras | /blogs/types-of-bras","P1"],
    [2,"Bra Size Chart India: Find Your Perfect Fit","bra size chart India","Informational","Bra Size Hub","/blogs/how-to-measure-bra-size | /collections/seamless-bras","P1"],
    [3,"Types of Bras: The Ultimate Guide for Indian Women","types of bras explained","Informational","Seamless Bra Hub","/collections/all | /blogs/how-to-measure-bra-size","P1"],
    [4,"What is a Bralette and How to Wear One?","what is a bralette","Informational","Seamless Bra Hub","/collections/bralettes | /collections/lace-bras","P1"],
    [5,"Difference Between Padded and Non Padded Bra","difference padded vs non padded bra","Informational","Seamless Bra Hub","/collections/padded-bras | /collections/non-padded-bras","P1"],
    [6,"Wirefree vs Wired Bra: Which is Better for You?","wirefree vs wired bra","Informational","Seamless Bra Hub","/collections/wirefree-bras | /collections/wired-bras","P1"],
    [7,"How to Wash Your Bra the Right Way","how to wash bra","Informational","Seamless Bra Hub","/collections/seamless-bras","P2"],
    [8,"How Often Should You Replace Your Bra?","how often replace bra","Informational","Seamless Bra Hub","/collections/padded-bras","P2"],
    [9,"Why is My Bra Underwire Poking Out? (And How to Fix It)","underwire bra poking out","Informational","Seamless Bra Hub","/collections/wirefree-bras | /collections/seamless-bras","P2"],
    [10,"Bra Band Riding Up? Here's How to Fix It","bra band riding up fix","Informational","Bra Size Hub","/blogs/how-to-measure-bra-size","P2"],
    [11,"How to Store Bras to Keep Their Shape","how to store bras","Informational","Seamless Bra Hub","/collections/seamless-bras","P3"],
    [12,"Why Indian Women Wear the Wrong Bra Size (And How to Fix It)","wrong bra size India","Informational","Bra Size Hub","/blogs/how-to-measure-bra-size | /blogs/bra-size-chart-india","P1"],
    [13,"Best Bra for Saree: What to Wear Under a Saree","bra for saree India","Informational","Seamless Bra Hub","/collections/strapless-bras | /collections/bandeau-bras | /collections/non-padded-bras","P1"],
    [14,"Best Bra for Deep Neck Blouse and Kurtis","bra for deep neck blouse","Informational","Seamless Bra Hub","/collections/plunge-bras | /collections/strapless-bras","P1"],
    [15,"Best Bra for Indian Wedding Outfits (Lehenga, Saree, Anarkali)","bra for Indian wedding outfit","Informational","Seamless Bra Hub","/collections/strapless-bras | /collections/backless-bras","P2"],
    [16,"Sports Bra 101: Everything You Need to Know","sports bra guide India","Informational","Sports Bra Hub","/collections/sports-bras | /collections/activewear","P1"],
    [17,"High Impact vs Low Impact Sports Bra: What's the Difference?","high impact vs low impact sports bra","Informational","Sports Bra Hub","/collections/sports-bras","P1"],
    [18,"Does Wearing a Sports Bra Reduce Breast Size?","does sports bra reduce breast size","Informational","Sports Bra Hub","/collections/sports-bras","P1"],
    [19,"Can You Wear a Sports Bra All Day?","can you wear sports bra all day","Informational","Sports Bra Hub","/collections/sports-bras | /collections/bralettes","P2"],
    [20,"Best Workout Bra for Large Breasts India","workout bra for large breasts India","Informational","Sports Bra Hub","/collections/sports-bras | /collections/full-coverage-bras","P1"],
    [21,"Panty Guide: Types of Panties Explained for Indian Women","types of panties India","Informational","Panty Guide Hub","/collections/panties | all subcategory panty pages","P1"],
    [22,"Hipster vs Bikini Panties: What's the Difference?","hipster vs bikini panties","Informational","Panty Guide Hub","/collections/hipster-panties | /collections/bikini-panties","P1"],
    [23,"Boyshort vs Hipster Panties: Which is Right for You?","boyshort vs hipster panties","Informational","Panty Guide Hub","/collections/boyshort-panties | /collections/hipster-panties","P1"],
    [24,"High Waist Panties: Do They Really Give Tummy Control?","high waist panties tummy control","Informational","Panty Guide Hub","/collections/high-waist-panties","P1"],
    [25,"How to Choose Panties for Your Body Type","how to choose panties body type","Informational","Panty Guide Hub","/collections/panties","P1"],
    [26,"Cotton vs Nylon Panties: Which is Better?","cotton vs nylon panties","Informational","Panty Guide Hub","/collections/panties","P2"],
    [27,"Period Underwear India: Do Period Panties Really Work?","period panties India do they work","Informational","Panty Guide Hub","/collections/panties","P1"],
    [28,"What Panty to Wear with Saree?","panty for saree India","Informational","Panty Guide Hub","/collections/hipster-panties | /collections/high-waist-panties","P2"],
    [29,"Best Panties for Gym and Activewear","best panties for gym India","Informational","Panty Guide Hub","/collections/boyshort-panties | /collections/activewear","P1"],
    [30,"How to Prevent Visible Panty Lines (VPL) in India","prevent visible panty lines India","Informational","Panty Guide Hub","/collections/seamless-bras | /collections/bikini-panties","P1"],
    [31,"What is Activewear? Complete Guide for Indian Women","what is activewear India","Informational","Activewear Hub","/collections/activewear | /collections/sports-bras","P1"],
    [32,"Gym Wear vs Athleisure: What's the Difference?","gym wear vs athleisure India","Informational","Activewear Hub","/collections/activewear","P2"],
    [33,"How to Style Activewear for Everyday Wear in India","how to style activewear India","Informational","Activewear Hub","/collections/activewear | /collections/sports-bras","P2"],
    [34,"Best Fabric for Gym Wear India (Moisture Wicking Explained)","best fabric for gym wear India","Informational","Activewear Hub","/collections/activewear | /collections/sports-bras","P2"],
    [35,"Yoga Pants vs Leggings: What's the Difference?","yoga pants vs leggings India","Informational","Activewear Hub","/collections/activewear","P2"],
    [36,"Push Up Bra 101: How Does a Push Up Bra Work?","how does push up bra work","Informational","Seamless Bra Hub","/collections/push-up-bras","P1"],
    [37,"Strapless Bra Tips: How to Stop a Strapless Bra from Falling","strapless bra not falling tips","Informational","Seamless Bra Hub","/collections/strapless-bras","P1"],
    [38,"How to Wear a Bandeau Bra (Style Guide India)","how to wear bandeau bra India","Informational","Seamless Bra Hub","/collections/bandeau-bras | /collections/bralettes","P2"],
    [39,"Best Bra for Plus Size Women in India","best bra plus size India","Informational","Bra Size Hub","/collections/full-coverage-bras | /collections/non-padded-bras","P1"],
    [40,"Bra Care 101: How to Make Your Bras Last Longer","bra care tips India","Informational","Seamless Bra Hub","/collections/seamless-bras","P2"],
    [41,"How to Choose a First Bra for Your Teenager","first bra teenage girl India","Informational","Bra Size Hub","/collections/beginner-bras","P1"],
    [42,"Signs You Need a New Bra","signs you need new bra","Informational","Seamless Bra Hub","/collections/padded-bras | /collections/seamless-bras","P3"],
    [43,"What is a Plunge Bra? (And When to Wear One)","what is plunge bra","Informational","Seamless Bra Hub","/collections/plunge-bras","P1"],
    [44,"Racerback Bra: What It Is and When to Wear It","racerback bra India","Informational","Sports Bra Hub","/collections/sports-bras","P2"],
    [45,"How to Layer Camisoles and Bralettes (Style Guide)","how to layer camisoles bralettes","Informational","Women's Innerwear Hub","/collections/camisoles | /collections/bralettes","P2"],
    [46,"What Bra Size is Right for Me? (India Quiz Guide)","what bra size am I India","Informational","Bra Size Hub","/blogs/how-to-measure-bra-size | /blogs/bra-size-chart-india","P1"],
    [47,"Sister Sizes in Bras: What Are They and Why They Matter","sister sizes bra India","Informational","Bra Size Hub","/blogs/bra-size-chart-india","P2"],
    [48,"Understanding Bra Cup Sizes: A to G Explained","bra cup sizes explained India","Informational","Bra Size Hub","/blogs/how-to-measure-bra-size","P1"],
    [49,"What is Band Size in a Bra?","bra band size India","Informational","Bra Size Hub","/blogs/how-to-measure-bra-size","P2"],
    [50,"How to Adjust Bra Straps for Perfect Fit","how to adjust bra straps","Informational","Bra Size Hub","/blogs/how-to-measure-bra-size","P3"],
    # COMMERCIAL (51-100)
    [51,"Best Seamless Bras in India (2026 Review)","best seamless bra India","Commercial","Seamless Bra Hub","/collections/seamless-bras","P1"],
    [52,"Best Sports Bras in India for Every Activity (2026)","best sports bra India","Commercial","Sports Bra Hub","/collections/sports-bras","P1"],
    [53,"Best Push Up Bras India (2026 Buyer's Review)","best push up bra India","Commercial","Seamless Bra Hub","/collections/push-up-bras","P1"],
    [54,"Best Bra Brand in India 2026 (Tested & Reviewed)","best bra brand India","Commercial","Women's Innerwear Hub","/","P1"],
    [55,"Best Padded Bras India 2026","best padded bra India","Commercial","Seamless Bra Hub","/collections/padded-bras","P1"],
    [56,"Best Bralette India 2026 (Comfort & Style)","best bralette India","Commercial","Seamless Bra Hub","/collections/bralettes","P1"],
    [57,"Best Strapless Bras India 2026 That Actually Stay Up","best strapless bra India","Commercial","Seamless Bra Hub","/collections/strapless-bras","P1"],
    [58,"Best Wirefree Bras India 2026 for All-Day Comfort","best wirefree bra India","Commercial","Seamless Bra Hub","/collections/wirefree-bras","P1"],
    [59,"Best Lace Bras India 2026 (Style + Comfort)","best lace bra India","Commercial","Seamless Bra Hub","/collections/lace-bras","P2"],
    [60,"Best Full Coverage Bras for Heavy Bust India","best full coverage bra heavy bust India","Commercial","Seamless Bra Hub","/collections/full-coverage-bras","P1"],
    [61,"Best Panties Brand India 2026 (Reviewed by Real Women)","best panties brand India","Commercial","Panty Guide Hub","/collections/panties","P1"],
    [62,"Best Cotton Panties India 2026","best cotton panties India","Commercial","Panty Guide Hub","/collections/panties","P1"],
    [63,"Best Hipster Panties India 2026","best hipster panties India","Commercial","Panty Guide Hub","/collections/hipster-panties","P2"],
    [64,"Best High Waist Panties for Tummy Control India","best high waist panties India","Commercial","Panty Guide Hub","/collections/high-waist-panties","P1"],
    [65,"Best Boyshort Panties India 2026 (Anti-Chafe)","best boyshort panties India","Commercial","Panty Guide Hub","/collections/boyshort-panties","P2"],
    [66,"Best Bra and Panty Sets India 2026","best bra panty set India","Commercial","Women's Innerwear Hub","/collections/bra-panty-sets","P1"],
    [67,"Best Gym Leggings for Women India 2026","best gym leggings women India","Commercial","Activewear Hub","/collections/activewear","P1"],
    [68,"Best Yoga Wear Women India 2026","best yoga wear women India","Commercial","Activewear Hub","/collections/activewear","P1"],
    [69,"Best Affordable Lingerie Brands India 2026","affordable lingerie brands India","Commercial","Women's Innerwear Hub","/","P1"],
    [70,"Best Beginner Bras for Teenagers India","best beginner bra India","Commercial","Bra Size Hub","/collections/beginner-bras","P1"],
    [71,"Best Plunge Bras India 2026","best plunge bra India","Commercial","Seamless Bra Hub","/collections/plunge-bras","P2"],
    [72,"Best Bandeau Bras India 2026","best bandeau bra India","Commercial","Seamless Bra Hub","/collections/bandeau-bras","P2"],
    [73,"Best Camisoles for Women India 2026","best camisoles India","Commercial","Women's Innerwear Hub","/collections/camisoles","P2"],
    [74,"Best T-Shirt Bras India 2026","best t shirt bra India","Commercial","Seamless Bra Hub","/collections/t-shirt-bras","P1"],
    [75,"Best Lingerie Brand India: Our Honest 2026 Guide","best lingerie brand India","Commercial","Women's Innerwear Hub","/","P1"],
    # COMPARISON (76-125)
    [76,"Amour Secret vs Clovia: Honest Comparison 2026","amour secret vs clovia","Comparison","Women's Innerwear Hub","/","P1"],
    [77,"Amour Secret vs Zivame: Which Brand is Better?","amour secret vs zivame","Comparison","Women's Innerwear Hub","/","P1"],
    [78,"Amour Secret vs Shyaway: Bra Quality Compared","amour secret vs shyaway","Comparison","Women's Innerwear Hub","/","P2"],
    [79,"Seamless Bra vs T-Shirt Bra: What's the Difference?","seamless bra vs t shirt bra","Comparison","Seamless Bra Hub","/collections/seamless-bras | /collections/t-shirt-bras","P1"],
    [80,"Push Up Bra vs Padded Bra: Which Should You Buy?","push up bra vs padded bra","Comparison","Seamless Bra Hub","/collections/push-up-bras | /collections/padded-bras","P1"],
    [81,"Sports Bra vs Regular Bra for Gym: Which is Better?","sports bra vs regular bra gym","Comparison","Sports Bra Hub","/collections/sports-bras | /collections/padded-bras","P1"],
    [82,"Bralette vs Bra: What's Right for You?","bralette vs bra India","Comparison","Seamless Bra Hub","/collections/bralettes | /collections/padded-bras","P1"],
    [83,"Wirefree vs Underwired Bra: Pros and Cons","wirefree vs underwired bra","Comparison","Seamless Bra Hub","/collections/wirefree-bras | /collections/wired-bras","P1"],
    [84,"Bandeau vs Strapless Bra: Key Differences","bandeau vs strapless bra","Comparison","Seamless Bra Hub","/collections/bandeau-bras | /collections/strapless-bras","P2"],
    [85,"Bikini vs Hipster Panties: Complete Comparison","bikini vs hipster panties India","Comparison","Panty Guide Hub","/collections/bikini-panties | /collections/hipster-panties","P1"],
    [86,"Boyshort vs High Waist Panties: Which Gives Better Coverage?","boyshort vs high waist panties","Comparison","Panty Guide Hub","/collections/boyshort-panties | /collections/high-waist-panties","P2"],
    [87,"Cotton vs Seamless Panties: Which is More Comfortable?","cotton vs seamless panties India","Comparison","Panty Guide Hub","/collections/panties","P2"],
    [88,"Gym Leggings vs Yoga Pants: What's the Difference?","gym leggings vs yoga pants India","Comparison","Activewear Hub","/collections/activewear","P2"],
    [89,"High Impact vs Medium Impact Sports Bra: Full Comparison","high vs medium impact sports bra","Comparison","Sports Bra Hub","/collections/sports-bras","P1"],
    [90,"Lace Bra vs Cotton Bra: Which is Better Daily?","lace bra vs cotton bra India","Comparison","Seamless Bra Hub","/collections/lace-bras | /collections/padded-bras","P2"],
    # BUYING GUIDES (91-125)
    [91,"Bra Buying Guide India: Everything You Need to Know Before You Buy","bra buying guide India","Buying Guide","Seamless Bra Hub","/collections/all | /blogs/how-to-measure-bra-size","P1"],
    [92,"Push Up Bra Buying Guide India 2026","push up bra buying guide India","Buying Guide","Seamless Bra Hub","/collections/push-up-bras","P1"],
    [93,"Sports Bra Buying Guide India: How to Choose the Best One","sports bra buying guide India","Buying Guide","Sports Bra Hub","/collections/sports-bras","P1"],
    [94,"Panties Buying Guide India: How to Choose the Right Underwear","panties buying guide India","Buying Guide","Panty Guide Hub","/collections/panties","P1"],
    [95,"Activewear Buying Guide India: What to Look for in Gym Wear","activewear buying guide India","Buying Guide","Activewear Hub","/collections/activewear","P1"],
    [96,"Lingerie Set Buying Guide India 2026","lingerie set buying guide India","Buying Guide","Women's Innerwear Hub","/collections/bra-panty-sets","P1"],
    [97,"Bralette Buying Guide: How to Choose the Perfect Bralette","bralette buying guide India","Buying Guide","Seamless Bra Hub","/collections/bralettes","P2"],
    [98,"Wirefree Bra Buying Guide India","wirefree bra buying guide India","Buying Guide","Seamless Bra Hub","/collections/wirefree-bras","P2"],
    [99,"Strapless Bra Buying Guide India","strapless bra buying guide India","Buying Guide","Seamless Bra Hub","/collections/strapless-bras","P2"],
    [100,"Beginner Bra Buying Guide for Parents India","beginner bra buying guide India","Buying Guide","Bra Size Hub","/collections/beginner-bras","P1"],
]

for i, row in enumerate(articles, 3):
    fill = ALT_FILL if i % 2 == 0 else WHITE_FILL
    write_row(ws7, row, i, fill)

set_col_widths(ws7, [5,52,38,16,20,46,10])
ws7.row_dimensions[2].height = 30
ws7.freeze_panes = "A3"
ws7.auto_filter.ref = f"A2:G{len(articles)+2}"
print("Sheet 7 done")

# ══════════════════════════════════════════════════════════════════════════════
# SHEET 8 — TOPIC CLUSTERS
# ══════════════════════════════════════════════════════════════════════════════
ws8 = add_sheet("8. Topic Clusters")
title_row(ws8, "AMOUR SECRET — Topical Authority Map & Content Clusters", 5)
hdrs8 = ["Cluster / Hub","Pillar Page (URL)","Supporting Collection Pages","Supporting Blog Pages","Authority Goal"]
write_headers(ws8, hdrs8, row=2)

clusters = [
    ["Seamless Bra Hub","/collections/seamless-bras","/collections/t-shirt-bras | /collections/wirefree-bras | /collections/padded-bras | /collections/bralettes | /collections/bandeau-bras","Best Seamless Bras India | Seamless vs T-Shirt Bra | How to Choose Seamless Bra | Seamless Bra Buying Guide","Own 'seamless bra' & all wire-free bra searches"],
    ["Sports Bra Hub","/collections/sports-bras","/collections/activewear | /collections/padded-bras","Best Sports Bras India | High vs Low Impact Sports Bra | Sports Bra Buying Guide | Sports Bra for Running India","Own all sports & gym bra searches"],
    ["Bra Size Hub","/blogs/how-to-measure-bra-size","/collections/padded-bras | /collections/full-coverage-bras | /collections/beginner-bras","Bra Size Chart India | Types of Bras | Sister Sizes Guide | Cup Size Guide | Plus Size Bra Guide | First Bra Guide","Own all bra sizing & fit searches"],
    ["Panty Guide Hub","/collections/panties","/collections/hipster-panties | /collections/high-waist-panties | /collections/bikini-panties | /collections/boyshort-panties","Types of Panties India | Hipster vs Bikini | Boyshort Guide | Best Panties Brand India | Period Panties Guide","Own all women's underwear searches"],
    ["Activewear Hub","/collections/activewear","/collections/sports-bras","Best Gym Wear Women India | Activewear Buying Guide | Gym Leggings vs Yoga Pants | How to Style Activewear","Own women's gym & yoga wear searches"],
    ["Women's Innerwear Hub","/","All category collection pages","Best Bra Brand India | Best Lingerie Brand India | Affordable Lingerie India | Amour Secret vs Clovia | Complete Bra Buying Guide","Own branded & category-level searches"],
    ["Push Up & Padded Bra Hub","/collections/push-up-bras","/collections/padded-bras | /collections/plunge-bras | /collections/wired-bras","Best Push Up Bra India | Push Up vs Padded Bra | Push Up Bra Buying Guide | Best Padded Bra India","Own all enhancement/lift bra searches"],
    ["Lingerie Sets Hub","/collections/bra-panty-sets","/collections/lace-bras | /collections/panties | /collections/bralettes","Best Bra Panty Set India | Lingerie Set Buying Guide | Lace Lingerie India","Own gift, occasion and matching set searches"],
]

for i, row in enumerate(clusters, 3):
    fill = ALT_FILL if i % 2 == 0 else WHITE_FILL
    write_row(ws8, row, i, fill)

set_col_widths(ws8, [24,34,60,70,40])
ws8.row_dimensions[2].height = 30
ws8.freeze_panes = "A3"
print("Sheet 8 done")

# ══════════════════════════════════════════════════════════════════════════════
# SHEET 9 — TECHNICAL SEO AUDIT
# ══════════════════════════════════════════════════════════════════════════════
ws9 = add_sheet("9. Technical SEO Audit")
title_row(ws9, "AMOUR SECRET — Technical SEO Audit & Fix Checklist", 6)
hdrs9 = ["Area","Issue / Check","Current Status","Recommended Fix","Priority","Effort"]
write_headers(ws9, hdrs9, row=2)

RED_FILL   = PatternFill("solid", fgColor="FFD7D7")
YLW_FILL   = PatternFill("solid", fgColor="FFF2CC")
GRN_FILL   = PatternFill("solid", fgColor="D9EAD3")

tech = [
    ["Indexability","Robots.txt present & correct","CHECK","Ensure all collection/product/blog pages are crawlable. Block /cart, /checkout, /account","P1","Low"],
    ["Indexability","XML Sitemap present & submitted","CHECK","Create sitemap with all category, product & blog URLs. Submit to GSC","P1","Low"],
    ["Indexability","Sitemap includes all key URLs","CHECK","Ensure 100% of collection & product pages are in sitemap","P1","Low"],
    ["Indexability","Google Search Console verified","CHECK","Verify property in GSC, monitor crawl errors weekly","P1","Low"],
    ["On-Page","Homepage Title Tag optimized","CHECK","Max 60 chars. Include primary keyword 'buy bra online India' or 'women innerwear'","P1","Low"],
    ["On-Page","All collection pages have unique meta titles","LIKELY MISSING","Add unique meta title + description to every collection page (23 pages)","P1","Medium"],
    ["On-Page","All collection pages have unique H1","LIKELY MISSING","Each collection page must have a unique keyword-rich H1","P1","Medium"],
    ["On-Page","Collection pages have descriptive content","LIKELY MISSING","Add 150-300 words of keyword-rich content above/below the product grid on every collection page","P1","Medium"],
    ["On-Page","Product pages have unique descriptions","LIKELY MISSING","Write unique product descriptions. Avoid duplicate/template text across variants","P1","High"],
    ["Schema Markup","Product schema on all product pages","LIKELY MISSING","Add Product schema: name, price, currency, availability, image, review","P1","Medium"],
    ["Schema Markup","BreadcrumbList schema","LIKELY MISSING","Add breadcrumb schema to all collection and product pages","P2","Low"],
    ["Schema Markup","Organization schema on homepage","LIKELY MISSING","Add Organization schema with logo, name, URL, social profiles","P2","Low"],
    ["Schema Markup","FAQPage schema on blog posts","LIKELY MISSING","Add FAQ schema to informational blog posts to capture featured snippets","P2","Medium"],
    ["Schema Markup","Article schema on blog posts","LIKELY MISSING","Add Article/BlogPosting schema with author, datePublished, image","P2","Low"],
    ["Core Web Vitals","LCP (Largest Contentful Paint) < 2.5s","CHECK","Optimize hero images: compress, use WebP format, lazy-load below fold","P1","Medium"],
    ["Core Web Vitals","CLS (Cumulative Layout Shift) < 0.1","CHECK","Define image dimensions in HTML. Avoid late-loading fonts causing layout shift","P1","Medium"],
    ["Core Web Vitals","FID / INP < 200ms","CHECK","Defer non-critical JS. Reduce third-party scripts","P2","High"],
    ["Core Web Vitals","Page speed mobile score > 70","CHECK","Run Google PageSpeed Insights on homepage + top 5 collection pages","P1","Medium"],
    ["Internal Linking","Homepage links to all key categories","LIKELY PARTIAL","Add visible links to all 23 category pages from homepage (nav + body)","P1","Low"],
    ["Internal Linking","Collection pages cross-link to related categories","LIKELY MISSING","Add 'Related Categories' section on every collection page","P1","Low"],
    ["Internal Linking","Blog posts link to relevant product pages","LIKELY MISSING","Every blog post must have 2-3 CTAs linking to relevant collection pages","P1","Low"],
    ["Internal Linking","Orphan pages exist","CHECK","Run crawl to find pages with 0 internal links pointing to them","P1","Medium"],
    ["Duplicate Content","Product variant URLs create duplicates","CHECK","Use canonical tags on product variant pages pointing to main product URL","P1","Low"],
    ["Duplicate Content","Collection pagination duplicates","CHECK","Add canonical on paginated pages (?page=2) pointing to page 1 OR use rel=next/prev","P1","Low"],
    ["Duplicate Content","Tag/search pages indexed","CHECK","Noindex /tags/ and /search? pages via robots.txt or meta robots","P1","Low"],
    ["Thin Content","Collection pages with < 3 products","CHECK","Merge thin collections or expand product range. Add category description copy","P2","Medium"],
    ["Thin Content","Blog posts under 800 words","CHECK","Audit all existing blogs. Expand thin posts to 800+ words with clear structure","P1","Medium"],
    ["URL Structure","URLs are clean and keyword-rich","CHECK","Ensure handle = primary keyword (e.g. /collections/seamless-bras not /collections/5678)","P1","Low"],
    ["Mobile","Site fully mobile responsive","CHECK","Test on mobile. Ensure CTAs, filters, product grids are usable on small screens","P1","Low"],
    ["Mobile","Mobile font size ≥ 16px","CHECK","Body text must be ≥ 16px on mobile to avoid pinch-zoom","P2","Low"],
    ["Faceted Navigation","Filter URLs crawlable/indexed","CHECK","Noindex faceted filter URLs (?size=, ?color=) to prevent duplicate content","P1","Low"],
    ["Images","Product images have alt text","LIKELY MISSING","Add descriptive alt text to all product images: '[Product Name] – [Color] – Amour Secret'","P1","Medium"],
    ["Images","Images compressed (WebP)","CHECK","Convert all product/category images to WebP. Target < 100KB per image","P1","High"],
    ["HTTPS","Site fully on HTTPS","CHECK","Verify no HTTP pages exist. Ensure HTTP auto-redirects to HTTPS","P1","Low"],
    ["Redirects","No broken 404 links","CHECK","Crawl site monthly for 404s. Set up 301 redirects for changed URLs","P1","Low"],
    ["Hreflang","International targeting if applicable","N/A","If adding regional languages (Hindi, Tamil etc.), add hreflang tags","P3","High"],
]

for i, row in enumerate(tech, 3):
    pri = row[4]
    if pri == "P1":
        fill = RED_FILL if row[2] == "LIKELY MISSING" else (ALT_FILL if i % 2 == 0 else WHITE_FILL)
    elif row[2] == "LIKELY MISSING":
        fill = YLW_FILL
    elif i % 2 == 0:
        fill = ALT_FILL
    else:
        fill = WHITE_FILL
    write_row(ws9, row, i, fill)

set_col_widths(ws9, [22,46,18,60,10,10])
ws9.row_dimensions[2].height = 30
ws9.freeze_panes = "A3"
ws9.auto_filter.ref = f"A2:F{len(tech)+2}"
print("Sheet 9 done")

# ══════════════════════════════════════════════════════════════════════════════
# SHEET 10 — QUICK WINS
# ══════════════════════════════════════════════════════════════════════════════
ws10 = add_sheet("10. Quick Wins")
title_row(ws10, "AMOUR SECRET — SEO Quick Wins (Do These First)", 6)
hdrs10 = ["#","Action","Impact","Effort","Est. Time","Expected Result"]
write_headers(ws10, hdrs10, row=2)

qw = [
    [1,"Add meta title + meta description to all 23 collection pages","HIGH","Low","2 hours","Better CTR in search results within 2-4 weeks"],
    [2,"Add H1 and 150-word category description to every collection page","HIGH","Low","3 hours","Keyword ranking improvement in 4-8 weeks"],
    [3,"Add alt text to all product images","HIGH","Low","2-3 hours","Image search traffic + accessibility compliance"],
    [4,"Submit XML sitemap to Google Search Console","HIGH","Low","30 mins","Faster indexing of all pages"],
    [5,"Add Product schema to top 20 product pages","HIGH","Medium","3-4 hours","Rich results (price, availability) in search — boosts CTR"],
    [6,"Add BreadcrumbList schema to collection + product pages","MEDIUM","Low","2 hours","Breadcrumbs in SERPs — improves CTR"],
    [7,"Create 'Related Categories' links on every collection page","HIGH","Low","2 hours","Better crawl depth + internal link equity distribution"],
    [8,"Write & publish 5 high-priority blog posts (Pillar content)","HIGH","High","2-3 weeks","Organic traffic from informational keywords in 8-12 weeks"],
    [9,"Compress all product images to WebP < 100KB","HIGH","Medium","1 day","Faster page load → better Core Web Vitals → ranking boost"],
    [10,"Noindex /tags/, /search, and filter URLs","MEDIUM","Low","30 mins","Eliminate duplicate content issues"],
    [11,"Add Organisation schema to homepage","MEDIUM","Low","1 hour","Brand Knowledge Panel + trust signals"],
    [12,"Add cross-sell 'Related Categories' widget on collection pages","HIGH","Medium","4 hours","Internal linking + lower bounce rate"],
    [13,"Create category description copy for top 5 highest-volume collections","HIGH","Low","4 hours","Ranking for head terms like 'sports bra', 'seamless bra'"],
    [14,"Build first 5 comparison articles (Amour Secret vs Clovia etc.)","HIGH","Medium","1 week","Brand search + commercial intent traffic"],
    [15,"Add FAQ section + FAQ schema to top 5 category pages","MEDIUM","Medium","3 hours","Featured snippet opportunities in Google"],
    [16,"Set up Google Search Console monitoring for top 20 keywords","HIGH","Low","1 hour","Track ranking progress and identify opportunities"],
    [17,"Fix any broken internal links (404s)","HIGH","Low","1-2 hours","Clean crawl + preserve link equity"],
    [18,"Add canonical tags to product variant pages","MEDIUM","Low","1 hour","Prevent duplicate content penalties"],
    [19,"Create 'Bra Size Guide' landing page (pillar content)","HIGH","High","1 week","Own 40K/mo 'bra size' search cluster"],
    [20,"Add customer reviews section to product pages","HIGH","Medium","2-3 hours","Social proof + keyword-rich UGC content → ranking boost"],
]

for i, row in enumerate(qw, 3):
    fill = RED_FILL if row[2] == "HIGH" else (YLW_FILL if row[2] == "MEDIUM" else (ALT_FILL if i % 2 == 0 else WHITE_FILL))
    write_row(ws10, row, i, fill)

set_col_widths(ws10, [5,52,12,12,14,52])
ws10.row_dimensions[2].height = 30
ws10.freeze_panes = "A3"
print("Sheet 10 done")

# ══════════════════════════════════════════════════════════════════════════════
# SHEET 11 — 12-MONTH SEO ROADMAP
# ══════════════════════════════════════════════════════════════════════════════
ws11 = add_sheet("11. 12-Month Roadmap")
title_row(ws11, "AMOUR SECRET — 12-Month SEO Execution Roadmap", 5)
hdrs11 = ["Month","Phase","Key Actions","KPIs to Track","Expected Outcome"]
write_headers(ws11, hdrs11, row=2)

roadmap = [
    ["Month 1","Foundation & Technical","1. Audit + fix all meta titles & descriptions (23 collections)\n2. Add H1 + category copy to all collection pages\n3. Submit sitemap to GSC\n4. Add alt text to all product images\n5. Add Product + Breadcrumb schema to top 10 products\n6. Set up GSC + GA4 tracking","Indexed pages | GSC coverage errors | Page speed score","Clean technical foundation. All pages indexable & optimised"],
    ["Month 2","Technical + On-Page","1. Add Product schema to remaining products\n2. Compress all images to WebP\n3. Noindex filter/tag/search URLs\n4. Add Organisation schema to homepage\n5. Fix all 404s + redirect broken links\n6. Add internal 'Related Categories' links to all collection pages","Core Web Vitals scores | 404 errors | Crawl coverage","Improved crawl efficiency. LCP/CLS improved. No duplicate content"],
    ["Month 3","Content – Pillar Launch","1. Publish Bra Size Guide (pillar)\n2. Publish Types of Bras Guide (pillar)\n3. Publish Panty Guide (pillar)\n4. Add FAQ + FAQ schema to top 5 collections\n5. Build internal links from all blogs to collections","Organic clicks | Ranking positions for pillar keywords | Time on page","First organic traffic from informational keywords. Topical authority building"],
    ["Month 4","Content – Blog Sprint 1","1. Publish 8 informational blogs (bra fit, washing, saree bra etc.)\n2. Publish 4 commercial blogs (best sports bra India etc.)\n3. Begin adding cross-sell product widgets to collection pages","Blog organic traffic | Keyword rankings for target blog terms","20-30 articles live. Starting to rank for long-tail informational terms"],
    ["Month 5","Content – Blog Sprint 2","1. Publish 8 more informational blogs\n2. Publish 4 comparison articles (vs Clovia, vs Zivame)\n3. Start Sports Bra Hub: publish all sports bra cluster content\n4. Add CTA links in all published blogs → collection pages","Comparison keyword rankings | Blog CTR | Collection page traffic from blogs","Comparison articles driving branded search + awareness"],
    ["Month 6","Category Expansion","1. Create 5 new missing categories (minimiser, maternity, thong, period panties, cotton bras)\n2. Add meta titles, H1, copy to all new pages\n3. Add new pages to sitemap + internal links\n4. Publish 6 buying guides","New category impressions in GSC | Traffic to new category pages","5 new high-volume categories indexed and starting to rank"],
    ["Month 7","Content – Blog Sprint 3","1. Publish 10 buying guides (bra buying guide, sports bra guide etc.)\n2. Build Panty Guide Hub: all panty cluster content live\n3. Optimize top 10 product pages with expanded descriptions\n4. Add video content plan for bra sizing (YouTube + on-site)","Buying guide rankings | Time on page | Conversion from blog to collection","Buying guides driving high commercial intent traffic"],
    ["Month 8","Link Building + PR","1. Outreach: get featured on 5 Indian fashion/lifestyle blogs\n2. Submit to Google Discover feed via structured content\n3. Build 10 high-quality backlinks from fashion/lifestyle sites\n4. Guest post on 2 relevant blogs with link back to Amour Secret","Domain Rating (Ahrefs) | Backlinks acquired | Referral traffic","First external backlinks. Domain authority starts building"],
    ["Month 9","Content – Blog Sprint 4 + Optimise","1. Publish 8 more articles completing 100-article milestone\n2. Audit + update Month 1-3 articles with fresh data & internal links\n3. Add more FAQ schema to blog content\n4. A/B test collection page descriptions","Organic traffic MoM growth | Rankings for head terms | CTR in GSC","100 articles milestone reached. Existing content refreshed for ranking"],
    ["Month 10","Conversion Optimisation","1. Add 'Complete the Look' cross-sell on all product pages\n2. Add customer review widgets (UGC content boost)\n3. Implement size guide pop-up on collection pages\n4. Add recently viewed + related products sections","Conversion rate | AOV (Average Order Value) | Bounce rate","Higher conversion rate from organic traffic. AOV increase"],
    ["Month 11","Scale & Expand","1. Launch Plus Size Bras + Shapewear category (high volume)\n2. Publish 20 more articles targeting new category keywords\n3. Build dedicated Activewear Hub content cluster\n4. Outreach for 10 more backlinks","Organic traffic | New keyword rankings | Revenue from organic","New high-volume categories driving incremental traffic"],
    ["Month 12","Review & Roadmap Year 2","1. Full SEO audit: compare Month 1 vs Month 12 rankings\n2. Identify top performing content – double down\n3. Identify gaps – plan Year 2 content calendar\n4. Build 300-article Year 2 plan\n5. Consider Hindi/regional language SEO expansion","Total organic sessions | Revenue from organic | Domain Authority | # of keywords ranking top 10","Clear data on ROI. Year 2 strategy ready. Sustainable organic growth channel established"],
]

for i, row in enumerate(roadmap, 3):
    fills = [ALT_FILL, WHITE_FILL]
    write_row(ws11, row, i, fills[(i-3) % 2])
    ws11.row_dimensions[i].height = 80

set_col_widths(ws11, [10,18,70,40,44])
ws11.row_dimensions[2].height = 30
ws11.freeze_panes = "A3"
print("Sheet 11 done")

# ══════════════════════════════════════════════════════════════════════════════
# Save
# ══════════════════════════════════════════════════════════════════════════════
output_path = "/home/user/teambharat/Amour_Secret_SEO_Workbook.xlsx"
wb.save(output_path)
print(f"Saved: {output_path}")
