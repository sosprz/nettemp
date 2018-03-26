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
$updates['2018-02-12 13:04:11'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_delay_on','60')";
$updates['2018-02-12 13:04:11'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_delay_off','60')";
$updates['2018-02-12 13:04:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_akku_discharged','3.3')";
$updates['2018-02-12 13:04:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_lcd_scroll','2')";
$updates['2018-02-12 13:04:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_lcd_backlight','yes')";
$updates['2018-02-15 09:55:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_time_off','15')";
$updates['2018-02-16 09:55:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_akku_temp','45')";
$updates['2018-02-16 09:57:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_toff_start','')";
$updates['2018-02-16 09:58:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_count','0')";
$updates['2018-02-16 09:59:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_toff_stop','')";

//Update USB for PiUSB
$updates['2018-02-15 12:00:03'][]="UPDATE usb SET device='PiUPS' where device='UPS Pimowo'";

//Update sensors for triggers
$updates['2018-02-19 14:36:25'][]="ALTER TABLE sensors ADD trigzero  TEXT";
$updates['2018-02-19 14:36:25'][]="ALTER TABLE sensors ADD trigone  TEXT";
$updates['2018-02-19 14:38:00'][]="UPDATE sensors SET trigzero='0.0' WHERE type='trigger'";
$updates['2018-02-19 14:38:00'][]="UPDATE sensors SET trigone='1.0' WHERE type='trigger'";
$updates['2018-02-19 18:54:12'][]="ALTER TABLE sensors ADD trigzeroclr  TEXT";
$updates['2018-02-19 18:54:12'][]="ALTER TABLE sensors ADD trigoneclr  TEXT";
$updates['2018-02-20 14:38:00'][]="UPDATE sensors SET trigzeroclr='label-success' WHERE type='trigger'";
$updates['2018-02-20 14:38:00'][]="UPDATE sensors SET trigoneclr='label-danger' WHERE type='trigger'";

//Update sensors for triggers
$updates['2018-02-27 11:11:20'][]="drop trigger aupdate_time_trigger";
$updates['2018-02-27 11:12:49'][]="CREATE TRIGGER aupdate_time_trigger AFTER UPDATE OF tmp ON sensors FOR EACH ROW BEGIN UPDATE sensors SET time = (datetime('now','localtime')) WHERE id = old.id; END";
//Update ow refresh
$updates['2018-03-01 11:11:11'][]="UPDATE ownwidget SET name = REPLACE(name,' ','_')";
$updates['2018-03-05 09:29:00'][]="ALTER TABLE ownwidget ADD refresh TEXT";
$updates['2018-03-05 09:29:00'][]="UPDATE ownwidget SET refresh='off'";
//Virtual Sensors
$updates['2018-03-09 10:29:46'][]="CREATE TABLE virtual (id INTEGER PRIMARY KEY, name TEXT , rom TEXT, type TEXT, device TEXT, lati TEXT, long TEXT, active TEXT, description TEXT)";
$updates['2018-03-09 10:40:04'][]="INSERT INTO virtual  ('name', 'rom', 'type', 'device', 'description') VALUES ('Air_quality', 'Airly', 'airquality', 'virtual','For api settings please visit https://airly.eu/pl/')";
$updates['2018-03-09 10:40:04'][]="INSERT INTO virtual  ('name', 'rom', 'type', 'device', 'description') VALUES ('Air_quality_PM2.5', 'Airly25', 'air_pm_25', 'virtual','For api settings please visit https://airly.eu/pl/')";
$updates['2018-03-09 10:40:04'][]="INSERT INTO virtual  ('name', 'rom', 'type', 'device', 'description') VALUES ('Air_quality_PM10', 'Airly10', 'air_pm_10', 'virtual','For api settings please visit https://airly.eu/pl/')";
$updates['2018-03-09 11:00:50'][]="ALTER TABLE sensors ADD latitude  TEXT";
$updates['2018-03-09 11:00:50'][]="ALTER TABLE sensors ADD longitude  TEXT";
$updates['2018-03-09 12:00:50'][]="ALTER TABLE sensors ADD apikey  TEXT";
$updates['2018-03-09 14:50:23'][]="INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('airquality', 'CAQI', 'CAQI', 'media/ico/airly.png' ,'Air Quality','0', '100')";
$updates['2018-03-09 14:50:23'][]="INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('air_pm_25', 'μg/m3', 'μg/m3', 'media/ico/airly.png' ,'PM 2.5','0', '1000')";
$updates['2018-03-09 14:50:23'][]="INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('air_pm_10', 'μg/m3', 'μg/m3', 'media/ico/airly.png' ,'PM 10','0', '1000')";
// SMS, MAIL, SCRIPT - sensors - Trigger
$updates['2018-03-15 08:48:41'][]="ALTER TABLE sensors ADD ssms  TEXT";
$updates['2018-03-15 08:48:41'][]="ALTER TABLE sensors ADD smail  TEXT";
$updates['2018-03-15 08:48:41'][]="ALTER TABLE sensors ADD script  TEXT";
$updates['2018-03-15 15:49:42'][]="ALTER TABLE sensors ADD script1  TEXT";
$updates['2018-03-15 09:17:10'][]="UPDATE sensors SET ssms='off'";
$updates['2018-03-15 09:17:10'][]="UPDATE sensors SET smail='off'";

$updates['2018-03-19 12:42:40'][]="ALTER TABLE sensors ADD readerrsend TEXT";
$updates['2018-03-21 13:05:08'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_language','1')";

$updates['2018-03-22 10:01:46'][]="ALTER TABLE sensors ADD ghide TEXT";
$updates['2018-03-22 10:17:11'][]="UPDATE sensors SET ghide='off'";

$updates['2018-03-26 08:52:27'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('hide_gpio','off')";
$updates['2018-03-26 08:52:30'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('hide_minmax','off')";
$updates['2018-03-26 08:52:35'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('hide_counters','off')";
?>
