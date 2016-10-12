<?php
namespace fx_builder\builder;
use fx_builder\Functions as Fs;
if ( ! defined( 'WPINC' ) ) { die; }
Tools::get_instance();

/**
 * Tools: Export Import
 * @since 1.0.0
 */
class Tools{

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

		/* Add CSS Button */
		add_action( 'fxb_switcher_nav', array( $this, 'add_tools_control' ), 11 );

		/* Scripts */
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		/* Ajax: To JSON */
		add_action( 'wp_ajax_fxb_export_to_json', array( $this, 'ajax_export_to_json' ) );
		add_action( 'wp_ajax_fxb_import_data', array( $this, 'ajax_import_data' ) );
	}

	/**
	 * CSS Control
	 */
	public function add_tools_control( $post ){
		$post_id = $post->ID;
		?>
		<a href="#" id="fxb-nav-tools" class="fxb-nav-tools"><span><?php _e( 'Tools', 'fx-builder' ); ?></span></a>
		<?php Functions::render_settings( array(
			'id'        => 'fxb-tools', // data-target
			'title'     => __( 'Tools', 'fx-builder' ),
			'width'     => '400px',
			'height'    => '380px',
			'callback'  => function() use( $post_id ){
				?>
				<ul class="wp-tab-bar">
					<li id="fxb-export-tab" class="tabs wp-tab-active">
						<a class="fxb-tools-nav-bar" href="#fxb-export-panel"><?php _e( 'Export', 'fx-builder' ); ?></a>
					</li><!-- .tabs -->
					<li id="fxb-import-tab" class="tabs">
						<a class="fxb-tools-nav-bar" href="#fxb-import-panel"><?php _e( 'Import', 'fx-builder' ); ?></a>
					</li><!-- .tabs -->
				</ul><!-- .wp-tab-bar -->

				<div id="fxb-export-panel" class="fxb-tools-panel wp-tab-panel" style="display:block;">
					<textarea autocomplete="off" id="fxb-tools-export-textarea" readonly="readonly" style="display:none;" placeholder="<?php esc_attr_e( 'No Data', 'fx-builder' ); ?>"></textarea>
					<p><a id="fxb-tools-export-action" href="#" class="button button-primary"><?php _e( 'Generate Export Code', 'fx-builder' ); ?></a></p>
				</div><!-- .wp-tab-panel -->

				<div id="fxb-import-panel" class="fxb-tools-panel wp-tab-panel" style="display:none;">
					<textarea autocomplete="off" id="fxb-tools-import-textarea" placeholder="<?php esc_attr_e( 'Paste your page builder data here...', 'fx-builder' ); ?>"></textarea>
					<p><a id="fxb-tools-import-action" href="#" data-confirm="<?php esc_attr_e( 'Are you sure you want to import this new data?', 'fx-builder' ); ?>" data-alert="<?php esc_attr_e( 'Your data is not valid.', 'fx-builder' ); ?>" class="button button-primary disabled"><?php _e( 'Import Page Builder Data', 'fx-builder' ); ?></a></p>
				</div><!-- .wp-tab-panel -->
				<?php
			},
		));?>
		<?php
	}

	/**
	 * Admin Scripts
	 * @since 1.0.0
	 */
	public function admin_scripts( $hook_suffix ){
		global $post_type;
		if( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ){
			return false;
		}
		if( post_type_supports( $post_type, 'editor' ) && post_type_supports( $post_type, 'fx_builder' ) ){

			/* CSS */
			wp_enqueue_style( 'fx-builder-tools', URI . 'assets/tools.css', array( 'fx-builder' ), VERSION );

			/* Serialize Object */
			wp_register_script( 'serialize-object', URI . 'assets/library/jquery.serialize-object.min.js', array( 'jquery' ), VERSION, true );

			/* JS */
			wp_enqueue_script( 'fx-builder-tools', URI . 'assets/tools.js', array( 'jquery', 'fx-builder-item', 'serialize-object' ), VERSION, true );
			$ajax_data = array(
				'ajax_url'         => admin_url( 'admin-ajax.php' ),
				'ajax_nonce'       => wp_create_nonce( 'fxb_tools_nonce' ),
			);
			wp_localize_script( 'fx-builder-tools', 'fxb_tools', $ajax_data );
		}
	}

	/**
	 * Ajax Export To JSon
	 */
	public function ajax_export_to_json(){

		/* Strip Slash */
		$request = stripslashes_deep( $_POST );

		/* Check Ajax */
		check_ajax_referer( 'fxb_tools_nonce', 'nonce' );

		$data = array(
			'row_ids' => isset( $request['row_ids'] ) ? $request['row_ids'] : '',
			'rows'    => isset( $request['rows'] ) ? $request['rows'] : array(),
			'items'   => isset( $request['items'] ) ? $request['items'] : array(),
		);

		echo json_encode( $data );
		wp_die();
	}

	/**
	 * Ajax Import Data
	 */
	public function ajax_import_data(){

		/* Strip Slash */
		$request = stripslashes_deep( $_POST );

		/* Check Ajax */
		check_ajax_referer( 'fxb_tools_nonce', 'nonce' );

		$data = isset( $request['data'] ) ? $request['data'] : '';
		$data = json_decode( $data, true );
		$default = array(
			'row_ids' => '',
			'rows'    => array(),
			'items'   => array(),
		);
		$data = wp_parse_args( $data, $default );

		/* Checking Data */
		$rows_data   = Sanitize::rows_data( $data['rows'] );
		$row_ids     = Sanitize::ids( $data['row_ids'] );
		if( ! $rows_data && $row_ids && is_array( $rows_data ) && is_array( $row_ids ) ){ return false; }
		$rows        = explode( ',', $row_ids );

		/* Items data */
		$items_data  = Sanitize::items_data( $data['items'] );
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
				var iframe_css = $.fn.fxB_getIframeCSS();
				$( '.fxb-item-iframe' ).each( function(i){
					$( this ).fxB_loadIfameContent( iframe_css );
				} );
			} );
		</script>
		<?php
		wp_die();
	}

}

