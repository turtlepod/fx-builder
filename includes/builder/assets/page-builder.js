/**
 * Render Page Builder
 */
jQuery(document).ready(function($){


	/* ADD ROW
	------------------------------------------ */
	var row_template = wp.template( 'fxb-row' );
	$( document.body ).on( 'click', '.fxb-add-row', function(e){
		e.preventDefault();

		/* Add Row */
		var new_id = new Date().getTime();
		$( '#fxb' ).prepend( row_template( {
			id       : new_id,
			col      : '1',
			col_num  : '1',
			stack    : '',
			order    : '1',
			state    : 'open',
		} ) );

		/* Make it sortable */
		var row_ids = [new_id];
		var old_ids = $( 'input[name="fxb-row-order"]' ).val();
		if( '' !== old_ids ){
			old_ids = old_ids.split(',');
			row_ids = $.merge( row_ids, old_ids );
		}
		$.fn.fxB_updateRowsOrder( row_ids );

	} );


	/* REMOVE ROW
	------------------------------------------ */
	$( document.body ).on( 'click', '.fxb-remove-row', function(e){
		e.preventDefault();
		var confirm_remove_row = confirm( $( this ).data( 'confirm' ) );
		if ( true ===  confirm_remove_row ){
			$( this ).parents( '.fxb-row' ).remove();
		}
	} );


	/* TOGGLE ROW
	------------------------------------------ */
	$( document.body ).on( 'click', '.fxb-toggle-row', function(e){
		e.preventDefault();
		var row = $( this ).parents( '.fxb-row' );
		var row_state = row.data( 'state' );
		if( 'open' == row_state ){
			row.data( 'state', 'close' ); // set data
			var row_state = row.data( 'state' ); // get data
			row.attr( 'data-state', row_state ); // change attr for styling
			row.find( 'input[data-setting="state"]' ).val( row_state ); // change hidden input
		}
		else{
			row.data( 'state', 'open' );
			var row_state = row.data( 'state' );
			row.attr( 'data-state', row_state );
			row.find( 'input[data-setting="state"]' ).val( row_state );
		}
	} );


	/* ROW SETTING
	------------------------------------------ */

	/* Open settings */
	$( document.body ).on( 'click', '.fxb-settings', function(e){
		e.preventDefault();
		var target = $( this ).data( 'target' );
		$( '.fxb-modal-overlay' ).show();
		$( this ).siblings( target ).show();
	} );

	/* Close Settings */
	$( document.body ).on( 'click', '.fxb-modal-close', function(e){
		e.preventDefault();
		$( this ).parents( '.fxb-modal' ).hide();
		$( '.fxb-modal-overlay' ).hide();
	} );


	/* ROW SETTINGS: Change Layout
	------------------------------------------ */

	$( document.body ).on( 'change', 'select[data-setting="col"]', function(e){
		e.preventDefault();

		/* Get selected value */
		var selected_col = $( this ).val();
		var selected_col_num = $( 'option:selected', this ).attr( 'data-col_num' );

		/* Update Row Data */
		var row = $( this ).parents( '.fxb-row' );
		row.data( 'col', selected_col );
		row.attr( 'data-col', row.data( 'col' ) );
		row.data( 'col_num', selected_col_num );
		row.attr( 'data-col_num', row.data( 'col_num' ) );

		/* Update hidden Input */
		row.find( 'input[data-setting="col_num"]' ).val( row.data( 'col_num' ) );
	} );


	/* ROW SETTINGS: Change Stack/Collapse Order
	------------------------------------------ */

	$( document.body ).on( 'change', 'select[data-setting="stack"]', function(e){
		e.preventDefault();

		/* Get selected value */
		var selected = $( this ).val();

		/* Update Row Data */
		var row = $( this ).parents( '.fxb-row' );
		row.data( 'stack', selected );
		row.attr( 'data-stack', row.data( 'stack' ) );
	} );


	/* SORT ROW
	------------------------------------------ */
	$( '#fxb' ).sortable({
		handle  : '.fxb-row-handle',
		cursor  : 'grabbing',
		axis    : 'y',
		stop    : function( e, ui ) {

			/* Update row attr order */
			var row_ids = $( this ).sortable( 'toArray', {attribute: 'data-id'} );
			$.fn.fxB_updateRowsOrder( row_ids );
		},
	});


	/* IFRAME STUFF
	------------------------------------------ */

	/* Get iframe CSS */
	var fxB_iframeCSS = $.fn.fxB_getIframeCSS();

	/* For each item textarea, load iframe content. */
	$( '.fxb-item-textarea' ).each( function( index ) {
		$( this ).fxB_loadIframe( fxB_iframeCSS );
	});

});