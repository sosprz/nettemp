BEGIN TRANSACTION;
CREATE TABLE "vpn" (
	`id`	INTEGER,
	`users`	TEXT UNIQUE,
	PRIMARY KEY(id)
);
CREATE TABLE "users" (
	`id`	INTEGER,
	`login`	TEXT UNIQUE,
	`password`	TEXT,
	`perms`	TEXT,
	`tel`	TEXT UNIQUE,
	`mail`	TEXT UNIQUE,
	`smsa`	TEXT,
	`maila`	TEXT,
	`adm`	TEXT,
	`ctr`	TEXT,
	`simple`	TEXT,
	`trigger`	TEXT,
	`moment`	TEXT,
	`cam`	TEXT,
	`at`	TEXT,
	`smspin`	TEXT,
	`smsts`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "usb" (
	`id`	INTEGER,
	`dev`	TEXT,
	`device`	TEXT UNIQUE,
	PRIMARY KEY(id)
);
CREATE TABLE "types" (
	`id`	INTEGER,
	`type`	TEXT UNIQUE,
	`unit`	TEXT,
	`unit2`	TEXT,
	`ico`	TEXT,
	`title`	TEXT,
	`min`	NUMERIC,
	`max`	NUMERIC,
	`value1`	NUMERIC,
	`value2`	NUMERIC,
	`value3`	NUMERIC,
	PRIMARY KEY(id)
);
CREATE TABLE "statistics" (
	`id`	INTEGER,
	`agreement`	TEXT UNIQUE,
	`nick`	TEXT UNIQUE,
	`location`	TEXT UNIQUE,
	`sensor_temp`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "snmp" (
	`id`	INTEGER,
	`name`	TEXT UNIQUE,
	`rom`	TEXT UNIQUE,
	`community`	TEXT,
	`host`	TEXT,
	`oid`	TEXT,
	`divider`	TEXT,
	`type`	TEXT,
	`version`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "sensors" (
	`id`	INTEGER,
	`time`	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`tmp`	REAL,
	`name`	TEXT UNIQUE,
	`rom`	TEXT UNIQUE,
	`tmp_min`	REAL,
	`tmp_max`	REAL,
	`type`	TEXT,
	`gpio`	TEXT,
	`ip`	TEXT,
	`device`	TEXT,
	`lcd`	TEXT,
	`method`	TEXT,
	`tmp_5ago`	TEXT,
	`adj`	TEXT,
	`charts`	TEXT,
	`remote`	TEXT,
	`i2c`	TEXT,
	`minmax`	TEXT,
	`sum`	TEXT,
	`ch_group`	TEXT,
	`jg`	TEXT,
	`current`	TEXT,
	`mail`	TEXT,
	`status`	TEXT,
	`usb`	TEXT,
	`position_group`	TEXT,
	`stat_min` TEXT,
	`stat_max` TEXT,
	`position` TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "rs485" (
	`id`	INTEGER,
	`dev`	TEXT,
	`addr`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "relays" (
	`id`	INTEGER,
	`list`	TEXT UNIQUE,
	`name`	TEXT,
	`ip`	TEXT,
	`delay`	TEXT,
	`rom`	TEXT,
	`type`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "newdev" (
	`id`	INTEGER,
	`list`	TEXT,
	`type`	TEXT,
	`rom`	TEXT UNIQUE,
	`device`	TEXT,
	`i2c`	TEXT,
	`usb`	TEXT,
	`gpio`	TEXT,
	`ip`	TEXT,
	`name`	TEXT, seen TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "meteo" (
	`id`	INTEGER,
	`temp`	TEXT,
	`latitude`	TEXT,
	`height`	TEXT,
	`pressure`	TEXT,
	`humid`	TEXT,
	`onoff`	TEXT,
	`normalized`	TEXT,
	`jg`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "maps" (
	`id`	INTEGER,
	`type`	TEXT,
	`element_id`	INTEGER,
	`map_num`	NUMERIC,
	`map_pos`	NUMERIC,
	`position`	INTEGER DEFAULT 1,
	`map_on`	TEXT,
	`transparent`	TEXT,
	`control_on_map`	TEXT,
	`display_name`	TEXT,
	`transparent_bkg`	TEXT,
	`background_color`	TEXT,
	`background_low`	TEXT,
	`background_high`	TEXT,
	`font_color`	TEXT,
	`font_size`	TEXT,
	`icon`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "i2c" (
	`id`	INTEGER,
	`name`	TEXT,
	`addr`	TEXT UNIQUE,
	PRIMARY KEY(id)
);
CREATE TABLE "hosts" (
	`id`	INTEGER,
	`time`	TEXT DEFAULT CURRENT_TIMESTAMP,
	`name`	TEXT UNIQUE,
	`ip`	TEXT,
	`type`	TEXT,
	`last`	TEXT,
	`status`	TEXT,
	`rom`	TEXT,
	`map_pos`	NUMERIC,
	`map_num`	NUMERIC,
	`map`	NUMERIC,
	`alarm`	TEXT,
	`position`	TEXT,
	`element_id`	TEXT,
	`mail`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "gpio" (
	`id`	INTEGER,
	`gpio`	TEXT,
	`name`	TEXT,
	`mode`	TEXT,
	`simple`	TEXT,
	`rev`	TEXT,
	`status`	TEXT,
	`time_run`	TEXT,
	`time_offset`	TEXT,
	`time_start`	TEXT,
	`humid_type`	TEXT,
	`day_run`	TEXT,
	`week_run`	TEXT,
	`week_status`	TEXT,
	`trigger_run`	TEXT,
	`trigger_notice`	TEXT,
	`kwh_run`	TEXT,
	`kwh_divider`	TEXT,
	`temp_run`	TEXT,
	`trigger_source`	TEXT,
	`control`	TEXT,
	`control_run`	TEXT,
	`trigger_delay`	TEXT,
	`trigger_con`	TEXT,
	`tel_num1`	TEXT,
	`tel_num2`	TEXT,
	`tel_num3`	TEXT,
	`tel_any`	TEXT,
	`tel_at`	TEXT,
	`elec_divider`	TEXT,
	`water_divider`	TEXT,
	`gas_divider`	TEXT,
	`elec_run`	TEXT,
	`water_run`	TEXT,
	`gas_run`	TEXT,
	`elec_debouncing`	TEXT,
	`water_debouncing`	TEXT,
	`gas_debouncing`	TEXT,
	`fnum`	TEXT,
	`state`	TEXT,
	`position`	TEXT,
	`day_zone2s`	TEXT,
	`day_zone2e`	TEXT,
	`day_zone3s`	TEXT,
	`day_zone3e`	TEXT,
	`moment_time`	TEXT,
	`ip`	TEXT,
	`rom`	TEXT,
	`locked`	TEXT, map NUM, map_num NUMERIC, map_pos NUMERIC, week_Fri  TEXT, week_Mon  TEXT, week_Sat  TEXT, week_Sun  TEXT, week_Thu  TEXT, week_Tue  TEXT, week_Wed  TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "g_func" (
	`id`	INTEGER,
	`position`	INTEGER DEFAULT 1,
	`sensor`	TEXT,
	`sensor2`	TEXT,
	`onoff`	TEXT,
	`value`	TEXT,
	`op`	TEXT,
	`hyst`	TEXT,
	`source`	TEXT,
	`gpio`	TEXT,
	`w_profile`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "fw" (
	`id`	INTEGER,
	`ssh`	TEXT,
	`icmp`	TEXT,
	`openvpn`	TEXT,
	`ext`	TEXT,
	`radius`	TEXT,
	`syslog`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "device" (
	`id`	INTEGER,
	`usb`	TEXT UNIQUE,
	`onewire`	TEXT UNIQUE,
	`serial`	TEXT UNIQUE,
	`i2c`	TEXT UNIQUE,
	`lmsensors`	TEXT,
	`wireless`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "day_plan" (
	`id`	INTEGER,
	`name`	TEXT UNIQUE,
	`Mon`	TEXT,
	`Tue`	TEXT,
	`Wed`	TEXT,
	`Thu`	TEXT,
	`Fri`	TEXT,
	`Sat`	TEXT,
	`Sun`	TEXT,
	`stime`	TEXT,
	`etime`	TEXT,
	`gpio`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "camera" (
	`id`	INTEGER,
	`name`	TEXT UNIQUE,
	`link`	TEXT UNIQUE,
	`access_all`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "call_settings" (
	`id`	INTEGER,
	`name`	TEXT,
	`dev`	TEXT,
	`default_dev`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "auth_tokens" (
	`id`	INTEGER,
	`selector`	TEXT,
	`token`	TEXT,
	`userid`	TEXT,
	`expires`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "access_time" (
	`id`	INTEGER,
	`name`	TEXT UNIQUE,
	`Mon`	TEXT,
	`Tue`	TEXT,
	`Wed`	TEXT,
	`Thu`	TEXT,
	`Fri`	TEXT,
	`Sat`	TEXT,
	`Sun`	TEXT,
	`stime`	TEXT,
	`etime`	TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE "adjust" (
	`id`	INTEGER,
	`rom` 	TEXT,
	`threshold` NUMERIC,
	`end` NUMERIC,
	`addvalue` NUMERIC,
	PRIMARY KEY(id)
);
CREATE TABLE "nt_settings" (
	`id` INTEGER,
	`option` TEXT UNIQUE,
	`value` TEXT,
	PRIMARY KEY(id)
);
CREATE TRIGGER aupdate_time_trigger AFTER UPDATE OF tmp ON sensors FOR EACH ROW WHEN NEW.tmp BEGIN UPDATE sensors SET time = (datetime('now','localtime')) WHERE id = old.id; END;
COMMIT;
