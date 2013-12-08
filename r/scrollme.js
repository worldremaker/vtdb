/* scrollme */

$( document ).ready( function() {

	var allAddscroll = $( '.scrollme' );

	for( var i = 0; i < allAddscroll.length; i++ ) {

	
		// Inject scrollbar HTML

		var scrollOut = allAddscroll[i];
		var contentHTML = scrollOut.innerHTML;
		var scrollbarHTML = '<div class="scrollbarUp"></div><div class="scrollbarDn"></div><div class="scrollbarBg"><div class="scrollbarScroll"><div class="scrollbarScrollTop"></div><div class="scrollbarScrollBtm"></div></div></div>';
		scrollOut.innerHTML = scrollbarHTML + '<div class="scrollIn"><div class="scrollContent">' + contentHTML + '</div></div>';

		
		// New elements names

		var scrollbarUp = scrollOut.children[0];
		var scrollbarDn = scrollOut.children[1];	
		var scrollbarBg = scrollOut.children[2];
		var scrollbarScroll = scrollOut.children[2].children[0];
		var scrollbarScrollTop = scrollOut.children[2].children[0].children[0];
		var scrollbarScrollBtm = scrollOut.children[2].children[0].children[1];
		var scrollIn = scrollOut.children[3];
		var scrollContent = scrollOut.children[3].children[0];		

		
		// Get container and content height

		var scrollOutHeight = scrollOut.offsetHeight;
		var scrollContentHeight = scrollContent.offsetHeight;

		
		// Set styles

		scrollOut.style.position = 'relative';
		scrollIn.style.width = ( scrollOut.offsetWidth - scrollbarUp.offsetWidth ) + 'px';
		scrollIn.style.height = scrollOut.offsetHeight + 'px';
		scrollIn.style.position = 'relative';
		scrollIn.style.overflowY = 'hidden';
		scrollbarUp.style.position = 'absolute';
		scrollbarUp.style.top = '0';
		scrollbarUp.style.right = '0';
		scrollbarDn.style.position = 'absolute';
		scrollbarDn.style.bottom = '0';
		scrollbarDn.style.right = '0';
		scrollbarBg.style.position = 'absolute';
		scrollbarBg.style.top = scrollbarUp.offsetHeight + 'px';
		scrollbarBg.style.right = '0';
		scrollbarBg.style.height = ( scrollOutHeight - scrollbarUp.offsetHeight - scrollbarDn.offsetHeight )  + 'px';	
		scrollbarScroll.style.position = 'absolute';
		scrollbarScroll.style.top = '0';
		scrollbarScroll.style.overflow = 'hidden';
		scrollbarScrollTop.style.position = 'absolute';
		scrollbarScrollTop.style.top = '0';
		scrollbarScrollBtm.style.position = 'absolute';
		scrollbarScrollBtm.style.bottom = '0';

		
		// Set scroll height

		if( scrollContentHeight > scrollOutHeight ) {
			var scrollbarBgHeight = scrollbarBg.offsetHeight;
			var containerHeightPercent = ( scrollOutHeight * 100 ) / scrollContentHeight;
			var scrollbarScrollHeight = ( scrollbarBgHeight * containerHeightPercent ) / 100;
			scrollbarScroll.style.height = scrollbarScrollHeight + 'px';
		} else {
			scrollbarScroll.style.height = scrollbarBg.style.height;
		}

	}


	// Update scrollbar position

	var computeRatio = function( obj ) {
		var spaceScroll = obj.offsetHeight - obj.firstChild.offsetHeight;
		var spaceContent = obj.parentNode.children[3].firstChild.offsetHeight - obj.parentNode.children[3].offsetHeight;
		var ratio = spaceContent / spaceScroll;
		return ratio;
	}
	
	var updateScrollbar = function ( obj ) {
		var offset = obj.parentNode.children[3].scrollTop / computeRatio( obj );
		obj.firstChild.style.top = offset + 'px';
	}

	
	// Scroll by...

	var continueScroll;
	var scroll = function( obj, dis, mouseWheel )
	{
		var scrollObj = obj.children[3];
		scrollObj.scrollTop = scrollObj.scrollTop + dis;
		if( !mouseWheel ) {
			continueScroll = setTimeout( function(){ scroll( obj, dis ); }, 100 );
		}
		updateScrollbar( obj.children[2] );
	};


	// Event - use mouse wheel

	$( '.scrollme' ).bind('mousewheel DOMMouseScroll', function(e) {
		if( e.wheelDelta ) {
			if( e.wheelDelta < 0 ) scroll( e.currentTarget, 15, true );
			if( e.wheelDelta > 0 ) scroll( e.currentTarget, -15, true );
		} else {
			if( e.detail > 0 ) scroll( e.currentTarget, 15, true );
			if( e.detail < 0 ) scroll( e.currentTarget, -15, true );
		}
	});

	
	// Event - press up/down buttons

	$( '.scrollbarUp' ).bind('mousedown', function(e) {
		scroll( e.currentTarget.parentNode, -15, false );
	});
	$( '.scrollbarDn' ).bind('mousedown', function(e) {
		scroll( e.currentTarget.parentNode, 15, false );
	});	
	$( '.scrollbarUp, .scrollbarDn' ).bind( 'mouseup mouseout', function(e) {
		clearTimeout( continueScroll );
	});


	// Event - drag scrollbar
	
	$( '.scrollbarBg' ).bind('mousedown', function( e ) {

		var originalTarget = e.currentTarget.parentNode;
		var startMouseY = e.clientY;
		var diffMouseY;

		$( document ).bind('mousemove', function( e ) {
			diffMouseY = ( e.clientY - startMouseY) * computeRatio( originalTarget.children[2] );
			startMouseY = e.clientY;
			scroll( originalTarget, diffMouseY, true );
		});

		$( document ).bind('mouseup', function( e ) {
			$( document ).unbind('mousemove');
			$( document ).unbind('mouseup');
		});
		
	});

});
