# -*- coding: utf-8 -*-
from app import app
from flask import Flask, request, render_template
import sqlite3
from flask_login import login_required
from flask_bcrypt import Bcrypt
bcrypt = Bcrypt()

def query_users():
  conn = sqlite3.connect(app.db)
  c = conn.cursor()
  c.execute(''' SELECT id, username, password, email, active, jwt, receive_mail FROM users ''')
  data = c.fetchall()  
  conn.close()
  return data

@app.route('/settings/users', methods=['GET','POST'])
@login_required
def settings_users():
  if request.method == "POST":
    print (request.form)
    if request.form.get('send-jwt') == 'yes':
      jwt = request.form['jwt']
      id = request.form['id']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("UPDATE users SET jwt=? WHERE id=?", (jwt,id,))
      conn.commit()
      conn.close()

    if request.form.get('send-password') == 'yes':
      password = request.form['password']
      password = bcrypt.generate_password_hash(password).decode('utf-8')
      id = request.form['id']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("UPDATE users SET password=? WHERE id=?", (password,id,))
      conn.commit()
      conn.close()

    if request.form.get('send-email') == 'yes':
      email = request.form['email']
      id = request.form['id']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("UPDATE users SET email=? WHERE id=?", (email,id,))
      conn.commit()
      conn.close()

    if request.form.get('send-active') == 'yes':
      id = request.form['id']
      active = request.form['active']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("UPDATE users SET active=? WHERE id=?", (active,id,))
      conn.commit()
      conn.close()

    if request.form.get('send-receive') == 'yes':
      id = request.form['id']
      receive_mail = request.form['receive_mail']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("UPDATE users SET receive_mail=? WHERE id=?", (receive_mail,id,))
      conn.commit()
      conn.close()

    if request.form.get('send-new') == 'yes':
      username = request.form['username']
      password = request.form['password']
      password = bcrypt.generate_password_hash(password)
      email = request.form['email']
      active = request.form['active']
      receive_mail = request.form['receive_mail']
      jwt = request.form['jwt']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("INSERT OR IGNORE INTO users (username, password, email, active, receive_mail, jwt) VALUES (?,?,?,?,?,?)", (username,password,email,active,receive_mail, jwt))
      conn.commit()
      conn.close()

    if request.form.get('send-remove') == 'yes' and request.form['id'] != 0:
      id = request.form['id']
      conn = sqlite3.connect(app.db)
      c = conn.cursor()
      c.execute("DELETE FROM users WHERE id=?", (id))
      conn.commit()
      conn.close()
  
  return render_template('users_settings.html', data=query_users())
