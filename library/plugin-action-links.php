<?php
/**
 * Plugin Action Links Helper Class
 * Simply add support link to Genbu Media Contact Form.
 * @version 1.0.0
 */
class Fx_Builder_Plugin_Action_Links{

	/* System Requirement */
	var $args;

	/**
	 * Constructor.
	 */
	public function __construct( $args = array() ) {

		/* Defaults */
		$defaults = array(
			'plugin'    => '',
			'name'      => '',
			'version'   => '',
			'text'      => '',
		);

		/* Parse defaults */
		$this->args = wp_parse_args( $args, $defaults );

		/* Action Links */
		add_filter( 'plugin_action_links_' . $this->args['plugin'], array( $this, 'plugin_action_links' ) );
	}

	/**
	 * Plugin Support Links
	 */
	public function plugin_action_links( $links ){

		/* Get current user info */
		if( function_exists( 'wp_get_current_user' ) ){
			$current_user = wp_get_current_user();
		}
		else{
			global $current_user;
			get_currentuserinfo();
		}

		/* Build support url */
		$support_url = add_query_arg(
			array(
				'about'      => urlencode( "{$this->args['name']} (v.{$this->args['version']})" ),
				'sp_name'    => urlencode( $current_user->display_name ),
				'sp_email'   => urlencode( $current_user->user_email ),
				'sp_website' => urlencode( home_url() ),
			),
			'http://genbumedia.com/contact/'
		);

		/* Add support link */
		$links[] = '<a target="_blank" href="' . esc_url( $support_url ) . '">' . $this->args['text'] . '</a>';

		return $links;
	}


}