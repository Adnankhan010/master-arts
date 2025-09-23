(function ($) {
  "use strict";
  

		var body = $( 'body' );
		var popup = $( '.site-gdpr' );
		var popupClose = $( '.site-gdpr .gdpr-button a' );
		var expiresDate = popup.data( 'expires' );


		const tl = gsap.timeline( { paused: true, reversed: true } );
		tl.to( popup, { duration: .6, opacity: 1, visibility: 'visible', y: 0, ease: 'power4.inOut' } );
		tl.play();
		popup.addClass( 'active' );

		

		popupClose.on( 'click', function(e) {
			e.preventDefault();
			Cookies.set( 'cookie-popup-visible', 'disable', { expires: expiresDate, path: '/' });
			tl.reverse();
			popup.removeClass( 'active' );
			$.cookie("klb_gdpr", 'accepted');
		});
		


}(jQuery));
