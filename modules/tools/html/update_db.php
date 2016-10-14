<pre>
<?php
echo "nettemp database update: \n";
$root=$_SERVER["DOCUMENT_ROOT"];
if(empty($root)){
    $root='/var/www/nettemp';
}
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");

$db->exec("ALTER TABLE settings ADD vpn type TEXT");
$db->exec("CREATE TABLE vpn (id INTEGER PRIMARY KEY,users UNIQUE)");
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

//for i in $(seq 1 30);
//    do
//    $db->exec("ALTER TABLE gpio ADD tout$i type TEXT");
//done

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
$db->exec("UPDATE OR IGNORE settings SET server_key='$(date +%s | sha256sum | base64 | head -c 10 ; echo)' where id='1' AND server_key is null");

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

$db->exec("CREATE TRIGGER aupdate_time_trigger AFTER UPDATE ON sensors WHEN NEW.tmp BEGIN UPDATE sensors SET time = (datetime('now','localtime')) WHERE tmp = old.tmp; END;");

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

$db->exec("ALTER TABLE sensors ADD time type TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

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
$db->exec("CREATE TABLE types (id INTEGER PRIMARY KEY,type UNIQUE, unit TEXT, unit2 TEXT, ico TEXT, title TEXT)");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('temp', '°C', '°F', 'media/ico/temp2-icon.png' ,'Temperature')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('heaterst', '°C', '°F', 'media/ico/heaters-icon.png' ,'Heater')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('lux', 'lux', 'lux', 'media/ico/sun-icon.png' ,'Lux')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('humid', '%', '%', 'media/ico/rain-icon.png' ,'Humidity')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('press', 'hPa', 'hPa', 'media/ico/Science-Pressure-icon.png' ,'Pressure')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('water', 'm3', 'm3', 'media/ico/water-icon.png' ,'Water')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('gas', 'm3', 'm3', 'media/ico/gas-icon.png' ,'Gas')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('elec', 'kWh', 'W', 'media/ico/Lamp-icon.png' ,'Electricity')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('watt', 'W', 'W', 'media/ico/watt.png' ,'Watt')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('volt', 'V', 'V', 'media/ico/volt.png' ,'Volt')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('amps', 'A', 'A', 'media/ico/amper.png' ,'Amps')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('dist', 'cm', 'cm', 'media/ico/Distance-icon.png' ,'Distance')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('trigger', '', '', 'media/ico/alarm-icon.png' ,'Trigger')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('rainfall', 'mm/m2', 'mm/m2', '' ,'Rainfall')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('speed', 'km/h', 'km/h', '' ,'Speed')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('wind', '°', '°', '' ,'Wind')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('uv', 'index', 'index', '' ,'UV')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('storm', 'km', 'km', '' ,'Storm')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('lightining', '', '', '' ,'Lightining')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('hosts', 'ms', 'ms', '' ,'Host')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('system', '%', '%', '' ,'System')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('gpio', 'H/L', 'H/L', '' ,'GPIO')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('group', '', '', '' ,'')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('relay', '', '', '' ,'')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('baterry', '', '', '' ,'Baterry')");

$db->exec("CREATE TABLE heaters (id INTEGER PRIMARY KEY,temp_actual type TEXT,temp_set type TEXT,work_mode type TEXT,position INTEGER DEFAULT 1, ip type TEXT, name type TEXT, status type TEXT, rom type TEXT, type type TEXT)");



echo "ok";

?>
</pre>
