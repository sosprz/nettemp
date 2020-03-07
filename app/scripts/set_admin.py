import sqlite3
from flask_bcrypt import Bcrypt
import os

dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))

bcrypt = Bcrypt()
password = bcrypt.generate_password_hash('admin').decode('utf-8')
conn = sqlite3.connect(dir+"/data/dbf/nettemp.db")
c = conn.cursor()
c.execute("UPDATE users SET password=? WHERE username='admin'", (password,))
conn.commit()
conn.close()