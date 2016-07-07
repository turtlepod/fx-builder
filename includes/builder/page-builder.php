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

	<input type="hidden" name="fxb_row_order" value="<?php echo esc_attr( get_post_meta( $post_id, 'fxb_row_order', true ) ); ?>" autocomplete="off"/>
	<input type="hidden" name="fxb_db_version" value="1.0.0" autocomplete="off"/>
<?php
	/* Load underscore template */
	require_once( PATH . 'templates/row.php' );

	/* Create Nonce */
	wp_nonce_field( __FILE__ , 'fxb_nonce' );

	/* Load initial rows */
	$rows_data = get_post_meta( $post_id, 'fxb_row', true );
	$order     = get_post_meta( $post_id, 'fxb_row_order', true );
	$rows      = explode( ',', $order );
	?>
	<script type="text/javascript">
		jQuery( document ).ready( function() {
			var row_template = wp.template( 'fxb-row' );
			<?php foreach( $rows as $row_id ){ ?>
				<?php if( isset( $rows_data[$row_id]['setting'] ) ){ ?>

					jQuery( '#fxb' ).append( row_template( <?php echo wp_json_encode( $rows_data[$row_id]['setting'] ); ?> ) );

				<?php } ?>
			<?php } // end foreach ?>
		} );
	</script>
	<?php
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
		update_post_meta( $post_id, 'fxb_db_version', $request['fxb_db_version'] );
	}
	if( isset( $request['fxb_row_order'] ) ){
		update_post_meta( $post_id, 'fxb_row_order', $request['fxb_row_order'] );
	}
	if( isset( $request['fxb_row'] ) ){
		update_post_meta( $post_id, 'fxb_row', $request['fxb_row'] );
	}
}


/* Utility
------------------------------------------ */

/**
 * Render (empty) Column
 */
function render_column( $args = array() ){
	$args_default = array(
		'title'     => '',
	);
	$args = wp_parse_args( $args, $args_default );
?>
	<div class="fxb-col fxb-clear">
		<h3 class="fxb-col-title"><span><?php echo $args['title']; ?></span></h3>
		<div class="fxb-col-content">
		</div><!-- .fxb-col-content -->
		<div class="fxb-add-item fxb-link">
			<span><?php _e( 'Add Item', 'fx-builder' );?></span>
		</div><!-- .fxb-add-item -->
	</div><!-- .fxb-col -->
<?php
}


/**
 * Render Modal Box Settings HTML
 * @since 1.0.0
 */
function render_settings( $args = array() ){
	$args_default = array(
		'id'        => '',
		'title'     => '',
		'callback'  => '__return_false',
		'width'     => '500px',
		'height'    => 'auto',
	);
	$args = wp_parse_args( $args, $args_default );
?>
	<div class="<?php echo sanitize_title( $args['id'] ); ?> fxb-modal" style="display:none;width:<?php echo esc_attr( $args['width'] ); ?>;height:<?php echo esc_attr( $args['height'] );?>;">
		<div class="fxb-modal-container">
			<div class="fxb-modal-title"><?php echo $args['title']; ?><span class="fxb-modal-close">Done</span></div><!-- .fxb-modal-title -->

			<div class="fxb-modal-content">
				<?php if ( is_callable( $args['callback'] ) ){
					call_user_func( $args['callback'] );
				} ?>
			</div><!-- .fxb-modal-content -->

		</div><!-- .fxb-modal-container -->
	</div><!-- .fxb-modal -->
<?php
}

