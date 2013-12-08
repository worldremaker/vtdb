<?php

// CLAMP()
//
function CLAMP($this,$low,$high) // from FOServ
{
	return( ((($this)>($high))?($high):((($this)<($low))?($low):($this))) );
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
	
	$array = preg_split('//', $text, -1, PREG_SPLIT_NO_EMPTY); # :/
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
				if( ctype_alnum( $letter ))
					font( $font, $letter );
				break;
		};
	};
};

?>