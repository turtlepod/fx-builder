<?php
/**
 * Item Underscore.js Template
 * 
 * Item datas saved as "fxb_items" meta key
 * 
 * Datas (all item data need to be prefixed with "item_*" ):
 *
 * Hidden field:
 * "item_id"    : unique item id (time stamp when row was created)
 * "item_state" : toggle state
 * "item_type"  : currently only one "text"
 * 
 * Content:
 * "content"    : hidden textarea (?)
 *
**/
namespace fx_builder\builder;
?>
<script id="tmpl-fxb-item" type="text/html">

	<div class="fxb-item fxb-clear" data-item_id="{{data.item_id}}" data-item_state="{{data.item_state}}" data-item_type="{{data.item_type}}" data-item_index="{{data.item_index}}">

		<?php /* HIDDEN FIELD */ ?>
		<input type="hidden" data-item_field="item_id" name="_fxb_items[{{data.item_id}}][item_id]" value="{{data.item_id}}" autocomplete="off"/>

		<input type="hidden" data-item_field="item_index" name="_fxb_items[{{data.item_id}}][item_index]" value="{{data.item_index}}" autocomplete="off"/>

		<input type="hidden" data-item_field="item_state" name="_fxb_items[{{data.item_id}}][item_state]" value="{{data.item_state}}" autocomplete="off"/>

		<input type="hidden" data-item_field="item_type" name="_fxb_items[{{data.item_id}}][item_type]" value="text" autocomplete="off"/>

		<?php /* CONTEXT FIELD */ ?>
		<input type="hidden" data-item_field="row_id" name="_fxb_items[{{data.item_id}}][row_id]" value="{{data.row_id}}" autocomplete="off"/>

		<input type="hidden" data-item_field="col_index" name="_fxb_items[{{data.item_id}}][col_index]" value="{{data.col_index}}" autocomplete="off"/>

		<?php /* ITEM MENU */ ?>
		<div class="fxb-item-menu fxb-clear">
			<div class="fxb-left">
				<span class="fxb-icon fxb-grab fxb-item-handle dashicons dashicons-move"></span>
				<span class="fxb-icon fxb_item_index" data-item-index="{{data.item_index}}"></span>
			</div><!-- .fxb-left -->
			<div class="fxb-right">
				<span data-confirm="<?php _e( 'Delete item?', 'fx-builder' ); ?>" class="fxb-icon fxb-remove-item fxb-link dashicons dashicons-trash"></span>
				<span class="fxb-icon fxb-toggle-item fxb-link dashicons dashicons-arrow-up"></span>
			</div><!-- .fxb-right -->
		</div><!-- .fxb-item-menu -->

		<div class="fxb-item-content fxb-clear">

			<a href="#" class="fxb-item-iframe-overlay"></a>

			<iframe class="fxb-item-iframe" height="100" width="100%" scrolling="no"></iframe>

			<textarea class="fxb-item-textarea" data-item_field="item_content" name="_fxb_items[{{data.item_id}}][content]" >{{{data.content}}}</textarea>

		</div><!-- .fxb-item-content -->

	</div><!-- .fxb-item -->

</script>
