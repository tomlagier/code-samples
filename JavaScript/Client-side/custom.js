/** 
 * This is a sample JS object from a recent front-end theme I created. 
 * It showcases my approach to front-end glue code, especially in a quick turn environment
 * where a SPA/JS framework isn't necessary
 *
 * Written by Tom Lagier
 */

jQuery( function( $ ){

	//User agent detection - not greeeaaat.
	var isMobile = {
	    Android: function() {
	        return navigator.userAgent.match(/Android/i);
	    },
	    BlackBerry: function() {
	        return navigator.userAgent.match(/BlackBerry/i);
	    },
	    iOS: function() {
	        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	    },
	    Opera: function() {
	        return navigator.userAgent.match(/Opera Mini/i);
	    },
	    Windows: function() {
	        return navigator.userAgent.match(/IEMobile/i);
	    },
	    any: function() {
	        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	    }
	};

	//Get the party started
	function init(){

		setupWallpaper();
		setupMenus();
		setElementHeights();
		setElementWidths();
		centerElements();
		setupSlider();
		setupFonts();
		setupAnimations();
		setupButtons();
		setupSocialShares();
	
	}

	//Set up the full-width wallpaper elements
	function setupWallpaper (  ){

		$( window ).on( 'heightSet', function(){

			$( '.js-hero-image' ).each( function( index, element ){

				$( element ).css( 'background-image', 'url(' + $( element ).attr('data-src') + ')' );

			} );

		} );


	}

	//Set up the homepage slider on desktop and mobile
	function setupSlider (  ){

		var desktopCarouselDefaults = {
			slideSpeed : 300,
			paginationSpeed : 400,
			singleItem: true,
			itemsScaleUp: true,
			autoPlay: true,
		};

		var mobileCarouselDefaults = {
			slideSpeed : 300,
			paginationSpeed : 400,
			singleItem: true,
			itemsScaleUp: true,
			autoHeight : true,
		};

		if( $( '.js-carousel' ).length > 0 ){

			$( '.js-carousel' ).owlCarousel( desktopCarouselDefaults );

		}

		if( $( '.js-carousel-mobile' ).length > 0 ){

			$( '.js-carousel-mobile' ).owlCarousel( mobileCarouselDefaults );

		}

	}

	//Make matchheight elements same height
	function setElementHeights(){

		$( 'body' ).imagesLoaded( function(){

			$( '.js-matchheight' ).matchHeight();

			$( window ).trigger( 'heightSet' );
			
		} );


	}

	//Expand an element to full width on mobile
	function setElementWidths(){

		if( $( '.js-mobile-fill-screen' ).length > 0 ){

			if( $( window ).width() < 767 ){

				$( '.js-mobile-fill-screen' ).outerWidth( $( window ).width() );

			}

			//Make sure we reset width when dragging from <767px to >767px
			$( window ).resize( function(){

				if( $( window ).width() < 767 ){

					$( '.js-mobile-fill-screen' ).outerWidth( $( window ).width() );

				} else {
				
					$( '.js-mobile-fill-screen' ).css( 'width', '100%' );

				}

			} );

		}

	}

	//Center elements that need centering!
	function centerElements(){

		if( $('.js-center-vertical').length > 0 ){

			$( 'js-center-vertical' ).imagesLoaded( function(){

				$( '.js-center-vertical' ).each( function( index, element ){

					var el     = $( element ),
						parent = el.parent();

					var offsetDistance = (parent.height() - el.height()) / 2;

					el.css( 'top', offsetDistance + 'px' );

				} );

			} );

			$( window ).resize( function(){

				$( '.js-center-vertical' ).each( function( index, element ){

					var el     = $( element ),
						parent = el.parent();

					var offsetDistance = (parent.height() - el.height()) / 2;

					el.css( 'top', offsetDistance + 'px' );

				} );				

			} );

		}

	}

	//Set up menus on desktop and mobile
	function setupMenus(){

		//Set up dropdoens
  		$( '.header .menu' ).dropdown_menu();

  		//Set up sticky navigation
  		if ( !isMobile.any() ) {
  		 
  		 	$( '.js-sticky-nav' ).waypoint( 'sticky', 
  		 	{
	  			handler : function ( direction ) {
	  				if ( direction == "down" ) {
	  					var offset = $( '#site' ).offset();
	  					$( '#main-nav' ).css( 'left', offset.left );
	  				} else {
	  					$( '#main-nav' ).css( 'left', 0 );
	  				}
	  				
	  			}
	  		} );

  		 }

  		 //Set up mobile navigation
  		 $( '.toggle-nav-label' ).on('click touchstart', function( e ){

  		 	e.stopPropagation();
  		 	e.preventDefault();

  		 	//TODO: Rewrite this using classes instead of check state because of poor mobile support.

  		 	//Adjust menu positioning
  		 	$( '.js-mobile-heading-offset' ).css( 'margin-top', $( '.mobile-navigation' ).height() + 'px' );

  		 	var targetMenu = $( '#' + $( this ).attr( 'data-target' ) );

  		 	//Close open menu if target is open
  		 	if( targetMenu.hasClass( 'active-mobile-menu' ) ){

  		 		targetMenu.removeClass( 'active-mobile-menu' );

  		 	} else {
  		 		//Else close other open menus and open this one

  		 		if( $( '.active-mobile-menu' ).length > 0 ){

  		 			$( '.active-mobile-menu' ).removeClass( 'active-mobile-menu' );
  		 			
  		 		}

  		 		targetMenu.addClass( 'active-mobile-menu' );

  		 		setElementWidths();

  		 	}

  		 } );

	}

	//Removes the loader on a timeout
	function setupFonts(){
		
		setTimeout( function(){

			removeLoader();

		}, 300 );

	}

	//Removes the loader
	function removeLoader(){

		$( '#loader' ).addClass( 'faded' );

		setTimeout( function(){ 

			$( '#loader' ).addClass( 'lower' );

		}, 500 );

	} 

	//Sets up animations by keying off of .animated and direction classes.
	//.left = slideRightIn (slides to the left)
	//.right = slideLeftIn (slides to the right)
	//.inplace = fadeIn (fades in)
	//none = slideUpIn
	function setupAnimations(){

		if ( $('.animated').length > 0 && !isMobile.any() ) {
	  	
	  		$('.animated').waypoint(function() {
	  		
	  			var target = $(this);
	  		
	  			if ( ! target.hasClass( 'animated_off' ) ) {

	  				if( ! target.hasClass( 'left' ) && ! target.hasClass( 'right' ) && ! target.hasClass( 'inplace' ) ){

		  				$(target).delay(200).velocity("transition.slideUpIn");
		  				target.addClass( 'animated_off' );

	  				}

	  				if( target.hasClass( 'inplace' ) ){

	  					$(target).delay(200).velocity("transition.fadeIn");
	  					//target.addClass( 'animated_off' );

	  				}

	  				if( target.hasClass( 'right' ) ){

	  					$(target).delay(200).velocity("transition.slideLeftIn");
	  					target.addClass( 'animated_off' );

	  				}

	  				if( target.hasClass( 'left' ) ){

	  					$(target).delay(200).velocity("transition.slideRightIn");
	  					target.addClass( 'animated_off' );

	  				}
	  		
	  			}
	  		
	  		},{
	  			
	  			offset: $.waypoints('viewportHeight')

	  		});
	  	
	  	} else {
	  	
	  		$('.animated').css('opacity', 1);
	  	
	  	}
	}

	//Sets up buttons for "down" state styling
	function setupButtons(){

		$( '.button, .page-numbers:not( .current )' ).on( 'mousedown touchstart', function(){

			$( this ).addClass( 'down' );

		} );

		$( '.button, .page-numbers:not( .current )' ).on( 'mouseup mouseout touchend', function(){

			$( this ).removeClass( 'down' );

		} );

	}

	//Sets up facebook and twitter shares
	function setupSocialShares(){

		$( '.facebook-share' ).on( 'click', function(){

			window.open( "https://facebook.com/sharer.php?u=" + encodeURIComponent( window.location ), "", "width=500,height=275,top=100,left=100" );

		} );

		$( '.twitter-share' ).on( 'click', function(){

			window.open("https://twitter.com/intent/tweet?text=" + truncateTitle( $( '.content-title' ).text() ) +  "&url=" + encodeURIComponent( window.location ), "", "width=500,height=275,top=100,left=100" );

		} );

	}

	//Truncate's page title to 114 characters so there is enough space for the '... ' and the link
	function truncateTitle( title ){

		if( title.length <= 114 ){

			return title;

		} else {

			return title.substr(0, 113) + '... ';

		}

	}

	$( document ).ready( function(){

		init();

	} );

} );