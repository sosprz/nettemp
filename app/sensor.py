from app import app
from flask import Flask, request, jsonify, g
import sqlite3, os, re, json, datetime
from random import randint
from flask_jwt_extended import jwt_required
from flask_mysqldb import MySQL
mysql = MySQL()

def get_db(rom):
    db = getattr(g, '_database', None)
    if db is None:
        db = g._database = sqlite3.connect(rom)
    return db

@app.teardown_appcontext
def close_connection(exception):
    db = getattr(g, '_database', None)
    if db is not None:
        db.close()

def check_value(value, type, rom):
  adj=''
  tm=''
  value=float(value)
  m = mysql.connection.cursor()
  sql = "SELECT adj, tmp FROM sensors WHERE rom=%s"
  m.execute(sql, [rom])
  sensor=m.fetchall()
  for adj, tmp in sensor:
    tmp=float(tmp)
    adj=float(adj)
  msg=[]
  sql = "SELECT min, max, value1, value2, value3 FROM types WHERE type=%s"
  m.execute(sql, [type])
  list=m.fetchall()
  msg.append("IN VALUE: %f" % value)
  msg.append(list)
  m.close()

  if adj:
    value=float(value)+(adj)
    msg.append("ADJ: %d" % value)
  for min, max, v1, v2, v3 in list:
    if (value>=float(min)) and (value<=float(max)): 
      if(value==v1) or (value==v2) or (value==v3):
        msg.append("filter 2 back to previous %f" % tmp)
        value=tmp
      else:
        value=float(value)
    else:
      msg.append("filter 1 back to previous %f" % tmp)
      value=tmp

  msg.append("VALUE OUT: %f" % value)
  print(msg)
  return value

def new_db_table(rom):
  rom = 'db_'+rom
  m = mysql.connection.cursor()
  sql = "CREATE TABLE `{}` ( `id` INT NOT NULL AUTO_INCREMENT, `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `value` FLOAT, PRIMARY KEY (`id`))".format(rom)
  #sql = "CREATE TABLE %s ( `id` INT NOT NULL AUTO_INCREMENT, `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `value` FLOAT, PRIMARY KEY (`id`))"
  #m.execute(sql, (rom,))
 
  if m.execute(sql):
    m.connection.commit()
    m.close()
    print ("[ nettemp ][ sensor ] Sensor %s instert ok - mysql" %rom)
    return True
  else:
    print ("[ nettemp ][ sensor ] Sensor %s create error - mysql" %rom)
    return False

def insert_db(rom,value):
  m = mysql.connection.cursor()
  rom = 'db_'+rom
  sql="SELECT count(*) FROM information_schema.tables WHERE table_schema = 'nettemp' AND table_name = '{}' LIMIT 1".format(rom)
  m.execute(sql)
  coun=m.fetchone()[0]
  if coun==1:
    sql = "INSERT INTO {} (value) VALUES ({})".format(rom,value)
    if m.execute(sql):
      m.connection.commit()
      m.close()
      print ("[ nettemp ][ sensor ] Sensor %s instert ok - mysql" %rom)
      return True
    else:
      print ("[ nettemp ][ sensor ] Sensor %s instert error - mysql" %rom)
      return False
  else:
    print ("[ nettemp ][ sensor ] Sensor %s instert error - mysql" %rom)
    return False

def new_db_sqlite(rom):
  rom = rom+'.sql'
  conn = sqlite3.connect(app.romdir+rom)
  c = conn.cursor()
  sql = "SELECT count() FROM sqlite_master WHERE type='table' AND name='def'"
  c.execute(sql)
  if c.fetchone()[0]==1:
    print ("Database %s exists - sqlite" %rom)
    return True
  else:
    with app.app_context():
      db = get_db(app.romdir+rom)
      with app.open_resource('schema/sensors_db_schema.sql', mode='r') as f:
        db.cursor().executescript(f.read())
        db.commit()
    print ("Database %s created - sqlite" %rom)
    return False

def insert_db_sqlite(rom,value):
  rom = rom+'.sql'
  conn = sqlite3.connect(app.romdir+rom)
  c = conn.cursor()
  sql = "SELECT count() FROM sqlite_master WHERE type='table' AND name='def'"
  c.execute(sql)
  if c.fetchone()[0]==1:
    data = [value]
    sql = "INSERT OR IGNORE INTO def (value) VALUES (?)"
    c.execute(sql, data)
    conn.commit()
    conn.close()
    print ("[ nettemp ][ sensor ] Sensor %s insert ok - sqlite" %rom)
    return True
  else:
    print ("[ nettemp ][ sensor ] Sensor %s not exist - sqlite" %rom)
    return False

def update_sensor_tmp(rom,value):
  m = mysql.connection.cursor()
  rom1 = [rom]
  sql="SELECT count(*) FROM sensors WHERE rom=%s"
  m.execute(sql, rom1)
  coun=m.fetchone()
  if coun[0]==1:
    if int(datetime.datetime.now().strftime("%M"))%5==0:
      tmp_5ago=value
      sql = "UPDATE sensors SET tmp=%s, tmp_5ago=%s, nodata='', time=CURRENT_TIMESTAMP() WHERE rom=%s"
      data = [value,tmp_5ago,rom]
    else:
      sql = "UPDATE sensors SET tmp=%s, nodata='', time=CURRENT_TIMESTAMP() WHERE rom=%s"
      data = [value,rom]
    m.execute(sql, data)
    # stat min max
    data = [value, value, rom]
    sql = "UPDATE sensors SET stat_min=%s, stat_min_time=CURRENT_TIMESTAMP() WHERE (stat_min>%s OR stat_min is null OR stat_min='0.0') AND rom=%s"
    m.execute(sql, data)
    sql = "UPDATE sensors SET stat_max=%s, stat_max_time=CURRENT_TIMESTAMP() WHERE (stat_max<%s OR stat_max is null OR stat_max='0.0') AND rom=%s"
    m.execute(sql, data)
    m.connection.commit()
    m.close()
    print ("[ nettemp ][ sensor ] Sensor %s updated" %rom)
    return True
  else:
    print ("[ nettemp ][ sensor ] Sensor %s not exist" %rom)
    return False

# unused
def delete_db_sqlite(rom):
  rom=rom+'.sql'
  if os.path.isfile(app.romdir+rom):
    os.remove(rom)
    print ("[ nettemp ][ sensor ] Database %s deleted" %rom)
    return True
  else:
    print ("[ nettemp ][ sensor ] Database %s not exist" %rom)
    return False

# unused
def delete_sensor(id,rom):
  data = [id, rom]
  m = mysql.connection.cursor()
  sql="DELETE FROM sensors WHERE id=? AND rom=%s"
  m.execute(sql, data)
  m.connection.commit()
  m.close()
  delete_db_sqlite(rom)
  print ("[ nettemp ][ sensor ] Sensor %s removed ok" %rom)

def create_sensor(rom, data, data2, map_settings):
  m = mysql.connection.cursor()
  rom1 = [rom]
  sql = "SELECT count(*) FROM sensors WHERE rom=%s"
  m.execute(sql, rom1)
  coun = m.fetchone()
  if coun[0]==0:
    sql = "INSERT INTO sensors (rom,type,device,ip,gpio,i2c,usb,name) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
    m.execute(sql, data)
    sql2 = "UPDATE sensors SET alarm='off', adj='0', charts='on', status='on', ch_group=%s, tmp_min='0', tmp_max='0', minmax='off', stat_min='0', stat_max='0', tmp_5ago='0', fiveago='on', map_id=%s, nodata_time='5', email_delay='10' WHERE rom=%s"
    m.execute(sql2, data2)
    map = "INSERT INTO maps (type, pos_x, pos_y, map_on, map_id, display_name) VALUES (%s, %s, %s, %s, %s, %s)"
    m.execute(map, map_settings)
    m.connection.commit()
    m.close()
    print ("[ nettemp ][ sensor ] Sensor %s added ok" %rom)
  else:
    print ("[ nettemp ][ sensor ] Sensor %s already exist" %rom)
  return None

def clean_rom(val):
  val.replace('-','_')
  val = re.sub(r'[^A-Za-z0-9_]+', '', val)
  return val

def clean_name(val):
  val = re.sub(r'[^A-Za-z0-9_.-]+', '', val)
  return val

def sensor():
    data = request.get_json()
    for j in data:

      rom = None
      if 'rom' in j: 
        rom=clean_rom(j['rom'])

      type = None 
      if 'type' in j: 
        type=j['type']

      device = None 
      if 'device' in j: 
        device=j['device']

      ip = None 
      if 'ip' in j: 
        ip = j['ip']

      gpio = None 
      if 'gpio' in j: 
        gpio=j['gpio']

      i2c = None 
      if 'i2c' in j: 
        i2c=j['i2c']

      usb = None 
      if 'usb' in j: 
        usb=j['usb']

      name = randint(1000,9000)
      if 'name' in j: 
        name=clean_name(j['name'])
        if not j['name']:
          name = randint(1000,9000)

      tmp = None 
      if 'tmp' in j: 
        tmp=j['tmp']

      value = None 
      if 'value' in j: 
        value=j['value']
    
      group = type 
      if 'group' in j: 
        group=j['group']

      map_id = randint(1000,9000)
      map_y = randint(50,600)
      map_x = randint(50,600)
      data = [rom, type, device, ip, gpio, i2c, usb, name]
      data2 = [group, map_id, rom]
      map_settings = [type, map_y, map_x, 'on', map_id, 'on']
      value=check_value(value, type, rom)

      m = mysql.connection.cursor()
      sql = "SELECT value FROM nt_settings WHERE option='mysql_charts'"
      m.execute(sql) 
      mysql_charts = m.fetchone()[0]
      m.close();

      if mysql_charts == 'on':
        if insert_db(rom,value) == False:
          new_db_table(rom)
          insert_db(rom,value) 
      else:
        if insert_db_sqlite(rom, value) == False:
          new_db_sqlite(rom)
          insert_db_sqlite(rom,value)

      if update_sensor_tmp(rom,value) == False:
        create_sensor(rom,data,data2,map_settings)
        update_sensor_tmp(rom,value)

@app.route('/sensor', methods=['POST'])
@jwt_required
def url_sensor():
  sensor()
  return '', 200

@app.route('/local', methods=['POST'])
def url_localhost():
  if request.remote_addr == '127.0.0.1':
    sensor()
    return 'Local'
  else:
    return '', 404
