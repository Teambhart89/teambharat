<?php
/**
 * Global product attributes used to build pot variations.
 *
 * Each attribute becomes a WooCommerce global attribute (pa_ prefixed) and the
 * terms below become the selectable options on every variable product.
 *
 * @package PlantGift_Core
 */

defined( 'ABSPATH' ) || exit;

return array(

	'pot-size' => array(
		'label'   => 'Pot Size',
		'type'    => 'select',
		'orderby' => 'menu_order',
		'terms'   => array(
			array(
				'name'        => '3 inch Mini Desk',
				'slug'        => '3-inch-mini-desk',
				'description' => 'A 3 inch rim diameter pot that fits beside a laptop, on a reception counter or inside an event giveaway box. Best for single succulents and air plants.',
				'price'       => 0,
			),
			array(
				'name'        => '4 inch Small Desk',
				'slug'        => '4-inch-small-desk',
				'description' => 'The most popular size for employee gifting. A 4 inch pot holds a rooted plant comfortably for a full year before it needs repotting.',
				'price'       => 60,
			),
			array(
				'name'        => '5 inch Medium',
				'slug'        => '5-inch-medium',
				'description' => 'Good for money plants, lucky bamboo and small foliage where the plant needs more root room and visual presence on the desk.',
				'price'       => 130,
			),
			array(
				'name'        => '6 inch Standard',
				'slug'        => '6-inch-standard',
				'description' => 'A cabin and lounge size. Suits snake plants, ZZ plants and bonsai that are meant to be noticed.',
				'price'       => 230,
			),
			array(
				'name'        => '8 inch Large',
				'slug'        => '8-inch-large',
				'description' => 'Floor and side table size for leadership gifting, peace lilies and areca palms.',
				'price'       => 420,
			),
		),
	),

	'pot-material' => array(
		'label'   => 'Pot Material',
		'type'    => 'select',
		'orderby' => 'menu_order',
		'terms'   => array(
			array(
				'name'        => 'Glazed Ceramic',
				'slug'        => 'glazed-ceramic',
				'description' => 'A fired ceramic pot with a smooth glaze. Holds moisture longer than clay, wipes clean easily and takes a fired logo decal beautifully.',
				'price'       => 0,
			),
			array(
				'name'        => 'Natural Terracotta',
				'slug'        => 'natural-terracotta',
				'description' => 'Unglazed clay that breathes through its walls. The right choice for succulents and cacti that rot in wet soil.',
				'price'       => -40,
			),
			array(
				'name'        => 'Self Watering',
				'slug'        => 'self-watering',
				'description' => 'A two chamber pot with a wick that draws water up from a reservoir. Keeps a plant alive through two to three weeks of travel.',
				'price'       => 180,
			),
			array(
				'name'        => 'Brushed Metal',
				'slug'        => 'brushed-metal',
				'description' => 'A powder coated steel or brass finish planter with a liner. Reads premium on a leadership desk and takes deep laser engraving.',
				'price'       => 210,
			),
			array(
				'name'        => 'Jute Wrapped',
				'slug'        => 'jute-wrapped',
				'description' => 'A plastic free jute sleeve over a compostable inner pot. The lightest option for event giveaways and courier heavy orders.',
				'price'       => -60,
			),
			array(
				'name'        => 'Glass Terrarium',
				'slug'        => 'glass-terrarium',
				'description' => 'A clear glass vessel that suits air plants and closed terrarium builds. Ships with a moulded insert to protect the walls.',
				'price'       => 140,
			),
			array(
				'name'        => 'Cast Concrete',
				'slug'        => 'cast-concrete',
				'description' => 'A matte concrete planter with a sealed interior. Heavy, stable and modern, and it takes a screen printed logo cleanly.',
				'price'       => 160,
			),
		),
	),

	'pot-design' => array(
		'label'   => 'Pot Design',
		'type'    => 'select',
		'orderby' => 'menu_order',
		'terms'   => array(
			array(
				'name'        => 'Matte Plain',
				'slug'        => 'matte-plain',
				'description' => 'A single flat colour with no pattern. The safest design when the pot has to sit on hundreds of different desks.',
				'price'       => 0,
			),
			array(
				'name'        => 'Glossy Two Tone',
				'slug'        => 'glossy-two-tone',
				'description' => 'A dipped glaze that fades from the rim to the base. Photographs well for internal announcement posts.',
				'price'       => 45,
			),
			array(
				'name'        => 'Geometric Facet',
				'slug'        => 'geometric-facet',
				'description' => 'A faceted outer wall that catches office lighting. Popular for milestone and anniversary gifting.',
				'price'       => 70,
			),
			array(
				'name'        => 'Minimal White',
				'slug'        => 'minimal-white',
				'description' => 'A clean white body that lets the plant and your logo do the talking.',
				'price'       => 25,
			),
			array(
				'name'        => 'Hand Painted',
				'slug'        => 'hand-painted',
				'description' => 'Painted by artisan partners in small batches. Each piece varies slightly, which suits limited run client gifting.',
				'price'       => 150,
			),
			array(
				'name'        => 'Textured Ribbed',
				'slug'        => 'textured-ribbed',
				'description' => 'Vertical ribbing that hides water marks and fingerprints on a busy desk.',
				'price'       => 55,
			),
			array(
				'name'        => 'Logo Engraved',
				'slug'        => 'logo-engraved',
				'description' => 'Your mark cut into the pot wall with a laser. Permanent, subtle and the most requested branding option.',
				'price'       => 110,
			),
			array(
				'name'        => 'Custom Brand Printed',
				'slug'        => 'custom-brand-printed',
				'description' => 'Full colour printing on the pot or the sleeve, with the artwork approved on a mockup before production.',
				'price'       => 130,
			),
		),
	),

	'plant-type' => array(
		'label'   => 'Plant Type',
		'type'    => 'select',
		'orderby' => 'name',
		'terms'   => array(
			array( 'name' => 'Succulent', 'slug' => 'succulent', 'description' => 'Water storing plants that tolerate irregular care.', 'price' => 0 ),
			array( 'name' => 'Air Plant', 'slug' => 'air-plant', 'description' => 'Soil free Tillandsia that feeds through its leaves.', 'price' => 0 ),
			array( 'name' => 'Foliage', 'slug' => 'foliage', 'description' => 'Leafy indoor plants grown for their greenery.', 'price' => 0 ),
			array( 'name' => 'Bonsai', 'slug' => 'bonsai', 'description' => 'Trained miniature trees in shallow trays.', 'price' => 0 ),
			array( 'name' => 'Flowering', 'slug' => 'flowering', 'description' => 'Indoor plants that bloom in season.', 'price' => 0 ),
			array( 'name' => 'Cactus', 'slug' => 'cactus', 'description' => 'Desert species that need very little water.', 'price' => 0 ),
		),
	),

	'light-need' => array(
		'label'   => 'Light Requirement',
		'type'    => 'select',
		'orderby' => 'menu_order',
		'terms'   => array(
			array( 'name' => 'Low Light Tolerant', 'slug' => 'low-light-tolerant', 'description' => 'Survives away from a window under office ceiling lights.', 'price' => 0 ),
			array( 'name' => 'Bright Indirect Light', 'slug' => 'bright-indirect-light', 'description' => 'Needs a spot near a window without direct sun on the leaves.', 'price' => 0 ),
			array( 'name' => 'Direct Sunlight', 'slug' => 'direct-sunlight', 'description' => 'Wants three or more hours of direct sun, so best near a sunny window.', 'price' => 0 ),
		),
	),

	'gift-packaging' => array(
		'label'   => 'Gift Packaging',
		'type'    => 'select',
		'orderby' => 'menu_order',
		'terms'   => array(
			array( 'name' => 'Kraft Gift Box', 'slug' => 'kraft-gift-box', 'description' => 'Recycled kraft box with a moulded insert and a care card.', 'price' => 0 ),
			array( 'name' => 'Premium Rigid Box', 'slug' => 'premium-rigid-box', 'description' => 'Magnetic closure rigid box with foam bedding, used for client gifting.', 'price' => 190 ),
			array( 'name' => 'Jute Pouch', 'slug' => 'jute-pouch', 'description' => 'A drawstring jute pouch, the lightest and most sustainable option.', 'price' => 60 ),
			array( 'name' => 'Printed Sleeve', 'slug' => 'printed-sleeve', 'description' => 'A branded paper sleeve wrapped around the pot with your message printed on it.', 'price' => 80 ),
			array( 'name' => 'No Packaging', 'slug' => 'no-packaging', 'description' => 'Shipped in protective transit packing only, for on site handover at events.', 'price' => -50 ),
		),
	),
);
