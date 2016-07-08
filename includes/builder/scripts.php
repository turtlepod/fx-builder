<?php
/**
 * Scripts
 * @since 1.0.0
**/
namespace fx_builder\builder;

/* Admin Script */
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\scripts', 99 );


/**
 * Admin Scripts
 * @since 1.0.0
 */
function scripts( $hook_suffix ){
	global $post_type;

	/* In Page Edit Screen */
	if( 'page' == $post_type && in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ){

		/* Underscores */
		wp_enqueue_script( 'wp-util' );

		/* Enqueue CSS */
		wp_enqueue_style( 'fx-builder', URI . 'assets/page-builder.css', array(), VERSION );

		/* Enqueue JS */
		//wp_enqueue_script( 'fx-builder-app', URI . 'assets/page-builder-app.js', array( 'jquery', 'jquery-ui-sortable', 'wp-util' ), VERSION, false );

		wp_enqueue_script( 'fx-builder-row', URI . 'assets/page-builder-row.js', array( 'jquery', 'jquery-ui-sortable', 'wp-util' ), VERSION, true );

		wp_enqueue_script( 'fx-builder-item', URI . 'assets/page-builder-item.js', array( 'jquery', 'jquery-ui-sortable', 'wp-util' ), VERSION, true );
	}
}




