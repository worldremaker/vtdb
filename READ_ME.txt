0.3 update 1:
- russian nicknames support (initial state)

Changes in files:

vtdb-master\changelog.php
vtdb-master\char.php
vtdb-master\setup.php

vtdb-master\r\char.php
vtdb-master\r\func.php
vtdb-master\r\gd.php

To get the proper russian character letters:
1. Make new font with russian character letters for font1.gif, font2.gif and font3.gif files.
2. Edit the vtdb-master\r\vtdb.css file and set new coordinates for letters in freshly created fonts.
3. Comment the lines in vtdb-master\char.php with following code:
$char['name'] = RUStoEU($char['name']);
4. Just run it.

