<?php
/**
 * Setup Plugin
 * @since 1.0.0
**/
namespace fx_builder;
if ( ! defined( 'WPINC' ) ) { die; }

/* Constants
------------------------------------------ */

define( __NAMESPACE__ . '\URI', $uri );
define( __NAMESPACE__ . '\PATH', $path );
define( __NAMESPACE__ . '\FILE', $file );
define( __NAMESPACE__ . '\PLUGIN', $plugin );
define( __NAMESPACE__ . '\VERSION', $version );


/* Load Files
------------------------------------------ */

/* Settings */
require_once( PATH . 'includes/settings/setup.php' );

/* Builder */
require_once( PATH . 'includes/builder/setup.php' );

