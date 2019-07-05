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
$updates['2018-02-27 11:11:20'][]="DROP trigger IF EXISTS aupdate_time_trigger";
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

$updates['2018-03-26 12:33:28'][]="ALTER TABLE ownwidget ADD hide TEXT";
$updates['2018-03-26 12:33:38'][]="UPDATE ownwidget SET hide='off'";

$updates['2018-03-29 09:52:37'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('hide_ups','off')";

$updates['2018-03-29 14:08:42'][]="ALTER TABLE rs485 ADD baudrate TEXT";
$updates['2018-03-29 15:00:37'][]="UPDATE rs485 SET baudrate='9600'";

$updates['2018-04-03 14:08:42'][]="ALTER TABLE camera ADD hide TEXT";
$updates['2018-04-03 15:00:37'][]="UPDATE camera SET hide='off'";

$updates['2018-04-03 16:09:35'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('ups_backl_time','15')";

$updates['2018-04-04 12:31:28'][]="ALTER TABLE ownwidget ADD edithide TEXT";
$updates['2018-04-04 12:31:38'][]="UPDATE ownwidget SET edithide='off'";

$updates['2018-04-24 10:10:04'][]="INSERT INTO virtual  ('name', 'rom', 'type', 'device', 'description') VALUES ('Max24', 'max24', 'max24', 'virtual','Max value - 24H')";
$updates['2018-04-24 10:11:04'][]="INSERT INTO virtual  ('name', 'rom', 'type', 'device', 'description') VALUES ('MaxWeek', 'maxweek', 'maxweek', 'virtual','Max value - week')";
$updates['2018-04-24 10:12:04'][]="INSERT INTO virtual  ('name', 'rom', 'type', 'device', 'description') VALUES ('MaxMonth', 'maxmonth', 'maxmonth', 'virtual','Max value - month')";

$updates['2018-04-24 10:13:23'][]="INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('max24', '', '', 'media/ico/max-icon.png' ,'Max 24','0', '10000')";
$updates['2018-04-24 10:14:23'][]="INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('maxweek', '', '', 'media/ico/max-icon.png' ,'Max Week','0', '10000')";
$updates['2018-04-24 10:15:23'][]="INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('maxmonth', '', '', 'media/ico/max-icon.png' ,'Max Month','0', '10000')";

$updates['2018-04-24 10:16:46'][]="ALTER TABLE sensors ADD bindsensor TEXT";

$updates['2018-07-20 13:45:58'][]="ALTER TABLE sensors ADD hide TEXT";
$updates['2018-07-20 13:46:11'][]="UPDATE sensors SET hide='off'";

$updates['2018-07-25 10:10:04'][]="INSERT INTO virtual  ('name', 'rom', 'type', 'device', 'description') VALUES ('Sunrise', 'sunrise', 'sunrise', 'virtual','Time of sunrise for a given location')";
$updates['2018-07-25 10:12:08'][]="INSERT INTO virtual  ('name', 'rom', 'type', 'device', 'description') VALUES ('Sunset', 'sunset', 'sunset', 'virtual','Time of sunset for a given location')";

$updates['2018-07-25 10:50:23'][]="INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('sunrise', '', '', 'media/ico/sunrise-icon.png' ,'Sunrise','0', '1000000000000')";
$updates['2018-07-25 10:51:23'][]="INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('sunset', '', '', 'media/ico/sunset-icon.png' ,'Sunset','0', '1000000000000')";
$updates['2018-07-25 12:45:46'][]="ALTER TABLE sensors ADD timezone TEXT";

$updates['2018-08-17 13:04:13'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('client_port','80')";
$updates['2018-09-06 09:40:31'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('mapon','on')";

$updates['2018-09-06 10:10:05'][]="INSERT INTO virtual  ('name', 'rom', 'type', 'device', 'description') VALUES ('Min24', 'min24', 'min24', 'virtual','Min value - 24H')";
$updates['2018-09-06 10:11:06'][]="INSERT INTO virtual  ('name', 'rom', 'type', 'device', 'description') VALUES ('MinWeek', 'minweek', 'minweek', 'virtual','Min value - week')";
$updates['2018-09-06 10:12:07'][]="INSERT INTO virtual  ('name', 'rom', 'type', 'device', 'description') VALUES ('MinMonth', 'minmonth', 'minmonth', 'virtual','Min value - month')";

$updates['2018-09-06 10:13:24'][]="INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('min24', '', '', 'media/ico/min-icon.png' ,'Min 24','-10000', '10000')";
$updates['2018-09-06 10:14:25'][]="INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('minweek', '', '', 'media/ico/min-icon.png' ,'Min Week','-10000', '10000')";
$updates['2018-09-06 10:15:26'][]="INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('minmonth', '', '', 'media/ico/min-icon.png' ,'Min Month','-10000', '10000')";

$updates['2018-09-11 13:04:14'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('pusho_active','off')";
$updates['2018-09-11 13:04:15'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('pusho_user_key','')";
$updates['2018-09-11 13:04:16'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('pusho_api_key','')";

$updates['2018-09-21 10:01:46'][]="ALTER TABLE sensors ADD domoticz TEXT";
$updates['2018-09-21 13:46:11'][]="UPDATE sensors SET domoticz='off'";
$updates['2018-09-21 14:05:46'][]="ALTER TABLE sensors ADD domoticzidx TEXT";



$updates['2018-09-24 11:40:31'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('lat','')";
$updates['2018-09-24 11:41:31'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('long','')";

$updates['2018-09-24 12:41:31'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('domoip','')";
$updates['2018-09-24 12:41:31'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('domoport','')";
$updates['2018-09-25 08:06:31'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('domoon','')";

$updates['2018-10-05 08:06:21'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('domoauth','off')";
$updates['2018-10-05 08:06:22'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('domolog','')";
$updates['2018-10-05 08:06:25'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('domopass','')";

$updates['2018-10-12 10:29:48'][]="CREATE TABLE notifications (id INTEGER PRIMARY KEY, rom TEXT , type TEXT, wheen TEXT, value TEXT, sms TEXT, mail TEXT, pov TEXT, message TEXT, priority TEXT, interval TEXT, recovery TEXT, active TEXT, sent TEXT)";

$updates['2018-12-20 13:39:47'][]="CREATE TABLE logs (id INTEGER PRIMARY KEY, date TEXT , type TEXT, message TEXT)";
$updates['2018-12-26 08:06:22'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('logs','')";
$updates['2018-12-26 08:06:25'][]="INSERT INTO nt_settings ('option', 'value') VALUES ('logshis','1')";

$updates['2019-01-07 10:01:46'][]="ALTER TABLE sensors ADD cost1 TEXT";
$updates['2019-01-07 10:01:49'][]="ALTER TABLE sensors ADD cost2 TEXT";
$updates['2019-01-07 10:01:50'][]="UPDATE sensors SET cost1=0.0";
$updates['2019-01-07 10:01:52'][]="UPDATE sensors SET cost2=0.0";


//$updates['2019-01-17 10:01:41'][]="ALTER TABLE sensors ADD t1start TEXT";
//$updates['2019-01-07 10:01:42'][]="ALTER TABLE sensors ADD t1stop TEXT";
//$updates['2019-01-17 10:01:46'][]="ALTER TABLE sensors ADD t2start TEXT";
//$updates['2019-01-17 10:01:49'][]="ALTER TABLE sensors ADD t2stop TEXT";

//Update sensors alarm reads errors
$updates['2019-01-24 11:40:18'][]="ALTER TABLE sensors ADD readerrtime TEXT";
$updates['2019-01-24 11:40:19'][]="UPDATE sensors SET readerrtime='60'";

//Update - modules order in status
$updates['2019-05-07 11:40:01'][]="CREATE TABLE statusorder (id INTEGER PRIMARY KEY, position INTEGER , modulename TEXT)";
$updates['2019-05-07 11:41:01'][]="INSERT INTO statusorder ('position', 'modulename') VALUES (1,'Sensors')";
$updates['2019-05-07 11:42:01'][]="INSERT INTO statusorder ('position', 'modulename') VALUES (2,'MinMax')";
$updates['2019-05-07 11:43:01'][]="INSERT INTO statusorder ('position', 'modulename') VALUES (3,'Counters')";
$updates['2019-05-07 11:44:01'][]="INSERT INTO statusorder ('position', 'modulename') VALUES (4,'Controls/GPIO')";
$updates['2019-05-07 11:45:01'][]="INSERT INTO statusorder ('position', 'modulename') VALUES (5,'Meteo')";
$updates['2019-05-07 11:46:01'][]="INSERT INTO statusorder ('position', 'modulename') VALUES (6,'IP Cam')";
$updates['2019-05-07 11:47:01'][]="INSERT INTO statusorder ('position', 'modulename') VALUES (7,'UPS')";
$updates['2019-05-07 11:48:01'][]="INSERT INTO statusorder ('position', 'modulename') VALUES (8,'Widget')";

//trigger update
$updates['2019-07-05 10:01:41'][]="ALTER TABLE gpio ADD trigout TEXT";
$updates['2019-07-05 10:02:31'][]="ALTER TABLE gpio ADD trigsource TEXT";




//$updates['2019-04-29 13:01:41'][]="ALTER TABLE gpio ADD token TEXT";
?>
