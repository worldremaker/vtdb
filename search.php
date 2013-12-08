<?php

include( 'setup.php' );
include( 'r/html.php' );
include( 'r/func.php' );
include( 'r/char.php' );

function do_showchars($my_dir,$sort,$desc,$page,$len)
{
	if( is_dir( $my_dir ))
	{
		if( $dir = opendir($my_dir))
		{
			printf( "<table cellspacing='0' cellpadding='5' class='bordercolor'>
<tbody>
<tr align='center' class='titlebg'>
	<td><a href='?sort=i%s%s'>ID</a></td>
	<td><a href='?sort=n%s%s'>Name</a></td>
	<td><a href='?sort=m%s%s'>Last update</a></td>
</tr>
",
($sort == 'i' && $desc == 0) ? '&amp;desc=1' : '',
($page != 1 )                ? "&amp;page=$page" : '',
($sort == 'n' && $desc == 0) ? '&amp;desc=1' : '',
($page != 1 )                ? "&amp;page=$page" : '',
($sort == 'm' && $desc == 0) ? '&amp;desc=1' : '',
($page != 1 )                ? "&amp;page=$page" : '' );
			$list = array();
			$pages = 1;
			$ch = 0;
			$curr_page = 1;
			while(($file = readdir($dir)) !== false)
			{	
				if( substr( $file, -4 ) == '.php' || // v1
					substr( $file, -5 ) == '.vtdb' ) // v2+
				{
					if( substr( $file, -4 ) == '.php' && ctype_digit( substr( $file, 0, strlen($file)-4 )))
					{
						$id = substr( $file, 0, strlen($file)-4 );
						$stat = stat( "$my_dir/$file" );
						$mtime = $stat['mtime'];
						require_once( "$my_dir/$file" );
						array_push( $list, array( i => $id, n => $char_name, m => $mtime ));
					}
					else if( substr( $file, -5 ) == '.vtdb' && ctype_digit( substr( $file, 0, strlen($file)-5 )))
					{
						$id = substr( $file, 0, strlen($file)-5 );
						$stat = stat( "$my_dir/$file" );
						$char = char_load($my_dir,$id);

						array_push( $list, array( 'i' => $id, 'n' => $char['name'], 'm' => $stat['mtime'] ));
					}
				}
			}
			closedir($dir);
			$tmp = Array();
			foreach( $list as $element )
				$tmp[] = $element[$sort];
			array_multisort($tmp, $desc ? SORT_DESC : SORT_ASC, $list );
			$bg = 1;
			$count = 0;
			foreach( $list as $luser )
			{
				$id = $luser['i'];
				$version = $luser['v'];
				$name = $luser['n'];
				$mtime = date( DATE_RFC850, $luser['m'] );
				if( $version == 1 )
					$setup = implode( ', ', array_keys( $luser['s'], 1 ));
				elseif( $version == 2 )	
					$setup = preg_replace( '/\ /', ', ', $luser['s'] );
				printf( "<tr align='center' valign='middle'>
	<td class='windowbg'>$id</td>
	<td class='windowbg2'><a href='char.php?$id' title='$name'>$name</a></td>
	<td class='windowbg'>$mtime</td>
</tr>\n" );
			};
			if( $len > 0 )
			{
				echo( "<tr align='center' class='titlebg'>\n\t<td colspan='2'>" );
				for( $p = 1; $p < $pages; $p++ )
				{
					printf( "%s[", $p == 1 ? '' : ' ' );
					if( $p != $page )
					{
						printf( "<a class='navPages' href='?%s%s%s'>%d</a>",
							$sort != 'i' ? "&amp;sort=$sort" : '',
							$desc != 0   ? '&amp;desc=1' : '',
							$page != $p  ? "&amp;page=$p" : '',
							$p
						);
					}
					else
						echo( "<b>$p</b>" );
					echo( "]" );
				}
				echo( "</td></tr>\n" );
			}
			echo( "</tbody>
</table>
" );
		}
	}
}

content_type( 'text/html' );
doctype( 'strict' );
html();
html_head( ' ', 'noindex,nofollow,noarchive', 0 );
html_head_link( $dirs['css'] . 'vtdb.css' );
html_head_end();
body(0);

echo( "<div class='top'>\n" );
string2font(1,"Vault-Tec DB\n" );
string2font(3,"Search" );
echo( "</div>\n" );

echo( "<div class='main' style='text-align: center;'>\n" );

$sort = $_GET['sort'];
if( !$sort || ($sort != 'i' && $sort != 'm' && $sort != 'n' && $sort != 's' && $sort != 'v' ))
	$sort = 'i';

$desc = $_GET['desc'];
if( $desc ) $desc = 1; else $desc = 0;

$page = $_GET['page'];
if( !$page || !ctype_digit($page) )
	$page = 1;

$limit = $_GET['limit'];
if( !$limit || !ctype_digit($limit) )
	$limit = 2;

do_showchars($dirs['db'],$sort,$desc,$page,$limit);

echo( "</div>\n" );


gen_menu();
gen_submenu( 'characters' );

body_end();
html_end();

?>
