<?php

include_once( 'setup.php' );

include_once( $dirs['include'] . 'html.php' );
include_once( $dirs['include'] . 'func.php' );
include_once( $dirs['include'] . 'gd.php' );
include_once( $dirs['include'] . 'char.php' );

/*
 * Local settings, do not edit until you know what you are doing.
 */
 
function char_image($vtdb_dir,$id,$dna_dir)
{
	if( file_exists( "$vtdb_dir/$id.vtdb" ) ||
		file_exists( "$vtdb_dir/$id.php" ))
	{
		$charload = microtime(true);
		$char = char_load( $vtdb_dir, $id );
		$charload = microtime(true) - $charload;
		$filename = sprintf( "%s/charbg.%d%d%d%d%d%d%d%d.png",
			$dna_dir,
			array_key_exists( 'special', $char ),
			array_key_exists( 'xp', $char ),
			array_key_exists( 'life', $char ),
			array_key_exists( 'stats', $char ),
			array_key_exists( 'skills', $char ),
			(array_key_exists( 'traits', $char ) || array_key_exists( 'perks', $char )) ? 1 : 0,
			(array_key_exists( 'karma', $char )  || array_key_exists( 'reputation', $char )) ? 1 : 0,
			array_key_exists( 'kills', $char ));

			$bg_generated = 0;
			if( !file_exists( $filename ))
			{
				$bg_generated = microtime(true);
				gd_charbg( $filename,
					array_key_exists( 'special', $char ),
					array_key_exists( 'xp', $char ),
					array_key_exists( 'life', $char ),
					array_key_exists( 'stats', $char ),
					array_key_exists( 'skills', $char ),
					(array_key_exists( 'traits', $char ) || array_key_exists( 'perks', $char )) ? 1 : 0,
					(array_key_exists( 'karma', $char )  || array_key_exists( 'reputation', $char )) ? 1 : 0,
					array_key_exists( 'kills', $char ));
				$bg_generated = microtime(true) - $bg_generated;
			};

			// time to do some magic!
			$generated = microtime(true);
			$image = gd_imagecreate( $filename );
			
			$char['name'] = RUStoEU($char['name']); // Convert russian nickname to european if needed

			gd_setinfo( $image, $char['id'], $char['name'], $char['gender'], $char['age'] );
			
			if( array_key_exists( 'special', $char ))
				gd_setspecial( $image, $char['special'] );

			if( array_key_exists( 'xp', $char ))
				gd_setxp( $image, $char['xp'] );

			if( array_key_exists( 'life', $char ))
				gd_setlife( $image, $char['life'] );

			if( array_key_exists( 'stats', $char ))
				gd_setstats( $image, $char['stats'] );

			if( array_key_exists( 'skills', $char ))
				gd_setskills( $image, $char['skills'] );

			$generated = microtime(true) - $generated;

			// to-be removed
			/*
			$y = 438;
			foreach( array( "image: $generated", "bg: $bg_generated", 'char v'.$char['version'].": $charload" ) as $line )
			{
				if( $y == 428 && $bg_generated == 0 )
				{
					$y = 427;
				}
				else
				{
					gd_addtext( $image, 350, $y, 'black', $line );
					$y -= 10;
				}
			};
			*/

			return( $image );
	};
};

function RUStoEU($rus_name) { // Convert Russian2European character letters, in nicknames...
			$tempArray = preg_split('//', $rus_name, -1, PREG_SPLIT_NO_EMPTY);
			// View of whole array after preg_split...
			//print_r($tempArray);
	
			// Check for russian character letter in nickname...
			if($tempArray[0] == '&' && $tempArray[1] == '#') {
				// Prepare variables...
				$tempCount = 0;
				$newName = '';
				$newLetter = '';
				$newCode = '';
				while($tempCount < count($tempArray)) {
					//Kiedy jest spacja
					if($tempArray[$tempCount] == ' ') {
						$newLetter = ' ';
						$tempCount++;
					} else {
						$newCode = $tempArray[$tempCount + 2].$tempArray[$tempCount + 3].$tempArray[$tempCount + 4].$tempArray[$tempCount + 5];
						$tempCount = $tempCount + 7;
						
						if($newCode == '1072'){
							$newLetter = 'a';
						}
						if($newCode == '1073'){
							$newLetter = 'b';
						}
						if($newCode == '1074'){
							$newLetter = 'v';
						}
						if($newCode == '1075'){
							$newLetter = 'g';
						}
						if($newCode == '1076'){
							$newLetter = 'd';
						}
						if($newCode == '1077'){
							$newLetter = 'ye';
						}
						if($newCode == '1078'){
							$newLetter = 'zh';
						}
						if($newCode == '1079'){
							$newLetter = 'z';
						}
						if($newCode == '1080'){
							$newLetter = 'i';
						}
						if($newCode == '1081'){
							$newLetter = 'y';
						}
						if($newCode == '1082'){
							$newLetter = 'k';
						}
						if($newCode == '1083'){
							$newLetter = 'l';
						}
						if($newCode == '1084'){
							$newLetter = 'm';
						}
						if($newCode == '1085'){
							$newLetter = 'n';
						}
						if($newCode == '1086'){
							$newLetter = 'o';
						}
						if($newCode == '1087'){
							$newLetter = 'p';
						}
						if($newCode == '1088'){
							$newLetter = 'r';
						}
						if($newCode == '1089'){
							$newLetter = 's';
						}
						if($newCode == '1090'){
							$newLetter = 't';
						}
						if($newCode == '1091'){
							$newLetter = 'u';
						}
						if($newCode == '1092'){
							$newLetter = 'f';
						}
						if($newCode == '1093'){
							$newLetter = 'kh';
						}
						if($newCode == '1094'){
							$newLetter = 'ts';
						}
						if($newCode == '1095'){
							$newLetter = 'ch';
						}
						if($newCode == '1096'){
							$newLetter = 'sh';
						}
						if($newCode == '1097'){
							$newLetter = 'shch';
						}
						if($newCode == '1098'){
							$newLetter = '"';
						}
						if($newCode == '1099'){
							$newLetter = 'y';
						}
						if($newCode == '1100'){
							$newLetter = '\\';
						}
						if($newCode == '1101'){
							$newLetter = 'e';
						}
						if($newCode == '1102'){
							$newLetter = 'yu';
						}
						if($newCode == '1103'){
						$newLetter = 'ya';
						}
					
					}				
				$newName = $newName.$newLetter;
				}
				$rus_name = $newName;
			}
	return $rus_name;
}

$id = $_SERVER['QUERY_STRING'];	
if( !$id || $id == "0" )
{
	global $home, $dirs;

	location( 301, "http://$home/".$dirs['home'] );
	ob_end_flush();

	exit;
}
else if( !ctype_digit( $id ))
{
	$img = ""; if( array_key_exists( 'img', $_GET )) $img = $_GET['img'];
	if( $img != "" )
	{
		$image = char_image( $dirs['db'], $img, $dirs['dna'] );

		header( 'Pragma: no-cache' );
		header( 'Content-Type: image/gif' );
		header( "X-VTDB-IMG: $img" );

		imagegif( $image );
		imagedestroy( $image );

		exit;
	};

	$getimg = ""; if( array_key_exists( 'getimg', $_GET )) $getimg = $_GET['getimg'];
	if( $getimg && ctype_digit( $getimg ))
	{
		$image = char_image( $vtdb_dir, $getimg );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( "Pragma: no-cache" );
		header( "Content-Type: application/octet-stream" );
		header( "Content-Disposition: disposition-type=attachment; filename=\"$getimg.gif\"" );

		imagegif( $image );
		imagedestroy( $image );

		exit;
	};

	$sig = ""; if( array_key_exists( 'sig', $_GET )) $sig = $_GET['sig'];
	if( $sig && ctype_digit( $sig ))
	{
		$char = char_load( $dirs['db'], $sig );
		$char['name'] = RUStoEU($char['name']); // Convert russian nickname to european if needed
		if( $char && $char['xp'] )
		{
			$type = "1"; if( array_key_exists( 't', $_GET )) $type = $_GET['t'];
			if( !isset($type) || empty($type) || !ctype_digit( $type ))
				$type = "1";
			$image = gd_imagecreate( $dirs['graphic'] . "sig${type}.png" );
			imagesavealpha($image, true );

			$iname = gd_ftext( 3, 2, 5, $char['name'] );
			imagecopy( $image, $iname,
				gd_getcenter( 17, 143, imagesx($iname) ),
				gd_getcenter( 3, 25, imagesy($iname) ),
				0, 0, imagesx($iname), imagesy($iname) );
			imagedestroy( $iname );

			$y = 46;
			$id = 0;
			foreach( $char['xp'] as $xp )
			{
				$xp = preg_replace( "/%d$/", CLAMP( $xp, $gd['xp_Lclamp'], $gd['xp_Hclamp'] ), $lang_xp[$id] );
				$image = gd_addtext( $image, 18, $y, 'green', $xp );
				$y += $gd['xp_y_jump'];
				$id++;
			};

			header( "Pragma: no-cache" );
			header( 'Content-Type: image/gif' );
			header( "X-VTDB-SIG: $type" );

			imagegif( $image );
			imagedestroy( $image );
		};
		exit;
	};

	$rvtdb = ""; if( array_key_exists( 'rvtdb', $_GET )) $rvtdb = $_GET['rvtdb'];
	if( defined( $rvtdb ))
	{
		$char = 0;
		$r = 301;
		if( ctype_digit( $rvtdb ))
		{
			$char = char_load( $dirs['db'], $rvtdb );
			if( $char )
			{
				$r = 302;
				header( "X-VTDB-VTDB: ".$version );
				foreach( array( 'version', 'mtime', 'name', 'gender', 'age', 'special', 'xp', 'life', 'stats', 'skills',
								'traits', 'perks', 'proffesions', 'karma', 'addictions', 'reputation', 'kills' )
						 as $info )
				{
					if( is_array( $char[$info] ))
					{
						if( count( $char[$info] ) >= 1 )
							header( sprintf( "X-VTDB-%s: %s", $info, join( ' ', $char[$info] )));
					}
					elseif( $char[$info] != "" )
						header( sprintf( "X-VTDB-%s: %s", $info, $char[$info] ));
				}
			};
		}
		elseif( $rvtdb == "dna" )
		{
			if( $dir = opendir( $dirs['dna'] ))
			{
				$files=0;
				$bg = 0;
				$name = 0;
				$age = 0;
				$gender = 0;
				while(( $file = readdir($dir)) != false )
				{
					if( $file != '.' && $file != '..' )
					{
						$files++;
						if( preg_match('/charbg.[0-9]+.png/', $file ))
							$bg++;
						elseif( preg_match( '/charname.[0-9]+.png/', $file ))
							$name++;
						elseif( preg_match( '/charage.[0-9]+.png/', $file ))
							$age++;
						elseif( preg_match( '/chargender.[a-z]+.png/', $file ))
							$gender++;
					};
				};
				closedir($dir);
				header( "X-VTDB-total: $files" );
				header( "X-VTDB-bg: $bg" );
				header( "X-VTDB-name: $name" );
				header( "X-VTDB-gender: $gender" );
				header( "X-VTDB-age: $age" );
			}
			else
			{
			};
		};

		location( $r, "http://$home/" . $dirs['home'] );
		exit;
	};
	
	echo "Huh.";
	exit;
};

content_type( 'text/html' );
doctype( 'transitional' );
html();
html_head( 'Vault-Tec DB (RC1)', 'noindex,nofollow,noarchive', 0 );
html_head_link( $dirs['css'] .'vtdb.css' );
html_head_script( $dirs['js'] . 'vtdb.js' );
echo( "\t<!--[if IE]>\n\t" );
html_head_link( 'r/vtdb-ie.css' );
echo( "\t<![endif]-->\n" );

html_head_end();
body("style='margin-top: 10px;'");

if( file_exists( $dirs['db'] . "/$id.php" ) ||
	file_exists( $dirs['db'] . "/$id.vtdb" ))
{
	$char = char_load( $dirs['db'], $id );
	$home = $dirs['home'];

	echo( "<div class='character_name'>\n" );
	string2font( 1, $char['name'] );
	echo( "</div>
	
<div class='character'>
	<div class='image' style='background-image: url(char.php?img=$id);'>
		<div class='infotext'>
			<span id='infotext' class='font_black'>&nbsp;</span>
		</div>
" );

	if( array_key_exists( 'special', $char ) && count($lang_special_long_descr) > 0 )
	{
		echo( "\t\t<div class='special'>\n" );
		for( $i=0; $i<count($lang_special_long_descr); $i++ )
		{
			printf( "\t\t\t<span style='top: %dpx;' onmouseover='infotext(\"%s\");' onmouseout='infotext(\"\");'>&nbsp;</span>\n",
				$i*33, htmlspecialchars($lang_special_long_descr[$i]) );
		}
		
		echo( "\t\t</div> <!-- .character .image .special -->\n" );
	};

	if( array_key_exists( 'xp', $char ) && count($lang_xp_descr) > 0 )
	{
		echo( "\t\t<div class='xp'>\n" );
		for( $i=0; $i<count($lang_xp_descr); $i++ )
		{
			printf( "\t\t\t<span style='top: %dpx;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">&nbsp;</span>\n",
				$i == 0 ? 7 : 7+($i*12), htmlspecialchars($lang_xp_descr[$i]) );
		};
		echo( "\t\t</div> <!-- .character .image .xp -->\n" );
	};

	if( array_key_exists( 'life', $char ) && count($lang_life_descr) > 0 )
	{
		echo( "\t\t<div class='life'>\n" );
		for( $i=0; $i<count($lang_life_descr); $i++ )
		{
			printf( "\t\t\t<span style='top: %dpx;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">&nbsp;</span>\n",
				$i == 0 ? 8 : 8+($i*14), htmlspecialchars($lang_life_descr[$i]) );
		}
		echo( "\t\t</div> <!-- .character .image .life -->\n" );
	};

	if( array_key_exists( 'stats', $char ) && count($lang_stats_descr) > 0 )
	{
		echo( "\t\t<div class='stats'>\n" );
		for( $i=0; $i<count($lang_stats_descr); $i++ )
		{
			printf( "\t\t\t<span style='top: %dpx;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">&nbsp;</span>\n",
				$i == 0 ? 13 : 13+($i*13), htmlspecialchars($lang_stats_descr[$i]) );
		};
		echo( "\t\t</div> <!-- .character .image .stats -->\n" );
	};

	if( array_key_exists( 'skills', $char ) && count($lang_skills_descr) > 0 )
	{
		echo( "\t\t<div class='skills'>\n" );
		echo( "\t\t\t<span style='height:20px;' onmouseover=\"infotext('skills [-1]');\" onmouseout=\"infotext('');\">&nbsp;</span>\n" );
		for( $i=0; $i<count($lang_skills_descr); $i++ )
		{
			printf( "\t\t\t<span style='top: %dpx;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">&nbsp;</span>\n",
				$i == 0 ? 21 : 21+($i*11), htmlspecialchars($lang_skills_descr[$i]) );
		};
		echo( "\t\t\t<p style='top:220px; width: 160px; height:33px; margin:0;border:0;padding:0;' onmouseover=\"infotext('skills [-2]');\" onmouseout=\"infotext('');\"></p>\n" );
		echo( "\t\t\t<p style='top:220px; left: 161px; width: 126px; height:33px; margin:0;border:0;padding:0;' onmouseover=\"infotext('skills [-3]');\" onmouseout=\"infotext('');\"></p>\n" );
		echo( "\t\t</div> <!-- .character .image .skills -->\n" );
	};

	// lets deal with tabs once and for all
	$tab_perks = false;
	$tab_karma = false;
	$tab_kills = false;

	foreach( array( 'traits', 'perks', 'proffesions' ) as $element )
	{
		if( array_key_exists( $element, $char ))
		{
			$tab_perks = true;
			break;
		};
	};
	foreach( array( 'karma', 'reputation' ) as $element )
	{
		if( array_key_exists( $element, $char ))
		{
			$tab_karma = true;
			break;
		};
	};
	if( array_key_exists( 'kills', $char ))
	{
		$tab_kills = true;
	};

	if( $tab_perks || $tab_karma || $tab_kills )
	{
		echo( "\t\t<div class='tabs'>\n" );

		echo( "\t\t\t<img id='tab' src='g/iecrap.gif' alt='' />\n" ); // hurr
		if( $tab_perks )
		{
			printf( "\t\t\t<p class='perks'%s%s%s%s onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\"></p>\n",
				($tab_karma || $tab_kills) ? ' onclick="' : '',
				$tab_kills ? "hide('kills');" : '',
				$tab_karma ? "hide('karma');" : '',
				($tab_karma || $tab_kills) ? "show('perks');\"" : '',
				$lang_tabs_descr[0] );
		};
		if( $tab_karma )
		{
			printf( "\t\t\t<p class='karma'%s%s%s%s onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\"></p>\n",
				($tab_perks || $tab_kills) ? ' onclick="' : '',
				$tab_perks ? "hide('perks');" : '',
				$tab_kills ? "hide('kills');" : '',
				($tab_perks || $tab_kills) ? "show('karma');\"" : '',
				$lang_tabs_descr[1] );
		};
		if( $tab_kills )
		{
			printf( "\t\t\t<p class='kills'%s%s%s%s onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\"></p>\n",
				($tab_perks || $tab_karma) ? ' onclick="' : '',
				$tab_perks ? "hide('perks');" : '',
				$tab_karma ? "hide('karma');" : '',
				($tab_perks || $tab_karma) ? "show('kills');\"" : '',
				$lang_tabs_descr[2] );
		};
		echo( "\t\t</div> <!-- .character .image .tabs -->\n" );

		if( $tab_perks )
		{
			echo( "\t\t<div id='scroll-perks'>\n" );
			echo( "\t\t\t<p class='up' onmousedown=\"scroll('infobox-perks',-10);\" onmouseup=\"clearTimeout(zxcTO);\"></p>\n" );
			echo( "\t\t\t<p class='down' style='top:14px;' onmousedown=\"scroll('infobox-perks',10);\" onmouseup=\"clearTimeout(zxcTO);\"></p>\n" );
			echo( "\t\t</div> <!-- .character .image #scroll-perks -->\n" );
		}
		if( $tab_karma )
		{
			printf( "\t\t<div id='scroll-karma'%s>\n",
				$tab_perks ?  " style='visibility:hidden;'" : '' );
			echo( "\t\t\t<p class='up' onmousedown=\"scroll('infobox-karma',-10);\" onmouseup=\"clearTimeout(zxcTO);\"></p>\n" );
			echo( "\t\t\t<p class='down' style='top:14px;' onmousedown=\"scroll('infobox-karma',10);\" onmouseup=\"clearTimeout(zxcTO);\"></p>\n" );
			echo( "\t\t</div> <!-- .character .image #scroll-perks -->\n" );
		}
		if( $tab_kills )
		{
			printf( "\t\t<div id='scroll-kills'%s>\n",
				$tab_perks || $tab_karma ? " style='visibility:hidden;'" : '' );
			echo( "\t\t\t<p class='up' onmousedown=\"scroll('infobox-kills',-10);\" onmouseup=\"clearTimeout(zxcTO);\"></p>\n" );
			echo( "\t\t\t<p class='down' style='top:14px;' onmousedown=\"scroll('infobox-kills',10);\" onmouseup=\"clearTimeout(zxcTO);\"></p>\n" );
			echo( "\t\t</div> <!-- .character .image #scroll-perks -->\n" );
		}

		echo( "\t\t<div id='infobox'>\n" );

		if( $tab_perks )
		{
			$line=0;
			echo( "\t\t\t<div id='infobox-perks' class='font_green_infobox'>\n" );		
			if( array_key_exists( 'traits', $char ) && count($lang_traits)>0 )
			{
				printf( "\t\t\t\t<span style='text-align: center;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s</span>\n",
					$lang_traits_descr[0], $lang_traits[0] );
				$line++;
				foreach( $char['traits'] as $trait )
				{
					printf( "\t\t\t\t<span style='top:%dpx;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s</span><br />\n",
						$line*16,
						htmlspecialchars($lang_traits_descr[$trait-549]), htmlspecialchars($lang_traits[$trait-549]) );
					$line++;
				};
			};
			if( array_key_exists( 'perks', $char ) && count($lang_perks)>0 )
			{			
				printf( "\t\t\t\t<span style='top: %dpx; text-align: center;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s</span>\n",
					($line*16), $lang_perks_descr[0], $lang_perks[0] );
				$line++;
				foreach( $char['perks'] as $perk )
				{
					$p = explode( ':', $perk );
					printf( "\t\t\t\t<span style='top: %dpx;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s%s</span>\n",
						($line*16), htmlspecialchars($lang_perks_descr[$p[0]-299]), htmlspecialchars($lang_perks[$p[0]-299]),
						(!isset($p[1]) || $p[1] == 1) ? '' : " ($p[1])" );
					$line++;
				};
			}
			if( array_key_exists( 'proffesions', $char ))
			{
				foreach( $char['proffesions'] as $proffesion )
				{
					$r = explode( ':', $proffesion );
					printf( "\t\t\t\t<span style='top: %dpx;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s%s</span>\n",
						($line*16),
						htmlspecialchars($lang_proffesions_descr[$r[0]-570]),
						htmlspecialchars($lang_proffesions[$r[0]-570]),
						(!isset($r[1]) || $r[1] == 1) ? '' : " ($r[1])" );
					$line++;
				};
			};
			echo( "\t\t\t</div> <!-- .character .image #infobox #infobox-perks -->\n" );
		}

		if( $tab_karma )
		{
			$line=0;
			printf( "\t\t\t<div id='infobox-karma' class='font_green_infobox'%s>\n",
				$tab_perks ? " style='visibility:hidden;'" : '' );
			if( array_key_exists( 'karma', $char ))
			{
				$format = preg_replace( "/\%d/", $char['karma'][0], $lang_karma_info[1] );
				$format = preg_replace( "/\%s/", 'TODO', $format );
				printf( "\t\t\t\t<span onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s%s</span>\n",
					$lang_karma_info[2],
					$lang_karma_info[0],
					$format );
				$line++;
				$id=0;
				foreach( $char['karma'] as $karma )
				{
					$id++;
					if( $id == 1 )
						continue;
					else
					{
						printf( "\t\t\t\t<span style='top: %dpx;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s</span>\n",
							($line*16),
							htmlspecialchars($lang_karma_descr[$karma-480]),
							htmlspecialchars($lang_karma[$karma-480]) );
						$line++;
					};
				};
			}; // karma
			if( array_key_exists( 'addictions', $char ))
			{
				printf( "\t\t\t\t<span style='top:%dpx; text-align:center;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s</span>\n",
					($line*16)-2,
					$lang_addictions_descr[0],
					$lang_addictions[0] );
				$line++;
				foreach( $char['addictions'] as $addiction )
				{
					printf( "\t\t\t\t<span style='top: %dpx;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s</span>\n",
						($line*16),
						htmlspecialchars($lang_addictions_descr[$addiction-469]),
						htmlspecialchars($lang_addictions[$addiction-469])
					);
					$line++;				
				};
			};
			if( array_key_exists( 'reputation', $char ))
			{
				printf( "\t\t\t\t<span style='top: %dpx; text-align:center;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s</span>\n",
					($line*16)-2,
					$lang_reputation_descr[0],
					$lang_reputation[0]
				);
				$line++;
				$_descr_max = count($lang_reputation_descr)-1;
				foreach( $char['reputation'] as $reputation )
				{
					$r = explode( ':', $reputation );
					if( $r[1] != 0 ) //&& $r[1] != -2147483648 )
					{
						$_descr = $_descr_max;
						if( $r[1] >= 1500 )
							$_descr = 1;
						elseif( $r[1] >= 900 )
							$_descr = 2;
						elseif( $r[1] >= 300 )
							$_descr = 3;
						elseif( $r[1] >= -299 )
							$_descr = 4;
						elseif( $r[1] >= -899 )
							$_descr = 5;
						elseif( $r[1] >= -1499 )
							$_descr = 6;
						printf( "\t\t\t\t<span style='top: %dpx;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s: %d (%s)</span>\n",
							($line*16),
							htmlspecialchars($lang_reputation_descr[$_descr]),
							$lang_factions[$r[0]-602],
							$r[1],
							$lang_reputation[$_descr]
						);
					}	$line++;
					
				}
			};
			echo( "\t\t\t</div> <!-- .character .image #infobox #infobox-karma -->\n" );
		}

		if( $tab_kills )
		{
			printf( "\t\t\t<div id='infobox-kills' class='font_green_infobox'%s>\n",
				$tab_perks || $tab_karma ?  " style='visibility:hidden;'" : '' );
			$line=0;
			foreach( $char['kills'] as $kill )
			{
				$k = explode( ':', $kill );
				printf( "\t\t\t\t<span style='top: %dpx;' onmouseover=\"infotext('%s');\" onmouseout=\"infotext('');\">%s\n\t\t\t\t\t<span style='left:%dpx;'>%s</span>\n\t\t\t\t</span>\n",
					($line*16),
					htmlspecialchars($lang_kills_descr[$k[0]-260]),
					htmlspecialchars($lang_kills[$k[0]-260]),
					245, CLAMP(isset($k[1])?$k[1]:1, 1, 99999 ));
				$line++;
			};
			echo( "\t\t\t</div> <!-- .character .image #infobox #infobox-kills -->\n" );
		}

		echo( "\t\t</div> <!-- .character .image #infobox -->\n" );
	}
	echo( "\t</div> <!-- .character .image -->\n" );
	echo( "</div> <!-- .character -->\n" );

	gen_menu();
	gen_submenu( 'character', $char['id'] );
}
else
{
	echo( "No char, no fun." );
};

body_end();
html_end();
?>
