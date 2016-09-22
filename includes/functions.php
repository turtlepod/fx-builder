<?php
namespace fx_builder;

/**
 * Class Wrapper for plugin functions.
 * All functions are "public" and "static"
 * Usage:
 * `use fx_builder\Functions;`
 * `Functions::stuff( $args );`
 * @since 1.0.0
 */
class Functions{

	/**
	 * Sanitize Post Types
	 * @param $input array
	 * @return array
	 * @since 1.0.0
	 */
	public static function sanitize_post_types( $input ) {
		$input = is_array( $input ) ? $input : array();
		$post_types = array();
		foreach( $input as $post_type ){
			if( post_type_exists( $post_type ) ){
				$post_types[] = $post_type;
			}
		}
		return $post_types;
	}

	/**
	 * Sanitize Custom CSS
	 */
	public static function sanitize_css( $css ){
		$css = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $css );
		$css = wp_kses( $css, array() );
		$css = esc_html( $css );
		$css = str_replace( '&gt;', '>', $css );
		$css = str_replace( '&quot;', '"', $css );
		$css = str_replace( '&amp;', "&", $css );
		$css = str_replace( '&amp;#039;', "'", $css );
		$css = str_replace( '&#039;', "'", $css );
		return $css;
	}

} // end class