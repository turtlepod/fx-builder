<?php
/**
 * Row Underscore.js Template
**/
namespace fx_builder\builder;
?>
<script id="tmpl-fxb-row" type="text/html">

	<div class="fxb-row fxb-clear" data-id="{{data.id}}" data-col-num="{{data.col_num}}" data-col="{{data.col}}" data-stack="{{data.stack}}" data-state="{{data.state}}" data-order="{{data.order}}">

		<input type="hidden" data-setting="id" name="fxb_row[{{data.id}}][setting][id]" value="{{data.id}}">
		<input type="hidden" data-setting="order" name="fxb_row[{{data.id}}][setting][order]" value="{{data.order}}">
		<input type="hidden" data-setting="col" name="fxb_row[{{data.id}}][setting][col]" value="{{data.col}}">
		<input type="hidden" data-setting="col_num" name="fxb_row[{{data.id}}][setting][col_num]" value="{{data.col_num}}">
		<input type="hidden" data-setting="stack" name="fxb_row[{{data.id}}][setting][stack]" value="{{data.stack}}">
		<input type="hidden" data-setting="state" name="fxb_row[{{data.id}}][setting][state]" value="{{data.state}}">

		<?php /* ROW MENU */ ?>
		<div class="fxb-row-menu fxb-clear">
			<div class="fxb-left">
				<span class="fxb-icon fxb-grab fxb-handle dashicons dashicons-sort"></span>
				<span class="fxb-icon fxb-order">{{data.order}}</span>
			</div><!-- .fxb-left -->
			<div class="fxb-right">
				<span class="fxb-icon fxb-link fxb-setting dashicons dashicons-admin-generic"></span>
				<span class="fxb-icon fxb-link fxb-remove fxb-remove-row dashicons dashicons-trash"></span>
				<span class="fxb-icon fxb-link fxb-toggle fxb-toggle-row dashicons dashicons-arrow-up"></span>
			</div><!-- .fxb-right -->
		</div><!-- .fxb-row-menu -->

		<div class="fxb-row-content fxb-clear">

			<?php /* COL #1 */ ?>
			<div class="fxb-col fxb-clear">
				<h3 class="fxb-col-title"><span><?php _e( '1st Column', 'fx-builder' ); ?></span></h3>
				<div class="fxb-col-content">
				</div><!-- .fxb-col-content -->
				<div class="fxb-add-item fxb-link">
					<span><?php _e( 'Add Item', 'fx-builder' );?></span>
				</div><!-- .fxb-add-item -->
			</div><!-- .fxb-col -->

			<?php /* COL #2 */ ?>
			<div class="fxb-col fxb-clear">
				<h3 class="fxb-col-title"><span><?php _e( '2nd Column', 'fx-builder' ); ?></span></h3>
				<div class="fxb-col-content">
				</div><!-- .fxb-col-content -->
				<div class="fxb-add-item fxb-link">
					<span><?php _e( 'Add Item', 'fx-builder' );?></span>
				</div><!-- .fxb-add-item -->
			</div><!-- .fxb-col -->

			<?php /* COL #3 */ ?>
			<div class="fxb-col fxb-clear">
				<h3 class="fxb-col-title"><span><?php _e( '3rd Column', 'fx-builder' ); ?></span></h3>
				<div class="fxb-col-content">
				</div><!-- .fxb-col-content -->
				<div class="fxb-add-item fxb-link">
					<span><?php _e( 'Add Item', 'fx-builder' );?></span>
				</div><!-- .fxb-add-item -->
			</div><!-- .fxb-col -->

			<?php /* COL #4 */ ?>
			<div class="fxb-col fxb-clear">
				<h3 class="fxb-col-title"><span><?php _e( '4th Column', 'fx-builder' ); ?></span></h3>
				<div class="fxb-col-content">
				</div><!-- .fxb-col-content -->
				<div class="fxb-add-item fxb-link">
					<span><?php _e( 'Add Item', 'fx-builder' );?></span>
				</div><!-- .fxb-add-item -->
			</div><!-- .fxb-col -->

		</div><!-- .fxb-row-content -->

	</div><!-- .fxb-row -->

</script>


