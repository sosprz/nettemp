from app import app
from flask import Flask, request, jsonify, render_template
from flask_login import login_required
from app.nettemp import nt_settings
from flask_mysqldb import MySQL
mysql = MySQL()

@app.route('/settings/nettemp', methods=['GET','POST'])
@login_required
def nettemp_settings():
  if request.method == "POST":
    if request.form.get('send-theme') == 'yes':
      theme = request.form['theme']
      m = mysql.connection.cursor()
      m.execute("UPDATE nt_settings SET value=%s WHERE option='nt_theme'", (theme,))
      m.connection.commit()
      m.close()
    if request.form.get('send-reboot') == 'yes':
      import os
      os.system('sudo reboot')
    if request.form.get('send-alarms-clear') == 'yes':
      m = mysql.connection.cursor()
      m.execute("DELETE FROM def")
      m.connection.commit()
      m.close()

  return render_template('nettemp_settings.html', nt_settings=dict(nt_settings()))


