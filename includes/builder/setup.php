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

/* Sanitize Functions */
require_once( PATH . 'sanitize.php' );

/* Functions */
require_once( PATH . 'functions.php' );

/* Switcher */
require_once( PATH . 'switcher.php' );

/* Custom CSS */
require_once( PATH . 'custom-css.php' );

/* Tools */
require_once( PATH . 'tools.php' );

/* The Page Builder */
require_once( PATH . 'builder.php' );

/* Revisions */
require_once( PATH . 'revisions.php' );

/* Front */
require_once( PATH . 'front.php' );

