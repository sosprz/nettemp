from app import app
from flask import Flask, render_template, request, jsonify
from flask_login import login_required
import datetime
from datetime import timedelta
from flask_mysqldb import MySQL
mysql = MySQL()

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

@app.route('/', methods=['GET', 'POST'])
@login_required
def index():
  if request.method == "POST":
    m = mysql.connection.cursor()
    data=[]
    data=request.form
    sid=1
    for id in data:
      sql = "UPDATE sensors SET sid=%s WHERE id=%s"
      data = (sid,id,)
      m.execute(sql, data)
      sid+=1
    m.connection.commit()
    m.close()

  m = mysql.connection.cursor()
  sql = "select sensors.id, sensors.name, sensors.tmp, types.unit, types.unit2, types.ico, types.title, sensors.type, sensors.ch_group, sensors.tmp_5ago, sensors.stat_min, sensors.stat_max, sensors.tmp_min, sensors.tmp_max, sensors.alarm, sensors.time, sensors.minmax, sensors.charts, sensors.fiveago, sensors.stat_min_time, sensors.stat_max_time, sensors.email, sensors.nodata, sensors.nodata_time FROM sensors INNER JOIN types ON sensors.type = types.type  WHERE ch_group!='none' ORDER BY sid ASC"
  m.execute(sql)
  sensors = m.fetchall()
  sql = "select DISTINCT sensors.ch_group FROM sensors WHERE sensors.ch_group!='none'"
  m.execute(sql)
  ch_group = m.fetchall()
  m.close()
  return render_template('sensor_groups.html', sensors=sensors, ch_group=ch_group)
