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
		<span class="eyebrow">Budget &amp; Luxury Hotels · Studios · Serviced Apartments · Gurgaon</span>
		<h1 id="hero-title">Your address in Gurgaon, from ₹1,256 a night</h1>
		<p>15+ properties and 700+ rooms across Golf Course Road, Sector 42, Golf Course
		Extension Road and Sohna Road — with housekeeping, high-speed Wi-Fi and a 24×7
		front desk, whether you stay a night or a quarter.</p>
		<div class="hero-cta">
			<a class="btn btn-primary" href="#book">Book your stay</a>
			<a class="btn btn-ghost" href="#apartments">Explore apartments</a>
		</div>
	</section>

	<!-- APARTMENTS -->
	<section id="apartments" aria-labelledby="apartments-title">
		<div class="section-head">
			<h2 id="apartments-title">Choose your space</h2>
			<p>Every room is fully furnished with hotel-grade linen; studios and apartments add
			a kitchen and workspace. Starting rates below are indicative — the exact tariff is
			confirmed on your booking email.</p>
		</div>
		<div class="grid-3">
			<article class="tile">
				<div class="tile-media m-deluxe">Deluxe Room</div>
				<div class="tile-body">
					<span class="price">From ₹1,256 / night</span>
					<ul><li>Queen bed + work desk</li><li>Smart TV &amp; high-speed Wi-Fi</li><li>Best-value business stay</li></ul>
					<a class="btn btn-secondary btn-sm" href="#book">Book Deluxe</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-studio">Executive Studio</div>
				<div class="tile-body">
					<span class="price">From ₹1,799 / night</span>
					<ul><li>Kitchenette &amp; dining nook</li><li>Balcony in select units</li><li>Ideal for solo travellers</li></ul>
					<a class="btn btn-secondary btn-sm" href="#book">Book Studio</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-1bhk">1 BHK Serviced Apartment</div>
				<div class="tile-body">
					<span class="price">From ₹2,499 / night</span>
					<ul><li>Separate living room</li><li>Fully equipped kitchen</li><li>Great for couples &amp; long stays</li></ul>
					<a class="btn btn-secondary btn-sm" href="#book">Book 1 BHK</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-premium">Premium Suite</div>
				<div class="tile-body">
					<span class="price">From ₹3,499 / night</span>
					<ul><li>Premium furnishings &amp; views</li><li>Buffet breakfast included</li><li>Extra bed ₹1,500–2,000 / night</li></ul>
					<a class="btn btn-secondary btn-sm" href="#book">Book Suite</a>
				</div>
			</article>
		</div>
	</section>

	<!-- LOCATIONS -->
	<section id="locations" aria-labelledby="locations-title">
		<div class="section-head">
			<h2 id="locations-title">Our properties across Gurgaon</h2>
			<p>From budget-friendly Express stays to Premier serviced apartments — minutes from
			business hubs, hospitals, metro stations and the city's best food.</p>
		</div>
		<div class="grid-3">
			<article class="tile">
				<div class="tile-media m-express">Saltstayz Express</div>
				<div class="tile-body">
					<span class="price">From ₹1,256 / night</span>
					<span>Golf Course Road &amp; DLF Phase-1 — budget rooms on the city's liveliest strip.</span>
					<a class="btn btn-secondary btn-sm" href="#book">Stay here</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-select">Saltstayz Select</div>
				<div class="tile-body">
					<span class="price">From ₹1,999 / night</span>
					<span>Galleria Market &amp; Golf Course Road — steps from shopping and cafés.</span>
					<a class="btn btn-secondary btn-sm" href="#book">Stay here</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-prem42">Saltstayz Premier</div>
				<div class="tile-body">
					<span class="price">From ₹2,499 / night</span>
					<span>Golf Course Road &amp; Sector 42 — next to the DLF Sector 42–43 Rapid Metro station.</span>
					<a class="btn btn-secondary btn-sm" href="#book">Stay here</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-premext">Saltstayz Premier</div>
				<div class="tile-body">
					<span class="price">From ₹2,799 / night</span>
					<span>Golf Course Extension Road (Sector 39) — near Unitech Cyber Park, built for business stays.</span>
					<a class="btn btn-secondary btn-sm" href="#book">Stay here</a>
				</div>
			</article>
			<article class="tile">
				<div class="tile-media m-sohna">Saltstayz Studio Apartment</div>
				<div class="tile-body">
					<span class="price">From ₹1,799 / night</span>
					<span>Sohna Road — minutes from Medanta and Artemis hospitals, with kitchens for long stays.</span>
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
				<footer>— Corporate guest, Saltstayz Premier (Golf Course Extension Road)</footer>
			</blockquote>
			<blockquote>
				<p>"Booked a 2 BHK for my parents' visit. Check-in took two minutes and the team remembered my mother's tea preference."</p>
				<footer>— Family stay, Saltstayz Select (Galleria Market)</footer>
			</blockquote>
			<blockquote>
				<p>"Feels like a hotel where you're allowed to live. The kitchen and laundry made a two-week stay effortless."</p>
				<footer>— Extended stay, Saltstayz Studio Apartment (Sohna Road)</footer>
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
