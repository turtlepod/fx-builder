<?php
/**
 * System Requirement Check
 * Prefix this class with plugin prefix.
 * Do not add namespace to this file. This file need to be PHP 5.2.4 compatible.
 * @version 1.0.0
 */
class Fx_Builder_System_Requirement{

	/* System Requirement */
	var $args;

	/**
	 * Constructor.
	 */
	public function __construct( $args = array() ) {

		/* Defaults */
		$defaults = array(
			'wp_requires'   => array(
				'version'       => '4.4',
				'notice'        => false,
			),
			'php_requires'  => array(
				'version'       => '5.2.4',
				'notice'        => false,
			),
		);

		/* Parse defaults */
		$this->args = wp_parse_args( $args, $defaults );

		/* Admin Notice */
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Admin Notice
	 */
	public function admin_notices(){

		/* WP Version Notice */
		if( $this->args['wp_requires']['notice'] && version_compare( get_bloginfo( 'version' ), $this->args['wp_requires']['version'], '<' ) ){
			?>
				<div class="error">
					<?php echo $this->args['wp_requires']['notice']; ?>
				</div>
			<?php
		}

		/* PHP Version Notice */
		if( $this->args['php_requires']['notice'] && version_compare( PHP_VERSION, $this->args['php_requires']['version'], '<' ) ){
			?>
				<div class="error">
					<?php echo $this->args['php_requires']['notice']; ?>
				</div>
			<?php
		}
	}

	/**
	 * Check if installation have min requirement.
	 * @return bool true if server have min requirement
	 */
	public function check(){

		/* if system have min req (WP & PHP), return true */
		if ( version_compare( get_bloginfo( 'version' ), $this->args['wp_requires']['version'], '>=' ) && version_compare( PHP_VERSION, $this->args['php_requires']['version'], '>=' ) ) {
			return true;
		}

		/* if not return false */
		return false;
	}

}