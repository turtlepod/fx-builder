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

	$.fxBuilder = {

	};
	
	
})(jQuery);