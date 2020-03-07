from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
import json
import os
from flask_login import login_required
from app.nettemp import nt_settings

@app.route('/map', methods=['GET', 'POST'])
@login_required
def map():

  if request.method == "POST":
    if request.form.get('send-map') == 'yes':
      map_id = request.form['map_id']
      pos_x = request.form['pos_x']
      pos_y = request.form['pos_y']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("UPDATE maps SET pos_x=?, pos_y=? WHERE map_id=?", (pos_x,pos_y,map_id,))
      conn.commit()
      conn.close()

  conn = sqlite3.connect(app.db)
  conn.row_factory = sqlite3.Row
  c = conn.cursor()
  c.execute("select sensors.name, sensors.tmp, types.unit, types.unit2, types.ico, types.title, \
             sensors.type, sensors.alarm, sensors.time, maps.map_id, maps.background_color, \
             maps.display_name, maps.font_color, maps.transparent_bkg, sensors.tmp_min, sensors.tmp_max, \
             maps.background_low, maps.background_high, maps.font_size \
             FROM sensors INNER JOIN types ON sensors.type = types.type INNER JOIN maps ON sensors.map_id = maps.map_id  WHERE maps.map_on='on' ")
  sensors = c.fetchall()
  c.execute("select maps.map_id, maps.pos_x, maps.pos_y FROM sensors INNER JOIN maps ON sensors.map_id = maps.map_id WHERE maps.map_on='on'")
  group = c.fetchall()
  conn.close()

  if os.path.exists('data/upload/map.jpg'):
   mapimage = 'new'
  else:
   mapimage = None

  return render_template('map.html', sensors=sensors, group=json.dumps( [dict(ix) for ix in group]), nt_settings=dict(nt_settings()), mapimage=mapimage)


