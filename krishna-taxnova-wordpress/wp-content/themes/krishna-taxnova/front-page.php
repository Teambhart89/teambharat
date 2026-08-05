<?php
/**
 * Homepage: hero, trust strip, category grid, how it works, why us,
 * testimonials, FAQs (with schema from core plugin) and final CTA.
 *
 * @package krishna-taxnova
 */

get_header();

$home = get_option( 'ktn_home_data', array() );
$get  = function ( $key, $default = '' ) use ( $home ) {
	return isset( $home[ $key ] ) && '' !== $home[ $key ] ? $home[ $key ] : $default;
};
?>

<section class="ktn-hero">
	<div class="wrap ktn-hero-inner">
		<div class="ktn-hero-copy">
			<p class="ktn-hero-eyebrow"><?php echo esc_html( $get( 'eyebrow', 'CA firm in Delhi, serving all India' ) ); ?></p>
			<h1><?php echo esc_html( $get( 'h1', 'Online CA Services for Tax, GST, Trademark, MCA and Business Compliance' ) ); ?></h1>
			<p class="ktn-hero-sub"><?php echo esc_html( $get( 'sub', 'Eaccountingcart helps startups, businesses and professionals register, stay compliant and save tax. Fill your details online, upload your documents or WhatsApp them to us, and a qualified expert takes it from there.' ) ); ?></p>
			<ul class="ktn-hero-points">
				<li><?php esc_html_e( 'Upload documents online in minutes', 'krishna-taxnova' ); ?></li>
				<li><?php esc_html_e( 'WhatsApp support for every service', 'krishna-taxnova' ); ?></li>
				<li><?php esc_html_e( 'Transparent fixed pricing, no surprises', 'krishna-taxnova' ); ?></li>
			</ul>
			<div class="ktn-hero-cta">
				<a class="ktn-btn ktn-btn-primary" href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'Explore All Services', 'krishna-taxnova' ); ?></a>
				<?php echo ktn_whatsapp_button(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
			<div class="ktn-hero-image">
				<?php echo ktn_showcase_image( 'ktn_hero_img', 'large' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
		</div>
		<div class="ktn-hero-form">
			<?php echo do_shortcode( '[ktn_service_form title="Talk to a CA Today"]' ); ?>
		</div>
	</div>
</section>

<section class="ktn-trust">
	<div class="wrap ktn-trust-grid">
		<div><strong><?php echo esc_html( $get( 'stat1_num', '1500+' ) ); ?></strong><span><?php echo esc_html( $get( 'stat1_label', 'Clients Served' ) ); ?></span></div>
		<div><strong><?php echo esc_html( $get( 'stat2_num', '90+' ) ); ?></strong><span><?php echo esc_html( $get( 'stat2_label', 'Services Offered' ) ); ?></span></div>
		<div><strong><?php echo esc_html( $get( 'stat3_num', '10+' ) ); ?></strong><span><?php echo esc_html( $get( 'stat3_label', 'Years of Experience' ) ); ?></span></div>
		<div><strong><?php echo esc_html( $get( 'stat4_num', '4.8/5' ) ); ?></strong><span><?php echo esc_html( $get( 'stat4_label', 'Client Rating' ) ); ?></span></div>
	</div>
</section>

<section class="ktn-section ktn-showcase">
	<div class="wrap ktn-showcase-grid">
		<div class="ktn-showcase-copy">
			<span class="ktn-chip-label">&#8599; <?php esc_html_e( 'Professional Tax Guidance', 'krishna-taxnova' ); ?></span>
			<h2><?php echo esc_html( get_theme_mod( 'ktn_showcase_heading', 'Your Trusted Experts for Every Tax and Compliance Matter' ) ); ?></h2>
			<p><?php echo esc_html( get_theme_mod( 'ktn_showcase_text', 'We simplify complex tax and compliance rules into clear guidance and fixed price plans that fit your business. One qualified team, accountable end to end.' ) ); ?></p>
			<div class="ktn-showcase-cta">
				<a class="ktn-btn ktn-btn-primary" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Book a Consultation', 'krishna-taxnova' ); ?></a>
				<a class="ktn-btn ktn-btn-outline" href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'Learn More', 'krishna-taxnova' ); ?></a>
			</div>
		</div>
		<div class="ktn-showcase-media">
			<div class="ktn-showcase-img ktn-showcase-tall">
				<?php echo ktn_showcase_image( 'ktn_showcase_img1', 'large' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
			<div class="ktn-showcase-side">
				<div class="ktn-showcase-img ktn-showcase-small">
					<?php echo ktn_showcase_image( 'ktn_showcase_img2', 'medium_large' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</div>
				<div class="ktn-showcase-stat">
					<div class="ktn-showcase-stat-copy">
						<strong><?php echo esc_html( $get( 'stat1_num', '1500+' ) ); ?> <?php esc_html_e( 'Trusted Clients', 'krishna-taxnova' ); ?></strong>
						<span><?php esc_html_e( 'Startups, businesses and professionals across India.', 'krishna-taxnova' ); ?></span>
						<span class="ktn-showcase-avatars" aria-hidden="true"><i>RK</i><i>SP</i><i>AM</i><i class="ktn-av-plus">+</i></span>
					</div>
					<div class="ktn-showcase-chart" aria-hidden="true">
						<em><?php esc_html_e( 'Filings per month', 'krishna-taxnova' ); ?></em>
						<span style="--h:38%"></span><span style="--h:55%"></span><span style="--h:46%"></span><span style="--h:70%"></span><span style="--h:60%"></span><span style="--h:85%"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="ktn-section">
	<div class="wrap">
		<h2 class="ktn-section-title"><?php esc_html_e( 'Our Services', 'krishna-taxnova' ); ?></h2>
		<p class="ktn-section-sub"><?php esc_html_e( 'Everything your business needs under one roof: registrations, tax filings, intellectual property and ongoing compliance.', 'krishna-taxnova' ); ?></p>
		<div class="ktn-cat-grid">
			<?php foreach ( ktn_get_service_tree() as $branch ) : ?>
				<a class="ktn-cat-card" href="<?php echo esc_url( get_term_link( $branch['term'] ) ); ?>">
					<span class="ktn-cat-icon"><?php echo ktn_icon( get_term_meta( $branch['term']->term_id, '_ktn_icon', true ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3><?php echo esc_html( $branch['term']->name ); ?></h3>
					<p><?php echo esc_html( get_term_meta( $branch['term']->term_id, '_ktn_tagline', true ) ); ?></p>
					<span class="ktn-cat-count"><?php echo esc_html( sprintf( _n( '%d service', '%d services', count( $branch['services'] ), 'krishna-taxnova' ), count( $branch['services'] ) ) ); ?> &rarr;</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="ktn-section">
	<div class="wrap ktn-solutions">
		<div>
			<span class="ktn-chip-label"><?php esc_html_e( 'Modern CA Practice', 'krishna-taxnova' ); ?></span>
			<h2><?php echo esc_html( $get( 'solutions_h2', 'Tax, compliance and finance solutions built for growing Indian businesses' ) ); ?></h2>
			<p class="ktn-solutions-text"><?php echo esc_html( $get( 'solutions_text', 'We combine qualified professional judgement with a fully online process. Documents move on WhatsApp, deadlines live in tracked calendars and advice is grounded in your numbers, so you always know where your business stands.' ) ); ?></p>
			<p style="margin-top:1.25rem;"><a class="ktn-btn ktn-btn-primary" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Free Consultation', 'krishna-taxnova' ); ?></a></p>
			<div class="ktn-solutions-features">
				<div class="ktn-solutions-feature">
					<span class="ktn-cat-icon"><?php echo ktn_icon( 'shield' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3><?php esc_html_e( 'Qualified, Accountable Team', 'krishna-taxnova' ); ?></h3>
					<p><?php esc_html_e( 'Every filing is reviewed and signed off by experienced professionals who stay responsible for it.', 'krishna-taxnova' ); ?></p>
				</div>
				<div class="ktn-solutions-feature">
					<span class="ktn-cat-icon"><?php echo ktn_icon( 'chart' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3><?php esc_html_e( 'Insight, Not Just Filing', 'krishna-taxnova' ); ?></h3>
					<p><?php esc_html_e( 'Monthly reports and proactive tax planning that tell you what your numbers mean and what to do next.', 'krishna-taxnova' ); ?></p>
				</div>
			</div>
		</div>
		<div class="ktn-solutions-visual" aria-hidden="true">
			<div class="ktn-solutions-stat"><strong><?php echo esc_html( $get( 'stat1_num', '1500+' ) ); ?></strong><span><?php esc_html_e( 'businesses registered, filed and kept compliant', 'krishna-taxnova' ); ?></span></div>
			<div class="ktn-solutions-stat"><strong><?php echo esc_html( $get( 'stat2_num', '90+' ) ); ?></strong><span><?php esc_html_e( 'services under one roof, one accountable team', 'krishna-taxnova' ); ?></span></div>
			<div class="ktn-solutions-stat"><strong><?php echo esc_html( $get( 'stat4_num', '4.8/5' ) ); ?></strong><span><?php esc_html_e( 'average client rating across engagements', 'krishna-taxnova' ); ?></span></div>
		</div>
	</div>
</section>

<section class="ktn-section ktn-section-alt">
	<div class="wrap">
		<h2 class="ktn-section-title"><?php esc_html_e( 'How It Works', 'krishna-taxnova' ); ?></h2>
		<p class="ktn-section-sub"><?php esc_html_e( 'Three simple steps. Everything happens online, from any city in India.', 'krishna-taxnova' ); ?></p>
		<div class="ktn-how-grid">
			<div class="ktn-how-card"><span class="ktn-how-num">1</span><h3><?php esc_html_e( 'Share Your Requirement', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'Fill the short form on any service page or message us on WhatsApp. A CA calls you back to understand your need and confirm the exact scope and fee.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-how-card"><span class="ktn-how-num">2</span><h3><?php esc_html_e( 'Upload Your Documents', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'Send documents through the secure upload form on the service page or on WhatsApp. We verify everything and tell you if anything is missing.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-how-card"><span class="ktn-how-num">3</span><h3><?php esc_html_e( 'We File, You Relax', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'Our team prepares and files your application or return, tracks it with the department and shares the final certificate or acknowledgment with you.', 'krishna-taxnova' ); ?></p></div>
		</div>
	</div>
</section>

<section class="ktn-section">
	<div class="wrap">
		<h2 class="ktn-section-title"><?php esc_html_e( 'Why Businesses Choose Eaccountingcart', 'krishna-taxnova' ); ?></h2>
		<div class="ktn-why-grid">
			<div class="ktn-why-card"><h3><?php esc_html_e( 'Qualified CA Team', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'Your work is reviewed and signed off by experienced Chartered Accountants, so filings are right the first time.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-why-card"><h3><?php esc_html_e( 'Document Upload and WhatsApp', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'No courier, no office visits. Upload documents on the website or WhatsApp them from your phone.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-why-card"><h3><?php esc_html_e( 'Fixed, Honest Pricing', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'You get a written quote before work starts. Government fees are always shown separately.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-why-card"><h3><?php esc_html_e( 'Deadline Reminders', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'We track your GST, TDS, ROC and income tax due dates and remind you before every deadline.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-why-card"><h3><?php esc_html_e( 'One Point of Contact', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'A dedicated expert handles your account end to end, so you never repeat your story.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-why-card"><h3><?php esc_html_e( 'All India Coverage', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'Based in Delhi, we serve clients in every state through a fully online process.', 'krishna-taxnova' ); ?></p></div>
		</div>
	</div>
</section>

<?php
$team_members = get_posts(
	array(
		'post_type'      => 'ktn_team',
		'posts_per_page' => 4,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
	)
);
if ( $team_members ) :
	?>
	<section class="ktn-team">
		<div class="wrap">
			<div class="ktn-team-head">
				<div>
					<span class="ktn-chip-label ktn-chip-dark"><?php esc_html_e( 'Meet Our Team', 'krishna-taxnova' ); ?></span>
					<h2><?php esc_html_e( 'A Team of Seasoned Tax and Finance Professionals', 'krishna-taxnova' ); ?></h2>
				</div>
				<div>
					<p><?php esc_html_e( 'Chartered Accountants and compliance specialists who handle your work personally, from the first call to the final filing.', 'krishna-taxnova' ); ?></p>
					<a class="ktn-btn ktn-btn-light" href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'About the Firm', 'krishna-taxnova' ); ?></a>
				</div>
			</div>
			<div class="ktn-team-grid">
				<?php foreach ( $team_members as $member ) : ?>
					<div class="ktn-team-card">
						<div class="ktn-team-photo">
							<?php if ( has_post_thumbnail( $member ) ) : ?>
								<?php echo get_the_post_thumbnail( $member, 'medium_large' ); ?>
							<?php else : ?>
								<?php
								$words    = preg_split( '/\s+/', trim( wp_strip_all_tags( $member->post_title ) ) );
								$initials = strtoupper( substr( $words[0], 0, 1 ) . ( count( $words ) > 1 ? substr( end( $words ), 0, 1 ) : '' ) );
								?>
								<span class="ktn-team-initials" aria-hidden="true"><?php echo esc_html( $initials ); ?></span>
							<?php endif; ?>
						</div>
						<div class="ktn-team-info">
							<h3><?php echo esc_html( $member->post_title ); ?></h3>
							<p><?php echo esc_html( get_post_meta( $member->ID, '_ktn_role', true ) ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
$testimonials = get_posts(
	array(
		'post_type'      => 'ktn_testimonial',
		'posts_per_page' => 8,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
	)
);
if ( $testimonials ) :
	?>
	<section class="ktn-section ktn-tsec">
		<div class="wrap">
			<div class="ktn-blog-head">
				<span class="ktn-chip-label"><?php esc_html_e( 'Client Stories', 'krishna-taxnova' ); ?></span>
				<h2><?php esc_html_e( 'What Our Clients Say', 'krishna-taxnova' ); ?></h2>
				<p><?php esc_html_e( 'Real feedback from businesses and professionals we work with across India.', 'krishna-taxnova' ); ?></p>
			</div>
			<div class="ktn-tslider" id="ktn-tslider">
				<div class="ktn-ttrack">
					<?php foreach ( $testimonials as $t ) : ?>
						<?php
						$t_role   = get_post_meta( $t->ID, '_ktn_role', true );
						$t_rating = (int) get_post_meta( $t->ID, '_ktn_rating', true );
						if ( $t_rating < 1 || $t_rating > 5 ) {
							$t_rating = 5;
						}
						$t_words    = preg_split( '/\s+/', trim( wp_strip_all_tags( $t->post_title ) ) );
						$t_initials = strtoupper( substr( $t_words[0], 0, 1 ) . ( count( $t_words ) > 1 ? substr( end( $t_words ), 0, 1 ) : '' ) );
						?>
						<figure class="ktn-tslide">
							<div class="ktn-tstars" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %d out of 5', 'krishna-taxnova' ), $t_rating ) ); ?>">
								<?php echo str_repeat( '<span class="ktn-star-on">&#9733;</span>', $t_rating ) . str_repeat( '<span class="ktn-star-off">&#9733;</span>', 5 - $t_rating ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							</div>
							<blockquote><?php echo esc_html( wp_strip_all_tags( $t->post_content ) ); ?></blockquote>
							<figcaption>
								<span class="ktn-tavatar">
									<?php if ( has_post_thumbnail( $t ) ) : ?>
										<?php echo get_the_post_thumbnail( $t, 'thumbnail' ); ?>
									<?php else : ?>
										<i aria-hidden="true"><?php echo esc_html( $t_initials ); ?></i>
									<?php endif; ?>
								</span>
								<span class="ktn-twho">
									<strong><?php echo esc_html( $t->post_title ); ?></strong>
									<?php if ( $t_role ) : ?><small><?php echo esc_html( $t_role ); ?></small><?php endif; ?>
								</span>
								<span class="ktn-tquote-mark" aria-hidden="true">&#8221;</span>
							</figcaption>
						</figure>
					<?php endforeach; ?>
				</div>
				<div class="ktn-tnav">
					<button type="button" class="ktn-tprev" aria-label="<?php esc_attr_e( 'Previous testimonial', 'krishna-taxnova' ); ?>">&#8592;</button>
					<div class="ktn-tdots" role="tablist"></div>
					<button type="button" class="ktn-tnext" aria-label="<?php esc_attr_e( 'Next testimonial', 'krishna-taxnova' ); ?>">&#8594;</button>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php $tools_page = get_page_by_path( 'tools' ); ?>
<?php if ( $tools_page ) : ?>
	<section class="ktn-section ktn-section-alt">
		<div class="wrap">
			<h2 class="ktn-section-title"><?php esc_html_e( 'Free Online Tools', 'krishna-taxnova' ); ?></h2>
			<p class="ktn-section-sub"><?php esc_html_e( 'Quick calculators built by our CA team. Instant answers, no signup, works on any device.', 'krishna-taxnova' ); ?></p>
			<?php echo do_shortcode( '[ktn_tools_grid]' ); ?>
			<p style="text-align:center;margin-top:1.5rem;">
				<a class="ktn-btn ktn-btn-outline" href="<?php echo esc_url( get_permalink( $tools_page ) ); ?>"><?php esc_html_e( 'View All Tools', 'krishna-taxnova' ); ?></a>
			</p>
		</div>
	</section>
<?php endif; ?>

<?php
$home_faqs = get_option( 'ktn_home_faqs', array() );
if ( $home_faqs ) :
	?>
	<section class="ktn-section ktn-section-alt">
		<div class="wrap ktn-narrow">
			<?php ktn_render_faqs( $home_faqs, __( 'Frequently Asked Questions', 'krishna-taxnova' ) ); ?>
		</div>
	</section>
<?php endif; ?>

<?php
$latest_posts = get_posts( array( 'posts_per_page' => 3, 'post_status' => 'publish' ) );
if ( $latest_posts ) :
	?>
	<section class="ktn-section">
		<div class="wrap">
			<div class="ktn-blog-head">
				<span class="ktn-chip-label"><?php esc_html_e( 'Insights & Resources', 'krishna-taxnova' ); ?></span>
				<h2><?php esc_html_e( 'Latest Insights and Resources', 'krishna-taxnova' ); ?></h2>
				<p><?php esc_html_e( 'Practical guidance on tax, GST, compliance and business finance from our team, written in plain language for business owners.', 'krishna-taxnova' ); ?></p>
			</div>
			<div class="ktn-blog-grid">
				<?php
				foreach ( $latest_posts as $post ) :
					setup_postdata( $post );
					$cats = get_the_category( $post->ID );
					?>
					<article class="ktn-blog-card">
						<a class="ktn-blog-thumb" href="<?php echo esc_url( get_permalink( $post ) ); ?>" tabindex="-1" aria-hidden="true">
							<?php if ( has_post_thumbnail( $post ) ) : ?>
								<?php echo get_the_post_thumbnail( $post, 'medium_large' ); ?>
							<?php else : ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/><path d="M9 7h7m-7 4h7"/></svg>
							<?php endif; ?>
						</a>
						<div class="ktn-blog-body">
							<div class="ktn-blog-meta">
								<?php if ( $cats ) : ?>
									<span class="ktn-blog-cat"><?php echo esc_html( $cats[0]->name ); ?></span>
									<span aria-hidden="true">&bull;</span>
								<?php endif; ?>
								<time datetime="<?php echo esc_attr( get_the_date( 'c', $post ) ); ?>"><?php echo esc_html( get_the_date( '', $post ) ); ?></time>
							</div>
							<h3><a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $post ), 22 ) ); ?></p>
							<a class="ktn-blog-more" href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php esc_html_e( 'Read More', 'krishna-taxnova' ); ?></a>
						</div>
					</article>
				<?php endforeach; wp_reset_postdata(); ?>
			</div>
			<?php $blog_page_id = (int) get_option( 'page_for_posts' ); ?>
			<?php if ( $blog_page_id ) : ?>
				<p style="text-align:center;margin-top:1.75rem;">
					<a class="ktn-btn ktn-btn-outline" href="<?php echo esc_url( get_permalink( $blog_page_id ) ); ?>"><?php esc_html_e( 'View All Articles', 'krishna-taxnova' ); ?></a>
				</p>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

<section class="ktn-cta-band">
	<div class="wrap ktn-cta-band-inner">
		<div>
			<h2><?php esc_html_e( 'Ready to get started?', 'krishna-taxnova' ); ?></h2>
			<p><?php esc_html_e( 'Tell us what you need. Get a free consultation and a fixed quote today.', 'krishna-taxnova' ); ?></p>
		</div>
		<div class="ktn-cta-band-actions">
			<a class="ktn-btn ktn-btn-light" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Free Consultation', 'krishna-taxnova' ); ?></a>
			<?php echo ktn_whatsapp_button(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
