<?php
/**
 * Front page: landing sections + booking form.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
?>

<main id="main" class="page" tabindex="-1">

	<!-- HERO -->
	<section class="hero" aria-labelledby="hero-title">
		<span class="eyebrow">Serviced Apartments &amp; Studios · Gurgaon</span>
		<h1 id="hero-title">Stays that feel like home, run like a hotel</h1>
		<p>Fully furnished studios and apartments with housekeeping, high-speed Wi-Fi and a
		24×7 front desk — for a night, a week, or as long as work keeps you in town.</p>
		<div class="hero-cta">
			<a class="btn btn-primary" href="#book">Book your stay</a>
			<a class="btn btn-ghost" href="#apartments">Explore apartments</a>
		</div>
	</section>

	<!-- APARTMENTS -->
	<section id="apartments" aria-labelledby="apartments-title">
		<div class="section-head">
			<h2 id="apartments-title">Choose your space</h2>
			<p>Every apartment is fully furnished with a kitchenette, workspace and hotel-grade linen.</p>
		</div>
		<div class="grid-3">
			<article class="tile">
				<div class="tile-media m-studio">Studio Apartment</div>
				<div class="tile-body">
					<span class="price">From ₹2,499 / night</span>
					<ul><li>Queen bed + work desk</li><li>Kitchenette &amp; smart TV</li><li>Ideal for solo travellers</li></ul>
					<a class="btn btn-secondary btn-sm" href="#book">Book Studio</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-1bhk">1 BHK Apartment</div>
				<div class="tile-body">
					<span class="price">From ₹3,499 / night</span>
					<ul><li>Separate living room</li><li>Full kitchen &amp; dining</li><li>Great for couples &amp; long stays</li></ul>
					<a class="btn btn-secondary btn-sm" href="#book">Book 1 BHK</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-2bhk">2 BHK Apartment</div>
				<div class="tile-body">
					<span class="price">From ₹5,499 / night</span>
					<ul><li>Two bedrooms, two baths</li><li>Full kitchen &amp; living area</li><li>Perfect for families &amp; teams</li></ul>
					<a class="btn btn-secondary btn-sm" href="#book">Book 2 BHK</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-premium">Premium Suite</div>
				<div class="tile-body">
					<span class="price">From ₹7,999 / night</span>
					<ul><li>Top-floor city views</li><li>Premium furnishings</li><li>Complimentary breakfast</li></ul>
					<a class="btn btn-secondary btn-sm" href="#book">Book Suite</a>
				</div>
			</article>
		</div>
	</section>

	<!-- LOCATIONS -->
	<section id="locations" aria-labelledby="locations-title">
		<div class="section-head">
			<h2 id="locations-title">Four addresses across Gurgaon</h2>
			<p>Minutes from business hubs, metro stations and the city's best food.</p>
		</div>
		<div class="grid-3">
			<article class="tile">
				<div class="tile-media m-golf">Golf Course Road</div>
				<div class="tile-body">
					<span>Premium tower next to fine dining, malls and rapid metro.</span>
					<a class="btn btn-secondary btn-sm" href="#book">Stay here</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-s39">Sector 39</div>
				<div class="tile-body">
					<span>Quiet residential block near Medanta and Subhash Chowk.</span>
					<a class="btn btn-secondary btn-sm" href="#book">Stay here</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-mg">MG Road</div>
				<div class="tile-body">
					<span>Steps from the metro and Gurgaon's classic high street.</span>
					<a class="btn btn-secondary btn-sm" href="#book">Stay here</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-cyber">Cyber City</div>
				<div class="tile-body">
					<span>Walk to work — right beside the DLF Cyber City offices.</span>
					<a class="btn btn-secondary btn-sm" href="#book">Stay here</a>
				</div>
			</article>
		</div>
	</section>

	<!-- AMENITIES -->
	<section id="amenities" class="card" aria-labelledby="amenities-title">
		<div class="section-head"><h2 id="amenities-title">Everything included, nothing to arrange</h2></div>
		<div class="amenities">
			<div class="amenity"><span class="icon" aria-hidden="true">⌂</span><div><strong>Fully furnished</strong><span>Move in with just your suitcase</span></div></div>
			<div class="amenity"><span class="icon" aria-hidden="true">⇡</span><div><strong>High-speed Wi-Fi</strong><span>Work-from-stay ready internet</span></div></div>
			<div class="amenity"><span class="icon" aria-hidden="true">✦</span><div><strong>Daily housekeeping</strong><span>Fresh linen and spotless rooms</span></div></div>
			<div class="amenity"><span class="icon" aria-hidden="true">☏</span><div><strong>24×7 front desk</strong><span>Real humans, any hour</span></div></div>
			<div class="amenity"><span class="icon" aria-hidden="true">♨</span><div><strong>Kitchen &amp; laundry</strong><span>Cook and wash on your schedule</span></div></div>
			<div class="amenity"><span class="icon" aria-hidden="true">⛨</span><div><strong>Secure access</strong><span>CCTV and keycard entry</span></div></div>
		</div>
	</section>

	<!-- TESTIMONIALS -->
	<section aria-labelledby="quotes-title">
		<div class="section-head"><h2 id="quotes-title">Guests keep coming back</h2></div>
		<div class="quotes">
			<blockquote>
				<p>"Stayed a full month for a project — the apartment was cleaner than my own flat and the Wi-Fi never dropped once."</p>
				<footer>— Corporate guest, Cyber City</footer>
			</blockquote>
			<blockquote>
				<p>"Booked a 2 BHK for my parents' visit. Check-in took two minutes and the team remembered my mother's tea preference."</p>
				<footer>— Family stay, Golf Course Road</footer>
			</blockquote>
			<blockquote>
				<p>"Feels like a hotel where you're allowed to live. The kitchen and laundry made a two-week stay effortless."</p>
				<footer>— Extended stay, Sector 39</footer>
			</blockquote>
		</div>
	</section>

	<!-- BOOKING -->
	<section id="book" class="card" aria-labelledby="book-title">
		<h2 id="book-title" style="font-size:22px;margin-bottom:8px;">Book your stay</h2>
		<p style="margin-bottom:16px;">Send us a booking request — our team confirms availability by email, usually within the hour.</p>

		<?php if ( isset( $_GET['ssz_error'] ) ) : ?>
			<div class="alert alert-error" role="alert"><?php echo esc_html( rawurldecode( sanitize_text_field( wp_unslash( $_GET['ssz_error'] ) ) ) ); ?></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['ssz_booked'] ) ) : ?>
			<div class="alert alert-success" role="status">🎉 Booking request
				<strong><?php echo esc_html( sanitize_text_field( wp_unslash( $_GET['ssz_booked'] ) ) ); ?></strong>
				received! A confirmation email is on its way to your inbox.</div>
		<?php endif; ?>

		<form class="form-grid" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="ssz_book">
			<?php wp_nonce_field( 'ssz_book', 'ssz_book_nonce' ); ?>

			<div class="form-row">
				<div class="field">
					<label for="ssz-name">Full name</label>
					<input id="ssz-name" name="ssz_name" type="text" autocomplete="name" required>
				</div>
				<div class="field">
					<label for="ssz-email">Email</label>
					<input id="ssz-email" name="ssz_email" type="email" autocomplete="email" required>
					<span class="hint">Booking confirmation is sent to this address.</span>
				</div>
			</div>
			<div class="form-row">
				<div class="field">
					<label for="ssz-phone">Phone</label>
					<input id="ssz-phone" name="ssz_phone" type="tel" autocomplete="tel" required>
				</div>
				<div class="field">
					<label for="ssz-guests">Guests</label>
					<select id="ssz-guests" name="ssz_guests">
						<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
							<option value="<?php echo esc_attr( $i ); ?>" <?php selected( $i, 2 ); ?>><?php echo esc_html( $i . ' guest' . ( $i > 1 ? 's' : '' ) ); ?></option>
						<?php endfor; ?>
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="field">
					<label for="ssz-property">Property</label>
					<select id="ssz-property" name="ssz_property">
						<?php foreach ( ssz_properties() as $property ) : ?>
							<option><?php echo esc_html( $property ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="field">
					<label for="ssz-apartment">Apartment type</label>
					<select id="ssz-apartment" name="ssz_apartment">
						<?php foreach ( ssz_apartments() as $apartment ) : ?>
							<option><?php echo esc_html( $apartment ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="field">
					<label for="ssz-checkin">Check-in</label>
					<input id="ssz-checkin" name="ssz_check_in" type="date" required
						value="<?php echo esc_attr( gmdate( 'Y-m-d' ) ); ?>" min="<?php echo esc_attr( gmdate( 'Y-m-d' ) ); ?>">
				</div>
				<div class="field">
					<label for="ssz-checkout">Check-out</label>
					<input id="ssz-checkout" name="ssz_check_out" type="date" required
						value="<?php echo esc_attr( gmdate( 'Y-m-d', time() + 2 * DAY_IN_SECONDS ) ); ?>" min="<?php echo esc_attr( gmdate( 'Y-m-d' ) ); ?>">
				</div>
			</div>
			<div class="field">
				<label for="ssz-notes">Special requests <span style="font-weight:400;">(optional)</span></label>
				<textarea id="ssz-notes" name="ssz_notes" maxlength="500" placeholder="Early check-in, extra bed, airport pickup…"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Request booking</button>
		</form>
	</section>

</main>

<?php get_footer(); ?>
