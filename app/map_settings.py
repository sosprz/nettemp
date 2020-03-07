# -*- coding: utf-8 -*-
from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
from app.nettemp import nt_settings

def queryselectsensors():
  conn = sqlite3.connect(app.db)
  c = conn.cursor()
  c.execute(''' SELECT maps.map_id, sensors.name, maps.map_on, maps.display_name, maps.transparent_bkg, maps.background_color, maps.background_low, maps.background_high, maps.font_color, maps.font_size FROM sensors INNER JOIN maps ON sensors.map_id = maps.map_id ''')
  data = c.fetchall()  
  conn.close()
  return data


@app.route('/settings/map/settings', methods=['GET','POST'])
@login_required
def settings_map():
  if request.method == "POST":
    if request.form.get('send-map-image') == 'yes':
      map_height = request.form['map_height']
      map_width = request.form['map_width']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("UPDATE nt_settings SET value=? WHERE option='map_width'", (map_width,))
      c.execute("UPDATE nt_settings SET value=? WHERE option='map_height'", (map_height,))
      conn.commit()
      conn.close()
    if request.form.get('send') == 'yes':
      name = request.form['name']
      value = request.form['value']
      id = request.form['id']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      sql = "UPDATE maps SET %s=? WHERE map_id=?" % name 
      data = [value,id,]
      c.execute(sql, data)
      conn.commit()
      conn.close()
    if request.form.get('send-default') == 'yes':
      id = request.form['id']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      sql = "UPDATE maps SET map_on='on', transparent='', control_on_map='', display_name='', background_color='', background_low='', background_high='', font_color='', font_size='', icon='' WHERE map_id=?"
      data = [id,]
      c.execute(sql, data)
      conn.commit()
      conn.close()
    

  data = queryselectsensors()
  return render_template('map_settings.html', nt_settings=dict(nt_settings()), data=data)
  
