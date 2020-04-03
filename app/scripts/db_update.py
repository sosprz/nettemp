#!/usr/bin/python3

import sqlite3
import os

from pathlib import Path

dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
DB=dir+'/data/dbf/nettemp.db'
print (DB)

def update():
  sql = []
  sql.append("PRAGMA journal_mode=DELETE")
  sql.append("PRAGMA page_size=4096")
  sql.append("VACUUM")
  sql.append("PRAGMA journal_mode=WAL")
  
  
  """ insert """
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max, value1, value2, value3) VALUES ('temp', '°C', '°F', 'media/ico/temp2-icon.png' ,'Temperature','-150', '3000', '85', '185' ,'127.9')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('amps', 'A', 'A', 'media/ico/amper.png' ,'Amps','0', '10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('alti', 'm', 'm', 'media/ico/View-Height-icon.png' ,'Altitude','-1000', '10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('battery', '%', '', 'media/ico/Battery-icon.png' ,'Battery','0', '100')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('dist', 'cm', 'cm', 'media/ico/Distance-icon.png' ,'Distance','0', '100000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('elec', 'kWh', 'W', 'media/ico/Lamp-icon.png' ,'Electricity','0', '99999999')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('gas', 'm3', 'm3', 'media/ico/gas-icon.png' ,'Gas','0', '100')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('gpio', 'H/L', '', 'media/ico/gpio2.png' ,'GPIO','-1000', '1000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('group', '', '', 'media/ico/FAQ-icon.png' ,'', '', '')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('gust', 'km/h', '', 'media/ico/gust.png' ,'Gust','0', '255')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('host', 'ms', 'ms', 'media/ico/Computer-icon.png' ,'Host','0', '10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('humid', '%', '%', 'media/ico/rain-icon.png' ,'Humidity','0', '110')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('lightining', '', '', 'media/ico/thunder-icon.png' ,'Lightining','0', '10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('lux', 'lux', 'lux', 'media/ico/sun-icon.png' ,'Lux','0','100000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('press', 'hPa', 'hPa', 'media/ico/Science-Pressure-icon.png' ,'Pressure','0','10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('rainfall', 'mm/m2', 'mm/m2', 'media/ico/showers.png' ,'Rainfall','0', '10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('relay', 'H/L', '', 'media/ico/Switch-icon.png' ,'Relay','-1000', '1000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('rssi', 'rssi', '', 'media/ico/wifi-icon.png' ,'RSSI','-1000', '1000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('speed', 'km/h', 'km/h', 'media/ico/Wind-Flag-Storm-icon.png' ,'Speed','0', '10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('storm', 'km', 'km', 'media/ico/storm-icon.png' ,'Storm','0', '10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('switch', 'H/L', '', 'media/ico/Switch-icon.png' ,'Switch','-1000', '1000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('system', '%', '%', 'media/ico/Computer-icon.png' ,'System','0', '100')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('trigger', '', '', 'media/ico/alarm-icon.png' ,'Trigger','0', '100000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('uv', 'index', 'index', 'media/ico/FAQ-icon.png' ,'UV','0', '10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('volt', 'V', 'V', 'media/ico/volt.png' ,'Volt','-10000', '10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('water', 'm3', 'm3', 'media/ico/water-icon.png' ,'Water','0', '100')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('watt', 'W', 'W', 'media/ico/watt.png' ,'Watt','-10000', '10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('wind', '°', '°', 'media/ico/compass.png' ,'Wind','0', '10000')")
  sql.append("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('dust', 'μg/m^3', '', 'media/ico/Weather-Dust-icon.png' ,'Dust','-4000', '4000')")

  sql.append("INSERT OR IGNORE INTO users (username, password, active) VALUES ('admin', 'fake', 'yes')")
  sql.append("INSERT OR IGNORE INTO nt_settings (option,value) VALUES ('smtp_user','')")
  sql.append("INSERT OR IGNORE INTO nt_settings (option,value) VALUES ('smtp_p','')")
  sql.append("INSERT OR IGNORE INTO nt_settings (option,value) VALUES ('smtp_server','smtp.gmail.com')")
  sql.append("INSERT OR IGNORE INTO nt_settings (option,value) VALUES ('smtp_port','465')")
  sql.append("INSERT OR IGNORE INTO nt_settings (option,value) VALUES ('mail_subject','Nettemp notification!')")

  sql.append("INSERT OR IGNORE INTO nt_settings (option,value) VALUES ('map_height', '600')")
  sql.append("INSERT OR IGNORE INTO nt_settings (option,value) VALUES ('map_width', '1000')")
 
  sql.append("INSERT OR IGNORE INTO nt_settings (option,value) VALUES ('quick_charts', 'off')")
  sql.append("INSERT OR IGNORE INTO nt_settings (option,value) VALUES ('charts_theme', '')")
  sql.append("INSERT OR IGNORE INTO nt_settings (option,value) VALUES ('nt_theme', 'dark')")

  """ update """
  
  sql.append("UPDATE sensors SET charts='on' WHERE charts is null")
  sql.append("UPDATE sensors SET ch_group='sensors' WHERE ch_group is null OR ch_group=''")


  sql.append("UPDATE sensors SET stat_max='0' WHERE stat_max='' OR stat_max is null")
  sql.append("UPDATE sensors SET stat_min='0' WHERE stat_min='' OR stat_min is null")
  sql.append("UPDATE sensors SET tmp_max='0' WHERE tmp_max='' OR tmp_max is null")
  sql.append("UPDATE sensors SET tmp_min='0' WHERE tmp_min='' OR tmp_min is null")
  sql.append("UPDATE sensors SET tmp_5ago='0' WHERE tmp_5ago='' OR tmp_5ago is null")
  sql.append("UPDATE sensors SET fiveago='on' WHERE fiveago='' OR fiveago is null")
  sql.append("UPDATE sensors SET nodata_time='5' WHERE nodata_time='' OR nodata_time is null")
  sql.append("UPDATE sensors SET email_delay='10' WHERE email_delay='' OR email_delay is null")


  #sql.append("CREATE TRIGGER IF NOT EXISTS time_tr AFTER UPDATE OF tmp ON sensors FOR EACH ROW WHEN NEW.tmp BEGIN UPDATE sensors SET time = (datetime('now','localtime')) WHERE id = old.id; END")
  #sql.append("CREATE TRIGGER IF NOT EXISTS stat_max_time_tr AFTER UPDATE OF stat_max ON sensors FOR EACH ROW WHEN NEW.stat_max BEGIN UPDATE sensors SET stat_max_time = (datetime('now','localtime')) WHERE id = old.id; END;")
  #sql.append("CREATE TRIGGER IF NOT EXISTS stat_min_time_tr AFTER UPDATE OF stat_min ON sensors FOR EACH ROW WHEN NEW.stat_min BEGIN UPDATE sensors SET stat_min_time = (datetime('now','localtime')) WHERE id = old.id; END;")

  conn = sqlite3.connect(DB)
  c = conn.cursor()
  for sql in sql:
   c.execute(sql)
  conn.commit()
  conn.close()
  return "ok"

def alter():
  sql = []
  sql.append("ALTER TABLE sensors ADD COLUMN 'nodata' TEXT")
  sql.append("ALTER TABLE sensors ADD COLUMN 'nodata_time' TEXT")
  sql.append("ALTER TABLE sensors ADD COLUMN 'sid' TEXT")

  conn = sqlite3.connect(DB)
  c = conn.cursor()
  for sql in sql:
    try:
      c.execute(sql)
    except:
      pass
  conn.commit()
  conn.close()
  return "ok"

alter()
update()

  
  


