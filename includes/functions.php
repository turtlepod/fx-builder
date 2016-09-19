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

} // end class