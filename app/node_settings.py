from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required
import requests
from requests import ReadTimeout, ConnectTimeout, HTTPError, Timeout, ConnectionError
requests.packages.urllib3.disable_warnings() 
import json
from flask_mysqldb import MySQL
mysql = MySQL()


def select_sensors():
  m = mysql.connection.cursor()
  sql = "SELECT id, name, node, node_url, node_token FROM sensors WHERE node='on'"
  m.execute(sql)
  data = m.fetchall()
  m.close()
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
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET node_url=%s WHERE id=%s"
        m.execute(sql, (url,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-token') == 'yes':
        token = request.form['token']
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET node_token=%s WHERE id=%s"
        m.execute(sql, (token,id,))
        m.connection.commit()
        m.close()

      if request.form.get('send-copy') == 'yes':
        node_token = request.form['node_token']
        node_url = request.form['node_url']
        node_url.replace("register", "sensor")
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET node_token=%s, node_url=%s WHERE node='on'"
        m.execute(sql, (node_token,node_url,))
        m.connection.commit()
        m.close()

      if request.form.get('send-del') == 'yes':
        id = request.form['id']
        m = mysql.connection.cursor()
        sql = "UPDATE sensors SET node_token='', node_url='' WHERE id=%s"
        m.execute(sql, (id,))
        m.connection.commit()
        m.close()

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
