from docx import Document
from docx.shared import Pt, RGBColor, Inches, Cm
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_ALIGN_VERTICAL
from docx.oxml.ns import qn
from docx.oxml import OxmlElement
import copy

doc = Document()

# ── Page margins ────────────────────────────────────────────────────────────
for section in doc.sections:
    section.top_margin    = Cm(2.0)
    section.bottom_margin = Cm(2.0)
    section.left_margin   = Cm(2.5)
    section.right_margin  = Cm(2.5)

# ── Color palette ────────────────────────────────────────────────────────────
BLUE   = RGBColor(0x1D, 0x9B, 0xF0)
BLACK  = RGBColor(0x0A, 0x0A, 0x0A)
GRAY   = RGBColor(0x6B, 0x72, 0x80)
WHITE  = RGBColor(0xFF, 0xFF, 0xFF)
GREEN  = RGBColor(0x10, 0xB9, 0x81)
ORANGE = RGBColor(0xF5, 0x9E, 0x0B)
PURPLE = RGBColor(0x8B, 0x5C, 0xF6)
LIGHT_BLUE_BG = RGBColor(0xE8, 0xF4, 0xFD)
DARK_BG  = RGBColor(0x0A, 0x0A, 0x0A)

# ── Helpers ──────────────────────────────────────────────────────────────────
def set_cell_bg(cell, hex_color: str):
    tc   = cell._tc
    tcPr = tc.get_or_add_tcPr()
    shd  = OxmlElement('w:shd')
    shd.set(qn('w:val'),   'clear')
    shd.set(qn('w:color'), 'auto')
    shd.set(qn('w:fill'),  hex_color)
    tcPr.append(shd)

def set_cell_borders(cell, color='D1D5DB', sz=4):
    tc   = cell._tc
    tcPr = tc.get_or_add_tcPr()
    tcBorders = OxmlElement('w:tcBorders')
    for side in ('top', 'left', 'bottom', 'right'):
        b = OxmlElement(f'w:{side}')
        b.set(qn('w:val'),   'single')
        b.set(qn('w:sz'),    str(sz))
        b.set(qn('w:color'), color)
        tcBorders.append(b)
    tcPr.append(tcBorders)

def add_heading(text, level=1, color=None, space_before=18, space_after=8):
    p   = doc.add_paragraph()
    run = p.add_run(text)
    run.bold = True
    if level == 1:
        run.font.size = Pt(22)
    elif level == 2:
        run.font.size = Pt(16)
    else:
        run.font.size = Pt(13)
    run.font.color.rgb = color or BLACK
    pf = p.paragraph_format
    pf.space_before = Pt(space_before)
    pf.space_after  = Pt(space_after)
    return p

def add_label(text):
    p   = doc.add_paragraph()
    run = p.add_run(text.upper())
    run.font.size  = Pt(9)
    run.font.color.rgb = BLUE
    run.bold = True
    p.paragraph_format.space_before = Pt(16)
    p.paragraph_format.space_after  = Pt(2)

def add_body(text, italic=False, color=None):
    p   = doc.add_paragraph()
    run = p.add_run(text)
    run.font.size  = Pt(11)
    run.font.color.rgb = color or GRAY
    run.italic = italic
    p.paragraph_format.space_after = Pt(6)
    return p

def add_bullet(text, bold_prefix=None):
    p = doc.add_paragraph(style='List Bullet')
    if bold_prefix:
        r = p.add_run(bold_prefix)
        r.bold = True
        r.font.size = Pt(11)
    r2 = p.add_run(text)
    r2.font.size = Pt(11)
    r2.font.color.rgb = GRAY

def add_hr():
    p  = doc.add_paragraph()
    pf = p.paragraph_format
    pf.space_before = Pt(4)
    pf.space_after  = Pt(4)
    pPr = p._p.get_or_add_pPr()
    pBdr = OxmlElement('w:pBdr')
    bottom = OxmlElement('w:bottom')
    bottom.set(qn('w:val'),   'single')
    bottom.set(qn('w:sz'),    '6')
    bottom.set(qn('w:color'), '1D9BF0')
    pBdr.append(bottom)
    pPr.append(pBdr)

def add_info_box(text, bg='E8F4FD', text_color=BLUE):
    tbl = doc.add_table(rows=1, cols=1)
    tbl.style = 'Table Grid'
    cell = tbl.cell(0, 0)
    set_cell_bg(cell, bg)
    cell.width = Inches(6)
    p   = cell.paragraphs[0]
    run = p.add_run(text)
    run.font.size  = Pt(10.5)
    run.font.color.rgb = text_color
    p.paragraph_format.space_before = Pt(6)
    p.paragraph_format.space_after  = Pt(6)
    doc.add_paragraph()

# ═══════════════════════════════════════════════════════════════════════════
# COVER PAGE
# ═══════════════════════════════════════════════════════════════════════════
cover_tbl = doc.add_table(rows=1, cols=1)
cover_tbl.style = 'Table Grid'
cover_cell = cover_tbl.cell(0, 0)
set_cell_bg(cover_cell, '0A0A2E')

p = cover_cell.paragraphs[0]
p.alignment = WD_ALIGN_PARAGRAPH.CENTER
run = p.add_run('\nOFFICIAL MARKETING PROPOSAL\n')
run.font.size  = Pt(10)
run.font.color.rgb = BLUE
run.bold = True

p2 = cover_cell.add_paragraph()
p2.alignment = WD_ALIGN_PARAGRAPH.CENTER
r2 = p2.add_run('Twitter / X Hashtag Trending\nMarketing Plan')
r2.font.size  = Pt(26)
r2.font.color.rgb = WHITE
r2.bold = True

p3 = cover_cell.add_paragraph()
p3.alignment = WD_ALIGN_PARAGRAPH.CENTER
r3 = p3.add_run('\nfor  evryvn.com  — Tech & Startup Brand\n')
r3.font.size  = Pt(13)
r3.font.color.rgb = RGBColor(0xB0, 0xC8, 0xFF)

p4 = cover_cell.add_paragraph()
p4.alignment = WD_ALIGN_PARAGRAPH.CENTER
r4 = p4.add_run(
    '\nPrepared by: Team Bharat\nPlatform: X (Twitter)\nDate: May 2026\nProposal ID: TB-X-EVRYVN-2026-05\n'
)
r4.font.size  = Pt(11)
r4.font.color.rgb = RGBColor(0xAA, 0xAA, 0xAA)

for para in cover_cell.paragraphs:
    para.paragraph_format.space_before = Pt(6)
    para.paragraph_format.space_after  = Pt(6)

doc.add_page_break()

# ═══════════════════════════════════════════════════════════════════════════
# 01 — EXECUTIVE SUMMARY
# ═══════════════════════════════════════════════════════════════════════════
add_label('01 · Overview')
add_heading('Executive Summary')
add_hr()
add_body(
    'X (formerly Twitter) remains the #1 platform for tech, startup, and developer communities. '
    'A strategically trending hashtag can put evryvn.com in front of millions of potential users, '
    'investors, and press in a matter of hours. This proposal outlines a full-service Twitter/X '
    'hashtag trending campaign designed specifically for evryvn.com.'
)

# Key stats table
stats_tbl = doc.add_table(rows=2, cols=4)
stats_tbl.style = 'Table Grid'
headers = ['500M+', '350M+', '#1', '6×']
labels  = ['Monthly active X users', 'Tweets sent daily', 'Platform for tech talk', 'More reach w/ trending']
for i, (h, l) in enumerate(zip(headers, labels)):
    c = stats_tbl.cell(0, i)
    set_cell_bg(c, '1D9BF0')
    p  = c.paragraphs[0]
    p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    r  = p.add_run(h)
    r.font.size  = Pt(20)
    r.font.color.rgb = WHITE
    r.bold = True

    c2 = stats_tbl.cell(1, i)
    set_cell_bg(c2, 'E8F4FD')
    p2 = c2.paragraphs[0]
    p2.alignment = WD_ALIGN_PARAGRAPH.CENTER
    r2 = p2.add_run(l)
    r2.font.size  = Pt(9)
    r2.font.color.rgb = RGBColor(0x1E, 0x40, 0xAF)

doc.add_paragraph()
add_info_box(
    '📌  KEY GOAL: Make #evryvn and related branded/industry hashtags visible in the Trending Topics '
    'section across India, USA, UK, and global tech audiences — generating organic reach, impressions, '
    'and website traffic.',
    bg='E8F4FD'
)

# ═══════════════════════════════════════════════════════════════════════════
# 02 — HOW IT WORKS
# ═══════════════════════════════════════════════════════════════════════════
add_label('02 · Education')
add_heading('What is Twitter Hashtag Trending & How It Works')
add_hr()
add_body('Understanding the mechanics behind trending — and why it\'s the most powerful organic amplification tool on X.')

steps = [
    ('Step 1 — Hashtag Selection & Research',
     'We identify high-potential hashtags using Twitter\'s own trend data, third-party tools '
     '(Hashtagify, Brand24, TweetDeck), and competitor analysis. We target branded hashtags '
     '(e.g. #evryvn), niche tech hashtags (e.g. #TechStartup, #BuildInPublic), and moment-based '
     'tags tied to industry events.'),
    ('Step 2 — Content Calendar & Tweet Scripting',
     'We design a daily/weekly content calendar with professionally crafted tweets, threads, polls, '
     'and reply-chain content. Each piece is optimised to include the target hashtag naturally, '
     'encouraging retweets and quote-tweets which signal volume to Twitter\'s algorithm.'),
    ('Step 3 — Influencer & Community Activation',
     'We mobilise a vetted network of tech micro-influencers, startup community accounts, and '
     'developer Twitter users to simultaneously tweet with the target hashtag. A coordinated spike '
     'in tweet volume over 1–2 hours triggers Twitter\'s trending algorithm.'),
    ('Step 4 — Algorithm Trigger & Trending Placement',
     'Twitter\'s trending algorithm ranks hashtags based on tweet volume velocity (rapid spike), '
     'unique user count, engagement (likes, RTs, replies), and geographic concentration. When the '
     'coordinated push crosses the threshold, your hashtag appears in "Trending".'),
    ('Step 5 — Live Monitoring & Real-Time Engagement',
     'Our social media team monitors the campaign in real time — responding to tweets, retweeting '
     'quality content, and keeping the conversation alive to sustain trending status and maximise '
     'the traffic window.'),
    ('Step 6 — Post-Campaign Analytics & Reporting',
     'Full performance report: total impressions, reach, engagement rate, website traffic spike '
     '(via UTM), influencer performance breakdown, and trending rank achieved.'),
]

for title, body in steps:
    p   = doc.add_paragraph()
    run = p.add_run(f'  {title}')
    run.bold = True
    run.font.size  = Pt(11.5)
    run.font.color.rgb = BLACK
    p.paragraph_format.space_before = Pt(10)
    p.paragraph_format.space_after  = Pt(2)
    add_body(f'    {body}')

# ═══════════════════════════════════════════════════════════════════════════
# 03 — HASHTAG STRATEGY
# ═══════════════════════════════════════════════════════════════════════════
doc.add_page_break()
add_label('03 · Strategy')
add_heading('Recommended Hashtag Pillars for evryvn.com')
add_hr()
add_body('We organise hashtags into six content pillars — each serving a different audience segment and campaign goal.')

pillars = [
    ('BRANDED',          '1D9BF0', '#evryvn  #evryvnapp  #TeamEvryvn  #evryvntech'),
    ('STARTUP CULTURE',  '8B5CF6', '#BuildInPublic  #StartupLife  #StartupIndia  #Founder  #YCombinator'),
    ('TECH & DEV',       '10B981', '#TechStartup  #SaaS  #NoCode  #DevTwitter  #100DaysOfCode'),
    ('GROWTH & MARKETING','F59E0B','#GrowthHacking  #ProductLaunch  #Indiehackers  #DigitalMarketing'),
    ('AI / INNOVATION',  'EF4444', '#AI  #ArtificialIntelligence  #FutureOfWork  #AIStartup'),
    ('COMMUNITY',        '374151', '#TechCommunity  #MadeInIndia  #StartupEcosystem  #VentureCapital'),
]

ht_tbl = doc.add_table(rows=len(pillars), cols=2)
ht_tbl.style = 'Table Grid'
for row_idx, (label, color, tags) in enumerate(pillars):
    c1 = ht_tbl.cell(row_idx, 0)
    c2 = ht_tbl.cell(row_idx, 1)
    set_cell_bg(c1, color)
    set_cell_bg(c2, color)
    p1 = c1.paragraphs[0]
    r1 = p1.add_run(label)
    r1.font.size  = Pt(10)
    r1.font.color.rgb = WHITE
    r1.bold = True
    p2 = c2.paragraphs[0]
    r2 = p2.add_run(tags)
    r2.font.size  = Pt(10)
    r2.font.color.rgb = WHITE
    for cell in (c1, c2):
        cell.paragraphs[0].paragraph_format.space_before = Pt(6)
        cell.paragraphs[0].paragraph_format.space_after  = Pt(6)

doc.add_paragraph()
add_info_box(
    '⚡  TRENDING CAMPAIGN FOCUS: The primary hashtags pushed for Trending placement will be '
    '#evryvn and #BuildInPublic combined with a campaign-specific hashtag '
    '(e.g. #evryvnLaunch or #evryvnxTech) to create a unique, trackable trending moment.',
    bg='FFF8E1', text_color=RGBColor(0x92, 0x40, 0x0E)
)

# ═══════════════════════════════════════════════════════════════════════════
# 04 — DELIVERABLES
# ═══════════════════════════════════════════════════════════════════════════
add_label('04 · Deliverables')
add_heading('What We Deliver')
add_hr()

deliverables = [
    ('🔍  Hashtag Audit & Strategy',       'Deep-dive research into trending tech hashtags, competitor analysis, and custom hashtag roadmap for evryvn.com.'),
    ('✍️  Content Creation',               'Professionally written tweets, Twitter threads, polls, and reply-bait posts — all branded for evryvn.com.'),
    ('🤝  Influencer Network',             'Activation of 20–100+ vetted tech/startup micro-influencers (5K–500K followers) to amplify your hashtag.'),
    ('📅  Content Calendar',               'Month-long scheduled content plan with optimal posting times based on your target audience\'s peak hours.'),
    ('📡  Live Campaign Management',        'Real-time monitoring and engagement during campaign execution windows to sustain trending momentum.'),
    ('📊  Analytics Report',               'Post-campaign PDF report with impressions, reach, engagement rate, trending rank, and website traffic data.'),
]

for title, desc in deliverables:
    add_bullet(f'{desc}', bold_prefix=f'{title} — ')

# ═══════════════════════════════════════════════════════════════════════════
# 05 — PACKAGES & PRICING
# ═══════════════════════════════════════════════════════════════════════════
doc.add_page_break()
add_label('05 · Pricing')
add_heading('Service Packages & Charges')
add_hr()
add_body('Three transparent, fixed-price packages. All prices in Indian Rupees (INR). No hidden fees.')

packages = [
    {
        'name': 'STARTER',
        'price': '₹25,000',
        'period': 'One-Time Campaign (1 month)',
        'color': '1D9BF0',
        'features': [
            '✓ Hashtag audit & research',
            '✓ 2 trending campaign pushes',
            '✓ 20 influencer activations',
            '✓ 30 branded tweets written',
            '✓ 1 Twitter thread',
            '✓ India regional trending target',
            '✓ 1 post-campaign report',
            '✗ Global trending push',
            '✗ Dedicated account manager',
            '✗ Twitter Spaces session',
        ]
    },
    {
        'name': 'GROWTH  ⭐ Most Popular',
        'price': '₹55,000/mo',
        'period': 'Monthly Retainer (3-month min.)',
        'color': '0D6EFD',
        'features': [
            '✓ Full hashtag strategy & calendar',
            '✓ 4 trending campaign pushes/month',
            '✓ 50 influencer activations/push',
            '✓ 60 branded tweets per month',
            '✓ 4 Twitter threads per month',
            '✓ India + UAE + UK trending targets',
            '✓ Weekly performance reports',
            '✓ 1 Twitter Spaces per month',
            '✓ Dedicated account manager',
            '✗ USA/Global trending push',
        ]
    },
    {
        'name': 'ENTERPRISE',
        'price': '₹1,20,000/mo',
        'period': 'Monthly Retainer (6-month min.)',
        'color': '374151',
        'features': [
            '✓ Everything in Growth',
            '✓ 8 trending campaign pushes/month',
            '✓ 100+ influencer activations/push',
            '✓ Unlimited tweet & thread creation',
            '✓ USA, UK, India, Global targets',
            '✓ Daily performance dashboard',
            '✓ 2 Twitter Spaces per month',
            '✓ Senior strategist assigned',
            '✓ Press release integration',
            '✓ Competitor tracking',
        ]
    },
]

for pkg in packages:
    # Package header
    pkg_tbl = doc.add_table(rows=1, cols=1)
    pkg_tbl.style = 'Table Grid'
    hdr_cell = pkg_tbl.cell(0, 0)
    set_cell_bg(hdr_cell, pkg['color'])
    ph = hdr_cell.paragraphs[0]
    ph.alignment = WD_ALIGN_PARAGRAPH.CENTER
    r_name  = ph.add_run(f"{pkg['name']}  |  {pkg['price']}")
    r_name.font.size = Pt(13)
    r_name.font.color.rgb = WHITE
    r_name.bold = True
    ph.paragraph_format.space_before = Pt(6)
    ph.paragraph_format.space_after  = Pt(2)

    p_period = hdr_cell.add_paragraph()
    p_period.alignment = WD_ALIGN_PARAGRAPH.CENTER
    r_p = p_period.add_run(pkg['period'])
    r_p.font.size = Pt(10)
    r_p.font.color.rgb = RGBColor(0xDD, 0xEE, 0xFF)
    p_period.paragraph_format.space_after = Pt(6)

    # Features
    feat_tbl = doc.add_table(rows=len(pkg['features']), cols=1)
    feat_tbl.style = 'Table Grid'
    for fi, feat in enumerate(pkg['features']):
        cell = feat_tbl.cell(fi, 0)
        bg = 'F3F4F6' if fi % 2 == 0 else 'FFFFFF'
        set_cell_bg(cell, bg)
        p = cell.paragraphs[0]
        is_yes = feat.startswith('✓')
        r = p.add_run(feat)
        r.font.size = Pt(10.5)
        r.font.color.rgb = GREEN if is_yes else RGBColor(0xD1, 0xD5, 0xDB)
        r.bold = is_yes
        p.paragraph_format.space_before = Pt(3)
        p.paragraph_format.space_after  = Pt(3)

    doc.add_paragraph()

# Add-ons
add_info_box(
    '💡  ADD-ONS AVAILABLE:\n'
    '• Twitter/X Paid Promotion Boost  +₹15,000\n'
    '• Additional Trending Push  +₹8,000/push\n'
    '• Multilingual Tweet Pack (Hindi + English)  +₹5,000/month\n'
    '• Extra Twitter Spaces session  +₹6,000/session',
    bg='E8F4FD'
)

# ── Comparison Table ─────────────────────────────────────────────────────────
doc.add_page_break()
add_label('Comparison')
add_heading('Package Comparison at a Glance', level=2)

cmp_headers = ['Feature', 'Starter\n₹25,000', 'Growth\n₹55,000/mo', 'Enterprise\n₹1,20,000/mo']
cmp_rows = [
    ['Hashtag Research & Strategy',       'Basic',    'Advanced',   'Full'],
    ['Trending Pushes per Month',          '2',        '4',          '8'],
    ['Influencer Activations per Push',    '20',       '50',         '100+'],
    ['Tweets Created per Month',           '30',       '60',         'Unlimited'],
    ['Twitter Threads',                    '1',        '4',          'Unlimited'],
    ['Target Geographies',                 'India',    'India+UAE+UK','Global'],
    ['Twitter Spaces',                     '✗',        '1/month',    '2/month'],
    ['Dedicated Account Manager',          '✗',        '✓',          '✓ Senior'],
    ['Performance Reports',                'Post-campaign','Weekly', 'Daily Dashboard'],
    ['Press Release Integration',          '✗',        '✗',          '✓'],
    ['Competitor Tracking',                '✗',        '✗',          '✓'],
    ['Minimum Commitment',                 '1 month',  '3 months',   '6 months'],
]

cmp_tbl = doc.add_table(rows=1 + len(cmp_rows), cols=4)
cmp_tbl.style = 'Table Grid'

for ci, hdr in enumerate(cmp_headers):
    c = cmp_tbl.cell(0, ci)
    set_cell_bg(c, '0A0A2E')
    p = c.paragraphs[0]
    p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    r = p.add_run(hdr)
    r.font.size = Pt(10)
    r.font.color.rgb = WHITE
    r.bold = True
    p.paragraph_format.space_before = Pt(4)
    p.paragraph_format.space_after  = Pt(4)

for ri, row in enumerate(cmp_rows):
    bg = 'F3F4F6' if ri % 2 == 0 else 'FFFFFF'
    for ci, val in enumerate(row):
        c = cmp_tbl.cell(ri + 1, ci)
        set_cell_bg(c, bg)
        p = c.paragraphs[0]
        r = p.add_run(val)
        r.font.size = Pt(10)
        if ci == 0:
            r.bold = True
            r.font.color.rgb = BLACK
        elif val in ('✓', '✓ Senior'):
            r.font.color.rgb = GREEN
        elif val == '✗':
            r.font.color.rgb = RGBColor(0xD1, 0xD5, 0xDB)
        else:
            r.font.color.rgb = GRAY
        p.paragraph_format.space_before = Pt(3)
        p.paragraph_format.space_after  = Pt(3)

doc.add_paragraph()

# ═══════════════════════════════════════════════════════════════════════════
# 06 — TIMELINE
# ═══════════════════════════════════════════════════════════════════════════
doc.add_page_break()
add_label('06 · Timeline')
add_heading('Campaign Execution Timeline')
add_hr()
add_body('A clear week-by-week breakdown using the Growth package as an example.')

timeline = [
    ('Week 1 — Onboarding & Research',
     'Discovery & Strategy Setup',
     'Brand intake call, access setup, deep hashtag research, competitor audit, and '
     'finalisation of the monthly content calendar and hashtag list. Influencer shortlist shared for approval.'),
    ('Week 2 — Content Production',
     'Content Creation & Approval',
     'All tweets, threads, and campaign-specific content are written, designed (visuals if needed), '
     'and sent for client approval. Influencer briefs distributed to the activation network.'),
    ('Week 2–3 — Campaign Launch',
     'First Trending Push Executed',
     'Coordinated activation begins. Influencers post simultaneously. Our team engages in real time. '
     'Campaign window: 2–3 hours of peak activity. Live trending rank screenshots captured.'),
    ('Week 3–4 — Ongoing Content',
     'Daily Posting & Community Management',
     'Scheduled organic tweets go live daily. Replies and mentions managed. Second trending push '
     'executed mid-month. Weekly report shared with client.'),
    ('End of Month — Review',
     'Full Performance Report & Strategy Review',
     'Comprehensive analytics report delivered. Strategy call to review results, adjust hashtag mix, '
     'and plan the next month\'s campaign based on data.'),
]

for week, title, detail in timeline:
    tl_tbl = doc.add_table(rows=1, cols=2)
    tl_tbl.style = 'Table Grid'
    tl_tbl.columns[0].width = Inches(1.5)

    c_week = tl_tbl.cell(0, 0)
    set_cell_bg(c_week, '1D9BF0')
    pw = c_week.paragraphs[0]
    pw.alignment = WD_ALIGN_PARAGRAPH.CENTER
    rw = pw.add_run(week)
    rw.font.size = Pt(9)
    rw.font.color.rgb = WHITE
    rw.bold = True
    pw.paragraph_format.space_before = Pt(6)
    pw.paragraph_format.space_after  = Pt(6)

    c_body = tl_tbl.cell(0, 1)
    set_cell_bg(c_body, 'F8FAFC')
    pb = c_body.paragraphs[0]
    rb_title = pb.add_run(f'{title}\n')
    rb_title.bold = True
    rb_title.font.size = Pt(11)
    rb_title.font.color.rgb = BLACK
    rb_detail = pb.add_run(detail)
    rb_detail.font.size = Pt(10)
    rb_detail.font.color.rgb = GRAY
    pb.paragraph_format.space_before = Pt(6)
    pb.paragraph_format.space_after  = Pt(6)

    doc.add_paragraph()

# ═══════════════════════════════════════════════════════════════════════════
# 07 — EXPECTED RESULTS
# ═══════════════════════════════════════════════════════════════════════════
add_label('07 · Expected Results')
add_heading('What You Can Expect')
add_hr()

results_tbl = doc.add_table(rows=2, cols=3)
results_tbl.style = 'Table Grid'
result_data = [
    ('2M+',    'Impressions per trending push'),
    ('Top 10', 'Trending rank (regional)'),
    ('300%',   'Website traffic spike on campaign day'),
    ('5K+',    'New followers per month (Growth)'),
    ('8–12%',  'Avg. engagement rate'),
    ('48hrs',  'Trend longevity (organic continuation)'),
]
for i, (num, label) in enumerate(result_data):
    r, c = divmod(i, 3)
    cell = results_tbl.cell(r, c)
    set_cell_bg(cell, 'E8F4FD' if r == 0 else 'F3F4F6')
    p = cell.paragraphs[0]
    p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    rn = p.add_run(f'{num}\n')
    rn.font.size = Pt(20)
    rn.font.color.rgb = BLUE
    rn.bold = True
    rl = p.add_run(label)
    rl.font.size = Pt(9)
    rl.font.color.rgb = GRAY
    p.paragraph_format.space_before = Pt(8)
    p.paragraph_format.space_after  = Pt(8)

doc.add_paragraph()
add_info_box(
    '⚠️  DISCLAIMER: Results vary based on platform competition, brand strength, and content quality. '
    'Figures above represent average outcomes from similar campaigns. We do not guarantee specific '
    'trending positions but commit to maximum effort and transparent reporting on all campaigns.',
    bg='FFFBEB', text_color=RGBColor(0x92, 0x40, 0x0E)
)

# ═══════════════════════════════════════════════════════════════════════════
# 08 — TERMS & CONDITIONS
# ═══════════════════════════════════════════════════════════════════════════
doc.add_page_break()
add_label('08 · Terms')
add_heading('Terms & Conditions')
add_hr()

terms = [
    ('💳  Payment Terms',
     '50% advance before campaign kickoff. Remaining 50% due within 7 days of campaign completion. '
     'Monthly retainers billed on the 1st of each month.'),
    ('🔄  Revisions',
     'Up to 2 rounds of revisions on all content before scheduling. Additional revisions billed at '
     '₹500 per tweet or ₹2,000 per thread.'),
    ('📋  Client Responsibilities',
     'Client must provide brand assets, approve content within 48 hours of submission, and grant '
     'Twitter analytics read access for reporting.'),
    ('🚫  Cancellation Policy',
     '30-day written notice required for cancellation of retainer packages. Work completed in the '
     'final month is fully billable. Advance payments are non-refundable.'),
    ('🔒  Confidentiality',
     'All campaign strategies, hashtag lists, influencer networks, and client data remain strictly '
     'confidential. NDAs available on request.'),
    ('📞  Communication',
     'Dedicated WhatsApp group for each client. Response within 4 business hours. Monthly strategy '
     'calls included in all packages.'),
]

for title, body in terms:
    tc_tbl = doc.add_table(rows=1, cols=1)
    tc_tbl.style = 'Table Grid'
    tc_cell = tc_tbl.cell(0, 0)
    set_cell_bg(tc_cell, 'F8FAFC')
    p = tc_cell.paragraphs[0]
    r_title = p.add_run(f'{title}\n')
    r_title.bold = True
    r_title.font.size = Pt(11.5)
    r_title.font.color.rgb = BLACK
    r_body = p.add_run(body)
    r_body.font.size = Pt(10.5)
    r_body.font.color.rgb = GRAY
    p.paragraph_format.space_before = Pt(8)
    p.paragraph_format.space_after  = Pt(8)
    doc.add_paragraph()

# ═══════════════════════════════════════════════════════════════════════════
# 09 — WHY TEAM BHARAT
# ═══════════════════════════════════════════════════════════════════════════
add_label('09 · Why Us')
add_heading('Why Choose Team Bharat')
add_hr()

why_items = [
    ('🏆  Tech-Niche Specialists',
     'We focus exclusively on tech, SaaS, and startup brands — our influencer network and content '
     'team speaks your audience\'s language.'),
    ('🌐  Multi-Region Reach',
     'Active influencer network across India, UAE, UK, and USA for coordinated global trending pushes.'),
    ('📈  Data-Driven Approach',
     'Every decision — hashtag choice, posting time, influencer selection — is backed by real-time '
     'data and platform analytics.'),
    ('⚡  Rapid Execution',
     'Fully operational within 7 days of contract signing. Campaign live within 14 days.'),
]

for title, body in why_items:
    add_bullet(f'{body}', bold_prefix=f'{title} — ')

# ═══════════════════════════════════════════════════════════════════════════
# CLOSING / SIGNATURE
# ═══════════════════════════════════════════════════════════════════════════
doc.add_page_break()
close_tbl = doc.add_table(rows=1, cols=1)
close_tbl.style = 'Table Grid'
close_cell = close_tbl.cell(0, 0)
set_cell_bg(close_cell, '0A0A2E')

pc1 = close_cell.paragraphs[0]
pc1.alignment = WD_ALIGN_PARAGRAPH.CENTER
rc1 = pc1.add_run('\nReady to Make evryvn.com Trend?')
rc1.font.size = Pt(22)
rc1.font.color.rgb = WHITE
rc1.bold = True

pc2 = close_cell.add_paragraph()
pc2.alignment = WD_ALIGN_PARAGRAPH.CENTER
rc2 = pc2.add_run(
    "\nLet's build your brand's presence at the top of Twitter's trending page.\n"
    "Reach out to get started or ask any questions.\n"
)
rc2.font.size = Pt(12)
rc2.font.color.rgb = RGBColor(0xAA, 0xBB, 0xFF)

pc3 = close_cell.add_paragraph()
pc3.alignment = WD_ALIGN_PARAGRAPH.CENTER
rc3 = pc3.add_run(
    '\nAgency:  Team Bharat\n'
    'Email:   hello@teambharat.in\n'
    'Valid Until:  30 Days from Issue Date\n'
    'Proposal ID:  TB-X-EVRYVN-2026-05\n'
)
rc3.font.size = Pt(11)
rc3.font.color.rgb = RGBColor(0xCC, 0xDD, 0xFF)

for para in close_cell.paragraphs:
    para.paragraph_format.space_before = Pt(6)
    para.paragraph_format.space_after  = Pt(6)

doc.add_paragraph()
footer_p = doc.add_paragraph()
footer_p.alignment = WD_ALIGN_PARAGRAPH.CENTER
fr = footer_p.add_run('© 2026 Team Bharat. All rights reserved. Confidential — prepared exclusively for evryvn.com')
fr.font.size = Pt(9)
fr.font.color.rgb = GRAY

# ── Save ─────────────────────────────────────────────────────────────────────
output = '/home/user/teambharat/Twitter_Hashtag_Marketing_Proposal_evryvn.docx'
doc.save(output)
print(f'Saved: {output}')
