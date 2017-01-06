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

		/* Filter content with page builder content. */
		add_filter( 'the_content', array( $this, 'content_filter' ), 1 );

		/* Enqueue Scripts */
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 1 );

		/* Post Class */
		add_filter( 'post_class', array( $this, 'post_class' ), 10, 3 );
	}

	/**
	 * Content Filter
	 * This will format content with page builder data.
	 */
	public function content_filter( $content ){

		/* Check Post Support */
		$post_id   = get_the_ID();
		$post_type = get_post_type( $post_id );
		if( ! post_type_supports( $post_type, 'fx_builder' ) ){
			return $content;
		}

		$active = get_post_meta( $post_id, '_fxb_active', true );

		remove_filter( 'the_content', 'wpautop' );
		if( $active ){
			$content = Functions::content( $post_id ); // autop added in this function.
		}
		else{
			add_filter( 'the_content', 'wpautop' );
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

	/**
	 * Post Class
	 */
	public function post_class( $classes, $class, $post_id ){
		$post_type = get_post_type( $post_id );
		if( ! post_type_supports( $post_type, 'fx_builder' ) ){
			return $classes;
		}
		$active = get_post_meta( $post_id, '_fxb_active', true );
		if( $active ){
			$classes[] = 'fx-builder-entry';
		}
		return $classes;
	}

}