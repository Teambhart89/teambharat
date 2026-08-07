<?php
/**
 * PlantGift Pro theme bootstrap.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

define( 'PLANTGIFT_PRO_VERSION', '1.0.0' );
define( 'PLANTGIFT_PRO_DIR', get_template_directory() );
define( 'PLANTGIFT_PRO_URI', get_template_directory_uri() );

require_once PLANTGIFT_PRO_DIR . '/inc/setup.php';
require_once PLANTGIFT_PRO_DIR . '/inc/enqueue.php';
require_once PLANTGIFT_PRO_DIR . '/inc/template-tags.php';
require_once PLANTGIFT_PRO_DIR . '/inc/customizer.php';
require_once PLANTGIFT_PRO_DIR . '/inc/woocommerce.php';
require_once PLANTGIFT_PRO_DIR . '/inc/cro.php';
require_once PLANTGIFT_PRO_DIR . '/inc/seo.php';
require_once PLANTGIFT_PRO_DIR . '/inc/performance.php';
