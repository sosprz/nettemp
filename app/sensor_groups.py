from app import app
from flask import Flask, render_template, request, jsonify
import sqlite3
from flask_login import login_required
import datetime
from datetime import timedelta


def check_time(last_time):
  fmt = '%Y-%m-%d %H:%M:%S'
  now = datetime.datetime.now()
  now = now.strftime("%Y-%m-%d %H:%M:%S")
  tstamp2 = datetime.datetime.strptime(now, fmt)
  tstamp1 = datetime.datetime.strptime(last_time, fmt)
  if tstamp1 > tstamp2:
    td = tstamp1 - tstamp2
  else:
    td = tstamp2 - tstamp1
    td_mins = int(round(td.total_seconds() / 60))
    if td_mins > 5:
      out='nodata'
    else:
      out='ok'
  return (out)

@app.route('/')
@login_required
def index():
  conn = sqlite3.connect(app.db)
  c = conn.cursor()
  c.execute("select sensors.id, sensors.name, sensors.tmp, types.unit, types.unit2, types.ico, types.title, sensors.type, sensors.ch_group, sensors.tmp_5ago, sensors.stat_min, sensors.stat_max, sensors.tmp_min, sensors.tmp_max, sensors.alarm, sensors.time, sensors.minmax, sensors.charts, sensors.fiveago, sensors.stat_min_time, sensors.stat_max_time, sensors.email, sensors.nodata FROM sensors INNER JOIN types ON sensors.type = types.type  WHERE ch_group!='none' ")
  sensors = c.fetchall()
  c.execute("select DISTINCT sensors.ch_group FROM sensors WHERE sensors.ch_group!='none'")
  ch_group = c.fetchall()
  conn.close()
  return render_template('sensor_groups.html', sensors=sensors, ch_group=ch_group)
