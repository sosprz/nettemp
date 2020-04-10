# -*- coding: utf-8 -*-
from app import app
from flask import Flask, request, render_template
from flask_login import login_required
from flask_bcrypt import Bcrypt
bcrypt = Bcrypt()
from flask_mysqldb import MySQL
mysql = MySQL()


def query_users():
  m = mysql.connection.cursor()
  m.execute("SELECT id, username, password, email, active, jwt, receive_mail FROM users")
  data = m.fetchall()  
  m.close()
  return data

@app.route('/settings/users', methods=['GET','POST'])
@login_required
def settings_users():
  if request.method == "POST":
    print (request.form)
    if request.form.get('send-jwt') == 'yes':
      jwt = request.form['jwt']
      id = request.form['id']
      m = mysql.connection.cursor()
      m.execute("UPDATE users SET jwt=%s WHERE id=%s", (jwt,id,))
      m.connection.commit()
      m.close()

    if request.form.get('send-password') == 'yes':
      password = request.form['password']
      password = bcrypt.generate_password_hash(password).decode('utf-8')
      id = request.form['id']
      m = mysql.connection.cursor()
      m.execute("UPDATE users SET password=%s WHERE id=%s", (password,id,))
      m.connection.commit()
      m.close()

    if request.form.get('send-email') == 'yes':
      email = request.form['email']
      id = request.form['id']
      m = mysql.connection.cursor()
      m.execute("UPDATE users SET email=%s WHERE id=%s", (email,id,))
      m.connection.commit()
      m.close()

    if request.form.get('send-active') == 'yes':
      id = request.form['id']
      active = request.form['active']
      m = mysql.connection.cursor()
      m.execute("UPDATE users SET active=%s WHERE id=%s", (active,id,))
      m.connection.commit()
      m.close()

    if request.form.get('send-receive') == 'yes':
      id = request.form['id']
      receive_mail = request.form['receive_mail']
      m = mysql.connection.cursor()
      m.execute("UPDATE users SET receive_mail=%s WHERE id=%s", (receive_mail,id,))
      m.connection.commit()
      m.close()

    if request.form.get('send-new') == 'yes':
      username = request.form['username']
      password = request.form['password']
      password = bcrypt.generate_password_hash(password)
      email = request.form['email']
      active = request.form['active']
      receive_mail = request.form['receive_mail']
      jwt = request.form['jwt']
      m = mysql.connection.cursor()
      m.execute("INSERT IGNORE INTO users (username, password, email, active, receive_mail, jwt) VALUES (%s,%s,%s,%s,%s,%s)", (username,password,email,active,receive_mail, jwt))
      m.connection.commit()
      m.close()

    if request.form.get('send-remove') == 'yes' and request.form['id'] != 0:
      id = request.form['id']
      m = mysql.connection.cursor()
      m.execute("DELETE FROM users WHERE id=%s", (id))
      m.connection.commit()
      m.close()
  
  return render_template('users_settings.html', data=query_users())
