jQuery(document).ready(function($){

	/**
	 * OPEN CUSTOM CSS MODAL
	 */
	$( document.body ).on( 'click', '#fxb-nav-css', function(e){
		e.preventDefault();

		/* Show Editor Modal & Modal Overlay */
		$( '.fxb-custom-css' ).show();
		$( '.fxb-modal-overlay' ).show();

		/* Fix Height */
		$( '.fxb-custom-css .fxb-modal-content' ).css( "height", $( '.fxb-custom-css' ).height() - 35 + "px" ); 
		$( window ).resize( function(){
			$( '.fxb-custom-css .fxb-modal-content' ).css( "height", "auto" ).css( "height", $( '.fxb-custom-css' ).height() - 35 + "px" ); 
		});
	});

	/**
	 * CLOSE CUSTOM CSS MODAL
	 */
	$( document.body ).on( 'click', '.fxb-custom-css .fxb-modal-close', function(e){
		e.preventDefault();

		/* Show Editor Modal & Modal Overlay */
		$( '.fxb-custom-css' ).hide();
		$( '.fxb-modal-overlay' ).hide();
	});

	/**
	 * ENABLE TAB IN CUSTOM CSS TEXTAREA
	 * @link http://stackoverflow.com/questions/6637341
	 */
	$( document.body ).delegate( '.fxb-custom-css-textarea', 'keydown', function(e) {
		var keyCode = e.keyCode || e.which;
		if ( keyCode == 9 ){
			e.preventDefault();
			var start = $(this).get(0).selectionStart;
			var end = $(this).get(0).selectionEnd;

			/* set textarea value to: text before caret + tab + text after caret */
			$(this).val($(this).val().substring(0, start)
				+ "\t"
				+ $(this).val().substring(end));

			/* put caret at right position again */
			$(this).get(0).selectionStart =
			$(this).get(0).selectionEnd = start + 1;
		}
	});

});