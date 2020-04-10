from app import app
from flask_mysqldb import MySQL
mysql = MySQL()

def nt_settings():
  m = mysql.connection.cursor()
  m.execute("SELECT option, value FROM nt_settings")
  data = m.fetchall()
  m.close()
  return data


