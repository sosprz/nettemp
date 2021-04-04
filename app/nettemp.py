from app import app
from flask_mysqldb import MySQL
mysql = MySQL()

def nt_settings():
  m = mysql.connection.cursor()
  sql = "SELECT option, value FROM nt_settings"
  m.execute(sql)
  data = m.fetchall()
  m.close()
  return data


