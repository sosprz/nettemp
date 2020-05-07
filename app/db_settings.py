from app import app
from flask import Flask, request, jsonify, render_template, Response
import sqlite3
import csv, io
from flask_login import login_required
import requests
from pathlib import Path
import os
import json
from flask_mysqldb import MySQL
mysql = MySQL()




def select_sensors():
  m = mysql.connection.cursor()
  sql = "SELECT id, name, rom FROM sensors"
  m.execute(sql)
  data = m.fetchall()
  m.close()
  return data

@app.route('/settings/db', methods=['GET','POST'])
@login_required
def settings_db():
    list = []
    err = []
    if request.method == "POST":
      if request.form.get('send-del') == 'yes':
        rom = request.form['rom']
        file = rom+'.sql'
        #try:
        Path('data/db/'+file).unlink()
        #except:
        # pass
    romlist = []
    for filename in os.listdir('data/db/'):
      if filename.endswith(".sql"): 
        romlist.append(os.path.splitext(filename)[0])

    if request.method == "GET":
      if request.args.get('export') == 'yes':
        rom = request.args.get('rom')
        db = sqlite3.connect('data/db/'+rom+'.sql')
        c = db.cursor()
        c.execute('SELECT * FROM def')
        data = io.StringIO()
        
        #csv_out = csv.writer(out_csv_file)
        csv_out = csv.writer(data, quoting=csv.QUOTE_NONNUMERIC)
        # write header                        
        csv_out.writerow([d[0] for d in c.description])
        # write data                          
        for result in c:
          csv_out.writerow(result)
        db.close()
        results = data.getvalue()
        return Response(results,mimetype="text/plain", headers={"Content-Disposition": "attachment;filename="+rom+'.csv'})
        data.close()

    data = select_sensors()
    return render_template('db_settings.html', data=data, list=list, err=err, romlist=romlist )
