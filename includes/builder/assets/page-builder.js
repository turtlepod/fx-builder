/**
 * Render Page Builder
 */
jQuery(document).ready(function($){

	/* ADD ROW
	------------------------------------------ */
	var row_template = wp.template( 'fxb-row' );
	$( document.body ).on( 'click', '.fxb-add-row', function(e){
		e.preventDefault();
		$( '#fxb' ).prepend( row_template( {
			id       : new Date().getTime(),
			col      : '1',
			col_num  : '1',
			stack    : 'l2r',
			order    : '1',
			state    : 'open',
		} ) );
	} );


	/* REMOVE ROW
	------------------------------------------ */
	$( document.body ).on( 'click', '.fxb-remove-row', function(e){
		var confirm_remove_row = confirm( 'Delete row?' );
		if ( true ===  confirm_remove_row ){
			$( this ).parents( '.fxb-row' ).remove();
		}
	} );


	/* TOGGLE ROW
	------------------------------------------ */
	$( document.body ).on( 'click', '.fxb-toggle-row', function(e){
		var row = $( this ).parents( '.fxb-row' );
		var row_state = row.data( 'state' );
		if( 'open' == row_state ){
			row.data( 'state', 'close' );
			row.attr( 'data-state', 'close' );
			row.find( 'input[data-setting="state"]' ).val( 'close' );
		}
		else{
			row.data( 'state', 'open' );
			row.attr( 'data-state', 'open' );
			row.find( 'input[data-setting="state"]' ).val( 'open' );
		}
	} );

	/* ROW SETTING
	------------------------------------------ */
	


	/* IFRAME STUFF
	------------------------------------------ */

	/* Get iframe CSS */
	var fxB_iframeCSS = $.fn.fxB_getIframeCSS();

	/* For each item textarea, load iframe content. */
	$( '.fxb-item-textarea' ).each( function( index ) {
		$( this ).fxB_loadIframe( fxB_iframeCSS );
	});

});