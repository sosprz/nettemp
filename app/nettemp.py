from app import app
import io
import sqlite3

def nt_settings():
  conn = sqlite3.connect(app.db)
  c = conn.cursor()
  c.execute(''' SELECT option, value FROM nt_settings ''')
  data = c.fetchall()  
  conn.close()
  return data


