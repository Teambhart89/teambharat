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

	// Banner slider: fade slides, arrows, dots, gentle autoplay.
	document.querySelectorAll( '.epb-slider' ).forEach( function ( slider ) {
		var slides = slider.querySelectorAll( '.epb-slide' );
		if ( slides.length < 2 ) {
			return;
		}

		var dots = slider.querySelectorAll( '.epb-slider-dot' );
		var current = 0;
		var timer = null;
		var reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		function goTo( index ) {
			current = ( index + slides.length ) % slides.length;
			slides.forEach( function ( slide, i ) {
				slide.classList.toggle( 'is-active', i === current );
				slide.setAttribute( 'aria-hidden', i === current ? 'false' : 'true' );
			} );
			dots.forEach( function ( dot, i ) {
				dot.classList.toggle( 'is-active', i === current );
			} );
		}

		function play() {
			if ( reducedMotion ) {
				return;
			}
			stop();
			timer = window.setInterval( function () {
				goTo( current + 1 );
			}, 6000 );
		}

		function stop() {
			if ( timer ) {
				window.clearInterval( timer );
				timer = null;
			}
		}

		var prev = slider.querySelector( '.epb-slider-prev' );
		var next = slider.querySelector( '.epb-slider-next' );
		if ( prev ) {
			prev.addEventListener( 'click', function () { goTo( current - 1 ); play(); } );
		}
		if ( next ) {
			next.addEventListener( 'click', function () { goTo( current + 1 ); play(); } );
		}
		dots.forEach( function ( dot ) {
			dot.addEventListener( 'click', function () {
				goTo( parseInt( dot.getAttribute( 'data-slide' ), 10 ) );
				play();
			} );
		} );

		slider.addEventListener( 'mouseenter', stop );
		slider.addEventListener( 'mouseleave', play );
		slider.addEventListener( 'focusin', stop );
		slider.addEventListener( 'focusout', play );
		document.addEventListener( 'visibilitychange', function () {
			if ( document.hidden ) {
				stop();
			} else {
				play();
			}
		} );

		play();
	} );

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
