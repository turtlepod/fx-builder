/**
 * Render Page Builder
 */
jQuery(document).ready(function($){

	/* ADD ITEM
	------------------------------------------ */
	var item_template = wp.template( 'fxb-item' );
	$( document.body ).on( 'click', '.fxb-add-item', function(e){
		e.preventDefault();

		var target_container = $( this ).siblings( '.fxb-col-content' );
		var new_id = new Date().getTime();

		$( target_container ).prepend( item_template( {
			item_id  : new_id,
			state    : 'open',
		} ) );

		/* Add new ID to hidden input */
		var input = $( this ).siblings( 'input[data-id="item_order"]' );
		var item_ids = [new_id];
		var old_ids = input.val();
		if( '' !== old_ids ){
			old_ids = old_ids.split( ',' ); // make it array
			item_ids = $.merge( item_ids, old_ids );
		}
		input.val( item_ids.join() );

		/* Make it sortable */
		fxb_make_item_sortable();
	} );


	/* REMOVE ITEM
	------------------------------------------ */
	$( document.body ).on( 'click', '.fxb-remove-item', function(e){
		e.preventDefault();
		var confirm_remove_item = confirm( $( this ).data( 'confirm' ) );
		if ( true ===  confirm_remove_item ){

			/* Get current col */
			var this_col = $( this ).parents( '.fxb-col' );

			/* Remove item */
			$( this ).parents( '.fxb-item' ).remove();

			/* Generate new list */
			var items = [];
			this_col.find( '.fxb-item' ).each( function(i){
				items[i] = $( this ).data( 'item_id' );
			});

			/* Update Input */
			var input = this_col.find( 'input[data-id="item_order"]' );
			input.val( items.join() )
		}
	} );


	/* TOGGLE ITEM
	------------------------------------------ */
	$( document.body ).on( 'click', '.fxb-toggle-item', function(e){
		e.preventDefault();
		var item = $( this ).parents( '.fxb-item' );
		var item_state = item.data( 'state' );
		/* Toggle State */
		if( 'open' == item_state ){
			item.data( 'state', 'close' ); // set data
			var item_state = item.data( 'state' ); // get data
			item.attr( 'data-state', item_state ); // change attr for styling
			item.find( 'input[data-setting="state"]' ).val( item_state ); // change hidden input
		}
		else{
			item.data( 'state', 'open' );
			var item_state = item.data( 'state' );
			item.attr( 'data-state', item_state );
			item.find( 'input[data-setting="state"]' ).val( item_state );
		}
	} );


	/* SORT ITEM
	------------------------------------------ */
	function fxb_make_item_sortable(){
		$( '.fxb-col-content' ).sortable({
			handle      : '.fxb-item-handle',
			cursor      : 'grabbing',
			connectWith : ".fxb-col-content",
			update      : function( e, ui ) {
				var item_ids = $( this ).sortable( 'toArray', {attribute: 'data-item_id'} );
				var input = $( this ).parents( '.fxb-col' ).find( 'input[data-id="item_order"]' );
				
				/* Update hidden input */
				input.val( item_ids.join() );
			},
		});
	}
	fxb_make_item_sortable();













	/* IFRAME STUFF
	------------------------------------------ */
	/* Get iframe CSS */
	//var fxB_iframeCSS = $.fn.fxB_getIframeCSS();

	/* For each item textarea, load iframe content. */
	//$( '.fxb-item-textarea' ).each( function( index ) {
	//	$( this ).fxB_loadIframe( fxB_iframeCSS );
	//});
});




























