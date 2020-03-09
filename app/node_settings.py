from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
import requests
from requests import ReadTimeout, ConnectTimeout, HTTPError, Timeout, ConnectionError
requests.packages.urllib3.disable_warnings() 
import json

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
    list = []
    err = []
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
        node_url.replace("register", "sensor")
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

      if request.form.get('send-request') == 'yes':
        url = request.form['url']
        username = request.form['username']
        password = request.form['password']
        data = {'username':username,'password':password}
        headers={'Accept':'application/json','Content-Type': 'application/json'}
        try:
          r = requests.post(url, data=json.dumps(data), headers=headers, verify=False)
          token=r.json()
          if not 'msg' in token:
            token['access_token']
            token = token['access_token']
            list.append(url.replace("register", "sensor"))
            list.append(token)
          else:
            err=token['msg']
        except (ConnectTimeout, HTTPError, ReadTimeout, Timeout, ConnectionError):
          err="Connection, HTTP or Timeout error occured."
    data = select_sensors()
    return render_template('node_settings.html', data=data, list=list, err=err )
