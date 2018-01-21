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

//MultiLCD DB changes
$updates['2017-05-10 19:25:15'][]="CREATE TABLE lcds (id INTEGER PRIMARY KEY, name TEXT NOT NULL, addr TEXT NOT NULL UNIQUE, rows TINYINT NOT NULL DEFAULT 2, cols TINYINT NOT NULL DEFAULT 16, clock TEXT DEFAULT '', avg TEXT DEFAULT '', active TEXT DEFAULT 'on', grp TEXT DEFAULT NULL, loop TEXT DEFAULT '')";
$updates['2017-05-10 19:25:15'][]="CREATE TABLE lcd_group_assign (rom TEXT NOT NULL, grpkey TEXT NOT NULL)";
$updates['2017-05-10 19:25:15'][]="CREATE TABLE lcd_groups (id INTEGER PRIMARY KEY, name TEXT UNIQUE, active TEXT DEFAULT 'on', charts TEXT DEFAULT '', grpkey TEXT UNIQUE DEFAULT (lower(hex(randomblob(4)))) NOT NULL)";
$updates['2017-05-10 19:25:15'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('lcdmode','off')";

//DayPlan DB changes
$updates['2018-01-21 12:00:00'][]="ALTER TABLE day_plan ADD active  TEXT";

?>
