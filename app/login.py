from app import app
from flask import Flask, render_template, request , abort , redirect , Response, url_for
from flask_login import LoginManager , login_required , UserMixin , login_user, current_user, logout_user
import sqlite3
from flask_bcrypt import Bcrypt


login_manager = LoginManager()
login_manager.login_view = "login"
login_manager.init_app(app)
bcrypt = Bcrypt()

class User(UserMixin):
    def __init__(self, id, active, username ):
      self.id = id
      self.username = username
      self.active = active

    def is_authenticated(self):
      return True

    def is_active(self):
      if self.active == 'yes':
          print('%s is_active TRUE \n' % self.id)
          return True
      else:
          print('%s is_active FALSE \n' % self.id)
          return False 

    def is_anonymous(self):
      return False

    def get_id(self):
      print ("get_id %s "  % self.id)
      return self.id


@app.route('/login' , methods=['GET' , 'POST'])
def login():
  if current_user.is_authenticated:
    return redirect(url_for('index'))
  if request.method == 'POST' and "username" in request.form:
    username = request.form['username']
    password = request.form['password']
    print ("Login form: %s" % username)

    conn = sqlite3.connect(app.db)
    conn.row_factory = sqlite3.Row
    c = conn.cursor()
    c.execute("SELECT id, username, password, email, active FROM users WHERE username=?", (username,))
    data = c.fetchone()
    conn.close()
    if data != None:
      pass_from_db = data['password']
      if username != None and username == data['username'] and bcrypt.check_password_hash(pass_from_db,password) and 'yes' == data['active']:
        print('Logged in..')
        user = User(data['id'], data['active'], data['username'])
        login_user(user)
        #if not current_user.is_active():
        #  return render_template('login.html')
        return redirect(url_for('index'))
      else:
        print ('Bad username ')
        return render_template('login.html')
    else:
      print ('No data')
      return render_template('login.html')
  else:
    print ('Bad post or no username')
    return render_template('login.html')


""" callback to reload the user object """
@login_manager.user_loader
def load_user(userid):
  conn = sqlite3.connect(app.db)
  conn.row_factory = sqlite3.Row
  c = conn.cursor()
  c.execute("SELECT id, active, username FROM users WHERE id=?", (userid,))
  data = c.fetchone() 
  conn.close()
  if data is not None:
    user = User(data['id'], data['active'], data['username'])
    return user
  else:
    return None

@login_manager.unauthorized_handler
def unauthorized_handler():
  return redirect(url_for('login'))

@app.route('/logout')
@login_required
def logout():
  logout_user()
  return redirect(url_for('index'))
