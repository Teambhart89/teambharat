<?php
/**
 * Template Name: Corporate Gifting Landing Page
 * Template Post Type: page
 *
 * A full width B2B landing page built around one goal: producing a bulk
 * enquiry. The form sits in the hero rather than at the bottom, because a
 * corporate buyer arriving from search already knows what they want and the
 * page should not make them scroll to ask for it.
 *
 * Sections are generated here so the layout stays consistent. Anything typed
 * into the page editor appears in the "why plants" band, and the FAQ block and
 * related categories come from the page meta fields.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$pg_id      = get_the_ID();
	$pg_eyebrow = get_post_meta( $pg_id, '_pg_eyebrow', true );
	$pg_faqs    = get_post_meta( $pg_id, '_pg_faqs', true );
	$pg_cats    = get_post_meta( $pg_id, '_pg_related_cats', true );
	$pg_shop    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
	?>

	<!-- Hero with the enquiry form -------------------------------------- -->
	<section class="pg-lp-hero">
		<div class="pg-wrap pg-lp-hero__grid">

			<div class="pg-lp-hero__copy">
				<?php if ( $pg_eyebrow ) : ?>
					<p class="pg-eyebrow"><?php echo esc_html( $pg_eyebrow ); ?></p>
				<?php endif; ?>

				<h1><?php the_title(); ?></h1>

				<?php if ( has_excerpt() ) : ?>
					<p class="pg-lp-hero__lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>

				<ul class="pg-check-list pg-lp-hero__points">
					<li><?php esc_html_e( 'Bulk pricing from 25 units, quoted the same day', 'plantgift-pro' ); ?></li>
					<li><?php esc_html_e( 'Your logo engraved or printed, mockup in 48 hours', 'plantgift-pro' ); ?></li>
					<li><?php esc_html_e( 'Delivered to one office or to every home address', 'plantgift-pro' ); ?></li>
					<li><?php esc_html_e( 'Free replacement if a plant arrives damaged', 'plantgift-pro' ); ?></li>
				</ul>

				<div class="pg-lp-hero__proof">
					<?php plantgift_pro_stars( 4.8 ); ?>
					<span><strong>4.8/5</strong> <?php esc_html_e( 'from 120+ corporate buyers', 'plantgift-pro' ); ?></span>
				</div>
			</div>

			<div class="pg-lp-hero__form">
				<?php echo do_shortcode( '[plantgift_quote_form]' ); ?>
			</div>

		</div>
	</section>

	<!-- Trusted by ------------------------------------------------------- -->
	<section class="pg-lp-logos" aria-labelledby="pg-lp-logos-title">
		<div class="pg-wrap">
			<p class="pg-lp-logos__label" id="pg-lp-logos-title">
				<?php esc_html_e( 'Gifting desks we look after', 'plantgift-pro' ); ?>
			</p>
			<div class="pg-logos">
				<?php
				// Replace these with real client logos before launch.
				$pg_logos = array( 'Northwind', 'Acme Tech', 'Blue Harbour', 'Sundara', 'Meridian', 'Kalpa Labs' );
				foreach ( $pg_logos as $pg_logo ) {
					printf( '<span>%s</span>', esc_html( $pg_logo ) );
				}
				?>
			</div>
		</div>
	</section>

	<!-- Why plants ------------------------------------------------------- -->
	<section class="pg-section" aria-labelledby="pg-lp-why">
		<div class="pg-wrap">
			<div class="pg-section-head pg-section-head--center">
				<p class="pg-eyebrow"><?php esc_html_e( 'Why plants', 'plantgift-pro' ); ?></p>
				<h2 id="pg-lp-why"><?php esc_html_e( 'The gift that is still on the desk six months later', 'plantgift-pro' ); ?></h2>
			</div>

			<div class="pg-grid pg-grid--4">
				<?php
				$pg_why = array(
					array( 'sprout', __( 'It keeps working', 'plantgift-pro' ), __( 'A mug goes in a cupboard and a hamper is finished in a week. A plant stays visible every working day.', 'plantgift-pro' ) ),
					array( 'recycle', __( 'It clears policy', 'plantgift-pro' ), __( 'Plastic free packaging and a living product, so it passes a sustainability review without an argument.', 'plantgift-pro' ) ),
					array( 'droplet', __( 'It survives neglect', 'plantgift-pro' ), __( 'We only ship species that tolerate air conditioning, weak light and a fortnight without water.', 'plantgift-pro' ) ),
					array( 'brush', __( 'It carries your brand', 'plantgift-pro' ), __( 'Fired decals, laser engraving and printed sleeves that will not peel after the third watering.', 'plantgift-pro' ) ),
				);
				foreach ( $pg_why as $pg_item ) :
					?>
					<article class="pg-icon-card">
						<div class="pg-icon-card__icon"><?php plantgift_pro_the_icon( $pg_item[0], 25 ); ?></div>
						<h3><?php echo esc_html( $pg_item[1] ); ?></h3>
						<p><?php echo esc_html( $pg_item[2] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>

			<?php
			$pg_content = trim( get_the_content() );
			if ( $pg_content ) :
				?>
				<div class="pg-entry pg-lp-prose"><?php the_content(); ?></div>
			<?php endif; ?>
		</div>
	</section>

	<!-- Gifting by occasion ---------------------------------------------- -->
	<section class="pg-section pg-section--cream" aria-labelledby="pg-lp-occasions">
		<div class="pg-wrap">
			<div class="pg-section-head pg-section-head--center">
				<p class="pg-eyebrow"><?php esc_html_e( 'Gifting solutions', 'plantgift-pro' ); ?></p>
				<h2 id="pg-lp-occasions"><?php esc_html_e( 'Built around the rounds companies actually run', 'plantgift-pro' ); ?></h2>
			</div>

			<div class="pg-grid pg-grid--3">
				<?php
				$pg_occasions = array(
					array( 'users', __( 'Employee onboarding', 'plantgift-pro' ), __( 'Desk ready kits that reach a new joiner on day one, dispatched monthly against your joiner list.', 'plantgift-pro' ), '/employee-onboarding-plant-gifts/' ),
					array( 'calendar', __( 'Work anniversaries', 'plantgift-pro' ), __( 'A tiered range that steps up in size and finish as the years do, with the year engraved on the pot.', 'plantgift-pro' ), '/plant-gifts/work-anniversary-plant-gifts/' ),
					array( 'building', __( 'Client appreciation', 'plantgift-pro' ), __( 'Bonsai and specimen plants in rigid boxes, with the branding kept quiet enough to read as a thank you.', 'plantgift-pro' ), '/client-gifting-programme/' ),
					array( 'star', __( 'Diwali and festive', 'plantgift-pro' ), __( 'Auspicious species in plastic free festive boxes. Book by August to choose rather than take what is left.', 'plantgift-pro' ), '/festival-corporate-plant-gifts/' ),
					array( 'gift', __( 'Events and conferences', 'plantgift-pro' ), __( 'Mini plants packed individually and counted in fifties, delivered to the venue on your schedule.', 'plantgift-pro' ), '/event-plant-giveaway-service/' ),
					array( 'sprout', __( 'Office greening', 'plantgift-pro' ), __( 'A subscription with scheduled care visits and free replacements, so nobody has to own the watering.', 'plantgift-pro' ), '/office-plant-subscription/' ),
				);
				foreach ( $pg_occasions as $pg_occ ) :
					?>
					<article class="pg-icon-card">
						<div class="pg-icon-card__icon"><?php plantgift_pro_the_icon( $pg_occ[0], 25 ); ?></div>
						<h3><a href="<?php echo esc_url( home_url( $pg_occ[3] ) ); ?>"><?php echo esc_html( $pg_occ[1] ); ?></a></h3>
						<p><?php echo esc_html( $pg_occ[2] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Curated picks ---------------------------------------------------- -->
	<?php if ( function_exists( 'wc_get_products' ) ) : ?>
		<?php
		$pg_picks = wc_get_products(
			array(
				'limit'    => 8,
				'status'   => 'publish',
				'orderby'  => 'menu_order',
				'category' => is_array( $pg_cats ) && $pg_cats ? $pg_cats : array(),
			)
		);
		?>
		<?php if ( $pg_picks ) : ?>
			<section class="pg-section" aria-labelledby="pg-lp-picks">
				<div class="pg-wrap">
					<div class="pg-section-head">
						<p class="pg-eyebrow"><?php esc_html_e( 'Curated picks', 'plantgift-pro' ); ?></p>
						<h2 id="pg-lp-picks"><?php esc_html_e( 'A starting shortlist, with pot options on every listing', 'plantgift-pro' ); ?></h2>
						<p class="pg-lede"><?php esc_html_e( 'Choose the pot size, material and design on the product page and the price updates as you go. Bulk slabs apply to your combined order.', 'plantgift-pro' ); ?></p>
					</div>

					<ul class="products columns-4">
						<?php
						global $post, $product;
						foreach ( $pg_picks as $pg_pick ) {
							$post    = get_post( $pg_pick->get_id() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
							$product = $pg_pick; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
							setup_postdata( $post );
							wc_get_template_part( 'content', 'product' );
						}
						wp_reset_postdata();
						?>
					</ul>

					<p class="pg-center pg-mt-2">
						<a class="pg-btn pg-btn--ghost pg-btn--lg" href="<?php echo esc_url( $pg_shop ); ?>">
							<?php esc_html_e( 'Browse the full catalogue', 'plantgift-pro' ); ?>
						</a>
					</p>
				</div>
			</section>
		<?php endif; ?>
	<?php endif; ?>

	<!-- Customisation ---------------------------------------------------- -->
	<section class="pg-section pg-section--dark" aria-labelledby="pg-lp-brand">
		<div class="pg-wrap">
			<div class="pg-split">
				<div>
					<p class="pg-eyebrow"><?php esc_html_e( 'Make it yours', 'plantgift-pro' ); ?></p>
					<h2 id="pg-lp-brand"><?php esc_html_e( 'Your mark on the pot, matched to the material', 'plantgift-pro' ); ?></h2>
					<p class="pg-lede"><?php esc_html_e( 'Branding fails when the method is chosen before the pot. We pick the pot the plant needs, then the method that material actually supports.', 'plantgift-pro' ); ?></p>
					<ul class="pg-check-list">
						<li><?php esc_html_e( 'Fired ceramic decals, sealed under the glaze so they never peel', 'plantgift-pro' ); ?></li>
						<li><?php esc_html_e( 'Laser engraving on metal and concrete for permanent fine detail', 'plantgift-pro' ); ?></li>
						<li><?php esc_html_e( 'Full colour printed sleeves when the artwork is complex', 'plantgift-pro' ); ?></li>
						<li><?php esc_html_e( 'Custom care cards and a QR code that opens your landing page', 'plantgift-pro' ); ?></li>
					</ul>
					<div class="pg-btn-row pg-mt-2">
						<a class="pg-btn pg-btn--action" href="#quote">
							<?php plantgift_pro_the_icon( 'brush', 18 ); ?>
							<?php esc_html_e( 'Get a branded mockup', 'plantgift-pro' ); ?>
						</a>
						<a class="pg-btn pg-btn--outline-light" href="<?php echo esc_url( home_url( '/custom-branded-planters/' ) ); ?>">
							<?php esc_html_e( 'How branding works', 'plantgift-pro' ); ?>
						</a>
					</div>
				</div>
				<div>
					<div class="pg-lp-brandgrid">
						<?php
						$pg_methods = array(
							array( __( 'Fired decal', 'plantgift-pro' ), __( 'Glazed ceramic', 'plantgift-pro' ), __( 'From 100 units', 'plantgift-pro' ) ),
							array( __( 'Laser engraving', 'plantgift-pro' ), __( 'Metal, concrete', 'plantgift-pro' ), __( 'From 50 units', 'plantgift-pro' ) ),
							array( __( 'Screen print', 'plantgift-pro' ), __( 'Terracotta', 'plantgift-pro' ), __( 'From 50 units', 'plantgift-pro' ) ),
							array( __( 'Printed sleeve', 'plantgift-pro' ), __( 'Any pot', 'plantgift-pro' ), __( 'From 50 units', 'plantgift-pro' ) ),
						);
						foreach ( $pg_methods as $pg_m ) :
							?>
							<div class="pg-lp-brandgrid__item">
								<strong><?php echo esc_html( $pg_m[0] ); ?></strong>
								<span><?php echo esc_html( $pg_m[1] ); ?></span>
								<em><?php echo esc_html( $pg_m[2] ); ?></em>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- How it works ----------------------------------------------------- -->
	<section class="pg-section" aria-labelledby="pg-lp-how">
		<div class="pg-wrap">
			<div class="pg-section-head pg-section-head--center">
				<p class="pg-eyebrow"><?php esc_html_e( 'How ordering works', 'plantgift-pro' ); ?></p>
				<h2 id="pg-lp-how"><?php esc_html_e( 'Four steps from brief to delivered desks', 'plantgift-pro' ); ?></h2>
			</div>
			<ol class="pg-steps">
				<li>
					<h3><?php esc_html_e( 'Share the brief', 'plantgift-pro' ); ?></h3>
					<p><?php esc_html_e( 'Headcount, budget per gift, delivery cities and the date it must land. Four numbers are enough.', 'plantgift-pro' ); ?></p>
				</li>
				<li>
					<h3><?php esc_html_e( 'Approve the mockup', 'plantgift-pro' ); ?></h3>
					<p><?php esc_html_e( 'A shortlist with real photos within one working day, and a branded pot mockup within two.', 'plantgift-pro' ); ?></p>
				</li>
				<li>
					<h3><?php esc_html_e( 'We pot and pack', 'plantgift-pro' ); ?></h3>
					<p><?php esc_html_e( 'Plants are hardened for a week, potted, inspected and packed in shock resistant cartons.', 'plantgift-pro' ); ?></p>
				</li>
				<li>
					<h3><?php esc_html_e( 'Delivered and tracked', 'plantgift-pro' ); ?></h3>
					<p><?php esc_html_e( 'One office drop in counted cartons, or individual shipments with a tracking link per recipient.', 'plantgift-pro' ); ?></p>
				</li>
			</ol>
		</div>
	</section>

	<!-- Bulk pricing ----------------------------------------------------- -->
	<section class="pg-section pg-section--mint" aria-labelledby="pg-lp-pricing">
		<div class="pg-wrap">
			<div class="pg-section-head">
				<p class="pg-eyebrow"><?php esc_html_e( 'Bulk pricing', 'plantgift-pro' ); ?></p>
				<h2 id="pg-lp-pricing"><?php esc_html_e( 'Five slabs, applied to your whole order', 'plantgift-pro' ); ?></h2>
				<p class="pg-lede"><?php esc_html_e( 'The slab applies to the combined quantity, not per product, so a mixed cart of succulents, air plants and hampers still qualifies.', 'plantgift-pro' ); ?></p>
			</div>
			<?php echo do_shortcode( '[plantgift_bulk_table]' ); ?>
			<div class="pg-callout pg-mt-2">
				<?php plantgift_pro_the_icon( 'clock', 20 ); ?>
				<p>
					<strong><?php esc_html_e( 'Festive rounds book out early.', 'plantgift-pro' ); ?></strong>
					<?php esc_html_e( 'Diwali orders briefed in August get the species and the delivery date you want. October briefs take what is left.', 'plantgift-pro' ); ?>
				</p>
			</div>
		</div>
	</section>

	<!-- Testimonials ----------------------------------------------------- -->
	<section class="pg-section" aria-labelledby="pg-lp-proof">
		<div class="pg-wrap">
			<div class="pg-section-head pg-section-head--center">
				<p class="pg-eyebrow"><?php esc_html_e( 'What buyers say', 'plantgift-pro' ); ?></p>
				<h2 id="pg-lp-proof"><?php esc_html_e( 'Rounds that landed the way they were meant to', 'plantgift-pro' ); ?></h2>
			</div>
			<div class="pg-grid pg-grid--3">
				<?php
				$pg_quotes = array(
					array(
						__( 'We sent 340 succulents across nine cities for Diwali. Two arrived damaged and both were replaced within the week without us chasing anyone.', 'plantgift-pro' ),
						__( 'People Operations Lead', 'plantgift-pro' ),
						__( 'IT services, 900 employees', 'plantgift-pro' ),
					),
					array(
						__( 'They talked us out of ferns for an air conditioned floor and put snake plants in instead. A year later almost all of them are still alive.', 'plantgift-pro' ),
						__( 'Workplace Manager', 'plantgift-pro' ),
						__( 'Financial services, Mumbai', 'plantgift-pro' ),
					),
					array(
						__( 'The welcome kits ship against our joiner list every month, so nobody on my team has to think about it. New starters mention it at the thirty day check in.', 'plantgift-pro' ),
						__( 'Head of Talent', 'plantgift-pro' ),
						__( 'SaaS company, hiring 20 a month', 'plantgift-pro' ),
					),
				);
				foreach ( $pg_quotes as $pg_q ) :
					?>
					<article class="pg-testimonial">
						<?php plantgift_pro_stars( 5 ); ?>
						<blockquote><?php echo esc_html( $pg_q[0] ); ?></blockquote>
						<div class="pg-testimonial__who">
							<strong><?php echo esc_html( $pg_q[1] ); ?></strong>
							<span><?php echo esc_html( $pg_q[2] ); ?></span>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<p class="pg-center pg-small pg-muted pg-mt-2">
				<?php esc_html_e( 'Replace these with your own client quotes before launch. Named people and companies convert considerably better.', 'plantgift-pro' ); ?>
			</p>
		</div>
	</section>

	<!-- FAQ -------------------------------------------------------------- -->
	<?php if ( is_array( $pg_faqs ) && $pg_faqs ) : ?>
		<section class="pg-section pg-section--cream" aria-labelledby="faqs">
			<div class="pg-wrap">
				<div class="pg-section-head">
					<p class="pg-eyebrow"><?php esc_html_e( 'Before you ask', 'plantgift-pro' ); ?></p>
					<?php
					plantgift_pro_faq_list( $pg_faqs, __( 'Frequently asked questions', 'plantgift-pro' ), 'h2' );
					if ( function_exists( 'plantgift_core_faq_schema' ) ) {
						plantgift_core_faq_schema( $pg_faqs );
					}
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Closing form ----------------------------------------------------- -->
	<section class="pg-section pg-section--tight">
		<div class="pg-wrap">
			<div class="pg-leadbox pg-lp-close">
				<div>
					<h2><?php esc_html_e( 'Ready when you are', 'plantgift-pro' ); ?></h2>
					<p><?php esc_html_e( 'Send the headcount and the budget. You will have a shortlist, a branded mockup and a landed cost in your inbox by the next working day, with no obligation attached.', 'plantgift-pro' ); ?></p>
					<?php $pg_phone = get_theme_mod( 'plantgift_phone', '' ); ?>
					<?php if ( $pg_phone ) : ?>
						<p class="pg-mt-1">
							<?php esc_html_e( 'Prefer to talk?', 'plantgift-pro' ); ?>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $pg_phone ) ); ?>"><?php echo esc_html( $pg_phone ); ?></a>
						</p>
					<?php endif; ?>
				</div>
				<div>
					<?php echo do_shortcode( '[plantgift_quote_form compact="yes" id="quote-bottom" title="" intro="" button="Send my brief"]' ); ?>
				</div>
			</div>
		</div>
	</section>

	<?php
endwhile;

get_footer();
