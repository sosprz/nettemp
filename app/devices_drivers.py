from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
import os
from pathlib import Path

@app.route('/settings/devices/drivers', methods=['GET','POST'])
@login_required
def devices_settings():
  readAfter =  ['01','05','10','15','20','30','60']
  driversDir = os.listdir('app/sensors/available/')
  driversList = [x.split('.')[0] for x in driversDir]
  if request.form.get('time') in readAfter or request.form.get('time') == 'off':
        file = request.form['file'] 
        time = request.form['time']
        print(time, file)
        if time in readAfter and file in driversList:
          for t in readAfter:
            try:
              Path('data/sensors/enabled/'+t+'/'+file+'.py').unlink()
            except:
              pass
          src = '../../../../app/sensors/available/'+file+'.py'
          dst = 'data/sensors/enabled/'+time+'/'+file+'.py'
          os.symlink(src, dst)
        elif time == 'off' and file in driversList:
          for t in readAfter:
            try:
              Path('data/sensors/enabled/'+t+'/'+file+'.py').unlink()
            except:
              pass

  av=[]
  def enabled(filename):
    for t in readAfter:
      for files in os.listdir('data/sensors/enabled/'+t+'/'):
        if files.endswith(".py"):
          if files == filename:
            return t

  for filename in os.listdir('app/sensors/available/'):
    if filename.endswith(".py"): 
      av.append([os.path.splitext(filename)[0],enabled(filename)])

  return render_template('devices_drivers.html', av=av, readAfter=readAfter)


