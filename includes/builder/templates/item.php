<?php
/**
 * Item Underscore.js Template
**/
namespace fx_builder\builder;
?>
<script id="tmpl-fxb-item" type="text/html">

	<div class="fxb-item fxb-clear" data-item_id="{{data.item_id}}" data-state="{{data.state}}">

		<?php /* HIDDEN INPUT */ ?>
		<input type="hidden" data-setting="item_id" name="fxb_item[{{data.item_id}}][setting][id]" value="{{data.item_id}}" autocomplete="off"/>
		<input type="hidden" data-setting="state" name="fxb_item[{{data.item_id}}][setting][state]" value="{{data.state}}" autocomplete="off"/>

		<div class="fxb-item-menu fxb-clear">
			<div class="fxb-left">
				<span class="fxb-icon fxb-grab fxb-item-handle dashicons dashicons-move"></span>
			</div><!-- .fxb-left -->
			<div class="fxb-right">
				<span data-confirm="<?php _e( 'Delete item?', 'fx-builder' ); ?>" class="fxb-icon fxb-remove-item fxb-link dashicons dashicons-trash"></span>
				<span class="fxb-icon fxb-toggle-item fxb-link dashicons dashicons-arrow-up"></span>
			</div><!-- .fxb-right -->
		</div><!-- .fxb-item-menu -->

		<div class="fxb-item-content">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas a tortor quam. Vestibulum aliquet, diam eget dignissim vehicula, sapien sapien tempor velit, a ultrices tellus turpis nec nunc.</p>
		</div><!-- .fxb-item-content -->

	</div><!-- .fxb-item -->

</script>
