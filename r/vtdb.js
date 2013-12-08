/*
 * VTDB.js
 */

function infotext(text)
{
	if( text == "" )
		text = '';
	document.getElementById('infotext').innerHTML = text;
};


function hide(name)
{
	document.getElementById('scroll-'+name).style.visibility = 'hidden';
	document.getElementById('infobox-'+name).style.visibility = 'hidden';
};

var visibleInfobox = 'perks';
function show(name)
{
	visibleInfobox = name;
	document.getElementById('scroll-'+name).style.visibility = 'visible';
	document.getElementById('infobox-'+name).style.visibility = 'visible';
	document.getElementById('tab').src= 'g/'+name+'fdr.gif';
};

/* Jovanka's magic */

var zxcTO;
function scroll( id, dis, mouseWheel )
{
	var obj = document.getElementById( id );
	obj.scrollTop = obj.scrollTop + dis;
	if( !mouseWheel )
		{ zxcTO = setTimeout( function(){ scroll( id, dis ); }, 100 ); }
};

/* Universal function to add events to objects */
function addEvent( obj, type, func  )
{
	if( window.addEventListener ) obj.addEventListener( type, func, false ); // W3C DOM
	else if( window.attachEvent ) obj.attachEvent( 'on' + type, func ); // IE
};

/* wheelScroll */
function wheelScroll( dir )
{
	if( dir < 0 ) scroll( 'infobox-' + visibleInfobox, 10, true );
	if( dir > 0 ) scroll( 'infobox-' + visibleInfobox, -10, true );
}

/* Attach mouse wheel event to infobox when document is ready */
addEvent( window, 'load', function(){
	addEvent( document.getElementById( "infobox" ), 'mousewheel', function( e ) { wheelScroll( e.wheelDelta ); }); // IE & other browsers
	addEvent( document.getElementById( "infobox" ), 'DOMMouseScroll', function( e ) { wheelScroll( e.detail * -1 ); });	// Firefox
});
