<?php
namespace fx_builder\settings;
if ( ! defined( 'WPINC' ) ) { die; }
//Settings::get_instance();

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
		$this->settings_slug = 'fx-base';
		$this->hook_suffix   = 'fx_base_page_fx-base';
		$this->options_group = 'fx-base';
		$this->option_name   = 'fx-base';

		/* Create Settings Page */
		add_action( 'admin_menu', array( $this, 'create_settings_page' ) );

		/* Register Settings and Fields */
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		/* Settings Scripts */
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}


	/**
	 * Create Settings Page
	 * @since 1.0.0
	 */
	public function create_settings_page(){

		/* Create Settings Sub-Menu */
		add_submenu_page(
			$parent_slug = 'edit.php?post_type=fx_base', // e.g "options-general.php"
			$page_title  = __( 'f(x) Base', 'fx-base' ),
			$menu_title  = __( 'f(x) Settings', 'fx-base' ),
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
			<h1><?php _e( 'f(x) Base', 'fx-base' ); ?></h1>
			<form method="post" action="options.php">
				<?php settings_errors(); ?>
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

		/* Register settings */
		register_setting(
			$option_group      = $this->options_group,
			$option_name       = $this->option_name,
			$sanitize_callback = array( $this, 'sanitize' )
		);

		/* Create settings section */
		add_settings_section(
			$section_id        = 'fx_base_section1',
			$section_title     = __( 'Section #1', 'fx-base' ),
			$callback_function = '__return_false',
			$settings_slug     = $this->settings_slug
		);

		/* Create Setting Field: Boxes, Buttons, Columns */
		add_settings_field(
			$field_id          = 'fx_base_settings_field1',
			$field_title       = __( 'Field #1', 'fx-base' ),
			$callback_function = array( $this, 'settings_field1' ),
			$settings_slug     = $this->settings_slug,
			$section_id        = 'fx_base_section1'
		);

	}

	/**
	 * Settings Field Callback
	 * @since 1.0.0
	 */
	public function settings_field1(){
		?>
		<p>
			<input type="text" name="fx-base" value="<?php echo sanitize_text_field( get_option( $this->option_name ) ); ?>">
		</p>
		<p class="description">
			<?php _e( 'Hi there!', 'fx-base' ); ?>
		</p>
		<?php
	}


	/**
	 * Sanitize Options
	 * @since 1.0.0
	 */
	public function sanitize( $data ){
		return sanitize_text_field( $data );
	}


	/**
	 * Settings Scripts
	 * @since 1.0.0
	 */
	public function scripts( $hook_suffix ){

		/* Only load in settings page. */
		if ( $this->hook_suffix == $hook_suffix ){

			/* CSS */
			wp_enqueue_style( "{$this->settings_slug}_settings", URI . 'assets/settings.css', array(), VERSION );

			/* JS */
			wp_enqueue_script( "{$this->settings_slug}_settings", URI . 'assets/settings.js', array( 'jquery' ), VERSION, true );
		}
	}
}