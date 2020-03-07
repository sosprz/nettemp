import sqlite3, os
import datetime
from datetime import timedelta
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
DB=dir+'/data/dbf/nettemp.db'

print('[ nettemp ] No data checker')
def check_nodata():
  def check_time(last_time, nodata_time):
    fmt = '%Y-%m-%d %H:%M:%S'
    now = datetime.datetime.now()
    now = now.strftime("%Y-%m-%d %H:%M:%S")
    tstamp2 = datetime.datetime.strptime(now, fmt)
    tstamp1 = datetime.datetime.strptime(last_time, fmt)
    if tstamp1 > tstamp2:
      td = tstamp1 - tstamp2
    else:
      td = tstamp2 - tstamp1
      td_mins = int(round(td.total_seconds() / 60))
      if td_mins > 5:
        out='nodata'
      else:
        out=''
    return (out)

  nodata_time = 5
  conn = sqlite3.connect(DB)
  c = conn.cursor()
  c.execute("select id, time, name FROM sensors ")
  time = c.fetchall()
  conn.close()

  list = []
  for id, time, name in time:
    if check_time(last_time=time,nodata_time=nodata_time)=='nodata':
      list.append([id, name])

  print('[ nettemp ] No data id list')
  print(list)
  if list:
    conn = sqlite3.connect(DB)
    c = conn.cursor()
    sql = "UPDATE sensors SET nodata='nodata' WHERE id=?"
    for id, name in list:
      c.execute(sql, [id])
    conn.commit()
    conn.close()

check_nodata()

