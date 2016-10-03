<?php
namespace fx_builder\builder;
use fx_builder\Functions as Fs;
if ( ! defined( 'WPINC' ) ) { die; }
Custom_CSS::get_instance();

/**
 * Custom CSS
 * @since 1.0.0
 */
class Custom_CSS{

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
		add_action( 'fxb_switcher_nav', array( $this, 'add_css_control' ) );

		/* Save CSS */
		add_action( 'save_post', array( $this, 'save' ), 10, 2 );

		/* Scripts */
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		/* Add CSS */
		add_action( 'wp_head', array( $this, 'print_css' ), 99 );
	}

	/**
	 * CSS Control
	 */
	public function add_css_control( $post ){
		$post_id = $post->ID;
		?>
		<a href="#" id="fxb-nav-css" class="fxb-nav-css"><span><?php _e( 'CSS', 'fx-builder' ); ?></span></a>
		<?php wp_nonce_field( __FILE__ , 'fx_builder_custom_css_nonce' ); ?>
		<?php Functions::render_settings( array(
			'id'        => 'fxb-custom-css', // data-target
			'title'     => __( 'Custom CSS', 'fx-builder' ),
			'width'     => '800px',
			'height'    => '400px',
			'callback'  => function() use( $post_id ){
				?>
				<textarea class="fxb-custom-css-textarea" name="_fxb_custom_css" autocomplete="off" placeholder="<?php esc_attr_e( 'Custom CSS Here...', 'fx-builder' ); ?>"><?php echo esc_textarea( Sanitize::css( get_post_meta( $post_id, '_fxb_custom_css', true ) ) ); ?></textarea>
				<p><label><input autocomplete="off" type="checkbox" name="_fxb_custom_css_disable" value="1" <?php checked( '1', get_post_meta( $post_id, '_fxb_custom_css_disable', true ) ); ?>><?php _e( 'Disable Custom CSS', 'fx-builder' ); ?></label></p>
				<?php
			},
		));?>
		<?php
	}

	/**
	 * Save Custom CSS Data
	 * @since 1.0.0
	 */
	public function save( $post_id, $post ){
		$request = stripslashes_deep( $_POST );
		if ( ! isset( $request['fx_builder_custom_css_nonce'] ) || ! wp_verify_nonce( $request['fx_builder_custom_css_nonce'], __FILE__ ) ){
			return false;
		}
		if( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
			return false;
		}
		$post_type = get_post_type_object( $post->post_type );
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
			return false;
		}

		/* Save Data */
		if( isset( $request['_fxb_custom_css'] ) ){
			if( $request['_fxb_custom_css'] ){
				update_post_meta( $post_id, '_fxb_custom_css', Sanitize::css( $request['_fxb_custom_css'] ) );
			}
			else{
				delete_post_meta( $post_id, '_fxb_custom_css' );
			}
		}
		if( isset( $request['_fxb_custom_css_disable'] ) && ( "1" == $request['_fxb_custom_css_disable'] ) ){
			update_post_meta( $post_id, '_fxb_custom_css_disable', 1 );
		}
		else{
			delete_post_meta( $post_id, '_fxb_custom_css_disable' );
		}
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
			wp_enqueue_style( 'fx-builder-custom_css', URI . 'assets/custom-css.css', array( 'fx-builder' ), VERSION );

			/* JS */
			wp_enqueue_script( 'fx-builder-custom_css', URI . 'assets/custom-css.js', array( 'jquery' ), VERSION, true );
		}
	}

	/**
	 * Print CSS to Front End
	 * @since 1.0.0
	 */
	public function print_css(){
		if( !is_singular() ) return;
		$post_id = get_queried_object_id();
		$post_type = get_post_type( $post_id );
		if( ! post_type_supports( $post_type, 'fx_builder' ) ) return;
		$active = get_post_meta( $post_id, '_fxb_active', true );
		if( ! $active ) return;
		$css = get_post_meta( $post_id, '_fxb_custom_css', true );
		$disable = get_post_meta( $post_id, '_fxb_custom_css_disable', true );
		if( $css && !$disable ){
		?>
		<style id="fx-builder-custom-css" type="text/css">
			<?php echo wp_strip_all_tags( $css );?>
		</style>
		<?php
		}
	}

}

