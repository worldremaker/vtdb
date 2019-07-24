<?php

include( 'setup.php' );

require_once( 'r/html.php' );
require_once( 'r/func.php' );

content_type( 'text/html' );
doctype( 'strict' );
html();
html_head( 'Vault-Tec DB (RC1): Changelog', 0, 0);

html_head_link( $dirs['css'] . 'vtdb.css' );
html_head_link( $dirs['css'] . 'scrollme.css' );

html_head_script( $dirs['js'] . 'jquery.js' );
html_head_script( $dirs['js'] . 'scrollme.js' );
html_head_end();
body(0);

$changelog = array(
	/* todo
	'0.4' => array(
		'character position',
	),
	*/
	'0.3u1 (Anne) update1' => array(
		'russian nicknames support (initial state)',
	),
	'0.3 (Anne)' => array(
		'savefile v2: added traits, perks, karma, reputation, kills, [placeholder: position]',
		//'russian nicks support',
		'fallout *real* font used in generated images',
		'working perks / karma / kills tabs',
		'in-game interface',
	),
	'0.2 (Bonny)' => array(
		'rewritten to PHP',
		'.char loader replaced by server module',
		'savefile v1: special, experience, life, stats, skills',
		'fallout messagebox font used in generated images (thanks to CptRookie)',
	),
	'0.1' => array(
		'.char files loader',
		'CGI/Perl version',
		'CharViewer (by JovankaB)',
	),
);


echo( "<div class='top'>\n" );
string2font(1, "Vault-Tec DB\n" );
string2font(3, "ChangeLog" );
echo( "</div>\n<div class='main'><div class='scrollme'>\n" );

$versions = array_keys( $changelog );
$id=0;
foreach( $changelog as $version )
{
	string2font( 3, $versions[$id] . "\n" );
	echo( "<span class='font_green'>\n" );
	foreach( $version as $change )
	{
		echo( "\t* " . $change . "<br />\n" );
	};
	echo( "</span><br />\n" );
	$id++;
};

echo( "	</div></div>\n" );

gen_menu();
gen_submenu('about');

body_end();
html_end();


?>