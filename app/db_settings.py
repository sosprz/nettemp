from app import app, clean
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
import pandas as pd

def select_sensors():
  m = mysql.connection.cursor()
  sql = "SELECT id, name, rom FROM sensors"
  m.execute(sql)
  data = m.fetchall()
  m.close()
  return data

def select_rom():
  m = mysql.connection.cursor()
  sql = "SELECT rom FROM sensors"
  m.execute(sql)
  data = m.fetchall()
  m.close()
  
  s = []
  for r in data:
    s.append(r[0])
  return s

@app.route('/settings/db', methods=['GET','POST'])
@login_required
def settings_db():
    list = []
    err = []
    if request.method == "POST":
      if request.form.get('send-del') == 'yes':
        rom = request.form['rom']
        file = rom+'.sql'
        Path('data/db/'+file).unlink()
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

    data = select_sensors()
    return render_template('db_settings.html', data=data, list=list, err=err, romlist=romlist )

@app.route('/settings/mysql', methods=['GET','POST'])
@login_required
def settings_mysql():
    list = []
    err = []
    romlist = select_rom()

    def parseCSV(filePath, rom):
      # CVS Column Names
      col_names = ['time','value']
      # Use Pandas to parse the CSV file
      csvData = pd.read_csv(filePath, names=col_names, header=None, skiprows=[0])
      # Loop through the Rows
      m = mysql.connection.cursor()
      for i,row in csvData.iterrows():
             sql = "INSERT INTO {} (time, value) VALUES (%s, %s)".format(rom)
             value = (row['time'],row['value'])
             m.execute(sql, value)
      m.connection.commit()
      m.close()     

    if request.method == "POST":
      if request.form.get('send-import') == 'yes':
        uploaded_file = request.files['file']
        rom = request.form['rom']
        rom = clean.clean(rom)
        rom = rom.clean_rom()
        rom = 'db_'+rom
        if uploaded_file.filename != '':
            file_path = os.path.join(app.config['UPLOAD_FOLDER'], uploaded_file.filename)
            uploaded_file.save(file_path)
            parseCSV(file_path, rom)
            os.remove(file_path)
    
      if request.form.get('send-del') == 'yes':
        rom = request.form['rom']
        m = mysql.connection.cursor()
        rom = clean.clean(rom)
        rom = rom.clean_rom()
        rom1 = "db_"+rom
        sql = "DROP TABLE {}".format(rom1)
        m.execute(sql)
        sql = "DELETE FROM sensors WHERE rom='{}'".format(rom)
        m.execute(sql)
        m.connection.commit()
        m.close()

    if request.method == "GET":
      if request.args.get('export') == 'yes':
        rom = request.args.get('rom')
        m = mysql.connection.cursor()
        rom = clean.clean(rom)
        rom = rom.clean_rom()
        rom = "db_"+rom
        sql = "SELECT time,value FROM {}".format(rom)
        m.execute(sql)
        c = m.fetchall()
        m.close()

        data = io.StringIO()
        
        #csv_out = csv.writer(out_csv_file)
        csv_out = csv.writer(data, quoting=csv.QUOTE_NONNUMERIC)
        # write header                        
        csv_out.writerow([d[0] for d in m.description])

        # write data                          
        for result in c:
          csv_out.writerow(result)
        results = data.getvalue()
        return Response(results,mimetype="text/plain", headers={"Content-Disposition": "attachment;filename="+rom+'.csv'})

    data = select_sensors()
    return render_template('db_settings_mysql.html', data=data, list=list, err=err, romlist=romlist )

