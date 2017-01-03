<?php
namespace fx_builder\builder;
if ( ! defined( 'WPINC' ) ) { die; }
Revisions::get_instance();

/**
 * Stuff
 * @since 1.0.0
 */
class Revisions{

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

		/* Save Page Builder Revision */
		add_action( 'save_post', array( $this, 'save_revision' ), 11, 2 );

		/* Restore Post Revisions */
		add_action( 'wp_restore_post_revision', array( $this, 'restore_revision' ), 10, 2 );
	}

	/**
	 * Save Revision
	 * Simply Clone To Revision If Page Builder Data Exists In Post
	 * @link https://johnblackbourn.com/post-meta-revisions-wordpress
	 */
	public function save_revision( $post_id, $post ){

		$parent_id = wp_is_post_revision( $post_id );

		if ( $parent_id ) {

			$parent     = get_post( $parent_id );

			$active     = get_post_meta( $parent->ID, '_fxb_active', true );
			$db_version = get_post_meta( $parent->ID, '_fxb_db_version', true );
			$row_ids    = get_post_meta( $parent->ID, '_fxb_row_ids', true );
			$rows       = get_post_meta( $parent->ID, '_fxb_rows', true );
			$items      = get_post_meta( $parent->ID, '_fxb_items', true );
			$css        = get_post_meta( $parent->ID, '_fxb_custom_css', true );

			if ( $active ){
				add_metadata( 'post', $post_id, '_fxb_active', $active );
			}
			if ( false !== $db_version ){
				add_metadata( 'post', $post_id, '_fxb_db_version', $db_version );
			}
			if ( false !== $row_ids ){
				add_metadata( 'post', $post_id, '_fxb_row_ids', $row_ids );
			}
			if ( false !== $rows ){
				add_metadata( 'post', $post_id, '_fxb_rows', $rows );
			}
			if ( false !== $items ){
				add_metadata( 'post', $post_id, '_fxb_items', $items );
			}
			if ( false !== $css ){
				add_metadata( 'post', $post_id, '_fxb_custom_css', $css );
			}
		}
	}


	/**
	 * Restore Revisions
	 * @link https://johnblackbourn.com/post-meta-revisions-wordpress
	 */
	public function restore_revision( $post_id, $revision_id ) {

		$revision   = get_post( $revision_id );

		$active     = get_metadata( 'post', $revision->ID, '_fxb_active', true );
		$db_version = get_metadata( 'post', $revision->ID, '_fxb_db_version', true );
		$row_ids    = get_metadata( 'post', $revision->ID, '_fxb_row_ids', true );
		$rows       = get_metadata( 'post', $revision->ID, '_fxb_rows', true );
		$items      = get_metadata( 'post', $revision->ID, '_fxb_items', true );
		$css        = get_metadata( 'post', $revision->ID, '_fxb_custom_css', true );

		if ( $active ){
			update_post_meta( $post_id, '_fxb_active', $active );
		}
		else{
			delete_post_meta( $post_id, '_fxb_active' );
		}

		if ( false !== $db_version ){
			update_post_meta( $post_id, '_fxb_db_version', $db_version );
		}
		else{
			delete_post_meta( $post_id, '_fxb_db_version' );
		}

		if ( false !== $row_ids ){
			update_post_meta( $post_id, '_fxb_row_ids', $row_ids );
		}
		else{
			delete_post_meta( $post_id, '_fxb_row_ids' );
		}

		if ( false !== $rows ){
			update_post_meta( $post_id, '_fxb_rows', $rows );
		}
		else{
			delete_post_meta( $post_id, '_fxb_rows' );
		}

		if ( false !== $items ){
			update_post_meta( $post_id, '_fxb_items', $items );
		}
		else{
			delete_post_meta( $post_id, '_fxb_items' );
		}

		if ( false !== $css ){
			update_post_meta( $post_id, '_fxb_custom_css', $css );
		}
		else{
			delete_post_meta( $post_id, '_fxb_custom_css' );
		}

	}

}

