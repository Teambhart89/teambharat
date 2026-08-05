<?php
/**
 * Product catalogue.
 *
 * Every entry becomes a WooCommerce variable product. Variations are generated
 * from the pot size, pot material and pot design lists, so the shopper picks the
 * combination on the product page and the price updates from the attribute
 * modifiers defined in data/attributes.php.
 *
 * @package PlantGift_Core
 */

defined( 'ABSPATH' ) || exit;

return array(

	/* Succulents --------------------------------------------------------- */

	array(
		'name'      => 'Haworthia Zebra Succulent Desk Gift',
		'slug'      => 'haworthia-zebra-succulent-desk-gift',
		'sku'       => 'PG-SUC-001',
		'price'     => 349,
		'cats'      => array( 'succulent-corporate-gifts', 'low-maintenance-plant-gifts', 'desk-plants-for-office' ),
		'type'      => 'succulent',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '3-inch-mini-desk', '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'glazed-ceramic', 'natural-terracotta', 'cast-concrete' ),
		'designs'   => array( 'matte-plain', 'logo-engraved' ),
		'short'     => 'Striped upright succulent that keeps its colour under office ceiling lights and needs water only once a fortnight.',
		'desc'      => '
<h2>A succulent that genuinely tolerates a windowless desk</h2>
<p>Haworthia fasciata is the succulent we reach for when a buyer tells us the desks sit in the middle of a floor with no natural light nearby. Most rosette succulents stretch and lose their colour in that situation. Haworthia holds its shape and its white banding, which is why it stays looking like a gift six months later.</p>
<h3>What arrives in the box</h3>
<p>A rooted plant with at least five mature leaves, potted in a fast draining succulent mix, finished with a decorative gravel top dressing. A matched saucer protects the desk and a printed care card names the plant and gives the watering interval in days.</p>
<h3>Care in three lines</h3>
<h4>Water</h4>
<p>Once every twelve to fourteen days indoors, and only when the soil is dry all the way through. Pour at the soil, not into the rosette.</p>
<h4>Light</h4>
<p>Ambient office lighting is enough. A window seat is a bonus, but direct afternoon sun will bleach the leaves.</p>
<h4>The mistake to avoid</h4>
<p>Water pooling in the centre of the rosette causes rot. If the leaves stay wet after watering, tip the pot gently to drain them.</p>
',
	),

	array(
		'name'      => 'Echeveria Rosette Succulent Gift',
		'slug'      => 'echeveria-rosette-succulent-gift',
		'sku'       => 'PG-SUC-002',
		'price'     => 399,
		'cats'      => array( 'succulent-corporate-gifts', 'corporate-event-plant-giveaways', 'low-maintenance-plant-gifts' ),
		'type'      => 'succulent',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '3-inch-mini-desk', '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'glazed-ceramic', 'natural-terracotta', 'jute-wrapped' ),
		'designs'   => array( 'matte-plain', 'glossy-two-tone' ),
		'short'     => 'The classic blue green rosette that photographs beautifully and survives three weeks without water.',
		'desc'      => '
<h2>The succulent people recognise on sight</h2>
<p>Echeveria is the rosette shape that comes to mind when anyone says succulent. Tight overlapping leaves in dusty blue, sage or blush pink, arranged in a perfect spiral. It is the most photographed plant in our catalogue, which matters when a gifting round gets posted on an internal channel.</p>
<h3>Best fit for this plant</h3>
<p>Desks near a window, event giveaway tables and welcome kits. Echeveria needs more light than Haworthia does, so for interior floors we suggest the zebra succulent instead and say so at quote stage.</p>
<h3>Pot pairing</h3>
<h4>Terracotta</h4>
<p>The safest choice, since the clay wicks moisture away from the roots and Echeveria rots faster than it dries.</p>
<h4>Jute wrapped</h4>
<p>The lightest option for event handouts, and fully plastic free.</p>
<h3>Colour change is normal</h3>
<p>Leaf tips blush pink or red under bright light. That is a healthy stress response, not damage, and the care card explains it so nobody assumes the plant is dying.</p>
',
	),

	array(
		'name'      => 'Mixed Succulent Bowl Corporate Gift',
		'slug'      => 'mixed-succulent-bowl-corporate-gift',
		'sku'       => 'PG-SUC-003',
		'price'     => 899,
		'cats'      => array( 'succulent-corporate-gifts', 'client-appreciation-plant-gifts', 'terrarium-gift-sets' ),
		'type'      => 'succulent',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '5-inch-medium', '6-inch-standard', '8-inch-large' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete', 'brushed-metal' ),
		'designs'   => array( 'minimal-white', 'textured-ribbed' ),
		'short'     => 'Three to five succulent varieties arranged in a single shallow bowl, finished with gravel and a care booklet.',
		'desc'      => '
<h2>One bowl, several varieties, considerably more presence</h2>
<p>A single succulent is a gesture. A planted bowl is a centrepiece. We arrange three to five varieties by height and colour in a shallow bowl, then finish with a gravel dressing so the soil never shows. It sits well on a reception counter, a meeting table or a manager desk.</p>
<h3>What we plant together</h3>
<p>A tall Haworthia or Crassula at the back, one or two Echeveria rosettes at mid height, and a trailing Sedum spilling over the rim. Every plant in the bowl shares the same watering rhythm, which is the detail that makes a mixed arrangement survive.</p>
<h3>Choosing the size</h3>
<h4>5 inch</h4>
<p>Three plants. Fits a desk without crowding it.</p>
<h4>6 and 8 inch</h4>
<p>Four to five plants with room to grow for a year. This is the client gifting size.</p>
<h3>Care and refresh</h3>
<p>Water at the soil every two weeks, never over the leaves. After a year the fastest grower usually needs lifting out and repotting, and the care booklet covers that step with photographs.</p>
',
	),

	array(
		'name'      => 'Jade Plant Prosperity Gift',
		'slug'      => 'jade-plant-prosperity-gift',
		'sku'       => 'PG-SUC-004',
		'price'     => 549,
		'cats'      => array( 'succulent-corporate-gifts', 'diwali-corporate-plant-gifts', 'work-anniversary-plant-gifts', 'low-maintenance-plant-gifts' ),
		'type'      => 'succulent',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'glazed-ceramic', 'natural-terracotta', 'brushed-metal' ),
		'designs'   => array( 'matte-plain', 'logo-engraved' ),
		'short'     => 'Crassula ovata with thick coin shaped leaves, the plant most associated with prosperity in Indian gifting.',
		'desc'      => '
<h2>The plant that carries meaning and still survives neglect</h2>
<p>Crassula ovata, the jade plant, sits at the intersection most gifting buyers are looking for. It carries a widely understood prosperity association, which makes it appropriate for festive rounds and promotions, and it is a succulent, which means it forgives the person who forgets it for a fortnight.</p>
<h3>How it grows over time</h3>
<p>Jade thickens rather than sprawls. Over two or three years the stem woodens and the plant starts to look like a small tree, which is why trained jade bonsai command a premium. A recipient who keeps it will watch it change, and that is unusual in a corporate gift.</p>
<h3>Where it works</h3>
<h4>Diwali and festive gifting</h4>
<p>Pair a 4 inch jade in glazed ceramic with diyas and dry fruits in a kraft box.</p>
<h4>Promotions and anniversaries</h4>
<p>A 5 or 6 inch jade in an engraved metal planter reads as a step up without a large increase in cost.</p>
<h3>Care notes</h3>
<p>Water every two weeks and let the soil dry fully between drinks. Leaf drop almost always means overwatering rather than underwatering, and the care card leads with that.</p>
',
	),

	array(
		'name'      => 'Golden Barrel Cactus Desk Gift',
		'slug'      => 'golden-barrel-cactus-desk-gift',
		'sku'       => 'PG-SUC-005',
		'price'     => 449,
		'cats'      => array( 'succulent-corporate-gifts', 'low-maintenance-plant-gifts', 'desk-plants-for-office' ),
		'type'      => 'cactus',
		'light'     => 'direct-sunlight',
		'sizes'     => array( '3-inch-mini-desk', '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'natural-terracotta', 'cast-concrete', 'glazed-ceramic' ),
		'designs'   => array( 'matte-plain', 'geometric-facet' ),
		'short'     => 'A compact golden spined cactus for sunny desks, needing water roughly once a month.',
		'desc'      => '
<h2>The lowest effort plant we ship</h2>
<p>Echinocactus grusonii asks for almost nothing. Water once every three to four weeks in summer and once every six in winter, and give it the sunniest spot available. That is the entire relationship. For a recipient who has killed every plant they have owned, this is the honest recommendation.</p>
<h3>The one condition it does need</h3>
<p>Direct sun. A cactus on an interior desk under ceiling lights slowly etiolates, growing pale and elongated. If your recipients do not sit near windows, choose a Haworthia or a snake plant instead and keep the cactus for the window row.</p>
<h3>Pot choice</h3>
<h4>Terracotta</h4>
<p>The correct answer almost always, because it dries fastest.</p>
<h4>Concrete</h4>
<p>Heavy and stable, which prevents a spiny plant being knocked over on a busy desk.</p>
<h3>Safety note</h3>
<p>Spines are sharp. We do not recommend cacti for offices with a creche or for handout at a crowded event, and every cactus ships with a protective collar that stays on until the plant is placed.</p>
',
	),

	/* Air plants --------------------------------------------------------- */

	array(
		'name'      => 'Tillandsia Ionantha Air Plant Gift',
		'slug'      => 'tillandsia-ionantha-air-plant-gift',
		'sku'       => 'PG-AIR-001',
		'price'     => 399,
		'cats'      => array( 'air-plant-gifts', 'corporate-event-plant-giveaways', 'low-maintenance-plant-gifts' ),
		'type'      => 'air-plant',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '3-inch-mini-desk', '4-inch-small-desk' ),
		'materials' => array( 'glass-terrarium', 'brushed-metal', 'jute-wrapped' ),
		'designs'   => array( 'matte-plain', 'custom-brand-printed' ),
		'short'     => 'A soil free Tillandsia in a glass, metal or jute holder. One weekly soak is the entire care routine.',
		'desc'      => '
<h2>No soil, no pot, nothing to spill</h2>
<p>Tillandsia ionantha feeds through fine scales on its leaves rather than through roots, which means the whole plant sits loose in a holder. Nothing can spill onto a keyboard, there is no repotting to explain, and the finished gift weighs almost nothing in a courier box.</p>
<h3>The weekly routine</h3>
<p>Drop the plant into a bowl of room temperature water for twenty minutes, then rest it upside down on a towel for an hour so water does not sit in the crown. Return it to the holder. That is all.</p>
<h3>Holder options</h3>
<h4>Glass globe</h4>
<p>Shows the plant from every angle and takes a frosted logo etch.</p>
<h4>Brushed metal stand</h4>
<p>Reads premium and carries a deep laser engraving.</p>
<h4>Jute base</h4>
<p>The lightest and cheapest option, and the right pick for high volume event handouts.</p>
<h3>It blushes before it flowers</h3>
<p>Mature ionantha turns red at the tips and then throws a violet bloom. The care card explains this so recipients recognise it as a milestone rather than a problem.</p>
',
	),

	array(
		'name'      => 'Tillandsia Xerographica Specimen Gift',
		'slug'      => 'tillandsia-xerographica-specimen-gift',
		'sku'       => 'PG-AIR-002',
		'price'     => 1899,
		'cats'      => array( 'air-plant-gifts', 'client-appreciation-plant-gifts' ),
		'type'      => 'air-plant',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '6-inch-standard', '8-inch-large' ),
		'materials' => array( 'brushed-metal', 'cast-concrete', 'glass-terrarium' ),
		'designs'   => array( 'minimal-white', 'logo-engraved' ),
		'short'     => 'The large silver rosette air plant, presented on a weighted stand in a rigid gift box.',
		'desc'      => '
<h2>The air plant that starts a conversation</h2>
<p>Xerographica grows into a wide silver rosette with curling leaves and can reach thirty centimetres across. It looks sculptural rather than horticultural, which is why it works as a client gift for people who already own everything a supplier might send.</p>
<h3>Presentation</h3>
<p>Each specimen ships in a rigid magnetic box with foam bedding, mounted on a weighted brushed metal or concrete stand so it will not tip. A care booklet and a blank handwritten note card are included.</p>
<h3>Care for a large specimen</h3>
<h4>Soaking</h4>
<p>A thirty minute soak every ten days, followed by an hour drying upside down. Larger rosettes hold more water in the crown, so the drying step matters more than it does for a small plant.</p>
<h4>Placement</h4>
<p>Bright indirect light with air movement. It will not do well in a sealed glass case.</p>
<h3>Availability</h3>
<p>Xerographica grows slowly and stock is limited. For matched sets across a client list, allow three weeks so we can select specimens of a similar span.</p>
',
	),

	array(
		'name'      => 'Air Plant Glass Globe Trio',
		'slug'      => 'air-plant-glass-globe-trio',
		'sku'       => 'PG-AIR-003',
		'price'     => 1199,
		'cats'      => array( 'air-plant-gifts', 'terrarium-gift-sets', 'hanging-plant-gifts' ),
		'type'      => 'air-plant',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'glass-terrarium', 'brushed-metal' ),
		'designs'   => array( 'minimal-white', 'custom-brand-printed' ),
		'short'     => 'Three hanging glass globes, each holding an air plant over white pebbles, with ceiling and partition fixings.',
		'desc'      => '
<h2>Three globes, one gift, no desk space used</h2>
<p>A trio of hanging glass globes gives a workspace visible greenery without taking a centimetre of desk surface. Each globe holds an air plant resting on white pebbles, and the set arrives with cotton cord, ceiling hooks and partition clips so it can be installed in a rented office without drilling.</p>
<h3>Where to hang them</h3>
<p>Beside a window at staggered heights, along the top of a partition, or above a breakout table. Keep them out of direct afternoon sun, which cooks the inside of a glass globe.</p>
<h3>Care with hanging globes</h3>
<h4>Taking the plant out</h4>
<p>Lift the plant out to soak it rather than filling the globe. Water left standing in glass rots the plant base within days.</p>
<h4>Drying</h4>
<p>An hour upside down on a towel before it goes back in.</p>
<h3>Good fit for</h3>
<p>New office fitouts, breakout areas and shared team gifts where an individual desk plant would not work.</p>
',
	),

	/* Desk foliage ------------------------------------------------------- */

	array(
		'name'      => 'Snake Plant Air Purifying Desk Gift',
		'slug'      => 'snake-plant-air-purifying-desk-gift',
		'sku'       => 'PG-FOL-001',
		'price'     => 649,
		'cats'      => array( 'air-purifying-plant-gifts', 'desk-plants-for-office', 'low-maintenance-plant-gifts', 'employee-welcome-kit-plants' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete', 'self-watering' ),
		'designs'   => array( 'matte-plain', 'logo-engraved' ),
		'short'     => 'Sansevieria with upright banded leaves. Survives low light, dry air and three weeks without water.',
		'desc'      => '
<h2>The most reliable plant gift we ship</h2>
<p>If we could only stock one plant for corporate gifting it would be Sansevieria. It tolerates low light, dry office air and long gaps between watering, and its upright form takes up almost no horizontal space on a desk. It also keeps exchanging gases at night, which is the origin of the common bedside recommendation.</p>
<h3>Varieties we grow</h3>
<h4>Laurentii</h4>
<p>Dark green leaves with yellow margins. The variety most people picture.</p>
<h4>Moonshine</h4>
<p>Pale silver green leaves that look striking against dark furniture, and slightly more expensive.</p>
<h4>Hahnii, the bird nest</h4>
<p>A compact rosette that stays under twenty centimetres, which suits a 4 inch pot and a crowded desk.</p>
<h3>Care</h3>
<p>Water every two to three weeks, less in winter. Overwatering is the only common way to kill it, so a pot with drainage matters more than the pot material.</p>
<h3>Note for pet friendly offices</h3>
<p>Sansevieria is mildly toxic if chewed. We flag this at quote stage rather than after delivery.</p>
',
	),

	array(
		'name'      => 'ZZ Plant Low Light Office Gift',
		'slug'      => 'zz-plant-low-light-office-gift',
		'sku'       => 'PG-FOL-002',
		'price'     => 749,
		'cats'      => array( 'desk-plants-for-office', 'low-maintenance-plant-gifts', 'air-purifying-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '5-inch-medium', '6-inch-standard', '8-inch-large' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete', 'self-watering' ),
		'designs'   => array( 'minimal-white', 'textured-ribbed' ),
		'short'     => 'Zamioculcas with glossy leaves on arching stems, happy in the darkest corner of a floor.',
		'desc'      => '
<h2>Built for the corner nobody else wants</h2>
<p>Zamioculcas zamiifolia stores water in underground rhizomes, which lets it go a full month indoors without a drink. It also keeps its glossy finish under fluorescent light where most foliage turns dull. Together those two traits make it the right answer for interior floors, meeting rooms and corridors.</p>
<h3>How it looks over time</h3>
<p>New stems push up from the base rather than the plant getting leggy, so it thickens into a fuller clump instead of sprawling. A 6 inch ZZ looks noticeably better after a year, which is unusual.</p>
<h3>Sizes and placement</h3>
<h4>5 and 6 inch</h4>
<p>Desk and side table. The common gifting sizes.</p>
<h4>8 inch</h4>
<p>Floor standing beside a cabin desk or in a reception corner.</p>
<h3>Care</h3>
<p>Water once the soil is dry through, roughly every three to four weeks. If the stems yellow at the base, the plant is being watered too often. Leaves are mildly toxic if chewed.</p>
',
	),

	array(
		'name'      => 'Peperomia Compact Foliage Gift',
		'slug'      => 'peperomia-compact-foliage-gift',
		'sku'       => 'PG-FOL-003',
		'price'     => 499,
		'cats'      => array( 'desk-plants-for-office', 'employee-welcome-kit-plants', 'low-maintenance-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '3-inch-mini-desk', '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'glazed-ceramic', 'jute-wrapped', 'self-watering' ),
		'designs'   => array( 'matte-plain', 'glossy-two-tone' ),
		'short'     => 'Thick patterned leaves on a plant that stays under thirty centimetres, ideal for a shared workstation.',
		'desc'      => '
<h2>Small enough for a desk that is already full</h2>
<p>Peperomia stays compact for its whole life rather than being a large plant sold small. In a 4 inch pot it holds at roughly twenty five centimetres, which means it never has to be moved off a crowded workstation to a windowsill.</p>
<h3>Varieties</h3>
<h4>Watermelon peperomia</h4>
<p>Silver striped leaves on red stems. The most decorative option and a favourite in welcome kits.</p>
<h4>Raindrop peperomia</h4>
<p>Thick glossy heart shaped leaves, closer to a succulent in feel and even easier to keep.</p>
<h3>Care</h3>
<p>Water every ten days once the top of the soil is dry. The semi succulent leaves store moisture, so underwatering is far less risky than overwatering.</p>
<h3>Why it suits welcome kits</h3>
<p>It survives several days in a packed box, tolerates a beginner and looks interesting enough that a new joiner puts it on the desk rather than in a drawer.</p>
',
	),

	array(
		'name'      => 'Syngonium Arrowhead Plant Gift',
		'slug'      => 'syngonium-arrowhead-plant-gift',
		'sku'       => 'PG-FOL-004',
		'price'     => 449,
		'cats'      => array( 'desk-plants-for-office', 'air-purifying-plant-gifts', 'employee-welcome-kit-plants' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'glazed-ceramic', 'self-watering', 'jute-wrapped' ),
		'designs'   => array( 'matte-plain', 'minimal-white' ),
		'short'     => 'Soft arrowhead leaves in green, cream or pink. Fast growing and forgiving of weak light.',
		'desc'      => '
<h2>Colour without needing a window</h2>
<p>Syngonium gives a desk something other than plain green. The pink and cream varieties hold their variegation in moderate light, which most coloured foliage does not, and the plant grows quickly enough that a recipient sees visible progress within a month.</p>
<h3>How it behaves</h3>
<p>Young plants stay bushy and upright. After a year the stems begin to vine, at which point the recipient can either trim it back to keep it compact or let it trail from a shelf. The care card explains both options.</p>
<h3>Pot pairing</h3>
<h4>Self watering</h4>
<p>Syngonium prefers evenly moist soil, so the reservoir suits it better than it suits a succulent.</p>
<h4>Jute wrapped</h4>
<p>Light and plastic free, and a good match for the softer look of the leaves.</p>
<h3>Care</h3>
<p>Water when the top two centimetres are dry, roughly weekly. Mildly toxic if chewed, so not the pick for a pet friendly floor.</p>
',
	),

	array(
		'name'      => 'Spider Plant Pet Safe Office Gift',
		'slug'      => 'spider-plant-pet-safe-office-gift',
		'sku'       => 'PG-FOL-005',
		'price'     => 429,
		'cats'      => array( 'air-purifying-plant-gifts', 'hanging-plant-gifts', 'desk-plants-for-office' ),
		'type'      => 'foliage',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'glazed-ceramic', 'jute-wrapped', 'self-watering' ),
		'designs'   => array( 'matte-plain', 'textured-ribbed' ),
		'short'     => 'Arching striped leaves that throw out baby plantlets. Non toxic, so it suits pet friendly workplaces.',
		'desc'      => '
<h2>The safe choice when there are pets in the office</h2>
<p>Chlorophytum comosum is one of the few popular indoor plants that is genuinely non toxic to cats and dogs. When a buyer tells us the office is pet friendly, this and the areca palm are the two we recommend, and we move pothos and peace lily off the shortlist.</p>
<h3>It makes copies of itself</h3>
<p>Mature spider plants send out runners with small plantlets on the ends. Recipients pot these and pass them to colleagues, which quietly spreads a single gifting round across a floor over the following year. It is the only plant we ship that reliably does this.</p>
<h3>Placement</h3>
<h4>Hanging</h4>
<p>The runners look best falling from a jute hanger or a shelf edge.</p>
<h4>On a desk</h4>
<p>A 4 inch pot works, though the arching leaves need about twenty centimetres of clearance either side.</p>
<h3>Care</h3>
<p>Water weekly and keep it in bright indirect light. Brown leaf tips usually mean fluoride in tap water, so rested or filtered water fixes it.</p>
',
	),

	/* Money plant and pothos --------------------------------------------- */

	array(
		'name'      => 'Golden Money Plant Corporate Gift',
		'slug'      => 'golden-money-plant-corporate-gift',
		'sku'       => 'PG-MON-001',
		'price'     => 299,
		'cats'      => array( 'money-plant-gifts', 'air-purifying-plant-gifts', 'diwali-corporate-plant-gifts', 'low-maintenance-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '3-inch-mini-desk', '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'glazed-ceramic', 'jute-wrapped', 'self-watering' ),
		'designs'   => array( 'matte-plain', 'custom-brand-printed' ),
		'short'     => 'Golden pothos with yellow splashed leaves. The most affordable plant gift that still looks considered at volume.',
		'desc'      => '
<h2>The workhorse of large gifting rounds</h2>
<p>When the list runs to five hundred people, Epipremnum aureum is the sensible answer. It grows in soil or plain water, tolerates weak light, forgives long gaps between watering and propagates from cuttings in weeks, which means we can match a large order without a long lead time.</p>
<h3>Why recipients keep it</h3>
<p>Money plant is the plant most Indian households already know how to look after. Familiarity raises survival rates, and a plant that is still alive a year later is the only kind that does anything for your brand.</p>
<h3>Soil or water</h3>
<h4>In soil</h4>
<p>Faster growth and fuller vines. Water weekly.</p>
<h4>In water</h4>
<p>Top up every fortnight and change the water monthly. No mess at all, which suits hybrid teams.</p>
<h3>Branding</h3>
<p>A printed sleeve around a plain pot is the lowest cost way to carry full colour artwork, and at this price point it is where the branding budget goes furthest.</p>
<h3>Safety</h3>
<p>Mildly toxic if chewed, so not suitable for pet friendly offices.</p>
',
	),

	array(
		'name'      => 'Marble Queen Money Plant Gift',
		'slug'      => 'marble-queen-money-plant-gift',
		'sku'       => 'PG-MON-002',
		'price'     => 449,
		'cats'      => array( 'money-plant-gifts', 'desk-plants-for-office', 'hanging-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete', 'self-watering' ),
		'designs'   => array( 'minimal-white', 'matte-plain' ),
		'short'     => 'Heavily variegated white and green pothos that reads as a premium version of a familiar plant.',
		'desc'      => '
<h2>The upgrade to a plant everyone recognises</h2>
<p>Marble queen is the same species as a golden money plant with far heavier white variegation. Set the two side by side and the difference is obvious, which makes it a useful way to distinguish a senior recipient tier without moving to a completely different plant.</p>
<h3>Slower, and that is the point</h3>
<p>White leaf sections carry no chlorophyll, so the plant grows more slowly and costs more to produce. It also needs brighter light than golden pothos to hold the variegation, so it belongs near a window rather than in a corridor.</p>
<h3>Pot pairing</h3>
<h4>Minimal white ceramic</h4>
<p>Lets the variegation read cleanly.</p>
<h4>Cast concrete</h4>
<p>A grey base makes the white in the leaves look brighter by contrast.</p>
<h3>Care</h3>
<p>Water weekly. If new leaves come through mostly green, the plant needs more light, and the care card says so directly.</p>
',
	),

	array(
		'name'      => 'Money Plant in Glass Bottle Gift',
		'slug'      => 'money-plant-glass-bottle-gift',
		'sku'       => 'PG-MON-003',
		'price'     => 549,
		'cats'      => array( 'money-plant-gifts', 'low-maintenance-plant-gifts', 'employee-welcome-kit-plants' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'glass-terrarium', 'brushed-metal' ),
		'designs'   => array( 'minimal-white', 'logo-engraved' ),
		'short'     => 'A rooted pothos cutting growing in a glass bottle of water. No soil, no repotting, no mess.',
		'desc'      => '
<h2>A plant gift with no soil at all</h2>
<p>A rooted money plant cutting in a glass bottle removes every objection people have to plants at work. Nothing spills, nothing attracts insects, and the only maintenance is a top up every couple of weeks. The visible white roots are also genuinely nice to look at.</p>
<h3>Why it suits hybrid teams</h3>
<p>A bottle of water carries a plant through two or three weeks unattended, which matches how often many people are actually at their desk now. A potted plant in the same situation dries out.</p>
<h3>Bottle options</h3>
<h4>Clear glass</h4>
<p>Shows the root system, and takes a frosted logo etch.</p>
<h4>Metal collar</h4>
<p>A brushed metal neck ring that carries a laser engraving where etching the glass is not wanted.</p>
<h3>Care</h3>
<p>Top up the water every two weeks and change it fully once a month. Rested or filtered water keeps the leaf tips from browning. A drop of liquid feed every couple of months keeps growth going.</p>
',
	),

	/* Lucky bamboo -------------------------------------------------------- */

	array(
		'name'      => 'Three Layer Lucky Bamboo Gift',
		'slug'      => 'three-layer-lucky-bamboo-gift',
		'sku'       => 'PG-BAM-001',
		'price'     => 599,
		'cats'      => array( 'lucky-bamboo-gifts', 'diwali-corporate-plant-gifts', 'low-maintenance-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'glass-terrarium', 'glazed-ceramic' ),
		'designs'   => array( 'matte-plain', 'custom-brand-printed' ),
		'short'     => 'Three stalks of Dracaena sanderiana in a water filled vase with pebbles. A fortnightly water change is all it needs.',
		'desc'      => '
<h2>The most requested arrangement for employee gifting</h2>
<p>Three stalks is the size that fits a desk without dominating it, and the layer count carries a positive association that recipients recognise. It sits in water rather than soil, so the care routine is one action every two weeks.</p>
<h3>Vase choice</h3>
<h4>Glass</h4>
<p>Shows the roots and the coloured pebbles. The default and the cheaper option.</p>
<h4>Glazed ceramic</h4>
<p>Hides the roots for a cleaner desk look, and takes a fired logo decal that will not wear off.</p>
<h3>Care</h3>
<p>Keep two to three inches of water over the roots and change it every fortnight. Use filtered or rested water, since chlorine in fresh tap water yellows the leaf tips over a few months. Bright indirect light, never direct sun.</p>
<h3>Add ons for festive rounds</h3>
<p>Brand coloured pebbles, a cotton ribbon tie and a card explaining the layer symbolism, which is one of the few inserts recipients actually read.</p>
',
	),

	array(
		'name'      => 'Eight Layer Lucky Bamboo Prosperity Set',
		'slug'      => 'eight-layer-lucky-bamboo-prosperity-set',
		'sku'       => 'PG-BAM-002',
		'price'     => 1299,
		'cats'      => array( 'lucky-bamboo-gifts', 'diwali-corporate-plant-gifts', 'client-appreciation-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '6-inch-standard', '8-inch-large' ),
		'materials' => array( 'glazed-ceramic', 'brushed-metal', 'glass-terrarium' ),
		'designs'   => array( 'glossy-two-tone', 'logo-engraved' ),
		'short'     => 'An eight stalk tiered arrangement in a weighted vase, the format most chosen for festive and client gifting.',
		'desc'      => '
<h2>Presence on a reception counter</h2>
<p>Eight stalks arranged in tiers reach thirty five to fifty centimetres and read as a proper gift rather than a desk accessory. The prosperity association attached to the number makes it a natural festive and client choice.</p>
<h3>Stability matters at this size</h3>
<p>A tall arrangement in a light vase tips over. We supply this set only in weighted ceramic, metal or thick walled glass at 6 inch and above, with pebbles adding ballast at the base.</p>
<h3>Care</h3>
<h4>Water</h4>
<p>Three inches over the roots, changed every two weeks with filtered or rested water.</p>
<h4>Light</h4>
<p>Bright indirect. Direct sun scorches the leaf edges within days.</p>
<h4>Trimming</h4>
<p>Yellow stalks are removed at the base rather than trimmed halfway, and the care booklet shows where to cut.</p>
<h3>Ordering for a festive round</h3>
<p>Stock of tall matched stalks runs out by early October most years. An August brief gets you the arrangement you want at the price you planned.</p>
',
	),

	/* Bonsai -------------------------------------------------------------- */

	array(
		'name'      => 'Ficus Bonsai Corporate Gift',
		'slug'      => 'ficus-bonsai-corporate-gift',
		'sku'       => 'PG-BON-001',
		'price'     => 2499,
		'cats'      => array( 'bonsai-corporate-gifts', 'client-appreciation-plant-gifts', 'work-anniversary-plant-gifts' ),
		'type'      => 'bonsai',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '6-inch-standard', '8-inch-large' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete' ),
		'designs'   => array( 'matte-plain', 'hand-painted' ),
		'short'     => 'A trained Ficus microcarpa in a glazed ceramic tray, presented in a rigid box with a care booklet.',
		'desc'      => '
<h2>The indoor bonsai that actually survives an office</h2>
<p>Ficus microcarpa is the most forgiving bonsai species for Indian indoor conditions. It handles moderate light, recovers from a missed watering and holds its silhouette between prunings, which matters when the recipient has never trained a tree before.</p>
<h3>What makes each tree different</h3>
<p>Every specimen has been grown and shaped for three to five years, so trunk taper, root spread and canopy shape vary. For a matched set across several recipients, tell us at order stage and we select trees of a similar age and form.</p>
<h3>Presentation</h3>
<p>Glazed ceramic tray with drainage, moss top dressing, matched drip saucer, a rigid magnetic box with foam bedding, and a care booklet rather than a single card. A brass plate with an engraved name or dedication can be fixed to the tray.</p>
<h3>Care, stated honestly</h3>
<h4>Water</h4>
<p>Two or three times a week. This is not a low maintenance gift.</p>
<h4>Light</h4>
<p>Bright indirect, ideally within two metres of a window.</p>
<h4>Pruning</h4>
<p>Pinch new growth back to two leaves every few weeks to hold the shape.</p>
',
	),

	array(
		'name'      => 'Jade Bonsai Milestone Gift',
		'slug'      => 'jade-bonsai-milestone-gift',
		'sku'       => 'PG-BON-002',
		'price'     => 1999,
		'cats'      => array( 'bonsai-corporate-gifts', 'work-anniversary-plant-gifts', 'diwali-corporate-plant-gifts' ),
		'type'      => 'bonsai',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete', 'brushed-metal' ),
		'designs'   => array( 'matte-plain', 'logo-engraved' ),
		'short'     => 'A succulent trained as a bonsai. Looks like a shaped tree, waters like a jade plant.',
		'desc'      => '
<h2>Bonsai presence without bonsai upkeep</h2>
<p>A jade bonsai gives you the thick trunk and shaped canopy of a trained tree, but underneath it is still Crassula ovata, which means it stores water in its leaves and forgives a fortnight of neglect. For a milestone gift going to someone who travels, this is the version that survives.</p>
<h3>Why it suits work anniversaries</h3>
<p>The trunk thickens visibly year on year, so the gift keeps marking time after the anniversary has passed. Add an engraved brass plate with the name and the year and it becomes a genuine keepsake.</p>
<h3>Care</h3>
<h4>Water</h4>
<p>Every ten to fourteen days, allowing the soil to dry fully between drinks.</p>
<h4>Light</h4>
<p>The brightest indirect spot available. More light means a thicker trunk.</p>
<h4>Shaping</h4>
<p>Trim long shoots back in spring. Jade responds well and branches from the cut.</p>
<h3>Presentation</h3>
<p>Rigid box, foam bedding, gravel top dressing and a care booklet. The engraved plate option is fitted before dispatch.</p>
',
	),

	array(
		'name'      => 'Carmona Fukien Tea Bonsai',
		'slug'      => 'carmona-fukien-tea-bonsai',
		'sku'       => 'PG-BON-003',
		'price'     => 3299,
		'cats'      => array( 'bonsai-corporate-gifts', 'client-appreciation-plant-gifts', 'flowering-plant-gifts' ),
		'type'      => 'bonsai',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '6-inch-standard', '8-inch-large' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete' ),
		'designs'   => array( 'hand-painted', 'minimal-white' ),
		'short'     => 'Small dark leaves and occasional white flowers on a classic flowering bonsai for an experienced recipient.',
		'desc'      => '
<h2>The most decorative bonsai we stock, and the most demanding</h2>
<p>Carmona retusa carries tiny glossy leaves, a gnarled trunk and small white flowers that appear through much of the year. It is the bonsai people picture, and it is the one we most often talk buyers out of, because it punishes irregular care.</p>
<h3>Who it is right for</h3>
<p>A recipient who already keeps plants and would enjoy the routine. Not a general leadership list, and certainly not a bulk round. If you do not know the person well enough to be sure, a ficus or jade bonsai delivers the same gesture with a far better survival rate.</p>
<h3>Care requirements</h3>
<h4>Water</h4>
<p>Daily checks. The soil must stay lightly moist and never dry out completely.</p>
<h4>Light</h4>
<p>Bright indirect light with a few hours of gentle morning sun.</p>
<h4>Humidity</h4>
<p>A humidity tray under the pot in air conditioned rooms.</p>
<h3>Presentation</h3>
<p>Rigid box, glazed tray, moss dressing, humidity tray and a detailed care booklet covering the first ninety days week by week.</p>
',
	),

	/* Flowering ----------------------------------------------------------- */

	array(
		'name'      => 'Peace Lily Air Purifying Gift',
		'slug'      => 'peace-lily-air-purifying-gift',
		'sku'       => 'PG-FLW-001',
		'price'     => 799,
		'cats'      => array( 'flowering-plant-gifts', 'air-purifying-plant-gifts', 'client-appreciation-plant-gifts' ),
		'type'      => 'flowering',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '5-inch-medium', '6-inch-standard', '8-inch-large' ),
		'materials' => array( 'glazed-ceramic', 'self-watering', 'cast-concrete' ),
		'designs'   => array( 'minimal-white', 'matte-plain' ),
		'short'     => 'White spathes above dark green leaves. It droops when thirsty and recovers within hours, which makes it easy to read.',
		'desc'      => '
<h2>A flowering plant that tells you what it needs</h2>
<p>Spathiphyllum wilts visibly when the soil dries out and stands back up within a few hours of watering. That single behaviour makes it far more beginner friendly than it looks, because the plant removes the guesswork that kills most flowering gifts.</p>
<h3>Blooming</h3>
<p>White spathes appear several times a year in adequate indirect light. Between flushes the plant rests, which is normal and stated plainly on the care card so recipients do not assume it has failed.</p>
<h3>Pot pairing</h3>
<h4>Self watering</h4>
<p>The best match in our range, since peace lily prefers consistently moist soil.</p>
<h4>Glazed ceramic</h4>
<p>Holds moisture better than terracotta, which suits this plant.</p>
<h3>Care</h3>
<p>Water weekly, or when the leaves begin to soften. Feed every six weeks during the growing season to keep it flowering. Toxic if chewed, so not suitable for pet friendly offices.</p>
',
	),

	array(
		'name'      => 'Anthurium Red Bloom Corporate Gift',
		'slug'      => 'anthurium-red-bloom-corporate-gift',
		'sku'       => 'PG-FLW-002',
		'price'     => 1099,
		'cats'      => array( 'flowering-plant-gifts', 'client-appreciation-plant-gifts', 'work-anniversary-plant-gifts' ),
		'type'      => 'flowering',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete', 'brushed-metal' ),
		'designs'   => array( 'minimal-white', 'textured-ribbed' ),
		'short'     => 'Glossy red spathes that hold for six to eight weeks at a time. The most photogenic plant in the range.',
		'desc'      => '
<h2>Colour that lasts far longer than a bouquet</h2>
<p>An anthurium spathe holds its colour for six to eight weeks, and a healthy plant carries several at once. Against a bouquet that is finished in a week, the comparison is not close, and it costs about the same to send.</p>
<h3>Colours we stock</h3>
<p>Red is the standard and the one most requested for celebration gifting. Pink and white are available with two to three weeks of notice for a bulk order in a matched colour.</p>
<h3>Pot pairing</h3>
<h4>Minimal white ceramic</h4>
<p>Lets the red read as strongly as possible.</p>
<h4>Cast concrete</h4>
<p>A grey base that makes the glossy spathe look almost lacquered.</p>
<h3>Care</h3>
<p>Water weekly, keeping the soil lightly moist but never soggy. Bright indirect light is essential for reflowering. Wipe the leaves monthly, since dust dulls the gloss that makes this plant worth choosing. Toxic if chewed.</p>
',
	),

	array(
		'name'      => 'Kalanchoe Flowering Succulent Gift',
		'slug'      => 'kalanchoe-flowering-succulent-gift',
		'sku'       => 'PG-FLW-003',
		'price'     => 549,
		'cats'      => array( 'flowering-plant-gifts', 'low-maintenance-plant-gifts', 'desk-plants-for-office' ),
		'type'      => 'flowering',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'glazed-ceramic', 'natural-terracotta', 'jute-wrapped' ),
		'designs'   => array( 'glossy-two-tone', 'matte-plain' ),
		'short'     => 'Dense clusters of small blooms on a succulent that needs water only every two weeks.',
		'desc'      => '
<h2>Flowers on a plant that behaves like a succulent</h2>
<p>Kalanchoe blossfeldiana carries thick succulent leaves under a dense head of small flowers, which means you get the look of a flowering gift with the watering schedule of a succulent. On a working desk that combination is hard to beat.</p>
<h3>Flowering cycle</h3>
<p>A flush lasts four to six weeks. After it fades the plant rests, and deadheading the spent stems encourages the next round. Kalanchoe sets buds in response to shorter days, which is why flowering peaks in the cooler months.</p>
<h3>Colours</h3>
<p>Red, orange, yellow, pink and white. Mixed colour orders across a team work well and cost the same as a single colour.</p>
<h3>Care</h3>
<h4>Water</h4>
<p>Every two weeks, at the soil rather than over the flowers.</p>
<h4>Light</h4>
<p>Bright indirect. More light means more buds.</p>
<h3>Note</h3>
<p>Toxic if chewed, so not a pet friendly office choice.</p>
',
	),

	/* Terrariums ---------------------------------------------------------- */

	array(
		'name'      => 'Desert Succulent Terrarium Gift Set',
		'slug'      => 'desert-succulent-terrarium-gift-set',
		'sku'       => 'PG-TER-001',
		'price'     => 1499,
		'cats'      => array( 'terrarium-gift-sets', 'succulent-corporate-gifts', 'client-appreciation-plant-gifts' ),
		'type'      => 'succulent',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '5-inch-medium', '6-inch-standard', '8-inch-large' ),
		'materials' => array( 'glass-terrarium', 'glazed-ceramic' ),
		'designs'   => array( 'minimal-white', 'custom-brand-printed' ),
		'short'     => 'An open glass bowl planted with three succulents over layered gravel, charcoal and coloured sand.',
		'desc'      => '
<h2>An arrangement rather than a plant</h2>
<p>An open desert terrarium is built in visible layers: drainage gravel, a thin charcoal band to keep the water sweet, a fast draining substrate, then the plants and a coloured sand dressing. Because the glass shows every layer, the build itself becomes part of the gift.</p>
<h3>What we plant</h3>
<p>Three succulents chosen for a shared watering rhythm, usually a Haworthia for height, an Echeveria rosette for the centre and a trailing Sedum over the rim. Nothing is glued, so the recipient can replace a plant later.</p>
<h3>Care</h3>
<h4>Water</h4>
<p>A small pour at the base of each plant every two to three weeks. Never fill the bowl.</p>
<h4>Light</h4>
<p>Bright indirect. Direct sun through glass will cook the roots.</p>
<h3>Branding</h3>
<p>Frosted etching on the glass, or a printed base card under the bowl for lower volumes. Etching carries a setup charge that spreads well above a hundred pieces.</p>
<h3>Lead time</h3>
<p>Each set is assembled by hand. Allow two to three weeks above fifty pieces, four if the glass is being etched.</p>
',
	),

	array(
		'name'      => 'Closed Moss Forest Terrarium',
		'slug'      => 'closed-moss-forest-terrarium',
		'sku'       => 'PG-TER-002',
		'price'     => 1899,
		'cats'      => array( 'terrarium-gift-sets', 'client-appreciation-plant-gifts', 'low-maintenance-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'glass-terrarium' ),
		'designs'   => array( 'minimal-white', 'logo-engraved' ),
		'short'     => 'A sealed jar holding cushion moss, fittonia and a small fern in a self sustaining humid environment.',
		'desc'      => '
<h2>A gift that waters itself</h2>
<p>A sealed terrarium recycles its own moisture. Water evaporates, condenses on the glass and returns to the substrate, which means the whole system runs for months without intervention. Recipients open it perhaps twice a year.</p>
<h3>What is inside</h3>
<p>Cushion moss as the ground layer, a fittonia or two for colour, a small fern for height, and a piece of driftwood or stone for structure. All chosen because they thrive in constant humidity.</p>
<h3>The one rule</h3>
<p>Keep it out of direct sun. Sealed glass in sunlight becomes an oven and cooks the contents within a day. Bright indirect light two or three metres from a window is the correct position, and it is printed on the lid tag as well as the care card.</p>
<h3>When to open it</h3>
<p>If the glass fogs completely and stays fogged, open the lid for a few hours. If there is no condensation at all for a week, add a tablespoon of water. Those two checks are the entire maintenance routine.</p>
<h3>Lead time</h3>
<p>Hand assembled, so allow three weeks above fifty pieces.</p>
',
	),

	/* Hanging -------------------------------------------------------------- */

	array(
		'name'      => 'Macrame Hanging Pothos Planter Gift',
		'slug'      => 'macrame-hanging-pothos-planter-gift',
		'sku'       => 'PG-HNG-001',
		'price'     => 899,
		'cats'      => array( 'hanging-plant-gifts', 'money-plant-gifts', 'desk-plants-for-office' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'jute-wrapped', 'glazed-ceramic', 'cast-concrete' ),
		'designs'   => array( 'matte-plain', 'textured-ribbed' ),
		'short'     => 'A trailing pothos in a cotton macrame hanger, supplied with ceiling hooks and partition clips.',
		'desc'      => '
<h2>Greenery that uses no desk space at all</h2>
<p>On a dense open plan floor, wall and ceiling space is the only space left. A macrame hanger puts a trailing pothos into that space and takes nothing from the working surface, which is why this format keeps growing in new office fitouts.</p>
<h3>What ships with it</h3>
<p>Rooted pothos in an inner pot with drainage, a hand knotted cotton macrame hanger, a fitted drip tray that sits inside the hanger, ceiling hooks and partition clips for offices where drilling is not allowed.</p>
<h3>Installing without damage</h3>
<h4>Partition clips</h4>
<p>Hook over a standard cubicle panel and leave no marks.</p>
<h4>Adhesive ceiling hooks</h4>
<p>Rated well beyond the one and a half kilogram filled weight of a 5 inch pot.</p>
<h3>Watering a hanging plant</h3>
<p>Take the pot down, water it at a sink, let it drain fully, then rehang. Watering in place is how a hanging plant ends up dripping onto the desk below, and the care card says so in the first line.</p>
',
	),

	array(
		'name'      => 'String of Pearls Hanging Gift',
		'slug'      => 'string-of-pearls-hanging-gift',
		'sku'       => 'PG-HNG-002',
		'price'     => 1099,
		'cats'      => array( 'hanging-plant-gifts', 'succulent-corporate-gifts', 'client-appreciation-plant-gifts' ),
		'type'      => 'succulent',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'glazed-ceramic', 'natural-terracotta', 'jute-wrapped' ),
		'designs'   => array( 'minimal-white', 'glossy-two-tone' ),
		'short'     => 'A trailing succulent of bead like leaves on fine stems. Striking near a window, and a poor choice away from one.',
		'desc'      => '
<h2>The trailing succulent people stop to look at</h2>
<p>Senecio rowleyanus grows in long strands of spherical leaves that fall like beaded curtains. It is the most eye catching hanging plant we stock and the one that most often prompts someone to ask where a gift came from.</p>
<h3>Be honest about the light it needs</h3>
<p>String of pearls wants bright light. Away from a window the strands thin out and the beads shrink within a couple of months. If your recipients sit on an interior floor, a pothos in the same hanger is the better gift and we will say so.</p>
<h3>Care</h3>
<h4>Water</h4>
<p>Every two to three weeks. It is a succulent, and the beads shrivel slightly when it is genuinely thirsty.</p>
<h4>Handling</h4>
<p>Strands detach easily. Hang it somewhere it will not be brushed against.</p>
<h3>Presentation</h3>
<p>Supplied established rather than as cuttings, with strands already trailing fifteen to twenty centimetres at the 5 inch size.</p>
',
	),

	/* Hampers -------------------------------------------------------------- */

	array(
		'name'      => 'Festive Plant and Dry Fruit Hamper',
		'slug'      => 'festive-plant-dry-fruit-hamper',
		'sku'       => 'PG-HAM-001',
		'price'     => 1799,
		'cats'      => array( 'plant-gift-hampers', 'diwali-corporate-plant-gifts', 'succulent-corporate-gifts' ),
		'type'      => 'succulent',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium' ),
		'materials' => array( 'glazed-ceramic', 'natural-terracotta' ),
		'designs'   => array( 'matte-plain', 'custom-brand-printed' ),
		'short'     => 'A jade plant, brass diyas, mixed dry fruits and a printed greeting in a plastic free kraft box.',
		'desc'      => '
<h2>The festive box that is still on the desk in March</h2>
<p>Sweets are eaten in a day and dry fruit boxes get passed along. Putting a living plant at the centre of the hamper changes what happens to it, because the plant stays and keeps carrying the association with whoever sent it.</p>
<h3>What is in the box</h3>
<ul>
<li>Jade plant in a glazed ceramic or terracotta pot</li>
<li>Two brass diyas and a tealight</li>
<li>Mixed dry fruits in a paper pouch</li>
<li>Printed greeting card with a blank signature line</li>
<li>Kraft box, paper shred filler, cotton ribbon, no plastic anywhere</li>
</ul>
<h3>Why no chocolate</h3>
<p>Diwali often falls in warm weather and chocolate does not survive courier transport reliably. A melted box ruins the plant and the packaging together, so we substitute dry fruits and say so up front.</p>
<h3>Branding</h3>
<p>Foil logo on the box lid and a printed greeting card. We deliberately keep the pot unbranded, because a plain pot stays on the desk longer than a branded one.</p>
<h3>Lead time</h3>
<p>Two weeks for standard builds, three to four weeks with custom box printing. Book by August for Diwali.</p>
',
	),

	array(
		'name'      => 'New Joiner Welcome Plant Kit',
		'slug'      => 'new-joiner-welcome-plant-kit',
		'sku'       => 'PG-HAM-002',
		'price'     => 1199,
		'cats'      => array( 'plant-gift-hampers', 'employee-welcome-kit-plants', 'succulent-corporate-gifts' ),
		'type'      => 'succulent',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '3-inch-mini-desk', '4-inch-small-desk' ),
		'materials' => array( 'glazed-ceramic', 'jute-wrapped', 'natural-terracotta' ),
		'designs'   => array( 'matte-plain', 'custom-brand-printed' ),
		'short'     => 'A desk succulent, branded notebook, pen and welcome note in a kraft box built to survive a week in storage.',
		'desc'      => '
<h2>Something living on the desk before they sit down</h2>
<p>A welcome kit lands hardest when it is already on the desk on the first morning. This build is designed for that: a plant that survives a week packed in a box, a card that explains how to keep it alive, and one or two branded items that will actually get used.</p>
<h3>What is in the kit</h3>
<ul>
<li>3 or 4 inch succulent with a sealed base and a decorative dressing</li>
<li>Care card naming the plant and the watering interval in days</li>
<li>Branded notebook and pen</li>
<li>Blank welcome note for the hiring manager to sign by hand</li>
</ul>
<h3>Built for rolling dispatch</h3>
<p>Most companies hire continuously. We hold your kit stock and dispatch against a joiner list sent monthly or fortnightly, so you keep the bulk rate without four hundred boxes arriving at once. Reserved stock is held for six months.</p>
<h3>Remote starters</h3>
<p>For people starting from home, we ship individually to the home address timed to arrive a few days before day one, with a tracking link per box so the manager can confirm it landed.</p>
',
	),

	array(
		'name'      => 'Client Thank You Plant Hamper',
		'slug'      => 'client-thank-you-plant-hamper',
		'sku'       => 'PG-HAM-003',
		'price'     => 3499,
		'cats'      => array( 'plant-gift-hampers', 'client-appreciation-plant-gifts', 'bonsai-corporate-gifts' ),
		'type'      => 'bonsai',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '6-inch-standard' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete' ),
		'designs'   => array( 'matte-plain', 'hand-painted' ),
		'short'     => 'A jade bonsai, single origin tea and a soy candle in a rigid magnetic box with a handwritten card.',
		'desc'      => '
<h2>A thank you that does not look like marketing</h2>
<p>Client gifts fail when they read as placement. This build keeps the branding to a handwritten card and, if you want it, a small engraved plate. Everything else is chosen to be genuinely good rather than to carry a logo.</p>
<h3>What is in the box</h3>
<ul>
<li>Jade bonsai in a glazed ceramic tray with a moss dressing</li>
<li>Single origin tea in a sealed tin</li>
<li>Soy candle in a reusable glass</li>
<li>Blank card for a handwritten note</li>
<li>Rigid magnetic box with foam bedding</li>
</ul>
<h3>Timing the delivery</h3>
<p>We schedule client hampers to arrive mid week and mid morning. Monday deliveries get lost in the week opening and Friday arrivals often sit in a post room over the weekend, by which point the plant has been boxed for three days.</p>
<h3>Before you send it</h3>
<p>Check the recipient organisation gifting policy. Plants clear internal caps more easily than most gifts because they read as a workplace item, but a stated value limit still applies.</p>
',
	),

	/* Branded and bulk oriented listings ---------------------------------- */

	array(
		'name'      => 'Logo Engraved Ceramic Planter with Succulent',
		'slug'      => 'logo-engraved-ceramic-planter-succulent',
		'sku'       => 'PG-BRD-001',
		'price'     => 749,
		'cats'      => array( 'branded-logo-planters', 'succulent-corporate-gifts', 'employee-welcome-kit-plants' ),
		'type'      => 'succulent',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete', 'brushed-metal' ),
		'designs'   => array( 'logo-engraved', 'custom-brand-printed' ),
		'short'     => 'Your logo fired into the glaze or laser cut into the pot wall, supplied planted with a desk succulent.',
		'desc'      => '
<h2>Branding that will still be there in three years</h2>
<p>A fired ceramic decal sits under the glaze, so it cannot peel or fade. A laser engraving is cut into the material itself. Both outlast the vinyl stickers that most branded pots use and that start lifting within weeks of the first watering.</p>
<h3>Artwork we need</h3>
<ul>
<li>Vector file in AI, EPS, PDF or SVG with fonts outlined</li>
<li>A single colour version of the mark</li>
<li>Pantone references if exact colour matching matters</li>
</ul>
<h3>The mockup step</h3>
<p>We send a rendered mockup on the actual pot within two working days, and a physical sample above two hundred units. A logo approved as a flat file often looks different wrapped around a curve, and this step exists to catch that.</p>
<h3>Minimums and timing</h3>
<h4>Minimum quantity</h4>
<p>Fifty units for laser engraving, one hundred for fired ceramic decals because of the plate cost.</p>
<h4>Lead time</h4>
<p>Seven to ten working days on top of the normal plant lead time.</p>
<h3>Keep it small</h3>
<p>A modest single colour mark stays on the desk. A large logo with a tagline gets swapped for a plain pot. We will advise on sizing before production.</p>
',
	),

	array(
		'name'      => 'Custom Printed Sleeve Plant Gift',
		'slug'      => 'custom-printed-sleeve-plant-gift',
		'sku'       => 'PG-BRD-002',
		'price'     => 449,
		'cats'      => array( 'branded-logo-planters', 'corporate-event-plant-giveaways', 'money-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '3-inch-mini-desk', '4-inch-small-desk' ),
		'materials' => array( 'jute-wrapped', 'glazed-ceramic', 'natural-terracotta' ),
		'designs'   => array( 'custom-brand-printed', 'matte-plain' ),
		'short'     => 'Full colour artwork on a paper sleeve wrapped around a plain pot. The cheapest route to a branded plant gift.',
		'desc'      => '
<h2>Full colour branding without paying to print a pot</h2>
<p>Printing directly onto a pot is expensive and limits your colours. Printing a paper sleeve costs a fraction as much, reproduces any artwork including gradients and photographs, and leaves the pot itself clean once the recipient removes it.</p>
<h3>Where this format wins</h3>
<h4>Event giveaways</h4>
<p>The sleeve carries the stand number, a QR code and the campaign artwork, and it is discarded after the event without spoiling the plant.</p>
<h4>High volume rounds</h4>
<p>At a thousand units the saving against printed pots usually funds a better plant.</p>
<h3>Specifications</h3>
<p>Recycled kraft or coated white stock, printed CMYK on the outside. Artwork supplied as a print ready PDF at 300dpi with 3mm bleed, or as vector files we can lay out for you.</p>
<h3>Add a QR code</h3>
<p>Event giveaways are one of the few gifting formats where a scan genuinely happens. Point it at a care guide or a landing page rather than a homepage.</p>
<h3>Lead time</h3>
<p>Two weeks for standard runs, three weeks above five hundred units.</p>
',
	),

	array(
		'name'      => 'Self Watering Desk Planter with Snake Plant',
		'slug'      => 'self-watering-desk-planter-snake-plant',
		'sku'       => 'PG-BRD-003',
		'price'     => 999,
		'cats'      => array( 'low-maintenance-plant-gifts', 'desk-plants-for-office', 'branded-logo-planters', 'employee-welcome-kit-plants' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'self-watering', 'glazed-ceramic' ),
		'designs'   => array( 'minimal-white', 'logo-engraved' ),
		'short'     => 'A two chamber pot with a wick and a visible water level indicator, planted with a low light snake plant.',
		'desc'      => '
<h2>For the team that is only in the office twice a week</h2>
<p>A self watering pot holds a reservoir beneath the soil and wicks moisture up as the plant uses it. Filled once, it carries a snake plant through three weeks or more. For hybrid teams and people who travel, that single upgrade does more for plant survival than any species choice.</p>
<h3>How the pot works</h3>
<h4>The reservoir</h4>
<p>Filled through a side port, with a float indicator showing the level so nobody has to guess.</p>
<h4>The wick</h4>
<p>A cotton rope draws water into the root zone at the rate the plant draws it out.</p>
<h3>Why a snake plant</h3>
<p>Sansevieria is already the most drought tolerant plant we stock. Pairing it with a reservoir makes it close to unkillable, which is exactly what a distributed team needs.</p>
<h3>Branding</h3>
<p>The flat front face of the outer pot takes a laser engraving or a printed panel, and it gives a larger usable area than a curved ceramic pot at the same size.</p>
<h3>Refill interval</h3>
<p>Roughly every three weeks at the 4 inch size and every four to five weeks at 6 inch, printed on the care card.</p>
',
	),

	array(
		'name'      => 'Mini Succulent Event Giveaway Pack',
		'slug'      => 'mini-succulent-event-giveaway-pack',
		'sku'       => 'PG-EVT-001',
		'price'     => 249,
		'cats'      => array( 'corporate-event-plant-giveaways', 'succulent-corporate-gifts', 'branded-logo-planters' ),
		'type'      => 'succulent',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '3-inch-mini-desk' ),
		'materials' => array( 'natural-terracotta', 'jute-wrapped', 'glazed-ceramic' ),
		'designs'   => array( 'custom-brand-printed', 'matte-plain' ),
		'short'     => 'A single mini succulent in a branded sleeve, boxed individually and counted in fifties for a handout table.',
		'desc'      => '
<h2>Built for a registration desk queue</h2>
<p>Loose pots slow a handout table down. Each unit here ships in its own sleeve or small box so a volunteer can pass one over in a second, and cartons are counted and labelled in fifties so the table restocks without anyone recounting.</p>
<h3>What attendees get</h3>
<p>A 3 inch succulent, a printed sleeve with your artwork and optional QR code, and a small care tag. Light enough for a conference bag and sturdy enough to survive a flight home in hand luggage.</p>
<h3>What we need from you</h3>
<ul>
<li>Final quantity plus roughly ten percent for walk ins</li>
<li>Venue address, delivery window and a named on site contact</li>
<li>Artwork at least two weeks before the event</li>
<li>Confirmation that the plants can be stored indoors overnight</li>
</ul>
<h3>Storage on site</h3>
<p>An indoor storeroom, not a loading bay. Succulents handle a night in a sealed carton but not a hot warehouse, so tell us your storage and we will time the delivery around it.</p>
<h3>Lead time</h3>
<p>Two weeks unbranded, three weeks with printed sleeves above five hundred units.</p>
',
	),

	array(
		'name'      => 'Areca Palm Cabin Plant Gift',
		'slug'      => 'areca-palm-cabin-plant-gift',
		'sku'       => 'PG-FOL-006',
		'price'     => 1699,
		'cats'      => array( 'air-purifying-plant-gifts', 'client-appreciation-plant-gifts', 'desk-plants-for-office' ),
		'type'      => 'foliage',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '6-inch-standard', '8-inch-large' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete', 'self-watering' ),
		'designs'   => array( 'matte-plain', 'textured-ribbed' ),
		'short'     => 'A feathery palm that raises humidity in a dry cabin. Non toxic, so it suits pet friendly workplaces.',
		'desc'      => '
<h2>The plant that makes an air conditioned cabin feel less dry</h2>
<p>Dypsis lutescens moves a genuinely useful amount of moisture into the air around it, which is noticeable in a small air conditioned cabin. It also grows tall enough to soften a corner in a way a desk plant cannot, and it is non toxic to cats and dogs.</p>
<h3>Where to place it</h3>
<p>A bright corner within two or three metres of a window, standing on the floor or a low table. It needs an 8 inch pot minimum to stay stable at full height, so it is a cabin, reception and lounge gift rather than a workstation one.</p>
<h3>Care</h3>
<h4>Water</h4>
<p>Weekly, keeping the soil lightly moist. Areca drinks more than anything else in our range.</p>
<h4>Light</h4>
<p>Bright indirect. Direct sun scorches the fronds.</p>
<h4>The common problem</h4>
<p>Brown frond tips almost always mean dry air or fluoride in tap water. Rested water and an occasional misting fix it.</p>
<h3>Packing</h3>
<p>Shipped with fronds bound and the soil secured, in a tall double wall carton marked for upright transit.</p>
',
	),

	array(
		'name'      => 'Aglaonema Red Foliage Desk Gift',
		'slug'      => 'aglaonema-red-foliage-desk-gift',
		'sku'       => 'PG-FOL-007',
		'price'     => 899,
		'cats'      => array( 'desk-plants-for-office', 'air-purifying-plant-gifts', 'work-anniversary-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete', 'self-watering' ),
		'designs'   => array( 'minimal-white', 'matte-plain' ),
		'short'     => 'Pink and red variegated leaves on a plant that keeps its colour in low light, which is rare.',
		'desc'      => '
<h2>Colour that does not need a window</h2>
<p>Most coloured foliage fades to green when the light drops. Aglaonema is the exception. The red and pink varieties hold their variegation under office lighting, which makes them the only genuinely colourful option for an interior floor.</p>
<h3>Varieties</h3>
<h4>Red Siam</h4>
<p>Deep pink midribs and margins against dark green. The most requested.</p>
<h4>Silver Bay</h4>
<p>Broad silver centres, calmer and slightly cheaper.</p>
<h3>Why it suits milestone gifting</h3>
<p>It looks more expensive than it is, grows slowly enough to stay in proportion on a desk for years, and does not demand any care that a busy person will fail to provide.</p>
<h3>Care</h3>
<p>Water every seven to ten days once the top of the soil is dry. Keep it away from cold draughts, since Aglaonema marks when chilled. Mildly toxic if chewed.</p>
',
	),

	array(
		'name'      => 'Rubber Plant Statement Office Gift',
		'slug'      => 'rubber-plant-statement-office-gift',
		'sku'       => 'PG-FOL-008',
		'price'     => 1499,
		'cats'      => array( 'desk-plants-for-office', 'air-purifying-plant-gifts', 'client-appreciation-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '6-inch-standard', '8-inch-large' ),
		'materials' => array( 'cast-concrete', 'glazed-ceramic', 'brushed-metal' ),
		'designs'   => array( 'matte-plain', 'textured-ribbed' ),
		'short'     => 'Large glossy burgundy leaves on an upright plant that fills a corner without needing much attention.',
		'desc'      => '
<h2>Presence without fuss</h2>
<p>Ficus elastica carries big, thick, high gloss leaves in deep green or burgundy. A single plant reads as decor rather than as a pot on a table, which is why it works for cabins, reception areas and senior gifting.</p>
<h3>Compared with a fiddle leaf fig</h3>
<p>A rubber plant delivers a similar visual effect and is considerably more forgiving. Fiddle leaf figs drop leaves when moved, chilled or watered unevenly, and we do not stock them for gifting for exactly that reason.</p>
<h3>Care</h3>
<h4>Water</h4>
<p>Every ten days once the top few centimetres dry out.</p>
<h4>Light</h4>
<p>Bright indirect. The burgundy varieties need more light than the green ones to hold their colour.</p>
<h4>Leaves</h4>
<p>Wipe monthly. Dust on a glossy leaf is visible from across a room and is the main reason these plants stop looking premium.</p>
<h3>Packing</h3>
<p>Shipped in a tall carton with the leaves interleaved in tissue and the soil secured under a mesh disc.</p>
',
	),

	array(
		'name'      => 'Tulsi Sacred Basil Festive Gift',
		'slug'      => 'tulsi-sacred-basil-festive-gift',
		'sku'       => 'PG-FLW-004',
		'price'     => 499,
		'cats'      => array( 'diwali-corporate-plant-gifts', 'flowering-plant-gifts' ),
		'type'      => 'flowering',
		'light'     => 'direct-sunlight',
		'sizes'     => array( '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'natural-terracotta', 'glazed-ceramic' ),
		'designs'   => array( 'matte-plain', 'hand-painted' ),
		'short'     => 'A traditional festive plant for the home rather than the desk, supplied in a terracotta pot with a care card.',
		'desc'      => '
<h2>A festive gift meant for the home</h2>
<p>Tulsi carries deep cultural significance across India, which makes it a meaningful Diwali gift. It also needs four to six hours of direct sunlight, so it belongs on a balcony or a windowsill rather than on an office desk. Gift it when you know it is going home.</p>
<h3>Varieties</h3>
<h4>Rama tulsi</h4>
<p>Green leaves, milder aroma, slightly hardier.</p>
<h4>Krishna tulsi</h4>
<p>Purple tinged leaves and a stronger scent.</p>
<h3>Care</h3>
<p>Direct sun daily, water when the top of the soil dries, and pinch off flower spikes to keep the plant bushy and productive. Tulsi is short lived by nature, generally a year or two, and the care card says so plainly so nobody feels they have failed the plant.</p>
<h3>Presentation</h3>
<p>Natural terracotta suits the plant and the occasion better than a glossy modern pot. A hand painted terracotta option is available for festive rounds.</p>
',
	),

	array(
		'name'      => 'Bamboo Palm Reception Plant Gift',
		'slug'      => 'bamboo-palm-reception-plant-gift',
		'sku'       => 'PG-FOL-009',
		'price'     => 1899,
		'cats'      => array( 'air-purifying-plant-gifts', 'desk-plants-for-office', 'client-appreciation-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '8-inch-large' ),
		'materials' => array( 'cast-concrete', 'glazed-ceramic', 'self-watering' ),
		'designs'   => array( 'matte-plain', 'textured-ribbed' ),
		'short'     => 'Chamaedorea seifrizii, a clumping palm that tolerates lower light than most and is safe around pets.',
		'desc'      => '
<h2>A palm that does not need a bright window</h2>
<p>Most palms sulk away from strong light. Chamaedorea seifrizii is the exception, holding its colour in the moderate light of a reception area or a corridor. It is also non toxic to cats and dogs, which narrows the options considerably in a pet friendly office.</p>
<h3>Where it belongs</h3>
<p>Floor standing in an 8 inch pot beside a reception desk, a lift lobby or a meeting room entrance. It reaches roughly one and a half metres over a few years and stays narrow, so it does not encroach on a walkway.</p>
<h3>Care</h3>
<h4>Water</h4>
<p>Weekly, keeping the soil lightly moist without letting it sit wet.</p>
<h4>Light</h4>
<p>Moderate to bright indirect. It survives lower light than any other palm we grow.</p>
<h4>Watch for</h4>
<p>Spider mites in dry air. A monthly leaf wipe prevents them, and the care card explains what to look for.</p>
<h3>Delivery</h3>
<p>Shipped upright in a tall carton with the fronds bound. Two person handling is recommended on arrival.</p>
',
	),

	array(
		'name'      => 'Fittonia Nerve Plant Mini Gift',
		'slug'      => 'fittonia-nerve-plant-mini-gift',
		'sku'       => 'PG-FOL-010',
		'price'     => 349,
		'cats'      => array( 'desk-plants-for-office', 'terrarium-gift-sets', 'corporate-event-plant-giveaways' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '3-inch-mini-desk', '4-inch-small-desk' ),
		'materials' => array( 'glass-terrarium', 'glazed-ceramic', 'jute-wrapped' ),
		'designs'   => array( 'matte-plain', 'glossy-two-tone' ),
		'short'     => 'Tiny veined leaves in pink, red or white. Dramatic, compact and honest about needing regular water.',
		'desc'      => '
<h2>The smallest plant with the most colour</h2>
<p>Fittonia packs bright pink, red or white veining into leaves barely three centimetres long. In a 3 inch pot it makes more visual impact than anything else at that size, which is why it appears in event giveaways and closed terrariums.</p>
<h3>The honest caveat</h3>
<p>Fittonia wants consistently moist soil and higher humidity than an air conditioned office provides. It collapses dramatically when dry, and although it recovers within an hour of watering, that cycle is stressful for the plant and for the person watching it. It works best inside a terrarium.</p>
<h3>Best use</h3>
<h4>In a closed terrarium</h4>
<p>Ideal. The sealed humidity solves every problem the plant has.</p>
<h4>On an open desk</h4>
<p>Only for someone who waters attentively, and paired with a pebble humidity tray.</p>
<h3>Care</h3>
<p>Keep the soil lightly moist at all times. Non toxic to pets, which is unusual for a plant this decorative.</p>
',
	),

	array(
		'name'      => 'Bulk Desk Succulent Assortment Box of 25',
		'slug'      => 'bulk-desk-succulent-assortment-box-25',
		'sku'       => 'PG-BLK-001',
		'price'     => 7999,
		'cats'      => array( 'succulent-corporate-gifts', 'corporate-event-plant-giveaways', 'low-maintenance-plant-gifts' ),
		'type'      => 'succulent',
		'light'     => 'bright-indirect-light',
		'sizes'     => array( '3-inch-mini-desk', '4-inch-small-desk' ),
		'materials' => array( 'natural-terracotta', 'glazed-ceramic', 'jute-wrapped' ),
		'designs'   => array( 'matte-plain', 'custom-brand-printed' ),
		'short'     => 'Twenty five assorted desk succulents in one carton, sorted and counted for a team wide handout.',
		'desc'      => '
<h2>One carton, twenty five desks</h2>
<p>The simplest way to green a small team. Twenty five assorted succulents arrive in a single counted carton with individual protective inserts, ready to distribute without any sorting on your side.</p>
<h3>What is in the mix</h3>
<p>A rotating assortment of Haworthia, Echeveria, Sedum and Crassula, weighted toward the low light tolerant species. Tell us if the desks are away from windows and we adjust the mix accordingly at no cost.</p>
<h3>Why buy the box rather than individual units</h3>
<h4>Price</h4>
<p>The box is priced at the 25 unit bulk slab automatically, with no minimum order conversation needed.</p>
<h4>Logistics</h4>
<p>One tracking number, one delivery, one invoice.</p>
<h3>Scaling up</h3>
<p>Order multiple boxes to cross into the 50, 100 and 250 unit slabs, where the per plant price drops further. The slab applies to the combined quantity in the cart rather than per line item.</p>
<h3>Branding</h3>
<p>Printed sleeves can be added across the whole box for a flat setup charge plus a small per unit cost.</p>
',
	),

	array(
		'name'      => 'Office Plant Starter Set of Five',
		'slug'      => 'office-plant-starter-set-of-five',
		'sku'       => 'PG-BLK-002',
		'price'     => 2999,
		'cats'      => array( 'desk-plants-for-office', 'air-purifying-plant-gifts', 'low-maintenance-plant-gifts' ),
		'type'      => 'foliage',
		'light'     => 'low-light-tolerant',
		'sizes'     => array( '4-inch-small-desk', '5-inch-medium', '6-inch-standard' ),
		'materials' => array( 'glazed-ceramic', 'cast-concrete', 'self-watering' ),
		'designs'   => array( 'matte-plain', 'minimal-white' ),
		'short'     => 'Five different low light plants chosen to cover a small office: desks, a meeting table and a reception corner.',
		'desc'      => '
<h2>Greening a small office in one order</h2>
<p>A curated set of five rather than five of the same thing. The mix is chosen so that each plant suits a different spot in a small office, which is a better outcome than putting an identical pot on every surface.</p>
<h3>What is in the set</h3>
<ul>
<li>Snake plant for a dark corner</li>
<li>ZZ plant for a meeting room or corridor</li>
<li>Money plant for a shelf edge, trailing</li>
<li>Peperomia for a desk with limited space</li>
<li>Aglaonema for a spot that needs colour without light</li>
</ul>
<h3>Why this combination works</h3>
<p>Every plant in the set tolerates low light and a fortnightly watering rhythm, so whoever ends up looking after them can water the whole office on one walk around rather than remembering five different schedules.</p>
<h3>Care</h3>
<p>A single laminated care sheet covers all five plants with the interval for each in days. It is designed to be pinned up in an office pantry.</p>
<h3>Scaling</h3>
<p>Multiple sets ship together and count toward the bulk slabs, so a twenty person office ordering four sets lands in the 25 unit tier.</p>
',
	),
);
