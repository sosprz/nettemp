from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
import os
from pathlib import Path

@app.route('/settings/devices/drivers', methods=['GET','POST'])
@login_required
def devices_settings():
  if request.method == "POST":
    if request.form.get('send-file') == 'yes':
      file = request.form['file'] 
      action = request.form['action']
      file = file+'.py'
      if action == 'on':
        src = '../available/'+file
        dst = 'app/sensors/enabled/'+file
        os.symlink(src, dst) 
      elif action == 'off':
        Path('app/sensors/enabled/'+file).unlink()

  available=[]
  enabled=[]

  for filename in os.listdir('app/sensors/available/'):
    if filename.endswith(".py"): 
      available.append(os.path.splitext(filename)[0])
  
  for filename in os.listdir('app/sensors/enabled/'):
    if filename.endswith(".py"): 
      enabled.append(os.path.splitext(filename)[0])
   
  return render_template('devices_drivers.html', available=available, enabled=enabled)


