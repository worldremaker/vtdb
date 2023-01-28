<?php

include( 'setup.php' );

include( $dirs['include'] . 'html.php' );
include( $dirs['include'] . 'func.php' );

content_type( 'text/html' );
doctype( 'strict' );
html();
html_head( 'Vault-Tec DB (RC1): About', 0, 0);
html_head_link( $dirs['css'] . 'vtdb.css' );
html_head_end();
body(0);

echo( "<div class='top'>\n" );
string2font( 1, "Vault-Tec DB\n" );
string2font( 3, "About\n" );
echo( "</div>\n" );

echo( "<div class='main'>\n" );

echo( "<span class='font_green'>
This Vault-Tec DataBase shows current stats of player's characters. Now it's underconstruction. Stay tuned.
</span>
</div>\n" );

gen_menu();
gen_submenu('about');

body_end();
html_end();

//<a href='http://www.dafont.com/due-date.font?classt=alpha&amp;l[]=10&amp;l[]=1'>Due Date</a>,
//<a href='http://www.dafont.com/top-secret-kb.font?l[]=10&amp;l[]=1'>Top Secret</a>

?>