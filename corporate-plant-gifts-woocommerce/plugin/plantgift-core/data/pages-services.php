<?php
/**
 * Service page content.
 *
 * Each entry becomes a WordPress page using the theme Service Page template,
 * with a full H1 to H4 heading structure and ten questions and answers that are
 * also emitted as FAQPage structured data.
 *
 * @package PlantGift_Core
 */

defined( 'ABSPATH' ) || exit;

return array(

	/* ==================================================================== */
	array(
		'title'      => 'Corporate Plant Gifting for Employees, Clients and Events',
		'slug'       => 'corporate-plant-gifting',
		'menu_title' => 'Corporate Gifting',
		'template'   => 'page-templates/template-landing.php',
		'eyebrow'    => 'Corporate gifting',
		'focus'      => 'corporate plant gifting',
		'meta_title' => 'Corporate Plant Gifting Service for Teams and Clients',
		'meta_desc'  => 'End to end corporate plant gifting: shortlist, branded pots, packing and tracked delivery. Succulents, air plants and desk greenery from 25 units.',
		'excerpt'    => 'Send your headcount, your budget and your delivery dates. We handle the shortlist, the branding, the packing and the tracking, and your team only signs off on the design.',
		'highlights' => array( 'From 25 units', 'Mockup in 48 hours', 'Pan India delivery', 'Free replacement promise' ),
		'cats'       => array( 'succulent-corporate-gifts', 'air-plant-gifts', 'desk-plants-for-office', 'plant-gift-hampers' ),
		'content'    => '
<p class="pg-lede">Corporate gifting has a memory problem. Most of what companies send is consumed, stored or quietly discarded within a month. A live plant behaves differently. It sits on a desk, it grows, and it keeps carrying the association with whoever sent it for as long as it stays alive. That is the entire argument for plant gifting, and everything on this page exists to make it work at the scale you need.</p>

<h2>What our corporate plant gifting service actually covers</h2>
<p>We are not a nursery with a checkout attached. The catalogue is the visible part of a service that runs from the first brief to the tracking link landing in your inbox. Here is what sits behind it.</p>

<h3>Curation against your real constraints</h3>
<p>Every brief has three numbers that decide everything: headcount, budget per gift and delivery date. Give us those and we return a shortlist of three to five options with real photographs, landed costs and honest notes about which plants suit your recipients. If your team sits on an interior floor with no windows, we will say so and take the light hungry species off the list rather than shipping something that dies in six weeks.</p>

<h3>Pot selection and branding</h3>
<p>The plant gets remembered, but the pot decides whether the gift looks considered or cheap. We match the pot material to the plant first, then match the branding method to the material.</p>

<h4>Size</h4>
<p>Three inch for event handouts, four inch for the standard employee gift, five and six inch for milestones and client gifting, eight inch for cabins and reception areas.</p>

<h4>Material</h4>
<p>Terracotta for succulents that need to dry out, glazed ceramic for everyday desk gifting, self watering for teams that travel, metal and concrete when the gift needs weight.</p>

<h4>Branding method</h4>
<p>Ceramic takes a fired decal, terracotta takes a screen print or a clay stamp, metal takes a laser etch, and complex artwork goes on a printed sleeve. A rendered mockup reaches you within two working days, and orders above two hundred units get a physical sample.</p>

<h3>Growing, hardening and potting</h3>
<p>Plants are hardened for a week before they are potted, which means they are gradually acclimatised to lower light and less water so the journey does not shock them. Soil is trimmed to travel weight. Every unit is inspected before it goes into a carton.</p>

<h3>Packing that survives a courier</h3>
<p>Each pot travels in a moulded insert inside a double wall carton, with the soil secured under a mesh disc so it cannot shift and coat the leaves. Fragile items such as terrariums and glass vessels get an additional pulp shell. This is the least glamorous part of the service and the part that decides whether your gift arrives looking like a gift.</p>

<h3>Delivery, tracking and the aftermath</h3>
<p>Bulk drops go to one office address in labelled cartons sorted by team. Distributed teams get individual shipments with a tracking link per recipient. If anything arrives damaged, send a photograph within 48 hours and we replace it without argument.</p>

<h2>Who this service is built for</h2>

<h3>Human resources and people teams</h3>
<p>Onboarding kits, work anniversaries, festival rounds and wellbeing initiatives. Usually recurring, usually across a distributed workforce, and usually needing rolling dispatch rather than one large delivery.</p>

<h3>Marketing and events teams</h3>
<p>Conference giveaways, booth handouts and launch gifting. Fixed dates that cannot move, artwork that arrives late, and a need for venue delivery with counted cartons.</p>

<h3>Account and relationship teams</h3>
<p>Client thank you gifts, partner appreciation and contract milestones. Short lists, higher unit values, and branding that has to stay quiet enough to read as a thank you rather than a placement.</p>

<h3>Facilities and workplace teams</h3>
<p>Office greening, meeting room planting and reception displays. Larger pots, on site placement and often a maintenance conversation attached.</p>

<h2>How an order runs, start to finish</h2>

<h3>Step one: the brief</h3>
<p>Headcount, budget per gift, delivery cities and the date it needs to land. Four pieces of information. Anything else is useful but not required to start.</p>

<h3>Step two: the shortlist</h3>
<p>Within one working day you get three to five options with photographs, landed costs and the trade offs stated plainly. If something in your brief will cause a problem, this is where we say so.</p>

<h3>Step three: mockup and approval</h3>
<p>Send your artwork as a vector file and we return a rendered mockup on the actual pot within two working days. Nothing goes into production before you approve it.</p>

<h3>Step four: production and packing</h3>
<p>Plants are potted and hardened while branded pots are produced. Allow seven to ten working days for branding on top of the plant lead time.</p>

<h3>Step five: dispatch and tracking</h3>
<p>One consolidated invoice, one dispatch confirmation, and either a single tracking number or one per recipient depending on how you are delivering.</p>

<h2>Pricing structure</h2>
<p>Bulk slabs begin at 25 units and improve at 50, 100, 250 and 500. The slab applies to the combined quantity in your order rather than per product, so a mixed cart of succulents, air plants and hampers still qualifies once the total crosses a threshold. Branding, premium packaging and individual home delivery are quoted as separate lines so you can see exactly what each element costs and remove anything that is not earning its place.</p>

<h2>What we will tell you not to do</h2>
<p>We turn down more briefs than you might expect, and it is usually for the same handful of reasons. Ferns and fiddle leaf figs for an air conditioned office. Closed terrariums for recipients who will put them on a sunny windowsill. Chocolate in a hamper during an Indian summer. A festive order briefed in the second week of October. A logo the size of the pot. Saying so early costs us a line on the invoice and saves you a gifting round that lands badly.</p>
',
		'faqs'       => array(
			array( 'q' => 'What is the minimum order for corporate plant gifting?', 'a' => 'Bulk pricing begins at 25 units. Below that you can still order at the listed retail prices directly from any product page without speaking to anyone. Most corporate orders we handle sit between 50 and 500 units.' ),
			array( 'q' => 'How long does a corporate plant gift order take?', 'a' => 'Ten to twelve working days for unbranded plants in stock pots. Add seven to ten working days when pots need engraving or printing. Festive weeks and event dates need three to four weeks of buffer because courier networks slow down.' ),
			array( 'q' => 'Can you deliver to employees working from home?', 'a' => 'Yes. Share a spreadsheet with names, addresses and phone numbers, and each recipient gets an individually packed box with its own tracking link. A per shipment logistics charge appears as a separate line in the quote.' ),
			array( 'q' => 'Do you provide a sample before we commit to a large order?', 'a' => 'We send a rendered mockup within two working days for every branded order, and a physical sample for orders above two hundred units. Sample cost is credited against the final invoice once the order is confirmed.' ),
			array( 'q' => 'What happens if plants arrive damaged?', 'a' => 'Send a photograph within 48 hours of delivery and we replace the affected units at no cost, including branded pots. Our packing keeps this rare, but the promise stands regardless of order size.' ),
			array( 'q' => 'Which plants work best for an office with no natural light?', 'a' => 'ZZ plants, snake plants, Haworthia succulents and Aglaonema. All four keep their colour under ceiling lighting alone. We move Echeveria, cacti and string of pearls off the shortlist when a floor has no window access.' ),
			array( 'q' => 'Can we split one order between office delivery and home delivery?', 'a' => 'Yes, and it is the most common pattern now. Send one spreadsheet marking which recipients get office delivery and which get home delivery, and we handle the split with consolidated cartons for the office and individual tracked shipments for the rest.' ),
			array( 'q' => 'Do you offer GST invoices and corporate payment terms?', 'a' => 'Every order is invoiced with GST against your company details. Standard terms are advance payment for first orders and agreed credit terms for repeat clients, which we set up after the first completed order.' ),
			array( 'q' => 'Can you handle recurring gifting rather than one large order?', 'a' => 'Yes. We hold stock against your list and dispatch monthly or fortnightly to the names you send, which keeps the bulk rate without a large delivery sitting in your storeroom. Reserved stock is held for six months.' ),
			array( 'q' => 'How do you make sure recipients keep the plants alive?', 'a' => 'Every gift ships with a care card that names the plant, states the watering interval in days rather than in vague terms, and names the single mistake that kills that species. A QR code opens a longer care page, and buyers can add a one year care helpline for their recipients.' ),
		),
	),

	/* ==================================================================== */
	array(
		'title'      => 'Bulk Plant Gifts for Companies',
		'slug'       => 'bulk-plant-gifts-for-companies',
		'menu_title' => 'Bulk Orders',
		'eyebrow'    => 'Volume pricing',
		'focus'      => 'bulk plant gifts for companies',
		'meta_title' => 'Bulk Plant Gifts for Companies with Tiered Pricing',
		'meta_desc'  => 'Bulk plant gift orders from 25 to 5000 units with tiered pricing, one consolidated invoice and a single delivery window. Mixed carts qualify for the same slab.',
		'excerpt'    => 'Tiered pricing from 25 units upward, one consolidated invoice and a single delivery window. Mixed carts count toward the same slab.',
		'highlights' => array( '5 pricing slabs', 'One invoice', 'Mixed carts qualify', 'Counted cartons' ),
		'cats'       => array( 'succulent-corporate-gifts', 'money-plant-gifts', 'low-maintenance-plant-gifts', 'corporate-event-plant-giveaways' ),
		'content'    => '
<p class="pg-lede">Buying plants in volume is a different exercise from buying one. The unit price matters less than you expect, and the things that decide whether the round succeeds are stock depth, packing quality and whether the delivery lands on the day you promised your team it would.</p>

<h2>How bulk pricing works here</h2>
<p>Five slabs, applied to the combined quantity in your order rather than per product. That last part matters. If you want a hundred succulents for the wider team and twenty five bonsai for senior staff, the whole order of one hundred and twenty five units sits in the 100 slab rather than being split into two smaller ones.</p>

<h3>The slabs</h3>
<div class="pg-table-scroll">
<table>
<thead><tr><th scope="col">Quantity</th><th scope="col">Typical discount</th><th scope="col">Who this fits</th></tr></thead>
<tbody>
<tr><th scope="row">25 to 49</th><td>5 percent</td><td>Small teams, pilot rounds</td></tr>
<tr><th scope="row">50 to 99</th><td>10 percent</td><td>Single department gifting</td></tr>
<tr><th scope="row">100 to 249</th><td>15 percent</td><td>Company wide for a mid size firm</td></tr>
<tr><th scope="row">250 to 499</th><td>20 percent</td><td>Multi office festive rounds</td></tr>
<tr><th scope="row">500 and above</th><td>Custom quote</td><td>Enterprise rounds and events</td></tr>
</tbody>
</table>
</div>
<p>Branding, premium packaging and individual home delivery are quoted separately so you can see what each element costs and drop anything that is not earning its place.</p>

<h2>What changes as the quantity goes up</h2>

<h3>Under a hundred units</h3>
<p>Almost anything in the catalogue is available with a normal lead time. Species choice is wide open, and this is the range where premium options such as bonsai and terrariums remain affordable.</p>

<h3>One hundred to five hundred units</h3>
<p>Stock depth starts to matter. Fast propagating species such as pothos, snake plants and common succulents remain easy. Slow growing specimens such as bonsai, xerographica air plants and marble queen pothos need longer notice because they cannot be produced on demand.</p>

<h3>Above five hundred units</h3>
<p>This is a production planning exercise rather than a purchase. We reserve nursery stock, schedule potting in batches and stagger dispatch. Realistically the species list narrows to succulents, pothos, snake plants and lucky bamboo, because those are the only ones we can guarantee at that depth without compromising plant quality.</p>

<h2>Packing and delivery at volume</h2>

<h3>Counted and labelled cartons</h3>
<p>Cartons arrive counted in fifties with the count printed on the outside, so your workplace team can distribute without recounting. If you send a seating plan or a team list we sort cartons by floor or department at no extra cost.</p>

<h4>What to arrange on your side</h4>
<ul>
<li>An indoor storage area, not a loading bay or an unconditioned warehouse</li>
<li>A named contact who will be present in the delivery window</li>
<li>Lift access confirmed if the delivery is above the ground floor</li>
</ul>

<h3>Split deliveries across offices</h3>
<p>Multi city orders ship to each office separately from one consolidated order, with a tracking number per destination and one invoice covering the whole round. There is no penalty for splitting, and the bulk slab still applies to the total.</p>

<h2>Planning the timeline backwards</h2>
<p>Start from the date the gift has to be on the desk and work backwards. Two days for the last mile, three to five days for transit, ten working days for potting and hardening, seven to ten working days for branded pot production, and two working days for mockup approval. That lands at roughly four weeks for a branded bulk round. Anything faster is possible but it starts removing the safety steps, and we will tell you which ones.</p>

<h2>Where bulk gifting budgets usually go wrong</h2>

<h3>Underestimating logistics</h3>
<p>Individual home delivery can cost as much as the gift itself on a low value item. If the budget is tight, a single office drop with internal distribution is by far the biggest saving available.</p>

<h3>Overspending on branding</h3>
<p>A fired ceramic decal is beautiful and expensive. On a 249 unit round it can be a fifth of the landed cost. A printed sleeve gets you full colour branding for a fraction of that, and the recipient sees it either way.</p>

<h3>Booking festive rounds late</h3>
<p>Prices rise, stock narrows and couriers slow down in the four weeks before Diwali. An August brief and an October brief for the same order produce different gifts at different prices.</p>
',
		'faqs'       => array(
			array( 'q' => 'What is the minimum quantity for bulk plant gift pricing?', 'a' => 'Twenty five units. Below that, listed retail prices apply and you can order directly from any product page without a quote conversation.' ),
			array( 'q' => 'Does a mixed order of different plants qualify for the bulk slab?', 'a' => 'Yes. The slab applies to the combined quantity across your whole order, not per product. A cart of a hundred succulents and twenty five bonsai sits in the 100 unit slab as a single order of a hundred and twenty five.' ),
			array( 'q' => 'How much cheaper is a bulk order than buying individually?', 'a' => 'Roughly 5 percent at 25 units, rising to 20 percent at 250. Above 500 units we quote individually, since at that depth the plant sourcing and the logistics both change enough that a fixed percentage stops being accurate.' ),
			array( 'q' => 'Can you deliver a bulk order to multiple office locations?', 'a' => 'Yes, with a tracking number per destination and one consolidated invoice. Splitting across offices carries no penalty and the bulk slab still applies to the combined total.' ),
			array( 'q' => 'How far in advance should a bulk order be placed?', 'a' => 'Four weeks for a branded round is comfortable. Ten to twelve working days is possible for unbranded plants in stock pots. Festive weeks need six weeks because both nursery stock and courier capacity tighten.' ),
			array( 'q' => 'Which plants are practical above five hundred units?', 'a' => 'Succulents, golden pothos, snake plants and lucky bamboo. All four propagate fast enough to be produced at depth without dropping plant quality. Bonsai, xerographica air plants and terrariums cannot be scaled that way.' ),
			array( 'q' => 'Do bulk orders come with GST invoices?', 'a' => 'Every order is invoiced with GST against your registered company details. We issue one consolidated invoice for the whole round regardless of how many delivery locations are involved.' ),
			array( 'q' => 'Can we place a bulk order now and take delivery in phases?', 'a' => 'Yes. We hold your stock and dispatch against a schedule you set, which is how most onboarding and anniversary programmes run. Reserved stock is held for six months from the order date.' ),
			array( 'q' => 'What is the cheapest plant gift for a very large round?', 'a' => 'A 3 inch golden pothos or a mini succulent in a printed kraft sleeve, delivered in bulk to one office address. That combination gives the lowest landed cost per unit while still presenting as a considered gift.' ),
			array( 'q' => 'What if some plants in a bulk delivery arrive damaged?', 'a' => 'Photograph the affected units within 48 hours and we replace them at no cost. For large rounds we usually ship a small buffer quantity so your team can swap immediately rather than waiting for the replacement batch.' ),
		),
	),

	/* ==================================================================== */
	array(
		'title'      => 'Custom Branded Planters and Logo Printed Pots',
		'slug'       => 'custom-branded-planters',
		'menu_title' => 'Custom Branding',
		'eyebrow'    => 'Branding service',
		'focus'      => 'custom branded planters',
		'meta_title' => 'Custom Branded Planters with Logo Printing and Engraving',
		'meta_desc'  => 'Laser engraved, screen printed and fired decal branding on ceramic, terracotta, metal and concrete planters. Free mockup in 48 hours, from 50 units.',
		'excerpt'    => 'Laser engraving, fired ceramic decals, screen printing and full colour sleeves. We match the branding method to the material rather than forcing it.',
		'highlights' => array( 'Mockup in 48 hours', 'From 50 units', 'Permanent finishes', 'Physical sample above 200' ),
		'cats'       => array( 'branded-logo-planters', 'succulent-corporate-gifts', 'employee-welcome-kit-plants' ),
		'content'    => '
<p class="pg-lede">Most branded planters fail in the same way. A vinyl sticker starts lifting after the third watering, or an ink print on unglazed clay fades within a season, or a logo designed for a business card ends up cramped and unreadable wrapped around a 3 inch curve. All three are avoidable, and all three come from choosing the branding method before choosing the pot.</p>

<h2>Match the method to the material</h2>
<p>The pot should be chosen for the plant first. Then the branding method follows from what that material can actually carry. Here is how each one behaves.</p>

<h3>Glazed ceramic: fired decal</h3>
<p>The artwork is applied to the pot and then fired, sealing it under the glaze. It cannot peel, scratch or fade, and full colour reproduction is possible. There is a plate setup cost, so it becomes economical above roughly a hundred units.</p>

<h3>Natural terracotta: screen print or clay stamp</h3>
<p>Unglazed clay takes a one or two colour screen print. A debossed clay stamp pressed before firing is subtler and lasts even longer. Avoid multi colour artwork on terracotta, since the porous surface softens fine detail.</p>

<h3>Metal: laser engraving</h3>
<p>A laser cuts through the powder coat or into bare metal. Fine detail reproduces cleanly, the mark is permanent, and there is no colour matching discussion because the engraving reveals the base material.</p>

<h3>Cast concrete: screen print or inset plate</h3>
<p>Flat faces take a screen print well. For a more premium finish, a small brass or steel plate set into the surface reads better than printing directly onto the texture.</p>

<h3>Jute, kraft and sleeves: full colour printing</h3>
<p>When artwork is complex, multi coloured or includes a photograph, print the sleeve rather than the pot. It costs a fraction as much, reproduces anything, and leaves the pot clean once removed.</p>

<h2>What we need from your brand team</h2>

<h3>File requirements</h3>
<ul>
<li>Vector artwork in AI, EPS, PDF or SVG with all fonts outlined</li>
<li>A single colour version of the logo, since several methods reproduce one colour best</li>
<li>Pantone references if exact colour matching matters</li>
<li>Clear space and minimum size rules if your brand guidelines specify them</li>
</ul>

<h4>Minimum legible sizes</h4>
<p>On a 3 inch pot, roughly 25mm wide. On a 4 inch pot, 32mm. Below those figures fine detail closes up during firing or engraving, and a wordmark becomes a smudge. If your logo has a strapline, we usually recommend dropping it at these sizes rather than shrinking everything.</p>

<h2>The mockup and sample process</h2>

<h3>Rendered mockup within two working days</h3>
<p>Your artwork is placed on a photograph of the actual pot at the actual size, so you can see how it wraps and how it reads at arm length. This step catches most problems, and it costs nothing.</p>

<h3>Physical sample above two hundred units</h3>
<p>A real pot, branded with the final method, couriered to you for approval. Sample cost is credited against the final invoice. For large rounds this is worth the four extra days it adds to the timeline.</p>

<h3>Production</h3>
<p>Seven to ten working days for branding on top of the normal plant lead time. Rush production is sometimes possible, but it removes the physical sample step, and we will say so plainly rather than let you discover it at delivery.</p>

<h2>Minimum quantities</h2>
<div class="pg-table-scroll">
<table>
<thead><tr><th scope="col">Method</th><th scope="col">Minimum</th><th scope="col">Lead time</th></tr></thead>
<tbody>
<tr><th scope="row">Printed sleeve</th><td>50</td><td>2 weeks</td></tr>
<tr><th scope="row">Screen print on pot</th><td>50</td><td>7 to 10 working days</td></tr>
<tr><th scope="row">Laser engraving</th><td>50</td><td>7 to 10 working days</td></tr>
<tr><th scope="row">Fired ceramic decal</th><td>100</td><td>10 to 14 working days</td></tr>
<tr><th scope="row">Inset metal plate</th><td>25</td><td>10 working days</td></tr>
</tbody>
</table>
</div>

<h2>A word about restraint</h2>
<p>The branded pots that stay on desks carry a small, single colour mark. The ones that get quietly swapped for a plain pot carry a large logo, a tagline and a campaign hashtag. If all three need to appear somewhere, put them on the sleeve or the card, which the recipient will discard anyway, and keep the pot quiet. We will make this argument during the mockup stage, and you are free to overrule it.</p>
',
		'faqs'       => array(
			array( 'q' => 'What is the minimum order for custom branded planters?', 'a' => 'Fifty units for screen printing, laser engraving and printed sleeves. One hundred for fired ceramic decals because of the plate setup cost. Inset metal plates start at twenty five since there is no plate to make.' ),
			array( 'q' => 'What artwork format do you need for logo printing?', 'a' => 'Vector artwork in AI, EPS, PDF or SVG with the fonts outlined, plus a single colour version of the mark. Pantone references help if your brand team needs exact colour matching.' ),
			array( 'q' => 'Will a printed logo fade or peel over time?', 'a' => 'Not with the methods we use. A fired ceramic decal sits under the glaze and a laser engraving is cut into the material, so both are permanent. We do not offer vinyl stickers, which are the usual cause of peeling on branded pots.' ),
			array( 'q' => 'How long does branded planter production take?', 'a' => 'Seven to ten working days on top of the normal plant lead time, or ten to fourteen for fired ceramic decals. Add two working days at the start for mockup approval and four more if you want a physical sample.' ),
			array( 'q' => 'Do you send a sample before the full production run?', 'a' => 'A rendered mockup within two working days for every branded order, and a physical branded pot for orders above two hundred units. Sample cost is credited against the final invoice.' ),
			array( 'q' => 'How large can the logo be on a small pot?', 'a' => 'Roughly 25mm wide on a 3 inch pot and 32mm on a 4 inch pot before detail starts closing up. If your logo carries a strapline we usually recommend dropping it at these sizes rather than shrinking the whole lockup.' ),
			array( 'q' => 'Can you print full colour artwork on a pot?', 'a' => 'Fired ceramic decals reproduce full colour. Screen printing on terracotta and concrete is limited to one or two colours. For anything complex, printing a paper sleeve is cheaper and reproduces everything including photographs.' ),
			array( 'q' => 'Can you brand the gift box as well as the pot?', 'a' => 'Yes, and it is often the better place for it. Foil stamping or full colour printing on the lid costs less than pot branding and gives a larger flat area. Many buyers brand the box and leave the pot plain.' ),
			array( 'q' => 'Do you keep our artwork on file for repeat orders?', 'a' => 'Yes, along with the approved mockup and the production settings, so a repeat round reproduces identically without going through approval again. Files are held for two years and can be deleted on request.' ),
			array( 'q' => 'What if the branding on delivered pots does not match the approved sample?', 'a' => 'Send photographs within 48 hours and we reproduce the affected units at our cost. This is the reason the physical sample step exists on larger orders, and why we resist rush production that skips it.' ),
		),
	),

	/* ==================================================================== */
	array(
		'title'      => 'Employee Onboarding Plant Gifts and Welcome Kits',
		'slug'       => 'employee-onboarding-plant-gifts',
		'menu_title' => 'Onboarding Kits',
		'eyebrow'    => 'People team service',
		'focus'      => 'employee onboarding plant gifts',
		'meta_title' => 'Employee Onboarding Plant Gifts and Welcome Kits',
		'meta_desc'  => 'Desk ready plant welcome kits for new joiners, shipped to the office or to a home address. Rolling monthly dispatch, branded pots and care cards included.',
		'excerpt'    => 'A living plant on the desk before the new joiner sits down, with rolling monthly dispatch so continuous hiring does not mean a storeroom full of boxes.',
		'highlights' => array( 'Rolling dispatch', 'Home or office delivery', 'Stock held 6 months', 'Care card included' ),
		'cats'       => array( 'employee-welcome-kit-plants', 'succulent-corporate-gifts', 'plant-gift-hampers', 'low-maintenance-plant-gifts' ),
		'content'    => '
<p class="pg-lede">People remember their first morning at a company with unusual clarity. Whatever is on the desk when they sit down becomes part of that memory. A branded water bottle does not survive the recollection. A living plant does, and it keeps doing so every time they water it.</p>

<h2>What a welcome plant kit should contain</h2>
<p>Four things, and resisting the urge to add a fifth is most of the skill.</p>

<h3>A plant that survives a box</h3>
<p>Kits get assembled in advance, so the plant may sit packed for several days before anyone opens it. Succulents, air plants, snake plants and jade all handle that. Ferns, flowering plants and anything that needs steady moisture do not, and we will not put them in a kit even when asked.</p>

<h3>A care card that actually helps</h3>
<p>Naming the plant is not enough. The card states the watering interval in days, names the light the plant needs, and names the single mistake that most often kills it. A QR code opens a longer care page. These details measurably raise the number of plants still alive six months later.</p>

<h3>A handwritten note</h3>
<p>The element recipients photograph and keep. A printed insert signed with a scanned signature does not have the same effect, and everyone can tell the difference. Leave a blank line and have the hiring manager sign it.</p>

<h3>One or two useful branded items</h3>
<p>A notebook and a pen, or a laptop sleeve. Items that get used, not items that get stored. Past two additions the box stops feeling considered and starts feeling like a sample bag.</p>

<h2>Choosing the plant for your specific situation</h2>

<h3>If new joiners get an assigned desk</h3>
<p>A 4 inch succulent, jade plant or snake plant. There is room for a proper pot and the plant becomes a fixture.</p>

<h3>If new joiners start on hot desks</h3>
<p>A 3 inch pot or an air plant in a small holder, since anything larger has to be carried around or left behind.</p>

<h3>If new joiners start remotely</h3>
<p>Anything that survives a courier and a beginner. Ship to the home address timed to arrive two or three days before the start date, so the plant is unboxed before the welcome call rather than after it.</p>

<h2>Running it as a rolling programme</h2>

<h3>The problem with one large order</h3>
<p>Hiring is continuous, so a single annual order means either a storeroom full of ageing boxes or a plant that has been sitting packed for four months. Neither produces a good day one.</p>

<h3>How rolling dispatch works</h3>
<p>You place one order at the volume that earns the bulk slab you want. We hold the stock, and you send a joiner list monthly or fortnightly. We assemble and dispatch against that list, either to your office in one carton or to individual home addresses. Reserved stock is held for six months, and unused units roll into your next cycle.</p>

<h4>What we need in the joiner list</h4>
<ul>
<li>Name and start date</li>
<li>Delivery address with pin code, and a phone number for the courier</li>
<li>Whether it is an office or a home delivery</li>
<li>Any personalisation, such as a name on the card</li>
</ul>

<h2>Budgeting realistically</h2>
<p>The plant is rarely the expensive part. A kraft box delivered in bulk to one office address is the lowest cost version by a wide margin. A rigid box shipped individually to a home address roughly doubles the landed cost per kit, mostly through courier charges and packaging weight. Both are legitimate choices, but knowing which one you are pricing prevents an unpleasant surprise when the quote arrives. Tell us the target figure per kit and we will build to it rather than proposing something and then negotiating down.</p>

<h2>Measuring whether it worked</h2>
<p>Ask about the plant in the thirty day check in. It is a low effort question and the answers tell you two things: whether the kit arrived when it was meant to, and whether the care card did its job. Several clients now track plant survival at ninety days as an informal proxy for how well their onboarding logistics are running.</p>
',
		'faqs'       => array(
			array( 'q' => 'Which plant is best for an employee welcome kit?', 'a' => 'A 3 or 4 inch succulent, a jade plant or an air plant. All three survive several days packed in a box and forgive a recipient with no plant experience, which is the realistic assumption for a new joiner.' ),
			array( 'q' => 'Can you ship welcome kits directly to new joiner home addresses?', 'a' => 'Yes, and for remote starters it works better than office delivery. Send the joiner list with addresses and phone numbers and each box ships individually with a tracking link, timed to arrive two or three days before the start date.' ),
			array( 'q' => 'We hire continuously. Do we have to order in one batch?', 'a' => 'No. Place one order at the volume that earns your preferred bulk slab, and we hold the stock and dispatch monthly or fortnightly against the joiner list you send. Reserved stock is held for six months.' ),
			array( 'q' => 'How long can an assembled welcome kit sit before handover?', 'a' => 'About a week for succulents and air plants in a sealed box, and up to two weeks if the box is opened and the plant is placed in light. Beyond that we recommend assembling closer to the start date.' ),
			array( 'q' => 'What is a reasonable budget per welcome kit?', 'a' => 'The box and the courier drive the cost far more than the plant does. A kraft box in a bulk office delivery is the lowest option, while a rigid box shipped individually to a home roughly doubles it. Tell us your target per kit and we build to it.' ),
			array( 'q' => 'Can the pot carry our company logo?', 'a' => 'Yes, with a minimum of fifty units for engraving or screen printing. Many buyers brand the box lid and the care card instead and leave the pot plain, since an unbranded pot tends to stay on the desk longer.' ),
			array( 'q' => 'Do you personalise the card with the new joiner name?', 'a' => 'We can print names onto individual cards when the joiner list is sent at least five working days before dispatch. Most clients prefer a blank line for a handwritten signature from the hiring manager, which lands better.' ),
			array( 'q' => 'What if a new joiner does not start after the kit has shipped?', 'a' => 'For office deliveries the kit simply goes to the next joiner. For home deliveries the unit is used, so we credit half the value against your next dispatch cycle as a shared cost.' ),
			array( 'q' => 'Do welcome kits work for interns and short term contractors?', 'a' => 'Yes, and a 3 inch succulent in a kraft box is the usual pick because the lower value suits a shorter engagement while still marking the first day properly.' ),
			array( 'q' => 'Can we include our own items in the kit?', 'a' => 'Yes. Ship your branded items to our facility and we assemble them into the kits at a small per unit handling charge. Send them at least a week before your first dispatch cycle.' ),
		),
	),

	/* ==================================================================== */
	array(
		'title'      => 'Client Gifting Programme with Live Plants',
		'slug'       => 'client-gifting-programme',
		'menu_title' => 'Client Gifting',
		'eyebrow'    => 'Relationship gifting',
		'focus'      => 'client gifting plants',
		'meta_title' => 'Client Gifting Programme with Premium Plant Gifts',
		'meta_desc'  => 'Premium plant gifts for clients and partners. Bonsai, anthurium and specimen air plants in rigid boxes, timed for mid week delivery with handwritten notes.',
		'excerpt'    => 'Premium plants, quiet branding and delivery timed for mid week. Built so the gift reads as a thank you rather than a placement.',
		'highlights' => array( 'Quiet branding', 'Rigid gift boxes', 'Mid week delivery', 'Matched specimen sets' ),
		'cats'       => array( 'client-appreciation-plant-gifts', 'bonsai-corporate-gifts', 'flowering-plant-gifts', 'terrarium-gift-sets' ),
		'content'    => '
<p class="pg-lede">A client gift stops working the moment it looks like marketing. Your logo across the pot turns a thank you into a placement, and the person receiving it reads it exactly that way. The gifts that survive on a client desk for years are the ones where the branding is small, well made and easy to ignore.</p>

<h2>The four rules that make client gifting work</h2>

<h3>Keep the branding quiet</h3>
<p>A handwritten card carrying your name is enough. If you want something on the object itself, use a small engraved plate with the recipient name rather than your logo. This single decision separates gifts that stay from gifts that get moved to a shelf.</p>

<h3>Spend on the object, not the wrapping</h3>
<p>A good plant in a plain premium pot beats an average plant in an elaborate box. Clients handle a lot of gifts and they can tell which way the budget went.</p>

<h3>Time the delivery</h3>
<p>Mid week, mid morning. Monday arrivals get buried in the week opening. Friday arrivals sit in a post room over the weekend, by which point the plant has been boxed for three days and looks it.</p>

<h3>Check the gifting policy first</h3>
<p>Many organisations cap the value an employee may accept, and some sectors prohibit gifts outright. Plants clear internal policies more easily than most things because they read as a workplace item rather than a personal benefit, but a stated cap still applies.</p>

<h2>What to send</h2>

<h3>A trained bonsai</h3>
<p>The strongest signal of effort in our range, because the tree obviously took years to shape. Ficus and jade bonsai both survive indoor conditions well enough to be a safe choice for someone who does not keep plants.</p>

<h4>Ficus or jade</h4>
<p>Both forgive a missed watering. Choose ficus when you want the classic bonsai silhouette and jade when the recipient travels.</p>

<h4>What to avoid</h4>
<p>Carmona, unless you know the person keeps plants. It punishes irregular care and a dead gift is worse than a modest one.</p>

<h3>Anthurium or peace lily</h3>
<p>Colour and presence with an undemanding care routine. Anthurium spathes hold for six to eight weeks and the plant photographs well, which matters if your client posts about it.</p>

<h3>A specimen air plant</h3>
<p>Tillandsia xerographica on a weighted metal stand is unusual enough to prompt a question, and it needs a weekly soak and nothing else. A good pick for a recipient who already owns everything a supplier might send.</p>

<h3>A planted terrarium</h3>
<p>Reads as an object rather than a plant. Best for reception areas and shared spaces rather than an individual desk.</p>

<h2>Presentation details that get noticed</h2>
<ul>
<li>Rigid magnetic box with foam bedding, not a kraft carton</li>
<li>A handwritten note signed by the person who owns the relationship</li>
<li>A care booklet rather than a single card when the plant needs one</li>
<li>An engraved brass plate carrying the recipient name and a date</li>
<li>Delivery confirmed by a call rather than left to a courier notification</li>
</ul>

<h2>Running this across a client list</h2>

<h3>Matched sets</h3>
<p>Client lists are short, which means we can select individual specimens and match height, form and colour across the set. Nobody wants to discover their gift was smaller than a peer received. Allow three weeks for bonsai and two for everything else.</p>

<h3>Staged delivery</h3>
<p>If the list spans several cities, we stage dispatch so everything lands within the same 48 hour window rather than trickling in over a week.</p>

<h3>Repeat rounds</h3>
<p>We keep a record of what each recipient received, so the following year does not repeat the same plant. It is a small thing that a client notices immediately.</p>

<h2>What we would advise against</h2>
<p>Sending a large floor plant to an office you have not visited, because you do not know whether there is a corner for it. Sending anything that needs daily watering to someone who travels. Sending a gift that requires assembly. Sending in the week before a major festival, when everything arrives at once and yours competes with twenty others. Sending the same gift two years running.</p>
',
		'faqs'       => array(
			array( 'q' => 'Should client gifts carry our company logo?', 'a' => 'Keep it minimal. A handwritten card or a small engraved plate is enough. A logo across the pot turns the gift into a placement, and that is when it stops being kept on the desk.' ),
			array( 'q' => 'What is the best plant to send to a client?', 'a' => 'A ficus or jade bonsai when you want to signal effort, an anthurium when you want colour with easy care, or a specimen air plant when you want something unusual. All three survive ordinary office conditions.' ),
			array( 'q' => 'When should a client gift be delivered?', 'a' => 'Mid week and mid morning. Monday deliveries get lost in the week opening and Friday arrivals often sit in a post room until the following week, by which point the plant has been boxed for three days.' ),
			array( 'q' => 'What if the client company has a gifting policy?', 'a' => 'Ask before you send and keep the value modest where you are unsure. Plants clear internal policies more easily than most gifts because they read as a workplace item, but a stated value cap still applies.' ),
			array( 'q' => 'Can you match plants across a list of clients?', 'a' => 'Yes. Client lists are usually short enough that we select individual specimens and match height and form across the set. Allow three weeks for bonsai and two weeks for other species.' ),
			array( 'q' => 'How much should we spend on a client plant gift?', 'a' => 'Most client gifting we handle sits between a mid range bonsai and a premium terrarium. Spend on the plant and the pot rather than the packaging, since clients handle enough gifts to tell where the budget went.' ),
			array( 'q' => 'Do you include a handwritten note?', 'a' => 'We include a blank quality card in every client box for you to write on, or you can send us the text and we handwrite it. A scanned signature on a printed insert does not have the same effect and everyone can tell.' ),
			array( 'q' => 'Can you deliver client gifts internationally?', 'a' => 'Live plants face phytosanitary restrictions in most countries and we do not ship them across borders. For international clients we suggest a preserved moss frame or a seed paper gift, neither of which is restricted.' ),
			array( 'q' => 'Will you track what each client received last year?', 'a' => 'Yes. We keep a record against your account so the following round does not repeat the same plant to the same person, which is a detail clients notice immediately.' ),
			array( 'q' => 'What happens if a client gift arrives damaged?', 'a' => 'Tell us and we send a replacement to the same address at our cost, usually within three working days. For client gifting we do not ask for a photograph first, since chasing evidence is not a conversation you should have to have.' ),
		),
	),

	/* ==================================================================== */
	array(
		'title'      => 'Event Plant Giveaway Service for Conferences and Offsites',
		'slug'       => 'event-plant-giveaway-service',
		'menu_title' => 'Event Giveaways',
		'eyebrow'    => 'Events service',
		'focus'      => 'event plant giveaways',
		'meta_title' => 'Event Plant Giveaway Service for Booths and Conferences',
		'meta_desc'  => 'Pre packed mini plant giveaways delivered to your venue, counted in fifties and labelled for a fast handout table. Branded sleeves with QR codes available.',
		'excerpt'    => 'Mini plants packed individually, counted in fifties and delivered to the venue on your schedule, so a handout table never slows down.',
		'highlights' => array( 'Venue delivery', 'Counted in fifties', 'Individually packed', 'QR code sleeves' ),
		'cats'       => array( 'corporate-event-plant-giveaways', 'succulent-corporate-gifts', 'air-plant-gifts', 'branded-logo-planters' ),
		'content'    => '
<p class="pg-lede">Walk any conference floor and the giveaway tables look identical. Pens, notebooks, stress balls, tote bags. Most of it ends up in a hotel bin before the attendee flies home. A tiny living plant does not, because discarding something alive feels different, and because whoever takes it home puts it somewhere they can see it.</p>

<h2>What works at an event and what does not</h2>

<h3>Mini succulents in 3 inch pots</h3>
<p>Sturdy, stackable, unlikely to spill and instantly recognisable as a gift rather than merchandise. The default booth giveaway and the one we ship most.</p>

<h3>Air plants in kraft boxes</h3>
<p>No soil at all, which means nothing spills in a conference bag and the item survives a flight home in checked luggage. Lighter than a potted plant, which matters when you are shipping a thousand units to a venue.</p>

<h3>Seed paper cards and grow kits</h3>
<p>The lightest option, and the right call when a large share of attendees are flying with cabin baggage only. Less impact than a live plant, but nothing gets abandoned at the venue.</p>

<h3>What we advise against</h3>
<p>Anything in glass at a standing event. Anything above 4 inches, because attendees will not carry it. Anything that needs watering during a multi day conference, since nobody will.</p>

<h2>Packing built for a handout queue</h2>

<h3>Individually packed units</h3>
<p>Loose pots slow a registration desk to a crawl. Each unit ships in its own sleeve or small box so a volunteer can hand one over in a second without touching soil.</p>

<h3>Counted cartons</h3>
<p>Cartons are counted in fifties with the count printed on the outside. Your team restocks the table without recounting, and reconciling what was given out at the end of the day takes a minute rather than an hour.</p>

<h3>Name labelling for seated events</h3>
<p>For dinners and awards nights we print and apply name labels so each place setting has the right unit. Send the list five working days before dispatch.</p>

<h2>Delivery and storage at the venue</h2>

<h4>What we need from you</h4>
<ul>
<li>Final quantity plus roughly ten percent for walk ins</li>
<li>Venue address, delivery window and a named on site contact with a phone number</li>
<li>Whether there is an indoor storeroom, and on which floor</li>
<li>Artwork at least two weeks before the event date</li>
</ul>

<h3>Storage matters more than people expect</h3>
<p>Plants delivered the day before need an indoor room, not a loading bay. Succulents tolerate a night in a sealed carton. They do not tolerate a hot warehouse or a cold basement. Tell us the storage situation honestly and we will time the delivery around it rather than shipping early and hoping for the best.</p>

<h2>Branding for events</h2>
<p>The sleeve carries the branding, not the pot. Sleeves print in full colour cheaply, take a QR code, and can carry the stand number and the campaign artwork. Event giveaways are one of the few gifting formats where a QR scan genuinely happens, so point it at something useful such as a care guide or a campaign landing page rather than your homepage.</p>

<h2>Timeline</h2>
<p>Three weeks for printed sleeves above five hundred units, two weeks for unbranded stock. We confirm dispatch a week before the event rather than the day before, because event dates cannot move and a courier delay discovered on the morning of the event is not recoverable. If your artwork is going to be late, tell us early and we will ship unbranded stock with a separate sleeve run.</p>

<h2>After the event</h2>
<p>Leftover units keep for two to three weeks if they are unboxed and placed in light. We can arrange a return collection for large surpluses, or you can distribute them internally, which is what most clients do. Either way, tell us the final give out count, since it is the most useful number for planning the next event.</p>
',
		'faqs'       => array(
			array( 'q' => 'What is the best plant giveaway for a conference booth?', 'a' => 'A 3 inch succulent in a printed sleeve, or an air plant in a kraft box. Both are sturdy, light, survive a day on a table and travel home in hand luggage without spilling anything.' ),
			array( 'q' => 'Can attendees carry live plants on a flight?', 'a' => 'Within India, yes, in both cabin and checked baggage. For international attendees the rules vary by destination and soil is usually the sticking point, which is why air plants and seed paper are safer at global events.' ),
			array( 'q' => 'How should plants be stored at the venue before the event?', 'a' => 'Indoors, out of direct sun, in a room that is neither hot nor freezing. A sealed carton overnight is fine. A loading bay or an unconditioned warehouse is not, so tell us your storage and we will time delivery around it.' ),
			array( 'q' => 'How far in advance do we need to place an event order?', 'a' => 'Three weeks for printed sleeves above five hundred units, two weeks for unbranded stock. We confirm dispatch a week ahead rather than the day before, since event dates cannot be moved.' ),
			array( 'q' => 'Can you deliver directly to the event venue?', 'a' => 'Yes. Give us the venue address, the delivery window and a named on site contact. Cartons arrive counted and labelled in fifties so your team can restock without recounting.' ),
			array( 'q' => 'How many units should we order for an expected footfall?', 'a' => 'Plan on roughly sixty to seventy percent of registered attendees actually visiting a booth, then add ten percent for walk ins. Over ordering is easier to absorb than running out at midday.' ),
			array( 'q' => 'Can we add a QR code to the giveaway packaging?', 'a' => 'Yes, printed on the sleeve or the box. Point it at a care guide or a campaign landing page rather than your homepage, since event scans are one of the few that genuinely convert.' ),
			array( 'q' => 'What happens to leftover plants after the event?', 'a' => 'They keep for two to three weeks if unboxed and placed in light. Most clients distribute the surplus internally. For large quantities we can arrange a return collection at cost.' ),
			array( 'q' => 'Do you supply staff to run the giveaway table?', 'a' => 'No, we deliver and pack only. What we do supply is packing designed so an untrained volunteer can hand a unit over in a second without touching soil, which removes most of the need for specialist staffing.' ),
			array( 'q' => 'Can the giveaways be personalised for a seated event?', 'a' => 'Yes. Send the guest list five working days before dispatch and we print and apply name labels so each place setting carries the right unit.' ),
		),
	),

	/* ==================================================================== */
	array(
		'title'      => 'Festival and Diwali Corporate Plant Gifts',
		'slug'       => 'festival-corporate-plant-gifts',
		'menu_title' => 'Festive Gifting',
		'eyebrow'    => 'Seasonal service',
		'focus'      => 'diwali corporate plant gifts',
		'meta_title' => 'Festival and Diwali Corporate Plant Gifts in Bulk',
		'meta_desc'  => 'Auspicious plant gifts for Diwali and New Year rounds. Jade, money plant and lucky bamboo in plastic free festive boxes with bulk delivery across India.',
		'excerpt'    => 'Auspicious plants in plastic free festive packaging, planned early enough that you choose the design rather than taking what is left.',
		'highlights' => array( 'Book by August', 'Plastic free boxes', 'Office and home split', 'Auspicious species' ),
		'cats'       => array( 'diwali-corporate-plant-gifts', 'lucky-bamboo-gifts', 'money-plant-gifts', 'plant-gift-hampers' ),
		'content'    => '
<p class="pg-lede">The festive gifting round has a well documented problem. Sweets are eaten in a day, dry fruit boxes get passed along, and branded merchandise is forgotten by January. A plant is still on the desk in March, and it is still carrying the association with whoever sent it.</p>

<h2>The plants that suit the occasion</h2>

<h3>Jade plant</h3>
<p>Thick coin shaped leaves and a long standing prosperity association. It is also a succulent, which means it survives the recipient going home for a week of holidays without watering it. Symbolism and practicality in the same plant, which is rarer than it sounds.</p>

<h3>Money plant</h3>
<p>The most affordable option at high volume and the one most recipients already know how to keep alive. Familiarity raises survival rates, and a plant that lives is the only kind that does anything for you.</p>

<h3>Lucky bamboo</h3>
<p>An eight stalk arrangement in a ceramic vase with a cotton ribbon presents as well as any traditional hamper and needs only a water change every fortnight. Stock of tall matched stalks runs out by early October most years.</p>

<h3>Tulsi</h3>
<p>Deeply significant and genuinely appropriate, but it needs four to six hours of direct sun. Gift it when you know it is going to a home rather than an office floor, and say so on the card.</p>

<h2>Festive packaging without plastic</h2>
<p>Kraft and rigid boxes, paper shred filler, jute pouches, cotton ribbon and a printed greeting card cover the entire festive look with no plastic component at all. That also makes the gift straightforward to justify against a corporate sustainability policy, which increasingly matters when the round has to be signed off.</p>

<h3>A build that works every year</h3>
<ul>
<li>4 inch jade plant in a glazed ceramic pot</li>
<li>Two brass diyas and a tealight</li>
<li>Mixed dry fruits in a paper pouch</li>
<li>Printed greeting with a blank line for a handwritten signature</li>
<li>Kraft box with a foil logo on the lid, paper shred filler, cotton ribbon</li>
</ul>

<h4>Why we leave out chocolate</h4>
<p>Diwali often falls in warm weather and chocolate does not survive courier transport reliably. A melted box ruins the plant and the packaging together, which turns a gift into an apology. Dry fruits and packaged snacks travel fine, so we substitute and say so up front.</p>

<h2>Timing, which is the whole game</h2>

<h3>August: the right time to brief</h3>
<p>Nursery stock is deep, courier networks are normal, branded pot production has capacity, and you choose the species, the design and the delivery date.</p>

<h3>September: still comfortable</h3>
<p>Most options remain open. Custom box printing gets tight toward the end of the month.</p>

<h3>October: you take what is available</h3>
<p>Popular species sell out, branded production books up and couriers slow down for two weeks around the festival. Orders still ship, but the design conversation becomes a shortlist of what remains.</p>

<p>This is the single most common regret we hear from buyers, which is why we say it early and repeat it.</p>

<h2>Delivering to a distributed workforce</h2>
<p>Most festive rounds now split between office drops and home deliveries. Send one spreadsheet covering both, marked by delivery type, and we handle the split: consolidated cartons to the offices and individually tracked shipments to everyone else. Home deliveries during festival weeks need an extra three to four days of buffer, and we build that into the dispatch schedule rather than discovering it late.</p>

<h2>Beyond Diwali</h2>
<p>New Year rounds in late December run on the same mechanics with lighter packaging. Regional festivals such as Onam, Pongal and Durga Puja work well for location specific teams and are far less crowded than the national festive window, which means better stock, calmer couriers and a gift that does not compete with twenty others arriving the same week.</p>
',
		'faqs'       => array(
			array( 'q' => 'Which plants are considered auspicious for Diwali corporate gifting?', 'a' => 'Jade, money plant, lucky bamboo and tulsi are the four most commonly chosen. Jade and money plant work best on an office desk, while tulsi needs direct sun and suits a home rather than a workstation.' ),
			array( 'q' => 'When should we place a Diwali plant gift order?', 'a' => 'August, or early September at the latest. Popular species run out and courier networks slow down for two weeks around the festival, so an early brief protects both your design choice and your delivery date.' ),
			array( 'q' => 'Can festive plant hampers include sweets or chocolate?', 'a' => 'Dry fruits and packaged snacks travel well. We avoid chocolate because Diwali often falls in warm weather and a melted box ruins the plant along with the packaging.' ),
			array( 'q' => 'Can the festive packaging be completely plastic free?', 'a' => 'Yes. Kraft or rigid boxes, paper shred filler, jute pouches and cotton ribbon cover the festive look with no plastic at all, which also makes the round easier to sign off against a sustainability policy.' ),
			array( 'q' => 'Do you deliver festive gifts to employee home addresses?', 'a' => 'Yes. Send one spreadsheet covering office and home recipients and we split the dispatch. Allow an extra three to four days during festival weeks, which we build into the schedule rather than flagging late.' ),
			array( 'q' => 'How much does a festive plant hamper cost per unit?', 'a' => 'It depends mostly on the box and the number of companions rather than the plant. A jade plant with diyas and dry fruits in a kraft box is the common mid range build, and we will price to a target figure if you give us one.' ),
			array( 'q' => 'Can you brand the festive boxes with our logo?', 'a' => 'Yes, usually as a foil stamp on the lid with a printed greeting card inside. We generally recommend leaving the pot unbranded, since a plain pot stays on the desk longer than a branded one does.' ),
			array( 'q' => 'What is the minimum order for festive plant gifting?', 'a' => 'Twenty five units for bulk pricing. Most festive rounds we handle sit between 100 and 1000 units, and above 500 the species list narrows to what can be produced at that depth.' ),
			array( 'q' => 'Do you handle regional festivals other than Diwali?', 'a' => 'Yes, and they are often a better option. Onam, Pongal and Durga Puja rounds face less crowded courier networks and deeper stock, so the gift arrives calmly instead of competing with twenty others.' ),
			array( 'q' => 'What if our headcount changes after we place the festive order?', 'a' => 'Tell us up to ten working days before dispatch and we adjust the quantity without repricing the slab downward. Late additions are possible but ship separately and may miss the festive window.' ),
		),
	),

	/* ==================================================================== */
	array(
		'title'      => 'Office Plant Subscription and Maintenance',
		'slug'       => 'office-plant-subscription',
		'menu_title' => 'Plant Subscription',
		'eyebrow'    => 'Ongoing service',
		'focus'      => 'office plant subscription',
		'meta_title' => 'Office Plant Subscription with Care Visits and Replacements',
		'meta_desc'  => 'An office plant subscription with scheduled care visits, free replacements and quarterly refreshes. Keeps workspace greenery healthy with no internal effort.',
		'excerpt'    => 'A quarterly refresh with scheduled care visits and free replacements, so nobody on your team has to become the person who waters the plants.',
		'highlights' => array( 'Quarterly refresh', 'Scheduled care visits', 'Free replacements', 'No internal owner needed' ),
		'cats'       => array( 'desk-plants-for-office', 'air-purifying-plant-gifts', 'low-maintenance-plant-gifts' ),
		'content'    => '
<p class="pg-lede">Office plants die for an organisational reason rather than a horticultural one. Nobody owns them. The person who cared quietly leaves, watering stops, and six months later there are brown plants in a meeting room that everyone has learned to ignore. A subscription solves the ownership problem, which is the only problem that matters.</p>

<h2>What the subscription includes</h2>

<h3>Scheduled care visits</h3>
<p>A technician visits monthly or fortnightly depending on the plan. They water, feed, prune, wipe leaves, check for pests, rotate plants toward the light and replace anything that is failing. The visit is logged and you receive a short report.</p>

<h3>Free replacements</h3>
<p>Any plant that dies or declines beyond recovery is replaced at no charge, whatever the cause. We do not investigate whose fault it was, because that conversation wastes more time than the plant costs.</p>

<h3>Quarterly refresh</h3>
<p>Every quarter we rotate a proportion of the plants, bringing in seasonal colour and moving anything that has outgrown its position. This is what keeps an office from looking the same for three years.</p>

<h3>Seasonal adjustments</h3>
<p>Watering frequency changes between summer and winter, and air conditioning load changes with it. The schedule adapts rather than running the same routine year round.</p>

<h2>Plans</h2>
<div class="pg-table-scroll">
<table>
<thead><tr><th scope="col">Plan</th><th scope="col">Visit frequency</th><th scope="col">Suits</th></tr></thead>
<tbody>
<tr><th scope="row">Essential</th><td>Monthly</td><td>Under 40 plants, single floor</td></tr>
<tr><th scope="row">Standard</th><td>Fortnightly</td><td>40 to 150 plants, multiple floors</td></tr>
<tr><th scope="row">Managed</th><td>Weekly</td><td>Above 150 plants, reception displays</td></tr>
</tbody>
</table>
</div>
<p>All plans include replacements and the quarterly refresh. Pricing is per plant per month, with the plants themselves either purchased upfront or included in the monthly figure depending on which structure suits your finance team.</p>

<h2>How a subscription starts</h2>

<h3>A site walk</h3>
<p>We visit and record light levels at each proposed position, along with air conditioning vents, walkways and anywhere a pot would be knocked. Light is the variable that decides everything, and guessing it from a photograph is how offices end up with plants that slowly fade.</p>

<h3>A planting plan</h3>
<p>You receive a plan showing what goes where and why, with the light requirement stated for each position. If a spot cannot support a living plant, we say so rather than putting something there that will need replacing every quarter.</p>

<h3>Installation</h3>
<p>Plants are delivered, placed and settled in a single visit. Larger specimens are placed by two people, and we bring our own trolley rather than assuming your building has one.</p>

<h2>Where a subscription pays for itself</h2>

<h4>Reception and client facing areas</h4>
<p>The places where a dying plant costs you something. These are also the positions most likely to be neglected because they belong to nobody.</p>

<h4>Meeting rooms</h4>
<p>Windowless rooms need species chosen specifically for them, and they need someone who remembers they exist.</p>

<h4>Post gifting rounds</h4>
<p>Several clients start a subscription after a large desk gifting round, because they want the greenery to still be there a year later rather than becoming a quiet embarrassment.</p>

<h2>What the subscription does not cover</h2>
<p>Plants that recipients own personally at their own desks, unless you specifically include them. Outdoor and terrace planting, which needs a different skill set and a different schedule. Damage from building work, flooding or pest fumigation, which we will fix but will quote separately. Being honest about the boundaries at the start prevents the awkward conversation later.</p>
',
		'faqs'       => array(
			array( 'q' => 'How much does an office plant subscription cost?', 'a' => 'Pricing is per plant per month and depends on visit frequency and plant size. A monthly visit plan for a small single floor office is the entry point, and the plants can either be purchased upfront or folded into the monthly figure.' ),
			array( 'q' => 'What happens if a plant dies under the subscription?', 'a' => 'We replace it at no charge, whatever the cause. We do not investigate why, because that conversation costs more time than the plant is worth and it makes people hide problems rather than report them.' ),
			array( 'q' => 'How often does a technician visit?', 'a' => 'Monthly, fortnightly or weekly depending on the plan and the number of plants. Larger installations and reception displays need more frequent attention because they are the most visible.' ),
			array( 'q' => 'Do you handle offices with no natural light?', 'a' => 'Yes, by choosing species that genuinely tolerate it such as ZZ plants, snake plants and Aglaonema. Where a position cannot support any living plant we say so during the site walk rather than placing something that fails every quarter.' ),
			array( 'q' => 'Can we start a subscription after a gifting round?', 'a' => 'That is a common route. Several clients add a subscription for shared areas after a desk gifting round, so the greenery is still healthy a year later rather than becoming a quiet embarrassment.' ),
			array( 'q' => 'Is there a minimum contract period?', 'a' => 'Three months, which is the shortest period over which the service can actually be judged. After that it runs month to month with thirty days notice on either side.' ),
			array( 'q' => 'Do you provide the pots as well as the plants?', 'a' => 'Yes, matched to the interior during the planting plan stage. If you already have planters we will work with them, provided they have drainage or can take an inner liner.' ),
			array( 'q' => 'Does the subscription cover employee desk plants?', 'a' => 'Only if you specifically include them. By default it covers shared areas and company owned plants, since personal desk plants belong to individuals who usually prefer to look after their own.' ),
			array( 'q' => 'What happens during an office move?', 'a' => 'We pause the subscription, relocate the plants as part of the move at a quoted rate, and run a fresh site walk at the new premises because the light conditions will be different.' ),
			array( 'q' => 'Which cities do you cover for care visits?', 'a' => 'Care visits require a technician on the ground, so coverage is limited to the metros and major cities where we have teams. Tell us your location and we will confirm honestly rather than promising coverage we cannot deliver.' ),
		),
	),

	/* ==================================================================== */
	array(
		'title'      => 'Plant Care Guide for Office and Desk Plants',
		'slug'       => 'plant-care-guide',
		'menu_title' => 'Plant Care Guide',
		'eyebrow'    => 'Care resource',
		'focus'      => 'office plant care guide',
		'meta_title' => 'Plant Care Guide for Office Desk Plants',
		'meta_desc'  => 'How to water, light and troubleshoot office desk plants. Watering intervals by species, light guidance and fixes for yellow leaves, brown tips and drooping.',
		'excerpt'    => 'Watering intervals in days, light guidance you can act on, and fixes for the four problems that account for almost every unhappy office plant.',
		'highlights' => array( 'Watering by species', 'Light explained simply', 'Troubleshooting', 'Holiday guidance' ),
		'cats'       => array( 'low-maintenance-plant-gifts', 'desk-plants-for-office', 'succulent-corporate-gifts' ),
		'content'    => '
<p class="pg-lede">Almost every office plant that dies is killed by one of four things: too much water, not enough light, a pot with no drainage, or a cold draught from an air conditioning vent. Understanding those four covers nearly everything you will ever need.</p>

<h2>Watering, in days rather than in vague terms</h2>
<p>Advice like water when it needs it is useless to someone who has never kept a plant. Here are actual intervals for an air conditioned Indian office. Adjust down slightly in winter and up slightly during a hot summer.</p>

<div class="pg-table-scroll">
<table>
<thead><tr><th scope="col">Plant</th><th scope="col">Interval</th><th scope="col">How to check</th></tr></thead>
<tbody>
<tr><th scope="row">Succulents and cacti</th><td>12 to 21 days</td><td>Soil dry all the way through</td></tr>
<tr><th scope="row">Snake plant</th><td>14 to 21 days</td><td>Soil dry, leaves still firm</td></tr>
<tr><th scope="row">ZZ plant</th><td>21 to 30 days</td><td>Soil completely dry</td></tr>
<tr><th scope="row">Money plant and pothos</th><td>7 days</td><td>Top 2cm dry</td></tr>
<tr><th scope="row">Peace lily</th><td>7 days</td><td>Or when leaves soften</td></tr>
<tr><th scope="row">Anthurium</th><td>7 days</td><td>Top 2cm dry</td></tr>
<tr><th scope="row">Bonsai</th><td>2 to 3 times a week</td><td>Surface just starting to dry</td></tr>
<tr><th scope="row">Air plant</th><td>Soak weekly</td><td>20 minutes, then dry upside down</td></tr>
</tbody>
</table>
</div>

<h3>How to water properly</h3>
<p>Water at the soil, not over the leaves. Pour slowly until water runs from the drainage hole, then stop and empty the saucer after ten minutes. A plant sitting in a full saucer is a plant with rotting roots, and that is the single most common cause of death in office plants.</p>

<h2>Light, explained without jargon</h2>

<h3>Bright indirect light</h3>
<p>Within two metres of a window, but not in the path of direct sun. If you can read a book comfortably without a lamp at midday, that is bright indirect light.</p>

<h3>Low light</h3>
<p>More than three metres from a window, or an interior room lit by ceiling fixtures. ZZ plants, snake plants, Aglaonema and Haworthia manage here. Most other plants slowly decline.</p>

<h3>Direct sunlight</h3>
<p>Three or more hours of sun falling on the leaves. Only cacti, some succulents and tulsi want this. For everything else it scorches.</p>

<h4>A quick test</h4>
<p>Hold your hand thirty centimetres above the plant at midday. A sharp shadow means direct sun. A soft shadow means bright indirect. Barely any shadow means low light.</p>

<h2>The four problems you will actually encounter</h2>

<h3>Yellow leaves</h3>
<p>Almost always overwatering. Let the soil dry fully, check the pot drains, and empty the saucer after every watering. Yellow lower leaves on an otherwise healthy plant can simply be age, which is normal.</p>

<h3>Brown crispy tips</h3>
<p>Dry air or fluoride and chlorine in tap water. Move the plant away from an air conditioning vent and switch to filtered or rested water. Trim the brown tips with scissors following the leaf shape.</p>

<h3>Drooping</h3>
<p>Usually thirst, occasionally root rot from overwatering. Feel the soil first. Dry soil with a drooping plant means water it. Wet soil with a drooping plant means the roots are in trouble, and the plant needs to dry out rather than being watered again.</p>

<h3>Leggy stretched growth</h3>
<p>Not enough light. The plant is reaching for a window. Move it closer to one, and trim the stretched growth back so the new growth comes in compact.</p>

<h2>Holidays and long absences</h2>
<p>Succulents, ZZ plants and snake plants need nothing for two to three weeks. Water them well before you leave and move them slightly away from the window so they use less. For thirstier plants, place the pot on a tray of damp expanded clay pebbles, or move it into a self watering pot before a long break. Do not ask a colleague to water your plants unless you write down the interval, because a well meaning daily watering kills more office plants than a fortnight of absence ever does.</p>

<h2>Repotting</h2>
<p>Most gift plants are comfortable in their pot for a year or more. Repot when roots come through the drainage hole, when water runs straight through without soaking in, or when growth stops entirely during the growing season. Move up one pot size only. A plant in a pot that is far too large sits in wet soil it cannot use, which brings you back to the first problem on this page.</p>
',
		'faqs'       => array(
			array( 'q' => 'How often should I water an office desk plant?', 'a' => 'It depends on the species rather than a general rule. Succulents every twelve to twenty one days, pothos and peace lily weekly, ZZ plants every three to four weeks. The table above lists the interval in days for each plant we ship.' ),
			array( 'q' => 'Why are my plant leaves turning yellow?', 'a' => 'Almost always overwatering. Let the soil dry through, check the pot actually drains, and empty the saucer ten minutes after watering. Yellowing on the lowest leaves of an otherwise healthy plant is usually just age.' ),
			array( 'q' => 'What causes brown crispy leaf tips?', 'a' => 'Dry air or the fluoride and chlorine in tap water. Move the plant away from an air conditioning vent and switch to filtered or rested water. Trim the brown edges with scissors following the natural leaf shape.' ),
			array( 'q' => 'Can office plants survive without natural light?', 'a' => 'ZZ plants, snake plants, Aglaonema and Haworthia genuinely can under ceiling lighting. Most other plants slowly decline. If a position is more than three metres from a window, choose from that shortlist rather than hoping.' ),
			array( 'q' => 'How do I look after plants during a two week holiday?', 'a' => 'Succulents, ZZ plants and snake plants need nothing. Water them well beforehand and move them slightly further from the window. For thirstier plants, stand the pot on a tray of damp clay pebbles or move it into a self watering pot.' ),
			array( 'q' => 'Should I ask a colleague to water my plants while I am away?', 'a' => 'Only with written instructions including the interval in days. A well meaning colleague watering daily kills more office plants than two weeks of neglect ever does.' ),
			array( 'q' => 'When should a plant be repotted?', 'a' => 'When roots emerge from the drainage hole, when water runs straight through without soaking in, or when growth stops during the growing season. Move up one pot size only, since an oversized pot holds wet soil the plant cannot use.' ),
			array( 'q' => 'Do office plants need fertiliser?', 'a' => 'A balanced liquid feed at half strength every six to eight weeks during the growing season is plenty. Feeding a plant in low light or in winter does more harm than good, since it cannot use the nutrients.' ),
			array( 'q' => 'What are the small flies around my plant?', 'a' => 'Fungus gnats, which breed in permanently damp topsoil. Let the top three centimetres dry between waterings and they disappear within a fortnight. They are a symptom of overwatering rather than a pest problem in themselves.' ),
			array( 'q' => 'My plant looks stretched and thin. What is wrong?', 'a' => 'Not enough light. The plant is reaching toward the nearest window. Move it closer to one and cut the stretched growth back so the new growth comes in compact rather than continuing to reach.' ),
		),
	),

	/* ==================================================================== */
	array(
		'title'      => 'Pan India Plant Delivery for Corporate Orders',
		'slug'       => 'pan-india-plant-delivery',
		'menu_title' => 'Delivery',
		'eyebrow'    => 'Logistics',
		'focus'      => 'pan india plant delivery',
		'meta_title' => 'Pan India Plant Delivery for Corporate Gift Orders',
		'meta_desc'  => 'How we pack and ship live plants across India. Transit times, packing standards, home and office delivery options, and the damage replacement promise.',
		'excerpt'    => 'How live plants actually reach a desk in one piece: hardening, packing, transit windows and what to do when something goes wrong.',
		'highlights' => array( 'Hardened before dispatch', 'Double wall cartons', 'Tracking per recipient', '48 hour claim window' ),
		'cats'       => array( 'low-maintenance-plant-gifts', 'succulent-corporate-gifts', 'air-plant-gifts' ),
		'content'    => '
<p class="pg-lede">Shipping a living thing is a different problem from shipping a mug. The plant has to survive several days in the dark, sideways handling, temperature swings and a final mile that nobody controls. Most of what determines whether it arrives well happens before the box is sealed.</p>

<h2>What happens before dispatch</h2>

<h3>Hardening</h3>
<p>For a week before dispatch, plants are gradually moved to lower light and reduced watering. This slows their metabolism so a few days in a dark box is a pause rather than a shock. Plants shipped straight from a bright, well watered nursery bench arrive stressed regardless of how well they are packed.</p>

<h3>Soil trimming</h3>
<p>Excess soil is removed to reduce weight and to lower the chance of the root ball shifting in transit. Less soil also means less moisture sloshing around inside a sealed box, which is what causes fungal problems on arrival.</p>

<h3>Inspection</h3>
<p>Every unit is checked for pests, damaged leaves and pot defects before packing. Anything marginal is pulled. It is cheaper to reject a plant at this stage than to replace it after delivery.</p>

<h2>How the box is built</h2>

<h3>Soil retention</h3>
<p>A mesh disc is fitted over the soil surface and secured to the pot rim. Without it, soil coats the leaves during transit and the plant arrives looking neglected even when it is perfectly healthy.</p>

<h3>Moulded inserts</h3>
<p>Each pot sits in a pulp or corrugated insert that holds it upright and prevents contact with the carton wall. Fragile items such as glass terrariums get an additional pulp shell.</p>

<h3>Double wall cartons</h3>
<p>Marked for upright transit with fragile and live plant labels on multiple faces. The labels do not guarantee careful handling, but they measurably improve it.</p>

<h3>Ventilation</h3>
<p>Small vents allow gas exchange without letting the box collapse. A fully sealed box builds humidity and encourages rot within three days.</p>

<h2>Transit times</h2>
<div class="pg-table-scroll">
<table>
<thead><tr><th scope="col">Destination</th><th scope="col">Typical transit</th><th scope="col">Notes</th></tr></thead>
<tbody>
<tr><th scope="row">Same city</th><td>1 to 2 days</td><td>Best outcome for fragile items</td></tr>
<tr><th scope="row">Metro to metro</th><td>2 to 4 days</td><td>Standard for most corporate rounds</td></tr>
<tr><th scope="row">Tier two and three cities</th><td>4 to 6 days</td><td>Choose hardier species</td></tr>
<tr><th scope="row">North east and hill stations</th><td>6 to 9 days</td><td>Succulents and air plants only</td></tr>
</tbody>
</table>
</div>
<p>Add three to four days during festival weeks. These are working day estimates and exclude the day of dispatch.</p>

<h2>Office delivery versus home delivery</h2>

<h3>Consolidated office delivery</h3>
<p>One address, counted cartons, one tracking number, lowest cost per unit. Your workplace team distributes internally. This is the cheapest option by a wide margin and it is worth choosing whenever people are actually in the office.</p>

<h3>Individual home delivery</h3>
<p>Each recipient gets their own box with their own tracking link. Considerably more expensive because every unit carries its own packaging and courier charge, but it is the only option that works for a distributed team.</p>

<h4>What we need for home delivery</h4>
<ul>
<li>Full address with pin code</li>
<li>A phone number, since couriers call before attempting delivery</li>
<li>Any building access notes such as a gate or reception name</li>
</ul>

<h2>When something goes wrong</h2>
<p>Photograph the affected units within 48 hours of delivery and send them to us. We replace damaged, wilted or incorrect items at no cost, including branded and personalised pots. We do not ask for the packaging back and we do not require the courier to confirm anything. The 48 hour window exists because after that it becomes impossible to tell transit damage from care after arrival, and it is the only condition attached.</p>

<h2>What we will not ship</h2>
<p>Live plants across international borders, because of phytosanitary restrictions in most destination countries. Glass terrariums to hill stations and the north east, where transit is too long and handling too rough. Flowering plants during a heatwave, where the blooms will not survive the journey and the gift lands looking worse than a plain foliage plant would have. In each case we will suggest an alternative rather than shipping something we expect to fail.</p>
',
		'faqs'       => array(
			array( 'q' => 'How long does plant delivery take across India?', 'a' => 'One to two days within a city, two to four days between metros, four to six days for tier two and three cities, and six to nine days for the north east and hill stations. Add three to four days during festival weeks.' ),
			array( 'q' => 'Do plants survive four or five days in a box?', 'a' => 'Succulents, air plants, snake plants and ZZ plants comfortably do, which is why they are the species we recommend for long routes. Flowering plants and bonsai are better kept to shorter transits.' ),
			array( 'q' => 'What happens if a plant arrives damaged?', 'a' => 'Photograph it within 48 hours of delivery and we replace it at no cost, including branded and personalised pots. We do not need the packaging back or a courier report, and there is no other condition attached.' ),
			array( 'q' => 'Can you deliver to individual employee home addresses?', 'a' => 'Yes. Send a spreadsheet with names, full addresses with pin codes and phone numbers, and each recipient gets their own box with a tracking link. It costs more per unit than an office drop because of the individual packaging and courier charges.' ),
			array( 'q' => 'Is office delivery cheaper than home delivery?', 'a' => 'Considerably. One consolidated delivery to a single address avoids per unit courier charges and individual packaging. Where people are actually in the office, it is the single biggest saving available on a bulk round.' ),
			array( 'q' => 'Do you deliver internationally?', 'a' => 'No. Live plants face phytosanitary restrictions in most countries and we will not ship something likely to be seized at customs. For international recipients we suggest preserved moss frames or seed paper gifts instead.' ),
			array( 'q' => 'How are the plants packed for transit?', 'a' => 'A mesh disc secures the soil, the pot sits in a moulded insert, and the whole thing travels in a vented double wall carton marked for upright handling. Fragile items get an additional pulp shell.' ),
			array( 'q' => 'Can we choose the delivery date?', 'a' => 'Yes, and for corporate rounds we recommend it. Tell us the date the gift must be on the desk and we work the dispatch backwards from there, building in buffer for the route and the season.' ),
			array( 'q' => 'What if nobody is available to receive an office delivery?', 'a' => 'The courier reattempts the next working day. For large consolidated deliveries this matters more than usual, so we ask for a named contact and a delivery window, and we call ahead on the day.' ),
			array( 'q' => 'Do you ship during the summer heat?', 'a' => 'Yes for succulents, air plants and hardy foliage. We avoid shipping flowering plants during a heatwave because the blooms do not survive the journey, and we will suggest a foliage alternative rather than sending something that arrives looking poor.' ),
		),
	),

);
