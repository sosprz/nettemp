from app import app
from flask import Flask, request
import sqlite3
import json
from flask_login import login_required
from flask_mysqldb import MySQL
mysql = MySQL()


@app.route('/data/charts/', methods=['GET', 'POST'])
@login_required
def data_charts():
  max = request.args.get("max")
  name = request.args.get("name")
  type = request.args.get("type")
  mode = request.args.get("mode")
  datetime = request.args.get("datetime")

  def mysql_query_datetime(rom, max, datetime):
    if max == '15min':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time BETWEEN '{}' and DATE_SUB('{}', INTERVAL -15 MINUTE))".format(rom,datetime,datetime)
    if max == 'hour':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time BETWEEN '{}' and DATE_SUB('{}', INTERVAL -1 HOUR))".format(rom,datetime,datetime)
    if max == 'week':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time BETWEEN '{}' and DATE_SUB('{}', INTERVAL -1 WEEK))".format(rom,datetime,datetime)
    if max == 'month':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time BETWEEN '{}' and DATE_SUB('{}', INTERVAL -1 MONTH))".format(rom,datetime,datetime)
    if max == '6months':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time BETWEEN '{}' and DATE_SUB('{}', INTERVAL -6 MONTH))".format(rom,datetime,datetime)
    if max == 'year':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time BETWEEN '{}' and DATE_SUB('{}', INTERVAL -1 YEAR))".format(rom,datetime,datetime)
    if max == 'all':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time BETWEEN '{}' and DATE_SUB('{}', INTERVAL -1 YEAR))".format(rom,datetime,datetime)
    return sql

  def query_datetime(max):
    if max == '15min':
      sql = "select strftime('%s', time),value from def WHERE datetime(time, 'localtime') BETWEEN datetime(?, 'localtime', '-15 minutes') AND datetime(?, 'localtime', '+15 minutes' )"
    if max == 'hour':
      sql = "select strftime('%s', time),value from def WHERE datetime(time, 'localtime') BETWEEN datetime(?, 'localtime', '-1 hour') AND datetime(?, 'localtime', '+1 hour' )"
    if max == 'day':
      sql = "select strftime('%s', time),value from def WHERE datetime(time, 'localtime') BETWEEN datetime(?, 'localtime', '-1 day') AND datetime(?, 'localtime', '+1 day' )"
    if max == 'week':
      sql = "select strftime('%s', time),value from def WHERE datetime(time, 'localtime') BETWEEN datetime(?, 'localtime', '-7 day') AND datetime(?, 'localtime', '+7 day' )"
    if max == 'month':
      sql = "select strftime('%s', time),value from def WHERE datetime(time, 'localtime') BETWEEN datetime(?, 'localtime', '-1 months') AND datetime(?, 'localtime', '+1 months ' )"
    if max == 'months':
      sql = "select strftime('%s', time),value from def WHERE datetime(time, 'localtime') BETWEEN datetime(?, 'localtime', '-6 months') AND datetime(?, 'localtime', '+6 months ' )"
    if max == 'year':
      sql = "select strftime('%s', time),value from def WHERE datetime(time, 'localtime') BETWEEN datetime(?, 'localtime', '-1 year') AND datetime(?, 'localtime', '+1 year ' )"
    if max == 'all':
      sql = "select strftime('%s', time),value from def WHERE datetime(time, 'localtime') BETWEEN datetime(?, 'localtime', '-1 year') AND datetime(?, 'localtime', '+1 year ' )"
    return sql

  def mysql_query(rom, max):
    if max == '15min':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 15 MINUTE))".format(rom)
    if max == 'hour':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 1 HOUR))".format(rom)
    if max == 'day':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 24 HOUR))".format(rom)
    if max == 'week':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 1 WEEK))".format(rom)
    if max == 'month':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 1 MONTH))".format(rom)
    if max == '6months':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 6 MONTH))".format(rom)
    if max == 'year':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 1 YEAR))".format(rom)
    if max == 'all':
      sql = "select UNIX_TIMESTAMP(time),value from {}".format(rom)      
    return sql


  def query(max):
   if max == '15min':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-15 minutes')"
   if max == 'hour':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 hour')"
   if max == 'day':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 day')"
   if max == 'week':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-7 day')"
   if max == 'month':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 months')"
   if max == '6months':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-6 months')"
   if max == 'year':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 year')"
   if max == 'all':
     sql = "select strftime('%s', time),value from def"
   return sql

  def mysql_querymod(rom, max):
    if max == '15min':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 15 MINUTE))".format(rom)
    if max == 'hour':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 1 HOUR))".format(rom)
    if max == 'day':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 24 HOUR)) AND id % 60=0".format(rom)
    if max == 'week':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 1 WEEK)) AND id % 240=0".format(rom)
    if max == 'month':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 1 MONTH)) AND id % 1440=0".format(rom)
    if max == '6months':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 6 MONTH)) AND id % 1440=0".format(rom)
    if max == 'year':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE (time > DATE_SUB(now(), INTERVAL 1 YEAR)) AND id % 10080=0".format(rom)
    if max == 'all':
      sql = "select UNIX_TIMESTAMP(time),value from {} WHERE id % 10080=0".format(rom)      
    return sql

  def querymod(max):
   if max == '15min':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-15 minutes')"
   if max == 'hour':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 hour')"
   if max == 'day':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 day') AND rowid % 60=0"
   if max == 'week':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-7 day') AND rowid % 240=0"
   if max == 'month':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 months') AND rowid % 1440=0"
   if max == '6months':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-6 months')  AND rowid % 1440=0"
   if max == 'year':
     sql = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 year') AND rowid % 10080=0"
   if max == 'all':
     sql = "select strftime('%s', time),value from def WHERE rowid % 10080=0"
   return sql


  m = mysql.connection.cursor()
  data = [str(name)]
  name = str(name)
  sql = "SELECT rom FROM sensors WHERE name=%s AND charts='on'"
  m.execute(sql, (name,))
  rom = m.fetchone()[0]
  sql = "SELECT value FROM nt_settings WHERE option='quick_charts'"
  m.execute(sql) 
  quick_charts = m.fetchone()[0]

  sql = "SELECT value FROM nt_settings WHERE option='mysql_charts'"
  m.execute(sql) 
  mysql_charts = m.fetchone()[0]

  m.close();


  if mysql_charts=='on':
    #remember this is for mysql
    rom = 'db_'+rom
    m = mysql.connection.cursor()

    if mode=='datetime':
      sql = mysql_query_datetime(rom, max, datetime)
    else:
      if quick_charts=='on':
        sql = mysql_querymod(rom, max)
      else:
        sql = mysql_query(rom, max)
    m.execute(sql)

    data = [[int(i[0])*1000,i[1]] for i in m.fetchall()]
    m.close();

  else:
    # sqlite
    rom = rom+'.sql'
    conn = sqlite3.connect(app.romdir+rom)
    c = conn.cursor()

    if mode=='datetime':
      c.execute(query_datetime(max),(datetime,datetime))
    else:
      if quick_charts=='on':
        c.execute(querymod(max))
      else:
        c.execute(query(max))

    data = [[int(i[0])*1000,i[1]] for i in c.fetchall()]
    conn.close()

  
  
  
  
  return json.dumps(data)

