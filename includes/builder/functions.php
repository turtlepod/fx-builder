<?php
namespace fx_builder\builder;
use fx_builder\Functions as Fs;
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Functions.
 * @since 1.0.0
 */
class Functions{

	/**
	 * Add Row
	 */
	public static function add_row_field( $method = 'prepend' ){
		global $fxb_admin_color;
		$img = URI . 'assets/layout-images/';
		?>
		<div class="fxb-add-row" data-add_row_method="<?php echo esc_attr( $method ); ?>" style="color:<?php echo esc_attr( $fxb_admin_color['2'] );?>">

			<div class="layout-thumb-wrap">
				<div class="layout-thumb" data-row-layout="1" data-row-col_num="1"><img src="<?php echo esc_url( $img . 'layout-1.png' ); ?>"></div>
			</div>
			<div class="layout-thumb-wrap">
				<div class="layout-thumb" data-row-layout="12_12" data-row-col_num="2"><img src="<?php echo esc_url( $img . 'layout-12_12.png' ); ?>"></div>
			</div>
			<div class="layout-thumb-wrap">
				<div class="layout-thumb" data-row-layout="13_23" data-row-col_num="2"><img src="<?php echo esc_url( $img . 'layout-13_23.png' ); ?>"></div>
			</div>
			<div class="layout-thumb-wrap">
				<div class="layout-thumb" data-row-layout="23_13" data-row-col_num="2"><img src="<?php echo esc_url( $img . 'layout-23_13.png' ); ?>"></div>
			</div>
			<div class="layout-thumb-wrap">
				<div class="layout-thumb" data-row-layout="13_13_13" data-row-col_num="3"><img src="<?php echo esc_url( $img . 'layout-13_13_13.png' ); ?>"></div>
			</div>
			<div class="layout-thumb-wrap">
				<div class="layout-thumb" data-row-layout="14_14_14_14" data-row-col_num="4"><img src="<?php echo esc_url( $img . 'layout-14_14_14_14.png' ); ?>"></div>
			</div>

		</div><!-- .fxb-add-row -->
		<?php
	}

	/**
	 * Render Modal Box Settings HTML
	 * @since 1.0.0
	 */
	public static function render_settings( $args = array() ){
		global $fxb_admin_color;
		$args_default = array(
			'id'        => '',
			'title'     => '',
			'callback'  => '__return_false',
			'width'     => '500px',
			'height'    => 'auto',
		);
		$args = wp_parse_args( $args, $args_default );
		?>
		<div class="<?php echo sanitize_title( $args['id'] ); ?> fxb-modal" style="display:none;width:<?php echo esc_attr( $args['width'] ); ?>;height:<?php echo esc_attr( $args['height'] );?>;">
			<div class="fxb-modal-container">
				<div class="fxb-modal-title"><?php echo $args['title']; ?><span class="fxb-modal-close" style="background-color:<?php echo esc_attr( $fxb_admin_color['2'] );?>"><?php _e( 'Done', 'fx-builder' ); ?></span></div><!-- .fxb-modal-title -->

				<div class="fxb-modal-content">
					<?php if ( is_callable( $args['callback'] ) ){
						call_user_func( $args['callback'] );
					} ?>
				</div><!-- .fxb-modal-content -->

			</div><!-- .fxb-modal-container -->
		</div><!-- .fxb-modal -->
		<?php
	}


	/**
	 * Row Settings (Modal Box)
	 * This is loaded in underscore template in each row
	**/
	public static function row_settings(){
		?>
		<?php /* Row Title */ ?>
		<div class="fxb-modal-field fxb-modal-field-text">

			<label for="fxb_rows[{{data.id}}][row_title]">
				<?php esc_html_e( 'Label', 'fx-builder' ); ?>
			</label>

			<input autocomplete="off" id="fxb_rows[{{data.id}}][row_title]" data-row_field="row_title" name="_fxb_rows[{{data.id}}][row_title]" type="text" value="{{data.row_title}}">

		</div><!-- .fxb-modal-field -->

		<?php /* Row Layout */ ?>
		<div class="fxb-modal-field fxb-modal-field-select">

			<label for="fxb_rows[{{data.id}}][layout]">
				<?php esc_html_e( 'Layout', 'fx-builder' ); ?>
			</label>

			<select id="fxb_rows[{{data.id}}][layout]" data-row_field="layout" name="_fxb_rows[{{data.id}}][layout]" autocomplete="off">

				<option data-col_num="1" value="1" <# if( data.layout == '1' ){ print('selected="selected"') } #>><?php _e( '1 Column', 'fx-builder' ); ?></option>

				<option data-col_num="2" value="12_12" <# if( data.layout == '12_12' ){ print('selected="selected"') } #>><?php _e( '1/2 - 1/2', 'fx-builder' ); ?></option>

				<option data-col_num="2" value="13_23" <# if( data.layout == '13_23' ){ print('selected="selected"') } #>><?php _e( '1/3 - 2/3', 'fx-builder' ); ?></option>

				<option data-col_num="2" value="23_13" <# if( data.layout == '23_13' ){ print('selected="selected"') } #>><?php _e( '2/3 - 1/3', 'fx-builder' ); ?></option>

				<option data-col_num="3" value="13_13_13" <# if( data.layout == '13_13_13' ){ print('selected="selected"') } #>><?php _e( '1/3 - 1/3 - 1/3', 'fx-builder' ); ?></option>

				<option data-col_num="4" value="14_14_14_14" <# if( data.layout == '14_14_14_14' ){ print('selected="selected"') } #>><?php _e( '1/4 - 1/4 - 1/4 - 1/4', 'fx-builder' ); ?></option>

			</select>

		</div><!-- .fxb-modal-field -->

		<?php /* Stack */ ?>
		<div class="fxb-modal-field fxb-modal-field-select">

			<label for="fxb_rows[{{data.id}}][col_order]">
				<?php esc_html_e( 'Collapse Order', 'fx-builder' ); ?>
			</label>

			<select id="fxb_rows[{{data.id}}][col_order]" data-row_field="col_order" name="_fxb_rows[{{data.id}}][col_order]" autocomplete="off">

				<option value="" <# if( data.col_order == '' ){ print('selected="selected"') } #>><?php _e( 'Default', 'fx-builder' ); ?></option>

				<option value="l2r" <# if( data.col_order == 'l2r' ){ print('selected="selected"') } #>><?php _e( 'Left on Top', 'fx-builder' ); ?></option>

				<option value="r2l" <# if( data.col_order == 'r2l' ){ print('selected="selected"') } #>><?php _e( 'Right on Top', 'fx-builder' ); ?></option>

			</select>

		</div><!-- .fxb-modal-field -->

		<?php /* HTML ID */ ?>
		<div class="fxb-modal-field fxb-modal-field-text">

			<label for="fxb_rows[{{data.id}}][row_html_id]">
				<?php esc_html_e( 'HTML ID', 'fx-builder' ); ?>
			</label>

			<input autocomplete="off" id="fxb_rows[{{data.id}}][row_html_id]" data-row_field="row_html_id" name="_fxb_rows[{{data.id}}][row_html_id]" type="text" value="{{data.row_html_id}}">

		</div><!-- .fxb-modal-field -->

		<?php /* HTML CLASSES */ ?>
		<div class="fxb-modal-field fxb-modal-field-text">

			<label for="fxb_rows[{{data.id}}][row_html_class]">
				<?php esc_html_e( 'HTML Class', 'fx-builder' ); ?>
			</label>

			<input autocomplete="off" id="fxb_rows[{{data.id}}][row_html_class]" data-row_field="row_html_class" name="_fxb_rows[{{data.id}}][row_html_class]" type="text" value="{{data.row_html_class}}">

		</div><!-- .fxb-modal-field -->
		<?php
	}


	/**
	 * Render (empty) Column
	 */
	public static function render_column( $args = array() ){
		global $fxb_admin_color;
		$args_default = array(
			'title'     => '',
			'index'     => '',
		);
		$args = wp_parse_args( $args, $args_default );
		extract( $args );

		/* Var */
		$field = "col_{$index}";
		?>
		<div class="fxb-col fxb-clear" data-col_index="<?php echo esc_attr( $field ); ?>">

			<?php /* Hidden input */ ?>
			<input type="hidden" data-id="item_ids" data-row_field="<?php echo esc_attr( $field ); ?>" name="_fxb_rows[{{data.id}}][<?php echo esc_attr( $field ); ?>]" value="{{data.<?php echo esc_attr( $field ); ?>}}" autocomplete="off"/>

			<?php /* Column Title */ ?>
			<h3 class="fxb-col-title"><span><?php echo $title; ?></span></h3>

			<div class="fxb-col-content"></div><!-- .fxb-col-content -->

			<div class="fxb-add-item fxb-link" style="color:<?php echo esc_attr( $fxb_admin_color['2'] ); ?>">
				<span><?php _e( 'Add Item', 'fx-builder' );?></span>
			</div><!-- .fxb-add-item -->

		</div><!-- .fxb-col -->
		<?php
	}

	/**
	 * Format Post Builder Data To Single String
	 * This is the builder data without div wrapper
	 */
	public static function to_string_raw( $post_id ){
		$row_ids     = self::sanitize_ids( get_post_meta( $post_id, '_fxb_row_ids', true ) );
		$rows_data   = self::sanitize_rows_data( get_post_meta( $post_id, '_fxb_rows', true ) );
		$items_data  = self::sanitize_items_data( get_post_meta( $post_id, '_fxb_items', true ) );
		if( !$row_ids || ! $rows_data ) return false;
		$rows        = explode( ',', $row_ids );

		$content = '';
		foreach( $rows as $row_id ){
			if( isset( $rows_data[$row_id] ) ){
				$cols = range( 1, $rows_data[$row_id]['col_num'] );
				foreach( $cols as $k ){
					$items = $rows_data[$row_id]['col_' . $k];
					$items = explode(",", $items);
					foreach( $items as $item_id ){
						if( isset( $items_data[$item_id]['content'] ) && !empty( $items_data[$item_id]['content'] ) ){
							$content .= $items_data[$item_id]['content'] . "\r\n\r\n";
						}
					}
				}

			}
		}
		return apply_filters( 'fxb_content_raw', $content, $post_id, $row_ids, $rows_data, $items_data );
	}

	/**
	 * Format Post Builder Data To Single String
	 * This will format page builder data to content (single string)
	 */
	public static function to_string( $post_id ){
		$row_ids     = self::sanitize_ids( get_post_meta( $post_id, '_fxb_row_ids', true ) );
		$rows_data   = self::sanitize_rows_data( get_post_meta( $post_id, '_fxb_rows', true ) );
		$items_data  = self::sanitize_items_data( get_post_meta( $post_id, '_fxb_items', true ) );
		$rows        = explode( ',', $row_ids );
		if( !$row_ids || ! $rows_data ) return false;
		ob_start();
		?>
		<div id="fxb-<?php echo strip_tags( $post_id ); ?>" class="fxb-wrap">

			<?php foreach( $rows as $row_id ){ ?>
				<?php if( isset( $rows_data[$row_id] ) ){
					$row_html_id = $rows_data[$row_id]['row_html_id'] ? $rows_data[$row_id]['row_html_id'] : "fxb-row-{$row_id}";
					$row_html_class = $rows_data[$row_id]['row_html_class'] ? "fxb-row {$rows_data[$row_id]['row_html_class']}" : "fxb-row";
					?>

					<div id="<?php echo $row_html_id; ?>" class="<?php echo esc_attr( $row_html_class ); ?>" data-index="<?php echo intval( $rows_data[$row_id]['index'] ); ?>" data-layout="<?php echo esc_attr( $rows_data[$row_id]['layout'] ); ?>" data-col_order=<?php echo self::sanitize_col_order( $rows_data[$row_id]['col_order'] ); ?>>

						<div class="fxb-wrap">

							<?php
							$cols = range( 1, $rows_data[$row_id]['col_num'] );
							foreach( $cols as $k ){
								$items = $rows_data[$row_id]['col_' . $k];
								$items = explode(",", $items);
								?>
								<div class="fxb-col-<?php echo intval( $k ); ?> fxb-col">

									<?php foreach( $items as $item_id ){ ?>
										<?php if( isset( $items_data[$item_id] ) ){?>

											<div id="fxb-item-<?php echo strip_tags( $item_id ); ?>" class="fxb-item">
												<div class="fxb-wrap">
													<?php echo wpautop( $items_data[$item_id]['content'] ); ?>
												</div><!-- .fxb-wrap -->
											</div><!-- .fxb-item -->

										<?php } ?>
									<?php } ?>

								</div><!-- .fxb-col -->
								<?php
							} ?>

						</div><!-- .fxb-wrap -->

					</div><!-- .fxb-row -->

				<?php } ?>
			<?php } ?>
			
		</div><!-- .fxb-wrap -->
		<?php
		return apply_filters( 'fxb_content', ob_get_clean(), $post_id, $row_ids, $rows_data, $items_data );
	}


	/* Sanitize
	------------------------------------------ */
	
	/**
	 * Sanitize Collapse Order
	 */
	public static function sanitize_col_order( $order ){
		$default = is_rtl() ? 'r2l' : 'l2r';
		$valid = array( 'r2l', 'l2r' );
		if( in_array( $order, $valid ) ){
			return $order;
		}
		return $default;
	}

	/**
	 * Sanitize Version
	 */
	public static function sanitize_version( $input ){
		$output = sanitize_text_field( $input );
		$output = str_replace( ' ', '', $output );
		return trim( esc_attr( $output ) );
	}

	/**
	 * Sanitize IDs
	 */
	public static function sanitize_ids( $input ){
		$output = explode( ",", $input );
		$output = array_map( "strip_tags", $output );
		$output = implode( ",", $output );
		return $output;
	}

	/**
	 * Sanitize Row Datas
	 */
	public static function sanitize_rows_data( $input ){
		if( ! is_array( $input ) || empty( $input ) ){
			return array();
		}
		$rows = array();
		foreach( $input as $row_id => $row_data ){
			$default = array(
				'id'              => $row_id,
				'index'           => '',
				'state'           => 'open',
				'col_num'         => '1',
				'layout'          => '1',
				'col_order'       => '',
				'col_1'           => '',
				'col_2'           => '',
				'col_3'           => '',
				'col_4'           => '',
				'row_title'       => '',
				'row_html_id'     => '',
				'row_html_class'  => '',
			);
			$rows[$row_id]                     = wp_parse_args( $row_data, $default );
			$rows[$row_id]['id']               = strip_tags( $rows[$row_id]['id'] );
			$rows[$row_id]['index']            = strip_tags( $rows[$row_id]['index'] );
			$rows[$row_id]['state']            = self::sanitize_state( $rows[$row_id]['state'] );
			$rows[$row_id]['col_num']          = self::get_col_num( $rows[$row_id]['layout'] );
			$rows[$row_id]['col_1']            = self::sanitize_ids( $rows[$row_id]['col_1'] );
			$rows[$row_id]['col_2']            = self::sanitize_ids( $rows[$row_id]['col_2'] );
			$rows[$row_id]['col_3']            = self::sanitize_ids( $rows[$row_id]['col_3'] );
			$rows[$row_id]['col_4']            = self::sanitize_ids( $rows[$row_id]['col_4'] );
			$rows[$row_id]['row_title']        = sanitize_text_field( $rows[$row_id]['row_title'] );
			$rows[$row_id]['row_html_id']      = sanitize_html_class( $rows[$row_id]['row_html_id'] );
			$rows[$row_id]['row_html_class']   = Fs::sanitize_html_classes( $rows[$row_id]['row_html_class'] );
		}
		return $rows;
	}

	/**
	 * Sanitize Items Datas
	 */
	public static function sanitize_items_data( $input ){
		if( ! is_array( $input ) || empty( $input ) ){
			return array();
		}
		$items = array();
		foreach( $input as $item_id => $item_data ){
			$default = array(
				'item_id'      => $item_id,
				'item_index'   => '',
				'item_state'   => 'open',
				'item_type'    => 'text',
				'row_id'       => '',
				'col_index'    => 'col_1',
				'content'      => '',
			);
			$items[$item_id]                  = wp_parse_args( $item_data, $default );
			$items[$item_id]['item_id']       = strip_tags( $items[$item_id]['item_id'] );
			$items[$item_id]['item_index']    = strip_tags( $items[$item_id]['item_index'] );
			$items[$item_id]['item_state']    = self::sanitize_state( $items[$item_id]['item_state'] );
			$items[$item_id]['item_type']     = self::sanitize_item_type( $items[$item_id]['item_type'] );
			$items[$item_id]['row_id']        = strip_tags( $items[$item_id]['row_id'] );
			$items[$item_id]['col_index']     = self::sanitize_item_col_index( $items[$item_id]['col_index'] );
			$items[$item_id]['content']       = wp_kses_post( $items[$item_id]['content'] );
		}
		return $items;
	}

	/**
	 * Sanitize State
	 */
	public static function sanitize_state( $input ){
		$default = 'open';
		$valid = array( 'open', 'close' );
		if( in_array( $input, $valid ) ){
			return $input;
		}
		return $default;
	}

	/**
	 * Get Col Number from Layout
	 */
	public static function get_col_num( $layout ){
		if( '1' == $layout ){
			return 1;
		}
		elseif( in_array( $layout, array( '12_12', '13_23', '23_13' ) ) ){
			return 2;
		}
		elseif( '13_13_13' == $layout ){
			return 3;
		}
		elseif( '14_14_14_14' == $layout ){
			return 4;
		}
		return 1; // fallback
	}

	/**
	 * Sanitize Col Number from Layout
	 */
	public static function sanitize_item_type( $input ){
		$default = 'text';
		$valid = array( 'text' );
		if( in_array( $input, $valid ) ){
			return $input;
		}
		return $default;
	}

	/**
	 * Sanitize Col Index
	 */
	public static function sanitize_item_col_index( $input ){
		$default = 'col_1';
		$valid = array( 'col_1', 'col_2', 'col_3', 'col_4' );
		if( in_array( $input, $valid ) ){
			return $input;
		}
		return $default;
	}


} // end class


