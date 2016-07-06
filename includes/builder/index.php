<?php
/**
 * Page Builder
**/
namespace fx_builder\builder;
if ( ! defined( 'WPINC' ) ) { die; }


/* Constants
------------------------------------------ */

define( __NAMESPACE__ . '\PATH', trailingslashit( plugin_dir_path(__FILE__) ) );
define( __NAMESPACE__ . '\URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( __NAMESPACE__ . '\VERSION', FX_BUILDER_VERSION );


/* Load FIles
------------------------------------------ */

/* The Page Builder */
require_once( PATH . 'page-builder.php' );

/* Scripts */
require_once( PATH . 'scripts.php' );


/* Setup
------------------------------------------ */

/* Init */
//add_action( 'init', __NAMESPACE__ . '\init' );

/**
 * Init Hook to Setup All
 * @since 1.0.0
 */
function init(){

	/* TEMP: remove editor */
	remove_post_type_support( 'page', 'editor' );
}






