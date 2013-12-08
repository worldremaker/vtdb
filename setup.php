<?php

//
// home
// 
//
$home = 'fonline2238.net';

//
// Dirs configuration; remember to add '/' at end!
//
$dirs = array(
	// home
	// path to main directory, leave empty if using root dir
	'home' => 'vtdb/',

	// db
	// characters files (if changed, modify online_stats.cpp too)
	'db' => 'db/',

	// dna
	// generated files (need write rights)
	'dna' => 'd/', // 'dna/'

	// chars
	'chars' => 'd/', // 'dna/chars/'

	// backgrounds
	// generated backgrounds
	'backgrounds' => 'd/',

	// graphic
	// directory with graphic, both original and edited
	'graphic' => 'g/',

	// css
	// directory with stylesheets
	'css' => 'r/',

	// js
	// directory with javascripts
	'js' => 'r/',
	
	// include
	// directory with additional php files are
	'include' => 'r/',

	// lang
	// language files
	'lang' => 'r/', // 'l/'
);

$lang = 'en'; include( $dirs['lang'] . "lang.$lang.php" );

$version = '0.3 (Anne)';

?>