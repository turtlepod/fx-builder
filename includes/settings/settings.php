<?php
namespace fx_builder\settings;
use fx_builder\Functions as Fs;
if ( ! defined( 'WPINC' ) ) { die; }
Settings::get_instance();

/**
 * Settings
 * @since 1.0.0
 */
class Settings{

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

		/* Vars */
		$this->settings_slug = 'fx-builder';
		$this->hook_suffix   = '';
		$this->options_group = 'fx-base';

		/* Create Settings Page */
		add_action( 'admin_menu', array( $this, 'create_settings_page' ) );

		/* Register Settings and Fields */
		add_action( 'admin_init', array( $this, 'register_settings' ), 1 );

		/* Add Post Type Support */
		add_action( 'init', array( $this, 'add_builder_support' ) );
	}


	/**
	 * Create Settings Page
	 * @since 1.0.0
	 */
	public function create_settings_page(){

		/* Hook to disable settings */
		if( false === apply_filters( 'fx_builder_settings', true ) ){ return false; }

		/* Create Settings Sub-Menu */
		$this->hook_suffix = add_options_page(
			$page_title  = __( 'Page Builder Settings', 'fx-builder' ),
			$menu_title  = __( 'Page Builder', 'fx-builder' ),
			$capability  = 'manage_options',
			$menu_slug   = $this->settings_slug,
			$function    = array( $this, 'settings_page' )
		);

		/* Admin Head */
		add_action( "admin_head-{$this->hook_suffix}", array( $this, 'admin_head' ) );
	}

	/**
	 * Settings Page Output
	 * @since 1.0.0
	 */
	public function settings_page(){
		?>
		<div class="wrap">
			<h1><?php _e( 'Page Builder Settings', 'fx-builder' ); ?></h1>
			<form method="post" action="options.php">
				<?php do_settings_sections( $this->settings_slug ); ?>
				<?php settings_fields( $this->options_group ); ?>
				<?php submit_button(); ?>
			</form>
		</div><!-- wrap -->
		<?php
	}


	/**
	 * Register Settings
	 * @since 0.1.0
	 */
	public function register_settings(){

		/* Hook to disable settings */
		if( false === apply_filters( 'fx_builder_settings', true ) ){ return false; }

		/* Disable Page Builder */
		register_setting(
			$option_group      = $this->options_group,
			$option_name       = 'fx-builder_post_types',
			$sanitize_callback = function( $data ){
				return $this->check_post_types_exists( $data );
			}
		);

		/* Create settings section */
		add_settings_section(
			$section_id        = 'fxb_settings',
			$section_title     = '',
			$callback_function = '__return_false',
			$settings_slug     = $this->settings_slug
		);

		/* Create Setting Field */
		add_settings_field(
			$field_id          = 'fxb_post_types_field',
			$field_title       = __( 'Enable Page Builder in', 'fx-builder' ),
			$callback_function = function(){

				/* Get All Public Post Types */
				$post_types = get_post_types( $args = array( 'public' => true ) , 'objects' );

				/* Create Options For Each Post Types */
				foreach( $post_types as $post_type ){

					/* Only if post type supports "editor" (content) */
					if( post_type_supports( $post_type->name, 'editor' ) ){
						?>
						<p>
							<label>
								<input type="checkbox" value="<?php echo esc_attr( $post_type->name );?>" name="fx-builder_post_types[]" <?php checked( post_type_supports( $post_type->name, 'fx_builder' ) ); ?>> <?php echo $post_type->label; ?>
							</label>
						</p>
						<?php
					}
				}
			},
			$settings_slug     = $this->settings_slug,
			$section_id        = 'fxb_settings'
		);

	}

	/**
	 * Admin Head
	 */
	public function admin_head(){
		if( ! get_option( 'fx-builder_welcome' ) && current_user_can( 'manage_options' ) ){
			?>
			<style>.fx-welcome-notice{display:none;}</style>
			<?php
			update_option( 'fx-builder_welcome', 1 );
		}
	}

	/**
	 * Enable Page Builder to Post Type
	 */
	public function add_builder_support(){
		/* Hook to disable settings */
		if( false === apply_filters( 'fx_builder_settings', true ) ){ return false; }

		/* If not set, default to page. */
		$post_types = get_option( 'fx-builder_post_types' );
		if( ! $post_types && ! is_array( $post_types ) ){
			$post_types = array( 'page' );
		}
		else{
			$post_types = $this->check_post_types_exists( $post_types );
		}
		foreach( $post_types as $pt ){
			add_post_type_support( $pt, 'fx_builder' );
		}
	}

	/**
	 * Sanitize Post Types
	 * @param $input array
	 * @return array
	 * @since 1.0.0
	 */
	public function check_post_types_exists( $input ) {
		$input = is_array( $input ) ? $input : array();
		$post_types = array();
		foreach( $input as $post_type ){
			if( post_type_exists( $post_type ) ){
				$post_types[] = $post_type;
			}
		}
		return $post_types;
	}
}