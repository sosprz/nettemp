from flask import Flask, request
import os
app = Flask(__name__)

app.config.from_pyfile('../data/config.cfg')
app.db = app.config["DB"]
app.romdir = app.config["ROMDIR"]
app.dba = app.config["DBA"]

import configparser, os
from flask_mysqldb import MySQL

app.config['MYSQL_HOST']
app.config['MYSQL_USER']
app.config['MYSQL_PASSWORD']
app.config['MYSQL_DB']

mysql = MySQL(app)

from app import charts_data, sensor, sensor_settings, charts
from app import map, sensor_groups, info, types_settings
from app import charts_settings, map_settings, map_upload, nettemp_settings, db_settings, db_edit
from app import users_settings, mail_settings, devices_drivers, devices_1wire, alarms, devices_gpio, node_settings
from app import login, jwt
import sqlite3



@app.context_processor
def system_settings():
  """url"""
  geturl=request.url_rule.rule
  return dict(geturl=geturl)

@app.context_processor
def nt_settings():
  m = mysql.connection.cursor()
  m.execute("SELECT option, value FROM nt_settings WHERE option='nt_theme'")
  data = m.fetchone()
  m.close()
  nt_theme=data[1]
  return dict(nt_theme=nt_theme)

@app.context_processor
def nt_reboot():
  reboot=''
  if os.path.isfile('data/reboot'):
    reboot='yes'
  return dict(reboot=reboot)





