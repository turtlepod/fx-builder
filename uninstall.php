<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

/* Clean up stuff */
//delete_option( 'fx-builder' );
delete_option( 'fx-builder_post_types' );
delete_option( 'fx-builder_welcome' );

/* Deprecated (Alpha) */
delete_option( 'fx-builder_enable-page-builder' );
delete_option( 'fx-builder_disable-wp-editor' );