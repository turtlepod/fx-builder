jQuery(document).ready(function($){

	/* Click Tab */
	$( document.body ).on( 'click', '#fxb-switcher a.nav-tab', function(e){
		e.preventDefault();

		/* Bail */
		if( $( this ).hasClass( 'nav-tab-active' ) ){
			return false;
		}

		/* Confirm ? */
		if( ! $( this ).hasClass( 'switch-confirmed' ) ){
			if ( true !== confirm( $( this ).data( 'confirm' ) ) ) {
				return false;
			}
		}

		/* Add Confirmed Class */
		$( this ).addClass( 'switch-confirmed' );

		/* Force Switch to Visual Editor */
		$.fn.fxB_switchEditor( "fxb_editor" );

		var this_data = $( this ).data( 'fxb-switcher' );

		/* Clicking "Editor" */
		if( 'editor' == this_data ){
			$( 'html' ).removeClass( 'fx_builder_active' );
			$( 'input[name="_fxb_active"]' ).val( '' );
			$( this ).addClass( 'nav-tab-active' );
			$( this ).siblings( '.nav-tab' ).removeClass( 'nav-tab-active' );
		}
		else if( 'builder' == this_data ){
			$( 'html' ).addClass( 'fx_builder_active' );
			$( 'input[name="_fxb_active"]' ).val( '1' );
			$( this ).addClass( 'nav-tab-active' );
			$( this ).siblings( '.nav-tab' ).removeClass( 'nav-tab-active' );
		}
	});
});