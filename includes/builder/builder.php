<?php
namespace fx_builder\builder;
use fx_builder\Functions as Fs;
if ( ! defined( 'WPINC' ) ) { die; }

/* Load Class */
Builder::get_instance();

/**
 * Builder
 * @since 1.0.0
 */
class Builder{

	/**
	 * Returns the instance.
	 */
	public static function get_instance(){
		static $instance = null;
		if ( is_null( $instance ) ) $instance = new self;
		return $instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {

		/* Add it after editor in edit screen */
		add_action( 'edit_form_after_editor', array( $this, 'form' ) );

		/* Load Underscore Templates + Print Scripts */
		add_action( 'admin_footer', array( $this, 'load_templates' ) );

		/* Save Builder Data */
		add_action( 'save_post', array( $this, 'save' ), 10, 2 );

		/* Scripts */
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ), 99 );
	}


	/**
	 * Builder Form
	 */
	public function form( $post ){
		if( ! post_type_supports( $post->post_type, 'fx_builder' ) ){ return; }
		$post_id = $post->ID;
		?>

		<div id="fxb-wrapper">

			<div class="fxb-modal-overlay" style="display:none;"></div>

			<div id="fxb-menu">
				<p><a href="#" class="button button-primary fxb-add-row"><?php _e( 'Add Row', 'fx-builder' ); ?></a></p>
			</div><!-- #fxb-menu -->

			<div id="fxb">
			</div><!-- #fxb -->

			<input type="hidden" name="fxb_row_ids" value="<?php echo esc_attr( get_post_meta( $post_id, 'fxb_row_ids', true ) ); ?>" autocomplete="off"/>
			<input type="hidden" name="fxb_db_version" value="<?php echo esc_attr( VERSION ); ?>" autocomplete="off"/>
			<?php wp_nonce_field( __FILE__ , 'fxb_nonce' ); // create nonce ?>

			<?php /* Load Custom Editor */ ?>

			<?php Functions::render_settings( array(
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

		</div><!-- #fxb-wrapper -->
		<?php
	}


	/**
	 * Admin Footer Scripts
	 */
	public function load_templates(){
		global $post_type;
		if( ! post_type_supports( $post_type, 'fx_builder' ) ){ return; }
		$post_id = get_the_ID();

		/* Row Template */
		require_once( PATH . 'templates/tmpl-row.php' );

		/* Item Template */
		require_once( PATH . 'templates/tmpl-item.php' );

		/* Rows data */
		$rows_data   = get_post_meta( $post_id, 'fxb_rows', true );
		$row_ids     = get_post_meta( $post_id, 'fxb_row_ids', true );
		if( ! $rows_data && $row_ids && is_array( $rows_data ) && is_array( $row_ids ) ){ return false; }
		$rows        = explode( ',', $row_ids );

		/* Items data */
		$items_data  = get_post_meta( $post_id, 'fxb_items', true );
		?>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				var row_template = wp.template( 'fxb-row' );

				<?php foreach( $rows as $row_id ){ ?>
					<?php if( isset( $rows_data[$row_id] ) ){ ?>
						$( '#fxb' ).append( row_template( <?php echo wp_json_encode( $rows_data[$row_id] ); ?> ) );
					<?php } ?>
				<?php } // end foreach ?>

				<?php if( $items_data && is_array( $items_data ) ){ ?>
					var item_template = wp.template( 'fxb-item' );
					<?php foreach( $items_data as $item_id => $item ){ ?>
						<?php if( isset( $rows_data[$item['row_id']] ) ){ ?>
							$( '.fxb-row[data-id="<?php echo $item['row_id']; ?>"] .fxb-col[data-col_index="<?php echo $item['col_index']; ?>"] .fxb-col-content' ).append( item_template( <?php echo wp_json_encode( $item ); ?> ) );
						<?php } ?>
					<?php } // end foreach ?>
				<?php } ?>
			} );
		</script>
		<?php
	}


	/**
	 * Save Page Builder Data
	 * @since 1.0.0
	 */
	public function save( $post_id, $post ){
		$request = stripslashes_deep( $_POST );
		if ( ! isset( $request['fxb_nonce'] ) || ! wp_verify_nonce( $request['fxb_nonce'], __FILE__ ) ){
			return false;
		}
		if( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
			return false;
		}
		$post_type = get_post_type_object( $post->post_type );
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
			return false;
		}

		/* DB Version */
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


		/* Row IDs */
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

		/* Rows Datas */
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

		/*  Items Datas */
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


	/**
	 * Admin Scripts
	 * @since 1.0.0
	 */
	public function scripts( $hook_suffix ){
		global $post_type;

		/* In Page Edit Screen */
		if( 'page' == $post_type && in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ){

			/* Enqueue CSS */
			wp_enqueue_style( 'fx-builder', URI . 'assets/page-builder.css', array(), VERSION );

			/* Enqueue JS: ROW */
			wp_enqueue_script( 'fx-builder-row', URI . 'assets/page-builder-row.js', array( 'jquery', 'jquery-ui-sortable', 'wp-util' ), VERSION, true );

			/* Enqueue JS: ITEM */
			wp_enqueue_script( 'fx-builder-item', URI . 'assets/page-builder-item.js', array( 'jquery', 'jquery-ui-sortable', 'wp-util' ), VERSION, true );
		}
	}


}
