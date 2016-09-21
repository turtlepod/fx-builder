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
	}


	/**
	 * Create Settings Page
	 * @since 1.0.0
	 */
	public function create_settings_page(){

		/* Create Settings Sub-Menu */
		$this->hook_suffix = add_options_page(
			$page_title  = __( 'Page Builder Settings', 'fx-builder' ),
			$menu_title  = __( 'Page Builder', 'fx-builder' ),
			$capability  = 'manage_options',
			$menu_slug   = $this->settings_slug,
			$function    = array( $this, 'settings_page' )
		);
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

		/* Disable WP Editor: array of post type to disable wp editor */
		register_setting(
			$option_group      = $this->options_group,
			$option_name       = 'fx-builder_disable-wp-editor',
			$sanitize_callback = function( $data ){
				return Fs::sanitize_post_types( $data );
			}
		);

		/* Disable Page Builder */
		register_setting(
			$option_group      = $this->options_group,
			$option_name       = 'fx-builder_enable-page-builder',
			$sanitize_callback = function( $data ){
				return Fs::sanitize_post_types( $data );
			}
		);

		/* Create settings section */
		add_settings_section(
			$section_id        = 'fxb_settings',
			$section_title     = '',
			$callback_function = '__return_false',
			$settings_slug     = $this->settings_slug
		);

		/* Get All Public Post Types */
		$post_types = get_post_types( $args = array( 'public' => true ) , 'objects' );

		/* Create Options For Each Post Types */
		foreach( $post_types as $post_type ){

			/* Only if post type supports "editor" */
			if( post_type_supports( $post_type->name, 'editor' ) ){

				/* Create Setting Field */
				add_settings_field(
					$field_id          = $post_type->name,
					$field_title       = $post_type->label,
					$callback_function = function() use( $post_type ){
						?>
						<p>
							<label>
								<input type="checkbox" value="<?php echo esc_attr( $post_type->name );?>" name="fx-builder_disable-wp-editor[]" <?php checked( in_array( $post_type->name, (array)get_option( 'fx-builder_disable-wp-editor' ) ) ); ?>> <?php _e( 'Disable WP Editor', 'fx-builder' ); ?>
							</label>
						</p>
						<p>
							<label>
								<input type="checkbox" value="<?php echo esc_attr( $post_type->name );?>" name="fx-builder_enable-page-builder[]" <?php checked( post_type_supports( $post_type->name, 'fx_builder' ) ); ?>> <?php _e( 'Enable Page Builder', 'fx-builder' ); ?>
							</label>
						</p>
						<?php
					},
					$settings_slug     = $this->settings_slug,
					$section_id        = 'fxb_settings'
				);
			}
		}

	}
}