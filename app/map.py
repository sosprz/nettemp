from app import app
from flask import Flask, request, jsonify, render_template
import json, os
from flask_login import login_required
from app.nettemp import nt_settings
from flask_mysqldb import MySQL
mysql = MySQL()


@app.route('/map', methods=['GET', 'POST'])
@login_required
def map():

  if request.method == "POST":
    if request.form.get('send-map') == 'yes':
      map_id = request.form['map_id']
      pos_x = request.form['pos_x']
      pos_y = request.form['pos_y']
      m = mysql.connection.cursor()
      sql = "UPDATE maps SET pos_x=%s, pos_y=%s WHERE map_id=%s"
      m.execute(sql, (pos_x,pos_y,map_id,))
      m.connection.commit()
      m.close()
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
      print(map_height)
      print(map_width)

  m = mysql.connection.cursor()
  sql = "select sensors.name, sensors.tmp, types.unit, types.unit2, types.ico, types.title, \
             sensors.type, sensors.alarm, sensors.time, maps.map_id, maps.background_color, \
             maps.display_name, maps.font_color, maps.transparent_bkg, sensors.tmp_min, sensors.tmp_max, \
             maps.background_low, maps.background_high, maps.font_size \
             FROM sensors INNER JOIN types ON sensors.type = types.type INNER JOIN maps ON sensors.map_id = maps.map_id  WHERE maps.map_on='on' "
  m.execute(sql)
  sensors = m.fetchall()
  sql = "select maps.map_id, maps.pos_x, maps.pos_y FROM sensors INNER JOIN maps ON sensors.map_id = maps.map_id WHERE maps.map_on='on'"
  m.execute(sql)
  row_headers=[x[0] for x in m.description]
  group = m.fetchall()
  m.close()
  json_data=[]
  for result in group:
    json_data.append(dict(zip(row_headers,result)))

  if os.path.exists('data/upload/map.jpg'):
   mapimage = 'new'
  else:
   mapimage = None
  print(group)
  return render_template('map.html', sensors=sensors, group=json.dumps(json_data), nt_settings=dict(nt_settings()), mapimage=mapimage)


