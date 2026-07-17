<?php
/**
 * Astro tools: shortcode-based calculators.
 *
 * [epb_nakshatra_calculator], [epb_rashi_calculator],
 * [epb_mangal_dosha_calculator], [epb_kaalsarp_calculator]
 *
 * All computation happens in the visitor's browser (assets/astro.js);
 * no external API and no data is sent to any server.
 *
 * @package epoojabooking-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * City presets: name, latitude, longitude east, UTC offset minutes.
 *
 * @return array[]
 */
function epb_astro_cities() {
	return array(
		array( 'New Delhi', 28.6139, 77.2090, 330 ),
		array( 'Mumbai', 19.0760, 72.8777, 330 ),
		array( 'Kolkata', 22.5726, 88.3639, 330 ),
		array( 'Chennai', 13.0827, 80.2707, 330 ),
		array( 'Bengaluru', 12.9716, 77.5946, 330 ),
		array( 'Hyderabad', 17.3850, 78.4867, 330 ),
		array( 'Ahmedabad', 23.0225, 72.5714, 330 ),
		array( 'Pune', 18.5204, 73.8567, 330 ),
		array( 'Jaipur', 26.9124, 75.7873, 330 ),
		array( 'Lucknow', 26.8467, 80.9462, 330 ),
		array( 'Varanasi', 25.3176, 82.9739, 330 ),
		array( 'Prayagraj', 25.4358, 81.8463, 330 ),
		array( 'Patna', 25.5941, 85.1376, 330 ),
		array( 'Bhopal', 23.2599, 77.4126, 330 ),
		array( 'Ujjain', 23.1793, 75.7849, 330 ),
		array( 'Indore', 22.7196, 75.8577, 330 ),
		array( 'Chandigarh', 30.7333, 76.7794, 330 ),
		array( 'Guwahati', 26.1445, 91.7362, 330 ),
		array( 'Kochi', 9.9312, 76.2673, 330 ),
		array( 'Srinagar', 34.0837, 74.7973, 330 ),
		array( 'Dubai', 25.2048, 55.2708, 240 ),
		array( 'Singapore', 1.3521, 103.8198, 480 ),
		array( 'London', 51.5074, -0.1278, 0 ),
		array( 'New York', 40.7128, -74.0060, -300 ),
		array( 'Toronto', 43.6532, -79.3832, -300 ),
		array( 'Sydney', -33.8688, 151.2093, 600 ),
	);
}

/**
 * Render a calculator form for a tool.
 *
 * @param string $tool One of nakshatra|rashi|mangal|kaalsarp.
 * @param string $button Button label.
 * @return string
 */
function epb_astro_form( $tool, $button ) {
	wp_enqueue_style( 'epb-astro' );
	wp_enqueue_script( 'epb-astro' );

	$timezones = array(
		'330'  => 'India (IST, UTC+5:30)',
		'345'  => 'Nepal (UTC+5:45)',
		'240'  => 'UAE (UTC+4)',
		'480'  => 'Singapore / Malaysia (UTC+8)',
		'0'    => 'UK (GMT, UTC+0)',
		'60'   => 'UK Summer / Central Europe (UTC+1)',
		'-300' => 'US Eastern (UTC-5)',
		'-360' => 'US Central (UTC-6)',
		'-480' => 'US Pacific (UTC-8)',
		'600'  => 'Sydney (UTC+10)',
	);

	ob_start();
	?>
	<div class="epb-astro-tool">
		<form class="epb-form epb-astro-form" data-tool="<?php echo esc_attr( $tool ); ?>" novalidate>
			<div class="epb-form-row">
				<p class="epb-field">
					<label for="epb-<?php echo esc_attr( $tool ); ?>-dob"><?php esc_html_e( 'Date of Birth', 'epoojabooking-core' ); ?> <span class="epb-required" aria-hidden="true">*</span></label>
					<input id="epb-<?php echo esc_attr( $tool ); ?>-dob" name="dob" type="date" required>
				</p>
				<p class="epb-field">
					<label for="epb-<?php echo esc_attr( $tool ); ?>-tob"><?php esc_html_e( 'Time of Birth', 'epoojabooking-core' ); ?> <span class="epb-required" aria-hidden="true">*</span></label>
					<input id="epb-<?php echo esc_attr( $tool ); ?>-tob" name="tob" type="time" required>
					<span class="epb-help"><?php esc_html_e( 'As exact as possible; the Moon changes sign every 2 to 3 days.', 'epoojabooking-core' ); ?></span>
				</p>
			</div>

			<p class="epb-field">
				<label for="epb-<?php echo esc_attr( $tool ); ?>-city"><?php esc_html_e( 'Birth City', 'epoojabooking-core' ); ?></label>
				<select id="epb-<?php echo esc_attr( $tool ); ?>-city" name="city">
					<option value=""><?php esc_html_e( 'Choose a city or enter coordinates below', 'epoojabooking-core' ); ?></option>
					<?php foreach ( epb_astro_cities() as $city ) : ?>
						<option data-lat="<?php echo esc_attr( $city[1] ); ?>" data-lon="<?php echo esc_attr( $city[2] ); ?>" data-tz="<?php echo esc_attr( $city[3] ); ?>"><?php echo esc_html( $city[0] ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<div class="epb-form-row">
				<p class="epb-field">
					<label for="epb-<?php echo esc_attr( $tool ); ?>-lat"><?php esc_html_e( 'Latitude', 'epoojabooking-core' ); ?></label>
					<input id="epb-<?php echo esc_attr( $tool ); ?>-lat" name="latitude" type="text" inputmode="decimal" placeholder="28.61">
				</p>
				<p class="epb-field">
					<label for="epb-<?php echo esc_attr( $tool ); ?>-lon"><?php esc_html_e( 'Longitude (east positive)', 'epoojabooking-core' ); ?></label>
					<input id="epb-<?php echo esc_attr( $tool ); ?>-lon" name="longitude" type="text" inputmode="decimal" placeholder="77.20">
				</p>
			</div>

			<p class="epb-field">
				<label for="epb-<?php echo esc_attr( $tool ); ?>-tz"><?php esc_html_e( 'Time Zone of Birth', 'epoojabooking-core' ); ?> <span class="epb-required" aria-hidden="true">*</span></label>
				<select id="epb-<?php echo esc_attr( $tool ); ?>-tz" name="tz" required>
					<?php foreach ( $timezones as $value => $label ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( '330', $value ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<button type="submit" class="epb-btn epb-btn-primary"><?php echo esc_html( $button ); ?></button>
			<p class="epb-help epb-secure-note"><?php esc_html_e( 'Free to use. The calculation runs in your browser and your birth details are not stored.', 'epoojabooking-core' ); ?></p>
		</form>
		<div class="epb-astro-result" role="status" aria-live="polite" hidden></div>
	</div>
	<?php
	return ob_get_clean();
}

add_shortcode( 'epb_nakshatra_calculator', function () {
	return epb_astro_form( 'nakshatra', __( 'Find My Nakshatra', 'epoojabooking-core' ) );
} );

add_shortcode( 'epb_rashi_calculator', function () {
	return epb_astro_form( 'rashi', __( 'Find My Moon Sign', 'epoojabooking-core' ) );
} );

add_shortcode( 'epb_mangal_dosha_calculator', function () {
	return epb_astro_form( 'mangal', __( 'Check Mangal Dosha', 'epoojabooking-core' ) );
} );

add_shortcode( 'epb_kaalsarp_calculator', function () {
	return epb_astro_form( 'kaalsarp', __( 'Check Kaal Sarp Dosha', 'epoojabooking-core' ) );
} );
