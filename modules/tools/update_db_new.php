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
$updates['2018-01-20 11:00:00'][]="ALTER TABLE day_plan ADD active  TEXT";
$updates['2018-01-20 12:00:00'][]="ALTER TABLE day_plan ADD rom  TEXT";

//g_func DB changes
$updates['2018-01-26 11:00:00'][]="ALTER TABLE g_func ADD active  TEXT";
$updates['2018-01-26 12:00:00'][]="ALTER TABLE g_func ADD rom TEXT";

//sensors DB changes - max min for JG
$updates['2018-01-29 13:00:00'][]="ALTER TABLE sensors ADD jg_min  TEXT";
$updates['2018-01-29 13:00:00'][]="ALTER TABLE sensors ADD jg_max  TEXT";

//ownwidget updates
$updates['2018-01-31 19:28:01'][]="CREATE TABLE ownwidget (id INTEGER PRIMARY KEY, name TEXT NOT NULL, body TEXT NOT NULL, onoff TEXT, iflogon TEXT)";

//sensors table update logon
$updates['2018-02-01 19:30:52'][]="ALTER TABLE sensors ADD logon TEXT";
$updates['2018-02-01 19:47:50'][]="UPDATE sensors SET logon='on'";

//sensors table update thingspeak
$updates['2018-02-05 13:32:38'][]="ALTER TABLE sensors ADD thing  TEXT";
//Create table for thingspeak
$updates['2018-02-05 13:47:42'][]="CREATE TABLE thingspeak (id INTEGER PRIMARY KEY, name TEXT , apikey TEXT , f1 TEXT, f2 TEXT, f3 TEXT, f4 TEXT, f5 TEXT, f6 TEXT, f7 TEXT, f8 TEXT, active TEXT, interval INTEGER)";
//Update sensors alarm reads errors
$updates['2018-02-08 19:40:08'][]="ALTER TABLE sensors ADD readerr TEXT";
$updates['2018-02-08 19:40:08'][]="ALTER TABLE sensors ADD readerralarm TEXT";
$updates['2018-02-08 19:48:25'][]="UPDATE sensors SET readerralarm='off'";
$updates['2018-02-08 19:49:20'][]="UPDATE sensors SET readerr='60'";
//Update nt_settings UPS NT
$updates['2018-02-12 13:04:09'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_deleay_on','60')";
$updates['2018-02-12 13:04:09'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_deleay_off','60')";
$updates['2018-02-12 13:04:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_akku_charge_start','3.9')";
$updates['2018-02-12 13:04:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_akku_charge_stop','4.1')";
$updates['2018-02-12 13:04:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_akku_discharged','3.3')";
$updates['2018-02-12 13:04:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_lcd_scroll','2')";
$updates['2018-02-12 13:04:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_lcd_backlight','yes')";

?>
