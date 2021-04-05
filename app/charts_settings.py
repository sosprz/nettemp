from app import app
from flask import Flask, request, jsonify, render_template
from flask_login import login_required
from app.nettemp import nt_settings
from flask_mysqldb import MySQL
mysql = MySQL()


@app.route('/settings/charts', methods=['GET','POST'])
@login_required
def charts_settings():
  if request.method == "POST":
    if request.form.get('send-quick-charts') == 'yes':
      quickcharts = request.form['quick-charts']
      m = mysql.connection.cursor()
      sql="UPDATE nt_settings SET value=%s WHERE option='quick_charts'"
      m.execute(sql, (quickcharts,))
      m.connection.commit()
      m.close()
    if request.form.get('send-mysql-charts') == 'yes':
      mysqlcharts = request.form['mysql-charts']
      m = mysql.connection.cursor()
      sql="UPDATE nt_settings SET value=%s WHERE option='mysql_charts'"
      m.execute(sql, (mysqlcharts,))
      m.connection.commit()
      m.close()
    if request.form.get('send-theme') == 'yes':
      theme = request.form['theme']
      m = mysql.connection.cursor()
      sql="UPDATE nt_settings SET value=%s WHERE option='charts_theme'"
      m.execute(sql, (theme,))
      m.connection.commit()
      m.close()

  return render_template('charts_settings.html', nt_settings=dict(nt_settings()))


