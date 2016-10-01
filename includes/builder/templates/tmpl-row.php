<?php
/**
 * Row Underscore.js Template
 * 
 * Row data saved as "fxb_rows" meta key
 * Row order saved as "fxb_row_ids" meta key
 *
 * Hidden Fields:
 * - "id"           : unique row id (time stamp when row was created)
 * - "index"        : order of the row (1st row = "1", 2nd row = "2", etc)
 * - "state"        : "open" vs "closed" (toggle state of the row)
 * - "col_num"      :  number of column in the layout (based on selected "col_order")
 *
 * Settings Fields:
 * - "layout"       : column layout (1 col, 1/2 - 1/2, etc)
 * - "col_order"    : collapse order, "default" (no val), "l2r" (left first/on top) vs "r2l" (right first)
 *
 * Item IDs Order (Hidden):
 * - "col_1"        : item IDs for 1st column in comma separated value
 * - "col_2"
 * - "col_3"
 * - "col_4"
**/
namespace fx_builder\builder;
global $fxb_admin_color;
?>
<script id="tmpl-fxb-row" type="text/html">

	<div class="fxb-row fxb-clear" data-id="{{data.id}}" data-index="{{data.index}}"  data-state="{{data.state}}" data-col_num="{{data.col_num}}" data-layout="{{data.layout}}" data-col_order="{{data.col_order}}">

		<?php /* HIDDEN FIELD */ ?>
		<input type="hidden" data-row_field="id" name="_fxb_rows[{{data.id}}][id]" value="{{data.id}}" autocomplete="off"/>

		<input type="hidden" data-row_field="index" name="_fxb_rows[{{data.id}}][index]" value="{{data.index}}" autocomplete="off"/>

		<input type="hidden" data-row_field="state" name="_fxb_rows[{{data.id}}][state]" value="{{data.state}}" autocomplete="off"/>

		<input type="hidden" data-row_field="col_num" name="_fxb_rows[{{data.id}}][col_num]" value="{{data.col_num}}" autocomplete="off"/>

		<?php /* ROW MENU */ ?>
		<div class="fxb-row-menu fxb-clear" style="background-color:<?php echo esc_attr( $fxb_admin_color['1'] );?>">
			<div class="fxb-left">
				<span class="fxb-icon fxb-grab fxb-row-handle dashicons dashicons-sort"></span>
				<span class="fxb-icon fxb_row_index" data-row-index="{{data.index}}"></span>
				<span class="fxb-icon fxb_row_title" data-row-title="{{data.row_title}}"></span>
			</div><!-- .fxb-left -->
			<div class="fxb-right">
				<span data-target=".fxb-row-settings" class="fxb-icon fxb-link fxb-settings dashicons dashicons-admin-generic"></span>
				<span data-confirm="<?php _e( 'Delete row?', 'fx-builder' ); ?>" class="fxb-icon fxb-link fxb-remove-row dashicons dashicons-trash"></span>
				<span class="fxb-icon fxb-link fxb-toggle-row dashicons dashicons-arrow-up"></span>
				<?php /* SETTINGS */ ?>
				<?php Functions::render_settings( array(
					'id'        => 'fxb-row-settings', // data-target
					'title'     => __( 'Row Settings', 'fx-builder' ),
					'callback'  => __NAMESPACE__ . '\Functions::row_settings',
				));?>
			</div><!-- .fxb-right -->
		</div><!-- .fxb-row-menu -->

		<?php /* ROW CONTENT */ ?>
		<div class="fxb-row-content fxb-clear">

			<?php Functions::render_column( array(
				'title'  => __( '1st Column', 'fx-builder' ),
				'index'  => 1,
			) ); ?>

			<?php Functions::render_column( array(
				'title'  => __( '2nd Column', 'fx-builder' ),
				'index'  => 2,
			) ); ?>

			<?php Functions::render_column( array(
				'title'  => __( '3rd Column', 'fx-builder' ),
				'index'  => 3,
			) ); ?>

			<?php Functions::render_column( array(
				'title'  => __( '4th Column', 'fx-builder' ),
				'index'  => 4,
			) ); ?>

		</div><!-- .fxb-row-content -->

	</div><!-- .fxb-row -->

</script>
