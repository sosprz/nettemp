from app import app
from flask import Flask, request, jsonify, render_template
from flask_login import login_required
import os
from pathlib import Path
import subprocess
from subprocess import PIPE, run

@app.route('/settings/devices/1wire', methods=['GET','POST'])
@login_required
def wire_settings():
  if request.method == "POST":
    if request.form.get('send-therm') == 'yes':
      if request.form['therm'] == 'on':
        Path("data/sensors/ds2482").touch()
        Path("data/reboot").touch()
      if request.form['therm'] == 'off':
        Path('data/sensors/ds2482').unlink()
        Path("data/reboot").touch()
        
    if request.form.get('send-wire') == 'yes':
      if request.form['wire'] == 'on':
        os.system('sudo app/scripts/1w.sh on')
        Path("data/reboot").touch()
      if request.form['wire'] == 'off':
        os.system('sudo app/scripts/1w.sh off')
        Path("data/reboot").touch()

  ds2482=''        
  if os.path.isfile('data/sensors/ds2482'):
    ds2482='on'
  else:
    ds2482='off'

  command = ["sudo", "app/scripts/1w.sh"]
  result = run(command, stdout=PIPE, stderr=PIPE, universal_newlines=True)
  #print(result.returncode, result.stdout, result.stderr)
  wire = result.stdout.strip()

  return render_template('devices_1wire.html', ds2482=ds2482, wire=wire)


