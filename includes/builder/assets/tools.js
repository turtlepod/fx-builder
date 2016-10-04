;(function($){

	/**
	 * TOOLS OPEN
	 ************************************
	 */
	$.fn.fxB_Tools_Open = function() {

		/* Show Editor Modal & Modal Overlay */
		$( '.fxb-tools' ).show();
		$( '.fxb-modal-overlay' ).show();

		/* Fix Height */
		$( '.fxb-fxb-tools .fxb-modal-content' ).css( "height", $( '.fxb-tools' ).height() - 35 + "px" ); 
		$( window ).resize( function(){
			$( '.fxb-tools .fxb-modal-content' ).css( "height", "auto" ).css( "height", $( '.fxb-tools' ).height() - 35 + "px" ); 
		});
	};

	/**
	 * TOOLS CLOSE
	 ************************************
	 */
	$.fn.fxB_Tools_Close = function() {

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
	};

})(jQuery);


jQuery(document).ready(function($){

	/**
	 * OPEN TOOLS MODAL
	 */
	$( document.body ).on( 'click', '#fxb-nav-tools', function(e){
		e.preventDefault();
		$.fn.fxB_Tools_Open();
	});

	/**
	 * CLOSE TOOLS MODAL
	 */
	$( document.body ).on( 'click', '.fxb-tools .fxb-modal-close', function(e){
		e.preventDefault();
		$.fn.fxB_Tools_Close();
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

		var pb_object = $( '#post' ).serializeObject();
		var row_ids = pb_object._fxb_row_ids;
		var rows = {};
		var items = {};
		if( row_ids ){
			row_ids.split( ',' ).forEach( function( row_id ){
				rows[row_id] = pb_object._fxb_rows[row_id];
				/* Col 1 */
				pb_object._fxb_rows[row_id].col_1.split( ',' ).forEach( function( item_id ){
					items[item_id] = pb_object._fxb_items[item_id];
				});
				/* Col 2 */
				pb_object._fxb_rows[row_id].col_2.split( ',' ).forEach( function( item_id ){
					items[item_id] = pb_object._fxb_items[item_id];
				});
				/* Col 3 */
				pb_object._fxb_rows[row_id].col_3.split( ',' ).forEach( function( item_id ){
					items[item_id] = pb_object._fxb_items[item_id];
				});
				/* Col 4 */
				pb_object._fxb_rows[row_id].col_4.split( ',' ).forEach( function( item_id ){
					items[item_id] = pb_object._fxb_items[item_id];
				});
			});
		}

		/* use ajax to convert to json data */
		$.ajax({
			type: "POST",
			url: fxb_tools.ajax_url,
			data:{
				action     : 'fxb_export_to_json',
				nonce      : fxb_tools.ajax_nonce,
				row_ids    : row_ids,
				rows       : rows,
				items      : items,
			},
			//dataType: 'json',
			success: function( data ){
				/* Add data in textarea and show */
				$( '#fxb-tools-export-textarea' ).val( data ).slideDown();
				/* Auto Select Textarea */
				$( "#fxb-tools-export-textarea" ).focus(function() {
					var $this = $(this);
					$this.select();
				});
				return;
			},
		});

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

			/* Confirm */
			if ( true !== confirm( $( this ).data( 'confirm' ) ) ) {
				return false;
			}

			/* Check valid data */
			var json_data = $( '#fxb-tools-import-textarea' ).val();
			var obj_data = $.parseJSON( json_data );
			if( typeof obj_data != 'object' || typeof obj_data.row_ids == 'undefined' || typeof obj_data.rows == 'undefined' || typeof obj_data.items == 'undefined' ){
				alert( $( this ).data( 'alert' ) );
				return false;
			}

			/* Start Importing Data Via Ajax */
			$.ajax({
				type: "POST",
				url: fxb_tools.ajax_url,
				data:{
					action     : 'fxb_import_data',
					nonce      : fxb_tools.ajax_nonce,
					data       : json_data,
				},
				success: function( data ){
					$( 'input[name="_fxb_row_ids"]' ).val( obj_data.row_ids );
					$( '#fxb' ).empty();
					$( '#fxb-template-loader' ).empty().html( data );
					$.fn.fxB_sortItems();
					$.fn.fxB_Tools_Close();
					return;
				},
			});
		}
	});
});
