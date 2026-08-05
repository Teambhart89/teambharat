<?php
/**
 * Site header with top bar, automatic services mega menu and mobile nav.
 *
 * @package krishna-taxnova
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'krishna-taxnova' ); ?></a>

<div class="ktn-topbar">
	<div class="wrap ktn-topbar-inner">
		<p class="ktn-topbar-note"><?php esc_html_e( 'CA led tax, accounting and compliance services. Delhi based, serving all India.', 'krishna-taxnova' ); ?></p>
		<div class="ktn-topbar-contact">
			<?php $phone = ktn_get_option( 'phone' ); ?>
			<?php if ( $phone ) : ?>
				<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>">&#9742; <?php echo esc_html( $phone ); ?></a>
			<?php endif; ?>
			<?php $email = ktn_get_option( 'email' ); ?>
			<?php if ( $email ) : ?>
				<a href="mailto:<?php echo esc_attr( $email ); ?>">&#9993; <?php echo esc_html( $email ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>

<header class="ktn-header" id="ktn-header">
	<div class="wrap ktn-header-inner">
		<div class="ktn-brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="ktn-logo-text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="ktn-logo-mark" aria-hidden="true">EA</span>
					<span class="ktn-logo-name">Eaccounting<em>cart</em><small><?php esc_html_e( 'Tax | Compliance | Advisory', 'krishna-taxnova' ); ?></small></span>
				</a>
			<?php endif; ?>
		</div>

		<div class="ktn-header-actions">
			<a class="ktn-btn ktn-btn-primary ktn-header-cta" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Free Consultation', 'krishna-taxnova' ); ?></a>
			<button class="ktn-nav-toggle" aria-expanded="false" aria-controls="ktn-nav">
				<span class="ktn-nav-toggle-bar"></span><span class="ktn-nav-toggle-bar"></span><span class="ktn-nav-toggle-bar"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'krishna-taxnova' ); ?></span>
			</button>
		</div>

		<nav class="ktn-nav" id="ktn-nav" aria-label="<?php esc_attr_e( 'Primary', 'krishna-taxnova' ); ?>">
			<ul class="ktn-menu">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'krishna-taxnova' ); ?></a></li>
				<?php foreach ( ktn_get_menu_groups() as $group ) : ?>
					<li class="ktn-has-mega">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>" aria-haspopup="true">
							<?php echo esc_html( $group['label'] ); ?> <span class="ktn-caret" aria-hidden="true">&#9662;</span>
						</a>
						<div class="ktn-mega ktn-mega-groups">
							<div class="ktn-mega-cols">
								<?php foreach ( $group['branches'] as $branch ) : ?>
									<div class="ktn-mega-col">
										<a class="ktn-mega-head" href="<?php echo esc_url( get_term_link( $branch['term'] ) ); ?>">
											<span class="ktn-mega-head-icon"><?php echo ktn_icon( get_term_meta( $branch['term']->term_id, '_ktn_icon', true ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
											<?php echo esc_html( $branch['term']->name ); ?>
										</a>
										<ul>
											<?php foreach ( array_slice( $branch['services'], 0, 8 ) as $service_post ) : ?>
												<li><a href="<?php echo esc_url( get_permalink( $service_post ) ); ?>"><?php echo esc_html( $service_post->post_title ); ?></a></li>
											<?php endforeach; ?>
										</ul>
										<a class="ktn-mega-all" href="<?php echo esc_url( get_term_link( $branch['term'] ) ); ?>">
											<?php echo esc_html( sprintf( __( 'View all %d services', 'krishna-taxnova' ), count( $branch['services'] ) ) ); ?> &rarr;
										</a>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
				<li><a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php esc_html_e( 'Tools', 'krishna-taxnova' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'About', 'krishna-taxnova' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Contact', 'krishna-taxnova' ); ?></a></li>
			</ul>
		</nav>
	</div>
</header>
<?php ktn_breadcrumbs(); ?>
<main id="main" class="ktn-main">
