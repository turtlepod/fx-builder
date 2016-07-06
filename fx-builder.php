<?php
/**
 * Plugin Name: f(x) Builder
 * Plugin URI: http://genbumedia.com/plugins/fx-builder/
 * Description: Simple Page Builder Plugin. The one you can actually use.
 * Version: 1.0.2
 * Author: David Chandra Purnama
 * Author URI: http://shellcreeper.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: fx-wpshop
 * Domain Path: /languages/
 *
 * @author David Chandra Purnama <david@genbumedia.com>
 * @copyright Copyright (c) 2016, Genbu Media
**/
if ( ! defined( 'WPINC' ) ) { die; }


/* Constants
------------------------------------------ */

define( 'FX_BUILDER_VERSION', '1.0.0' );
define( 'FX_BUILDER_PLUGIN', plugin_basename( __FILE__ ) );
define( 'FX_BUILDER_FILE', __FILE__ );

define( 'FX_BUILDER_PATH', trailingslashit( plugin_dir_path(__FILE__) ) );
define( 'FX_BUILDER_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );


/* Includes
------------------------------------------ */

/* The Page Builder */
require_once( FX_BUILDER_PATH . 'includes/builder/index.php' );
















