<?php
if ( ! defined( 'WPINC' ) ) { die; }


/* Load Text Domain
------------------------------------------ */
load_plugin_textdomain( dirname( $plugin ), false, dirname( $plugin ) . '/languages/' );


/* Add Support Link
------------------------------------------ */
require_once( $path . 'library/plugin-action-links.php' );
$args = array(
	'plugin'    => $plugin,
	'name'      => __( 'f(x) Builder', 'fx-builder' ),
	'version'   => $version,
	'text'      => __( 'Get Support', 'fx-builder' ),
);
new Fx_Builder_Plugin_Action_Links( $args );


/* Check PHP and WordPress Version
------------------------------------------ */
require_once( $path . 'library/system-requirement.php' );
$args = array(
	'wp_requires'   => array(
		'version'       => '4.4',
		'notice'        => wpautop( sprintf( __( 'f(x) Builder plugin requires at least WordPress 4.4+. You are running WordPress %s. Please upgrade and try again.', 'fx-builder' ), get_bloginfo( 'version' ) ) ),
	),
	'php_requires'  => array(
		'version'       => '5.3',
		'notice'        => wpautop( sprintf( __( 'f(x) Builder plugin requires at least PHP 5.3+. You are running PHP %s. Please upgrade and try again.', 'fx-builder' ), PHP_VERSION ) ),
	),
);
$sys_req = new Fx_Builder_System_Requirement( $args );
if( ! $sys_req->check() ) return;


/* Welcome Notice
------------------------------------------ */
if( ! get_option( 'fx-builder' ) ){
	require_once( $path . 'library/welcome-notice.php' );
	$args = array( 
		'notice'  => wpautop( sprintf( __( 'Please Navigate to <a href="%s">Page Builder Settings</a>.', 'fx-builder' ), esc_url( add_query_arg( 'page', 'fx-builder', admin_url( 'options-general.php' ) ) ) ) ),
		'dismiss' => __( 'Dismiss this notice.', 'fx-builder' ),
		'option'  => 'fx-builder_welcome',
	);
	new Fx_Builder_Welcome_Notice( $args );
}
