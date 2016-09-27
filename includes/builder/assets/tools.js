jQuery(document).ready(function($){

	/**
	 * OPEN TOOLS MODAL
	 */
	$( document.body ).on( 'click', '#fxb-nav-tools', function(e){
		e.preventDefault();

		/* Show Editor Modal & Modal Overlay */
		$( '.fxb-tools' ).show();
		$( '.fxb-modal-overlay' ).show();

		/* Fix Height */
		$( '.fxb-fxb-tools .fxb-modal-content' ).css( "height", $( '.fxb-tools' ).height() - 35 + "px" ); 
		$( window ).resize( function(){
			$( '.fxb-tools .fxb-modal-content' ).css( "height", "auto" ).css( "height", $( '.fxb-tools' ).height() - 35 + "px" ); 
		});
	});

	/**
	 * CLOSE TOOLS MODAL
	 */
	$( document.body ).on( 'click', '.fxb-tools .fxb-modal-close', function(e){
		e.preventDefault();

		/* Show Editor Modal & Modal Overlay */
		$( '.fxb-tools' ).hide();
		$( '.fxb-modal-overlay' ).hide();

		/* Reset Modal */
		$( '#fxb-export-tab' ).addClass( 'wp-tab-active' );
		$( '#fxb-import-tab' ).removeClass( 'wp-tab-active' );
		$( '#fxb-export-panel' ).show();
		$( '#fxb-import-panel' ).hide();
		$( '#fxb-tools-export-textarea' ).val( '' ).hide();
		$( '#fxb-tools-import-textarea' ).val( '' );
		$( '#fxb-tools-import-action' ).addClass( 'disabled' );
	});

	/**
	 * TOOLS NAV BAR
	 */
	$( document.body ).on( 'click', '.fxb-tools-nav-bar', function(e){
		e.preventDefault();
		var tab = $( this ).parent( '.tabs' );
		tab.addClass( 'wp-tab-active' );
		tab.siblings( '.tabs' ).removeClass( 'wp-tab-active' );
		var target = $( this ).attr( 'href' );
		$( target ).show();
		$( target ).siblings( '.wp-tab-panel' ).hide();
	});

	/**
	 * EXPORT DATA
	 */
	$( document.body ).on( 'click', '#fxb-tools-export-action', function(e){
		e.preventDefault();
		$( '#fxb-tools-export-textarea' ).slideDown();
	});

	/**
	 * IMPORT DATA
	 */
	$( document.body ).on( 'change', '#fxb-tools-import-textarea', function(e){
		var pb_data = $( this ).val();
		if( pb_data ){
			$( '#fxb-tools-import-action' ).removeClass( 'disabled' );
		}
		else{
			$( '#fxb-tools-import-action' ).addClass( 'disabled' );
		}
	});
	$( document.body ).on( 'click', '#fxb-tools-import-action', function(e){
		e.preventDefault();
		if( $( this ).hasClass( 'disabled' ) ){
			return false;
		}
		else{
			if ( true !== confirm( $( this ).data( 'confirm' ) ) ) {
				return false;
			}
		}
	});
});
