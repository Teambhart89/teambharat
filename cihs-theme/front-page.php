<?php
/**
 * Front page: hero slider, mission, focus areas, publications,
 * analysis, events, stats, newsletter CTA.
 *
 * @package CIHS
 */

get_header();
?>

<main id="primary" class="site-main">

	<!-- Hero slider -->
	<section class="cihs-hero" aria-label="<?php esc_attr_e( 'Highlights', 'cihs' ); ?>">
		<div class="cihs-hero__slides">
			<?php foreach ( cihs_get_hero_slides() as $i => $slide ) : ?>
				<div class="cihs-hero__slide<?php echo 0 === $i ? ' is-active' : ''; ?>">
					<div class="cihs-container">
						<div class="cihs-hero__inner">
							<?php if ( $slide['kicker'] ) : ?>
								<span class="cihs-hero__kicker"><?php echo esc_html( $slide['kicker'] ); ?></span>
							<?php endif; ?>
							<p class="cihs-hero__title"><?php echo esc_html( $slide['title'] ); ?></p>
							<p><?php echo esc_html( $slide['text'] ); ?></p>
							<div class="cihs-hero__actions">
								<?php if ( $slide['button_label'] && $slide['button_url'] ) : ?>
									<a class="cihs-btn" href="<?php echo esc_url( $slide['button_url'] ); ?>"><?php echo esc_html( $slide['button_label'] ); ?></a>
								<?php endif; ?>
								<a class="cihs-btn cihs-btn--ghost" href="<?php echo esc_url( home_url( '/about-cihs/' ) ); ?>"><?php esc_html_e( 'About CIHS', 'cihs' ); ?></a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="cihs-hero__dots" role="tablist" aria-label="<?php esc_attr_e( 'Choose slide', 'cihs' ); ?>"></div>
	</section>

	<!-- Mission strip -->
	<section class="cihs-section">
		<div class="cihs-container">
			<div class="cihs-section-head cihs-reveal">
				<span class="cihs-eyebrow"><?php esc_html_e( 'Who We Are', 'cihs' ); ?></span>
				<h2><?php esc_html_e( 'Research that Connects Civilisational Wisdom with Contemporary Policy', 'cihs' ); ?></h2>
				<p><?php esc_html_e( 'Since 2021, CIHS has produced impactful research and fostered intellectual discourse that influences policy-making and guides public understanding — always independent, always non-partisan.', 'cihs' ); ?></p>
				<a class="cihs-btn cihs-btn--ghost" href="<?php echo esc_url( home_url( '/about-cihs/' ) ); ?>"><?php esc_html_e( 'Learn More About Us', 'cihs' ); ?></a>
			</div>
		</div>
	</section>

	<!-- Focus areas -->
	<section class="cihs-section cihs-section--tint">
		<div class="cihs-container">
			<div class="cihs-section-head cihs-reveal">
				<span class="cihs-eyebrow"><?php esc_html_e( 'Focus Areas', 'cihs' ); ?></span>
				<h2><?php esc_html_e( 'What We Study', 'cihs' ); ?></h2>
			</div>
			<div class="cihs-grid cihs-grid--3">
				<?php
				$cihs_areas = array(
					array( '🛡️', __( 'Geopolitics & National Security', 'cihs' ), __( 'Strategic analysis of regional and global flashpoints, terrorism and Bharat\'s long-term security posture.', 'cihs' ), 'geopolitics-security' ),
					array( '🏛️', __( 'Policy & Governance', 'cihs' ), __( 'Evidence-based evaluation of public policy, institutions and reforms for equitable outcomes.', 'cihs' ), 'policy-governance' ),
					array( '⚙️', __( 'Economy & Technology', 'cihs' ), __( 'Aatmanirbhar Bharat, AI, energy security and the road to indigenous technological leadership.', 'cihs' ), 'economy-technology' ),
					array( '🛕', __( 'Culture & Civilisation', 'cihs' ), __( 'Documenting and interpreting Bharat\'s living heritage and its relevance to modern life.', 'cihs' ), 'culture-civilisation' ),
					array( '🌏', __( 'Diaspora & Global Engagement', 'cihs' ), __( 'The Indian diaspora as a bridge between democracies — in diplomacy, technology and culture.', 'cihs' ), 'diaspora-global' ),
					array( '📚', __( 'All Research', 'cihs' ), __( 'Browse the complete library of CIHS research papers, reports and issue briefs.', 'cihs' ), '' ),
				);
				foreach ( $cihs_areas as $cihs_area ) :
					$cihs_url = $cihs_area[3] ? home_url( '/research/' . $cihs_area[3] . '/' ) : home_url( '/publications/' );
					?>
					<div class="cihs-focus-tile cihs-reveal">
						<div class="cihs-focus-tile__icon" aria-hidden="true"><?php echo esc_html( $cihs_area[0] ); ?></div>
						<h3><?php echo esc_html( $cihs_area[1] ); ?></h3>
						<p><?php echo esc_html( $cihs_area[2] ); ?></p>
						<a class="cihs-card__more" href="<?php echo esc_url( $cihs_url ); ?>"><?php esc_html_e( 'Explore →', 'cihs' ); ?></a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Latest publications -->
	<section class="cihs-section">
		<div class="cihs-container">
			<div class="cihs-section-head cihs-reveal">
				<span class="cihs-eyebrow"><?php esc_html_e( 'Publications', 'cihs' ); ?></span>
				<h2><?php esc_html_e( 'Latest Research', 'cihs' ); ?></h2>
			</div>
			<div class="cihs-grid cihs-grid--3">
				<?php
				$cihs_pubs = new WP_Query(
					array(
						'post_type'      => 'cihs_publication',
						'posts_per_page' => 3,
						'no_found_rows'  => true,
					)
				);
				if ( $cihs_pubs->have_posts() ) {
					while ( $cihs_pubs->have_posts() ) {
						$cihs_pubs->the_post();
						cihs_render_card();
					}
					wp_reset_postdata();
				} else {
					echo '<p>' . esc_html__( 'Publications will appear here once added from the dashboard.', 'cihs' ) . '</p>';
				}
				?>
			</div>
			<p style="text-align:center;margin-top:36px;"><a class="cihs-btn" href="<?php echo esc_url( home_url( '/publications/' ) ); ?>"><?php esc_html_e( 'View All Publications', 'cihs' ); ?></a></p>
		</div>
	</section>

	<!-- Stats band -->
	<section class="cihs-section cihs-section--navy">
		<div class="cihs-container">
			<div class="cihs-stats">
				<div class="cihs-stat cihs-reveal"><div class="cihs-stat__num" data-count="2021"><?php echo esc_html( '2021' ); ?></div><div class="cihs-stat__label"><?php esc_html_e( 'Founded', 'cihs' ); ?></div></div>
				<div class="cihs-stat cihs-reveal"><div class="cihs-stat__num" data-count="150">150+</div><div class="cihs-stat__label"><?php esc_html_e( 'Publications & Briefs', 'cihs' ); ?></div></div>
				<div class="cihs-stat cihs-reveal"><div class="cihs-stat__num" data-count="60">60+</div><div class="cihs-stat__label"><?php esc_html_e( 'Events & Lectures', 'cihs' ); ?></div></div>
				<div class="cihs-stat cihs-reveal"><div class="cihs-stat__num" data-count="5">5</div><div class="cihs-stat__label"><?php esc_html_e( 'Focus Areas', 'cihs' ); ?></div></div>
			</div>
		</div>
	</section>

	<!-- Analysis + events -->
	<section class="cihs-section cihs-section--tint">
		<div class="cihs-container">
			<div class="cihs-grid cihs-grid--2">
				<div>
					<span class="cihs-eyebrow"><?php esc_html_e( 'Analysis', 'cihs' ); ?></span>
					<h2><?php esc_html_e( 'Latest Commentary', 'cihs' ); ?></h2>
					<?php
					$cihs_posts = new WP_Query(
						array(
							'post_type'      => 'post',
							'posts_per_page' => 3,
							'no_found_rows'  => true,
						)
					);
					if ( $cihs_posts->have_posts() ) {
						echo '<div class="cihs-grid" style="gap:18px;">';
						while ( $cihs_posts->have_posts() ) {
							$cihs_posts->the_post();
							?>
							<article class="cihs-event-row cihs-reveal" style="grid-template-columns: 1fr auto;">
								<div>
									<div class="cihs-card__meta"><?php echo esc_html( get_the_date() ); ?></div>
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<p class="cihs-event-loc"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
								</div>
								<a class="cihs-btn cihs-btn--ghost" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read', 'cihs' ); ?></a>
							</article>
							<?php
						}
						echo '</div>';
						wp_reset_postdata();
					}
					?>
				</div>
				<div>
					<span class="cihs-eyebrow"><?php esc_html_e( 'Events', 'cihs' ); ?></span>
					<h2><?php esc_html_e( 'Lectures & Seminars', 'cihs' ); ?></h2>
					<?php
					$cihs_events = new WP_Query(
						array(
							'post_type'      => 'cihs_event',
							'posts_per_page' => 3,
							'meta_key'       => '_cihs_event_date',
							'orderby'        => 'meta_value',
							'order'          => 'DESC',
							'no_found_rows'  => true,
						)
					);
					if ( $cihs_events->have_posts() ) {
						while ( $cihs_events->have_posts() ) {
							$cihs_events->the_post();
							cihs_render_event_row();
						}
						wp_reset_postdata();
					}
					?>
					<p><a class="cihs-btn cihs-btn--ghost" href="<?php echo esc_url( home_url( '/events/' ) ); ?>"><?php esc_html_e( 'All Events', 'cihs' ); ?></a></p>
				</div>
			</div>
		</div>
	</section>

	<!-- Newsletter -->
	<section class="cihs-section cihs-section--navy" style="text-align:center;">
		<div class="cihs-container">
			<span class="cihs-eyebrow"><?php esc_html_e( 'Stay Informed', 'cihs' ); ?></span>
			<h2><?php esc_html_e( 'Get CIHS Research in Your Inbox', 'cihs' ); ?></h2>
			<p><?php esc_html_e( 'Monthly digest of new publications, upcoming events and featured commentary.', 'cihs' ); ?></p>
			<form class="cihs-newsletter-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="cihs_contact_submit">
				<?php wp_nonce_field( 'cihs_contact_form', 'cihs_contact_nonce' ); ?>
				<input type="hidden" name="cihs_name" value="Newsletter Subscriber">
				<input type="hidden" name="cihs_subject" value="Newsletter Signup">
				<input type="hidden" name="cihs_message" value="Please add this address to the CIHS newsletter list.">
				<label class="screen-reader-text" for="cihs_newsletter_email"><?php esc_html_e( 'Email address', 'cihs' ); ?></label>
				<input type="email" id="cihs_newsletter_email" name="cihs_email" placeholder="<?php esc_attr_e( 'you@example.com', 'cihs' ); ?>" required>
				<button type="submit" class="cihs-btn"><?php esc_html_e( 'Subscribe', 'cihs' ); ?></button>
			</form>
		</div>
	</section>

	<!-- CTA -->
	<section class="cihs-section">
		<div class="cihs-container">
			<div class="cihs-cta cihs-reveal">
				<div>
					<h2><?php esc_html_e( 'Partner with CIHS', 'cihs' ); ?></h2>
					<p><?php esc_html_e( 'Collaborate with our scholars on research, events and policy dialogue.', 'cihs' ); ?></p>
				</div>
				<a class="cihs-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Get in Touch', 'cihs' ); ?></a>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
