from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
import os
from pathlib import Path
import subprocess
from subprocess import PIPE, run

@app.route('/settings/devices/gpio', methods=['GET','POST'])
@login_required
def gpio_settings():
  if request.method == "POST":
    if request.form.get('send-new-dht22') == 'yes':
      name = request.form['name']
      gpio = request.form['gpio'] 
      try:
        os.mkdir("data/sensors/dht22/")
      except:
        pass
      if name.isalnum() and gpio.isalnum():
        try:
          os.mkdir('data/sensors/dht22/'+name)
          Path('data/sensors/dht22/'+name+'/'+gpio).touch()
        except:
          pass

    if request.form.get('send-new-dht11') == 'yes':
      name = request.form['name']
      gpio = request.form['gpio'] 
      try:
        os.mkdir("data/sensors/dht11/")
      except:
        pass
      if name.isalnum() and gpio.isalnum():
        try:
          os.mkdir('data/sensors/dht11/'+name)
          Path('data/sensors/dht11/'+name+'/'+gpio).touch()
        except:
          pass

    if request.form.get('send-dht22-del') == 'yes':
      name = request.form['name']
      gpio = request.form['gpio']
      if name.isalnum() and gpio.isalnum():
        try:
          Path('data/sensors/dht22/'+name+'/'+gpio).unlink()
          os.rmdir('data/sensors/dht22/'+name)
        except:
          pass

    if request.form.get('send-dht11-del') == 'yes':
      name = request.form['name']
      gpio = request.form['gpio']
      if name.isalnum() and gpio.isalnum():
        try:
          Path('data/sensors/dht11/'+name+'/'+gpio).unlink()
          os.rmdir('data/sensors/dht11/'+name)
        except:
          pass

  data22 = []
  for name in os.listdir('data/sensors/dht22/'):
    for gpio in os.listdir('data/sensors/dht22/'+name):
      data22.append([name, gpio])

  data11 = []
  for name in os.listdir('data/sensors/dht11/'):
    for gpio in os.listdir('data/sensors/dht11/'+name):
      data11.append([name, gpio])

  return render_template('devices_gpio.html', data22=data22, data11=data11)


