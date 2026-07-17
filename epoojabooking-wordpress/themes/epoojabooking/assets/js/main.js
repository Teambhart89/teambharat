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

	// Temple directory: filter cards by city.
	var filter = document.querySelector( '.epb-city-filter' );
	if ( filter ) {
		var chips = filter.querySelectorAll( '.epb-chip' );
		var cards = document.querySelectorAll( '.epb-temple-card' );
		var empty = document.querySelector( '.epb-filter-empty' );

		filter.addEventListener( 'click', function ( e ) {
			var chip = e.target.closest( '.epb-chip' );
			if ( ! chip ) {
				return;
			}
			var city = chip.getAttribute( 'data-city' );
			var visible = 0;

			chips.forEach( function ( c ) {
				var active = c === chip;
				c.classList.toggle( 'is-active', active );
				c.setAttribute( 'aria-pressed', active ? 'true' : 'false' );
			} );

			cards.forEach( function ( card ) {
				var show = 'all' === city || card.getAttribute( 'data-city' ) === city;
				card.classList.toggle( 'is-hidden', ! show );
				if ( show ) {
					visible++;
				}
			} );

			if ( empty ) {
				empty.hidden = visible > 0;
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
