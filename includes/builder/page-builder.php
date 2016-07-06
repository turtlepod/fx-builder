<?php
/**
 * The Page Builder
 * @since 1.0.0
 */
namespace fx_builder\builder;


/* PARTS
------------------------------------------ */

/* Column Parts */
require_once( PATH . 'parts-item.php' );


/* Add Page Builder Editor
------------------------------------------ */

/* Add it after editor in edit screen */
add_action( 'edit_form_after_editor', __NAMESPACE__ . '\page_builder', 10, 2 );

/**
 * The Page Builder
 * @since 1.0.0
 */
function page_builder( $post ){
	/* TEMP: Only in page post type */
	if( 'page' !== $post->post_type ){ return; }
?>

	<div id="fxb-menu">
		<p><a href="#" class="button button-primary fxb-add-row">Add Row</a></p>
	</div><!-- #fxb-menu -->

	<div id="fxb">
	</div><!-- #fxb -->
<?php

	/* === LOAD UNDERSCORE TEMPLATES */

	/* Row Template */
	require_once( PATH . 'templates/row.php' );
}




