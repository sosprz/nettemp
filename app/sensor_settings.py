from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required

get_type = ''
get_group = ''

def select_sensors(get_type, get_group):
  conn = sqlite3.connect(app.db)
  c = conn.cursor()
  if get_type:
    print (get_type)
    sql = ''' SELECT sensors.id, sensors.time, sensors.tmp, sensors.name, sensors.rom, 
                sensors.tmp_min, sensors.tmp_max, sensors.alarm, sensors.type, sensors.charts, 
                sensors.ch_group, sensors.minmax, sensors.fiveago, sensors.map_id, maps.map_on, sensors.email, sensors.email_delay, sensors.node FROM sensors INNER JOIN maps ON sensors.map_id = maps.map_id WHERE sensors.type=? '''
    c.execute(sql, [get_type])
  elif get_group:
    sql = ''' SELECT sensors.id, sensors.time, sensors.tmp, sensors.name, sensors.rom, 
                sensors.tmp_min, sensors.tmp_max, sensors.alarm, sensors.type, sensors.charts, 
                sensors.ch_group, sensors.minmax, sensors.fiveago, sensors.map_id, maps.map_on, sensors.email, sensors.email_delay, sensors.node FROM sensors INNER JOIN maps ON sensors.map_id = maps.map_id WHERE sensors.ch_group=? '''
    c.execute(sql, [get_group])
  else:
    sql = ''' SELECT sensors.id, sensors.time, sensors.tmp, sensors.name, sensors.rom, 
                sensors.tmp_min, sensors.tmp_max, sensors.alarm, sensors.type, sensors.charts, 
                sensors.ch_group, sensors.minmax, sensors.fiveago, sensors.map_id, maps.map_on, sensors.email, sensors.email_delay, sensors.node FROM sensors INNER JOIN maps ON sensors.map_id = maps.map_id '''
    c.execute(sql)
  data = c.fetchall()  
  conn.close()
  return data

def select_group():
  conn = sqlite3.connect(app.db)
  c = conn.cursor()
  c.execute("SELECT DISTINCT ch_group FROM sensors")
  data = c.fetchall()  
  conn.close()
  return data

def select_type():
  conn = sqlite3.connect(app.db)
  c = conn.cursor()
  c.execute("SELECT DISTINCT type FROM sensors")
  data = c.fetchall()  
  conn.close()
  return data

@app.route('/settings/sensors', methods=['GET','POST'])
@login_required
def settings_sensors():
    get_type = request.args.get("type")
    get_group = request.args.get("group")

    if request.method == "POST":
      if request.form.get('send-node') == 'yes':
        node = request.form['node']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET node=? WHERE id=?", (node,id,))
        conn.commit()
        conn.close()

      if request.form.get('rem-all') == 'yes':
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        if get_type:
          sql = "DELETE FROM sensors WHERE type=?"
          c.execute(sql, [get_type])
        elif get_group:
          sql = "DELETE FROM sensors WHERE ch_group=?"
          c.execute(sql, [get_group])
        else:
          c.execute("DELETE FROM sensors")
        conn.commit()
        conn.close()

      if request.form.get('send-name') == 'yes':
        name = request.form['name']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET name=? WHERE id=?", (name,id,))
        conn.commit()
        conn.close()
      if request.form.get('send-email') == 'yes':
        email = request.form['email']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET email=? WHERE id=?", (email,id,))
        if email == 'off':
          c.execute("UPDATE sensors SET email_status='', email_time='' WHERE id=?", (id,))
        conn.commit()
        conn.close()
      if request.form.get('send-alarm') == 'yes':
        alarm = request.form['alarm']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET alarm=? WHERE id=?", (alarm,id,))
        if alarm == 'off':
          c.execute("UPDATE sensors SET alarm_status='', alarm_recovery_time='' WHERE id=?", (id,))
          c.execute("UPDATE sensors SET email='' WHERE id=?", (id,))
          c.execute("UPDATE sensors SET email_status='', email_time='' WHERE id=?", (id,))
        conn.commit()
        conn.close()
      if request.form.get('send-map') == 'yes':
        map_on = request.form['map_on']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE maps SET map_on=? WHERE map_id=?", (map_on,id,))
        conn.commit()
        conn.close()
      if request.form.get('send-charts') == 'yes':
        charts = request.form['charts']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET charts=? WHERE id=?", (charts,id,))
        conn.commit()
        conn.close()
      if request.form.get('send-group') == 'yes':
        group = request.form['group']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET ch_group=? WHERE id=?", (group,id,))
        conn.commit()
        conn.close()
      if request.form.get('send-alarm-min') == 'yes':
        tmp_min = request.form['tmp_min']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET tmp_min=? WHERE id=?", (tmp_min,id,))
        conn.commit()
        conn.close()
      if request.form.get('send-alarm-max') == 'yes':
        tmp_max = request.form['tmp_max']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET tmp_max=? WHERE id=?", (tmp_max,id,))
        conn.commit()
        conn.close()
    
      if request.form.get('send-selectgroup') == 'yes':
        selectgroup = request.form['selectgroup']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c  = conn.cursor()
        c.execute("UPDATE sensors SET ch_group=? WHERE id=?", (selectgroup,id,))
        conn.commit()
        conn.close()
      if request.form.get('send-status-minmax') == 'yes':
        minmax = request.form['minmax']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET minmax=? WHERE id=?", (minmax,id,))
        conn.commit()
        conn.close()
      if request.form.get('send-fiveago') == 'yes':
        fiveago = request.form['fiveago']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET fiveago=? WHERE id=?", (fiveago,id,))
        conn.commit()
        conn.close()
      if request.form.get('send-email-delay') == 'yes':
        email_delay = request.form['email_delay']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET email_delay=? WHERE id=?", (email_delay,id,))
        conn.commit()
        conn.close()
      if request.form.get('send-del') == 'yes':
        rom = request.form['rom']
        id = request.form['id']
        map_id = request.form['map_id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("DELETE FROM sensors WHERE id=? AND rom=?", (id,rom,))
        c.execute("DELETE FROM maps WHERE map_id=? ", (map_id,))
        conn.commit()
        conn.close()
        print ("Sensor %s removed ok" %rom)

      if request.form.get('add-all') == 'yes':
        function = request.form['function']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        if get_type:
          sql = "UPDATE sensors SET %s='on' WHERE type=?" % function
          c.execute(sql, [get_type])
        elif get_group:
          sql = "UPDATE sensors SET %s='on' WHERE ch_group=?" % function
          c.execute(sql, [get_group])
        else:
          sql = "UPDATE sensors SET %s='on'" % function
          c.execute(sql)
        conn.commit()
        conn.close()

      if request.form.get('del-all') == 'yes':
        function = request.form['function']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        if get_type:
          sql = "UPDATE sensors SET %s='' WHERE type=?" % function
          c.execute(sql, [get_type])
        elif get_group:
          sql = "UPDATE sensors SET %s='' WHERE ch_group=?" % function
          c.execute(sql, [get_group])
        else:
          sql = "UPDATE sensors SET %s=''" % function
          c.execute(sql)
        conn.commit()
        conn.close()

      if request.form.get('add-all-map') == 'yes':
        function = request.form['function']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        if get_type:
          sql = "UPDATE maps SET %s='on' WHERE type=?" % function
          c.execute(sql, [get_type])
        else:
          sql = "UPDATE maps SET %s='on'" % function
          c.execute(sql)
        conn.commit()
        conn.close()

      if request.form.get('del-all-map') == 'yes':
        function = request.form['function']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        if get_type:
          sql = "UPDATE maps SET %s='' WHERE type=?" % function
          c.execute(sql, [get_type])
        else:
          sql = "UPDATE maps SET %s=''" % function
          c.execute(sql)
        conn.commit()
        conn.close()
    
    
    type = select_type()
    data = select_sensors(get_type, get_group)
    group = select_group()
    return render_template('sensor_settings.html', data=data, group=group, type=type)
