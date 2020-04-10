from flask import Flask
from flask_bcrypt import Bcrypt
import mysql.connector
import os
from configobj import ConfigObj

dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
config = ConfigObj(dir+'/data/config.cfg')

mydb = mysql.connector.connect(
  host=config.get('MYSQL_HOST'),
  user=config.get('MYSQL_USER'),
  passwd=config.get('MYSQL_PASSWORD'),
  database=config.get('MYSQL_DB')
)


m = mydb.cursor()
bcrypt = Bcrypt()
password = bcrypt.generate_password_hash('admin').decode('utf-8')
sql = "UPDATE users SET password=%s WHERE username='admin'"
m.execute(sql, (password,))
mydb.commit()
