<?php
/**
 * Plugin Name: f(x) Builder
 * Plugin URI: http://genbumedia.com/plugins/fx-builder/
 * Description: A simple page builder plugin. The one you can actually use. (Alpha Version)
 * Version: 1.0.2
 * Author: David Chandra Purnama
 * Author URI: http://shellcreeper.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: fx-builder
 * Domain Path: /languages/
 *
 * @author David Chandra Purnama <david@genbumedia.com>
 * @copyright Copyright (c) 2016, Genbu Media
**/
if ( ! defined( 'WPINC' ) ) { die; }


/* Constants
------------------------------------------ */

define( 'FX_BUILDER_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'FX_BUILDER_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'FX_BUILDER_FILE', __FILE__ );
define( 'FX_BUILDER_PLUGIN', plugin_basename( __FILE__ ) );
define( 'FX_BUILDER_VERSION', '1.0.2' );


/* Init
------------------------------------------ */

/* Load plugin in "plugins_loaded" hook */
add_action( 'plugins_loaded', 'fx_builder_init' );

/**
 * Plugin Init
 * @since 0.1.0
 */
function fx_builder_init(){

	/* Var */
	$uri      = FX_BUILDER_URI;
	$path     = FX_BUILDER_PATH;
	$file     = FX_BUILDER_FILE;
	$plugin   = FX_BUILDER_PLUGIN;
	$version  = FX_BUILDER_VERSION;

	/* Prepare */
	require_once( $path . 'includes/prepare.php' );
	if( ! $sys_req->check() ) return;

	/* Setup */
	require_once( $path . 'includes/setup.php' );
}
