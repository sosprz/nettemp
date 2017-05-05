<?php
/*

Proper way of use:
1)
$updates['xxxx-xx-xx yy:yy:yy'][]="FIRST Line";
$updates['xxxx-xx-xx yy:yy:yy'][]="SECOND Line";
...
$updates['xxxx-xx-xx yy:yy:yy'][]="LAST Line";

2)
$query="FIRST line\nSECOND line\n...\nLAST line";
$updates['xxxx-xx-xx yy:yy:yy']=explode("\n",$query);

*/


//Newdev proper fix
$updates['2017-05-04 20:00:00'][]="DROP TABLE IF EXISTS newdev";
$updates['2017-05-04 20:00:00'][]="CREATE TABLE IF NOT EXISTS newdev (id INTEGER PRIMARY KEY,list UNIQUE, rom UNIQUE)";
$updates['2017-05-04 20:00:00'][]="ALTER TABLE newdev ADD device  TEXT";
$updates['2017-05-04 20:00:00'][]="ALTER TABLE newdev ADD gpio  TEXT";
$updates['2017-05-04 20:00:00'][]="ALTER TABLE newdev ADD i2c  TEXT";
$updates['2017-05-04 20:00:00'][]="ALTER TABLE newdev ADD ip  TEXT";
$updates['2017-05-04 20:00:00'][]="ALTER TABLE newdev ADD name  TEXT";
$updates['2017-05-04 20:00:00'][]="ALTER TABLE newdev ADD type TEXT";
$updates['2017-05-04 20:00:00'][]="ALTER TABLE newdev ADD usb  TEXT";
$updates['2017-05-04 20:00:00'][]="ALTER TABLE newdev ADD seen  TEXT";

?>
