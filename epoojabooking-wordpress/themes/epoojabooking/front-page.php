<?php
/**
 * Front page: temple-inspired landing for epoojabooking.com.
 *
 * @package epoojabooking
 */

get_header();

$epb_banners = post_type_exists( 'epb_banner' ) ? get_posts( array(
	'post_type'      => 'epb_banner',
	'posts_per_page' => 5,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) ) : array();
?>

<?php if ( $epb_banners ) : ?>
<h1 class="screen-reader-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?>: <?php esc_html_e( 'Online Puja Booking, Chadhava and Astrology Services', 'epoojabooking' ); ?></h1>
<?php get_template_part( 'template-parts/banner-slider' ); ?>

<div class="epb-trust-strip">
	<div class="epb-container epb-trust-strip-inner">
		<span><?php epb_the_icon( 'star' ); ?> <?php esc_html_e( 'Trusted temples and verified pandits', 'epoojabooking' ); ?></span>
		<span><?php epb_the_icon( 'shield' ); ?> <?php esc_html_e( '100% secure payments', 'epoojabooking' ); ?></span>
		<span><?php epb_the_icon( 'lotus' ); ?> <?php esc_html_e( 'Serving devotees in India and 15+ countries', 'epoojabooking' ); ?></span>
	</div>
</div>
<?php endif; ?>

<section class="epb-hero<?php echo $epb_banners ? ' epb-hero-secondary' : ''; ?>"
	<div class="epb-hero-glow" aria-hidden="true"></div>
	<div class="epb-container epb-hero-inner">
		<p class="epb-eyebrow"><?php esc_html_e( 'Trusted temples across India', 'epoojabooking' ); ?></p>
		<?php $epb_hero_tag = $epb_banners ? 'h2' : 'h1'; ?>
		<<?php echo esc_html( $epb_hero_tag ); ?>><?php esc_html_e( 'Book Online Puja, Chadhava and Temple Offerings from Anywhere in the World', 'epoojabooking' ); ?></<?php echo esc_html( $epb_hero_tag ); ?>>
		<p class="epb-hero-sub"><?php esc_html_e( 'epoojabooking connects you with verified temples and experienced pandits for online puja booking, chadhava offerings, abhishek, havan and astrology consultations. Your puja is performed in your name with full sankalp, and prasad reaches your doorstep in India or abroad.', 'epoojabooking' ); ?></p>
		<div class="epb-hero-actions">
			<a class="epb-btn epb-btn-primary" href="<?php echo esc_url( home_url( '/online-puja-booking/' ) ); ?>"><?php esc_html_e( 'Book a Puja', 'epoojabooking' ); ?></a>
			<a class="epb-btn epb-btn-ghost" href="<?php echo esc_url( home_url( '/online-chadhava-offering/' ) ); ?>"><?php esc_html_e( 'Offer Chadhava', 'epoojabooking' ); ?></a>
		</div>
		<ul class="epb-hero-trust" aria-label="<?php esc_attr_e( 'Why devotees trust us', 'epoojabooking' ); ?>">
			<li><?php esc_html_e( 'Video proof of every puja', 'epoojabooking' ); ?></li>
			<li><?php esc_html_e( 'Prasad delivery worldwide', 'epoojabooking' ); ?></li>
			<li><?php esc_html_e( 'Secure UPI and card payments', 'epoojabooking' ); ?></li>
		</ul>
	</div>
	<div class="epb-arch-divider" aria-hidden="true"></div>
</section>

<section class="epb-section epb-services">
	<div class="epb-container">
		<h2 class="epb-section-title"><?php esc_html_e( 'Spiritual Services for Every Devotee', 'epoojabooking' ); ?></h2>
		<p class="epb-section-sub"><?php esc_html_e( 'Choose a seva and we take care of everything, from sankalp to prasad delivery.', 'epoojabooking' ); ?></p>

		<div class="epb-card-grid">
			<?php
			$epb_services = array(
				array(
					'title' => __( 'Online Puja Booking', 'epoojabooking' ),
					'desc'  => __( 'Book pujas at famous temples for health, wealth, career and family wellbeing. Performed in your name with full Vedic rituals.', 'epoojabooking' ),
					'url'   => home_url( '/online-puja-booking/' ),
					'icon'  => 'flame',
				),
				array(
					'title' => __( 'Chadhava and Offerings', 'epoojabooking' ),
					'desc'  => __( 'Offer flowers, vastra, sweets and dakshina at the temple of your choice. We make the offering in your name on your chosen day.', 'epoojabooking' ),
					'url'   => home_url( '/online-chadhava-offering/' ),
					'icon'  => 'lotus',
				),
				array(
					'title' => __( 'Astrology Consultation', 'epoojabooking' ),
					'desc'  => __( 'Talk to experienced Vedic astrologers for kundli analysis, horoscope reading, numerology and practical remedies.', 'epoojabooking' ),
					'url'   => home_url( '/online-astrology-consultation/' ),
					'icon'  => 'star',
				),
				array(
					'title' => __( 'Abhishek Booking', 'epoojabooking' ),
					'desc'  => __( 'Book Rudrabhishek, dudh abhishek and other sacred abhishek rituals performed by learned pandits at Jyotirlinga and Shiva temples.', 'epoojabooking' ),
					'url'   => home_url( '/online-abhishek-booking/' ),
					'icon'  => 'kalash',
				),
				array(
					'title' => __( 'Havan Booking', 'epoojabooking' ),
					'desc'  => __( 'Organise Ganesh havan, Navagraha havan and Mahamrityunjaya havan for peace, prosperity and removal of obstacles.', 'epoojabooking' ),
					'url'   => home_url( '/online-havan-booking/' ),
					'icon'  => 'fire',
				),
				array(
					'title' => __( 'Book Pandit Ji Online', 'epoojabooking' ),
					'desc'  => __( 'Verified pandits for griha pravesh, satyanarayan katha, wedding ceremonies and all sanskars, at home or online.', 'epoojabooking' ),
					'url'   => home_url( '/book-pandit-online/' ),
					'icon'  => 'bell',
				),
			);

			foreach ( $epb_services as $service ) :
				?>
				<article class="epb-card">
					<div class="epb-card-icon" aria-hidden="true">
						<?php epb_the_icon( $service['icon'] ); ?>
					</div>
					<h3><a href="<?php echo esc_url( $service['url'] ); ?>"><?php echo esc_html( $service['title'] ); ?></a></h3>
					<p><?php echo esc_html( $service['desc'] ); ?></p>
					<span class="epb-card-link" aria-hidden="true"><?php esc_html_e( 'Explore seva', 'epoojabooking' ); ?> →</span>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
$epb_special_pujas = post_type_exists( 'epb_puja' ) ? get_posts( array(
	'post_type'      => 'epb_puja',
	'posts_per_page' => 3,
) ) : array();

if ( $epb_special_pujas ) :
	?>
<section class="epb-section epb-special-pujas">
	<div class="epb-container">
		<h2 class="epb-section-title"><?php esc_html_e( 'Special Pujas', 'epoojabooking' ); ?></h2>
		<p class="epb-section-sub"><?php esc_html_e( 'Participate in powerful pujas performed on auspicious dates at revered temples, in your name and for your family.', 'epoojabooking' ); ?></p>

		<div class="epb-card-grid epb-grid-3">
			<?php
			foreach ( $epb_special_pujas as $epb_sp ) :
				$epb_badge  = get_post_meta( $epb_sp->ID, 'epb_badge', true );
				$epb_temple = get_post_meta( $epb_sp->ID, 'epb_temple_name', true );
				$epb_date   = get_post_meta( $epb_sp->ID, 'epb_event_date', true );
				$epb_link   = get_permalink( $epb_sp );
				?>
				<article class="epb-card epb-puja-card">
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
	</div>
</section>
<?php endif; ?>

<section class="epb-section epb-how epb-section-cream">
	<div class="epb-container">
		<h2 class="epb-section-title"><?php esc_html_e( 'How Online Puja Booking Works', 'epoojabooking' ); ?></h2>
		<ol class="epb-steps">
			<li>
				<h3><?php esc_html_e( 'Choose your puja or seva', 'epoojabooking' ); ?></h3>
				<p><?php esc_html_e( 'Select from pujas, chadhava, abhishek, havan or astrology services at trusted temples.', 'epoojabooking' ); ?></p>
			</li>
			<li>
				<h3><?php esc_html_e( 'Share your sankalp details', 'epoojabooking' ); ?></h3>
				<p><?php esc_html_e( 'Tell us your name, gotra, nakshatra and prayer intention along with your preferred date.', 'epoojabooking' ); ?></p>
			</li>
			<li>
				<h3><?php esc_html_e( 'Pandit performs your puja', 'epoojabooking' ); ?></h3>
				<p><?php esc_html_e( 'Experienced pandits perform the ritual at the temple. Watch live or receive the recorded video.', 'epoojabooking' ); ?></p>
			</li>
			<li>
				<h3><?php esc_html_e( 'Receive prasad at home', 'epoojabooking' ); ?></h3>
				<p><?php esc_html_e( 'Blessed prasad is packed with care and delivered to your address in India or overseas.', 'epoojabooking' ); ?></p>
			</li>
		</ol>
	</div>
</section>

<section class="epb-section epb-testimonials">
	<div class="epb-container">
		<h2 class="epb-section-title"><?php esc_html_e( 'Devotees Who Trusted Us', 'epoojabooking' ); ?></h2>
		<div class="epb-card-grid epb-grid-3">
			<blockquote class="epb-quote">
				<p><?php esc_html_e( 'I booked a Rudrabhishek for my father from Toronto. The video of the puja brought tears to our eyes and the prasad arrived within a week. Truly grateful.', 'epoojabooking' ); ?></p>
				<footer><cite>Anjali S.</cite> · <?php esc_html_e( 'Canada', 'epoojabooking' ); ?></footer>
			</blockquote>
			<blockquote class="epb-quote">
				<p><?php esc_html_e( 'The chadhava was offered exactly on the date I chose and they shared photos from the temple. Booking took me less than five minutes on my phone.', 'epoojabooking' ); ?></p>
				<footer><cite>Rahul M.</cite> · <?php esc_html_e( 'Mumbai', 'epoojabooking' ); ?></footer>
			</blockquote>
			<blockquote class="epb-quote">
				<p><?php esc_html_e( 'My astrology consultation was detailed and practical. The astrologer explained my kundli patiently and suggested simple remedies.', 'epoojabooking' ); ?></p>
				<footer><cite>Priya K.</cite> · <?php esc_html_e( 'London, UK', 'epoojabooking' ); ?></footer>
			</blockquote>
		</div>
	</div>
</section>

<section class="epb-section epb-cta-band">
	<div class="epb-container epb-cta-inner">
		<h2><?php esc_html_e( 'Begin Your Spiritual Journey Today', 'epoojabooking' ); ?></h2>
		<p><?php esc_html_e( 'Book a puja, offer chadhava or consult an astrologer. Fast, reliable and trusted by devotees worldwide.', 'epoojabooking' ); ?></p>
		<a class="epb-btn epb-btn-light" href="<?php echo esc_url( home_url( '/online-puja-booking/' ) ); ?>"><?php esc_html_e( 'Book Your Puja Now', 'epoojabooking' ); ?></a>
	</div>
</section>

<?php
get_footer();
