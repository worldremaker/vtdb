<?php

// CLAMP()
//
function CLAMP($that,$low,$high) // from FOServ
{
	return( ((($that)>($high))?($high):((($that)<($low))?($low):($that))) );
};

// font()
//
//
function font($c,$l)
{
//	$p = "<span class='$c ";
//	$s = "'>&nbsp;</span>\n";
	echo( "<span class=\"$c ${c}_$l\">&nbsp;</span>\n" );
};

// string2font()
//
function string2font($font,$text)
{
	if( !$font )
		$font = 1;
	if( !$text )
		return;

	$font = strtolower("font$font");
	$text = strtolower($text);

	$tempArray = preg_split('//', $text, -1, PREG_SPLIT_NO_EMPTY);
	// Look for russian character letters in $tempArray

	if($tempArray[0] == '&' && $tempArray[1] == '#') {
		$tempCount = 0;
		while($tempCount < count($tempArray)) {
			// When there's "space"
			if($tempArray[$tempCount] == ' ') {
				$array[] = ' ';
				$tempCount++;
			} else {
				$array[] = $tempArray[$tempCount + 2].$tempArray[$tempCount + 3].$tempArray[$tempCount + 4].$tempArray[$tempCount + 5];
				$tempCount = $tempCount + 7;
			}
		}
	} else {
		$array = preg_split('//', $text, -1, PREG_SPLIT_NO_EMPTY); # :/
	}
	foreach( $array	 as $letter )
	{
/*		if( $letter == ' ' )
			{ echo( '&nbsp;&nbsp;' ); }
		elseif( $letter == "\n" )
			{ echo( "<br />\n" ); }
		elseif( $letter == "\t" )
			{ echo( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ); }
		elseif( ctype_alnum( $letter ))
			{ echo( "$p${font}_$letter$s" ); }
		elseif( $letter == '!' )
			{ echo( "$p${font}_em$s" ); }
		elseif( $letter == '?' )
			{ echo( "$p${font}_qm$s" ); }
		elseif( $letter == '#' )
			{ echo( "$p${font}_hash$s" ); }
		else {};
*/
		switch( $letter )
		{
			case "\n":
				echo( "<br />\n" ); break;
			case "\t":
				echo( "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" ); break;

			case ' ':
				echo( "&nbsp;&nbsp;\n" ); break;
			// special (3rd line)
			case '`':
				font( $font, 'sp1' ); break;
			case '-':
				font( $font, 'sp2' ); break;				
			case '=':
				font( $font, 'sp3' ); break;
			case '\\':
				font( $font, 'sp4' ); break;
			case '[':
				font( $font, 'sp5' ); break;
			case ']':
				font( $font, 'sp6' ); break;
			case ';':
				font( $font, 'sp7' ); break;
			case '\'':
				font( $font, 'sp8' ); break;
			case ',':
				font( $font, 'sp9' ); break;
			case '.':
				font( $font, 'sp10' ); break;
			case '/':
				font( $font, 'sp11' ); break;
			case '~':
				font( $font, 'sp12' ); break;
			case '!':
				font( $font, 'sp13' ); break;
			case '@':
				font( $font, 'sp14' ); break;
			case '#':
				font( $font, 'sp15' ); break;
			case '$':
				font( $font, 'sp16' ); break;
			case '%':
				font( $font, 'sp17' ); break;
			case '^':
				font( $font, 'sp18' ); break;
			case '&':
				font( $font, 'sp19' ); break;
			case '*':
				font( $font, 'sp20' ); break;
			case '(':
				font( $font, 'sp21' ); break;
			case ')':
				font( $font, 'sp22' ); break;
			case '_':
				font( $font, 'sp23' ); break;
			case '+':
				font( $font, 'sp24' ); break;
			case '|':
				font( $font, 'sp25' ); break;
			case '{':
				font( $font, 'sp26' ); break;
			case '}':
				font( $font, 'sp27' ); break;
			case ':':
				font( $font, 'sp28' ); break;
			case '"':
				font( $font, 'sp29' ); break;
			case '<':
				font( $font, 'sp30' ); break;
			case '>':
				font( $font, 'sp31' ); break;
			case '?':
				font( $font, 'sp32' ); break;
			// alphanumeric (1rd/2nd line)
			default:
				if(strlen($letter) == 4){ // Russian2European generator
					//font( $font, $letter );
					if($letter == '1072'){
						for($i=0; $i<1; $i++) {
							font( $font, 'a' );
						}
					}
					if($letter == '1073'){
						for($i=0; $i<1; $i++) {
							font( $font, 'b' );
						}
					}
					if($letter == '1074'){
						for($i=0; $i<1; $i++) {
							font( $font, 'v' );
						}
					}
					if($letter == '1075'){
						for($i=0; $i<1; $i++) {
							font( $font, 'g' );
						}
					}
					if($letter == '1076'){
						for($i=0; $i<1; $i++) {
							font( $font, 'd' );
						}
					}
					if($letter == '1077'){
						for($i=0; $i<1; $i++) {
							font( $font, 'y' );
							font( $font, 'e' );
						}
					}
					if($letter == '1078'){
						for($i=0; $i<1; $i++) {
							font( $font, 'z' );
							font( $font, 'h' );
						}
					}
					if($letter == '1079'){
						for($i=0; $i<1; $i++) {
							font( $font, 'z' );
						}
					}
					if($letter == '1080'){
						for($i=0; $i<1; $i++) {
							font( $font, 'i' );
						}
					}
					if($letter == '1081'){
						for($i=0; $i<1; $i++) {
							font( $font, 'y' );
						}
					}
					if($letter == '1082'){
						for($i=0; $i<1; $i++) {
							font( $font, 'k' );
						}
					}
					if($letter == '1083'){
						for($i=0; $i<1; $i++) {
							font( $font, 'l' );
						}
					}
					if($letter == '1084'){
						for($i=0; $i<1; $i++) {
							font( $font, 'm' );
						}
					}
					if($letter == '1085'){
						for($i=0; $i<1; $i++) {
							font( $font, 'n' );
						}
					}
					if($letter == '1086'){
						for($i=0; $i<1; $i++) {
							font( $font, 'o' );
						}
					}
					if($letter == '1087'){
						for($i=0; $i<1; $i++) {
							font( $font, 'p' );
						}
					}
					if($letter == '1088'){
						for($i=0; $i<1; $i++) {
							font( $font, 'r' );
						}
					}
					if($letter == '1089'){
						for($i=0; $i<1; $i++) {
							font( $font, 's' );
						}
					}
					if($letter == '1090'){
						for($i=0; $i<1; $i++) {
							font( $font, 't' );
						}
					}
					if($letter == '1091'){
						for($i=0; $i<1; $i++) {
							font( $font, 'u' );
						}
					}
					if($letter == '1092'){
						for($i=0; $i<1; $i++) {
							font( $font, 'f' );
						}
					}
					if($letter == '1093'){
						for($i=0; $i<1; $i++) {
							font( $font, 'k' );
							font( $font, 'h' );
						}
					}
					if($letter == '1094'){
						for($i=0; $i<1; $i++) {
							font( $font, 't' );
							font( $font, 's' );
						}
					}
					if($letter == '1095'){
						for($i=0; $i<1; $i++) {
							font( $font, 'c' );
							font( $font, 'h' );
						}
					}
					if($letter == '1096'){
						for($i=0; $i<1; $i++) {
							font( $font, 's' );
							font( $font, 'h' );
						}
					}
					if($letter == '1097'){
						for($i=0; $i<1; $i++) {
							font( $font, 's' );
							font( $font, 'h' );
							font( $font, 'c' );
							font( $font, 'h' );
						}
					}
					if($letter == '1098'){
						for($i=0; $i<1; $i++) {
							font( $font, 'sp29' );
						}
					}
					if($letter == '1099'){
						for($i=0; $i<1; $i++) {
							font( $font, 'y' );
						}
					}
					if($letter == '1100'){
						for($i=0; $i<1; $i++) {
							font( $font, 'sp4' );
						}
					}
					if($letter == '1101'){
						for($i=0; $i<1; $i++) {
							font( $font, 'e' );
						}
					}
					if($letter == '1102'){
						for($i=0; $i<1; $i++) {
							font( $font, 'y' );
							font( $font, 'u' );
						}
					}
					if($letter == '1103'){
						for($i=0; $i<1; $i++) {
							font( $font, 'y' );
							font( $font, 'a' );
						}
					}
				}elseif( ctype_alnum( $letter )){ // alphanumeric
					font( $font, $letter );
				}
				break;
		};
	};
};

?>