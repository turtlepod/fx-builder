<?php
namespace fx_builder\builder;

/**
 * Functions.
 * @since 1.0.0
 */
class Functions{

	/**
	 * Render Modal Box Settings HTML
	 * @since 1.0.0
	 */
	public static function render_settings( $args = array() ){
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
				<div class="fxb-modal-title"><?php echo $args['title']; ?><span class="fxb-modal-close"><?php _e( 'Done', 'fx-builder' ); ?></span></div><!-- .fxb-modal-title -->

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
	 * This is loaded in underscore template
	**/
	public static function row_settings(){
	?>
		<div class="fxb-modal-field fxb-modal-field-select">

			<label for="fxb_rows[{{data.id}}][layout]">
				<?php esc_html_e( 'Row Layout', 'fx-builder' ); ?>
			</label>

			<select id="fxb_rows[{{data.id}}][layout]" data-row_field="layout" name="fxb_rows[{{data.id}}][layout]" autocomplete="off">

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

			<select id="fxb_rows[{{data.id}}][col_order]" data-row_field="col_order" name="fxb_rows[{{data.id}}][col_order]" autocomplete="off">

				<option value="" <# if( data.col_order == '' ){ print('selected="selected"') } #>><?php _e( 'Default', 'fx-builder' ); ?></option>

				<option value="l2r" <# if( data.col_order == 'l2r' ){ print('selected="selected"') } #>><?php _e( 'Left on Top', 'fx-builder' ); ?></option>

				<option value="r2l" <# if( data.col_order == 'r2l' ){ print('selected="selected"') } #>><?php _e( 'Right on Top', 'fx-builder' ); ?></option>

			</select>

		</div><!-- .fxb-modal-field -->
	<?php
	}


	/**
	 * Render (empty) Column
	 */
	public static function render_column( $args = array() ){
		$args_default = array(
			'title'     => '',
			'index'     => '',
		);
		$args  = wp_parse_args( $args, $args_default );
		extract( $args );

		/* Var */
		$field = "col_{$index}";
	?>
		<div class="fxb-col fxb-clear" data-col_index="<?php echo esc_attr( $field ); ?>">

			<?php /* Hidden input */ ?>
			<input type="hidden" data-id="item_ids" data-row_field="<?php echo esc_attr( $field ); ?>" name="fxb_rows[{{data.id}}][<?php echo esc_attr( $field ); ?>]" value="{{data.<?php echo esc_attr( $field ); ?>}}" autocomplete="off"/>

			<?php /* Column Title */ ?>
			<h3 class="fxb-col-title"><span><?php echo $title; ?></span></h3>

			<div class="fxb-col-content"></div><!-- .fxb-col-content -->

			<div class="fxb-add-item fxb-link">
				<span><?php _e( 'Add Item', 'fx-builder' );?></span>
			</div><!-- .fxb-add-item -->

		</div><!-- .fxb-col -->
	<?php
	}



} // end class