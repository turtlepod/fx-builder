/**
 * f(x) Page Builder App
 */
;(function($){

	/**
	 * Get Iframe CSS
	 */
	$.fn.fxB_getIframeCSS = function() {
		var iframe_styles = tinyMCEPreInit.mceInit.content.content_css.split(',');
		var iframe_css = '';
		/* Loop each styles and create link el. */
		if( typeof iframe_styles !== 'undefined' ){
			iframe_styles.forEach( function( item ){
				iframe_css += '<link type="text/css" rel="stylesheet" href="' + item + '" />';
			});
		}
		return iframe_css;
	};

	/**
	 * Load Iframe Content For Each Textarea
	 */
	$.fn.fxB_loadIframe = function( head ) {
		var iframe = this.siblings( '.fxb-item-iframe' );
		iframe.contents().find( "head" ).append( head );
		iframe.contents().find( "body" ).append( this.val() );
	};

	/**
	 * Update Rows Order
	 */
	$.fn.fxB_updateRowsOrder = function( row_ids ) {

		/* Update each rows attr */
		$( '#fxb > .fxb-row' ).each( function(i){

			/* get index number */
			var num = i + 1;

			/* set order */
			$( this ).data( 'order', num );

			/* get order */
			var row_order = $( this ).data( 'order' );

			/* change text */
			$( this ).find( '.fxb_row_order' ).text( row_order );

			/* change hidden input */
			$( this ).find( 'input[data-setting="order"]' ).val( row_order );
		});

		/* Update Hidden Input */
		if( typeof row_ids !== 'undefined' ){
			$( 'input[name="fxb_row_order"]' ).val( row_ids.join() );
		}
	};

	
	/* Load Functions
	------------------------------------------ */
	jQuery( document ).ready( function( $ ){
		$.fn.fxB_updateRowsOrder();
	});

	

	
	
})(jQuery);


























