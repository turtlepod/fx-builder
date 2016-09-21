<?php
namespace fx_builder\builder;
if ( ! defined( 'WPINC' ) ) { die; }
Front::get_instance();

/**
 * Front-End Implementation
 * @since 1.0.0
 */
class Front{

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

		/* Filter content with page builder content. Need to be after WP wpautop filter */
		add_filter( 'the_content', array( $this, 'content_filter' ), 10 );

		/* Enqueue Scripts */
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * Content Filter
	 */
	public function content_filter( $content ){
		$post_id = get_the_ID();
		$post_type = get_post_type( $post_id );
		if( ! post_type_supports( $post_type, 'fx_builder' ) ){
			return $content;
		}
		$active = get_post_meta( $post_id, '_fx_builder_active', true );
		if( $active ){
			$content = Functions::to_string( $post_id );
		}
		return $content;
	}

	/**
	 * Front-End Scripts
	 */
	public function scripts(){
		if( apply_filters( 'fx_builder_css', true ) ){
			wp_enqueue_style( 'fx-builder', URI . 'assets/front.css', array(), VERSION );
		}
	}

}