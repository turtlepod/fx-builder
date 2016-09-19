<?php
/**
 * Setup Builder NameSpace
 * @since 1.0.0
**/
namespace fx_builder\builder;
if ( ! defined( 'WPINC' ) ) { die; }

/* Constants
------------------------------------------ */

define( __NAMESPACE__ . '\URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( __NAMESPACE__ . '\PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( __NAMESPACE__ . '\VERSION', $version );


/* Load Files
------------------------------------------ */

/* Functions */
require_once( PATH . 'functions.php' );

/* Switcher */
require_once( PATH . 'switcher.php' );

/* The Page Builder */
require_once( PATH . 'builder.php' );

