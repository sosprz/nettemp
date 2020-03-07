from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required


def select_sensors():
  conn = sqlite3.connect(app.db)
  c = conn.cursor()
  sql = ''' SELECT id, name, node, node_url, node_token FROM sensors WHERE node='on' '''
  c.execute(sql)
  data = c.fetchall()  
  conn.close()
  return data

@app.route('/settings/node', methods=['GET','POST'])
@login_required
def settings_node():
    if request.method == "POST":
      if request.form.get('send-url') == 'yes':
        url = request.form['url']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET node_url=? WHERE id=?", (url,id,))
        conn.commit()
        conn.close()

      if request.form.get('send-token') == 'yes':
        token = request.form['token']
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET node_token=? WHERE id=?", (token,id,))
        conn.commit()
        conn.close()

      if request.form.get('send-copy') == 'yes':
        node_token = request.form['node_token']
        node_url = request.form['node_url']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET node_token=?, node_url=? WHERE node='on'", (node_token,node_url,))
        conn.commit()
        conn.close()

      if request.form.get('send-del') == 'yes':
        id = request.form['id']
        conn = sqlite3.connect(app.db)
        c = conn.cursor()
        c.execute("UPDATE sensors SET node_token='', node_url='' WHERE id=?", (id,))
        conn.commit()
        conn.close()


    data = select_sensors()
    return render_template('node_settings.html', data=data)
