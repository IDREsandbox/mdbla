 /*
 * Custom scripts
 * Description: Custom scripts for fullframe
 */

jQuery(document).ready(function() {
	var jQueryheader_search = jQuery( '#header-toggle' );
	jQueryheader_search.click( function() {
		var jQueryform_search = jQuery("div").find( '#masthead' );	
			
		if ( jQueryform_search.hasClass( 'displaynone' ) ) {
			jQueryform_search.removeClass( 'displaynone' ).addClass( 'displayblock' ).animate( { opacity : 1 }, 300 );
		} else {
			jQueryform_search.removeClass( 'displayblock' ).addClass( 'displaynone' ).animate( { opacity : 0 }, 300 );		
		}
	});

	//Fit vids
	if ( jQuery.isFunction( jQuery.fn.fitVids ) ) {
		jQuery('.hentry, .widget').fitVids();
	}

	//sidr
	if ( jQuery.isFunction( jQuery.fn.sidr ) ) {
		jQuery('#mobile-header-left-menu').sidr({
		   name: 'mobile-header-left-nav',
		   side: 'left' // By default
		});
	}
});