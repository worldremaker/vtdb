<?php

header('Content-Type: text/html; charset=UTF-8');

include_once( 'setup.php' );

// check if setup array have all keys
// deprecated in v2
function check_setup($setup,$version)
{
	if( $version == 1 )
	{
		$checklist = array( 'special', 'xp', 'life', 'stats', 'skills', 'perks', 'karma', 'kills', 'position' );

		$id = -1;
		foreach( $checklist as $check )
		{
			if( !array_key_exists( $check, $setup ))
				return( $id );
			$id--;
		};

		return( 1 );
	};
};

function char_load_get( $char, $key, $regexp, $file, $explode = 0 )
{
	$match = 0; preg_match( $regexp, $file, $match );
	if( isset($match[1]) )
	{
		if( $explode )
		{
			$akey = explode( $explode, $match[1] );
			if( count($akey) > 0 )
				$char[$key] = $akey;
			else
				$char[$key] = $match[1];
		}
		else
			$char[$key] = $match[1];

		return( $char );
	}
	return( $char );
}

// load character into array
function char_load( $vtdb_dir, $id )
{
	$file = 0;
	$char = array();

	if( !is_dir( $vtdb_dir ))
	{
		user_error( "char_load[DB,$id]: !isdir" );
		exit;
	}

	if( file_exists( "$vtdb_dir/$id.vtdb" ))
	{
		if( !is_readable( "$vtdb_dir/$id.vtdb" ))
		{
			user_error( "char_load[DB,$id]: can't read (v2+)" );
			exit;
		};

		$file = file_get_contents( "$vtdb_dir/$id.vtdb" );
		$file = mb_convert_encoding($file, 'HTML-ENTITIES', "UTF-8");
		$match = 0; preg_match( '/@version = ([0-9]+);/', $file, $match );
		if( !$match[1] || empty($match[1]) )
		{
			user_error( "char_load[DB,$id]: invalid version (probably 2+)" );
			exit;
		}
		elseif( !ctype_digit( $match[1] ) || $match[1] <= 0 )
		{
			user_error( "char_load[DB,$id]: invalid version: ".$match[1] );
			exit;
		}

		$char['id'] = $id;
		$char['filename'] = "$id.vtdb";
		$char['version'] = $match[1];
	}
	elseif( file_exists( "$vtdb_dir/$id.php" )) // version 1
	{
		if( !is_readable( "$vtdb_dir/$id.php" ))
		{
			user_error( "char_load[DB,$id]: can't read (v1)" );
			exit;
		};

		$file = file_get_contents( "$vtdb_dir/$id.php" );
		$match = 0; preg_match( '/char_version = ([0-9]+);/', $file, $match );
		if( !$match[1] || empty($match[1]) )
		{
			user_error( "char_load[DB,$id]: invalid version (probably 1)" );
			exit;
		}
		elseif( !ctype_digit( $match[1] ) || $match[1] <= 0 )
		{
			user_error( "char_load[DB,$id]: invalid version: ".$match[1] );
			exit;
		}
		$char['id'] = $id;
		$char['filename'] = "$id.php";
		$char['version'] = $match[1];
	}
	else
	{
		user_error( "char_load[$vtdb_dir,$id]: nothing to load" );
		exit;
	};

	$stat = stat( "$vtdb_dir/".$char['filename'] );
	$char['mtime'] = $stat['mtime'];

	// load base keys first; if something is missing - scream
	if( $char['version'] == 1 )
	{
		$char = char_load_get( $char, 'name', '/(*UTF8)\$char_name = "(.*)";/', $file );
		$char = char_load_get( $char, 'gender', '/\$char_gender = ([\-0-9]+);/', $file ); // support GM tricks
		$char = char_load_get( $char, 'age', '/\$char_age = ([\-0-9]+);/', $file ); // support GM tricks
	}
	elseif( $char['version'] >= 2 )
	{
		$char = char_load_get( $char, 'name', '/@name = (.*);/', $file );
		$char = char_load_get( $char, 'gender', '/@gender = ([\-0-9]+);/', $file ); // support GM tricks
		$char = char_load_get( $char, 'age', '/@age = ([\-0-9]+);/', $file ); // support GM tricks
	};

	if( !isset($char['name']) || !isset($char['gender']) || !isset($char['age']) )
	{
		user_error( "char_load[DB,$id]: missing basic info, savefile corrupted?" );
		exit;
	}
	
	// load additional keys
	if( $char['version'] == 1 )
	{
		// v1 should display only parts defined in $char_setup; deal with that.
		$match = 0; preg_match( '/\$char_setup = array\( special => ([01]), xp => ([01]), life => ([01]), stats => ([01]), skills => ([01])/', $file, $match );
		if( !$match[0] )
		{
			user_error( "char_load[DB,$id,v1]: no setup" );
			exit;
		};
		array_shift( $match );

		if( $match[0] )
			$char = char_load_get( $char, 'special', '/\$char_special = array\( ([0-9\,\ ]+) \);/', $file, ', ' );

		if( $match[1] )
			$char = char_load_get( $char, 'xp', '/\$char_xp = array\( ([\-0-9\,\ ]+) \);/', $file, ', ' );

		if( $match[2] )
			$char = char_load_get( $char, 'life', '/\$char_life = array\( ([\-0-9\,\ ]+) \);/', $file, ', ' );

		if( $match[3] )
			$char = char_load_get( $char, 'stats', '/\$char_stats = array\( ([\-0-9\,\ ]+) \);/', $file, ', ' );

		if( $match[4] )
		{
			$char = char_load_get( $char, 'skills', '/\$char_skills = array\( ([\+\-0-9\'\,\ ]+) \);/', $file, ', ' );
			if( array_key_exists( 'skills', $char ))
			{
				$sk=0;
				foreach( $char['skills'] as $skill )
				{
					$skill = preg_replace( '/\'/', '', $skill );
					$char['skills'][$sk] = $skill;
					$sk++;
				}
			}
		}
	}
	else
	{
		if( $char['version'] >=2 )
		{
			$char = char_load_get( $char, 'special',		'/@special = ([\-0-9\ ]+);/', 		$file, ' ' );
			$char = char_load_get( $char, 'xp',			'/@xp = ([\-0-9\ ]+);/',			$file, ' ' );
			$char = char_load_get( $char, 'life',			'/@life = ([\-0-9\ ]+);/',			$file, ' ' );
			$char = char_load_get( $char, 'stats',			'/@stats = ([\-0-9\ ]+);/',			$file, ' ' );
			$char = char_load_get( $char, 'skills',		'/@skills = ([\+\-0-9\ ]+);/',		$file, ' ' );
			$char = char_load_get( $char, 'traits',		'/@traits = ([0-9\ ]+);/',			$file, ' ' );
			$char = char_load_get( $char, 'perks',			'/@perks = ([0-9\:\ ]+);/',			$file, ' ' );
			$char = char_load_get( $char, 'proffesions',	'/@proffesions = ([0-9\:\ ]+);/',	$file, ' ' );
			$char = char_load_get( $char, 'karma',			'/@karma = ([\-0-9\:\ ]+);/',		$file, ' ' );
			$char = char_load_get( $char, 'addictions',	'/@addictions = ([0-9\:\ ]+);/',	$file, ' ' );
			$char = char_load_get( $char, 'reputation',	'/@reputation = ([\-0-9\:\ ]+);/',	$file, ' ' );
			$char = char_load_get( $char, 'kills',			'/@kills = ([0-9\:\ ]+);/',			$file, ' ' );
			$char = char_load_get( $char, 'position', 		'/@position = ([0-9\ ]+);/',		$file, ' ' );
		}
	}

	// check keys length
	foreach( array( 'special:7','xp:3', 'life:9', 'stats:10', 'skills:19', 'position:2' ) as $key )
	{
		$key = explode( ':', $key );
		if( array_key_exists( $key[0], $char ))
		{
			if( !is_array( $char[$key[0]] ))
			{
				user_error( "char_load[DB,$id]: bad key (".$key[0].'): not an array' );
				exit;
			}
			elseif( count( $char[$key[0]] ) != $key[1] )
			{
				user_error( "char_load[DB,$id]: key (".$key[0].'): len '.count( $char[$key[0]] ).' != '.$key[1] );
				exit;
			}
		}
	}

	return( $char );
}

?>