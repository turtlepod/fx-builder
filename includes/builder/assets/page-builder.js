/**
 * Render Page Builder
 */
jQuery(document).ready(function($){

	/* Get iframe CSS */
	var fxB_iframeCSS = $.fn.fxB_getIframeCSS();

	/* For each item textarea, load iframe content. */
	$( '.fxb-item-textarea' ).each( function( index ) {
		$( this ).fxB_loadIframe( fxB_iframeCSS );
	});

});