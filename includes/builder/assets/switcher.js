jQuery(document).ready(function($){

	/* Click Tab */
	$( document.body ).on( 'click', '#fxb-switcher a.nav-tab', function(e){
		e.preventDefault();

		var this_data = $( this ).data( 'fxb-switcher' );
		/* Clicking "Editor" */
		if( 'editor' == this_data ){
			$( 'html' ).removeClass( 'fx_builder_active' );
			$( 'input[name="fx_builder_active"]' ).val( '' );
			$( this ).addClass( 'nav-tab-active' );
			$( this ).siblings( '.nav-tab' ).removeClass( 'nav-tab-active' );
		}
		else if( 'builder' == this_data ){
			$( 'html' ).addClass( 'fx_builder_active' );
			$( 'input[name="fx_builder_active"]' ).val( '1' );
			$( this ).addClass( 'nav-tab-active' );
			$( this ).siblings( '.nav-tab' ).removeClass( 'nav-tab-active' );
		}
	});
});