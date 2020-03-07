BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "types" (
	'id'	INTEGER,
	'type'	TEXT UNIQUE,
	'unit'	TEXT,
	'unit2'	TEXT,
	'ico'	TEXT,
	'title'	TEXT,
	'min'	NUMERIC,
	'max'	NUMERIC,
	'value1'	NUMERIC,
	'value2'	NUMERIC,
	'value3'	NUMERIC,
	PRIMARY KEY(id)
);
CREATE TABLE IF NOT EXISTS 'users' (
	'id'	INTEGER,'username' TEXT UNIQUE,
	'password'	TEXT, 'active' TEXT, 'email' TEXT, 'jwt' TEXT, 'receive_mail' TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE IF NOT EXISTS 'sensors' (
	'id'	INTEGER,
	'time'	TIMESTAMP,
	'tmp'	REAL,
	'name'	TEXT UNIQUE,
	'rom'	TEXT UNIQUE,
	'tmp_min'	REAL,
	'tmp_max'	REAL,
	'alarm'	TEXT,
	'type'	TEXT,
	'ip'	TEXT,
	'device'	TEXT,
	'method'	TEXT,
	'tmp_5ago'	REAL,
	'adj'	REAL,
	'charts'	TEXT,
	'i2c'	TEXT,
	'minmax'	TEXT,
	'sum'	TEXT,
	'ch_group'	TEXT,
        'email'	TEXT,
        'email_time'	TIMESTAMP,
        'email_status' TEXT,
        'email_delay' INTEGER DEFAULT 0,
	'status'	TEXT,
	'usb'	TEXT,
	'stat_min' REAL,
	'stat_max' REAL,
        'fiveago' TEXT,
        'map_id' NUMERIC,
        'gpio' NUMERIC,
        'stat_min_time'	TIMESTAMP,
        'stat_max_time'	TIMESTAMP, 'alarm_status' INTEGER, 'alarm_recovery_time' DATETIME, 'node', 'node_url', 'node_token', 'nodata', 
	PRIMARY KEY(id)
);
CREATE TRIGGER stat_max_time_tr AFTER UPDATE OF stat_max ON sensors FOR EACH ROW WHEN NEW.stat_max BEGIN UPDATE sensors SET stat_max_time = (datetime('now','localtime')) WHERE id = old.id; END;
CREATE TRIGGER stat_min_time_tr AFTER UPDATE OF stat_min ON sensors FOR EACH ROW WHEN NEW.stat_min BEGIN UPDATE sensors SET stat_min_time = (datetime('now','localtime')) WHERE id = old.id; END;
CREATE TABLE IF NOT EXISTS 'nt_settings' (
	'id' INTEGER,
	'option' TEXT UNIQUE,
	'value' TEXT, 'node_token',
	PRIMARY KEY(id)
);
CREATE TABLE IF NOT EXISTS 'maps' (
	'id'	INTEGER,
	'type'	TEXT,
        'map_id'	NUMERIC,
        'pos_y'	NUMERIC,
        'pos_x'	NUMERIC,
	'map_on'	TEXT,
	'transparent'	TEXT,
	'control_on_map'	TEXT,
	'display_name'	TEXT,
	'transparent_bkg'	TEXT,
	'background_color'	TEXT,
	'background_low'	TEXT,
	'background_high'	TEXT,
	'font_color'	TEXT,
	'font_size'	TEXT,
	'icon'	TEXT,
	PRIMARY KEY(id)
);
CREATE TRIGGER time_tr  AFTER UPDATE OF tmp ON sensors FOR EACH ROW WHEN NEW.tmp BEGIN UPDATE sensors SET time = (datetime('now','localtime')), nodata='' WHERE id = old.id; END;
COMMIT;
