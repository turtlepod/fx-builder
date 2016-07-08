<?php
/**
 * The Page Builder
 * @since 1.0.0
 */
namespace fx_builder\builder;


/* Add Page Builder Editor
------------------------------------------ */

/* Add it after editor in edit screen */
add_action( 'edit_form_after_editor', __NAMESPACE__ . '\page_builder', 10, 2 );

/**
 * The Page Builder
 * @since 1.0.0
 */
function page_builder( $post ){
	$post_id = $post->ID;
	/* TEMP: Only in page post type */
	if( 'page' !== $post->post_type ){ return; }
?>

	<div class="fxb-modal-overlay" style="display:none;"></div>

	<div id="fxb-menu">
		<p><a href="#" class="button button-primary fxb-add-row"><?php _e( 'Add Row', 'fx-builder' ); ?></a></p>
	</div><!-- #fxb-menu -->

	<div id="fxb">
	</div><!-- #fxb -->

	<input type="hidden" name="fxb_row_ids" value="<?php echo esc_attr( get_post_meta( $post_id, 'fxb_row_ids', true ) ); ?>" autocomplete="off"/>
	<input type="hidden" name="fxb_db_version" value="1.0.0" autocomplete="off"/>
	<?php wp_nonce_field( __FILE__ , 'fxb_nonce' ); // create nonce ?>

	<?php /* Load Custom Editor */ ?>

	<?php render_settings( array(
		'id'        => 'fxb-editor', // data-target
		'title'     => __( 'Edit Content', 'fx-builder' ),
		'width'     => '800px',
		'callback'  => function(){

			wp_editor( '', 'fxb_editor', array(
				'tinymce'       => array(
					'wp_autoresize_on' => false,
					'resize'           => false,
				),
				'editor_height' => 300,
			) );
		},
	));?>


<?php
	/* Load underscore template */
	require_once( PATH . 'templates/index.php' );
}

/* Save Data
------------------------------------------ */
add_action( 'save_post', __NAMESPACE__ . '\save_builder_data', 10, 2 );

/**
 * Save Page Builder Data
 * @since 1.0.0
 */
function save_builder_data( $post_id, $post ){
	$request = stripslashes_deep( $_POST );
	$nonce_id = 'fxb_nonce';
	if ( ! isset( $request[$nonce_id] ) || ! wp_verify_nonce( $request[$nonce_id], __FILE__ ) ){
		return false;
	}
	if( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return false;
	}
	$post_type = get_post_type_object( $post->post_type );
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
		return false;
	}

	/* Save Datas */
	if( isset( $request['fxb_db_version'] ) ){
		if( $request['fxb_db_version'] ){
			update_post_meta( $post_id, 'fxb_db_version', $request['fxb_db_version'] );
		}
		else{
			delete_post_meta( $post_id, 'fxb_db_version' );
		}
	}
	else{
		delete_post_meta( $post_id, 'fxb_db_version' );
	}
	if( isset( $request['fxb_row_ids'] ) ){
		if( $request['fxb_row_ids'] ){
			update_post_meta( $post_id, 'fxb_row_ids', $request['fxb_row_ids'] );
		}
		else{
			delete_post_meta( $post_id, 'fxb_row_ids' );
		}
	}
	else{
		delete_post_meta( $post_id, 'fxb_row_ids' );
	}
	if( isset( $request['fxb_rows'] ) ){
		if( $request['fxb_rows'] ){
			update_post_meta( $post_id, 'fxb_rows', $request['fxb_rows'] );
		}
		else{
			delete_post_meta( $post_id, 'fxb_rows' );
		}
	}
	else{
		delete_post_meta( $post_id, 'fxb_rows' );
	}
	if( isset( $request['fxb_items'] ) ){
		if( $request['fxb_items'] ){
			update_post_meta( $post_id, 'fxb_items', $request['fxb_items'] );
		}
		else{
			delete_post_meta( $post_id, 'fxb_items' );
		}
	}
	else{
		delete_post_meta( $post_id, 'fxb_items' );
	}
}



