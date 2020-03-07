from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
from app.nettemp import nt_settings

@app.route('/settings/charts', methods=['GET','POST'])
@login_required
def charts_settings():
  if request.method == "POST":
    if request.form.get('send-quick-charts') == 'yes':
      quickcharts = request.form['quick-charts']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("UPDATE nt_settings SET value=? WHERE option='quick_charts'", (quickcharts,))
      conn.commit()
      conn.close()
    if request.form.get('send-theme') == 'yes':
      theme = request.form['theme']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("UPDATE nt_settings SET value=? WHERE option='charts_theme'", (theme,))
      conn.commit()
      conn.close()

  return render_template('charts_settings.html', nt_settings=dict(nt_settings()))


