from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
from flask_mysqldb import MySQL
mysql = MySQL()

get_type = ''
get_group = ''
get_id = ''

def select_sensors(get_type, get_group, get_id):
  m = mysql.connection.cursor()
  if get_type:
    print (get_type)
    sql = ''' SELECT sensors.id, sensors.time, sensors.tmp, sensors.name, sensors.rom, 
                sensors.tmp_min, sensors.tmp_max, sensors.alarm, sensors.type, sensors.charts, 
                sensors.ch_group, sensors.minmax, sensors.fiveago, sensors.map_id, maps.map_on, sensors.email, sensors.email_delay, sensors.node, sensors.adj, sensors.email_status, sensors.ip, sensors.nodata_time FROM sensors INNER JOIN maps ON sensors.map_id = maps.map_id WHERE sensors.type=%s '''
    m.execute(sql, [get_type])
  elif get_group:
    sql = ''' SELECT sensors.id, sensors.time, sensors.tmp, sensors.name, sensors.rom, 
                sensors.tmp_min, sensors.tmp_max, sensors.alarm, sensors.type, sensors.charts, 
                sensors.ch_group, sensors.minmax, sensors.fiveago, sensors.map_id, maps.map_on, sensors.email, sensors.email_delay, sensors.node, sensors.adj, sensors.email_status, sensors.ip, sensors.nodata_time FROM sensors INNER JOIN maps ON sensors.map_id = maps.map_id WHERE sensors.ch_group=%s '''
    m.execute(sql, [get_group])
  elif get_id:
    sql = ''' SELECT sensors.id, sensors.time, sensors.tmp, sensors.name, sensors.rom, 
                sensors.tmp_min, sensors.tmp_max, sensors.alarm, sensors.type, sensors.charts, 
                sensors.ch_group, sensors.minmax, sensors.fiveago, sensors.map_id, maps.map_on, sensors.email, sensors.email_delay, sensors.node, sensors.adj, sensors.email_status, sensors.ip, sensors.nodata_time FROM sensors INNER JOIN maps ON sensors.map_id = maps.map_id WHERE sensors.id=%s '''
    m.execute(sql, [get_id])
  else:
    sql = ''' SELECT sensors.id, sensors.time, sensors.tmp, sensors.name, sensors.rom, 
                sensors.tmp_min, sensors.tmp_max, sensors.alarm, sensors.type, sensors.charts, 
                sensors.ch_group, sensors.minmax, sensors.fiveago, sensors.map_id, maps.map_on, sensors.email, sensors.email_delay, sensors.node, sensors.adj, sensors.email_status, sensors.ip, sensors.nodata_time FROM sensors INNER JOIN maps ON sensors.map_id = maps.map_id ORDER BY id ASC '''
    m.execute(sql)
  data = m.fetchall()  
  m.close()
  return data

def select_group():
  m = mysql.connection.cursor()
  sql = "SELECT DISTINCT ch_group FROM sensors"
  m.execute(sql)
  data = m.fetchall()
  m.close()
  return data

def select_type():
  m = mysql.connection.cursor()
  sql = "SELECT DISTINCT type FROM sensors"
  m.execute(sql)
  data = m.fetchall()  
  m.close()
  return data

@app.route('/settings/sensors', methods=['GET','POST'])
@login_required
def settings_sensors():
    get_type = request.args.get("type")
    get_group = request.args.get("group")
    get_id = request.args.get("id")

    if request.method == "POST":
      if request.form.get('send-node') == 'yes':
        node = request.form['node']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET node=%s WHERE id=%s"
        m.execute(sql, (node,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-adj') == 'yes':
        adj = request.form['adj']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql="UPDATE sensors SET adj=%s WHERE id=%s"
        m.execute(sql, (adj,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-nodata_time') == 'yes':
        nodata_time = request.form['nodata_time']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET nodata_time=%s WHERE id=%s"
        m.execute(sql, (nodata_time,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-name') == 'yes':
        name = request.form['name']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql= "UPDATE sensors SET name=%s WHERE id=%s"
        m.execute(sql, (name,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-map') == 'yes':
        map_on = request.form['map_on']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE maps SET map_on=%s WHERE map_id=%s"
        m.execute(sql , (map_on,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-charts') == 'yes':
        charts = request.form['charts']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET charts=%s WHERE id=%s"
        m.execute(sql, (charts,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-group') == 'yes':
        group = request.form['group']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET ch_group=%s WHERE id=%s"
        m.execute(sql, (group,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-alarm-min') == 'yes':
        tmp_min = request.form['tmp_min']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET tmp_min=%s WHERE id=%s"
        m.execute(sql, (tmp_min,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-alarm-max') == 'yes':
        tmp_max = request.form['tmp_max']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET tmp_max=%s WHERE id=%s"
        m.execute(sql, (tmp_max,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-selectgroup') == 'yes':
        selectgroup = request.form['selectgroup']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET ch_group=%s WHERE id=%s"
        m.execute(sql, (selectgroup,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-status-minmax') == 'yes':
        minmax = request.form['minmax']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET minmax=%s WHERE id=%s"
        m.execute(sql, (minmax,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-fiveago') == 'yes':
        fiveago = request.form['fiveago']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET fiveago=%s WHERE id=%s"
        m.execute(sql, (fiveago,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-email-delay') == 'yes':
        email_delay = request.form['email_delay']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET email_delay=%s WHERE id=%s"
        m.execute(sql, (email_delay,id,))
        m.connection.commit()
        m.close()


      ### multi


      if request.form.get('rem-all') == 'yes':
        m = mysql.connection.cursor()
        if get_type:
          sql = "DELETE FROM sensors WHERE type=%s"
          m.execute(sql, [get_type])
        elif get_group:
          sql = "DELETE FROM sensors WHERE ch_group=%s"
          m.execute(sql, [get_group])
        else:
          sql = "DELETE FROM sensors"
          m.execute(sql)
        m.connection.commit()
        m.close()

      if request.form.get('send-email') == 'yes':
        email = request.form['email']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET email=%s WHERE id=%s"
        m.execute(sql, (email,id,))
        if email == 'off':
          sql = "UPDATE sensors SET email_status='', email_time='' WHERE id=%s"
          m.execute(sql, (id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-alarm') == 'yes':
        alarm = request.form['alarm']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET alarm=%s WHERE id=%s"
        m.execute(sql, (alarm,id,))
        if alarm == 'off':
          sql = "UPDATE sensors SET alarm_status='', alarm_recovery_time='' WHERE id=%s"
          m.execute(sql, (id,))
          sql = "UPDATE sensors SET email='' WHERE id=%s"
          m.execute(sql, (id,))
          sql = "UPDATE sensors SET email_status='', email_time='' WHERE id=%s"
          m.execute(sql, (id,))
        m.connection.commit()
        m.close()


      if request.form.get('send-del') == 'yes':
        rom = request.form['rom']
        id = request.form['id']
        map_id = request.form['map_id']
        m = mysql.connection.cursor()
        sql="DELETE FROM sensors WHERE id=%s AND rom=%s"
        m.execute(sql,(id,rom,))
        sql="DELETE FROM maps WHERE map_id=%s"
        m.execute(sql,(map_id,))
        m.connection.commit()
        m.close()
        print ("Sensor %s removed ok" %rom)


      if request.form.get('add-all-map') == 'yes':
        function = request.form['function']
        m = mysql.connection.cursor()
        if get_type:
          sql = "UPDATE maps SET %s='on' WHERE type=%s" % function
          m.execute(sql, [get_type])
        else:
          sql = "UPDATE maps SET %s='on'" % function
          m.execute(sql)
        m.connection.commit()
        m.close()

      if request.form.get('del-all-map') == 'yes':
        function = request.form['function']
        m = mysql.connection.cursor()
        if get_type:
          sql = "UPDATE maps SET %s='' WHERE type=%s" % function
          m.execute(sql, [get_type])
        else:
          sql = "UPDATE maps SET %s=''" % function
          m.execute(sql)
        m.connection.commit()
        m.close()

      if request.form.get('send-copy') == 'yes':
        v = request.form['v']
        f = request.form['f']
        m = mysql.connection.cursor()
        if get_type:
          if f=='tmp_min':
            sql = "UPDATE sensors SET tmp_min=%s WHERE type=%s"
          if f=='tmp_max':
            sql = "UPDATE sensors SET tmp_max=%s WHERE type=%s"
          if f=='email_delay':
            sql = "UPDATE sensors SET email_delay=%s WHERE type=%s"
          if f=='adj':
            sql = "UPDATE sensors SET adj=%s WHERE type=%s"
          if f=='nodata_time':
            sql = "UPDATE sensors SET nodata_time=%s WHERE type=%s"
          if f=='node':
            sql = "UPDATE sensors SET node=%s WHERE type=%s"
          if f=='map_on':
            sql = "UPDATE sensors SET map_on=%s WHERE type=%s"
          if f=='charts':
            sql = "UPDATE sensors SET charts=%s WHERE type=%s"
          if f=='fiveago':
            sql = "UPDATE sensors SET fiveago=%s WHERE type=%s"
          if f=='minmax':
            sql = "UPDATE sensors SET minmax=%s WHERE type=%s"
          if f=='email':
            sql = "UPDATE sensors SET email=%s WHERE type=%s"
          m.execute(sql,(v,get_type))
        elif get_group:
          if f=='tmp_min':
            sql = "UPDATE sensors SET tmp_min=%s WHERE ch_group=%s"
          if f=='tmp_max':
            sql = "UPDATE sensors SET tmp_max=%s WHERE ch_group=%s"
          if f=='email_delay':
            sql = "UPDATE sensors SET email_delay=%s WHERE ch_group=%s"
          if f=='adj':
            sql = "UPDATE sensors SET adj=%s WHERE ch_group=%s"
          if f=='nodata_time':
            sql = "UPDATE sensors SET nodata_time=%s WHERE ch_group=%s"
          if f=='node':
            sql = "UPDATE sensors SET node=%s WHERE ch_group=%s"
          if f=='map_on':
            sql = "UPDATE sensors SET map_on=%s WHERE ch_group=%s"
          if f=='charts':
            sql = "UPDATE sensors SET charts=%s WHERE ch_group=%s"
          if f=='fiveago':
            sql = "UPDATE sensors SET fiveago=%s WHERE ch_group=%s"
          if f=='minmax':
            sql = "UPDATE sensors SET minmax=%s WHERE ch_group=%s"
          m.execute(sql,(v,get_group))
        else:
          if f=='tmp_min':
            sql = "UPDATE sensors SET tmp_min=%s"
          if f=='tmp_max':
            sql = "UPDATE sensors SET tmp_max=%s"
          if f=='email_delay':
            sql = "UPDATE sensors SET email_delay=%s"
          if f=='adj':
            sql = "UPDATE sensors SET adj=%s"
          if f=='nodata_time':
            sql = "UPDATE sensors SET nodata_time=%s"
          if f=='node':
            sql = "UPDATE sensors SET node=%s"
          if f=='map_on':
            sql = "UPDATE sensors SET map_on=%s"
          if f=='minmax':
            sql = "UPDATE sensors SET minmax=%s"
          if f=='charts':
            sql = "UPDATE sensors SET charts=%s"
          if f=='fiveago':
            sql = "UPDATE sensors SET fiveago=%s"
          m.execute(sql,(v,))
        m.connection.commit()
        m.close()

    type = select_type()
    data = select_sensors(get_type, get_group, get_id)
    group = select_group()
    return render_template('sensor_settings.html', data=data, group=group, type=type, get_id=get_id, get_group=get_group, get_type=get_type)
