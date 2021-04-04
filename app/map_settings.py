# -*- coding: utf-8 -*-
from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
from app.nettemp import nt_settings
from flask_mysqldb import MySQL
mysql = MySQL()


def queryselectsensors():
  m = mysql.connection.cursor()
  sql = "SELECT maps.map_id, sensors.name, maps.map_on, maps.display_name, maps.transparent_bkg, maps.background_color, maps.background_low, maps.background_high, maps.font_color, maps.font_size FROM sensors INNER JOIN maps ON sensors.map_id = maps.map_id"
  m.execute(sql)
  data = m.fetchall()  
  m.close()
  return data


@app.route('/settings/map/settings', methods=['GET','POST'])
@login_required
def settings_map():
  if request.method == "POST":
    if request.form.get('send-map-image') == 'yes':
      map_height = request.form['map_height']
      map_width = request.form['map_width']
      m = mysql.connection.cursor()
      sql = "UPDATE nt_settings SET value=%s WHERE option='map_width'"
      m.execute(sql, (map_width,))
      sql = "UPDATE nt_settings SET value=%s WHERE option='map_height'"
      m.execute(sql, (map_height,))
      m.connection.commit()
      m.close()
    if request.form.get('send') == 'yes':
      name = request.form['name']
      value = request.form['value']
      id = request.form['id']
      m = mysql.connection.cursor()
      if name=='transparent_bkg':
        sql = "UPDATE maps SET transparent_bkg=%s WHERE map_id=%s"
      if name=='map_on':
        sql = "UPDATE maps SET map_on=%s WHERE map_id=%s"
      if name=='font_size':
        sql = "UPDATE maps SET font_size=%s WHERE map_id=%s"
      if name=='font_color':
        sql = "UPDATE maps SET font_color=%s WHERE map_id=%s"
      if name=='display_name':
        sql = "UPDATE maps SET display_name=%s WHERE map_id=%s"
      if name=='background_low':
        sql = "UPDATE maps SET background_low=%s WHERE map_id=%s"
      if name=='background_high':
        sql = "UPDATE maps SET background_high=%s WHERE map_id=%s"
      if name=='background_color':
        sql = "UPDATE maps SET background_color=%s WHERE map_id=%s"
      data = (value,id,)
      m.execute(sql, data)
      m.connection.commit()
      m.close()
    if request.form.get('send-default') == 'yes':
      id = request.form['id']
      m = mysql.connection.cursor()
      sql = "UPDATE maps SET map_on='on', transparent_bkg='', control_on_map='', display_name='', background_color='', background_low='', background_high='', font_color='', font_size='', icon='' WHERE map_id=%s"
      data = [id,]
      m.execute(sql, data)
      m.connection.commit()
      m.close()
    

  data = queryselectsensors()
  return render_template('map_settings.html', nt_settings=dict(nt_settings()), data=data)
  
