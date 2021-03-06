<?php

function location($code,$url)
{
	$text = 0;

	switch( $code )
	{
		case '300':	$text = 'Multiple Choises';		break;
		case '301':	$text = 'Moved Permanently';	break;
		case '302':	$text = 'Found';				break;
		case '303':	$text = 'See Other';			break;
		case '304':	$text = 'Not Modified';			break;
		case '305':	$text = 'Use Proxy';			break;
		case '307': $text = 'Temporary Redirect';	break;
	};

	if( $text )
	{
		header( "HTTP/1.0 $code $text" );
		header( "Status: $code $text" );
		header( "Location: $url" );
		exit;
	}
	else
	{
		header( "X-VTDB:LOCERR: $code" );
		exit;
	};
};

function content_type($type)
{
	header( "Content-Type: $type" );
};

function doctype($doctype)
{
	global $document;

	echo( '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 ' . ucfirst( strtolower( $doctype )) . "//EN\"\n\t" .
		  ' "http://www.w3.org/TR/xhtml1/DTD/xhtml1-' . strtolower( $doctype ) . ".dtd\">\n\n" );

	$document['doctype'] = strtolower( $doctype );
};

function html()
{
	echo( "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n" );
};

function html_head($title,$robots,$gverify1)
{
    echo( "<head>\n" );
	html_head_emeta( 'content-type', 'text/html; charset=utf-8' );

	if( $title )
		printf( "\t<title>%s</title>\n", $title );

	if( $robots )
		html_head_meta( 'robots', $robots );

	if( $gverify1 )
		html_head_meta( 'verify-v1', $gverify1 );
};

function html_head_meta($meta,$content)
{
	printf( "\t<meta name=\"%s\" content=\"%s\" />\n", $meta, $content );
}

function html_head_emeta($http_equiv,$content)
{
	printf( "\t<meta http-equiv=\"%s\" content=\"%s\" />\n", $http_equiv, $content );
}

function html_head_link($href)
{
	$rel  = 0;
	$type = 0;

	switch( substr( $href, -4 ))
	{
		case '.css':
			$rel  = 'stylesheet';
			$type = 'text/css';
			break;
	};

	if( $rel && $type )
		{ printf( "\t<link rel=\"%s\" type=\"%s\" href=\"%s\" />\n", $rel, $type, $href ); };
};

function html_head_script($href)
{
	$type = 0;
	$lang = 0;

	switch( substr( $href, -4 ))
	{
		default:
			switch( substr( $href, -3 ))
			{
				case '.js':
					$type  = 'text/javascript';
					$lang = 'javascript';
			};
	};

	if( $type && $lang )
	{
		global $document;
		if( $document['doctype'] == 'strict' )
			echo( "\t<script type=\"$type\" src=\"$href\"></script>\n" );
		else
			echo( "\t<script type=\"$type\" language=\"$lang\" src=\"$href\"></script>\n" );
	}
};

function html_head_end()
{
	echo( "</head>\n" );
};

function body($args)
{
	printf( "<body%s>\n", $args ? " $args" : '' );
}

function body_end()
{
	echo( "</body>\n" );
};

function html_end()
{
	echo( "</html>\n" );
};

function button($url,$name)
{
	echo( "\t\t<a href='$url'><span class='button".rand(1,3)."'>$name</span></a>\n" );
}

function gen_menu()
{
	global $dirs;
	$top=$dirs['home'];
	
	echo( "<div class='menu'>
	<span class='font_green'>\n" );
		button("/${top}",'MAIN' );
		//button("/${top}search.php",'CHARACTERS' );
		//button( "/${top}tools.php", 'TOOLS' );
		button( "/${top}about.php", 'ABOUT' );echo("
	</span>
</div>\n" );
};

function gen_submenu($type,$options=0)
{
	global $dirs;
	$top=$dirs['home'];
	$start = "<div class='submenu'>\n\t<span class='font_green'>\n";
	$end = "\t</span>\n</div>\n";

	if( $type == 'about' )
	{
		echo( $start );
		//button( "/${top}manual.php", "MANUAL" );
		button( "https://fodev.net/forum/index.php?topic=12717.msg104445#msg104445", 'GENERAL INFO' );
		//button( "http://fonline2238.net/forum/index.php?topic=12937.msg104446#msg104446", 'INI SYNTAX' );
		echo( "<br />\n" );
		button( "/${top}changelog.php", 'CHANGELOG' );
		echo( $end );
	}
	elseif( $type == 'character' )
	{
		$o = explode( ':', $options );
		if( $o[0] )
		{
			echo( $start );
			button( "/${top}char.php?".$o[0], 'CHARACTER' );
			button( "/${top}char.php?sig=".$o[0], 'SIGNATURE' );
			//button( "#", 'POSITION' );
			echo( $end );
		}
	}
	elseif( $type == 'characters' )
	{
		echo( $start );
		button( "/${top}search.php", 'SEARCH' );
		echo( $end );
	};
	
};

?>