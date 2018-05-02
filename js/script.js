$(function(){

	// Mobile Drawer Menu
	$('.mobile-menu').css('display', 'block');
	$('body').mobile_menu({
		menu: ['#nav1 ul'],
		menu_width: 260,
		prepend_button_to: '#mobile-bar'
	});

	// Smooth Scroll
	$('a[href^=#]').click(function() {
		var speed = 400;
		var href = $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);

		var he_header = 20;
		if (href != '#top') {
			he_header = $('#pc-menu').height() + $('#mainWrap').height();
		}
		var position = target.offset().top - he_header;

		/* スムーススクロール */
		var body = 'body';


		// UserAgetn を小文字に正規化
		ua = window.navigator.userAgent.toLowerCase();

		// IE かどうか判定
		isIE = (ua.indexOf('msie') >= 0 || ua.indexOf('trident') >= 0);

		// IE の場合、バージョンを取得(IE6.7.8.9.10)
		if (isIE) body = 'html';

		// if (navigator.userAgent.match(/MSIE/)) {
			/*IE6.7.8.9.10*/
			// body = 'html';
		// }
		$(body).animate({scrollTop:position}, speed, 'swing');
		// $($.browser.safari ? 'body' : 'html').animate({scrollTop:position}, speed, 'swing');
		return false;
	});

	// Anchor Position
	$(window).scroll(function() {
		if ($(this).scrollTop() > 150) {
			$('#anchor').fadeIn(150);
		} else {
			$('#anchor').fadeOut(150);
		}
	});

	// Image Lightbox
	var selectorG = '#lightbox a';
	var instanceG = $( selectorG ).imageLightbox(
	{
		onStart: function(){
			overlayOn();
			arrowsOn( instanceG, selectorG );
		},
		onEnd: function(){
			overlayOff();
			arrowsOff();
			activityIndicatorOff();
		},
		onLoadStart: function(){
			activityIndicatorOn();
		},
		onLoadEnd: function(){
			$( '.imagelightbox-arrow' ).css( 'display', 'block' );
			activityIndicatorOff();
		}
	});

	var activityIndicatorOn = function() {
		$( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
	},
	activityIndicatorOff = function() {
		$( '#imagelightbox-loading' ).remove();
	},

	arrowsOn = function(instance, selector) {
		var $arrows = $( '<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"></button>' );
		$arrows.appendTo( 'body' );
		$arrows.on('click touchend', function(e) {
			e.preventDefault();

			var $this = $( this ),
				$target = $( selector + '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ),
				index = $target.index( selector );

			if ($this.hasClass('imagelightbox-arrow-left')) {
				index = index - 1;
				if (!$( selector ).eq( index ).length)
					index = $( selector ).length;
			} else {
				index = index + 1;
				if(!$( selector ).eq( index ).length)
					index = 0;
			}
			instance.switchImageLightbox( index );
			return false;
		});
	},
	arrowsOff = function() {
		$('.imagelightbox-arrow').remove();
	},
	overlayOn = function() {
		$( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
	},
	overlayOff = function(){
		$( '#imagelightbox-overlay' ).remove();
	};

});
