VTDB
====

Unfinished server database, only character viewer is (more or less) working. No changes was made compared to version running on fonline2238.net except for some links/paths.
See fo2238 [extensions/online_stats](https://github.com/rotators/fo2238/blob/master/Server/extensions/online_stats/online_stats.cpp) for .vtdb format info.
Inspired by one of old WoW Armory versions.

WARNING: horrible code quality.

db/ - characters
d/  - generated images (characters name/age/gender, backgrounds)
g/  - static images
i/  - tools
r/  - everything else (css, js, fonts)

ar.php    - used to generate image shown after [silly attempt](https://github.com/rotators/fo2238/blob/master/Server/scripts/client_messages.fos#L313) attemt to guess ~getaccess password
char.php  - character viewer
index.php - main page
setup.php - minimalistic configuration

In case of server wipe, d/ and db/ should be cleaned manually.

