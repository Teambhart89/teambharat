<?php
/**
 * Reusable template helpers for the CIHS theme.
 *
 * @package CIHS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post date + author line.
 */
function cihs_entry_meta() {
	printf(
		'<div class="entry-meta"><span class="posted-on">%1$s</span> &middot; <span class="byline">%2$s</span></div>',
		esc_html( get_the_date() ),
		esc_html( get_the_author() )
	);
}

/**
 * Card used across archives (posts + publications).
 *
 * @param int|WP_Post|null $post Post object or ID.
 */
function cihs_render_card( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return;
	}
	$meta = get_the_date( '', $post );
	if ( 'cihs_publication' === $post->post_type ) {
		$types = get_the_terms( $post, 'cihs_publication_type' );
		if ( $types && ! is_wp_error( $types ) ) {
			$meta = $types[0]->name . ' &middot; ' . $meta;
		}
	} elseif ( 'post' === $post->post_type ) {
		$cats = get_the_category( $post->ID );
		if ( $cats ) {
			$meta = $cats[0]->name . ' &middot; ' . $meta;
		}
	}
	?>
	<article class="cihs-card cihs-reveal">
		<a class="cihs-card__media <?php echo has_post_thumbnail( $post ) ? '' : 'cihs-card__media--initial'; ?>" href="<?php echo esc_url( get_permalink( $post ) ); ?>" aria-hidden="true" tabindex="-1">
			<?php
			if ( has_post_thumbnail( $post ) ) {
				echo get_the_post_thumbnail( $post, 'cihs-card' );
			} else {
				echo esc_html( mb_substr( get_the_title( $post ), 0, 1 ) );
			}
			?>
		</a>
		<div class="cihs-card__body">
			<div class="cihs-card__meta"><?php echo wp_kses_post( $meta ); ?></div>
			<h3><a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a></h3>
			<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $post ), 22 ) ); ?></p>
			<a class="cihs-card__more" href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php esc_html_e( 'Read more →', 'cihs' ); ?></a>
		</div>
	</article>
	<?php
}

/**
 * Event row with date badge.
 *
 * @param int|WP_Post|null $post Event post.
 */
function cihs_render_event_row( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return;
	}
	$date  = get_post_meta( $post->ID, '_cihs_event_date', true );
	$time  = get_post_meta( $post->ID, '_cihs_event_time', true );
	$venue = get_post_meta( $post->ID, '_cihs_event_venue', true );
	$ts    = $date ? strtotime( $date ) : false;
	?>
	<div class="cihs-event-row cihs-reveal">
		<div class="cihs-event-date" aria-hidden="true">
			<b><?php echo esc_html( $ts ? date_i18n( 'd', $ts ) : '—' ); ?></b>
			<span><?php echo esc_html( $ts ? date_i18n( 'M Y', $ts ) : __( 'TBA', 'cihs' ) ); ?></span>
		</div>
		<div>
			<h3><a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a></h3>
			<p class="cihs-event-loc">
				<?php
				$bits = array_filter( array( $time, $venue ) );
				echo esc_html( $bits ? implode( ' · ', $bits ) : wp_trim_words( get_the_excerpt( $post ), 16 ) );
				?>
			</p>
		</div>
		<a class="cihs-btn cihs-btn--ghost" href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php esc_html_e( 'Details', 'cihs' ); ?></a>
	</div>
	<?php
}

/**
 * Event card with thumbnail image and date ribbon (homepage / archive grid).
 *
 * @param int|WP_Post|null $post Event post.
 */
function cihs_render_event_card( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return;
	}
	$date  = get_post_meta( $post->ID, '_cihs_event_date', true );
	$venue = get_post_meta( $post->ID, '_cihs_event_venue', true );
	$ts    = $date ? strtotime( $date ) : false;
	?>
	<article class="cihs-card cihs-event-card cihs-reveal">
		<a class="cihs-card__media <?php echo has_post_thumbnail( $post ) ? '' : 'cihs-card__media--initial'; ?>" href="<?php echo esc_url( get_permalink( $post ) ); ?>" aria-hidden="true" tabindex="-1">
			<?php
			if ( has_post_thumbnail( $post ) ) {
				echo get_the_post_thumbnail( $post, 'cihs-card' );
			} else {
				echo esc_html( mb_substr( get_the_title( $post ), 0, 1 ) );
			}
			?>
			<span class="cihs-event-ribbon">
				<b><?php echo esc_html( $ts ? date_i18n( 'd', $ts ) : '—' ); ?></b>
				<span><?php echo esc_html( $ts ? date_i18n( 'M', $ts ) : __( 'TBA', 'cihs' ) ); ?></span>
			</span>
		</a>
		<div class="cihs-card__body">
			<h3><a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a></h3>
			<?php if ( $venue ) : ?>
				<p class="cihs-event-venue"><strong><?php esc_html_e( 'Venue:', 'cihs' ); ?></strong> <?php echo esc_html( $venue ); ?></p>
			<?php endif; ?>
			<a class="cihs-btn cihs-event-card__btn" href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php esc_html_e( 'Event Details', 'cihs' ); ?></a>
		</div>
	</article>
	<?php
}

/**
 * Compact horizontal report card: thumbnail left, type + title right.
 *
 * @param int|WP_Post|null $post Publication post.
 */
function cihs_render_report_row( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return;
	}
	$type  = __( 'Publication', 'cihs' );
	$terms = get_the_terms( $post, 'cihs_publication_type' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		$type = $terms[0]->name;
	}
	?>
	<a class="cihs-report-row cihs-reveal" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
		<span class="cihs-report-row__thumb <?php echo has_post_thumbnail( $post ) ? '' : 'cihs-card__media--initial'; ?>">
			<?php
			if ( has_post_thumbnail( $post ) ) {
				echo get_the_post_thumbnail( $post, 'thumbnail' );
			} else {
				echo esc_html( mb_substr( get_the_title( $post ), 0, 1 ) );
			}
			?>
		</span>
		<span class="cihs-report-row__body">
			<span class="cihs-report-row__type"><?php echo esc_html( $type ); ?></span>
			<span class="cihs-report-row__title"><?php echo esc_html( get_the_title( $post ) ); ?></span>
		</span>
	</a>
	<?php
}

/**
 * Simple breadcrumbs for inner pages.
 */
function cihs_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	echo '<nav class="cihs-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'cihs' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'cihs' ) . '</a> &rsaquo; ';
	if ( is_singular( 'cihs_publication' ) ) {
		echo '<a href="' . esc_url( get_post_type_archive_link( 'cihs_publication' ) ) . '">' . esc_html__( 'Publications', 'cihs' ) . '</a> &rsaquo; ';
	} elseif ( is_singular( 'cihs_event' ) ) {
		echo '<a href="' . esc_url( get_post_type_archive_link( 'cihs_event' ) ) . '">' . esc_html__( 'Events', 'cihs' ) . '</a> &rsaquo; ';
	} elseif ( is_singular( 'cihs_career' ) ) {
		echo '<a href="' . esc_url( home_url( '/careers-internships/' ) ) . '">' . esc_html__( 'Careers', 'cihs' ) . '</a> &rsaquo; ';
	} elseif ( is_singular( 'post' ) ) {
		$blog = get_option( 'page_for_posts' );
		if ( $blog ) {
			echo '<a href="' . esc_url( get_permalink( $blog ) ) . '">' . esc_html( get_the_title( $blog ) ) . '</a> &rsaquo; ';
		}
	} elseif ( is_page() ) {
		$parent = wp_get_post_parent_id( get_the_ID() );
		if ( $parent ) {
			echo '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . esc_html( get_the_title( $parent ) ) . '</a> &rsaquo; ';
		}
	}
	echo '<span>' . esc_html( cihs_page_title() ) . '</span>';
	echo '</nav>';
}

/**
 * Current view title (used by page hero + breadcrumbs).
 *
 * @return string
 */
function cihs_page_title() {
	if ( is_search() ) {
		/* translators: %s: search query. */
		return sprintf( __( 'Search results for “%s”', 'cihs' ), get_search_query() );
	}
	if ( is_404() ) {
		return __( 'Page not found', 'cihs' );
	}
	if ( is_home() && ! is_front_page() ) {
		return get_the_title( (int) get_option( 'page_for_posts' ) );
	}
	if ( is_post_type_archive() ) {
		return post_type_archive_title( '', false );
	}
	if ( is_archive() ) {
		return get_the_archive_title();
	}
	return single_post_title( '', false );
}

/**
 * Social links list from Customizer settings.
 */
function cihs_social_links() {
	$networks = array(
		'twitter'  => array( get_theme_mod( 'cihs_social_twitter', 'https://x.com/cihs_india' ), 'X' ),
		'facebook' => array( get_theme_mod( 'cihs_social_facebook', 'https://www.facebook.com/CIHSofficial/' ), 'Fb' ),
		'youtube'  => array( get_theme_mod( 'cihs_social_youtube', 'https://www.youtube.com/@CIHS_India' ), 'Yt' ),
		'linkedin' => array( get_theme_mod( 'cihs_social_linkedin', 'https://in.linkedin.com/company/centre-for-integrated-and-holistic-studies' ), 'In' ),
	);
	foreach ( $networks as $slug => $data ) {
		if ( empty( $data[0] ) ) {
			continue;
		}
		printf(
			'<a href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s">%3$s</a>',
			esc_url( $data[0] ),
			esc_attr( ucfirst( $slug ) ),
			esc_html( $data[1] )
		);
	}
}
