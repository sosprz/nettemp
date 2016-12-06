<?php
$date = date("Y-m-d H:i:s"); 

if(empty($ROOT)){
    $ROOT=dirname(dirname(dirname(__FILE__)));
}

$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");

$db->exec("INSERT OR IGNORE INTO users (login, password, perms ) VALUES ('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'adm')");
$db->exec("INSERT OR IGNORE INTO device (usb, onewire, serial, i2c, lmsensors, wireless ) VALUES ('off','off','off','off','off','off')");
$db->exec("INSERT OR IGNORE INTO settings (mail, sms, rrd, fw, vpn, gpio, authmod, temp_scale) VALUES ('off','off', 'off', 'off', 'off', 'on', 'on', 'C')");

$db->exec("ALTER TABLE settings ADD vpn type TEXT");
$db->exec("CREATE TABLE IF NOT EXISTS vpn (id INTEGER PRIMARY KEY,users UNIQUE)");
$db->exec("ALTER TABLE settings ADD fw type TEXT");
$db->exec("CREATE TABLE fw (id INTEGER PRIMARY KEY,ssh TEXT,icmp TEXT,openvpn TEXT,ext TEXT)");
$db->exec("ALTER TABLE fw ADD radius type TEXT");
$db->exec("ALTER TABLE settings ADD kwh type TEXT");
$db->exec("ALTER TABLE settings ADD gpio type TEXT");
$db->exec("ALTER TABLE device ADD lmsensors type TEXT");
$db->exec("ALTER TABLE settings ADD authmod type TEXT");
$db->exec("ALTER TABLE device ADD i2c type TEXT");
$db->exec("ALTER TABLE gpio ADD mode type TEXT");
$db->exec("ALTER TABLE gpio ADD simple type TEXT");
$db->exec("ALTER TABLE gpio ADD rev type TEXT");
$db->exec("ALTER TABLE gpio ADD humid_type type TEXT");
$db->exec("ALTER TABLE gpio ADD kwh_run type TEXT");
$db->exec("ALTER TABLE gpio ADD kwh_divider type TEXT");
$db->exec("ALTER TABLE gpio ADD day_run type TEXT");
$db->exec("ALTER TABLE gpio ADD week_run type TEXT");
$db->exec("ALTER TABLE gpio ADD week_status type TEXT");
$db->exec("ALTER TABLE gpio ADD week_Mon type TEXT");
$db->exec("ALTER TABLE gpio ADD week_Tue type TEXT");
$db->exec("ALTER TABLE gpio ADD week_Wed type TEXT");
$db->exec("ALTER TABLE gpio ADD week_Thu type TEXT");
$db->exec("ALTER TABLE gpio ADD week_Fri type TEXT");
$db->exec("ALTER TABLE gpio ADD week_Sat type TEXT");
$db->exec("ALTER TABLE gpio ADD week_Sun type TEXT");
$db->exec("ALTER TABLE gpio ADD day_zone2s type TEXT");
$db->exec("ALTER TABLE gpio ADD day_zone2e type TEXT");
$db->exec("ALTER TABLE gpio ADD day_zone3s type TEXT");
$db->exec("ALTER TABLE gpio ADD day_zone3e type TEXT");
$db->exec("ALTER TABLE settings ADD tempnum type TEXT");
$db->exec("ALTER TABLE gpio ADD status type TEXT");
$db->exec("ALTER TABLE mail_settings ADD error type TEXT");
$db->exec("ALTER TABLE device ADD wireless type TEXT");
$db->exec("ALTER TABLE sensors ADD ip type TEXT");
$db->exec("ALTER TABLE sensors ADD device type TEXT");
$db->exec("ALTER TABLE sensors ADD lcd type TEXT");
$db->exec("ALTER TABLE sensors ADD method type TEXT");
$db->exec("ALTER TABLE settings ADD lcd4 type TEXT");
$db->exec("ALTER TABLE settings ADD lcd type TEXT");
$db->exec("ALTER TABLE sensors ADD tmp_5ago type TEXT");
$db->exec("ALTER TABLE mail_settings ADD tlscheck type TEXT");
$db->exec("ALTER TABLE mail_settings ADD tls type TEXT");
$db->exec("ALTER TABLE mail_settings ADD auth type TEXT");
$db->exec("CREATE TABLE newdev (id INTEGER PRIMARY KEY,list UNIQUE)");
$db->exec("CREATE TABLE camera (id INTEGER PRIMARY KEY,list UNIQUE)");
$db->exec("ALTER TABLE camera ADD name type TEXT");
$db->exec("ALTER TABLE camera ADD link type TEXT");
$db->exec("CREATE TABLE relays (id INTEGER PRIMARY KEY,list UNIQUE)");
$db->exec("ALTER TABLE relays ADD name type TEXT");
$db->exec("ALTER TABLE relays ADD ip type TEXT");
$db->exec("ALTER TABLE relays ADD delay type TEXT");
$db->exec("ALTER TABLE relays ADD rom type TEXT");
$db->exec("ALTER TABLE relays ADD type type TEXT");
$db->exec("ALTER TABLE hosts ADD rom type TEXT");

$db->exec("ALTER TABLE gpio ADD control type TEXT");
$db->exec("ALTER TABLE gpio ADD control_run type TEXT");
$db->exec("ALTER TABLE gpio ADD trigger_delay type TEXT");
$db->exec("ALTER TABLE settings ADD radius type TEXT");
$db->exec("CREATE TABLE i2c (id INTEGER PRIMARY KEY,name TEXT, addr UNIQUE)");
$db->exec("ALTER TABLE snmp ADD rom type UNIQUE");
$db->exec("ALTER TABLE gpio ADD trigger_con type TEXT");
$db->exec("ALTER TABLE meteo ADD COLUMN onoff TEXT");
$db->exec("ALTER TABLE gpio ADD tel_any type TEXT");
$db->exec("ALTER TABLE gpio ADD tel_at type TEXT");
$db->exec("ALTER TABLE users ADD tel type TEXT");
$db->exec("ALTER TABLE users ADD mail type TEXT");
$db->exec("ALTER TABLE users ADD smsa type TEXT");
$db->exec("ALTER TABLE users ADD maila type TEXT");
$db->exec("ALTER TABLE users ADD ctr type TEXT");
$db->exec("ALTER TABLE users ADD simple type TEXT");
$db->exec("ALTER TABLE users ADD trigger type TEXT");
$db->exec("ALTER TABLE users ADD moment type TEXT");
$db->exec("ALTER TABLE users ADD cam type TEXT");
$db->exec("ALTER TABLE users ADD at type TEXT");
$db->exec("ALTER TABLE users ADD smspin type TEXT");
$db->exec("ALTER TABLE users ADD smsts type TEXT");
$db->exec("ALTER TABLE settings ADD call type TEXT");
$db->exec("ALTER TABLE sensors ADD adj type TEXT");
$db->exec("ALTER TABLE day_plan ADD gpio type TEXT");
$db->exec("ALTER TABLE sensors ADD charts type TEXT");
$db->exec("ALTER TABLE settings ADD charts_system type TEXT");
$db->exec("ALTER TABLE settings ADD charts_hosts type TEXT");
$db->exec("ALTER TABLE settings ADD charts_gpio type TEXT");
$db->exec("ALTER TABLE settings ADD charts_min type TEXT");
$db->exec("ALTER TABLE settings ADD charts_theme type TEXT");

$db->exec("ALTER TABLE settings ADD server_key type TEXT");
$db->exec("ALTER TABLE settings ADD client_key type TEXT");
$db->exec("ALTER TABLE settings ADD client_ip type TEXT");
$db->exec("ALTER TABLE settings ADD client_on type TEXT");
$db->exec("ALTER TABLE settings ADD cauth_on type TEXT");
$db->exec("ALTER TABLE settings ADD cauth_login type TEXT");
$db->exec("ALTER TABLE settings ADD cauth_pass type TEXT");


$db->exec("ALTER TABLE sensors ADD remote type TEXT");
$db->exec("ALTER TABLE sensors ADD i2c type TEXT");

$db->exec("CREATE TABLE call_settings (id INTEGER PRIMARY KEY, name TEXT, dev TEXT, default_dev TEXT)");
$db->exec("CREATE TABLE access_time (id INTEGER PRIMARY KEY, name UNIQUE, Mon TEXT, Tue TEXT, Wed TEXT, Thu TEXT, Fri TEXT, Sat TEXT, Sun TEXT, stime TEXT, etime TEXT)");
$db->exec("CREATE TABLE day_plan (id INTEGER PRIMARY KEY, name UNIQUE, Mon TEXT, Tue TEXT, Wed TEXT, Thu TEXT, Fri TEXT, Sat TEXT, Sun TEXT, stime TEXT, etime TEXT)");
$db->exec("CREATE TABLE meteo (id INTEGER PRIMARY KEY, temp TEXT, latitude TEXT, height TEXT, pressure TEXT, humid TEXT, onoff TEXT)");

$db->exec("UPDATE mail_settings SET tlscheck='off' WHERE id='1' AND tlscheck is null");
$db->exec("UPDATE settings SET charts_system='on' WHERE charts_system is null");
$db->exec("UPDATE settings SET charts_hosts='on' WHERE charts_hosts is null");
$db->exec("UPDATE settings SET charts_gpio='on' WHERE charts_gpio is null");
$db->exec("UPDATE settings SET charts_min='10' WHERE charts_gpio is null");

$db->exec("UPDATE sensors SET charts='on' WHERE charts is null");
$db->exec("UPDATE sensors SET adj='0' WHERE adj='' OR adj=' ' OR adj is null");
$db->exec("UPDATE users SET perms='adm' WHERE login='admin' AND perms is null");
$db->exec("UPDATE OR IGNORE settings SET tempnum='3' where id='1' AND tempnum is null");
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$key=generateRandomString();
$db->exec("UPDATE OR IGNORE settings SET server_key='$key' where id='1' AND server_key is null");

$db->exec("INSERT OR IGNORE INTO mail_settings (id,tlscheck) VALUES (1,'off')");
$db->exec("INSERT OR IGNORE INTO mail_settings (id,tls) VALUES (1,'on')");
$db->exec("INSERT OR IGNORE INTO mail_settings (id,auth) VALUES (1,'on')");
$db->exec("INSERT OR IGNORE INTO access_time (name, Mon, Tue, Wed, Thu, Fri, Sat, Sun, stime, etime) VALUES  ('any', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', '00:00', '23:59')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('bmp180','77')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('tsl2561','39')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('ds2482','18')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('ds2482','1a')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('htu21d','40')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('mpl3115a2','60')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('hih6130','27')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('tmp102','48')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('bh1750','23')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('bme280','76')");
$db->exec("INSERT OR IGNORE INTO fw (id, ssh, icmp, ext, openvpn, radius ) VALUES (1,'off','off', '0.0.0.0/0', 'off', 'off')");
$db->exec("INSERT OR IGNORE INTO meteo (id, temp, latitude, height, pressure, humid, onoff ) VALUES (1,'0','0','0','0','0','off')");
$db->exec("INSERT OR IGNORE INTO settings (id,gpio) VALUES (1,'on')");
$db->exec("INSERT OR IGNORE INTO device (id,lmsensors) VALUES (1,'off')");
$db->exec("INSERT OR IGNORE INTO device (id,i2c) VALUES (1,'off')");
$db->exec("INSERT OR IGNORE INTO device (id,wireless) VALUES (1,'off')");

$db->exec("ALTER TABLE sensors ADD minmax type TEXT");
$db->exec("ALTER TABLE sensors ADD sum type TEXT");
$db->exec("UPDATE sensors SET sum='0' WHERE sum='' OR sum=' ' OR sum is null");

$db->exec("ALTER TABLE newdev ADD type type TEXT");
$db->exec("ALTER TABLE newdev ADD device type TEXT");
$db->exec("ALTER TABLE newdev ADD i2c type TEXT");
$db->exec("ALTER TABLE newdev ADD usb type TEXT");
$db->exec("ALTER TABLE newdev ADD gpio type TEXT");
$db->exec("ALTER TABLE newdev ADD ip type TEXT");
$db->exec("ALTER TABLE settings ADD meteogram type TEXT");
$db->exec("UPDATE settings SET meteogram='Poland/Pomerania/Gdansk' WHERE id='1' AND meteogram is null");
$db->exec("ALTER TABLE gpio ADD elec_divider type TEXT");
$db->exec("ALTER TABLE gpio ADD water_divider type TEXT");
$db->exec("ALTER TABLE gpio ADD gas_divider type TEXT");
$db->exec("ALTER TABLE gpio ADD elec_run type TEXT");
$db->exec("ALTER TABLE gpio ADD water_run type TEXT");
$db->exec("ALTER TABLE gpio ADD gas_run type TEXT");
$db->exec("ALTER TABLE gpio ADD elec_debouncing type TEXT");
$db->exec("ALTER TABLE gpio ADD water_debouncing type TEXT");
$db->exec("ALTER TABLE gpio ADD gas_debouncing type TEXT");
$db->exec("ALTER TABLE gpio ADD fnum type TEXT");


$db->exec("CREATE TABLE usb (id INTEGER PRIMARY KEY, dev TEXT, device UNIQUE)");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('RS485','none')");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('1wire','none')");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('1wire Serial','none')");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('Modem Call','none')");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('Modem SMS','none')");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('UPS Pimowo','none')");
$db->exec("ALTER TABLE gpio ADD state type TEXT");

$db->exec("PRAGMA journal_mode=WAL");

$db->exec("ALTER TABLE sensors ADD map_pos type NUM");
$db->exec("ALTER TABLE sensors ADD map_num type NUM");
$db->exec("ALTER TABLE sensors ADD map type NUM");
$db->exec("UPDATE sensors SET map_num=ABS(300 + RANDOM() % 3600) WHERE map_num is null");
$db->exec("UPDATE sensors SET map_pos='{left:0,top:0}' WHERE map_pos is null");
$db->exec("UPDATE sensors SET map='on' WHERE map is null");

$db->exec("ALTER TABLE gpio ADD map_pos type NUM");
$db->exec("ALTER TABLE gpio ADD map_num type NUM");
$db->exec("ALTER TABLE gpio ADD map type NUM");
$db->exec("UPDATE gpio SET map_num=ABS(300 + RANDOM() % 3600) WHERE map_num is null");
$db->exec("UPDATE gpio SET map_pos='{left:0,top:0}' WHERE map_pos is null");
$db->exec("UPDATE gpio SET map='on' WHERE map is null");

$db->exec("ALTER TABLE hosts ADD map_pos type NUM");
$db->exec("ALTER TABLE hosts ADD map_num type NUM");
$db->exec("ALTER TABLE hosts ADD map type NUM");
$db->exec("UPDATE hosts SET map_num=ABS(300 + RANDOM() % 3600) WHERE map_num is null");
$db->exec("UPDATE hosts SET map_pos='{left:0,top:0}' WHERE map_pos is null");
$db->exec("UPDATE hosts SET map='on' WHERE map is null");

$db->exec("ALTER TABLE sensors ADD COLUMN position INTEGER DEFAULT 1");

$db->exec("ALTER TABLE snmp ADD type type TEXT");
$db->exec("ALTER TABLE settings ADD MCP23017 type TEXT");
$db->exec("ALTER TABLE hosts ADD alarm type TEXT");
$db->exec("ALTER TABLE camera ADD access_all type TEXT");
$db->exec("ALTER TABLE snmp ADD version type TEXT");
$db->exec("UPDATE snmp SET version='2c' WHERE version is null");
$db->exec("ALTER TABLE settings ADD ups_status type TEXT");

$db->exec("ALTER TABLE gpio ADD position type NUM");
$db->exec("UPDATE gpio SET position='1' WHERE position is null");

$db->exec("ALTER TABLE hosts ADD position type NUM");
$db->exec("UPDATE hosts SET position='1' WHERE position is null");

$db->exec("ALTER TABLE sensors ADD ch_group type NUM");

$db->exec("CREATE TABLE statistics (id INTEGER PRIMARY KEY, agreement TEXT, nick TEXT, location TEXT, sensor_temp TEXT)");
$db->exec("INSERT OR IGNORE INTO statistics (agreement) VALUES ('no')");

$db->exec("CREATE TABLE g_func (id INTEGER PRIMARY KEY, position INTEGER DEFAULT 0, sensor TEXT, sensor2 TEXT, onoff TEXT, value TEXT, op TEXT, hyst TEXT, source TEXT, gpio TEXT, w_profile TEXT)");


$db->exec("CREATE TABLE maps (id INTEGER PRIMARY KEY,type TEXT,element_id INTEGER,map_num type NUM, map_pos NUMERIC, position INTEGER DEFAULT 1)");
$db->exec("ALTER TABLE maps ADD map_on type TEXT");
$db->exec("ALTER TABLE maps ADD transparent type TEXT");
$db->exec("ALTER TABLE maps ADD control_on_map type TEXT");
$db->exec("ALTER TABLE maps ADD display_name type TEXT");
$db->exec("ALTER TABLE maps ADD transparent_bkg type TEXT");
$db->exec("ALTER TABLE maps ADD background_color TEXT");
$db->exec("ALTER TABLE maps ADD background_low TEXT");
$db->exec("ALTER TABLE maps ADD background_high TEXT");
$db->exec("ALTER TABLE maps ADD font_color TEXT");
$db->exec("ALTER TABLE maps ADD font_size TEXT");
$db->exec("ALTER TABLE maps ADD icon TEXT");

$db->exec("ALTER TABLE hosts ADD element_id type TEXT");


$db->exec("ALTER TABLE settings ADD temp_scale TEXT");
$db->exec("INSERT OR IGNORE INTO settings (id, temp_scale) VALUES (1, 'C')");
$db->exec("UPDATE settings SET temp_scale='C' WHERE temp_scale is null OR temp_scale=''");

$db->exec("CREATE TABLE highcharts (id INTEGER PRIMARY KEY,charts_min TEXT, charts_theme TEXT, charts_fast TEXT)");
$db->exec("INSERT OR IGNORE INTO highcharts (id, charts_min, charts_theme, charts_fast) VALUES (1, '1', 'black', 'on')");
$db->exec("ALTER TABLE gpio ADD moment_time type TEXT");
$db->exec("CREATE TABLE charts (id INTEGER PRIMARY KEY,charts TEXT)");
$db->exec("INSERT OR IGNORE INTO charts (id, charts) VALUES (1, 'Highcharts')");

$db->exec("CREATE TABLE rs485 (id INTEGER PRIMARY KEY,dev,addr TEXT)");
$db->exec("ALTER TABLE sensors ADD jg TEXT");
$db->exec("ALTER TABLE sensors ADD current TEXT");
$db->exec("ALTER TABLE meteo ADD normalized TEXT");
$db->exec("ALTER TABLE meteo ADD jg TEXT");
$db->exec("CREATE TABLE html (id INTEGER PRIMARY KEY,name UNIQUE,state TEXT,value TEXT)");

$db->exec("INSERT OR IGNORE INTO html (name, state) VALUES ('info', 'on')");
$db->exec("INSERT OR IGNORE INTO html (name, state) VALUES ('footer', 'on')");
$db->exec("INSERT OR IGNORE INTO html (name, state) VALUES ('screen', 'off')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('nettemp_logo', ' media/png/nettemp.pl.png')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('nettemp_link', 'http://nettemp.pl')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('nettemp_alt', 'nettemp')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('charts_max', 'day')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('map_width', '800')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('map_height', '600')");

$db->exec("CREATE TABLE minmax (id INTEGER PRIMARY KEY,name UNIQUE,state TEXT,value TEXT)");
$db->exec("INSERT OR IGNORE INTO minmax (name, state) VALUES ('mode', '1')");
$db->exec("CREATE TABLE types (id INTEGER PRIMARY KEY,type UNIQUE, unit TEXT, unit2 TEXT, ico TEXT, title TEXT, min NUMERIC, max NUMERIC, value1 NUMERIC, value2 NUMERIC, value3 NUMERIC");

$db->exec("ALTER TABLE types ADD min NUMERIC");
$db->exec("ALTER TABLE types ADD max NUMERIC");
$db->exec("ALTER TABLE types ADD value1 NUMERIC");
$db->exec("ALTER TABLE types ADD value2 NUMERIC");
$db->exec("ALTER TABLE types ADD value3 NUMERIC");

	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max, value1, value2, value3) VALUES ('temp', '°C', '°F', 'media/ico/temp2-icon.png' ,'Temperature','-150', '3000', '85', '185' ,'127.9')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('lux', 'lux', 'lux', 'media/ico/sun-icon.png' ,'Lux','8000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('humid', '%', '%', 'media/ico/rain-icon.png' ,'Humidity','0', '110')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('press', 'hPa', 'hPa', 'media/ico/Science-Pressure-icon.png' ,'Pressure','0','10000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('water', 'm3', 'm3', 'media/ico/water-icon.png' ,'Water','0', '100')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('gas', 'm3', 'm3', 'media/ico/gas-icon.png' ,'Gas','0', '100')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('elec', 'kWh', 'W', 'media/ico/Lamp-icon.png' ,'Electricity','0', '99999999')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('watt', 'W', 'W', 'media/ico/watt.png' ,'Watt','-10000', '10000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('volt', 'V', 'V', 'media/ico/volt.png' ,'Volt','-10000', '10000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('amps', 'A', 'A', 'media/ico/amper.png' ,'Amps','0', '10000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('dist', 'cm', 'cm', 'media/ico/Distance-icon.png' ,'Distance','0', '100000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('trigger', '', '', 'media/ico/alarm-icon.png' ,'Trigger','0', '100000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('rainfall', 'mm/m2', 'mm/m2', 'media/ico/showers.png' ,'Rainfall','0', '10000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('speed', 'km/h', 'km/h', 'media/ico/Wind-Flag-Storm-icon.png' ,'Speed','0', '10000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('wind', '°', '°', 'media/ico/compass.png' ,'Wind','0', '10000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('uv', 'index', 'index', '' ,'UV','0', '10000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('storm', 'km', 'km', 'media/ico/storm-icon.png' ,'Storm','0', '10000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('lightining', '', '', 'media/ico/thunder-icon.png' ,'Lightining','0', '10000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('host', 'ms', 'ms', 'media/ico/Computer-icon.png' ,'Host','0', '10000')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('system', '%', '%', '' ,'System','0', '100')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('gpio', 'H/L', 'H/L', 'media/ico/gpio2.png' ,'GPIO')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('group', '', '', '' ,'')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('relay', '', '', 'media/ico/socket-icon.png' ,'Relay')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('baterry', '%', '', 'media/ico/Battery-icon.png' ,'Baterry','0', '100')");


$db->exec("UPDATE types SET min='-150', max='3000', value1='85', value2='185', value3='127.9' WHERE type='temp' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='110' WHERE type='humid' AND min is null AND max is null");
$db->exec("UPDATE types SET min='-1', max='8000' WHERE type='lux' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='10000' WHERE type='press' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='100' WHERE type='gas' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='100' WHERE type='water' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='99999999' WHERE type='elec' AND min is null AND max is null");
$db->exec("UPDATE types SET min='-10000', max='10000' WHERE type='watt' AND min is null AND max is null");
$db->exec("UPDATE types SET min='-10000', max='10000' WHERE type='volt' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='10000' WHERE type='host' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='10000' WHERE type='amps' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='10000' WHERE type='dist' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='10000' WHERE type='trigger' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='10000' WHERE type='rainfall' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='10000' WHERE type='speed' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='10000' WHERE type='wind' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='10000' WHERE type='uv' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='10000' WHERE type='storm' AND min is null AND max is null");
$db->exec("UPDATE types SET min='0', max='10000' WHERE type='lightining' AND min is null AND max is null");
$db->exec("ALTER TABLE sensors ADD mail type TEXT");
$db->exec("ALTER TABLE hosts ADD mail type TEXT");

// TIME & TRIGGER
$db->exec("ALTER TABLE sensors ADD time type TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");
//$db->exec("ALTER TABLE hosts ADD time type TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");
$db->exec("CREATE TRIGGER aupdate_time_trigger AFTER UPDATE ON sensors WHEN NEW.tmp BEGIN UPDATE sensors SET time = (datetime('now','localtime')) WHERE tmp = old.tmp; END;");
//$db->exec("CREATE TRIGGER hosts_time_trigger AFTER UPDATE ON hosts WHEN NEW.last BEGIN UPDATE hosts SET time = (datetime('now','localtime')) WHERE last = old.last; END;");


echo $date." nettemp database update: ok \n";


?>

