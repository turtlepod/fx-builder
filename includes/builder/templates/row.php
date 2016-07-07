<?php
/**
 * Row Underscore.js Template
**/
namespace fx_builder\builder;
?>
<script id="tmpl-fxb-row" type="text/html">

	<div class="fxb-row fxb-clear" data-id="{{data.id}}" data-col_num="{{data.col_num}}" data-col="{{data.col}}" data-stack="{{data.stack}}" data-state="{{data.state}}" data-order="{{data.order}}">

		<?php /* HIDDEN INPUT */ ?>
		<input type="hidden" data-setting="id" name="fxb_row[{{data.id}}][setting][id]" value="{{data.id}}" autocomplete="off"/>
		<input type="hidden" data-setting="order" name="fxb_row[{{data.id}}][setting][order]" value="{{data.order}}" autocomplete="off"/>
		<input type="hidden" data-setting="state" name="fxb_row[{{data.id}}][setting][state]" value="{{data.state}}" autocomplete="off"/>
		<input type="hidden" data-setting="col_num" name="fxb_row[{{data.id}}][setting][col_num]" value="{{data.col_num}}" autocomplete="off"/>

		<?php /* ITEMS ORDER */ ?>
		<input type="hidden" data-id="col1" name="fxb_row[{{data.id}}][col1][order]" value="" autocomplete="off"/>
		<input type="hidden" data-id="col2" name="fxb_row[{{data.id}}][col2][order]" value="" autocomplete="off"/>
		<input type="hidden" data-id="col3" name="fxb_row[{{data.id}}][col3][order]" value="" autocomplete="off"/>
		<input type="hidden" data-id="col4" name="fxb_row[{{data.id}}][col4][order]" value="" autocomplete="off"/>

		<?php /* ROW MENU */ ?>
		<div class="fxb-row-menu fxb-clear">
			<div class="fxb-left">
				<span class="fxb-icon fxb-grab fxb-row-handle dashicons dashicons-sort"></span>
				<span class="fxb-icon fxb-row-order">{{data.order}}</span>
			</div><!-- .fxb-left -->
			<div class="fxb-right">
				<span data-target=".fxb-row-settings" class="fxb-icon fxb-link fxb-settings dashicons dashicons-admin-generic"></span>
				<span data-confirm="<?php _e( 'Delete row?', 'fx-builder' ); ?>" class="fxb-icon fxb-link fxb-remove fxb-remove-row dashicons dashicons-trash"></span>
				<span class="fxb-icon fxb-link fxb-toggle-row dashicons dashicons-arrow-up"></span>

				<?php /* SETTINGS */ ?>
				<?php render_settings( array(
					'id' => 'fxb-row-settings',
					'title' => __( 'Row Settings', 'fx-builder' ),
					'callback'  => function(){
						?>

						<?php /* Row Layout */ ?>
						<div class="fxb-modal-field fxb-modal-field-select">

							<label for="fxb_row[{{data.id}}][setting][col]">
								<?php esc_html_e( 'Row Layout', 'fx-builder' ); ?>
							</label>

							<select id="fxb_row[{{data.id}}][setting][col]" data-setting="col" name="fxb_row[{{data.id}}][setting][col]" autocomplete="off">

								<option data-col_num="1" value="1" <# if( data.col == '1' ){ print('selected="selected"') } #>><?php _e( '1 Column', 'fx-builder' ); ?></option>

								<option data-col_num="2" value="12_12" <# if( data.col == '12_12' ){ print('selected="selected"') } #>><?php _e( '1/2 - 1/2', 'fx-builder' ); ?></option>

								<option data-col_num="2" value="13_23" <# if( data.col == '13_23' ){ print('selected="selected"') } #>><?php _e( '1/3 - 2/3', 'fx-builder' ); ?></option>

								<option data-col_num="2" value="23_13" <# if( data.col == '23_13' ){ print('selected="selected"') } #>><?php _e( '2/3 - 1/3', 'fx-builder' ); ?></option>

								<option data-col_num="3" value="13_13_13" <# if( data.col == '13_13_13' ){ print('selected="selected"') } #>><?php _e( '1/3 - 1/3 - 1/3', 'fx-builder' ); ?></option>

								<option data-col_num="4" value="14_14_14_14" <# if( data.col == '14_14_14_14' ){ print('selected="selected"') } #>><?php _e( '1/4 - 1/4 - 1/4 - 1/4', 'fx-builder' ); ?></option>

							</select>

						</div><!-- .fxb-modal-field -->

						<?php /* Stack */ ?>
						<div class="fxb-modal-field fxb-modal-field-select">

							<label for="fxb_row[{{data.id}}][setting][stack]">
								<?php esc_html_e( 'Collapse Order', 'fx-builder' ); ?>
							</label>

							<select id="fxb_row[{{data.id}}][setting][stack]" data-setting="stack" name="fxb_row[{{data.id}}][setting][stack]" autocomplete="off">

								<option value="" <# if( data.stack == '' ){ print('selected="selected"') } #>><?php _e( 'Default', 'fx-builder' ); ?></option>

								<option value="l2r" <# if( data.stack == 'l2r' ){ print('selected="selected"') } #>><?php _e( 'Left on Top', 'fx-builder' ); ?></option>

								<option value="r2l" <# if( data.stack == 'r2l' ){ print('selected="selected"') } #>><?php _e( 'Right on Top', 'fx-builder' ); ?></option>

							</select>

						</div><!-- .fxb-modal-field -->
						<?php
					},
				));?>

			</div><!-- .fxb-right -->
		</div><!-- .fxb-row-menu -->

		<div class="fxb-row-content fxb-clear">

			<?php render_column( array(
				'title' => __( '1st Column', 'fx-builder' ),
			) ); ?>

			<?php render_column( array(
				'title' => __( '2nd Column', 'fx-builder' ),
			) ); ?>

			<?php render_column( array(
				'title' => __( '3rd Column', 'fx-builder' ),
			) ); ?>

			<?php render_column( array(
				'title' => __( '4th Column', 'fx-builder' ),
			) ); ?>

		</div><!-- .fxb-row-content -->

	</div><!-- .fxb-row -->

</script>
