<?php
/**
 * Home page.
 *
 * The hero, category and process sections are generated here so the layout stays
 * consistent. Anything typed into the Home page editor is printed inside the
 * "story" section, which keeps the page editable without breaking the design.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

get_header();

$pg_has_woo = class_exists( 'WooCommerce' );
$pg_shop    = $pg_has_woo ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
?>

<section class="pg-hero">
	<div class="pg-wrap pg-hero__grid">
		<div>
			<p class="pg-eyebrow"><?php esc_html_e( 'Corporate plant gifts', 'plantgift-pro' ); ?></p>
			<h1><?php echo esc_html( get_theme_mod( 'plantgift_hero_title', __( 'Corporate Plant Gifts for Colleagues, Employees, Events and Clients', 'plantgift-pro' ) ) ); ?></h1>
			<p class="pg-hero__lede">
				<?php echo esc_html( get_theme_mod( 'plantgift_hero_text', __( 'Surprise your teams and your clients with low maintenance greenery that lives on their desk long after the gifting season ends. Choose succulents, air plants and air purifying favourites, then pick the pot size, material and design that suits your brand.', 'plantgift-pro' ) ) ); ?>
			</p>
			<div class="pg-btn-row">
				<a class="pg-btn pg-btn--lg" href="<?php echo esc_url( $pg_shop ); ?>"><?php esc_html_e( 'Shop plant gifts', 'plantgift-pro' ); ?></a>
				<a class="pg-btn pg-btn--ghost pg-btn--lg" href="<?php echo esc_url( home_url( '/bulk-plant-gifts-for-companies/' ) ); ?>"><?php esc_html_e( 'Bulk order pricing', 'plantgift-pro' ); ?></a>
			</div>
			<div class="pg-hero__trust">
				<div><strong>25+</strong><span><?php esc_html_e( 'Minimum units per bulk order', 'plantgift-pro' ); ?></span></div>
				<div><strong>48 hrs</strong><span><?php esc_html_e( 'Branded mockup turnaround', 'plantgift-pro' ); ?></span></div>
				<div><strong>4.8/5</strong><span><?php esc_html_e( 'Average buyer rating', 'plantgift-pro' ); ?></span></div>
			</div>
		</div>
		<div class="pg-hero__art">
			<?php
			$pg_hero_img = get_theme_mod( 'plantgift_hero_image', '' );
			if ( $pg_hero_img ) :
				?>
				<img src="<?php echo esc_url( $pg_hero_img ); ?>" alt="<?php esc_attr_e( 'Succulents and air plants in branded ceramic pots arranged as corporate gifts', 'plantgift-pro' ); ?>" fetchpriority="high" width="900" height="720">
			<?php endif; ?>
			<div class="pg-hero__badge">
				<strong><?php esc_html_e( 'Your logo on every pot', 'plantgift-pro' ); ?></strong>
				<?php esc_html_e( 'Laser engraving, sleeve printing and custom care cards included.', 'plantgift-pro' ); ?>
			</div>
		</div>
	</div>
</section>

<?php plantgift_pro_trust_strip(); ?>

<section class="pg-section" aria-labelledby="pg-cats-title">
	<div class="pg-wrap">
		<div class="pg-section-head pg-section-head--center">
			<p class="pg-eyebrow"><?php esc_html_e( 'Shop by category', 'plantgift-pro' ); ?></p>
			<h2 id="pg-cats-title"><?php esc_html_e( 'Every plant gifting category, sorted by what your team actually needs', 'plantgift-pro' ); ?></h2>
			<p class="pg-lede"><?php esc_html_e( 'Each collection lists the plants available in that range along with the pot sizes, pot materials and design variants you can pick during checkout.', 'plantgift-pro' ); ?></p>
		</div>

		<?php
		if ( $pg_has_woo ) {
			$pg_cats = get_terms(
				array(
					'taxonomy'   => 'product_cat',
					'parent'     => 0,
					'hide_empty' => false,
					'number'     => 12,
					'orderby'    => 'menu_order',
					'exclude'    => array( get_option( 'default_product_cat' ) ),
				)
			);

			if ( $pg_cats && ! is_wp_error( $pg_cats ) ) {
				echo '<div class="pg-grid pg-grid--4">';
				foreach ( $pg_cats as $pg_cat ) {
					$pg_thumb_id = get_term_meta( $pg_cat->term_id, 'thumbnail_id', true );
					?>
					<article class="pg-card">
						<a class="pg-card__media" href="<?php echo esc_url( get_term_link( $pg_cat ) ); ?>" tabindex="-1" aria-hidden="true">
							<?php
							if ( $pg_thumb_id ) {
								echo wp_get_attachment_image( $pg_thumb_id, 'plantgift-card', false, array( 'loading' => 'lazy', 'alt' => esc_attr( $pg_cat->name ) ) );
							}
							?>
						</a>
						<div class="pg-card__body">
							<h3 class="pg-card__title"><a href="<?php echo esc_url( get_term_link( $pg_cat ) ); ?>"><?php echo esc_html( $pg_cat->name ); ?></a></h3>
							<?php if ( $pg_cat->description ) : ?>
								<p class="pg-card__text"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $pg_cat->description ), 18 ) ); ?></p>
							<?php endif; ?>
							<p class="pg-card__meta">
								<?php
								/* translators: %d: number of products. */
								printf( esc_html( _n( '%d gift option', '%d gift options', (int) $pg_cat->count, 'plantgift-pro' ) ), (int) $pg_cat->count );
								?>
							</p>
						</div>
					</article>
					<?php
				}
				echo '</div>';
			}
		}
		?>

		<p class="pg-center pg-mt-2">
			<a class="pg-btn pg-btn--ghost" href="<?php echo esc_url( $pg_shop ); ?>"><?php esc_html_e( 'View the full plant gift catalogue', 'plantgift-pro' ); ?></a>
		</p>
	</div>
</section>

<section class="pg-section pg-section--cream" aria-labelledby="pg-variants-title">
	<div class="pg-wrap">
		<div class="pg-split">
			<div>
				<p class="pg-eyebrow"><?php esc_html_e( 'Pots and variants', 'plantgift-pro' ); ?></p>
				<h2 id="pg-variants-title"><?php esc_html_e( 'Pick the pot size, material and design on every product page', 'plantgift-pro' ); ?></h2>
				<p><?php esc_html_e( 'A plant gift only looks premium when the pot matches the desk it sits on. Every listing in the store is a variable product, so you choose the combination before adding it to the cart and the price updates instantly.', 'plantgift-pro' ); ?></p>

				<h3><?php esc_html_e( 'Pot sizes that fit a working desk', 'plantgift-pro' ); ?></h3>
				<ul class="pg-check-list">
					<li><?php esc_html_e( '3 inch mini pots for cubicles, laptop trays and reception counters', 'plantgift-pro' ); ?></li>
					<li><?php esc_html_e( '4 and 5 inch pots for standard workstations and meeting tables', 'plantgift-pro' ); ?></li>
					<li><?php esc_html_e( '6 and 8 inch pots for cabins, lounges and leadership gifting', 'plantgift-pro' ); ?></li>
				</ul>

				<h3><?php esc_html_e( 'Materials and finishes', 'plantgift-pro' ); ?></h3>
				<p><?php esc_html_e( 'Ceramic, terracotta, self watering, brushed metal, jute wrapped, glass and concrete. Each material carries a different weight, drainage behaviour and branding method, and the product page explains which one suits your use.', 'plantgift-pro' ); ?></p>
			</div>
			<div>
				<div class="pg-table-scroll">
					<table>
						<caption class="screen-reader-text"><?php esc_html_e( 'Pot size guide for corporate plant gifts', 'plantgift-pro' ); ?></caption>
						<thead>
							<tr>
								<th scope="col"><?php esc_html_e( 'Pot size', 'plantgift-pro' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Best for', 'plantgift-pro' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Typical plants', 'plantgift-pro' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr><th scope="row"><?php esc_html_e( '3 inch', 'plantgift-pro' ); ?></th><td><?php esc_html_e( 'Event giveaways, table favours', 'plantgift-pro' ); ?></td><td><?php esc_html_e( 'Haworthia, Echeveria, Tillandsia', 'plantgift-pro' ); ?></td></tr>
							<tr><th scope="row"><?php esc_html_e( '4 inch', 'plantgift-pro' ); ?></th><td><?php esc_html_e( 'Employee welcome kits', 'plantgift-pro' ); ?></td><td><?php esc_html_e( 'Jade, Syngonium, Peperomia', 'plantgift-pro' ); ?></td></tr>
							<tr><th scope="row"><?php esc_html_e( '5 inch', 'plantgift-pro' ); ?></th><td><?php esc_html_e( 'Work anniversaries', 'plantgift-pro' ); ?></td><td><?php esc_html_e( 'Money plant, Lucky bamboo', 'plantgift-pro' ); ?></td></tr>
							<tr><th scope="row"><?php esc_html_e( '6 inch', 'plantgift-pro' ); ?></th><td><?php esc_html_e( 'Client and partner gifting', 'plantgift-pro' ); ?></td><td><?php esc_html_e( 'Snake plant, ZZ plant, Bonsai', 'plantgift-pro' ); ?></td></tr>
							<tr><th scope="row"><?php esc_html_e( '8 inch', 'plantgift-pro' ); ?></th><td><?php esc_html_e( 'Cabins and leadership gifts', 'plantgift-pro' ); ?></td><td><?php esc_html_e( 'Peace lily, Areca palm', 'plantgift-pro' ); ?></td></tr>
						</tbody>
					</table>
				</div>
				<p class="pg-small pg-muted pg-mt-2"><?php esc_html_e( 'Sizes refer to the pot diameter at the rim. Plant height varies by season and is listed on each product page.', 'plantgift-pro' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="pg-section" aria-labelledby="pg-services-title">
	<div class="pg-wrap">
		<div class="pg-section-head pg-section-head--center">
			<p class="pg-eyebrow"><?php esc_html_e( 'Gifting services', 'plantgift-pro' ); ?></p>
			<h2 id="pg-services-title"><?php esc_html_e( 'Services built around how companies actually gift', 'plantgift-pro' ); ?></h2>
		</div>

		<?php
		$pg_services = array(
			array( 'gift', __( 'Bulk plant gifts for companies', 'plantgift-pro' ), __( 'Tiered pricing from 25 units upward, with one consolidated invoice and a single delivery window.', 'plantgift-pro' ), '/bulk-plant-gifts-for-companies/' ),
			array( 'brush', __( 'Custom branded planters', 'plantgift-pro' ), __( 'Laser engraving, ceramic decals, printed sleeves and care cards carrying your logo and message.', 'plantgift-pro' ), '/custom-branded-planters/' ),
			array( 'users', __( 'Employee onboarding plant gifts', 'plantgift-pro' ), __( 'Desk ready kits that reach a new joiner on day one, shipped to home or to the office.', 'plantgift-pro' ), '/employee-onboarding-plant-gifts/' ),
			array( 'building', __( 'Client gifting programme', 'plantgift-pro' ), __( 'Premium bonsai, jade and air purifying plants presented in rigid boxes with a handwritten note.', 'plantgift-pro' ), '/client-gifting-programme/' ),
			array( 'calendar', __( 'Event and conference giveaways', 'plantgift-pro' ), __( 'Mini succulents and air plants packed for booth handouts, with per box labelling.', 'plantgift-pro' ), '/event-plant-giveaway-service/' ),
			array( 'star', __( 'Festival and Diwali hampers', 'plantgift-pro' ), __( 'Auspicious plants paired with dry fruits, diyas and sustainable packaging for the festive round.', 'plantgift-pro' ), '/festival-corporate-plant-gifts/' ),
			array( 'sprout', __( 'Office plant subscription', 'plantgift-pro' ), __( 'A quarterly refresh of desk plants with on site care visits and free replacements.', 'plantgift-pro' ), '/office-plant-subscription/' ),
			array( 'droplet', __( 'Plant care support', 'plantgift-pro' ), __( 'Care cards, watering schedules and a helpline your recipients can use for a full year.', 'plantgift-pro' ), '/plant-care-guide/' ),
		);
		?>

		<div class="pg-grid pg-grid--4">
			<?php foreach ( $pg_services as $pg_service ) : ?>
				<article class="pg-icon-card">
					<div class="pg-icon-card__icon"><?php plantgift_pro_the_icon( $pg_service[0], 24 ); ?></div>
					<h3><a href="<?php echo esc_url( home_url( $pg_service[3] ) ); ?>" style="text-decoration:none;color:inherit;"><?php echo esc_html( $pg_service[1] ); ?></a></h3>
					<p><?php echo esc_html( $pg_service[2] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
// Anything written in the Home page editor appears here.
while ( have_posts() ) :
	the_post();
	$pg_content = trim( get_the_content() );
	if ( $pg_content ) :
		?>
		<section class="pg-section pg-section--mint">
			<div class="pg-wrap">
				<div class="pg-entry" style="max-width:78ch;margin-inline:auto;">
					<?php the_content(); ?>
				</div>
			</div>
		</section>
		<?php
	endif;
endwhile;
?>

<section class="pg-section pg-section--cream" aria-labelledby="pg-how-title">
	<div class="pg-wrap">
		<div class="pg-section-head">
			<p class="pg-eyebrow"><?php esc_html_e( 'How ordering works', 'plantgift-pro' ); ?></p>
			<h2 id="pg-how-title"><?php esc_html_e( 'From shortlist to delivered desks in four steps', 'plantgift-pro' ); ?></h2>
		</div>
		<ol class="pg-steps">
			<li>
				<h3><?php esc_html_e( 'Share your brief', 'plantgift-pro' ); ?></h3>
				<p><?php esc_html_e( 'Tell us the headcount, the budget per gift and the delivery cities. Nothing else is needed to start.', 'plantgift-pro' ); ?></p>
			</li>
			<li>
				<h3><?php esc_html_e( 'Approve the mockup', 'plantgift-pro' ); ?></h3>
				<p><?php esc_html_e( 'We send a shortlist with real photos and a branded pot mockup within one working day.', 'plantgift-pro' ); ?></p>
			</li>
			<li>
				<h3><?php esc_html_e( 'We pot and pack', 'plantgift-pro' ); ?></h3>
				<p><?php esc_html_e( 'Plants are hardened, potted, quality checked and packed in shock resistant cartons.', 'plantgift-pro' ); ?></p>
			</li>
			<li>
				<h3><?php esc_html_e( 'Delivered and tracked', 'plantgift-pro' ); ?></h3>
				<p><?php esc_html_e( 'Bulk drops to one office address or individual shipments to home addresses, both fully tracked.', 'plantgift-pro' ); ?></p>
			</li>
		</ol>
	</div>
</section>

<?php
$pg_home_faqs = array(
	array(
		'q' => __( 'What are the best corporate plant gifts for employees who travel often?', 'plantgift-pro' ),
		'a' => __( 'Air plants and succulents are the safest picks. Tillandsia needs a soak once a week and no soil at all, while Haworthia and Echeveria hold water in their leaves and stay healthy through two or three weeks of neglect. Both survive air conditioned offices with indirect light, which is exactly the environment most desks offer.', 'plantgift-pro' ),
	),
	array(
		'q' => __( 'How many units do I need to order to get bulk pricing?', 'plantgift-pro' ),
		'a' => __( 'Tiered pricing begins at 25 units and improves at 50, 100, 250 and 500 units. The tier applies across the whole order rather than per product, so a mixed cart of succulents and air plants still qualifies once the combined quantity crosses a slab.', 'plantgift-pro' ),
	),
	array(
		'q' => __( 'Can you print our company logo on the pots?', 'plantgift-pro' ),
		'a' => __( 'Yes. Ceramic pots take a fired decal or a laser etch, terracotta suits a screen print, metal takes engraving and jute sleeves take a flat print. Send a vector file and we return a mockup within two working days before anything goes into production.', 'plantgift-pro' ),
	),
	array(
		'q' => __( 'Do the plants arrive alive after a long courier route?', 'plantgift-pro' ),
		'a' => __( 'Plants are hardened for a week before dispatch, the soil is trimmed to travel weight and each pot travels in a moulded insert inside a double wall carton. If a plant arrives damaged, send a photo within 48 hours of delivery and we replace it at no cost.', 'plantgift-pro' ),
	),
	array(
		'q' => __( 'Which pot material should we choose for an office gift?', 'plantgift-pro' ),
		'a' => __( 'Ceramic looks best on a desk and holds moisture longer, which suits people who water irregularly. Terracotta breathes and suits succulents that hate wet roots. Self watering pots are the practical choice for teams that travel. Metal and concrete read as premium and work well for leadership gifting.', 'plantgift-pro' ),
	),
	array(
		'q' => __( 'Can you deliver to employees working from home in different cities?', 'plantgift-pro' ),
		'a' => __( 'Yes. Share a spreadsheet with names, addresses and phone numbers and we ship individually with a tracking link per recipient. There is a per shipment logistics charge that shows up separately in the quote.', 'plantgift-pro' ),
	),
	array(
		'q' => __( 'How far in advance should we place a festive order?', 'plantgift-pro' ),
		'a' => __( 'Book three to four weeks ahead for Diwali and New Year rounds. Branded pots need production time and courier networks slow down during festival weeks, so an early lock in protects both the design and the delivery date.', 'plantgift-pro' ),
	),
	array(
		'q' => __( 'Do you provide a care guide with each plant?', 'plantgift-pro' ),
		'a' => __( 'Every gift ships with a printed care card that covers watering frequency, light needs and the two mistakes people usually make with that species. The card can carry your branding and a QR code that points to a longer care page.', 'plantgift-pro' ),
	),
	array(
		'q' => __( 'Can we mix different plants and pot designs in one order?', 'plantgift-pro' ),
		'a' => __( 'You can. Many buyers pick one design for the wider team and a premium variant for senior members. Add each combination to the cart separately and the bulk tier still applies to the combined quantity.', 'plantgift-pro' ),
	),
	array(
		'q' => __( 'What is the return or replacement policy on plant gifts?', 'plantgift-pro' ),
		'a' => __( 'Live plants cannot be returned for a change of mind, but anything that arrives broken, wilted or in the wrong variant is replaced or refunded once you send a photo within 48 hours. Branded and personalised pots are covered by the same promise.', 'plantgift-pro' ),
	),
);
?>

<section class="pg-section" aria-labelledby="pg-faq-title">
	<div class="pg-wrap">
		<div class="pg-section-head">
			<p class="pg-eyebrow"><?php esc_html_e( 'Questions buyers ask us', 'plantgift-pro' ); ?></p>
			<h2 id="pg-faq-title"><?php esc_html_e( 'Frequently asked questions about corporate plant gifting', 'plantgift-pro' ); ?></h2>
		</div>
		<?php
		plantgift_pro_faq_list( $pg_home_faqs );
		if ( function_exists( 'plantgift_core_faq_schema' ) ) {
			plantgift_core_faq_schema( $pg_home_faqs );
		}
		?>
	</div>
</section>

<section class="pg-section pg-section--tight">
	<div class="pg-wrap">
		<div class="pg-cta">
			<h2><?php esc_html_e( 'Ready to gift greenery that outlives the gifting season?', 'plantgift-pro' ); ?></h2>
			<p><?php esc_html_e( 'Send us your headcount and budget. You will have a shortlist, a branded mockup and a landed cost in your inbox by the next working day.', 'plantgift-pro' ); ?></p>
			<div class="pg-btn-row">
				<a class="pg-btn pg-btn--light pg-btn--lg" href="<?php echo esc_url( home_url( '/corporate-plant-gifting/' ) ); ?>"><?php esc_html_e( 'Request a gifting quote', 'plantgift-pro' ); ?></a>
				<a class="pg-btn pg-btn--clay pg-btn--lg" href="<?php echo esc_url( $pg_shop ); ?>"><?php esc_html_e( 'Browse the catalogue', 'plantgift-pro' ); ?></a>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
