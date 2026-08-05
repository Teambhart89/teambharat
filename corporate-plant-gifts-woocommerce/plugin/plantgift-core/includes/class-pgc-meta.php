<?php
/**
 * Editable FAQ and SEO fields for pages and product categories.
 *
 * @package PlantGift_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Meta boxes and term fields.
 */
class PGC_Meta {

	/**
	 * Hook in.
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_box' ) );
		add_action( 'save_post_page', array( __CLASS__, 'save_box' ) );

		add_action( 'product_cat_add_form_fields', array( __CLASS__, 'term_add_fields' ) );
		add_action( 'product_cat_edit_form_fields', array( __CLASS__, 'term_edit_fields' ), 20 );
		add_action( 'created_product_cat', array( __CLASS__, 'save_term_fields' ) );
		add_action( 'edited_product_cat', array( __CLASS__, 'save_term_fields' ) );
	}

	/**
	 * FAQ editor on pages.
	 */
	public static function register_box() {
		add_meta_box(
			'pgc_faqs',
			__( 'Questions and answers', 'plantgift-core' ),
			array( __CLASS__, 'render_box' ),
			'page',
			'normal',
			'default'
		);
	}

	/**
	 * Render the FAQ editor.
	 *
	 * @param WP_Post $post Current page.
	 */
	public static function render_box( $post ) {
		wp_nonce_field( 'pgc_faqs_save', 'pgc_faqs_nonce' );

		$faqs = get_post_meta( $post->ID, '_pg_faqs', true );
		$text = '';
		if ( is_array( $faqs ) ) {
			foreach ( $faqs as $faq ) {
				if ( empty( $faq['q'] ) || empty( $faq['a'] ) ) {
					continue;
				}
				$text .= 'Q: ' . $faq['q'] . "\n" . 'A: ' . $faq['a'] . "\n\n";
			}
		}
		?>
		<p>
			<?php esc_html_e( 'One question and answer per block. Start questions with "Q:" and answers with "A:", separated by a blank line. These render as an accordion and are also published as FAQ structured data.', 'plantgift-core' ); ?>
		</p>
		<textarea name="pgc_faqs" rows="16" style="width:100%;font-family:monospace;font-size:13px;"><?php echo esc_textarea( trim( $text ) ); ?></textarea>

		<hr>
		<p>
			<label for="pgc-eyebrow"><strong><?php esc_html_e( 'Eyebrow label', 'plantgift-core' ); ?></strong></label><br>
			<input type="text" id="pgc-eyebrow" name="pgc_eyebrow" style="width:100%;max-width:32rem;" value="<?php echo esc_attr( get_post_meta( $post->ID, '_pg_eyebrow', true ) ); ?>">
			<span class="description"><?php esc_html_e( 'Small label shown above the H1 on service pages.', 'plantgift-core' ); ?></span>
		</p>
		<p>
			<label for="pgc-highlights"><strong><?php esc_html_e( 'Highlight strip', 'plantgift-core' ); ?></strong></label><br>
			<?php $highlights = get_post_meta( $post->ID, '_pg_highlights', true ); ?>
			<input type="text" id="pgc-highlights" name="pgc_highlights" style="width:100%;max-width:48rem;" value="<?php echo esc_attr( is_array( $highlights ) ? implode( ', ', $highlights ) : '' ); ?>">
			<span class="description"><?php esc_html_e( 'Up to four short points, separated by commas.', 'plantgift-core' ); ?></span>
		</p>
		<p>
			<label for="pgc-cats"><strong><?php esc_html_e( 'Related category slugs', 'plantgift-core' ); ?></strong></label><br>
			<?php $cats = get_post_meta( $post->ID, '_pg_related_cats', true ); ?>
			<input type="text" id="pgc-cats" name="pgc_related_cats" style="width:100%;max-width:48rem;" value="<?php echo esc_attr( is_array( $cats ) ? implode( ', ', $cats ) : '' ); ?>">
			<span class="description"><?php esc_html_e( 'Product category slugs shown in the sidebar and in the Service structured data.', 'plantgift-core' ); ?></span>
		</p>
		<p>
			<label for="pgc-meta-title"><strong><?php esc_html_e( 'Meta title', 'plantgift-core' ); ?></strong></label><br>
			<input type="text" id="pgc-meta-title" name="pgc_meta_title" style="width:100%;max-width:48rem;" maxlength="70" value="<?php echo esc_attr( get_post_meta( $post->ID, '_pg_meta_title', true ) ); ?>">
			<span class="description"><?php esc_html_e( 'Up to 60 characters works best. Leave empty to use the page title.', 'plantgift-core' ); ?></span>
		</p>
		<?php
	}

	/**
	 * Save the FAQ editor.
	 *
	 * @param int $post_id Page id.
	 */
	public static function save_box( $post_id ) {
		if ( ! isset( $_POST['pgc_faqs_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['pgc_faqs_nonce'] ) ), 'pgc_faqs_save' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['pgc_faqs'] ) ) {
			$raw = wp_kses_post( wp_unslash( $_POST['pgc_faqs'] ) );
			update_post_meta( $post_id, '_pg_faqs', self::parse_faqs( $raw ) );
		}

		if ( isset( $_POST['pgc_eyebrow'] ) ) {
			update_post_meta( $post_id, '_pg_eyebrow', sanitize_text_field( wp_unslash( $_POST['pgc_eyebrow'] ) ) );
		}

		if ( isset( $_POST['pgc_meta_title'] ) ) {
			update_post_meta( $post_id, '_pg_meta_title', sanitize_text_field( wp_unslash( $_POST['pgc_meta_title'] ) ) );
		}

		if ( isset( $_POST['pgc_highlights'] ) ) {
			$list = array_filter( array_map( 'trim', explode( ',', sanitize_text_field( wp_unslash( $_POST['pgc_highlights'] ) ) ) ) );
			update_post_meta( $post_id, '_pg_highlights', array_slice( $list, 0, 4 ) );
		}

		if ( isset( $_POST['pgc_related_cats'] ) ) {
			$list = array_filter( array_map( 'sanitize_title', array_map( 'trim', explode( ',', sanitize_text_field( wp_unslash( $_POST['pgc_related_cats'] ) ) ) ) ) );
			update_post_meta( $post_id, '_pg_related_cats', $list );
		}
	}

	/**
	 * Turn the plain text FAQ format into an array.
	 *
	 * @param string $raw Textarea contents.
	 * @return array
	 */
	public static function parse_faqs( $raw ) {
		$faqs     = array();
		$question = '';
		$answer   = '';

		foreach ( preg_split( '/\r\n|\r|\n/', (string) $raw ) as $line ) {
			$line = trim( $line );

			if ( 0 === stripos( $line, 'Q:' ) ) {
				if ( $question && $answer ) {
					$faqs[] = array( 'q' => $question, 'a' => trim( $answer ) );
				}
				$question = trim( substr( $line, 2 ) );
				$answer   = '';
				continue;
			}

			if ( 0 === stripos( $line, 'A:' ) ) {
				$answer = trim( substr( $line, 2 ) );
				continue;
			}

			if ( '' !== $line && $answer ) {
				$answer .= ' ' . $line;
			}
		}

		if ( $question && $answer ) {
			$faqs[] = array( 'q' => $question, 'a' => trim( $answer ) );
		}

		return $faqs;
	}

	/**
	 * Fields on the add category screen.
	 */
	public static function term_add_fields() {
		?>
		<div class="form-field">
			<label for="pgc_meta_description"><?php esc_html_e( 'Meta description', 'plantgift-core' ); ?></label>
			<textarea name="pgc_meta_description" id="pgc_meta_description" rows="3" maxlength="160"></textarea>
			<p><?php esc_html_e( 'Aim for 140 to 158 characters.', 'plantgift-core' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Fields on the edit category screen.
	 *
	 * @param WP_Term $term Current term.
	 */
	public static function term_edit_fields( $term ) {
		$intro = get_term_meta( $term->term_id, '_pg_intro', true );
		$body  = get_term_meta( $term->term_id, '_pg_seo_body', true );
		$title = get_term_meta( $term->term_id, '_pg_meta_title', true );
		$desc  = get_term_meta( $term->term_id, '_pg_meta_description', true );
		$faqs  = get_term_meta( $term->term_id, '_pg_faqs', true );

		$faq_text = '';
		if ( is_array( $faqs ) ) {
			foreach ( $faqs as $faq ) {
				if ( empty( $faq['q'] ) || empty( $faq['a'] ) ) {
					continue;
				}
				$faq_text .= 'Q: ' . $faq['q'] . "\n" . 'A: ' . $faq['a'] . "\n\n";
			}
		}

		wp_nonce_field( 'pgc_term_save', 'pgc_term_nonce' );
		?>
		<tr class="form-field">
			<th scope="row"><label for="pgc_meta_title"><?php esc_html_e( 'Meta title', 'plantgift-core' ); ?></label></th>
			<td>
				<input type="text" name="pgc_meta_title" id="pgc_meta_title" value="<?php echo esc_attr( $title ); ?>" maxlength="70">
				<p class="description"><?php esc_html_e( 'Shown in search results. Up to 60 characters works best.', 'plantgift-core' ); ?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="pgc_meta_description"><?php esc_html_e( 'Meta description', 'plantgift-core' ); ?></label></th>
			<td>
				<textarea name="pgc_meta_description" id="pgc_meta_description" rows="3" maxlength="160"><?php echo esc_textarea( $desc ); ?></textarea>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="pgc_intro"><?php esc_html_e( 'Intro under the H1', 'plantgift-core' ); ?></label></th>
			<td>
				<textarea name="pgc_intro" id="pgc_intro" rows="3"><?php echo esc_textarea( $intro ); ?></textarea>
				<p class="description"><?php esc_html_e( 'One or two sentences shown above the product grid.', 'plantgift-core' ); ?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="pgc_seo_body"><?php esc_html_e( 'Long form body', 'plantgift-core' ); ?></label></th>
			<td>
				<textarea name="pgc_seo_body" id="pgc_seo_body" rows="14" style="font-family:monospace;font-size:12px;"><?php echo esc_textarea( $body ); ?></textarea>
				<p class="description"><?php esc_html_e( 'HTML allowed. Rendered below the product grid so shoppers reach the catalogue first. Start headings at H2.', 'plantgift-core' ); ?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="pgc_faqs"><?php esc_html_e( 'Questions and answers', 'plantgift-core' ); ?></label></th>
			<td>
				<textarea name="pgc_faqs" id="pgc_faqs" rows="10" style="font-family:monospace;font-size:12px;"><?php echo esc_textarea( trim( $faq_text ) ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Start questions with "Q:" and answers with "A:", separated by a blank line.', 'plantgift-core' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Save the category fields.
	 *
	 * @param int $term_id Term id.
	 */
	public static function save_term_fields( $term_id ) {
		if ( isset( $_POST['pgc_term_nonce'] ) && ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['pgc_term_nonce'] ) ), 'pgc_term_save' ) ) {
			return;
		}
		if ( ! current_user_can( 'manage_product_terms' ) && ! current_user_can( 'manage_categories' ) ) {
			return;
		}

		if ( isset( $_POST['pgc_meta_title'] ) ) {
			update_term_meta( $term_id, '_pg_meta_title', sanitize_text_field( wp_unslash( $_POST['pgc_meta_title'] ) ) );
		}
		if ( isset( $_POST['pgc_meta_description'] ) ) {
			update_term_meta( $term_id, '_pg_meta_description', sanitize_textarea_field( wp_unslash( $_POST['pgc_meta_description'] ) ) );
		}
		if ( isset( $_POST['pgc_intro'] ) ) {
			update_term_meta( $term_id, '_pg_intro', sanitize_textarea_field( wp_unslash( $_POST['pgc_intro'] ) ) );
		}
		if ( isset( $_POST['pgc_seo_body'] ) ) {
			update_term_meta( $term_id, '_pg_seo_body', wp_kses_post( wp_unslash( $_POST['pgc_seo_body'] ) ) );
		}
		if ( isset( $_POST['pgc_faqs'] ) ) {
			update_term_meta( $term_id, '_pg_faqs', self::parse_faqs( wp_kses_post( wp_unslash( $_POST['pgc_faqs'] ) ) ) );
		}
	}
}
