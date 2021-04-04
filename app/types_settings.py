# -*- coding: utf-8 -*-
from app import app
from flask import Flask, request, jsonify, render_template
from flask_login import login_required
import os
from flask_mysqldb import MySQL
mysql = MySQL()


def query_select_types():
  m = mysql.connection.cursor()
  sql = "SELECT id, type, unit, unit2, ico, title, min, max, value1, value2, value3 title FROM types"
  m.execute(sql)
  data = m.fetchall()  
  m.close()
  return data

def query_select_group():
  m = mysql.connection.cursor()
  sql = "SELECT DISTINCT ico FROM types"
  m.execute(sql)
  data = m.fetchall()  
  m.close()
  return data

@app.route('/settings/types', methods=['GET','POST'])
@login_required
def settings_types():
  if request.method == "POST":
    if request.form.get('send-types-update') == 'yes':
      id = request.form['id']
      type = request.form['type']
      unit = request.form['unit']
      unit2 = request.form['unit2']
      ico = request.form['ico']
      title = request.form['title']
      min = request.form['min']
      max = request.form['max']
      value1 = request.form['value1']
      value2 = request.form['value2']
      value3 = request.form['value3']
      m = mysql.connection.cursor()
      sql = "UPDATE types SET type=%s, unit=%s, unit2=%s, ico=%s, title=%s, min=%s, max=%s, value1=%s, value2=%s, value3=%s  WHERE id=%s"
      m.execute(sql, (type,unit,unit2,ico,title,min,max,value1,value2,value3,id))
      m.connection.commit()
      m.close()

    if request.form.get('send-types-del') == 'yes':
      id = request.form['id']
      m = mysql.connection.cursor()
      sql = "DELETE FROM types WHERE id=%s"
      m.execute(sql, (id,))
      m.connection.commit()
      m.close()
    if request.form.get('send-types-new') == 'yes':
      type = request.form['type']
      unit = request.form['unit']
      unit2 = request.form['unit2']
      ico = request.form['ico']
      title = request.form['title']
      min = request.form['min']
      max = request.form['max']
      value1 = request.form['value1']
      value2 = request.form['value2']
      value3 = request.form['value3']
      m = mysql.connection.cursor()
      sql = "INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max, value1, value2, value3) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
      m.execute(sql, (type,unit,unit2,ico,title,min,max,value1,value2,value3))
      m.connection.commit()
      m.close()
    if request.form.get('send-default') == 'yes':
      type = []
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max, value1, value2, value3) VALUES ('temp', '°C', '°F', 'media/ico/temp2-icon.png' ,'Temperature','-150', '3000', '85', '185' ,'127.9')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('amps', 'A', 'A', 'media/ico/amper.png' ,'Amps','0', '10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('alti', 'm', 'm', 'media/ico/View-Height-icon.png' ,'Altitude','-1000', '10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('battery', '%', '', 'media/ico/Battery-icon.png' ,'Battery','0', '100')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('dist', 'cm', 'cm', 'media/ico/Distance-icon.png' ,'Distance','0', '100000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('elec', 'kWh', 'W', 'media/ico/Lamp-icon.png' ,'Electricity','0', '99999999')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('gas', 'm3', 'm3', 'media/ico/gas-icon.png' ,'Gas','0', '100')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('gpio', 'H/L', '', 'media/ico/gpio2.png' ,'GPIO','-1000', '1000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('group', '', '', 'media/ico/FAQ-icon.png' ,'', '', '')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('gust', 'km/h', '', 'media/ico/gust.png' ,'Gust','0', '255')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('host', 'ms', 'ms', 'media/ico/Computer-icon.png' ,'Host','0', '10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('humid', '%', '%', 'media/ico/rain-icon.png' ,'Humidity','0', '110')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('lightining', '', '', 'media/ico/thunder-icon.png' ,'Lightining','0', '10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('lux', 'lux', 'lux', 'media/ico/sun-icon.png' ,'Lux','0','100000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('press', 'hPa', 'hPa', 'media/ico/Science-Pressure-icon.png' ,'Pressure','0','10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('rainfall', 'mm/m2', 'mm/m2', 'media/ico/showers.png' ,'Rainfall','0', '10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('relay', 'H/L', '', 'media/ico/Switch-icon.png' ,'Relay','-1000', '1000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('rssi', 'rssi', '', 'media/ico/wifi-icon.png' ,'RSSI','-1000', '1000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('speed', 'km/h', 'km/h', 'media/ico/Wind-Flag-Storm-icon.png' ,'Speed','0', '10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('storm', 'km', 'km', 'media/ico/storm-icon.png' ,'Storm','0', '10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('switch', 'H/L', '', 'media/ico/Switch-icon.png' ,'Switch','-1000', '1000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('system', '%', '%', 'media/ico/Computer-icon.png' ,'System','0', '100')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('trigger', '', '', 'media/ico/alarm-icon.png' ,'Trigger','0', '100000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('uv', 'index', 'index', 'media/ico/FAQ-icon.png' ,'UV','0', '10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('volt', 'V', 'V', 'media/ico/volt.png' ,'Volt','-10000', '10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('water', 'm3', 'm3', 'media/ico/water-icon.png' ,'Water','0', '100')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('watt', 'W', 'W', 'media/ico/watt.png' ,'Watt','-10000', '10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('wind', '°', '°', 'media/ico/compass.png' ,'Wind','0', '10000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('dust', 'μg/m^3', '', 'media/ico/Weather-Dust-icon.png' ,'Dust','-4000', '4000')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('accel', '', '', 'media/ico/paper-plane-icon.png' ,'Acceleration','-100', '100')")
      type.append("INSERT IGNORE INTO types (type, unit, unit2, ico, title, min, max) VALUES ('motion', '', '', 'media/ico/paper-plane-icon.png' ,'Motion','0', '1')")
      m = mysql.connection.cursor()
      sql = "DELETE from types"
      m.execute(sql)
      for sql in type:
        m.execute(sql)
      m.connection.commit()
      m.close()

  icolist = []
  for filename in os.listdir('app/static/media/ico/'):
    if filename.endswith(".png"): 
      icolist.append([filename,'media/ico/'+filename])

  data = query_select_types()
  group = query_select_group()
  return render_template('types_settings.html', data=data, group=group, icolist=icolist)
