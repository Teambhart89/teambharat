/**
 * epoojabooking astro tools engine.
 *
 * Self-contained Vedic astrology calculators: Nakshatra, Rashi (moon sign),
 * Mangal Dosha and Kaal Sarp Dosha. Positions are computed with compact
 * astronomical series (Meeus-style Sun and Moon, Keplerian elements for
 * planets, mean lunar node for Rahu) and the Lahiri ayanamsa approximation.
 * Accuracy is a small fraction of a degree, which is sufficient for sign
 * and nakshatra level results; births very close to a boundary should be
 * verified with a detailed kundli.
 */
( function () {
	'use strict';

	var D2R = Math.PI / 180;

	function norm( deg ) {
		deg %= 360;
		return deg < 0 ? deg + 360 : deg;
	}

	function sinD( d ) { return Math.sin( d * D2R ); }
	function cosD( d ) { return Math.cos( d * D2R ); }

	// Julian Day from a UTC timestamp.
	function julianDay( date ) {
		return date.getTime() / 86400000 + 2440587.5;
	}

	// Sun geocentric apparent longitude (tropical), Meeus low precision.
	function sunLongitude( T ) {
		var L0 = norm( 280.46646 + 36000.76983 * T );
		var M = norm( 357.52911 + 35999.05029 * T );
		var C = ( 1.914602 - 0.004817 * T ) * sinD( M )
			+ ( 0.019993 - 0.000101 * T ) * sinD( 2 * M )
			+ 0.000289 * sinD( 3 * M );
		return norm( L0 + C );
	}

	// Moon geocentric longitude (tropical), truncated ELP series (~0.05 deg).
	function moonLongitude( T ) {
		var Lp = norm( 218.3164477 + 481267.88123421 * T - 0.0015786 * T * T );
		var D = norm( 297.8501921 + 445267.1114034 * T - 0.0018819 * T * T );
		var M = norm( 357.5291092 + 35999.0502909 * T );
		var Mp = norm( 134.9633964 + 477198.8675055 * T + 0.0087414 * T * T );
		var F = norm( 93.2720950 + 483202.0175233 * T - 0.0036539 * T * T );

		var lon = Lp
			+ 6.288774 * sinD( Mp )
			+ 1.274027 * sinD( 2 * D - Mp )
			+ 0.658314 * sinD( 2 * D )
			+ 0.213618 * sinD( 2 * Mp )
			- 0.185116 * sinD( M )
			- 0.114332 * sinD( 2 * F )
			+ 0.058793 * sinD( 2 * D - 2 * Mp )
			+ 0.057066 * sinD( 2 * D - M - Mp )
			+ 0.053322 * sinD( 2 * D + Mp )
			+ 0.045758 * sinD( 2 * D - M )
			- 0.040923 * sinD( M - Mp )
			- 0.034720 * sinD( D )
			- 0.030383 * sinD( M + Mp )
			+ 0.015327 * sinD( 2 * D - 2 * F )
			- 0.012528 * sinD( Mp + 2 * F )
			+ 0.010980 * sinD( Mp - 2 * F )
			+ 0.010675 * sinD( 4 * D - Mp )
			+ 0.010034 * sinD( 3 * Mp )
			+ 0.008548 * sinD( 4 * D - 2 * Mp )
			- 0.007888 * sinD( 2 * D + M - Mp )
			- 0.006766 * sinD( 2 * D + M )
			- 0.005163 * sinD( D - Mp );
		return norm( lon );
	}

	// Keplerian elements (J2000, per-century rates), Standish 1800-2050.
	var ELEMENTS = {
		mercury: [ 0.38709927, 0.20563593, 7.00497902, 252.25032350, 77.45779628, 48.33076593, 0.00000037, 0.00001906, -0.00594749, 149472.67411175, 0.16047689, -0.12534081 ],
		venus:   [ 0.72333566, 0.00677672, 3.39467605, 181.97909950, 131.60246718, 76.67984255, 0.00000390, -0.00004107, -0.00078890, 58517.81538729, 0.00268329, -0.27769418 ],
		earth:   [ 1.00000261, 0.01671123, -0.00001531, 100.46457166, 102.93768193, 0.0, 0.00000562, -0.00004392, -0.01294668, 35999.37244981, 0.32327364, 0.0 ],
		mars:    [ 1.52371034, 0.09339410, 1.84969142, -4.55343205, -23.94362959, 49.55953891, 0.00001847, 0.00007882, -0.00813131, 19140.30268499, 0.44441088, -0.29257343 ],
		jupiter: [ 5.20288700, 0.04838624, 1.30439695, 34.39644051, 14.72847983, 100.47390909, -0.00011607, -0.00013253, -0.00183714, 3034.74612775, 0.21252668, 0.20469106 ],
		saturn:  [ 9.53667594, 0.05386179, 2.48599187, 49.95424423, 92.59887831, 113.66242448, -0.00125060, -0.00050991, 0.00193609, 1222.49362201, -0.41897216, -0.28867794 ]
	};

	// Heliocentric ecliptic rectangular coordinates of a body.
	function heliocentric( name, T ) {
		var el = ELEMENTS[ name ];
		var a = el[0] + el[6] * T;
		var e = el[1] + el[7] * T;
		var I = el[2] + el[8] * T;
		var L = el[3] + el[9] * T;
		var wBar = el[4] + el[10] * T;
		var O = el[5] + el[11] * T;

		var M = norm( L - wBar );
		var w = wBar - O;

		// Solve Kepler's equation.
		var E = M + ( e * 180 / Math.PI ) * sinD( M );
		for ( var i = 0; i < 8; i++ ) {
			var dM = M - ( E - ( e * 180 / Math.PI ) * sinD( E ) );
			E += dM / ( 1 - e * cosD( E ) );
		}

		var xP = a * ( cosD( E ) - e );
		var yP = a * Math.sqrt( 1 - e * e ) * sinD( E );

		var x = ( cosD( w ) * cosD( O ) - sinD( w ) * sinD( O ) * cosD( I ) ) * xP
			+ ( -sinD( w ) * cosD( O ) - cosD( w ) * sinD( O ) * cosD( I ) ) * yP;
		var y = ( cosD( w ) * sinD( O ) + sinD( w ) * cosD( O ) * cosD( I ) ) * xP
			+ ( -sinD( w ) * sinD( O ) + cosD( w ) * cosD( O ) * cosD( I ) ) * yP;
		var z = ( sinD( w ) * sinD( I ) ) * xP + ( cosD( w ) * sinD( I ) ) * yP;

		return { x: x, y: y, z: z };
	}

	// Geocentric tropical ecliptic longitude of a planet.
	function planetLongitude( name, T ) {
		var p = heliocentric( name, T );
		var e = heliocentric( 'earth', T );
		return norm( Math.atan2( p.y - e.y, p.x - e.x ) / D2R );
	}

	// Mean lunar ascending node (Rahu), tropical.
	function rahuLongitude( T ) {
		return norm( 125.0445479 - 1934.1362891 * T + 0.0020754 * T * T );
	}

	// Lahiri ayanamsa approximation (23.853 deg at J2000, 50.29"/year).
	function ayanamsa( T ) {
		return 23.853 + 1.39694 * T;
	}

	// Ecliptic longitude of the ascendant (tropical).
	function ascendant( jd, T, latitude, longitudeEast ) {
		var gmst = norm( 280.46061837 + 360.98564736629 * ( jd - 2451545.0 ) );
		var ramc = norm( gmst + longitudeEast );
		var eps = 23.4392911 - 0.0130042 * T;
		var asc = Math.atan2(
			cosD( ramc ),
			-( sinD( ramc ) * cosD( eps ) + Math.tan( latitude * D2R ) * sinD( eps ) )
		) / D2R;
		return norm( asc );
	}

	var NAKSHATRAS = [
		[ 'Ashwini', 'Ketu', 'quick, healing, pioneering energy' ],
		[ 'Bharani', 'Venus', 'creative strength and the courage to bear responsibility' ],
		[ 'Krittika', 'Sun', 'sharp clarity, leadership and purifying fire' ],
		[ 'Rohini', 'Moon', 'charm, growth and love of beauty and comfort' ],
		[ 'Mrigashira', 'Mars', 'curiosity, gentleness and a searching mind' ],
		[ 'Ardra', 'Rahu', 'intensity, transformation and sharp intellect' ],
		[ 'Punarvasu', 'Jupiter', 'renewal, optimism and generous wisdom' ],
		[ 'Pushya', 'Saturn', 'nourishment, discipline and steady prosperity' ],
		[ 'Ashlesha', 'Mercury', 'deep perception, intuition and persuasive skill' ],
		[ 'Magha', 'Ketu', 'dignity, ancestry and natural authority' ],
		[ 'Purva Phalguni', 'Venus', 'warmth, artistry and love of celebration' ],
		[ 'Uttara Phalguni', 'Sun', 'reliability, kindness and helpful leadership' ],
		[ 'Hasta', 'Moon', 'skilled hands, wit and practical intelligence' ],
		[ 'Chitra', 'Mars', 'brilliance, design sense and striking presence' ],
		[ 'Swati', 'Rahu', 'independence, diplomacy and flexible strength' ],
		[ 'Vishakha', 'Jupiter', 'determination, ambition and focused purpose' ],
		[ 'Anuradha', 'Saturn', 'friendship, devotion and success away from home' ],
		[ 'Jyeshtha', 'Mercury', 'protectiveness, seniority and sharp strategy' ],
		[ 'Mula', 'Ketu', 'depth, research and the search for root causes' ],
		[ 'Purva Ashadha', 'Venus', 'invincible optimism and persuasive power' ],
		[ 'Uttara Ashadha', 'Sun', 'lasting victory, integrity and high goals' ],
		[ 'Shravana', 'Moon', 'learning, listening and preserving wisdom' ],
		[ 'Dhanishta', 'Mars', 'rhythm, wealth and adaptable talent' ],
		[ 'Shatabhisha', 'Rahu', 'healing, mysticism and independent thinking' ],
		[ 'Purva Bhadrapada', 'Jupiter', 'idealism, intensity and spiritual fire' ],
		[ 'Uttara Bhadrapada', 'Saturn', 'depth, patience and quiet strength' ],
		[ 'Revati', 'Mercury', 'compassion, protection of travellers and gentle completion' ]
	];

	var RASHIS = [
		[ 'Mesha', 'Aries', 'Mars', 'courageous, direct and pioneering' ],
		[ 'Vrishabha', 'Taurus', 'Venus', 'steady, patient and comfort-loving' ],
		[ 'Mithuna', 'Gemini', 'Mercury', 'quick-minded, curious and expressive' ],
		[ 'Karka', 'Cancer', 'Moon', 'caring, intuitive and family-oriented' ],
		[ 'Simha', 'Leo', 'Sun', 'confident, warm and born to lead' ],
		[ 'Kanya', 'Virgo', 'Mercury', 'precise, helpful and analytical' ],
		[ 'Tula', 'Libra', 'Venus', 'balanced, artistic and diplomatic' ],
		[ 'Vrishchika', 'Scorpio', 'Mars', 'intense, determined and transformative' ],
		[ 'Dhanu', 'Sagittarius', 'Jupiter', 'optimistic, philosophical and freedom-loving' ],
		[ 'Makara', 'Capricorn', 'Saturn', 'disciplined, ambitious and enduring' ],
		[ 'Kumbha', 'Aquarius', 'Saturn', 'original, humanitarian and independent' ],
		[ 'Meena', 'Pisces', 'Jupiter', 'compassionate, imaginative and devoted' ]
	];

	var KAALSARP_TYPES = [ 'Anant', 'Kulik', 'Vasuki', 'Shankhpal', 'Padma', 'Mahapadma', 'Takshak', 'Karkotak', 'Shankhachur', 'Ghatak', 'Vishdhar', 'Sheshnag' ];

	// Compute the full sidereal chart from birth details.
	function computeChart( dateStr, timeStr, tzOffsetMinutes, latitude, longitudeEast ) {
		var parts = dateStr.split( '-' );
		var tparts = timeStr.split( ':' );
		var utcMs = Date.UTC(
			parseInt( parts[0], 10 ),
			parseInt( parts[1], 10 ) - 1,
			parseInt( parts[2], 10 ),
			parseInt( tparts[0], 10 ),
			parseInt( tparts[1], 10 )
		) - tzOffsetMinutes * 60000;

		var jd = julianDay( new Date( utcMs ) );
		var T = ( jd - 2451545.0 ) / 36525.0;
		var ayan = ayanamsa( T );

		function sidereal( tropical ) {
			return norm( tropical - ayan );
		}

		var rahu = sidereal( rahuLongitude( T ) );

		return {
			jd: jd,
			ayanamsa: ayan,
			moon: sidereal( moonLongitude( T ) ),
			sun: sidereal( sunLongitude( T ) ),
			mercury: sidereal( planetLongitude( 'mercury', T ) ),
			venus: sidereal( planetLongitude( 'venus', T ) ),
			mars: sidereal( planetLongitude( 'mars', T ) ),
			jupiter: sidereal( planetLongitude( 'jupiter', T ) ),
			saturn: sidereal( planetLongitude( 'saturn', T ) ),
			rahu: rahu,
			ketu: norm( rahu + 180 ),
			ascendant: sidereal( ascendant( jd, T, latitude, longitudeEast ) )
		};
	}

	function rashiIndex( lon ) { return Math.floor( norm( lon ) / 30 ); }

	function houseFrom( fromLon, planetLon ) {
		return ( ( rashiIndex( planetLon ) - rashiIndex( fromLon ) + 12 ) % 12 ) + 1;
	}

	function degMin( lon ) {
		var inSign = norm( lon ) % 30;
		var d = Math.floor( inSign );
		var m = Math.round( ( inSign - d ) * 60 );
		if ( 60 === m ) { d += 1; m = 0; }
		return d + '° ' + ( m < 10 ? '0' : '' ) + m + '′';
	}

	// ---------- Result builders ----------

	function esc( s ) {
		return String( s ).replace( /[&<>"']/g, function ( c ) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ c ];
		} );
	}

	function nakshatraResult( chart ) {
		var idx = Math.floor( chart.moon / ( 360 / 27 ) );
		var pada = Math.floor( ( chart.moon % ( 360 / 27 ) ) / ( 360 / 108 ) ) + 1;
		var nk = NAKSHATRAS[ idx ];
		var rs = RASHIS[ rashiIndex( chart.moon ) ];
		return '<div class="epb-astro-headline">' + esc( nk[0] ) + ' Nakshatra, Pada ' + pada + '</div>' +
			'<ul class="epb-astro-facts">' +
			'<li><strong>Birth star (Janma Nakshatra):</strong> ' + esc( nk[0] ) + '</li>' +
			'<li><strong>Charan / Pada:</strong> ' + pada + ' of 4</li>' +
			'<li><strong>Nakshatra lord:</strong> ' + esc( nk[1] ) + '</li>' +
			'<li><strong>Moon position:</strong> ' + degMin( chart.moon ) + ' in ' + esc( rs[0] ) + ' (' + esc( rs[1] ) + ')</li>' +
			'</ul>' +
			'<p>People born in ' + esc( nk[0] ) + ' often carry ' + esc( nk[2] ) + '. Your nakshatra guides the choice of auspicious dates, your name syllable and the pujas that suit you best.</p>';
	}

	function rashiResult( chart ) {
		var rs = RASHIS[ rashiIndex( chart.moon ) ];
		var nk = NAKSHATRAS[ Math.floor( chart.moon / ( 360 / 27 ) ) ];
		return '<div class="epb-astro-headline">' + esc( rs[0] ) + ' Rashi (' + esc( rs[1] ) + ' Moon Sign)</div>' +
			'<ul class="epb-astro-facts">' +
			'<li><strong>Janma Rashi (moon sign):</strong> ' + esc( rs[0] ) + ' / ' + esc( rs[1] ) + '</li>' +
			'<li><strong>Rashi lord:</strong> ' + esc( rs[2] ) + '</li>' +
			'<li><strong>Moon position:</strong> ' + degMin( chart.moon ) + ' in ' + esc( rs[0] ) + '</li>' +
			'<li><strong>Birth star:</strong> ' + esc( nk[0] ) + '</li>' +
			'</ul>' +
			'<p>' + esc( rs[0] ) + ' moon natives are typically ' + esc( rs[3] ) + '. The janma rashi is used for daily and yearly predictions, kundli milan and choosing your rashi name.</p>';
	}

	function mangalResult( chart ) {
		var doshaHouses = [ 1, 2, 4, 7, 8, 12 ];
		var fromLagna = houseFrom( chart.ascendant, chart.mars );
		var fromMoon = houseFrom( chart.moon, chart.mars );
		var lagnaDosha = doshaHouses.indexOf( fromLagna ) !== -1;
		var moonDosha = doshaHouses.indexOf( fromMoon ) !== -1;
		var marsSign = rashiIndex( chart.mars );
		var softened = ( 0 === marsSign || 7 === marsSign || 9 === marsSign );

		var verdict;
		if ( lagnaDosha && moonDosha ) {
			verdict = 'Mangal Dosha is present from both the Lagna and the Moon chart.';
		} else if ( lagnaDosha || moonDosha ) {
			verdict = 'Partial Mangal Dosha: present from the ' + ( lagnaDosha ? 'Lagna' : 'Moon' ) + ' chart only.';
		} else {
			verdict = 'No Mangal Dosha found. Mars is placed in a neutral house.';
		}

		var html = '<div class="epb-astro-headline">' + esc( verdict ) + '</div>' +
			'<ul class="epb-astro-facts">' +
			'<li><strong>Mars:</strong> ' + degMin( chart.mars ) + ' in ' + esc( RASHIS[ marsSign ][0] ) + '</li>' +
			'<li><strong>House from Lagna (' + esc( RASHIS[ rashiIndex( chart.ascendant ) ][0] ) + ' rising):</strong> ' + fromLagna + '</li>' +
			'<li><strong>House from Moon:</strong> ' + fromMoon + '</li>' +
			'</ul>';

		if ( ( lagnaDosha || moonDosha ) && softened ) {
			html += '<p>Mars stands in ' + esc( RASHIS[ marsSign ][0] ) + ', a sign where its dosha is traditionally considered much weaker or cancelled.</p>';
		}
		if ( lagnaDosha || moonDosha ) {
			html += '<p>Many charts carry Mangal Dosha, and tradition offers well-known remedies such as Mangal Shanti puja, Hanuman upasana on Tuesdays, and matching with another Manglik chart. A detailed reading confirms whether the dosha truly applies, since several placements cancel it.</p>';
		} else {
			html += '<p>Mars placement in your chart does not create the classical Manglik combination checked by this tool.</p>';
		}
		return html;
	}

	function kaalsarpResult( chart ) {
		var planets = [
			[ 'Sun', chart.sun ], [ 'Moon', chart.moon ], [ 'Mars', chart.mars ],
			[ 'Mercury', chart.mercury ], [ 'Jupiter', chart.jupiter ],
			[ 'Venus', chart.venus ], [ 'Saturn', chart.saturn ]
		];

		var sideA = 0;
		var outliersA = [];
		var outliersB = [];
		planets.forEach( function ( p ) {
			var d = norm( p[1] - chart.rahu );
			if ( d < 180 ) {
				sideA++;
				outliersB.push( p[0] );
			} else {
				outliersA.push( p[0] );
			}
		} );

		var verdict, detail;
		var rahuHouse = houseFrom( chart.ascendant, chart.rahu );
		if ( 7 === sideA || 0 === sideA ) {
			var type = KAALSARP_TYPES[ rahuHouse - 1 ];
			verdict = 'Kaal Sarp Dosha is present: ' + type + ' Kaal Sarp Yoga.';
			detail = '<p>All seven grahas stand on one side of the Rahu and Ketu axis. With Rahu in house ' + rahuHouse + ' from the Lagna, this formation is traditionally called <strong>' + esc( type ) + ' Kaal Sarp Yoga</strong>.</p>' +
				'<p>Shastras describe this yoga as a period-giver of struggle that also grants unusual focus and achievement once pacified. The classical remedy is Kaal Sarp Dosh Nivaran puja, performed especially at Trimbakeshwar or Ujjain, along with Rahu-Ketu shanti and Nag Panchami worship.</p>';
		} else if ( 6 === sideA || 1 === sideA ) {
			var outside = ( 6 === sideA ? outliersA : outliersB ).join( ', ' );
			verdict = 'Partial Kaal Sarp Dosha (Kaal Sarp Yoga is not complete).';
			detail = '<p>Only ' + esc( outside ) + ' stands outside the Rahu and Ketu axis, so the yoga is partial. Partial formations are considered much milder, and their effects fade as the periods of the outside graha operate.</p>';
		} else {
			verdict = 'No Kaal Sarp Dosha found.';
			detail = '<p>The seven grahas are distributed on both sides of the Rahu and Ketu axis, so the Kaal Sarp formation does not occur in your chart.</p>';
		}

		return '<div class="epb-astro-headline">' + esc( verdict ) + '</div>' +
			'<ul class="epb-astro-facts">' +
			'<li><strong>Rahu:</strong> ' + degMin( chart.rahu ) + ' in ' + esc( RASHIS[ rashiIndex( chart.rahu ) ][0] ) + ' (house ' + rahuHouse + ')</li>' +
			'<li><strong>Ketu:</strong> ' + degMin( chart.ketu ) + ' in ' + esc( RASHIS[ rashiIndex( chart.ketu ) ][0] ) + '</li>' +
			'</ul>' + detail;
	}

	var BUILDERS = {
		nakshatra: nakshatraResult,
		rashi: rashiResult,
		mangal: mangalResult,
		kaalsarp: kaalsarpResult
	};

	// ---------- Form wiring ----------

	document.querySelectorAll( '.epb-astro-form' ).forEach( function ( form ) {
		var tool = form.getAttribute( 'data-tool' );
		var result = form.parentElement.querySelector( '.epb-astro-result' );
		var citySelect = form.querySelector( '[name="city"]' );
		var latInput = form.querySelector( '[name="latitude"]' );
		var lonInput = form.querySelector( '[name="longitude"]' );
		var tzSelect = form.querySelector( '[name="tz"]' );

		if ( citySelect ) {
			citySelect.addEventListener( 'change', function () {
				var opt = citySelect.options[ citySelect.selectedIndex ];
				if ( opt && opt.dataset.lat ) {
					latInput.value = opt.dataset.lat;
					lonInput.value = opt.dataset.lon;
					if ( opt.dataset.tz ) {
						tzSelect.value = opt.dataset.tz;
					}
				}
			} );
		}

		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			if ( ! form.reportValidity() ) {
				return;
			}

			var chart = computeChart(
				form.querySelector( '[name="dob"]' ).value,
				form.querySelector( '[name="tob"]' ).value,
				parseInt( tzSelect.value, 10 ),
				parseFloat( latInput.value ) || 0,
				parseFloat( lonInput.value ) || 0
			);

			result.innerHTML = BUILDERS[ tool ]( chart ) +
				'<p class="epb-astro-note">Calculated with Lahiri ayanamsa. Results close to a sign or nakshatra boundary should be confirmed with a detailed kundli from our astrologers.</p>';
			result.hidden = false;
			result.scrollIntoView( { behavior: 'smooth', block: 'nearest' } );
		} );
	} );
} )();
