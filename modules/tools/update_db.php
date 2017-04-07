<?php
// http://php.net/manual/en/pdo.transactions.php

$date = date("Y-m-d H:i:s"); 

if(empty($ROOT)){
    $ROOT=dirname(dirname(dirname(__FILE__)));
}

//WAL
$dbu = new PDO("sqlite:$ROOT/dbf/nettemp.db");
$dbu->exec("PRAGMA journal_mode=DELETE");
$dbu->exec("PRAGMA page_size=4096");
$dbu->exec("VACUUM");
$dbu->exec("PRAGMA journal_mode=WAL");
$dbu=null;

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {

$db->beginTransaction();

/* Change the database schema and data */

//CLEAN
$db->exec("DELETE FROM settings WHERE id>1");
$db->exec("DROP TRIGGER IF EXISTS hosts_time_trigger");
$db->exec("DROP TRIGGER IF EXISTS aupdate_time_trigger");
$db->exec("DROP INDEX IF EXISTS unique_name");


//CREATE
$db->exec("CREATE TABLE IF NOT EXISTS access_time (id INTEGER PRIMARY KEY, name UNIQUE, Mon TEXT, Tue TEXT, Wed TEXT, Thu TEXT, Fri TEXT, Sat TEXT, Sun TEXT, stime TEXT, etime TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS call_settings (id INTEGER PRIMARY KEY, name TEXT, dev TEXT, default_dev TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS camera (id INTEGER PRIMARY KEY,list UNIQUE)");
$db->exec("CREATE TABLE IF NOT EXISTS charts (id INTEGER PRIMARY KEY,charts TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS day_plan (id INTEGER PRIMARY KEY, name UNIQUE, Mon TEXT, Tue TEXT, Wed TEXT, Thu TEXT, Fri TEXT, Sat TEXT, Sun TEXT, stime TEXT, etime TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS fw (id INTEGER PRIMARY KEY,ssh TEXT,icmp TEXT,openvpn TEXT,ext TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS g_func (id INTEGER PRIMARY KEY, position INTEGER DEFAULT 0, sensor TEXT, sensor2 TEXT, onoff TEXT, value TEXT, op TEXT, hyst TEXT, source TEXT, gpio TEXT, w_profile TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS highcharts (id INTEGER PRIMARY KEY,charts_min TEXT, charts_theme TEXT, charts_fast TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS html (id INTEGER PRIMARY KEY,name UNIQUE,state TEXT,value TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS i2c (id INTEGER PRIMARY KEY,name TEXT, addr UNIQUE)");
$db->exec("CREATE TABLE IF NOT EXISTS maps (id INTEGER PRIMARY KEY,type TEXT,element_id INTEGER,map_num NUMERIC, map_pos NUMERIC, position INTEGER DEFAULT 1)");
$db->exec("CREATE TABLE IF NOT EXISTS meteo (id INTEGER PRIMARY KEY, temp TEXT, latitude TEXT, height TEXT, pressure TEXT, humid TEXT, onoff TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS minmax (id INTEGER PRIMARY KEY,name UNIQUE,state TEXT,value TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS newdev (id INTEGER PRIMARY KEY,list UNIQUE)");
$db->exec("CREATE TABLE IF NOT EXISTS relays (id INTEGER PRIMARY KEY,list UNIQUE)");
$db->exec("CREATE TABLE IF NOT EXISTS rs485 (id INTEGER PRIMARY KEY,dev,addr TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS types (id INTEGER PRIMARY KEY,type UNIQUE, unit TEXT, unit2 TEXT, ico TEXT, title TEXT, min NUMERIC, max NUMERIC, value1 NUMERIC, value2 NUMERIC, value3 NUMERIC)");
$db->exec("CREATE TABLE IF NOT EXISTS usb (id INTEGER PRIMARY KEY, dev TEXT, device UNIQUE)");
$db->exec("CREATE TABLE IF NOT EXISTS vpn (id INTEGER PRIMARY KEY,users UNIQUE)");
$db->exec("CREATE TABLE IF NOT EXISTS auth_tokens (id INTEGER PRIMARY KEY, selector TEXT, token TEXT, userid TEXT, expires TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS adjust (id INTEGER PRIMARY KEY, rom TEXT, threshold NUMERIC, end NUMERIC, addvalue NUMERIC)");

$db->commit();
$db=null;
} catch (Exception $e) {
	/* Recognize mistake and roll back changes */
	$db->rollBack();
    echo $date." Error.\n";
    echo $e;
    exit;
}


$dba = new PDO("sqlite:$ROOT/dbf/nettemp.db");
$dba->beginTransaction();

$dba->exec("ALTER TABLE camera ADD COLUMN access_all TEXT");
$dba->exec("ALTER TABLE camera ADD link TEXT");
$dba->exec("ALTER TABLE camera ADD name TEXT");
$dba->exec("ALTER TABLE day_plan ADD gpio TEXT");
$dba->exec("ALTER TABLE device ADD i2c TEXT");
$dba->exec("ALTER TABLE device ADD lmsensors TEXT");
$dba->exec("ALTER TABLE device ADD wireless TEXT");
$dba->exec("ALTER TABLE fw ADD radius TEXT");

$dba->exec("ALTER TABLE gpio ADD control TEXT");
$dba->exec("ALTER TABLE gpio ADD control_run TEXT");
$dba->exec("ALTER TABLE gpio ADD day_run TEXT");
$dba->exec("ALTER TABLE gpio ADD day_zone2e TEXT");
$dba->exec("ALTER TABLE gpio ADD day_zone2s TEXT");
$dba->exec("ALTER TABLE gpio ADD day_zone3e TEXT");
$dba->exec("ALTER TABLE gpio ADD day_zone3s TEXT");
$dba->exec("ALTER TABLE gpio ADD elec_debouncing TEXT");
$dba->exec("ALTER TABLE gpio ADD elec_divider TEXT");
$dba->exec("ALTER TABLE gpio ADD elec_run TEXT");
$dba->exec("ALTER TABLE gpio ADD fnum TEXT");
$dba->exec("ALTER TABLE gpio ADD gas_debouncing TEXT");
$dba->exec("ALTER TABLE gpio ADD gas_divider TEXT");
$dba->exec("ALTER TABLE gpio ADD gas_run type TEXT");
$dba->exec("ALTER TABLE gpio ADD humid_type TEXT");
$dba->exec("ALTER TABLE gpio ADD ip TEXT");
$dba->exec("ALTER TABLE gpio ADD kwh_divider TEXT");
$dba->exec("ALTER TABLE gpio ADD kwh_run TEXT");
$dba->exec("ALTER TABLE gpio ADD map NUM");
$dba->exec("ALTER TABLE gpio ADD map_num NUMERIC");
$dba->exec("ALTER TABLE gpio ADD map_pos NUMERIC");
$dba->exec("ALTER TABLE gpio ADD mode TEXT");
$dba->exec("ALTER TABLE gpio ADD moment_time TEXT");
$dba->exec("ALTER TABLE gpio ADD position NUM");
$dba->exec("ALTER TABLE gpio ADD rev TEXT");
$dba->exec("ALTER TABLE gpio ADD rom TEXT");
$dba->exec("ALTER TABLE gpio ADD simple TEXT");
$dba->exec("ALTER TABLE gpio ADD state type TEXT");
$dba->exec("ALTER TABLE gpio ADD status  TEXT");
$dba->exec("ALTER TABLE gpio ADD tel_any  TEXT");
$dba->exec("ALTER TABLE gpio ADD tel_at  TEXT");
$dba->exec("ALTER TABLE gpio ADD trigger_con  TEXT");
$dba->exec("ALTER TABLE gpio ADD trigger_delay  TEXT");
$dba->exec("ALTER TABLE gpio ADD water_debouncing  TEXT");
$dba->exec("ALTER TABLE gpio ADD water_divider  TEXT");
$dba->exec("ALTER TABLE gpio ADD water_run  TEXT");
$dba->exec("ALTER TABLE gpio ADD week_Fri  TEXT");
$dba->exec("ALTER TABLE gpio ADD week_Mon  TEXT");
$dba->exec("ALTER TABLE gpio ADD week_run  TEXT");
$dba->exec("ALTER TABLE gpio ADD week_Sat  TEXT");
$dba->exec("ALTER TABLE gpio ADD week_status  TEXT");
$dba->exec("ALTER TABLE gpio ADD week_Sun  TEXT");
$dba->exec("ALTER TABLE gpio ADD week_Thu  TEXT");
$dba->exec("ALTER TABLE gpio ADD week_Tue  TEXT");
$dba->exec("ALTER TABLE gpio ADD week_Wed  TEXT");
$dba->exec("ALTER TABLE gpio ADD locked  TEXT");

$dba->exec("ALTER TABLE hosts ADD alarm  TEXT");
$dba->exec("ALTER TABLE hosts ADD element_id  TEXT");
$dba->exec("ALTER TABLE hosts ADD position  NUM");
$dba->exec("ALTER TABLE hosts ADD rom  TEXT");

$dba->exec("ALTER TABLE maps ADD background_color TEXT");
$dba->exec("ALTER TABLE maps ADD background_high TEXT");
$dba->exec("ALTER TABLE maps ADD background_low TEXT");
$dba->exec("ALTER TABLE maps ADD control_on_map  TEXT");
$dba->exec("ALTER TABLE maps ADD display_name  TEXT");
$dba->exec("ALTER TABLE maps ADD font_color TEXT");
$dba->exec("ALTER TABLE maps ADD font_size TEXT");
$dba->exec("ALTER TABLE maps ADD icon TEXT");
$dba->exec("ALTER TABLE maps ADD map_on  TEXT");
$dba->exec("ALTER TABLE maps ADD transparent  TEXT");
$dba->exec("ALTER TABLE maps ADD transparent_bkg  TEXT");

$dba->exec("ALTER TABLE meteo ADD jg TEXT");
$dba->exec("ALTER TABLE meteo ADD normalized TEXT");

$dba->exec("ALTER TABLE newdev ADD device  TEXT");
$dba->exec("ALTER TABLE newdev ADD gpio  TEXT");
$dba->exec("ALTER TABLE newdev ADD i2c  TEXT");
$dba->exec("ALTER TABLE newdev ADD ip  TEXT");
$dba->exec("ALTER TABLE newdev ADD name  TEXT");
$dba->exec("ALTER TABLE newdev ADD rom  TEXT");
$dba->exec("ALTER TABLE newdev ADD type TEXT");
$dba->exec("ALTER TABLE newdev ADD usb  TEXT");
$dba->exec("ALTER TABLE newdev ADD seen  TEXT");

$dba->exec("ALTER TABLE relays ADD delay TEXT");
$dba->exec("ALTER TABLE relays ADD ip TEXT");
$dba->exec("ALTER TABLE relays ADD name TEXT");
$dba->exec("ALTER TABLE relays ADD rom TEXT");
$dba->exec("ALTER TABLE relays ADD type TEXT");

$dba->exec("ALTER TABLE sensors ADD adj  TEXT");
$dba->exec("ALTER TABLE sensors ADD charts  TEXT");
$dba->exec("ALTER TABLE sensors ADD ch_group  NUM");
$dba->exec("ALTER TABLE sensors ADD current TEXT");
$dba->exec("ALTER TABLE sensors ADD device  TEXT");
$dba->exec("ALTER TABLE sensors ADD i2c  TEXT");
$dba->exec("ALTER TABLE sensors ADD ip  TEXT");
$dba->exec("ALTER TABLE sensors ADD jg TEXT");
$dba->exec("ALTER TABLE sensors ADD lcd  TEXT");
$dba->exec("ALTER TABLE sensors ADD mail  TEXT");
$dba->exec("ALTER TABLE sensors ADD method  TEXT");
$dba->exec("ALTER TABLE sensors ADD minmax  TEXT");
$dba->exec("ALTER TABLE sensors ADD remote  TEXT");
$dba->exec("ALTER TABLE sensors ADD status TEXT");
$dba->exec("ALTER TABLE sensors ADD sum  TEXT");
$dba->exec("ALTER TABLE sensors ADD tmp_5ago  TEXT");
$dba->exec("ALTER TABLE sensors ADD usb  TEXT");
$dba->exec("ALTER TABLE sensors ADD position_group  TEXT");
$dba->exec("ALTER TABLE sensors ADD stat_min TEXT");
$dba->exec("ALTER TABLE sensors ADD stat_max TEXT");

$dba->exec("ALTER TABLE settings ADD authmod  TEXT");
$dba->exec("ALTER TABLE settings ADD call  TEXT");
$dba->exec("ALTER TABLE settings ADD cauth_login  TEXT");
$dba->exec("ALTER TABLE settings ADD cauth_on  TEXT");
$dba->exec("ALTER TABLE settings ADD cauth_pass  TEXT");
$dba->exec("ALTER TABLE settings ADD charts_gpio  TEXT");
$dba->exec("ALTER TABLE settings ADD charts_hosts  TEXT");
$dba->exec("ALTER TABLE settings ADD charts_min  TEXT");
$dba->exec("ALTER TABLE settings ADD charts_system  TEXT");
$dba->exec("ALTER TABLE settings ADD charts_theme  TEXT");
$dba->exec("ALTER TABLE settings ADD client_ip  TEXT");
$dba->exec("ALTER TABLE settings ADD client_key  TEXT");
$dba->exec("ALTER TABLE settings ADD client_on  TEXT");
$dba->exec("ALTER TABLE settings ADD fw  TEXT");
$dba->exec("ALTER TABLE settings ADD gpio  TEXT");
$dba->exec("ALTER TABLE settings ADD kwh  TEXT");
$dba->exec("ALTER TABLE settings ADD lcd  TEXT");
$dba->exec("ALTER TABLE settings ADD lcd4  TEXT");
$dba->exec("ALTER TABLE settings ADD MCP23017  TEXT");
$dba->exec("ALTER TABLE settings ADD meteogram  TEXT");
$dba->exec("ALTER TABLE settings ADD radius  TEXT");
$dba->exec("ALTER TABLE settings ADD server_key  TEXT");
$dba->exec("ALTER TABLE settings ADD tempnum  TEXT");
$dba->exec("ALTER TABLE settings ADD temp_scale TEXT");
$dba->exec("ALTER TABLE settings ADD ups_status  TEXT");
$dba->exec("ALTER TABLE settings ADD vpn  TEXT");
$dba->exec("ALTER TABLE settings ADD gpiodemo  TEXT");
$dba->exec("ALTER TABLE settings ADD autologout  TEXT");

$dba->exec("ALTER TABLE snmp ADD rom  UNIQUE");
$dba->exec("ALTER TABLE snmp ADD  type TEXT");
$dba->exec("ALTER TABLE snmp ADD version  TEXT");

$dba->exec("ALTER TABLE types ADD max NUMERIC");
$dba->exec("ALTER TABLE types ADD min NUMERIC");
$dba->exec("ALTER TABLE types ADD value1 NUMERIC");
$dba->exec("ALTER TABLE types ADD value2 NUMERIC");
$dba->exec("ALTER TABLE types ADD value3 NUMERIC");
$dba->exec("ALTER TABLE users ADD at  TEXT");
$dba->exec("ALTER TABLE users ADD cam  TEXT");
$dba->exec("ALTER TABLE users ADD ctr  TEXT");
$dba->exec("ALTER TABLE users ADD mail  TEXT");
$dba->exec("ALTER TABLE users ADD maila  TEXT");
$dba->exec("ALTER TABLE users ADD moment  TEXT");
$dba->exec("ALTER TABLE users ADD simple  TEXT");
$dba->exec("ALTER TABLE users ADD smsa  TEXT");
$dba->exec("ALTER TABLE users ADD smspin  TEXT");
$dba->exec("ALTER TABLE users ADD smsts  TEXT");
$dba->exec("ALTER TABLE users ADD tel  TEXT");
$dba->exec("ALTER TABLE users ADD trigger  TEXT");

$dba->commit();
$dba=null;


// DEFAULT INSERT

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
$db->beginTransaction();

$db->exec("INSERT OR IGNORE INTO access_time (name, Mon, Tue, Wed, Thu, Fri, Sat, Sun, stime, etime) VALUES  ('any', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', '00:00', '23:59')");
$db->exec("INSERT OR IGNORE INTO charts (id, charts) VALUES (1, 'Highcharts')");

$db->exec("INSERT OR IGNORE INTO device (id,i2c) VALUES (1,'off')");
$db->exec("INSERT OR IGNORE INTO device (id,lmsensors) VALUES (1,'off')");
$db->exec("INSERT OR IGNORE INTO device (id,wireless) VALUES (1,'off')");
$db->exec("INSERT OR IGNORE INTO device (usb, onewire, serial, i2c, lmsensors, wireless ) VALUES ('off','off','off','off','off','off')");

$db->exec("INSERT OR IGNORE INTO fw (id, ssh, icmp, ext, openvpn, radius ) VALUES (1,'off','off', '0.0.0.0/0', 'off', 'off')");
$db->exec("INSERT OR IGNORE INTO highcharts (id, charts_min, charts_theme, charts_fast) VALUES (1, '1', 'black', 'off')");

$db->exec("INSERT OR IGNORE INTO html (name, state) VALUES ('footer', 'on')");
$db->exec("INSERT OR IGNORE INTO html (name, state) VALUES ('info', 'on')");
$db->exec("INSERT OR IGNORE INTO html (name, state) VALUES ('screen', 'off')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('charts_max', 'day')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('map_height', '600')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('map_width', '800')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('nettemp_alt', 'nettemp')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('nettemp_link', 'http://nettemp.pl')");
$db->exec("INSERT OR IGNORE INTO html (name, value) VALUES ('nettemp_logo', ' media/png/nettemp.pl.png')");

$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('bh1750','23')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('bme280','76')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('bmp180','77')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('ds2482','18')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('ds2482','1a')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('hih6130','27')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('htu21d','40')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('mpl3115a2','60')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('tmp102','48')");
$db->exec("INSERT OR IGNORE INTO i2c (name,addr) VALUES ('tsl2561','39')");

$db->exec("INSERT OR IGNORE INTO meteo (id, temp, latitude, height, pressure, humid, onoff ) VALUES (1,'0','0','0','0','0','off')");
$db->exec("INSERT OR IGNORE INTO minmax (name, state) VALUES ('mode', '1')");

$db->exec("INSERT OR IGNORE INTO settings (id, mail, sms, rrd, fw, vpn, gpio, authmod, temp_scale, meteogram) VALUES (1,'off','off', 'off', 'off', 'off', 'on', 'on', 'C', 'Poland/Pomerania/Gdansk')");
$db->exec("INSERT OR IGNORE INTO settings (id, temp_scale) VALUES (1, 'C')");
$db->exec("INSERT OR IGNORE INTO settings (id,gpio) VALUES (1,'on')");

$db->exec("INSERT OR IGNORE INTO statistics (agreement) VALUES ('no')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max, value1, value2, value3) VALUES ('temp', '°C', '°F', 'media/ico/temp2-icon.png' ,'Temperature','-150', '3000', '85', '185' ,'127.9')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('amps', 'A', 'A', 'media/ico/amper.png' ,'Amps','0', '10000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('battery', '%', '', 'media/ico/Battery-icon.png' ,'Battery','0', '100')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('dist', 'cm', 'cm', 'media/ico/Distance-icon.png' ,'Distance','0', '100000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('elec', 'kWh', 'W', 'media/ico/Lamp-icon.png' ,'Electricity','0', '99999999')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('gas', 'm3', 'm3', 'media/ico/gas-icon.png' ,'Gas','0', '100')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('gpio', 'H/L', '', 'media/ico/gpio2.png' ,'GPIO','-1000', '1000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('group', '', '', '' ,'', '', '')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('gust', 'km/h', '', 'media/ico/gust.png' ,'Gust','0', '255')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('host', 'ms', 'ms', 'media/ico/Computer-icon.png' ,'Host','0', '10000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('humid', '%', '%', 'media/ico/rain-icon.png' ,'Humidity','0', '110')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('lightining', '', '', 'media/ico/thunder-icon.png' ,'Lightining','0', '10000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('lux', 'lux', 'lux', 'media/ico/sun-icon.png' ,'Lux','0','100000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('press', 'hPa', 'hPa', 'media/ico/Science-Pressure-icon.png' ,'Pressure','0','10000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('rainfall', 'mm/m2', 'mm/m2', 'media/ico/showers.png' ,'Rainfall','0', '10000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('relay', 'H/L', '', 'media/ico/Switch-icon.png' ,'Relay','-1000', '1000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('rssi', 'rssi', '', 'media/ico/wifi-icon.png' ,'RSSI','-1000', '1000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('speed', 'km/h', 'km/h', 'media/ico/Wind-Flag-Storm-icon.png' ,'Speed','0', '10000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('storm', 'km', 'km', 'media/ico/storm-icon.png' ,'Storm','0', '10000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('switch', 'H/L', '', 'media/ico/Switch-icon.png' ,'Switch','-1000', '1000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('system', '%', '%', '' ,'System','0', '100')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('trigger', '', '', 'media/ico/alarm-icon.png' ,'Trigger','0', '100000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('uv', 'index', 'index', '' ,'UV','0', '10000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('volt', 'V', 'V', 'media/ico/volt.png' ,'Volt','-10000', '10000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('water', 'm3', 'm3', 'media/ico/water-icon.png' ,'Water','0', '100')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('watt', 'W', 'W', 'media/ico/watt.png' ,'Watt','-10000', '10000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('wind', '°', '°', 'media/ico/compass.png' ,'Wind','0', '10000')");
$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('dust', 'μg/m^3', '', 'media/ico/Weather-Dust-icon.png' ,'Dust','-4000', '4000')");



$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('1wire Serial','none')");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('1wire','none')");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('Modem Call','none')");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('Modem SMS','none')");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('RS485','none')");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('UPS Pimowo','none')");
$db->exec("INSERT OR IGNORE INTO usb (device,dev) VALUES ('SDS011','none')");

$db->exec("INSERT OR IGNORE INTO users (login, password, perms ) VALUES ('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'adm')");


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

$db->commit();
$db=null;
} catch (Exception $e) {
	/* Recognize mistake and roll back changes */
	$db->rollBack();
    echo $date." Error.\n";
    echo $e;
    //exit;
}


// END DEFAULT INSERT

//UPDATE

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
$db->beginTransaction();
$db->exec("UPDATE gpio SET position='1' WHERE position is null");
$db->exec("UPDATE hosts SET position='1' WHERE position is null");
$db->exec("UPDATE sensors SET position_group='1' WHERE position_group is null");
$db->exec("UPDATE sensors SET adj='0' WHERE adj='' OR adj=' ' OR adj is null");
$db->exec("UPDATE sensors SET charts='on' WHERE charts is null");
$db->exec("UPDATE sensors SET ch_group='sensors' WHERE ch_group is null OR ch_group=''");
$db->exec("UPDATE sensors SET sum='0' WHERE sum='' OR sum=' ' OR sum is null");
$db->exec("UPDATE settings SET autologout='on' WHERE autologout is null");
$db->exec("UPDATE settings SET charts_gpio='on' WHERE charts_gpio is null");
$db->exec("UPDATE settings SET charts_hosts='on' WHERE charts_hosts is null");
$db->exec("UPDATE settings SET charts_min='10' WHERE charts_gpio is null");
$db->exec("UPDATE settings SET charts_system='on' WHERE charts_system is null");
$db->exec("UPDATE settings SET meteogram='Poland/Pomerania/Gdansk' WHERE id='1' AND meteogram is null");
$db->exec("UPDATE settings SET temp_scale='C' WHERE temp_scale is null OR temp_scale=''");
$db->exec("UPDATE snmp SET version='2c' WHERE version is null");
$db->exec("UPDATE users SET perms='adm' WHERE login='admin' AND perms is null");
$db->exec("UPDATE sensors SET stat_max='0' WHERE stat_max='' OR stat_max is null");
$db->exec("UPDATE sensors SET stat_min='0' WHERE stat_min='' OR stat_min is null");

//TIME & TRIGGER
//$db->exec("CREATE TRIGGER IF NOT EXISTS aupdate_time_trigger AFTER UPDATE ON sensors WHEN NEW.tmp BEGIN UPDATE sensors SET time = (datetime('now','localtime')) WHERE id = old.id; END;");
$db->exec("CREATE TRIGGER IF NOT EXISTS aupdate_time_trigger AFTER UPDATE OF tmp ON sensors FOR EACH ROW WHEN NEW.tmp BEGIN UPDATE sensors SET time = (datetime('now','localtime')) WHERE id = old.id; END");
$db->exec("create unique index unique_name on newdev(rom)");

/* COMMIT */
$db->commit();
$db=null;

} catch (Exception $e) {
	/* Recognize mistake and roll back changes */
	$db->rollBack();
    echo $date." Error.\n";
    echo $e;
    //exit;
}

echo $date." nettemp database update: ok \n";


?>
