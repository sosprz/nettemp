import sqlite3
import datetime
from datetime import timedelta

dba='/var/www/nettemp/data/dba/alarms.db'


name='test'
value='1'
unit='C'
action='alarm'
status='min'
min=10
max=50
type='temp'



conn = sqlite3.connect(dba)
c = conn.cursor()
data = [name, value, unit, 'recovery', status, min, max, type]
sql = ''' INSERT OR IGNORE INTO def (name, value, unit, action, status, min, max, type) VALUES (?,?,?,?,?,?,?,?) '''
c.execute(sql, data)
conn.commit()
conn.close()

for i in range(1,200):
    conn = sqlite3.connect(dba)
    c = conn.cursor()
    data = [name, value, unit, action, status, min, max, type]
    sql = ''' INSERT OR IGNORE INTO def (name, value, unit, action, status, min, max, type) VALUES (?,?,?,?,?,?,?,?) '''
    c.execute(sql, data)
    conn.commit()
    conn.close()

conn = sqlite3.connect(dba)
c = conn.cursor()
data = [name, value, unit, 'recovery', status, min, max, type]
sql = ''' INSERT OR IGNORE INTO def (name, value, unit, action, status, min, max, type) VALUES (?,?,?,?,?,?,?,?) '''
c.execute(sql, data)
conn.commit()
conn.close()

