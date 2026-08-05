<?php
/**
 * Shortcodes for dropping gifting blocks into any page.
 *
 * @package PlantGift_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Shortcodes.
 */
class PGC_Shortcodes {

	/**
	 * Register shortcodes.
	 */
	public static function init() {
		add_shortcode( 'plantgift_categories', array( __CLASS__, 'categories' ) );
		add_shortcode( 'plantgift_faq', array( __CLASS__, 'faq' ) );
		add_shortcode( 'plantgift_bulk_table', array( __CLASS__, 'bulk_table' ) );
		add_shortcode( 'plantgift_pot_guide', array( __CLASS__, 'pot_guide' ) );
		add_shortcode( 'plantgift_cta', array( __CLASS__, 'cta' ) );
	}

	/**
	 * Category grid.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function categories( $atts ) {
		if ( ! taxonomy_exists( 'product_cat' ) ) {
			return '';
		}

		$atts = shortcode_atts(
			array(
				'limit'   => 8,
				'slugs'   => '',
				'columns' => 4,
			),
			$atts,
			'plantgift_categories'
		);

		$args = array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'number'     => absint( $atts['limit'] ),
			'orderby'    => 'menu_order',
			'exclude'    => array( get_option( 'default_product_cat' ) ),
		);

		if ( $atts['slugs'] ) {
			$args['slug']   = array_map( 'sanitize_title', array_map( 'trim', explode( ',', $atts['slugs'] ) ) );
			$args['number'] = 0;
		}

		$terms = get_terms( $args );
		if ( ! $terms || is_wp_error( $terms ) ) {
			return '';
		}

		$columns = max( 2, min( 4, absint( $atts['columns'] ) ) );

		ob_start();
		echo '<div class="pg-grid pg-grid--' . esc_attr( $columns ) . '">';
		foreach ( $terms as $term ) {
			$link     = get_term_link( $term );
			$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
			?>
			<article class="pg-card">
				<a class="pg-card__media" href="<?php echo esc_url( is_wp_error( $link ) ? '#' : $link ); ?>" tabindex="-1" aria-hidden="true">
					<?php
					if ( $thumb_id ) {
						echo wp_get_attachment_image( $thumb_id, 'plantgift-card', false, array( 'loading' => 'lazy', 'alt' => esc_attr( $term->name ) ) );
					}
					?>
				</a>
				<div class="pg-card__body">
					<h3 class="pg-card__title"><a href="<?php echo esc_url( is_wp_error( $link ) ? '#' : $link ); ?>"><?php echo esc_html( $term->name ); ?></a></h3>
					<?php $intro = get_term_meta( $term->term_id, '_pg_intro', true ); ?>
					<?php if ( $intro ) : ?>
						<p class="pg-card__text"><?php echo esc_html( wp_trim_words( $intro, 18 ) ); ?></p>
					<?php endif; ?>
				</div>
			</article>
			<?php
		}
		echo '</div>';

		return ob_get_clean();
	}

	/**
	 * FAQ accordion pulled from a page or category.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function faq( $atts ) {
		$atts = shortcode_atts(
			array(
				'page'     => '',
				'category' => '',
				'title'    => '',
				'schema'   => 'yes',
			),
			$atts,
			'plantgift_faq'
		);

		$faqs = array();

		if ( $atts['page'] ) {
			$page = get_page_by_path( sanitize_title( $atts['page'] ), OBJECT, 'page' );
			if ( $page ) {
				$faqs = get_post_meta( $page->ID, '_pg_faqs', true );
			}
		} elseif ( $atts['category'] ) {
			$term = get_term_by( 'slug', sanitize_title( $atts['category'] ), 'product_cat' );
			if ( $term ) {
				$faqs = get_term_meta( $term->term_id, '_pg_faqs', true );
			}
		} else {
			$faqs = get_post_meta( get_the_ID(), '_pg_faqs', true );
		}

		if ( ! is_array( $faqs ) || ! $faqs ) {
			return '';
		}

		ob_start();
		if ( function_exists( 'plantgift_pro_faq_list' ) ) {
			plantgift_pro_faq_list( $faqs, $atts['title'], 'h2' );
		}
		if ( 'yes' === $atts['schema'] ) {
			PGC_Schema::print_faq_schema( $faqs );
		}
		return ob_get_clean();
	}

	/**
	 * Bulk pricing slab table.
	 *
	 * @return string
	 */
	public static function bulk_table() {
		$rows = array(
			array( __( '25 to 49 units', 'plantgift-core' ), '5%', __( 'Small teams and pilot rounds', 'plantgift-core' ) ),
			array( __( '50 to 99 units', 'plantgift-core' ), '10%', __( 'Single department gifting', 'plantgift-core' ) ),
			array( __( '100 to 249 units', 'plantgift-core' ), '15%', __( 'Company wide for a mid size firm', 'plantgift-core' ) ),
			array( __( '250 to 499 units', 'plantgift-core' ), '20%', __( 'Multi office festive rounds', 'plantgift-core' ) ),
			array( __( '500 units and above', 'plantgift-core' ), __( 'Custom quote', 'plantgift-core' ), __( 'Enterprise rounds and events', 'plantgift-core' ) ),
		);

		ob_start();
		?>
		<div class="pg-table-scroll">
			<table>
				<caption class="screen-reader-text"><?php esc_html_e( 'Bulk pricing slabs', 'plantgift-core' ); ?></caption>
				<thead>
					<tr>
						<th scope="col"><?php esc_html_e( 'Quantity', 'plantgift-core' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Discount', 'plantgift-core' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Who this fits', 'plantgift-core' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $row ) : ?>
						<tr>
							<th scope="row"><?php echo esc_html( $row[0] ); ?></th>
							<td><?php echo esc_html( $row[1] ); ?></td>
							<td><?php echo esc_html( $row[2] ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Pot size and material guide.
	 *
	 * @return string
	 */
	public static function pot_guide() {
		$rows = array(
			array( __( '3 inch', 'plantgift-core' ), __( 'Event giveaways and table favours', 'plantgift-core' ), __( 'Terracotta or jute', 'plantgift-core' ) ),
			array( __( '4 inch', 'plantgift-core' ), __( 'Employee welcome kits and desks', 'plantgift-core' ), __( 'Glazed ceramic', 'plantgift-core' ) ),
			array( __( '5 inch', 'plantgift-core' ), __( 'Work anniversaries and milestones', 'plantgift-core' ), __( 'Ceramic or concrete', 'plantgift-core' ) ),
			array( __( '6 inch', 'plantgift-core' ), __( 'Client gifting and cabins', 'plantgift-core' ), __( 'Concrete or brushed metal', 'plantgift-core' ) ),
			array( __( '8 inch', 'plantgift-core' ), __( 'Reception areas and leadership gifts', 'plantgift-core' ), __( 'Concrete or self watering', 'plantgift-core' ) ),
		);

		ob_start();
		?>
		<div class="pg-table-scroll">
			<table>
				<caption class="screen-reader-text"><?php esc_html_e( 'Pot size guide', 'plantgift-core' ); ?></caption>
				<thead>
					<tr>
						<th scope="col"><?php esc_html_e( 'Pot size', 'plantgift-core' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Best for', 'plantgift-core' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Suggested material', 'plantgift-core' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $row ) : ?>
						<tr>
							<th scope="row"><?php echo esc_html( $row[0] ); ?></th>
							<td><?php echo esc_html( $row[1] ); ?></td>
							<td><?php echo esc_html( $row[2] ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Call to action block.
	 *
	 * @param array  $atts    Attributes.
	 * @param string $content Inner text.
	 * @return string
	 */
	public static function cta( $atts, $content = '' ) {
		$atts = shortcode_atts(
			array(
				'title'  => __( 'Planning a gifting round?', 'plantgift-core' ),
				'button' => __( 'Request a quote', 'plantgift-core' ),
				'url'    => home_url( '/contact/' ),
			),
			$atts,
			'plantgift_cta'
		);

		ob_start();
		?>
		<div class="pg-cta">
			<h2><?php echo esc_html( $atts['title'] ); ?></h2>
			<?php if ( $content ) : ?>
				<p><?php echo esc_html( wp_strip_all_tags( $content ) ); ?></p>
			<?php endif; ?>
			<div class="pg-btn-row">
				<a class="pg-btn pg-btn--light pg-btn--lg" href="<?php echo esc_url( $atts['url'] ); ?>"><?php echo esc_html( $atts['button'] ); ?></a>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
