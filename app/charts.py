from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
from app.nettemp import nt_settings

@app.route('/charts', methods=['GET', 'POST'])
@login_required
def charts():
  conn = sqlite3.connect(app.db)

  max = request.args.get("max")
  single = request.args.get("single")
  group = request.args.get("group")
  type = request.args.get("type")
  datetime = request.args.get("datetime")
  mode = request.args.get("mode")

  if group:
   c = conn.cursor()
   c.execute("select name FROM sensors WHERE ch_group=? AND charts='on'", (group,))
   names = c.fetchall()
  elif single:
   c = conn.cursor()
   c.execute("select name FROM sensors WHERE name=? AND charts='on'", (single,))
   names = c.fetchall()
  else:
   c = conn.cursor()
   c.execute("select name FROM sensors WHERE type=? AND charts='on'", (type,))
   names = c.fetchall()

  c.execute(''' select DISTINCT type FROM sensors WHERE charts='on' ''')
  types = c.fetchall()

  c.execute(''' select DISTINCT ch_group FROM sensors WHERE charts='on' AND ch_group!='none' ''')
  groups = c.fetchall()
  
  c.execute(''' select DISTINCT type, unit FROM types ''')
  units = c.fetchall()
  conn.close()

  names = [i[0] for i in names]
  names = list(set(names))

  groups = [i[0] for i in groups]
  groups = list(set(groups))

  groupmax = ['15min', 'hour', 'day', 'week', 'month', '6month', 'year', 'all']

  return render_template('highcharts.html', groups=groups, types=types, max=max, single=single, type=type, names=names, groupmax=groupmax, group=group, units=units, mode=mode, datetime=datetime, nt_settings=dict(nt_settings()))
