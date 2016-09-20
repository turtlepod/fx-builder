/**
 * F(X) BUILDER JS: ITEMS
*************************************/

 
/* Functions
------------------------------------------ */
;(function($){

	/**
	 * UPDATE ITEMS INDEX
	 ************************************
	 */
	$.fn.fxB_updateItemsIndex = function( col ) {

		/* Var Row IDs */
		var row_id         = col.parents( '.fxb-row' ).data( 'id' );
		var col_index      = col.data( 'col_index' );
		var items_input    = col.find( 'input[data-row_field="' + col_index + '"]' );
		var item_ids       = [];

		/* Update each rows attr */
		$( col ).find( '.fxb-col-content > .fxb-item' ).each( function(i){

			/* Var */
			var num = i + 1;
			var item_id = $( this ).data( 'item_id' );

			/* Set data */
			$( this ).data( 'item_index', num ); // set index
			var item_index = $( this ).data( 'item_index' ); // get index

			/* Update Item Index */
			$( this ).attr( 'data-item_index', item_index ); // set data attr
			$( this ).find( '.fxb_item_index' ).text( item_index ); // display text
			$( this ).find( 'input[data-item_field="item_index"]' ).val( item_index ); // change input

			/* Update Row ID and Col Index */
			$( this ).data( 'row_id', row_id );
			$( this ).find( 'input[data-item_field="row_id"]' ).val( row_id );
			$( this ).data( 'col_index', col_index );
			$( this ).find( 'input[data-item_field="col_index"]' ).val( col_index );

			/* Get ID */
			item_ids.push( item_id );
		});

		/* Update Hidden Input */
		items_input.val( item_ids.join() );
	};

	/**
	 * MAKE ITEMS SORTABLE
	 ************************************
	 */
	$.fn.fxB_sortItems = function( col ) {

		$( '.fxb-col-content' ).sortable({
			handle      : '.fxb-item-handle',
			cursor      : 'grabbing',
			connectWith : ".fxb-col-content",
			update      : function( e, ui ) {

				/* Var */
				var col = $( this ).parents( '.fxb-col' );

				/* Update Index */
				$.fn.fxB_updateItemsIndex( col );
			},
		});
	};


	/**
	 * Get Iframe CSS
	 */
	$.fn.fxB_getIframeCSS = function() {
		if( typeof tinymce == 'undefined' ){
			return '';
		}
		var iframe_css = '';
		var iframe_styles = tinyMCEPreInit.mceInit.fxb_editor.content_css;
		/* Loop each styles and create link el. */
		iframe_styles.split(',').forEach( function( item ){
			iframe_css += '<link type="text/css" rel="stylesheet" href="' + item + '" />';
		});
		return iframe_css;
	};


	/**
	 * Format Content
	 */
	$.fn.fxB_formatContent = function( raw_content ){
		if( typeof tinymce == 'undefined' ){
			return $.fn.fxB_wpautop( raw_content );
		}
		var content = "";
		$.ajax({
			type: "POST",
			async: false,
			url: fxb_ajax.ajax_url,
			data:{
				action     : 'fxb_item_format_content',
				nonce      : fxb_ajax.ajax_nonce,
				content    : raw_content,
			},
			success: function( data ){
				content = data;
			},
			fail: function( data ){
				content = raw_content;
			},
		});
		return content;
	}


	/**
	 * wpautop
	 */
	$.fn.fxB_wpautop = function( raw_content ){
		var content = "";
		$.ajax({
			type: "POST",
			async: false,
			url: fxb_ajax.ajax_url,
			data:{
				action     : 'fxb_item_wpautop',
				nonce      : fxb_ajax.ajax_nonce,
				content    : raw_content,
			},
			success: function( data ){
				content = data;
			},
			fail: function( data ){
				content = raw_content;
			},
		});
		return content;
	}

	/**
	 * Load Iframe
	 */
	$.fn.fxB_loadIfameContent = function( head ){
		var iframe = this;
		var editor_body_class = '';
		if( typeof tinymce != 'undefined' ){
			editor_body_class = tinyMCEPreInit.mceInit.fxb_editor.body_class;
		}
		else{
			head = "<style>.wp-editor{font-family: Consolas,Monaco,monospace;font-size: 13px;line-height: 150%;}</style>"
		}
		var body_class = 'wp-editor';
		var raw_content = iframe.siblings( '.fxb-item-textarea' ).val();
		var content = $.fn.fxB_formatContent( raw_content );

		iframe.contents().find( 'head' ).html( head );
		iframe.contents().find( 'body' ).attr( 'id', 'tinymce' ).addClass( editor_body_class ).addClass( body_class ).html( content );

		/* 
		 * Firefox Hack
		 * @link http://stackoverflow.com/a/24686535
		 */
		$( iframe ).on('load', function() {
			$( this ).contents().find( 'head' ).html( head );
			$( this ).contents().find( 'body' ).attr( 'id', 'tinymce' ).addClass( editor_body_class ).addClass( body_class ).html( content );
		});
	};


	/**
	 * Force Switch to Visual Editor
	 */
	$.fn.fxB_switchEditor = function( id ) {
		if( typeof tinymce == 'undefined' ){
			return;
		}
		id = id || 'content';

		var editor = tinymce.get( id ),
			wrap = $( '#wp-' + id + '-wrap' ),
			$textarea = $( '#' + id ),
			textarea = $textarea[0];

		if ( editor && ! editor.isHidden() ) {
			return false;
		}

		if ( typeof( window.QTags ) !== 'undefined' ) {
			window.QTags.closeAllTags( id );
		}
		if ( editor ) {
			editor.show();
		}
		else {
			tinymce.init( window.tinyMCEPreInit.mceInit[id] );
		}

		wrap.removeClass( 'html-active' ).addClass( 'tmce-active' );
		$textarea.attr( 'aria-hidden', true );
		window.setUserSetting( 'editor', 'tinymce' );
	}


})(jQuery);


/* Document Ready
------------------------------------------ */
jQuery(document).ready(function($){

	/**
	 * Make Sure Visual Editor Is Active
	 */
	$.fn.fxB_switchEditor( "fxb_editor" );
	$( document.body ).on( 'submit', '#post', function(){
		$.fn.fxB_switchEditor( "fxb_editor" );
	} );


	/**
	 * VAR
	 * 
	 ************************************
	 */
	var item_template = wp.template( 'fxb-item' );
	var iframe_css = $.fn.fxB_getIframeCSS();

	/**
	 * MAKE SORTABLE ON PAGE LOAD
	 * 
	 ************************************
	 */
	$.fn.fxB_sortItems();


	/**
	 * PREPARE IFRAME ON PAGE LOAD
	 * 
	 ************************************
	 */
	$( '.fxb-item-iframe' ).each( function(i){
		$( this ).fxB_loadIfameContent( iframe_css );
	} );



	/**
	 * ADD NEW ITEM
	 *
	 * Add new item in the column when click new item (+) button.
	 * 
	 ************************************
	 */
	$( document.body ).on( 'click', '.fxb-add-item', function(e){
		e.preventDefault();

		/* Vars */
		var items_container = $( this ).siblings( '.fxb-col-content' );
		var item_id         = new Date().getTime();
		var col             = $( this ).parents( '.fxb-col' );

		/* Add template to container */
		$( items_container ).append( item_template( {
			item_id     : item_id,
			item_index  : '1',
			item_state  : 'open',
			item_type   : 'text',
		} ) );

		/* Update Index */
		$.fn.fxB_updateItemsIndex( col );

		/* Load Iframe */
		$( '.fxb-item[data-item_id="' + item_id + '"] .fxb-item-iframe' ).fxB_loadIfameContent( iframe_css );

		/* Make Sortable */
		$.fn.fxB_sortItems();
	} );


	/**
	 * REMOVE ITEM
	 *
	 ************************************
	 */
	$( document.body ).on( 'click', '.fxb-remove-item', function(e){
		e.preventDefault();

		/* Confirm delete */
		var confirm_delete = confirm( $( this ).data( 'confirm' ) );
		if ( true ===  confirm_delete ){

			/* Vars */
			var item = $( this ).parents( '.fxb-item' );
			var col  = $( this ).parents( '.fxb-col' );

			/* Remove item */
			item.remove();

			/* Update Index */
			$.fn.fxB_updateItemsIndex( col );
		}
	} );


	/**
	 * TOGGLE ITEM STATE
	 *
	 * Open/Close item using toggle arrow icon.
	 * 
	 ************************************
	 */
	$( document.body ).on( 'click', '.fxb-toggle-item', function(e){
		e.preventDefault();

		/* Var */
		var item = $( this ).parents( '.fxb-item' );
		var item_state = item.data( 'item_state' );

		/* Toggle State */
		if( 'open' == item_state ){
			item.data( 'item_state', 'close' ); // set data
		}
		else{
			item.data( 'item_state', 'open' );
		}

		/* Update state */
		var item_state = item.data( 'item_state' ); // get data
		item.attr( 'data-item_state', item_state ); // change attr for styling
		item.find( 'input[data-item_field="item_state"]' ).val( item_state ); // change hidden input
	} );


	/**
	 * SORT ITEM
	 * 
	 ************************************
	 */
	$( '.fxb-col-content' ).sortable({
		handle      : '.fxb-item-handle',
		cursor      : 'grabbing',
		connectWith : ".fxb-col-content",
		update      : function( e, ui ) {

			/* Var */
			var col = $( this ).parents( '.fxb-col' );

			/* Update Index */
			$.fn.fxB_updateItemsIndex( col );
		},
	});


	/**
	 * OPEN EDITOR
	 * 
	 ************************************
	 */
	$( document.body ).on( 'click', '.fxb-item-iframe-overlay', function(e){
		e.preventDefault();

		var editor_id = "fxb_editor";

		/**
		 * Make sure it's using tmce editor
		 * if not it will get "tinyMCE.get(...) is null" error
		 */
		$.fn.fxB_switchEditor( editor_id );

		/* Textarea source */
		var target_textarea = $( this ).siblings( '.fxb-item-textarea' );

		/* Add active class */
		target_textarea.addClass( 'fxb_editing_active' );

		/* Set it to tinyMCE content */
		var raw_content = target_textarea.val();
		var content = $.fn.fxB_wpautop( raw_content );
		if( typeof tinymce != 'undefined' ){
			tinyMCE.get( editor_id ).show();
			tinyMCE.get( editor_id ).setContent( content );
		}
		else{
			$( "#" + editor_id ).val( raw_content );
		}

		/* Show Editor Modal & Modal Overlay */
		$( '.fxb-editor' ).show();
		$( '.fxb-modal-overlay' ).show();
	});

	/**
	 * CLOSE EDITOR
	 * 
	 ************************************
	 */
	$( document.body ).on( 'click', '.fxb-editor .fxb-modal-close', function(e){
		e.preventDefault();

		var editor_id = "fxb_editor";

		/**
		 * Make sure it's using tmce editor
		 * if not it will get "tinyMCE.get(...) is null" error
		 */
		$.fn.fxB_switchEditor( editor_id );

		/* Force tinyMCE to save the data to their textarea */
		if( typeof tinymce != 'undefined' ){
			tinyMCE.get( editor_id ).save();
			tinyMCE.get( editor_id ).hide();
		}

		/* Get the value saved in textarea */
		var editor_val = $( '#' + editor_id ).val();

		/* Item Textarea */
		var item_textarea = $( '.fxb_editing_active' );

		/* Add content back to textarea and item iframe */
		item_textarea.val( editor_val );
		item_textarea.siblings( '.fxb-item-iframe' ).fxB_loadIfameContent( iframe_css );
		item_textarea.removeClass( 'fxb_editing_active' );

		/* Hide Settings Modal & Overlay */
		$( this ).parents( '.fxb-modal' ).hide();
		$( '.fxb-modal-overlay' ).hide();
	} );


});

