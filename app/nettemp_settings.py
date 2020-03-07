from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
from app.nettemp import nt_settings

@app.route('/settings/nettemp', methods=['GET','POST'])
@login_required
def nettemp_settings():
  if request.method == "POST":
    if request.form.get('send-theme') == 'yes':
      theme = request.form['theme']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("UPDATE nt_settings SET value=? WHERE option='nt_theme'", (theme,))
      conn.commit()
      conn.close()
    if request.form.get('send-reboot') == 'yes':
      import os
      os.system('sudo reboot')
    if request.form.get('send-alarms-clear') == 'yes':
      conn = sqlite3.connect(app.dba)
      c = conn.cursor()
      c.execute("DELETE FROM def")
      conn.commit()
      conn.close()

  return render_template('nettemp_settings.html', nt_settings=dict(nt_settings()))


