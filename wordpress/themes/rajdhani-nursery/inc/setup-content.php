<?php
/**
 * One time content setup, runs on theme activation.
 *
 * Creates all service pages with SEO friendly slugs, hand written meta
 * descriptions, the booking page, plans page, FAQs page and contact page.
 * Sets pretty permalinks, the static front page and the primary menu.
 *
 * @package Rajdhani_Nursery
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Page definitions: slug => [title, meta description, service schema name, content].
 */
function rn_get_seed_pages() {
	$booking = home_url( '/book-maali-online/' );
	$plans   = home_url( '/maali-service-plans/' );

	return array(

		/* ---------------- Home ---------------- */
		'home' => array(
			'title'   => 'Mali On Rent & Gardener Online Delhi | Rajdhani Nursery',
			'meta'    => 'Book maali online in Delhi with Rajdhani Nursery. Mali on rent for 1 hour to full day, verified gardeners, weekly and monthly plans from Rs 1,499. Serving all Delhi NCR.',
			'schema'  => '',
			'content' => '<!-- Home page content is rendered by the front-page.php template. Edit sections under Appearance > Customize or in the theme files. -->',
		),

		/* ---------------- Service page 1 ---------------- */
		'mali-on-rent-delhi' => array(
			'title'   => 'Mali On Rent in Delhi',
			'meta'    => 'Hire a trusted mali on rent in Delhi from Rajdhani Nursery. Hourly, daily, weekly and monthly maali services with verified gardeners. Book online, starting Rs 349 per visit.',
			'schema'  => 'Mali On Rent in Delhi',
			'content' => <<<HTML
<p>Looking for a reliable mali on rent in Delhi? Rajdhani Nursery sends trained and background verified maalis to homes, farmhouses, societies and offices across Delhi NCR. Whether your garden needs a quick one hour visit or a dedicated gardener every day, you can book a maali online in minutes and relax while we take care of the rest.</p>

<h2>Why Hire a Mali On Rent from Rajdhani Nursery</h2>
<p>Delhi weather is tough on plants. Harsh summers, dusty winds and cold winters mean your garden needs regular, skilled attention. A professional maali knows exactly when to water, when to prune and how to protect plants season by season. With our mali rental service you get that expertise without the cost of a full time employee.</p>

<h3>Verified and Experienced Gardeners</h3>
<p>Every maali on our team is background verified and carries years of hands on experience with Delhi soil, local plant varieties and seasonal flowers. Most of our gardeners have worked with us for five years or more, so you can trust the person who enters your home.</p>

<h3>Flexible Booking, From One Hour to Full Day</h3>
<p>You choose how long the maali works. Book for 1 hour, 2 hours, 4 hours, 6 hours or a full day of 8 hours. Pick a date and time slot from the calendar on our booking page and we confirm your visit on call or WhatsApp.</p>

<h4>One Time Visit Charges</h4>
<ul>
<li>1 hour visit: Rs 349</li>
<li>2 hours visit: Rs 549</li>
<li>4 hours visit: Rs 999</li>
<li>6 hours visit: Rs 1,299</li>
<li>Full day (8 hours): Rs 1,599</li>
</ul>

<h2>What Work Does Our Mali Do</h2>
<p>Our maalis handle the complete range of garden work during every visit:</p>
<ul>
<li>Watering of plants, pots and lawns</li>
<li>Pruning, trimming and shaping of plants and hedges</li>
<li>Weeding and removal of dry leaves</li>
<li>Soil loosening (gudai) and mixing of manure</li>
<li>Repotting and shifting of plants</li>
<li>Lawn mowing and edge cutting</li>
<li>Pest and disease inspection</li>
<li>Complete garden cleaning before leaving</li>
</ul>

<h3>What Is Included and What Is Chargeable</h3>
<p>The maali's labour, basic hand tools and travel within our service area are included in the price. Materials such as khaad, fertilizers, pesticides, new pots, fresh soil, grass and plants are chargeable at actual nursery cost. We always take your approval before buying anything.</p>

<h2>Weekly and Monthly Mali Plans</h2>
<p>Need regular care instead of a one time visit? Our monthly plans start at Rs 1,499 with one visit every week and go up to a full day dedicated maali who reports to your property six days a week. Every monthly plan comes with a fixed gardener, so the same trusted person looks after your garden on every visit. See the full details on our <a href="{$plans}">maali service plans and pricing</a> page.</p>

<h3>Areas We Serve</h3>
<p>We provide mali on rent across South Delhi, North Delhi, East Delhi, West Delhi and Central Delhi, plus Noida, Gurugram, Ghaziabad, Faridabad and Greater Noida. Popular localities include Saket, Vasant Kunj, Greater Kailash, Dwarka, Rohini and Pitampura.</p>

<h4>How to Book Your Mali</h4>
<ol>
<li>Open the <a href="{$booking}">Book Maali Online</a> page</li>
<li>Fill your name, mobile number and address</li>
<li>Choose duration, date and time slot</li>
<li>Get confirmation on call or WhatsApp</li>
</ol>

<p>Your garden deserves expert hands. Book a mali on rent in Delhi today with Rajdhani Nursery and see the difference a professional maali makes.</p>
HTML,
		),

		/* ---------------- Service page 2 ---------------- */
		'gardener-on-rent-delhi' => array(
			'title'   => 'Gardener On Rent in Delhi',
			'meta'    => 'Professional gardener on rent in Delhi NCR. Hire an online gardener for lawn care, plant care and garden upkeep. Hourly and monthly gardener services by Rajdhani Nursery.',
			'schema'  => 'Gardener On Rent in Delhi',
			'content' => <<<HTML
<p>Rajdhani Nursery makes it simple to hire a professional gardener on rent in Delhi. From small balcony gardens to sprawling farmhouse lawns, our trained gardeners bring the skill, tools and care your green space needs. Book a gardener online for a single visit or set up a regular schedule that suits your routine.</p>

<h2>Professional Gardener Services for Every Space</h2>
<p>No two gardens are the same, and neither are our services. Tell us about your space while booking and we assign a gardener with the right experience for the job.</p>

<h3>Home Gardens and Lawns</h3>
<p>Our gardeners maintain home lawns with regular mowing, edge trimming, aeration and seasonal reseeding. Flower beds are prepared and planted according to the season, so your garden stays colourful through the year.</p>

<h3>Terrace and Balcony Gardens</h3>
<p>Terrace gardens in Delhi need special attention to drainage, pot health and summer heat protection. Our gardeners are experienced with container gardening, vertical setups and kitchen gardens on terraces.</p>

<h3>Society and Office Gardens</h3>
<p>We provide scheduled gardener services for housing societies, schools, hotels and corporate offices, complete with supervisor checks and monthly reporting. Ask us for a custom quote for larger properties.</p>

<h2>What Your Gardener Will Do</h2>
<h4>Included in Every Visit</h4>
<ul>
<li>Watering and moisture check of all plants</li>
<li>Pruning, deadheading and shaping</li>
<li>Weeding of beds, pots and lawn</li>
<li>Soil work, hoeing and manure mixing</li>
<li>Cleaning of the garden area after work</li>
</ul>

<h4>Available on Request</h4>
<ul>
<li>Lawn mowing and grass replacement</li>
<li>Repotting and new plantation</li>
<li>Organic pest and disease treatment</li>
<li>New garden design and setup</li>
<li>Seasonal flower bed preparation</li>
</ul>

<h2>Gardener Charges in Delhi</h2>
<p>One time gardener visits start at Rs 349 for one hour. Most homes choose our 2 hour visit at Rs 549, which covers watering, pruning and cleaning for a medium garden. Monthly gardener plans start at Rs 1,499 for weekly visits. Materials like fertilizer, soil and pots are extra and billed at actual cost with your approval.</p>

<h3>Why Delhi Trusts Rajdhani Nursery</h3>
<ul>
<li>Background verified gardeners with 5+ years of experience</li>
<li>Same gardener assigned in all monthly plans</li>
<li>Nursery backed service with plants and material supply</li>
<li>Free replacement visit if your gardener is absent</li>
<li>Support on WhatsApp and phone, seven days a week</li>
</ul>

<h3>Book a Gardener Online in Two Minutes</h3>
<p>Choose your duration, pick a date and time from the calendar, and confirm. It is that easy. Visit the <a href="{$booking}">online booking page</a> now, or message us on WhatsApp using the green button on your screen and our team will arrange everything for you.</p>
HTML,
		),

		/* ---------------- Service page 3 ---------------- */
		'garden-maintenance-services-delhi' => array(
			'title'   => 'Garden Maintenance Services in Delhi',
			'meta'    => 'Complete garden maintenance services in Delhi NCR. Weekly and monthly garden upkeep, lawn mowing, pruning and seasonal care by Rajdhani Nursery maalis. Plans from Rs 1,499.',
			'schema'  => 'Garden Maintenance Services in Delhi',
			'content' => <<<HTML
<p>A beautiful garden is the result of regular, planned care. Rajdhani Nursery offers complete garden maintenance services in Delhi that keep your lawn green, your plants healthy and your outdoor space ready to enjoy in every season. Choose a weekly or monthly plan and let our maalis handle the hard work.</p>

<h2>Complete Garden Upkeep, Season After Season</h2>
<p>Delhi gardens face intense summers, monsoon overgrowth and winter frost. Our maintenance schedule adapts to each season so your garden gets the right care at the right time.</p>

<h3>Summer Care (April to June)</h3>
<p>Deep watering schedules, mulching to protect roots, shade management for delicate plants and drip checks for terrace gardens.</p>

<h3>Monsoon Care (July to September)</h3>
<p>Drainage checks, fungal disease prevention, aggressive weed control and pruning of fast growing branches and creepers.</p>

<h3>Winter Care (October to February)</h3>
<p>Seasonal flower plantation, frost protection, lawn top dressing and preparing beds for the famous Delhi winter blooms.</p>

<h2>What Our Garden Maintenance Covers</h2>
<h4>Every Scheduled Visit Includes</h4>
<ul>
<li>Watering of lawn, beds and pots</li>
<li>Lawn mowing and edge trimming as needed</li>
<li>Pruning, trimming and hedge shaping</li>
<li>Weeding and dry leaf removal</li>
<li>Soil loosening and aeration</li>
<li>Pest and disease inspection</li>
<li>Full cleanup before the maali leaves</li>
</ul>

<h4>Chargeable Extras (billed at actual cost)</h4>
<ul>
<li>Fertilizers, manure and khaad</li>
<li>Pesticides and fungicides</li>
<li>New plants, seeds and grass</li>
<li>Pots, planters and fresh soil</li>
</ul>

<h2>Maintenance Plans and Visit Frequency</h2>
<p>Pick the visit frequency that matches your garden size:</p>
<ul>
<li><strong>Basic Green Plan, Rs 1,499 per month:</strong> 1 visit a week, 4 visits a month. Good for balcony gardens and up to 25 pots.</li>
<li><strong>Standard Care Plan, Rs 2,799 per month:</strong> 2 visits a week, 8 visits a month. Ideal for homes with 25 to 60 pots.</li>
<li><strong>Premium Garden Plan, Rs 3,999 per month:</strong> 3 visits a week, 12 visits a month. Made for gardens with lawns.</li>
<li><strong>Daily Maali Plan, Rs 6,999 per month:</strong> 6 visits a week, Monday to Saturday.</li>
<li><strong>Full Day Dedicated Maali, Rs 13,999 per month:</strong> a full time gardener at your property every working day.</li>
</ul>
<p>Compare all plans in detail on our <a href="{$plans}">plans and pricing page</a>.</p>

<h3>Trusted by Homes and Businesses Across Delhi NCR</h3>
<p>From independent houses in South Delhi to society gardens in Dwarka and office campuses in Noida and Gurugram, our teams maintain hundreds of gardens every week. Supervisors visit regularly in the larger plans and you get direct WhatsApp support whenever you need us.</p>

<h3>Start Your Garden Maintenance Today</h3>
<p><a href="{$booking}">Book your first visit online</a> and see the quality of our work before committing to a monthly plan. Most customers upgrade to a plan after the very first visit.</p>
HTML,
		),

		/* ---------------- Service page 4 ---------------- */
		'plant-care-services-delhi' => array(
			'title'   => 'Plant Care Services in Delhi',
			'meta'    => 'Expert plant care services in Delhi by Rajdhani Nursery. Indoor plant care, repotting, pest treatment and plant doctor visits at home. Book a plant care maali online.',
			'schema'  => 'Plant Care Services in Delhi',
			'content' => <<<HTML
<p>Plants are living companions and they tell you when something is wrong: yellowing leaves, drooping stems, slow growth. Rajdhani Nursery brings professional plant care services to your doorstep in Delhi. Our maalis diagnose problems, treat diseases and set up care routines that keep your plants thriving all year.</p>

<h2>Specialist Care for Indoor and Outdoor Plants</h2>
<p>Coming from a working plant nursery, our gardeners know plants deeply. They understand what each variety needs in Delhi's climate, from moisture loving ferns to hardy succulents.</p>

<h3>Indoor Plant Care</h3>
<p>Indoor plants like areca palm, snake plant, money plant, ZZ plant and peace lily need the right light, careful watering and periodic leaf cleaning. Our maali sets up a simple routine and handles the technical parts like soil refresh and root health checks.</p>

<h3>Outdoor and Flowering Plant Care</h3>
<p>Roses, hibiscus, bougainvillea, champa and seasonal flowers each demand specific pruning and feeding. We time these correctly so you get maximum blooms in every season.</p>

<h3>Repotting and Soil Health</h3>
<p>Most Delhi plant problems begin in the soil. Our team checks root health, refreshes the potting mix, adds the right manure and moves plants to bigger pots when needed. Repotting labour is included in your visit; new pots and soil are chargeable at nursery rates.</p>

<h2>Plant Doctor Visits</h2>
<p>Is a favourite plant struggling? Book a plant care visit and our experienced maali will inspect it, identify the pest or disease and treat it, usually with organic remedies first. You also get simple prevention tips so the problem does not return.</p>

<h4>Common Problems We Treat</h4>
<ul>
<li>Yellowing or browning leaves</li>
<li>Mealybugs, aphids and spider mites</li>
<li>Fungal spots and root rot</li>
<li>Overwatering and drainage issues</li>
<li>Weak growth and flowering failure</li>
</ul>

<h2>Plant Care Visit Frequency and Charges</h2>
<p>For a home with mostly potted plants, one focused visit each week is usually enough. Our Basic Green Plan at Rs 1,499 per month covers 4 weekly visits of one hour each. Larger collections do better with the Standard Care Plan at Rs 2,799 per month with 8 visits. One time plant care visits start at Rs 349 for one hour.</p>

<h4>Included vs Chargeable</h4>
<ul>
<li><strong>Included:</strong> maali labour, inspection, pruning, watering setup and basic tools</li>
<li><strong>Chargeable:</strong> fertilizers, pesticides, pots, soil and any new plants, always with your approval first</li>
</ul>

<h3>Plants and Supplies from Our Own Nursery</h3>
<p>Because we run our own nursery in Delhi, your maali can bring healthy plants, quality potting mix and genuine fertilizers on the next visit at fair nursery prices. No middlemen, no doubtful quality.</p>

<h3>Give Your Plants Expert Care</h3>
<p><a href="{$booking}">Book a plant care visit online</a> today, or ask us anything on WhatsApp. A healthier, greener home is one visit away.</p>
HTML,
		),

		/* ---------------- Service page 5 ---------------- */
		'terrace-garden-maintenance-delhi' => array(
			'title'   => 'Terrace Garden Maintenance in Delhi',
			'meta'    => 'Terrace and balcony garden maintenance in Delhi. Waterproof friendly care, kitchen garden support and container plant services by Rajdhani Nursery maalis.',
			'schema'  => 'Terrace Garden Maintenance in Delhi',
			'content' => <<<HTML
<p>Terrace gardens are Delhi's favourite way to grow green in limited space, but they need a different kind of care than ground gardens. Rajdhani Nursery provides dedicated terrace garden maintenance in Delhi with maalis trained in container gardening, rooftop drainage and kitchen gardens.</p>

<h2>Why Terrace Gardens Need Special Care</h2>
<p>A rooftop garden lives in harsher conditions: direct sunlight all day, faster drying soil, wind exposure and the constant concern of water seepage into the building. Our maalis are trained to manage all of these while keeping your terrace lush and productive.</p>

<h3>Seepage Safe Watering</h3>
<p>We water carefully with attention to drainage trays and outlet flow, so your plants get enough moisture without risking the roof below. We also flag drainage problems early, before they become expensive repairs.</p>

<h3>Heat and Wind Protection</h3>
<p>In peak summer we adjust watering times, add mulch, group sensitive pots and recommend shade nets where needed. In winter we reposition pots for maximum sun.</p>

<h2>Kitchen Garden Support</h2>
<p>Grow your own tomatoes, chillies, spinach, coriander and mint on your terrace. Our maalis handle sowing schedules, organic feeding, staking and harvest timing so your family gets fresh, chemical free vegetables through the season.</p>

<h4>What We Grow With You</h4>
<ul>
<li>Leafy greens: spinach, methi, coriander, mint</li>
<li>Vegetables: tomato, chilli, brinjal, okra, gourds</li>
<li>Herbs: tulsi, lemongrass, curry patta, ajwain</li>
<li>Seasonal flowers for colour through the year</li>
</ul>

<h2>Terrace Garden Services and Visit Plans</h2>
<h3>Every Maintenance Visit Includes</h3>
<ul>
<li>Watering with drainage check</li>
<li>Pruning, pinching and deadheading</li>
<li>Weeding and pot surface cleaning</li>
<li>Soil loosening and feeding schedule</li>
<li>Pest inspection with organic first treatment</li>
<li>Terrace floor cleanup after work</li>
</ul>

<h3>Recommended Visit Frequency</h3>
<p>Small balconies do well with one visit a week under the Basic Green Plan at Rs 1,499 per month. Full terrace gardens with vegetables need two to three visits a week, covered by the Standard Care Plan at Rs 2,799 or the Premium Garden Plan at Rs 3,999 per month. See all options on the <a href="{$plans}">plans page</a>.</p>

<h4>New Terrace Garden Setup</h4>
<p>Starting from scratch? We design and build complete terrace gardens: lightweight potting mix, proper containers, drip systems and plant selection suited to your terrace direction and sunlight. Setup projects are quoted separately after a free assessment visit.</p>

<h3>Book a Terrace Garden Expert</h3>
<p><a href="{$booking}">Book your maali online</a> and choose Balcony / Terrace Garden as your garden type. Prefer to talk first? Tap the WhatsApp button and tell us about your terrace.</p>
HTML,
		),

		/* ---------------- Plans page ---------------- */
		'maali-service-plans' => array(
			'title'   => 'Maali Service Plans & Pricing',
			'meta'    => 'Maali service plans in Delhi from Rs 1,499 per month. Compare 5 gardening plans by visits per week and month, what is included and what is chargeable. Book online.',
			'schema'  => 'Maali Service Plans in Delhi',
			'content' => <<<HTML
<p>Simple, honest pricing for professional garden care in Delhi. Choose from five maali service plans based on how often your garden needs attention. Every plan includes a verified gardener, basic tools and full support on WhatsApp. No hidden charges, ever.</p>

[rn_plans]

<h2>Compare All Plans at a Glance</h2>
<table>
<thead>
<tr><th>Plan</th><th>Visits per Week</th><th>Visits per Month</th><th>Time per Visit</th><th>Monthly Price</th></tr>
</thead>
<tbody>
<tr><td>Basic Green Plan</td><td>1</td><td>4</td><td>1 hour</td><td>Rs 1,499</td></tr>
<tr><td>Standard Care Plan</td><td>2</td><td>8</td><td>1.5 hours</td><td>Rs 2,799</td></tr>
<tr><td>Premium Garden Plan</td><td>3</td><td>12</td><td>2 hours</td><td>Rs 3,999</td></tr>
<tr><td>Daily Maali Plan</td><td>6 (Mon to Sat)</td><td>24 to 26</td><td>2 hours</td><td>Rs 6,999</td></tr>
<tr><td>Full Day Dedicated Maali</td><td>6 (Mon to Sat)</td><td>24 to 26</td><td>Full day, 8 hours</td><td>Rs 13,999</td></tr>
</tbody>
</table>

<h2>One Time Visit Pricing</h2>
<p>Not ready for a monthly plan? Book a single visit and pay per hour:</p>
<table>
<thead>
<tr><th>Duration</th><th>Price</th><th>Best For</th></tr>
</thead>
<tbody>
<tr><td>1 Hour</td><td>Rs 349</td><td>Balcony gardens, quick plant check</td></tr>
<tr><td>2 Hours</td><td>Rs 549</td><td>Medium home gardens, regular upkeep</td></tr>
<tr><td>4 Hours</td><td>Rs 999</td><td>Large gardens, seasonal deep work</td></tr>
<tr><td>6 Hours</td><td>Rs 1,299</td><td>Repotting projects, garden makeover</td></tr>
<tr><td>Full Day (8 Hours)</td><td>Rs 1,599</td><td>Farmhouses, new garden setup</td></tr>
</tbody>
</table>

<h2>What Is Included in Every Plan</h2>
<h3>Always Included</h3>
<ul>
<li>Trained, background verified maali</li>
<li>Basic hand tools (khurpi, secateurs, pipe fittings)</li>
<li>Travel within our Delhi NCR service area</li>
<li>Watering, pruning, weeding, soil work and cleanup</li>
<li>WhatsApp support and visit reminders</li>
<li>Free replacement maali if yours is on leave (monthly plans)</li>
</ul>

<h3>Chargeable at Actual Cost</h3>
<ul>
<li>Fertilizers, manure, khaad and compost</li>
<li>Pesticides and plant medicines</li>
<li>New plants, seeds, grass and saplings</li>
<li>Pots, planters and potting soil</li>
<li>Machine work such as heavy lawn mowing equipment (small charge, informed in advance)</li>
</ul>
<p>We never buy any material without your approval. As a plant nursery ourselves, we supply everything at genuine nursery prices.</p>

<h4>How Visits Work</h4>
<p>Your maali arrives at the fixed time, completes the visit checklist for your plan, and updates you before leaving. In monthly plans the same gardener is assigned to your home so your plants get consistent care. Missed a visit due to rain or a holiday? We adjust it within the same month.</p>

<h3>Ready to Start?</h3>
<p><a href="{$booking}">Book your maali online now</a>. Start with a one time visit or jump straight into a plan. You can upgrade, downgrade or pause your plan any month with a simple WhatsApp message.</p>
HTML,
		),

		/* ---------------- Booking page ---------------- */
		'book-maali-online' => array(
			'title'   => 'Book Maali Online',
			'meta'    => 'Book a maali online in Delhi in two minutes. Choose 1 hour to full day duration, pick your date and time slot from the calendar and get instant confirmation.',
			'schema'  => 'Online Maali Booking in Delhi',
			'content' => <<<HTML
<p>Booking a maali in Delhi has never been easier. Choose how long you need the gardener, pick a convenient date and time slot from the calendar below, and submit. Our team confirms every booking personally on call or WhatsApp, usually within a few hours.</p>

[maali_booking_form]

<h2>How Online Maali Booking Works</h2>
<ol>
<li><strong>Fill the form:</strong> your name, mobile number and address help us send the right maali to the right place.</li>
<li><strong>Choose duration:</strong> 1 hour, 2 hours, 4 hours, 6 hours or a full day. The price updates as you select.</li>
<li><strong>Pick date and time:</strong> select any date from tomorrow onwards and a time slot between 7 AM and 5 PM.</li>
<li><strong>Get confirmation:</strong> we call or message you on WhatsApp to confirm the visit and any special requirements.</li>
</ol>

<h3>Payment</h3>
<p>Pay after the visit, once you are happy with the work. We accept UPI, cash and bank transfer. Monthly plan customers pay at the start of each month.</p>

<h3>Need Help Booking?</h3>
<p>Tap the green WhatsApp button on your screen and send us a message. Our team will book the maali for you and answer any questions about pricing, plans or your garden.</p>
HTML,
		),

		/* ---------------- FAQs page ---------------- */
		'faqs' => array(
			'title'   => 'Frequently Asked Questions',
			'meta'    => 'Answers to common questions about maali booking, mali on rent charges in Delhi, service areas, visit plans and what is included in Rajdhani Nursery gardening services.',
			'schema'  => '',
			'content' => <<<HTML
<p>Everything you need to know about booking a maali online, our gardening service plans, charges and coverage across Delhi NCR. Can't find your answer here? Message us on WhatsApp and we will reply quickly.</p>

[rn_faqs]

<h2>Still Have Questions?</h2>
<p>Our team is available seven days a week from 7 AM to 7 PM. Tap the WhatsApp button on your screen, call us, or <a href="{$booking}">book a maali online</a> and add your question in the special instructions box.</p>
HTML,
		),

		/* ---------------- About page ---------------- */
		'about-us' => array(
			'title'   => 'About Rajdhani Nursery',
			'meta'    => 'Rajdhani Nursery is a plant nursery in Delhi providing plants, mali on rent and professional gardening services across Delhi NCR with verified, experienced maalis.',
			'schema'  => '',
			'content' => <<<HTML
<p>Rajdhani Nursery began as a plant nursery in Delhi with a simple belief: every home deserves a green corner, and every green corner deserves proper care. Today we grow and sell plants online, and our team of verified maalis cares for hundreds of gardens across Delhi NCR every week.</p>

<h2>From Nursery to Your Garden</h2>
<p>Because we grow plants ourselves, we understand them better than any agency. Our maalis train at the nursery, learning soil preparation, seasonal care and organic pest management before they ever visit a customer's home. When you hire a gardener from us, you get nursery grade expertise at your doorstep.</p>

<h3>What We Offer</h3>
<ul>
<li>Plants, pots and gardening supplies from our Delhi nursery</li>
<li>Mali on rent for hourly, daily and full day bookings</li>
<li>Weekly and monthly garden maintenance plans</li>
<li>Terrace, balcony and kitchen garden services</li>
<li>Plant care and plant doctor visits at home</li>
</ul>

<h3>Our Promise</h3>
<ul>
<li>Verified gardeners you can trust inside your home</li>
<li>Transparent pricing with no hidden charges</li>
<li>Materials only with your approval, at nursery prices</li>
<li>A real team behind every booking, on call and WhatsApp</li>
</ul>

<h4>Serving All of Delhi NCR</h4>
<p>South Delhi, North Delhi, East Delhi, West Delhi, Central Delhi, Noida, Gurugram, Ghaziabad, Faridabad and Greater Noida.</p>

<p><a href="{$booking}">Book your first maali visit</a> and experience the Rajdhani Nursery difference.</p>
HTML,
		),

		/* ---------------- Contact page ---------------- */
		'contact-us' => array(
			'title'   => 'Contact Us',
			'meta'    => 'Contact Rajdhani Nursery in Delhi for maali booking, gardening services and plant orders. Reach us on phone, WhatsApp or email, open 7 AM to 7 PM every day.',
			'schema'  => '',
			'content' => <<<HTML
<p>We would love to hear from you. Whether you want to book a maali, ask about a plan, order plants or get advice for a struggling plant, our team responds quickly on every channel.</p>

<h2>Reach Rajdhani Nursery</h2>
<h3>WhatsApp (fastest)</h3>
<p>Tap the green WhatsApp button on your screen and send us a message. We usually reply within minutes during working hours.</p>

<h3>Phone</h3>
<p>Call us any day between 7 AM and 7 PM. You will find our number in the header and footer of this website.</p>

<h3>Visit Our Nursery</h3>
<p>Come see our plants in person. Our nursery in Delhi is open every day from 7 AM to 7 PM. Bring a photo of your garden and our team will suggest the right plants and care plan.</p>

<h2>Book Online Anytime</h2>
<p>The fastest way to schedule a gardener is our <a href="{$booking}">online maali booking page</a>. Choose your duration, date and time slot, and we handle the rest.</p>

<h4>Service Areas</h4>
<p>All of Delhi plus Noida, Gurugram, Ghaziabad, Faridabad and Greater Noida.</p>
HTML,
		),
	);
}

/**
 * Create pages, menu and settings on theme activation.
 */
function rn_seed_site_content() {
	// Pretty, SEO friendly permalinks.
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/%postname%/' );
	update_option( 'rewrite_rules', '' );
	$wp_rewrite->flush_rules( true );

	$menu_pages = array();

	foreach ( rn_get_seed_pages() as $slug => $page ) {
		$existing = get_page_by_path( 'home' === $slug ? 'home' : $slug );
		if ( $existing ) {
			$menu_pages[ $slug ] = $existing->ID;
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $page['title'],
				'post_name'    => $slug,
				'post_content' => $page['content'],
				'meta_input'   => array_filter(
					array(
						'_rn_meta_description'    => $page['meta'],
						'_rn_service_schema_name' => $page['schema'],
					)
				),
			)
		);

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			$menu_pages[ $slug ] = $page_id;
		}
	}

	// Static front page.
	if ( ! empty( $menu_pages['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $menu_pages['home'] );
	}

	// Primary menu.
	if ( ! wp_get_nav_menu_object( 'Primary Menu' ) ) {
		$menu_id = wp_create_nav_menu( 'Primary Menu' );

		$menu_items = array(
			'home'                              => 'Home',
			'mali-on-rent-delhi'                => 'Mali On Rent',
			'gardener-on-rent-delhi'            => 'Gardener On Rent',
			'garden-maintenance-services-delhi' => 'Garden Maintenance',
			'plant-care-services-delhi'         => 'Plant Care',
			'terrace-garden-maintenance-delhi'  => 'Terrace Gardens',
			'maali-service-plans'               => 'Plans & Pricing',
			'faqs'                              => 'FAQs',
			'contact-us'                        => 'Contact',
		);

		foreach ( $menu_items as $slug => $label ) {
			if ( empty( $menu_pages[ $slug ] ) ) {
				continue;
			}
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'     => $label,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $menu_pages[ $slug ],
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				)
			);
		}

		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		$locations['footer']  = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// Site tagline.
	if ( 'Just another WordPress site' === get_option( 'blogdescription' ) || ! get_option( 'blogdescription' ) ) {
		update_option( 'blogdescription', 'Mali On Rent & Gardener Online Delhi' );
	}
}
add_action( 'after_switch_theme', 'rn_seed_site_content' );
