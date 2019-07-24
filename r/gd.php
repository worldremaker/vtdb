<?php

include( 'setup.php' );

$gd = array(
	'color_green'			=> array( 0, 255, 0 ),
	'color_red'				=> array( 255, 0, 0 ),
	'color_tag'				=> array( 168, 173, 167 ),
	'color_disabled'		=> array( 50, 52, 47 ),

	'*character*'			=> 'g/character.png',
	'*hidden*'				=> 'g/character_hidden.jpg',
	'*perks_tab*'			=> 'g/perksfdr.gif',
	'*karma_tab*'			=> 'g/karmafdr.gif',
	'*kills_tab*'			=> 'g/killsfdr.gif',
	'*scrolltab_up*'		=> 'g/uparwoff.gif',
	'*scrolltab_down*'		=> 'g/dnarwoff.gif',
	'*font_bignum*'			=> 'g/fnt_big_num.gif',
	'_special_'				=> 'g/special.gif', // temp
	'_skills_'				=> 'g/skills.gif', // temp
	'_skill_points_'		=> 'g/skillpoints.gif', //temp

	'*ffont*'				=> 'ffont%d.png', //

	'*charbg*'				=> 'charbg.%d.png',
	'*charname*'			=> 'charname.%d.png',
	'*chargender*'			=> 'chargender.%s.png',
	'*charage*'				=> 'charage.%d.png',

	'name_x_start'			=> 24,
	'name_x_end'			=> 149,
	'name_y'				=> 7,
	
	'age_x_start'			=> 160,
	'age_x_end'				=> 230,
	'age_y'					=> 7,

	'gender_x_start'		=> 235,
	'gender_x_end'			=> 310,
	'gender_y'				=> 7,
	
	'special_hidden_x'		=> 0,
	'special_hidden_y'		=> 33,
	'special_hidden_w'		=> 173,
	'special_hidden_h'		=> 234,
	'special_x'				=> 60,
	'special_x_fix'			=> 15,
	'special_y_fix'			=> 16,
	'special_x_descr'		=> 102,
	'special_y_descr'		=> 54,
	'special_y_descr_jump'	=> 33,
	'special_Lclamp'		=> 0,
	'special_Hclamp'		=> 99,

	'xp_hidden_x'			=> 0,
	'xp_hidden_y'			=> 268,
	'xp_hidden_w'			=> 172,
	'xp_hidden_h'			=> 56,
	'xp_x'					=> 29,
	'xp_y'					=> 288,
	'xp_y_jump'				=> 11,
	'xp_Lclamp'				=> 0,
	'xp_Hclamp'				=> 99999999,

	'life_hidden_x'			=> 170,
	'life_hidden_y'			=> 33,
	'life_hidden_w'			=> 162,
	'life_hidden_h'			=> 130,
	'life_x'				=> 190,
	'life_y'				=> 51,
	'life_y_jump'			=> 14,
	'life_Lclamp_hp'		=> -999,
	'life_Hclamp_hp'		=> 999,

	'stats_hidden_x'		=> 170,
	'stats_hidden_y'		=> 163,
	'stats_hidden_w'		=> 163,
	'stats_hidden_h'		=> 163,
	'stats_x_name'			=> 189,
	'stats_x_value'			=> 288,
	'stats_y'				=> 189,
	'stats_y_jump'			=> 13,
	'stats_Lclamp_normal'	=> 0,
	'stats_Hclamp_normal'	=> 9999,
	'stats_Lclamp_percent'	=> 0,
	'stats_Hclamp_percent'	=> 999,

	'skills_hidden_x'		=> 333,
	'skills_hidden_y'		=> 0,
	'skills_hidden_w'		=> 307,
	'skills_hidden_h'		=> 261,
	'skills_x_name'			=> 368,
	'skills_x_value'		=> 574,
	'skills_y'				=> 34,
	'skills_y_jump'			=> 11,
	'skills_tag'			=> '+', // when changing this, modify online_stats.cpp too
	'skills_Lclamp'			=> -9999,
	'skills_Hclamp'			=> 99999,

	'scrolltab_x'			=> 316,
	'scrolltab_up_y'		=> 370,
	'scrolltab_down_y'		=> 384,
	
	'perkskarmakills_hidden_x'	=> 0,
	'perkskarmakills_hidden_y'	=> 350,
	'perkskarmakills_hidden_w'	=> 333,
	'perkskarmakills_hidden_h'	=> 130,
);

function gd_getcenter($start,$end,$wh)
{
	return( $start + ((( $end - $start ) - $wh ) / 2 ));
}

function gd_imagecreate( $filename, $truecolor=0 )
{
	if( strlen($filename) < 5 )
	{
		user_error( "gd_imagecreate: wrong filename ($filename)" );
		exit;
	}
	elseif( !file_exists( $filename ))
	{
		user_error( "gd_imagecreate: file don't exists ($filename)" );
		exit;
	};

	$ext = substr( $filename, -4 );

	if( $ext == ".png" )
	{
		$image = imagecreatefrompng( $filename );
		return( $image );
	}
	elseif( $ext == ".jpg" )
	{
		$image = imagecreatefromjpeg( $filename );
		return( $image );
	}
	elseif( $ext == ".gif" )
	{
		$image = imagecreatefromgif( $filename );
		return( $image );
	}
	/*
	elseif( $ext == ".bmp" )
	{
		$image = imagecreatefromwbmp( $filename );
		return( $image );
	}
	*/
	else
	{
		user_error( "gd_imagecreate: wrong extension ($filename)" );
		exit;
	};
};

function gd_charbg($f_result,$bg_special,$bg_xp,$bg_life,$bg_stats,$bg_skills,$bg_perks,$bg_karma,$bg_kills)
{
	global $gd, $version;

	$image		= gd_imagecreate( $gd['*character*'] );
	$hidden		= gd_imagecreate( $gd['*hidden*'] );
	 
	if( !$bg_special )
		imagecopy( $image, $hidden,
			$gd['special_hidden_x'], $gd['special_hidden_y'],
			$gd['special_hidden_x'], $gd['special_hidden_y'],
			$gd['special_hidden_w'], $gd['special_hidden_h'] );

	if( !$bg_xp )
	{
		imagecopy( $image, $hidden,
			$gd['xp_hidden_x'], $gd['xp_hidden_y'],
			$gd['xp_hidden_x'], $gd['xp_hidden_y'],
			$gd['xp_hidden_w'], $gd['xp_hidden_h'] );
	};

	if( !$bg_life )
		imagecopy( $image, $hidden,
			$gd['life_hidden_x'], $gd['life_hidden_y'],
			$gd['life_hidden_x'], $gd['life_hidden_y'],
			$gd['life_hidden_w'], $gd['life_hidden_h'] );
	
	if(!$bg_stats )
		imagecopy( $image, $hidden,
			$gd['stats_hidden_x'], $gd['stats_hidden_y'],
			$gd['stats_hidden_x'], $gd['stats_hidden_y'],
			$gd['stats_hidden_w'], $gd['stats_hidden_h'] );

	if( !$bg_skills )
		imagecopy( $image, $hidden,
			$gd['skills_hidden_x'], $gd['skills_hidden_y'],
			$gd['skills_hidden_x'], $gd['skills_hidden_y'],
			$gd['skills_hidden_w'], $gd['skills_hidden_h'] );

	if( !$bg_perks && !$bg_karma && !$bg_kills )
		imagecopy( $image, $hidden, 0, 350, 0, 350, 333, 130 );
	else
	{
		$dest_x = 10;
		$dest_y = 326;

		if( $bg_perks )
		{

			if( $bg_kills )
			{
				$kills = gd_imagecreate( $gd['*kills_tab*'] );
				imagecopy( $image, $kills, $dest_x, $dest_y, 0, 0, 318, 33 );
				imagedestroy( $kills );
			};

			if( $bg_karma )
			{
				$karma = gd_imagecreate( $gd['*karma_tab*'] );
				imagecopy( $image, $karma, $dest_x, $dest_y, 0, 0, 318, 33 );
				imagedestroy( $karma );
			};

			$perks = gd_imagecreate( $gd['*perks_tab*'] );
			imagecopy( $image, $perks, $dest_x, $dest_y, 0, 0, 318, 33 );
			imagedestroy( $perks );
		}
		elseif( $bg_karma )
		{
			if( $bg_kills )
			{
				$kills = gd_imagecreate( $gd['*kills_tab*'] );
				imagecopy( $image, $kills, $dest_x, $dest_y, 0, 0, 318, 33 );
				imagedestroy( $kills );
			};

			if( $bg_perks )
			{
				$perks = gd_imagecreate( $gd['*perks_tab*'] );
				imagecopy( $image, $perks, $dest_x, $dest_y, 0, 0, 318, 33 );
				imagedestroy( $perks );
			};
			
			$karma = gd_imagecreate( $gd['*karma_tab*'] );
			imagecopy( $image, $karma, $dest_x, $dest_y, 0, 0, 318, 33 );
			imagedestroy( $karma );
		}
		elseif( $bg_kills )
		{
			$kills = gd_imagecreate( $gd['*kills_tab*'] );
			imagecopy( $image, $kills, $dest_x, $dest_y, 0, 0, 318, 33 );
			imagedestroy( $kills );
		};

		$img = gd_imagecreate( $gd['*scrolltab_up*'] );
		imagecopy( $image, $img, $gd['scrolltab_x'], $gd['scrolltab_up_y'], 0, 0, imagesx($img), imagesy($img) );
		imagedestroy( $img );

		$img = gd_imagecreate( $gd['*scrolltab_down*'] );
		imagecopy( $image, $img, $gd['scrolltab_x'], $gd['scrolltab_down_y'], 0, 0, imagesx($img), imagesy($img) );
		imagedestroy( $img );
	};

	/*
	gd_addtext( $image, $gd['special_hidden_x'], $gd['special_hidden_y'], 'red', 'S' );
	gd_addtext( $image, $gd['special_hidden_x']+$gd['special_hidden_w'], $gd['special_hidden_y'], 'red', 'S' );
	gd_addtext( $image, $gd['special_hidden_x'], $gd['special_hidden_y']+$gd['special_hidden_h'], 'red', 'S' );
	gd_addtext( $image, $gd['special_hidden_x']+$gd['special_hidden_w'], $gd['special_hidden_y']+$gd['special_hidden_h'], 'red', 'S' );

	gd_addtext( $image, $gd['xp_hidden_x'], $gd['xp_hidden_y'], 'red', 'x' );
	gd_addtext( $image, $gd['xp_hidden_x']+$gd['xp_hidden_w'], $gd['xp_hidden_y'], 'red', 'x' );
	gd_addtext( $image, $gd['xp_hidden_x'], $gd['xp_hidden_y']+$gd['xp_hidden_h'], 'red', 'x' );
	gd_addtext( $image, $gd['xp_hidden_x']+$gd['xp_hidden_w'], $gd['xp_hidden_y']+$gd['xp_hidden_h'], 'red', 'x' );
	
	gd_addtext( $image, $gd['life_hidden_x'], $gd['life_hidden_y'], 'red', 'l' );
	gd_addtext( $image, $gd['life_hidden_x']+$gd['life_hidden_w'], $gd['life_hidden_y'], 'red', 'l' );
	gd_addtext( $image, $gd['life_hidden_x'], $gd['life_hidden_y']+$gd['life_hidden_h'], 'red', 'l' );
	gd_addtext( $image, $gd['life_hidden_x']+$gd['life_hidden_w'], $gd['life_hidden_y']+$gd['life_hidden_h'], 'red', 'l' );
	
	gd_addtext( $image, $gd['stats_hidden_x'], $gd['stats_hidden_y'], 'red', 't' );
	gd_addtext( $image, $gd['stats_hidden_x']+$gd['stats_hidden_w'], $gd['stats_hidden_y'], 'red', 't' );
	gd_addtext( $image, $gd['stats_hidden_x'], $gd['stats_hidden_y']+$gd['stats_hidden_h'], 'red', 't' );
	gd_addtext( $image, $gd['stats_hidden_x']+$gd['stats_hidden_w'], $gd['stats_hidden_y']+$gd['stats_hidden_h'], 'red', 't' );
	
	gd_addtext( $image, $gd['skills_hidden_x'], $gd['skills_hidden_y'], 'red', 's' );
	gd_addtext( $image, $gd['skills_hidden_x']+$gd['skills_hidden_w'], $gd['skills_hidden_y'], 'red', 's' );
	gd_addtext( $image, $gd['skills_hidden_x'], $gd['skills_hidden_y']+$gd['skills_hidden_h'], 'red', 's' );
	gd_addtext( $image, $gd['skills_hidden_x']+$gd['skills_hidden_w'], $gd['skills_hidden_y']+$gd['skills_hidden_h'], 'red', 's' );
	
	gd_addtext( $image, $gd['perkskarmakills_hidden_x'], $gd['perkskarmakills_hidden_y'], 'red', 'p' );
	gd_addtext( $image, $gd['perkskarmakills_hidden_x']+$gd['perkskarmakills_hidden_w'], $gd['perkskarmakills_hidden_y'], 'red', 'p' );
	gd_addtext( $image, $gd['perkskarmakills_hidden_x'], $gd['perkskarmakills_hidden_y']+$gd['perkskarmakills_hidden_h'], 'red', 'p' );
	gd_addtext( $image, $gd['perkskarmakills_hidden_x']+$gd['perkskarmakills_hidden_w'], $gd['perkskarmakills_hidden_y']+$gd['perkskarmakills_hidden_h'], 'red', 'p' );
	*/
	
	$info = "Vault-Tec DB, v$version
by WHINE Team (update1 by worldremaker)";
	$info = preg_split( '/\n/', $info, -1, PREG_SPLIT_NO_EMPTY); # :/
	$y = 285;//310;
	foreach( $info as $line )
	{
		gd_addtext( $image, 350, $y, 'black', $line );
		$y += 10;
	};
	gd_addtext( $image, 530, 438, 'black', "fonline2238.net" );

	imagedestroy( $hidden );
	imagepng( $image, $f_result );
	imagedestroy( $image );
};

function gd_addtext($image,$x,$y,$color,$text)
{
	global $gd;

	switch( $color )
	{
		case 'green':
			$color = imagecolorallocate( $image, $gd['color_green'][0], $gd['color_green'][1], $gd['color_green'][2] ); break;
		case 'red':
			$color = imagecolorallocate( $image, $gd['color_red'][0], $gd['color_red'][1], $gd['color_red'][2] ); break;
		case 'tag':
			$color = imagecolorallocate( $image, $gd['color_tag'][0], $gd['color_tag'][1], $gd['color_tag'][2] ); break;
		case 'disabled':
			$color = imagecolorallocate( $image, $gd['color_disabled'][0], $gd['color_disabled'][1], $gd['color_disabled'][2] ); break;
		case 'black':
		default:
			$color = imagecolorallocate( $image, 35, 0, 0 ); break;
	};

	$path = realpath('.');
	imagefttext( $image, 6, 0, $x, $y, $color, "$path/r/jh_fallout-webfont.ttf", $text );

	imagecolordeallocate( $image, $color );
	
	return( $image );
};
/*
function gd_replacetext($image,$original,$x1,$y1,$x2,$y2,$color,$text)
{
	global $realhome_dir;

	$bg = imagecolorallocate( $image, 2, 13, 0 );
	//imagefilledrectangle($image, $x1, $y1, $x2, $y2, $bg );
	imagefttext( $image, 6, 0, $x1, $y1, $color, "$realhome_dir/r/jh_fallout-webfont.ttf", $text );

	return( $image );
};
*/

function gd_addbignum( $image, $x, $y, $num )
{
	global $gd;
	
	$src_x = 1;

	switch( CLAMP( $num, 0, 9 ))
	{
		case 9:
			$src_x = 127; break;
		case 8:
			$src_x = 113; break;
		case 7:
			$src_x = 99; break;
		case 6:
			$src_x = 85; break;
		case 5:
			$src_x = 71; break;
		case 4:
			$src_x = 57; break;
		case 3:
			$src_x = 43; break;
		case 2:
			$src_x = 29; break;
		case 1:
			$src_x = 15; break;
	};
	
	$bignum = gd_imagecreate( $gd['*font_bignum*'] );
	imagecopy( $image, $bignum, $x, $y, $src_x, 1, 14, 22 );
	imagedestroy( $bignum );
};

// абвгдежз
// ийклмнопрстуфхцчшщъы
// ьэюя
function gd_ftext( $font, $sp1, $sp2, $text )
{
	global $dirs, $gd;
	
	$letters = 0;
	if( $font == 3 )
	{
		$letters = array(
			'a' => array( 181, 111, 190, 126 ),
			'b' => array( 213, 111, 222, 126 ),
			'c' => array( 247, 111, 254, 126 ),
			'd' => array( 277, 111, 286, 126 ),
			'e' => array( 311, 111, 318, 126 ),
			'f' => array( 343, 111, 350, 126 ),
			'g' => array( 374, 111, 382, 126 ),
			'h' => array( 405, 111, 414, 126 ),
			'i' => array( 442, 111, 446, 126 ),
			'j' => array( 473, 111, 478, 126 ),
			'k' => array( 501, 111, 510, 126 ),
			'l' => array( 535, 111, 542, 126 ),
			'm' => array( 563, 111, 574, 126 ),
			'n' => array( 597, 111, 606, 126 ),
			'o' => array( 628, 111, 638, 126 ),
			'p' => array(  21, 143,  30, 158 ),
			'q' => array(  51, 143,  62, 158 ),
			'r' => array(  84, 143,  94, 158 ),
			's' => array( 119, 143, 126, 158 ),
			't' => array( 150, 143, 158, 158 ),
			'u' => array( 181, 143, 190, 158 ),
			'v' => array( 212, 143, 222, 158 ),
			'w' => array( 240, 143, 254, 158 ),
			'x' => array( 276, 143, 286, 158 ),
			'y' => array( 308, 143, 318, 158 ),
			'z' => array( 342, 143, 350, 158 ),
			
			// Russian characters
			'1072' => array( 405, 303, 414, 318 ),
			'1073' => array( 438, 303, 445, 318 ),
			'1074' => array( 470, 303, 478, 318 ),
			'1075' => array( 502, 303, 509, 318 ),
			'1076' => array( 529, 303, 541, 318 ),
			'1077' => array( 567, 303, 573, 318 ),
			'1078' => array( 593, 303, 606, 318 ),
			'1079' => array( 631, 303, 368, 318 ),
			'1080' => array( 21, 335, 30, 350 ),
			'1081' => array( 53, 335, 62, 350 ),
			'1082' => array( 85, 335, 93, 350 ),
			'1083' => array( 116, 335, 126, 350 ),
			'1084' => array( 147, 335, 158, 350 ),
			'1085' => array( 182, 335, 190, 350 ),
			'1086' => array( 212, 335, 222, 350 ),
			'1087' => array( 246, 335, 254, 350 ),
			'1088' => array( 278, 335, 287, 350 ),
			'1089' => array( 312, 335, 318, 350 ),
			'1090' => array( 342, 335, 350, 350 ),
			'1091' => array( 373, 335, 383, 350 ),
			'1092' => array( 400, 335, 415, 350 ),
			'1093' => array( 437, 335, 446, 350 ),
			'1094' => array( 468, 335, 477, 350 ),
			'1095' => array( 501, 335, 511, 350 ),
			'1096' => array( 529, 335, 542, 350 ),
			'1097' => array( 559, 335, 573, 350 ),
			'1098' => array( 598, 335, 606, 350 ),
			'1099' => array( 624, 335, 638, 350 ),
			'1100' => array( 22, 367, 30, 382 ),
			'1101' => array( 54, 367, 63, 382 ),
			'1102' => array( 80, 367, 94, 382 ),
			'1103' => array( 117, 367, 126, 382 ),
			
			'0' => array( 278,  79, 286,  94 ),
			'1' => array( 312,  79, 318,  94 ),
			'2' => array( 342,  79, 350,  94 ),
			'3' => array( 374,  79, 382,  94 ),
			'4' => array( 405,  79, 414,  94 ),
			'5' => array( 438,  79, 446,  94 ),
			'6' => array( 469,  79, 478,  94 ),
			'7' => array( 502,  79, 510,  94 ),
			'8' => array( 534,  79, 542,  94 ),
			'9' => array( 566,  79, 574,  94 ),

			'.' => array( 219,  79, 222,  94 ),
		);
	}
	elseif( $font == 4 )
	{
		$letters = array(
			'a' => array( 176, 105, 190, 126 ),
			'b' => array( 211, 105, 222, 126 ),
			'c' => array( 245, 105, 254, 126 ),
			'd' => array( 274, 105, 286, 126 ),
			'e' => array( 308, 105, 318, 126 ),
			'f' => array( 340, 105, 350, 126 ),
			'g' => array( 370, 105, 382, 126 ),
			'h' => array( 403, 105, 414, 126 ),
			'i' => array( 442, 105, 446, 126 ),
			'j' => array( 472, 105, 478, 126 ),
			'k' => array( 498, 105, 510, 126 ),
			'l' => array( 534, 105, 542, 126 ),
			'm' => array( 559, 105, 574, 126 ),
			'n' => array( 593, 105, 606, 126 ),
			'o' => array( 624, 105, 638, 126 ),
			'p' => array(  18, 137,  30, 158 ),
			'q' => array(  47, 137,  62, 158 ),
			'r' => array(  81, 137,  94, 158 ),
			's' => array( 115, 137, 126, 158 ),
			't' => array( 148, 137, 158, 158 ),
			'u' => array( 177, 137, 190, 158 ),
			'v' => array( 209, 137, 222, 158 ),
			'w' => array( 234, 137, 254, 158 ),
			'x' => array( 273, 137, 286, 158 ),
			'y' => array( 306, 137, 318, 158 ),
			'z' => array( 339, 137, 350, 158 ),
			
			//Russian characters
			'1072' => array( 400, 297, 414, 318 ),
			'1073' => array( 433, 297, 445, 318 ),
			'1074' => array( 465, 297, 478, 318 ),
			'1075' => array( 497, 297, 509, 318 ),
			'1076' => array( 524, 297, 541, 318 ),
			'1077' => array( 562, 297, 573, 318 ),
			'1078' => array( 588, 297, 606, 318 ),
			'1079' => array( 626, 297, 368, 318 ),
			'1080' => array( 16, 329, 30, 350 ),
			'1081' => array( 48, 329, 62, 350 ),
			'1082' => array( 80, 329, 93, 350 ),
			'1083' => array( 111, 329, 126, 350 ),
			'1084' => array( 142, 329, 158, 350 ),
			'1085' => array( 177, 329, 190, 350 ),
			'1086' => array( 207, 329, 222, 350 ),
			'1087' => array( 241, 329, 254, 350 ),
			'1088' => array( 273, 329, 287, 350 ),
			'1089' => array( 307, 329, 318, 350 ),
			'1090' => array( 337, 329, 350, 350 ),
			'1091' => array( 368, 329, 383, 350 ),
			'1092' => array( 395, 329, 415, 350 ),
			'1093' => array( 432, 329, 446, 350 ),
			'1094' => array( 463, 329, 477, 350 ),
			'1095' => array( 496, 329, 511, 350 ),
			'1096' => array( 524, 329, 542, 350 ),
			'1097' => array( 554, 329, 573, 350 ),
			'1098' => array( 593, 329, 606, 350 ),
			'1099' => array( 619, 329, 638, 350 ),
			'1100' => array( 17, 361, 30, 382 ),
			'1101' => array( 49, 361, 63, 382 ),
			'1102' => array( 75, 361, 94, 382 ),
			'1103' => array( 112, 361, 126, 382 ),

			'!' => array( 441,  41, 446,  62 ),
			'"' => array( 470,  41, 478,  62 ),	
		);
	}
	else
	{
		user_error( "gd_ftext: wrong font ($font)"  );
		exit;
	};


	$atext = preg_split( '//', strtolower($text), -1, PREG_SPLIT_NO_EMPTY );

	$result_x=0;
	$result_y=0;
	
	foreach( $atext as $letter )
	{
		if( $letter == ' ' )
		{
			$result_x += $sp2;
		}
		else
		{
			if( !array_key_exists( $letter, $letters ))
			{
				user_error( "gd_ftext: wrong letter ($letter), font $font, letters:" . count($letters) );
				exit;
			}
			$result_x += (($letters[$letter][2]-$letters[$letter][0])+1);
			$y = ($letters[$letter][3]-$letters[$letter][1])+1;
			if( $y > $result_y )
				$result_y = $y;
		};
	};
	$result_x += (strlen($text)-1)*$sp1;

	$timage = imagecreate( $result_x, $result_y );
	$fimage = gd_imagecreate( $dirs['graphic'] . sprintf( $gd['*ffont*'], $font ));

	$x=-$sp1;
	foreach( $atext as $letter )
	{
		if( $letter == ' ' )
		{
			$x += $sp2;
		}
		else
		{
			$x+= $sp1;
			imagecopy( $timage, $fimage, $x, 0,
				$letters[$letter][0], $letters[$letter][1],
				($letters[$letter][2]-$letters[$letter][0])+1,
				($letters[$letter][3]-$letters[$letter][1])+1 );
			$x += (($letters[$letter][2]-$letters[$letter][0])+1);
		}
	};
	imagedestroy( $fimage );

	return( $timage );
}

function gd_setinfo( $image, $id, $name, $gender, $age )
{
	global $gd, $dirs;

	if( $id == 0 )
	{
		user_error( "gd_setinfo: id = 0" );
		exit;
	};

	$fname = sprintf( $gd['*charname*'], $id );
	if( !file_exists( $dirs['dna'] . $fname ))
	{
		$iname = gd_ftext( 3, 2, 5, $name );
		imagealphablending($iname, false);
		imagesavealpha($iname, true);
		imagepng( $iname, $dirs['dna'] . $fname );
		imagedestroy( $iname );
	};
	$iname = gd_imagecreate( $dirs['dna'] . $fname );
	imagecopy( $image, $iname,
		//$gd['name_x_start']+((($gd['name_x_end']-$gd['name_x_start'])-imagesx($iname))/2),
		gd_getcenter( $gd['name_x_start'], $gd['name_x_end'], imagesx($iname) ),
		$gd['name_y'], 0, 0, imagesx($iname), imagesy($iname) );
	imagedestroy( $iname );

	////////

	switch( $gender )
	{
		case 0:		$gender = "male"; break;
		case 1:		$gender = "female"; break;
		default:	$gender = "it"; break;
	};
	$fgender = sprintf( $gd['*chargender*'], $gender );
	if( !file_exists( $dirs['dna'] . $fgender ))
	{
		$igender = gd_ftext( 3, 2, 5, strtolower($gender) );
		imagepng( $igender, $dirs['dna'] . $fgender );
		imagedestroy( $igender );
	};
	$igender = gd_imagecreate( $dirs['dna'] . $fgender );
	imagecopy( $image, $igender,
		//$gd['gender_x_start']+((($gd['gender_x_end']-$gd['gender_x_start'])-imagesx($igender))/2),
		gd_getcenter( $gd['gender_x_start'], $gd['gender_x_end'], imagesx($igender) ),
		$gd['gender_y'], 0, 0, imagesx($igender), imagesy($igender) );
	imagedestroy( $igender );

	$fage = sprintf( $gd['*charage*'], $age );
	if( !file_exists( $dirs['dna'] . $fage ))
	{
		$iage = gd_ftext( 3, 2, 5, strtolower($age) );
		imagepng( $iage, $dirs['dna'] . $fage );
		imagedestroy( $iage );
	};
	$iage = gd_imagecreate( $dirs['dna'] . $fage );
	imagecopy( $image, $iage,
		//$gd['age_x_start']+((($gd['age_x_end']-$gd['age_x_start'])-imagesx($iage))/2),
		gd_getcenter( $gd['age_x_start'], $gd['age_x_end'], imagesx($iage) ),
		$gd['age_y'], 0, 0, imagesx($iage), imagesy($iage) );
	imagedestroy( $iage );
}

function gd_setspecial( $image, $c_special )
{
	global $gd, $lang_special_short, $lang_special_rating;

	$id=0;
	$y_descr = $gd['special_y_descr'];
	foreach( $c_special as $special )
	{
		$special = CLAMP( $special, $gd['special_Lclamp'], $gd['special_Hclamp'] );
		if( $special < 10 )
		{
			gd_addbignum( $image, $gd['special_x'], $y_descr-$gd['special_y_fix'], 0 );
			gd_addbignum( $image, $gd['special_x']+$gd['special_x_fix'], $y_descr-$gd['special_y_fix'], $special );
		}
		else
		{
			gd_addbignum( $image, $gd['special_x'], $y_descr-$gd['special_y_fix'], substr( $special, 0, 1 ));
			gd_addbignum( $image, $gd['special_x']+$gd['special_x_fix'], $y_descr-$gd['special_y_fix'], substr( $special, 1, 1 ));
		};
		gd_addtext( $image, $gd['special_x_descr'], $y_descr, 'green', $lang_special_rating[$special <= 10 ? $special-1 : 9] );
		$y_descr += $gd['special_y_descr_jump'];
		$id++;
	};
	$sp = gd_imagecreate( $gd['_special_'] );
	imagecopy( $image, $sp, 17, 36, 0, 0, 32, 223 );
	imagedestroy( $sp );
};

function gd_setxp( $image, $c_xp )
{
	global $gd, $lang_xp;

	$id = 0;
	$y = $gd['xp_y'];
	foreach( $c_xp as $xp )
	{
		if( $xp == "0" )
			$xp = '';
		$xp = preg_replace( "/%d$/", CLAMP( $xp, $gd['xp_Lclamp'], $gd['xp_Hclamp'] ), $lang_xp[$id] );
		gd_addtext( $image, $gd['xp_x'], $y, 'green', $xp );
		$y += $gd['xp_y_jump'];
		$id++;
	};

	return( $image );
};

function gd_setlife( $image, $c_life )
{
	global $gd, $lang_life;

	$id = -1;
	$y = $gd['life_y'] - $gd['life_y_jump'];
	foreach( $c_life as $life )
	{
		if( $id == -1 )
			{}
		else if( $id == 0 )
			gd_addtext( $image, $gd['life_x'], $y, 'green', sprintf( "%s %d/%d", $lang_life[$id],
				CLAMP( $c_life[0], $gd['life_Lclamp_hp'], $gd['life_Hclamp_hp'] ),
				CLAMP( $c_life[1], $gd['life_Lclamp_hp'], $gd['life_Hclamp_hp'] )));
		else
			gd_addtext( $image, $gd['life_x'], $y, $life ? 'green' : 'disabled', $lang_life[$id] );
		$y += $gd['life_y_jump'];
		$id++;
	};

};

function gd_setstats( $image, $c_stats )
{
	global $gd, $lang_stats;

	$id = 0;
	$y = $gd['stats_y'];
	foreach( $c_stats as $stat )
	{
		$plum = '';
		if( $id == 2 )
			$stat = intval($stat/1000);
		// else if... don't!

		if( ($id >= 4 && $id <= 6) || ($id == 9 ))
		{
			$plum = '%';
			$stat = CLAMP( $stat, $gd['stats_Lclamp_percent'], $gd['stats_Hclamp_percent'] );
		}
		else
			$stat = CLAMP( $stat, $gd['stats_Lclamp_normal'], $gd['stats_Hclamp_normal'] );
		gd_addtext( $image, $gd['stats_x_name'], $y, 'green', $lang_stats[$id] );
		gd_addtext( $image, $gd['stats_x_value'], $y, 'green', "$stat$plum" );
		$y += $gd['stats_y_jump'];
		$id++;
	};
};

function gd_setskills( $image, $c_skills )
{
	global $gd, $lang_skills;

	$id = 0;
	$y = $gd['skills_y'];
	foreach( $c_skills as $skill )
	{
		$tag = 0;
		$skill = preg_replace( "/'/", '', $skill );
		if( substr($skill,0,1) == '+' )
		{
			$skill = substr($skill,1,strlen($skill)-1);
			$tag = 1;
		};
		gd_addtext( $image, $gd['skills_x_name'],  $y, $tag ? 'tag' : 'green', $lang_skills[$id] );
		gd_addtext( $image, $gd['skills_x_value'], $y, $tag ? 'tag' : 'green', sprintf( "%d%%",
			CLAMP( $skill, $gd['skills_Lclamp'], $gd['skills_Hclamp'] )));
		$y += $gd['skills_y_jump'];
		$id++;
		if( $id == 18 )
			break;
	};

	$sk = gd_imagecreate( $gd['_skills_'] );
	imagecopy( $image, $sk, 368, 4, 0, 0, 54, 18 );
	imagedestroy( $sk );
	
	$x1 = 524; $x2 = 538; $y = 229;
	$c_skills[$id] = CLAMP( $c_skills[$id], 0, 99 );
	if( $c_skills[$id] < 10 )
	{
		gd_addbignum( $image, $x1, $y, 0 );
		gd_addbignum( $image, $x2, $y, $c_skills[$id] );
	}
	else
	{
		gd_addbignum( $image, $x1, $y, substr( $c_skills[$id], 0, 1 ));
		gd_addbignum( $image, $x2, $y, substr( $c_skills[$id], 1, 1 ));
	};

	$sk = gd_imagecreate( $gd['_skill_points_'] );
	imagecopy( $image, $sk, 374, 234, 0, 0, 110, 18 );
	imagedestroy( $sk );
};

?>