import datetime
from datetime import timedelta
import mysql.connector
from configobj import ConfigObj, os

dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
config = ConfigObj(dir+'/data/config.cfg')

mydb = mysql.connector.connect(
  host=config.get('MYSQL_HOST'),
  user=config.get('MYSQL_USER'),
  passwd=config.get('MYSQL_PASSWORD'),
  database=config.get('MYSQL_DB')
)


print('[ nettemp ][ no_data ] checker')
def check_nodata():
  def check_time(last_time, nodata_time):
    msg=[]
    fmt = '%Y-%m-%d %H:%M:%S'
    now = datetime.datetime.now()
    now = now.strftime("%Y-%m-%d %H:%M:%S")
    tstamp2 = datetime.datetime.strptime(now, fmt)
    msg.append("NOW: %s" % tstamp2)
    tstamp1 = datetime.datetime.strptime(last_time, fmt)
    msg.append("Last data read: %s" % tstamp1)
    msg.append("No data time: %s" % nodata_time)
    if tstamp1 > tstamp2:
      td = tstamp1 - tstamp2
    else:
      td = tstamp2 - tstamp1
      td_mins = int(round(td.total_seconds() / 60))
      if td_mins > int(nodata_time):
        out='nodata'
      else:
        out=''
    print(msg)
    return (out)

  m = mydb.cursor()
  m.execute("select id, time, name, nodata_time FROM sensors ")
  time = m.fetchall()
  m.close()

  list = []
  for id, time, name, nodata_time in time:
    if check_time(last_time=time,nodata_time=nodata_time)=='nodata':
      list.append([id, name])
  
  print('[ nettemp ][ no_data ] id list')
  print("[ nettemp ][ no_data ] %s" % list)
  if list:

    m = mydb.cursor()
    sql = "UPDATE sensors SET nodata='nodata' WHERE id=%s"
    for id, name in list:
      m.execute(sql, [id])
    mydb.commit()
    m.close()

check_nodata()

