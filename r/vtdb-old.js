/*
 * Vault-Tec DB
 */

function infotext(text)
{
	if( text == \"\" )
		text = 'Beta version.';
	document.getElementById('infotext').innerHTML=text;
}

function hide(name)
{
	document.getElementById('scroll-'+name).style.visibility = 'hidden';
	document.getElementById('infobox-'+name).style.visibility = 'hidden';
}

function show(name)
{
	document.getElementById('scroll-'+name).style.visibility = 'visible';
	document.getElementById('infobox-'+name).style.visibility = 'visible';
	document.getElementById('tab').src= 'g/'+name+'fdr.gif';
}

var zxcTO;
function scroll(id,dis,pos)
{
	var obj=document.getElementById(id)
	obj.scrollTop=obj.scrollTop+dis;
	if(pos) {obj.scrollTop=pos;}
	else {zxcTO=setTimeout( function(){ Scroll(id,dis); },10); }
	document.selection.clear();
}
