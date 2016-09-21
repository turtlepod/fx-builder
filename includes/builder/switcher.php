<?php
namespace fx_builder\builder;
use fx_builder\Functions as Fs;
if ( ! defined( 'WPINC' ) ) { die; }
Switcher::get_instance();

/**
 * Switcher: Toggle between page builder / wp editor.
 * @since 1.0.0
 */
class Switcher{

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

		/* Add Post Type Support */
		add_action( 'init', array( $this, 'add_builder_support' ) );

		/* Setup Write Panel */
		add_action( 'admin_init', array( $this, 'remove_wp_editor_support' ) );

		/* Add HTML Class */
		add_action( 'admin_head', array( $this, 'html_class_script' ) );

		/* Add Editor/Page Builder Tab */
		add_action( 'edit_form_after_title', array( $this, 'editor_toggle' ) );

		/* Save Switcher Preference */
		add_action( 'save_post', array( $this, 'save' ), 9, 2 );

		/* Scripts */
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ), 99 );
	}

	/**
	 * Enable Page Builder to Post Type
	 */
	public function add_builder_support(){
		$enable_page_builder = Fs::sanitize_post_types( get_option( 'fx-builder_enable-page-builder' ) );
		foreach( $enable_page_builder as $pt ){
			add_post_type_support( $pt, 'fx_builder' );
		}
	}


	/**
	 * Disable WP Editor
	 * Remove editor support only in write panel.
	 */
	public function remove_wp_editor_support(){
		global $pagenow;
		if( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) ){
			$disable_wp_editor = Fs::sanitize_post_types( get_option( 'fx-builder_disable-wp-editor' ) );
			foreach( $disable_wp_editor as $pt ){
				remove_post_type_support( $pt, 'editor' );
			}
		}
	}


	/**
	 * Add Builder Active HTML Class
	 * This is added using this method, so we can hide/show builder properly without waiting all page loaded.
	 */
	function html_class_script(){
		global $pagenow, $post_type;
		if( ! in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) ){
			return false;
		}

		if( post_type_supports( $post_type, 'editor' ) && post_type_supports( $post_type, 'fx_builder' ) ){

			/* If builder selected */
			if( $active = get_post_meta( get_the_ID(), '_fx_builder_active', true ) ){
				?>
				<script type="text/javascript">
				/* <![CDATA[ */
				document.documentElement.classList.add( "fx_builder_active" );
				/* ]]> */
				</script>
				<?php
			}
		}
	}
	

	/**
	 * Editor Toggle
	 */
	public function editor_toggle( $post ){
		$post_id = $post->ID;
		if( post_type_supports( $post->post_type, 'editor' ) && post_type_supports( $post->post_type, 'fx_builder' ) ){
			$active        = get_post_meta( $post_id, '_fx_builder_active', true );
			$active        = $active ? 1 : 0;
			$editor_class  = $active ? "nav-tab" : "nav-tab nav-tab-active";
			$builder_class = $active ? "nav-tab nav-tab-active" : "nav-tab";
			?>
			<h1 id="fxb-switcher" class="nav-tab-wrapper wp-clearfix">
				<a data-fxb-switcher="editor" class="<?php echo esc_attr( $editor_class ); ?>" href="#"><?php _e( 'Editor', 'fx-builder' ); ?></a>
				<a data-fxb-switcher="builder" class="<?php echo esc_attr( $builder_class ); ?>" href="#"><?php _e( 'Page Builder', 'fx-builder' ); ?></a>
				<input type="hidden" name="_fx_builder_active" value="<?php echo esc_attr( $active ); ?>">
				<?php wp_nonce_field( __FILE__ , 'fx_builder_switcher_nonce' ); ?>
			</h1>
			<?php
		}
	}


	/**
	 * Save Switcher Pref
	 * @since 1.0.0
	 */
	public function save( $post_id, $post ){
		$request = stripslashes_deep( $_POST );
		if ( ! isset( $request['fx_builder_switcher_nonce'] ) || ! wp_verify_nonce( $request['fx_builder_switcher_nonce'], __FILE__ ) ){
			return false;
		}
		if( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
			return false;
		}
		$post_type = get_post_type_object( $post->post_type );
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
			return false;
		}

		/* Save Builder Tab */
		if( isset( $request['_fx_builder_active'] ) ){
			$new_data = $request['_fx_builder_active'] ? 1 : 0;
			if( $new_data ){
				update_post_meta( $post_id, '_fx_builder_active', 1 );
			}
			else{
				delete_post_meta( $post_id, '_fx_builder_active' );
			}
		}
		else{
			delete_post_meta( $post_id, '_fx_builder_active' );
		}
	}


	/**
	 * Admin Scripts
	 * @since 1.0.0
	 */
	public function scripts( $hook_suffix ){
		global $post_type;
		if( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ){
			return false;
		}
		if( post_type_supports( $post_type, 'editor' ) && post_type_supports( $post_type, 'fx_builder' ) ){

			/* CSS */
			wp_enqueue_style( 'fx-builder-switcher', URI . 'assets/switcher.css', array(), VERSION );

			/* JS */
			wp_enqueue_script( 'fx-builder-switcher', URI . 'assets/switcher.js', array( 'jquery', 'fx-builder-item' ), VERSION, true );
		}
	}

}
