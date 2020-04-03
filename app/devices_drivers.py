from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
import os
from pathlib import Path

@app.route('/settings/devices/drivers', methods=['GET','POST'])
@login_required
def devices_settings():
  list =  ['01','05','10','15','20','30','60']
  if request.form.get('time') in list:
        file = request.form['file'] 
        action = request.form['action']
        time = request.form['time']
        print(time)
        file = file+'.py'
        if action == 'on':
          for t in list:
            try:
              Path('data/sensors/enabled/'+t+'/'+file).unlink()
            except:
              pass
          src = '../../../../app/sensors/available/'+file
          dst = 'data/sensors/enabled/'+time+'/'+file
          os.symlink(src, dst)
        elif action == 'off':
          for t in list:
            try:
              Path('data/sensors/enabled/'+t+'/'+file).unlink()
            except:
              pass

  av=[]
  def enabled(filename):
    for t in list:
      for files in os.listdir('data/sensors/enabled/'+t+'/'):
        if files.endswith(".py"):
          if files == filename:
            return t

  for filename in os.listdir('app/sensors/available/'):
    if filename.endswith(".py"): 
      av.append([os.path.splitext(filename)[0],enabled(filename)])

  return render_template('devices_drivers.html', av=av)


