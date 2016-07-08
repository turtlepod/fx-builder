<?php
/**
 * TEMP: Inline Script
 */
namespace fx_builder\builder;

/* Load initial rows */

//ccdd( $rows_data );

/* Load Script to Admin Footer */
add_action( 'admin_footer', __NAMESPACE__ . '\print_script_init' );

/**
 * Load initial/saved content
 */
function print_script_init(){
	$post_id = get_the_ID();

	/* Rows data */
	$rows_data   = get_post_meta( $post_id, 'fxb_rows', true );
	$row_ids     = get_post_meta( $post_id, 'fxb_row_ids', true );
	if( ! $rows_data && $row_ids && is_array( $rows_data ) && is_array( $row_ids ) ){ return false; }
	$rows        = explode( ',', $row_ids );

	/* Items data */
	$items_data  = get_post_meta( $post_id, 'fxb_items', true );
	ccdd( $rows_data, '$rows_data' );
	ccdd( $items_data, '$items_data' );
?>

	<script type="text/javascript">
		jQuery( document ).ready( function( $ ) {
			var row_template = wp.template( 'fxb-row' );

			<?php foreach( $rows as $row_id ){ ?>
				<?php if( isset( $rows_data[$row_id] ) ){ ?>
					$( '#fxb' ).append( row_template( <?php echo wp_json_encode( $rows_data[$row_id] ); ?> ) );
				<?php } ?>
			<?php } // end foreach ?>

			<?php if( $items_data && is_array( $items_data ) ){ ?>
				var item_template = wp.template( 'fxb-item' );
				<?php foreach( $items_data as $item_id => $item ){ ?>
					<?php if( isset( $rows_data[$item['row_id']] ) ){ ?>
						$( '.fxb-row[data-id="<?php echo $item['row_id']; ?>"] .fxb-col[data-col_index="<?php echo $item['col_index']; ?>"] .fxb-col-content' ).append( item_template( <?php echo wp_json_encode( $item ); ?> ) );
					<?php } ?>
				<?php } // end foreach ?>
			<?php } ?>

		} );
	</script>

<?php
}















