<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

/* Clean up stuff */
delete_option( 'fx-builder_post_types' );
delete_option( 'fx-builder_welcome' );