/**
 * epoojabooking theme scripts: mobile nav + scroll reveal.
 */
( function () {
	'use strict';

	document.documentElement.classList.add( 'js' );

	// Mobile navigation toggle.
	var toggle = document.querySelector( '.epb-nav-toggle' );
	var nav = document.getElementById( 'epb-nav' );

	if ( toggle && nav ) {
		toggle.addEventListener( 'click', function () {
			var open = nav.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			toggle.setAttribute( 'aria-label', open ? 'Close menu' : 'Open menu' );
		} );

		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key && nav.classList.contains( 'is-open' ) ) {
				nav.classList.remove( 'is-open' );
				toggle.setAttribute( 'aria-expanded', 'false' );
				toggle.focus();
			}
		} );
	}

	// Scroll reveal for cards and steps, skipped for reduced motion.
	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	if ( ! reduced && 'IntersectionObserver' in window ) {
		var targets = document.querySelectorAll( '.epb-card, .epb-steps li, .epb-quote' );
		targets.forEach( function ( el ) {
			el.classList.add( 'epb-reveal' );
		} );

		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'epb-revealed' );
						observer.unobserve( entry.target );
					}
				} );
			},
			{ threshold: 0.12 }
		);

		targets.forEach( function ( el ) {
			observer.observe( el );
		} );
	}
} )();
