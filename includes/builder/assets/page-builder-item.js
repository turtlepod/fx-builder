/**
 * F(X) BUILDER JS: ITEMS
*************************************/

 
/* Functions
------------------------------------------ */
;(function($){

	/**
	 * UPDATE ITEMS INDEX
	 ************************************
	 */
	$.fn.fxB_updateItemsIndex = function( col ) {

		/* Var Row IDs */
		var row_id         = col.parents( '.fxb-row' ).data( 'id' );
		var col_index      = col.data( 'col_index' );
		var items_input    = col.find( 'input[data-row_field="' + col_index + '"]' );
		var item_ids       = [];

		/* Update each rows attr */
		$( col ).find( '.fxb-col-content > .fxb-item' ).each( function(i){

			/* Var */
			var num = i + 1;
			var item_id = $( this ).data( 'item_id' );

			/* Set data */
			$( this ).data( 'item_index', num ); // set index
			var item_index = $( this ).data( 'item_index' ); // get index

			/* Update Item Index */
			$( this ).attr( 'data-item_index', item_index ); // set data attr
			$( this ).find( '.fxb_item_index' ).text( item_index ); // display text
			$( this ).find( 'input[data-item_field="item_index"]' ).val( item_index ); // change input

			/* Update Row ID and Col Index */
			$( this ).data( 'row_id', row_id );
			$( this ).find( 'input[data-item_field="row_id"]' ).val( row_id );
			$( this ).data( 'col_index', col_index );
			$( this ).find( 'input[data-item_field="col_index"]' ).val( col_index );

			/* Get ID */
			item_ids.push( item_id );
		});

		/* Update Hidden Input */
		items_input.val( item_ids.join() );
	};

	/**
	 * MAKE ITEMS SORTABLE
	 ************************************
	 */
	$.fn.fxB_sortItems = function( col ) {

		$( '.fxb-col-content' ).sortable({
			handle      : '.fxb-item-handle',
			cursor      : 'grabbing',
			connectWith : ".fxb-col-content",
			update      : function( e, ui ) {

				/* Var */
				var col = $( this ).parents( '.fxb-col' );

				/* Update Index */
				$.fn.fxB_updateItemsIndex( col );
			},
		});
	};


	/**
	 * Get Iframe CSS
	 */
	$.fn.fxB_getIframeCSS = function() {
		var iframe_styles = tinyMCEPreInit.mceInit.content.content_css;
		var iframe_css = '';
		/* Loop each styles and create link el. */
		if( typeof iframe_styles !== 'undefined' ){
			iframe_styles.split(',').forEach( function( item ){
				iframe_css += '<link type="text/css" rel="stylesheet" href="' + item + '" />';
			});
		}
		return iframe_css;
	};

	/**
	 * Load Iframe
	 */
	$.fn.fxB_loadIfameContent = function( head ){
		var iframe = this;
		var content = iframe.siblings( '.fxb-item-textarea' ).val();
		iframe.contents().find('head').html( head );
		iframe.contents().find('body').html( content );
		$( iframe ).on('load', function() {
			$( this ).contents().find('head').html( head );
			$( this ).contents().find('body').html( content );
		});
	};


})(jQuery);


/* Document Ready
------------------------------------------ */
jQuery(document).ready(function($){

	/**
	 * VAR
	 * 
	 ************************************
	 */
	var item_template = wp.template( 'fxb-item' );
	var iframe_css = $.fn.fxB_getIframeCSS();

	/**
	 * MAKE SORTABLE ON PAGE LOAD
	 * 
	 ************************************
	 */
	$.fn.fxB_sortItems();


	/**
	 * PREPARE IFRAME ON PAGE LOAD
	 * 
	 ************************************
	 */
	$( '.fxb-item-iframe' ).each( function(i){
		$( this ).fxB_loadIfameContent( iframe_css );
	} );



	/**
	 * ADD NEW ITEM
	 *
	 * Add new item in the column when click new item (+) button.
	 * 
	 ************************************
	 */
	$( document.body ).on( 'click', '.fxb-add-item', function(e){
		e.preventDefault();

		/* Vars */
		var items_container = $( this ).siblings( '.fxb-col-content' );
		var item_id         = new Date().getTime();
		var col             = $( this ).parents( '.fxb-col' );

		/* Add template to container */
		$( items_container ).prepend( item_template( {
			item_id     : item_id,
			item_index  : '1',
			item_state  : 'open',
			item_type   : 'text',
		} ) );

		/* Update Index */
		$.fn.fxB_updateItemsIndex( col );

		/* Load Iframe */
		$( '.fxb-item[data-item_id="' + item_id + '"] .fxb-item-iframe' ).fxB_loadIfameContent( iframe_css );

		/* Make Sortable */
		$.fn.fxB_sortItems();
	} );


	/**
	 * REMOVE ITEM
	 *
	 ************************************
	 */
	$( document.body ).on( 'click', '.fxb-remove-item', function(e){
		e.preventDefault();

		/* Confirm delete */
		var confirm_delete = confirm( $( this ).data( 'confirm' ) );
		if ( true ===  confirm_delete ){

			/* Vars */
			var item = $( this ).parents( '.fxb-item' );
			var col  = $( this ).parents( '.fxb-col' );

			/* Remove item */
			item.remove();

			/* Update Index */
			$.fn.fxB_updateItemsIndex( col );
		}
	} );


	/**
	 * TOGGLE ITEM STATE
	 *
	 * Open/Close item using toggle arrow icon.
	 * 
	 ************************************
	 */
	$( document.body ).on( 'click', '.fxb-toggle-item', function(e){
		e.preventDefault();

		/* Var */
		var item = $( this ).parents( '.fxb-item' );
		var item_state = item.data( 'item_state' );

		/* Toggle State */
		if( 'open' == item_state ){
			item.data( 'item_state', 'close' ); // set data
		}
		else{
			item.data( 'item_state', 'open' );
		}

		/* Update state */
		var item_state = item.data( 'item_state' ); // get data
		item.attr( 'data-item_state', item_state ); // change attr for styling
		item.find( 'input[data-item_field="item_state"]' ).val( item_state ); // change hidden input
	} );


	/**
	 * SORT ITEM
	 * 
	 ************************************
	 */
	$( '.fxb-col-content' ).sortable({
		handle      : '.fxb-item-handle',
		cursor      : 'grabbing',
		connectWith : ".fxb-col-content",
		update      : function( e, ui ) {

			/* Var */
			var col = $( this ).parents( '.fxb-col' );

			/* Update Index */
			$.fn.fxB_updateItemsIndex( col );
		},
	});

});




























