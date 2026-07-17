<?php
/**
 * Puja listing: promo banner, filter bar (deity, tithi, dosha,
 * benefit, location) and the upcoming online pujas grid.
 *
 * @package epoojabooking
 */

get_header();

$epb_pujas = get_posts( array(
	'post_type'      => 'epb_puja',
	'posts_per_page' => -1,
) );

$epb_filters = array(
	'epb_deity'    => __( 'Deity', 'epoojabooking' ),
	'epb_tithi'    => __( 'Tithi', 'epoojabooking' ),
	'epb_dosha'    => __( 'Dosha', 'epoojabooking' ),
	'epb_benefit'  => __( 'Benefits', 'epoojabooking' ),
	'epb_location' => __( 'Location', 'epoojabooking' ),
);
?>

<section class="epb-page-hero">
	<div class="epb-container">
		<?php epb_breadcrumbs(); ?>
		<h1><?php esc_html_e( 'Perform Puja with Vedic Rituals at Famous Hindu Temples in India', 'epoojabooking' ); ?></h1>
	</div>
	<div class="epb-arch-divider" aria-hidden="true"></div>
</section>

<div class="epb-container epb-promo-slot">
	<?php get_template_part( 'template-parts/banner-slider', null, array( 'compact' => true ) ); ?>
</div>

<section class="epb-section epb-puja-listing">
	<div class="epb-container">
		<h2 class="epb-listing-title"><?php esc_html_e( 'Upcoming Online Pujas', 'epoojabooking' ); ?></h2>
		<p class="epb-listing-sub"><?php esc_html_e( 'Book puja in your name and gotra, watch the ritual on video, and receive blessed prasad at your home.', 'epoojabooking' ); ?></p>

		<div class="epb-puja-filter" role="group" aria-label="<?php esc_attr_e( 'Filter pujas', 'epoojabooking' ); ?>">
			<span class="epb-filter-label">
				<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M4 6h16"/><path d="M7 12h10"/><path d="M10 18h4"/></svg>
				<?php esc_html_e( 'Filter', 'epoojabooking' ); ?>
			</span>
			<?php
			foreach ( $epb_filters as $epb_tax => $epb_label ) :
				if ( ! taxonomy_exists( $epb_tax ) ) {
					continue;
				}
				$epb_terms = get_terms( array(
					'taxonomy'   => $epb_tax,
					'hide_empty' => true,
				) );
				if ( is_wp_error( $epb_terms ) || ! $epb_terms ) {
					continue;
				}
				?>
				<label class="epb-filter-select">
					<span class="screen-reader-text"><?php echo esc_html( $epb_label ); ?></span>
					<select data-filter="<?php echo esc_attr( $epb_tax ); ?>">
						<option value=""><?php echo esc_html( $epb_label ); ?></option>
						<?php foreach ( $epb_terms as $epb_term ) : ?>
							<option value="<?php echo esc_attr( $epb_term->slug ); ?>"><?php echo esc_html( $epb_term->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			<?php endforeach; ?>
			<button type="button" class="epb-filter-clear" hidden><?php esc_html_e( 'Clear all', 'epoojabooking' ); ?></button>
		</div>

		<?php if ( $epb_pujas ) : ?>
			<div class="epb-card-grid epb-grid-3 epb-puja-grid">
				<?php
				foreach ( $epb_pujas as $epb_sp ) :
					$epb_badge  = get_post_meta( $epb_sp->ID, 'epb_badge', true );
					$epb_temple = get_post_meta( $epb_sp->ID, 'epb_temple_name', true );
					$epb_date   = get_post_meta( $epb_sp->ID, 'epb_event_date', true );
					$epb_link   = get_permalink( $epb_sp );

					// Term slugs as data attributes for client-side filtering.
					$epb_data = '';
					foreach ( array_keys( $epb_filters ) as $epb_tax ) {
						$epb_post_terms = get_the_terms( $epb_sp->ID, $epb_tax );
						$epb_slugs      = ( $epb_post_terms && ! is_wp_error( $epb_post_terms ) ) ? wp_list_pluck( $epb_post_terms, 'slug' ) : array();
						$epb_data      .= ' data-' . str_replace( '_', '-', $epb_tax ) . '="' . esc_attr( implode( ' ', $epb_slugs ) ) . '"';
					}
					?>
					<article class="epb-card epb-puja-card"<?php echo $epb_data; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<a href="<?php echo esc_url( $epb_link ); ?>" class="epb-card-thumb" tabindex="-1" aria-hidden="true">
							<?php if ( has_post_thumbnail( $epb_sp ) ) : ?>
								<?php echo get_the_post_thumbnail( $epb_sp, 'medium_large', array( 'loading' => 'lazy', 'alt' => esc_attr( get_the_title( $epb_sp ) ) ) ); ?>
							<?php else : ?>
								<span class="epb-thumb-placeholder" aria-hidden="true">
									<svg viewBox="0 0 24 24" width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M12 3c-2.5 3-5 5.5-5 8.5a5 5 0 0 0 10 0C17 8.5 14.5 6 12 3Z"/><path d="M12 13a2.5 2.5 0 0 0-2.5 2.5A2.5 2.5 0 0 0 12 18a2.5 2.5 0 0 0 2.5-2.5A2.5 2.5 0 0 0 12 13Z"/></svg>
								</span>
							<?php endif; ?>
						</a>
						<?php if ( $epb_badge ) : ?>
							<span class="epb-badge"><?php echo esc_html( $epb_badge ); ?></span>
						<?php endif; ?>
						<h3 class="epb-card-title"><a href="<?php echo esc_url( $epb_link ); ?>"><?php echo esc_html( get_the_title( $epb_sp ) ); ?></a></h3>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $epb_sp ), 22 ) ); ?></p>
						<ul class="epb-puja-meta">
							<?php if ( $epb_temple ) : ?>
								<li><?php epb_the_icon( 'bell' ); ?> <span><?php echo esc_html( $epb_temple ); ?></span></li>
							<?php endif; ?>
							<?php if ( $epb_date ) : ?>
								<li><?php epb_the_icon( 'calendar' ); ?> <span><?php echo esc_html( $epb_date ); ?></span></li>
							<?php endif; ?>
						</ul>
						<a class="epb-btn epb-btn-primary epb-participate" href="<?php echo esc_url( $epb_link ); ?>"><?php esc_html_e( 'Participate', 'epoojabooking' ); ?> →</a>
					</article>
				<?php endforeach; ?>
			</div>
			<p class="epb-filter-empty" hidden><?php esc_html_e( 'No pujas match the selected filters yet. Clear a filter or explore all pujas.', 'epoojabooking' ); ?></p>
		<?php else : ?>
			<p><?php esc_html_e( 'Pujas will appear here soon. Activate the ePoojaBooking Core plugin to load sample pujas.', 'epoojabooking' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="epb-section epb-cta-band">
	<div class="epb-container epb-cta-inner">
		<h2><?php esc_html_e( 'Not Sure Which Puja Is Right for You?', 'epoojabooking' ); ?></h2>
		<p><?php esc_html_e( 'Tell us your intention, health, career, marriage or peace at home, and our team will suggest the right puja and an auspicious date.', 'epoojabooking' ); ?></p>
		<a class="epb-btn epb-btn-light" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Ask Our Team', 'epoojabooking' ); ?></a>
	</div>
</section>

<?php
get_footer();
