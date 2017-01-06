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

		/* Get Admin Color */
		add_action( 'admin_head', array( $this, 'global_admin_color' ), 1 );

		/* Add it after editor in edit screen */
		add_action( 'edit_form_after_editor', array( $this, 'form' ) );

		/* Save Builder Data */
		add_action( 'save_post', array( $this, 'save' ), 10, 2 );

		/* Scripts */
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ), 99 );
	}


	/**
	 * Get Admin Color in Global
	 */
	public function global_admin_color(){
		global $pagenow, $_wp_admin_css_colors, $fxb_admin_color;
		$fxb_admin_color = array( '#222', '#333', '#0073aa', '#00a0d2' ); // default (fresh)
		if( ! in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) ){
			return false;
		}
		$user_admin_color_scheme = get_user_option( 'admin_color' );
		if( isset( $_wp_admin_css_colors[$user_admin_color_scheme]->colors ) ){
			$fxb_admin_color = $_wp_admin_css_colors[$user_admin_color_scheme]->colors;
		}
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

			<?php Functions::add_row_field( 'prepend' ); ?>

			<div id="fxb">
			</div><!-- #fxb -->

			<?php Functions::add_row_field( 'append' ); ?>

			<input type="hidden" name="_fxb_row_ids" value="<?php echo esc_attr( get_post_meta( $post_id, '_fxb_row_ids', true ) ); ?>" autocomplete="off"/>
			<input type="hidden" name="_fxb_db_version" value="<?php echo esc_attr( VERSION ); ?>" autocomplete="off"/>
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

			<div id="fxb-templates">
				<?php require_once( PATH . 'templates/tmpl-row.php' ); ?>
				<?php require_once( PATH . 'templates/tmpl-item.php' ); ?>
			</div>
			<div id="fxb-template-loader">
				<?php $this->load_templates( $post_id ); ?>
			</div>

		</div><!-- #fxb-wrapper -->
		<?php
	}


	/**
	 * Load Template
	 */
	public function load_templates( $post_id ){

		/* Rows data */
		$rows_data   = Sanitize::rows_data( get_post_meta( $post_id, '_fxb_rows', true ) );
		$row_ids     = Sanitize::ids( get_post_meta( $post_id, '_fxb_row_ids', true ) );
		if( ! $rows_data && $row_ids && is_array( $rows_data ) && is_array( $row_ids ) ){ return false; }
		$rows        = explode( ',', $row_ids );

		/* Items data */
		$items_data  = Sanitize::items_data( get_post_meta( $post_id, '_fxb_items', true ) );
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

		/* Prepare
		------------------------------------------ */
		$request = stripslashes_deep( $_POST );
		if ( ! isset( $request['fxb_nonce'] ) || ! wp_verify_nonce( $request['fxb_nonce'], __FILE__ ) ){
			return $post_id;
		}
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			return $post_id;
		}
		$post_type = get_post_type_object( $post->post_type );
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
			return $post_id;
		}
		$wp_preview = isset( $request['wp-preview'] ) ? esc_attr( $request['wp-preview'] ) : false;
		if( $wp_preview ){
			return $post_id;
		}

		/* Check Swicther
		------------------------------------------ */
		$active = isset( $request['_fxb_active'] ) ? $request['_fxb_active'] : false;

		/* Page Builder Active */
		if( $active ){
			update_post_meta( $post_id, '_fxb_active', 1 );
		}
		/* Page Builder Not Selected: Delete Data and Bail. */
		else{
			delete_post_meta( $post_id, '_fxb_active' );
			delete_post_meta( $post_id, '_fxb_db_version' );
			delete_post_meta( $post_id, '_fxb_row_ids' );
			delete_post_meta( $post_id, '_fxb_rows' );
			delete_post_meta( $post_id, '_fxb_items' );
			return false;
		}


		/* Page Builder Datas
		------------------------------------------ */

		/* DB Version */
		if( isset( $request['_fxb_db_version'] ) ){
			$db_version = Sanitize::version( $request['_fxb_db_version'] );
			if( $db_version ){
				update_post_meta( $post_id, '_fxb_db_version', $db_version );
			}
			else{
				delete_post_meta( $post_id, '_fxb_db_version' );
			}
		}
		else{
			delete_post_meta( $post_id, '_fxb_db_version' );
		}


		/* Row IDs */
		if( isset( $request['_fxb_row_ids'] ) ){
			$row_ids = Sanitize::ids( $request['_fxb_row_ids'] );
			if( $row_ids ){
				update_post_meta( $post_id, '_fxb_row_ids', $row_ids );
			}
			else{
				delete_post_meta( $post_id, '_fxb_row_ids' );
			}
		}
		else{
			delete_post_meta( $post_id, '_fxb_row_ids' );
		}

		/* Rows Datas */
		if( isset( $request['_fxb_rows'] ) ){
			$rows = Sanitize::rows_data( $request['_fxb_rows'] );
			if( $rows ){
				update_post_meta( $post_id, '_fxb_rows', $rows );
			}
			else{
				delete_post_meta( $post_id, '_fxb_rows' );
			}
		}
		else{
			delete_post_meta( $post_id, '_fxb_rows' );
		}

		/*  Items Datas */
		if( isset( $request['_fxb_items'] ) ){
			$items = Sanitize::items_data( $request['_fxb_items'] );
			if( $items ){
				update_post_meta( $post_id, '_fxb_items', $items );
			}
			else{
				delete_post_meta( $post_id, '_fxb_items' );
			}
		}
		else{
			delete_post_meta( $post_id, '_fxb_items' );
		}

		/* Content Data
		------------------------------------------ */
		$pb_content = Functions::content_raw( $post_id );
		$this_post = array(
			'ID'           => $post_id,
			'post_content' => sanitize_post_field( 'post_content', $pb_content, $post_id, 'db' ),
		);
		/**
		 * Prevent infinite loop.
		 * @link https://developer.wordpress.org/reference/functions/wp_update_post/
		 */
		remove_action( 'save_post', array( $this, __FUNCTION__ ) );
		wp_update_post( $this_post );
		add_action( 'save_post', array( $this, __FUNCTION__ ), 10, 2 );
	}


	/**
	 * Admin Scripts
	 * @since 1.0.0
	 */
	public function scripts( $hook_suffix ){
		global $post_type;
		if( ! post_type_supports( $post_type, 'fx_builder' ) ){ return; }

		/* In Page Edit Screen */
		if( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ){

			/* Enqueue CSS */
			wp_enqueue_style( 'fx-builder', URI . 'assets/page-builder.css', array(), VERSION );

			/* Enqueue JS: ROW */
			wp_enqueue_script( 'fx-builder-row', URI . 'assets/page-builder-row.js', array( 'jquery', 'jquery-ui-sortable', 'wp-util' ), VERSION, true );
			$data = array(
				'unload'         => __( 'The changes you made will be lost if you navigate away from this page','fx-builder' ),
			);
			wp_localize_script( 'fx-builder-row', 'fxb_i18n', $data );

			/* Enqueue JS: ITEM */
			wp_enqueue_script( 'fx-builder-item', URI . 'assets/page-builder-item.js', array( 'jquery', 'jquery-ui-sortable', 'wp-util' ), VERSION, true );
			$ajax_data = array(
				'ajax_url'         => admin_url( 'admin-ajax.php' ),
				'ajax_nonce'       => wp_create_nonce( 'fxb_ajax_nonce' ),
			);
			wp_localize_script( 'fx-builder-item', 'fxb_ajax', $ajax_data );
		}
	}


}
