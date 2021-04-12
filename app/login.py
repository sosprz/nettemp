from app import app
from flask import Flask, render_template, request , abort , redirect , Response, url_for
from flask_login import LoginManager , login_required , UserMixin , login_user, current_user, logout_user
from flask_bcrypt import Bcrypt
from flask_mysqldb import MySQL
mysql = MySQL()

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

    m = mysql.connection.cursor()
    sql = "SELECT id, username, password, email, active FROM users WHERE username=%s"
    m.execute(sql, (username,))
    data = m.fetchone()
    print(data)
    m.close()
    if data != None:
      pass_from_db = data[2]
      if username != None and username == data[1] and bcrypt.check_password_hash(pass_from_db,password) and 'yes' == data[4]:
        print('Logged in..')
        user = User(data[0], data[4], data[1])
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
  m = mysql.connection.cursor()
  sql = "SELECT id, active, username FROM users WHERE id=%s"
  m.execute(sql, (userid,))
  data = m.fetchone()
  m.close()
  if data is not None:
    user = User(data[0], data[1], data[2])
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
