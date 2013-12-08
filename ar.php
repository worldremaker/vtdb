<?php

include "r/html.php";
include "r/gd.php";

$i = get( 'i' );
$h = get( 'h' );
$d = get( 'd' );

if( $i && ( !ctype_alnum( $i ) || !file_exists( "g/s/" . $i . ".png" )))
{
	location( 301,  "ar.php" );
	exit;
}

if( $i && $h && $d )
{
	$image = gd_imagecreate( "g/ar2.png" );
	imagesavealpha($image, true );
	$trans_colour = imagecolorallocatealpha($image, 0, 0, 0, 127);
	imagefill($image, 0, 0, $trans_colour);

	$img = gd_imagecreate( "g/s/" . $i . ".png" );
	$scale = 1;
	imagecopyresized( $image, $img, 40, 50, 0, 0, imagesx( $img ) / $scale , imagesy( $img ) / $scale , imagesx( $img ), imagesy( $img ));
	imagedestroy( $img );

	$x = 190;
	$y = 63;

	$color = imagecolorallocate( $image, 35, 0, 0 );
	imagefttext( $image, 16, 0, $x, $y, $color, "r/agencyb.ttf", $h );
	imagecolordeallocate( $image, $color );
	$y += 10;
	$array = explode( "|", $d );
	foreach( $array as $line )
	{
		gd_addtext( $image, $x, $y,  'black', $line );
		$y += 10;
	}

	header( "Pragma: no-cache" );
	header( "Content-Type: image/png" );

	imagepng( $image );
	imagedestroy( $image );

}
else
{
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<title></title>
</head>
<script type="text/javascript">
	function changeImg()
	{
		var i = document.getElementById("img");
		var s = document.getElementById("sel");
		
		i.src = "g/s/" + s.value + ".png";
	}

	function prev()
	{
		var h = document.forms["myform"]["header"].value
		var d = document.forms["myform"]["description"].value
		var s = document.getElementById("sel");
		var p = document.getElementById("preview");

		if( h == null || h == "" )
		{
			alert( "Missing header" );
			return( false );
		}

		if( d == null || d == "" )
		{
			alert( "Missing description" );
			return( false );
		}

		var idx;
		idx = d.indexOf( "\n" );while( idx != -1 ){ d = d.replace( "\n", "|" ); idx = d.indexOf( "\n" );}
		idx = h.indexOf( "#" );while( idx != -1 ){h = h.replace( "#", "%23" );idx = h.indexOf( "#" );}
		idx = d.indexOf( "#" );while( idx != -1 ){d = d.replace( "#", "%23" );idx = d.indexOf( "#" );}
		idx = h.indexOf( "&" );while( idx != -1 ){h = h.replace( "&", "%26" );idx = h.indexOf( "&" );}
		idx = d.indexOf( "&" );while( idx != -1 ){d = d.replace( "&", "%26" );idx = d.indexOf( "&" );}

		var pp = "ar.php?i="+s.value+"&h="+h+"&d="+d;
		p.src = pp;
		return( false );
	}
</script>
<body>
<div id="container">
	<img id="preview" src="g/ar2.png" alt=""/>
	<div id="ar">
		<form action="ar.php" name="myform" onSubmit="return prev()">
			<br />
			<div style="float: left; text-align: center;">
				<img id="img" src="g/s/action.png" alt="" style="margin-bottom: 10px;"/>
				<br />
				<select id="sel" onchange="changeImg()">';
	$dir = "g/s/";
	if (is_dir($dir))
	{
		if ($dh = opendir($dir))
		{
			while(($file = readdir($dh)) !== false)
			{
				if( $file == '.' || $file == '..' )
					continue;

				echo '
				<option value="', substr( $file, 0, -4 ),'">', substr( $file, 0, -4 ), '</option>';
			}
			closedir($dh);
		}
	}

	echo '
				</select>
			</div>
			<div>
				<input name="header" type="text" value="Header" /><br />
				<br />
				<textarea name="description" rows="5" cols="26">Description</textarea>
				<br />
				<input type="submit" value="Preview" />
			</div>
		</form>
	</div>
</div>
</body>
</html>';

}

function get($key)
{
	$x = null;
	if( array_key_exists( $key, $_GET ))
		return( $_GET[$key] );
}

?>