<?php
/**
 * Scripts
 * @since 1.0.0
**/
namespace fx_builder\builder;

/* Admin Script */
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\scripts' );


/**
 * Admin Scripts
 * @since 1.0.0
 */
function scripts( $hook_suffix ){
	global $post_type;

	/* In Page Edit Screen */
	if( 'page' == $post_type && in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ){

		/* Enqueue CSS & JS For Page Builder */
		wp_enqueue_style( 'fx-builder', URI. 'assets/page-builder.css', array(), VERSION );
		wp_enqueue_script( 'fx-builder-app', URI. 'assets/page-builder-app.js', array( 'jquery', 'jquery-ui-sortable' ), VERSION, true );
		wp_enqueue_script( 'fx-builder', URI. 'assets/page-builder.js', array( 'jquery', 'jquery-ui-sortable', 'fx-builder-app' ), VERSION, true );
	}
}




