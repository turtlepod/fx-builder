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
					<textarea autocomplete="off" id="fxb-tools-export-textarea" readonly="readonly" style="display:none;"><?php echo esc_textarea( ' Quisque tempus lobortis turpis vel congue. Proin mi sapien, mollis at dignissim ut, ultricies vel mi. Aenean sagittis rhoncus elementum. Curabitur ut justo leo. Nam lobortis pellentesque velit, vel mattis erat aliquam ac. Aliquam erat volutpat. Donec pulvinar imperdiet eros, interdum consequat justo rhoncus eu. Nulla rhoncus lacus ut velit iaculis vitae blandit dui sodales. Pellentesque sed mi eu eros molestie feugiat ac et sem. Phasellus suscipit, arcu sed euismod semper, dolor nibh ullamcorper libero, a bibendum ipsum risus sed velit. Nullam vitae elit eu urna pharetra pretium in sed enim. Quisque porta, lacus eu pulvinar convallis, nibh mi aliquet velit, quis congue nulla nisi a lectus. Suspendisse sed lectus metus. Vestibulum dignissim elit at ante dictum pellentesque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec pellentesque vestibulum suscipit. Mauris vitae justo justo, nec vestibulum lorem. Nam lacus ipsum, sagittis vel elementum eu, imperdiet vel turpis. Aenean rhoncus libero augue, quis ultricies tellus. In mauris eros, lobortis eget adipiscing lacinia, eleifend mattis purus. Sed feugiat urna id lorem elementum eu molestie nulla lobortis.' ); ?></textarea>
					<p><a id="fxb-tools-export-action" href="#" class="button button-primary"><?php _e( 'Generate Export Code', 'fx-builder' ); ?></a></p>
				</div><!-- .wp-tab-panel -->

				<div id="fxb-import-panel" class="fxb-tools-panel wp-tab-panel" style="display:none;">
					<textarea autocomplete="off" id="fxb-tools-import-textarea" ><?php echo esc_textarea( '' ); ?></textarea>
					<p><a id="fxb-tools-import-action" href="#" data-confirm="<?php esc_attr_e( 'Are you sure you want to import this new data?', 'fx-builder' ); ?>" class="button button-primary disabled"><?php _e( 'Import Page Builder Data', 'fx-builder' ); ?></a></p>
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

			/* JS */
			wp_enqueue_script( 'fx-builder-tools', URI . 'assets/tools.js', array( 'jquery' ), VERSION, true );
		}
	}

}

