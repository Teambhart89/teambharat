<?php
/**
 * Temple directory: filterable grid of temples, srimandir-style.
 *
 * @package epoojabooking
 */

get_header();

// Gather all temples once so we can build city filters and the grid.
$epb_temples = get_posts( array(
	'post_type'      => 'epb_temple',
	'posts_per_page' => -1,
	'orderby'        => 'title',
	'order'          => 'ASC',
) );

$epb_cities = array();
foreach ( $epb_temples as $epb_t ) {
	$city = get_post_meta( $epb_t->ID, 'epb_city', true );
	if ( $city ) {
		$epb_cities[ sanitize_title( $city ) ] = $city;
	}
}
ksort( $epb_cities );
?>

<section class="epb-page-hero epb-temple-hero">
	<div class="epb-container">
		<?php epb_breadcrumbs(); ?>
		<h1><?php esc_html_e( 'Divine Temples and Holy Pilgrimages of India', 'epoojabooking' ); ?></h1>
		<p class="epb-hero-sub"><?php esc_html_e( 'Discover the history, significance and darshan timings of India\'s most revered temples. Book pujas and offer chadhava at the temple your heart belongs to, from anywhere in the world.', 'epoojabooking' ); ?></p>
		<ul class="epb-hero-trust">
			<li><?php esc_html_e( 'Learn the history and traditions of each temple', 'epoojabooking' ); ?></li>
			<li><?php esc_html_e( 'Connect with the deities you worship', 'epoojabooking' ); ?></li>
			<li><?php esc_html_e( 'Book pujas and offerings at your favourite temples', 'epoojabooking' ); ?></li>
		</ul>
	</div>
	<div class="epb-arch-divider" aria-hidden="true"></div>
</section>

<section class="epb-section">
	<div class="epb-container">

		<?php if ( $epb_cities ) : ?>
			<div class="epb-city-filter" role="group" aria-label="<?php esc_attr_e( 'Filter temples by city', 'epoojabooking' ); ?>">
				<button type="button" class="epb-chip is-active" data-city="all" aria-pressed="true"><?php esc_html_e( 'All', 'epoojabooking' ); ?></button>
				<?php foreach ( $epb_cities as $slug => $label ) : ?>
					<button type="button" class="epb-chip" data-city="<?php echo esc_attr( $slug ); ?>" aria-pressed="false"><?php echo esc_html( $label ); ?></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $epb_temples ) : ?>
			<div class="epb-card-grid epb-grid-3 epb-temple-grid">
				<?php
				foreach ( $epb_temples as $epb_t ) :
					$city  = get_post_meta( $epb_t->ID, 'epb_city', true );
					$state = get_post_meta( $epb_t->ID, 'epb_state', true );
					$link  = get_permalink( $epb_t );
					?>
					<article class="epb-card epb-temple-card" data-city="<?php echo esc_attr( sanitize_title( $city ) ); ?>">
						<a href="<?php echo esc_url( $link ); ?>" class="epb-card-thumb" tabindex="-1" aria-hidden="true">
							<?php if ( has_post_thumbnail( $epb_t ) ) : ?>
								<?php echo get_the_post_thumbnail( $epb_t, 'medium_large', array( 'loading' => 'lazy', 'alt' => esc_attr( get_the_title( $epb_t ) ) ) ); ?>
							<?php else : ?>
								<span class="epb-thumb-placeholder" aria-hidden="true">
									<svg viewBox="0 0 24 24" width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M12 2l1 3h-2l1-3Z"/><path d="M12 5v3"/><path d="M6 11c0-2 2.5-3.5 6-3.5s6 1.5 6 3.5"/><path d="M5 11h14"/><path d="M6 11v9"/><path d="M18 11v9"/><path d="M10 20v-5a2 2 0 0 1 4 0v5"/><path d="M4 20h16"/></svg>
								</span>
							<?php endif; ?>
						</a>
						<h2 class="epb-card-title"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( get_the_title( $epb_t ) ); ?></a></h2>
						<p class="epb-temple-location"><?php echo esc_html( trim( $city . ', ' . $state, ', ' ) ); ?></p>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $epb_t ), 26 ) ); ?></p>
						<span class="epb-card-link" aria-hidden="true"><?php esc_html_e( 'Explore temple', 'epoojabooking' ); ?> →</span>
					</article>
				<?php endforeach; ?>
			</div>
			<p class="epb-filter-empty" hidden><?php esc_html_e( 'No temples found for this city yet. More temples are added regularly.', 'epoojabooking' ); ?></p>
		<?php else : ?>
			<p><?php esc_html_e( 'Temples will appear here soon. Activate the ePoojaBooking Core plugin to load the temple directory.', 'epoojabooking' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="epb-section epb-cta-band">
	<div class="epb-container epb-cta-inner">
		<h2><?php esc_html_e( 'Your Temple, Your Puja, From Anywhere', 'epoojabooking' ); ?></h2>
		<p><?php esc_html_e( 'Choose a temple and we arrange the puja or chadhava in your name, with video proof and prasad delivery worldwide.', 'epoojabooking' ); ?></p>
		<a class="epb-btn epb-btn-light" href="<?php echo esc_url( home_url( '/online-puja-booking/' ) ); ?>"><?php esc_html_e( 'Book a Puja', 'epoojabooking' ); ?></a>
	</div>
</section>

<?php
get_footer();
