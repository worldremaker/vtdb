<?php

include( 'setup.php' );

include( $dirs['include'] . '/html.php' );
include( $dirs['include'] . '/func.php' );

content_type( 'text/html' );
doctype( 'strict' );
html();
html_head( 'Vault-Tec DB (RC1)', 0, 0 );
html_head_link( $dirs['css'] . 'vtdb.css' );
html_head_end();
body("style='height:100%;'");

print( "<p style='text-align: center;'>\n" );
string2font( 1, "Vault-Tec DB\n" );
string2font( 3, "by WHINE TEAM\n" );
echo "<span class='font_green'>:: OPEN TEST ::</span><br/>\n";

$who = '?';
$when = 0;
if( $dir = opendir( $dirs['db'] ))
{
	$chars = 0;
	while(( $file = readdir($dir)) !== false )
	{
		if( $file == '.' || $file == '..'  )
			continue;
		if( substr( $file, -5 ) == '.vtdb' && ctype_digit( substr( $file, 0, strlen($file)-5 )))
			$chars++;
		if( substr( $file, -4 ) == '.php' && ctype_digit( substr( $file, 0, strlen($file)-4 )))
			$chars++;
		$stat = stat( $dirs['db'] . "/$file" );
		if( $stat['mtime'] > $when )
			$when = $stat['mtime'];
	};
	closedir($dir);
	echo "Characters: $chars ";
}

/*
if( $dir = opendir( $dirs['dna'] ))
{
	$bgs = 0;
	while(( $file = readdir($dir)) !== false )
	{
		if( substr( $file, 0, 7 ) == 'charbg.' &&
			ctype_digit( substr( $file, 7, 8 )) &&
			substr( $file, -4 ) == '.png' )
			$bgs++;
	};
	closedir($dir);
	echo "backgrounds: $bgs\n";
}
*/

print( "</p>\n" );

gen_menu();

body_end();
html_end();

?>