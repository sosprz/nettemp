from app import app
from flask import Flask, request, jsonify, render_template
from flask_login import login_required
from app.nettemp import nt_settings
from flask_mysqldb import MySQL
mysql = MySQL()

@app.route('/charts', methods=['GET', 'POST'])
@login_required
def charts():

  max = request.args.get("max")
  single = request.args.get("single")
  group = request.args.get("group")
  type = request.args.get("type")
  datetime = request.args.get("datetime")
  mode = request.args.get("mode")

  if group:
   m = mysql.connection.cursor()
   m.execute("select name FROM sensors WHERE ch_group=%s AND charts='on'", (group,))
   names = m.fetchall()
  elif single:
   m = mysql.connection.cursor()
   m.execute("select name FROM sensors WHERE name=%s AND charts='on'", (single,))
   names = m.fetchall()
  else:
   m = mysql.connection.cursor()
   m.execute("select name FROM sensors WHERE type=%s AND charts='on'", (type,))
   names = m.fetchall()

  m.execute(''' select DISTINCT type FROM sensors WHERE charts='on' ''')
  types = m.fetchall()

  m.execute(''' select DISTINCT ch_group FROM sensors WHERE charts='on' AND ch_group!='none' ''')
  groups = m.fetchall()
  
  m.execute(''' select DISTINCT type, unit FROM types ''')
  units = m.fetchall()

  m.close()

  names = [i[0] for i in names]
  names = list(set(names))

  groups = [i[0] for i in groups]
  groups = list(set(groups))

  groupmax = ['15min', 'hour', 'day', 'week', 'month', '6month', 'year', 'all']

  return render_template('highcharts.html', groups=groups, types=types, max=max, single=single, type=type, names=names, groupmax=groupmax, group=group, units=units, mode=mode, datetime=datetime, nt_settings=dict(nt_settings()))
