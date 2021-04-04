import smtplib, ssl, sqlite3
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
import datetime
from datetime import timedelta
import sys, os
import socket
from subprocess import check_output
import mysql.connector
from configobj import ConfigObj, os

dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
sys.path.append(dir)
config = ConfigObj(dir+'/data/config.cfg')

mydb = mysql.connector.connect(
  host=config.get('MYSQL_HOST'),
  user=config.get('MYSQL_USER'),
  passwd=config.get('MYSQL_PASSWORD'),
  database=config.get('MYSQL_DB')
)


dba=dir+'/data/dba/alarms.db'
schema=dir+'/app/schema/alarms_db_schema.sql'
def new_dba():
  conn = sqlite3.connect(dba)
  c = conn.cursor()
  sql = "SELECT count() FROM sqlite_master WHERE type='table' AND name='def'"
  c.execute(sql)
  if c.fetchone()[0]==1:
    print ("Database DBA exists" )
    return True
  else:
    with open(schema, mode='r') as f:
      conn = sqlite3.connect(dba)
      conn.cursor().executescript(f.read())
      conn.commit()
    print ("Database DBA created" )
    return False
  conn.close()

def insert_dba(name, value, unit, action, status, min, max, type):
  conn = sqlite3.connect(dba)
  c = conn.cursor()
  sql = "SELECT count() FROM sqlite_master WHERE type='table' AND name='def'"
  c.execute(sql)
  coun=c.fetchone()
  if coun[0]==1:
    data = [name, value, unit, action, status, min, max, type]
    sql = "INSERT OR IGNORE INTO def (name, value, unit, action, status, min, max, type) VALUES (?,?,?,?,?,?,?,?)"
    c.execute(sql, data)
    conn.commit()
    conn.close()
    print ("Database %s insert ok" %dba)
    return True
  else:
    print ("Database %s not exist" %dba)
    return False


def check_alarm():
  m = mydb.cursor()
  sql = "select sensors.id, sensors.name, sensors.tmp, types.unit, sensors.tmp_min, sensors.tmp_max, sensors.alarm_status, sensors.type FROM sensors INNER JOIN types ON sensors.type = types.type  WHERE sensors.alarm='on'"
  m.execute(sql)
  data = m.fetchall()
  m.close()


  def update_alarm_status(id, status):
    """ action sent or recovery """
    m = mydb.cursor()
    if status == 'recovery':
      data = [id]
      sql = "UPDATE sensors SET alarm_status='', alarm_recovery_time=CURRENT_TIMESTAMP WHERE id=%s"
    else:
      sql = "UPDATE sensors SET alarm_status=%s WHERE id=%s"
      data = [status, id]
    m.execute(sql, data)
    mydb.commit()
    m.close()

  msg_all = []

  for id, name, tmp, unit, min, max, alarm_status, type in data:
    action = ''
    # max
    if tmp>max and alarm_status!='max':
      update_alarm_status(id,'max')
      msg=("Alarm for %s %.2f%s. Max alarm set to: %.2f%s " % (name,tmp,unit,max,unit))
      action = 'alarm'
      status = 'max'
      print("Alarm 1 "+msg)
    elif tmp>max and alarm_status=='max':
      msg=("Alarm already set for %s %.2f%s" % (name,tmp,unit))
      print("Alarm 2 "+msg)
    elif tmp<max and alarm_status=='max':
      update_alarm_status(id,'recovery')
      msg=("Alarm recovery for %s %.2f%s" % (name,tmp,unit))
      action = 'recovery'
      status = 'max'
      print("Alarm 3 "+msg)
    # min
    elif tmp<min and alarm_status !='min':
      update_alarm_status(id,'min') 
      msg=("Alarm for %s %.2f%s. Min alarm set to: %.2f%s " % (name,tmp,unit,min,unit))
      action = 'alarm'
      status = 'min'
      print("Alarm 4 "+msg)
    elif tmp<min and alarm_status=='min':
      msg=("Alarm already set for %s %.2f%s" % (name,tmp,unit))
      print("Alarm 5 "+msg)
    elif tmp>min and alarm_status=='min':
      update_alarm_status(id,'recovery')
      msg=("Alarm recovery for %s %.2f%s" % (name,tmp,unit))
      action = 'recovery'
      status = 'min'
      print("Alarm 6 "+msg)

    if action:
      if insert_dba(name, tmp, unit, action, status, min, max, type) == False:
        new_dba()
        insert_dba(name, tmp, unit, action, status, min, max, type)



def check_mail():
  msg_all = [] 

  m = mydb.cursor()
  sql = "select sensors.id, sensors.name, sensors.tmp, types.unit, sensors.tmp_min, \
             sensors.tmp_max, sensors.email_status, sensors.email_time, sensors.email_delay, \
             sensors.alarm_recovery_time, sensors.alarm_status, sensors.nodata, sensors.nodata_time \
             FROM sensors INNER JOIN types ON sensors.type = types.type  WHERE sensors.email='on'"
  m.execute(sql)
  data = m.fetchall()
  m.close()

  def update_mail(id, action):
    """ action sent or recovery """
    m = mydb.cursor()
    if action == 'recovery':
      data = [id]
      sql = "UPDATE sensors SET email_status='' WHERE id=%s"
    else:
      sql = "UPDATE sensors SET email_status=%s, email_time=CURRENT_TIMESTAMP WHERE id=%s"
      data = [action, id]
    m.execute(sql, data)
    mydb.commit()
    m.close()

  msg_all = []
  for id, name, tmp, unit, min, max, email_status, email_time, email_delay, alarm_recovery_time, alarm_status, nodata, nodata_time in data:
    if alarm_recovery_time:
      fmt = '%Y-%m-%d %H:%M:%S'
      now = datetime.datetime.now()
      now = now.strftime("%Y-%m-%d %H:%M:%S")
      tstamp2 = datetime.datetime.strptime(now, fmt)
      tstamp1 = datetime.datetime.strptime(alarm_recovery_time, fmt)

      if tstamp1 > tstamp2:
        td = tstamp1 - tstamp2
      else:
        td = tstamp2 - tstamp1
        td_mins = int(round(td.total_seconds() / 60))
        #print (name)
        #print (tstamp1)
        #print (tstamp2)
        #print('%s the difference is approx. %s minutes' % (name, td_mins))
    else:
      td_mins = 0
      #print("No time")

    if nodata=='nodata' and email_status!='sent':
        update_mail(id,'sent')
        msg=("No data for %s >= %smin." % (name, nodata_time))
        msg_all.append(msg)
        print("[ nettemp ][ alarm send ] Mail 0 "+msg)
    elif alarm_status and td_mins < email_delay and alarm_recovery_time:
        msg=("Delay for %s %.2f%s is %d minutes. Passed %s minutes." % (name,tmp,unit,email_delay,td_mins))
        print("[ nettemp ][ alarm send ] Mail 1 "+msg)
    elif alarm_status and email_status != 'sent':
        update_mail(id,'sent')
        msg=("Alarm for %s %.2f%s. Max alarm set to: %.2f%s " % (name,tmp,unit,max,unit))
        msg_all.append(msg)
        print("[ nettemp ][ alarm send ] Mail 2 "+msg)
    elif alarm_status and email_status=='sent':
        msg=("Already sent for %s %.2f%s" % (name,tmp,unit))
        print("[ nettemp ][ alarm send ] Mail 3 "+msg)
    elif not alarm_status and email_status=='sent' and not nodata=='nodata':
        update_mail(id, 'recovery')
        msg=("Recovery for %s %.2f%s" % (name,tmp,unit))
        msg_all.append(msg)
        print("[ nettemp ][ alarm send ] Mail 4 "+msg)

  data='<br>'.join(str(x) for x in msg_all)
  return data




# MAIN 
check_alarm()

m = mydb.cursor()
sql = "select email FROM users WHERE receive_mail='yes'"
m.execute(sql)
recipients = [str(x[0]) for x in m.fetchall()]


if recipients:
  hostname = socket.gethostname()
  host_ip = check_output(['hostname', '-I']).decode()
  data=check_mail()

  m = mydb.cursor()
  sql = "SELECT option, value FROM nt_settings"
  m.execute(sql)
  s = m.fetchall()  
  mydb.commit()
  m.close()

  for k, v in s:
   if k=='smtp_user':
     smtp_user = v
   if k=='smtp_p':
     smtp_p = v
   if k=='smtp_server':
     smtp_server = v
   if k=='smtp_port':
     smtp_port = v
   if k=='mail_subject':
     mail_subject = v

  message = MIMEMultipart("alternative")
  message["Subject"] = mail_subject
  message["From"] = smtp_user
  message["To"] = ", ".join(recipients)


  text = """\
  Hi,
  {data}
  Notification from: https://{host_ip}
  """.format(data=data,host_ip=host_ip)
  html = """\
  <html>
    <body>
      <p>
       {data}<br>
       <br>
       Notification from: <a href="https://{host_ip}">https://{hostname}</a>
       <br>
         <a href="http://techfreak.pl/tag/nettemp"> <img src="http://techfreak.pl/wp-content/uploads/2012/12/nettemp.pl_.png" style="width:120px;height:40px;"></a><br>
      </p>
    </body>
  </html>
  """.format(data=data, hostname=hostname, host_ip=host_ip)

  # Turn these into plain/html MIMEText objects
  part1 = MIMEText(text, "plain")
  part2 = MIMEText(html, "html")

  # Add HTML/plain-text parts to MIMEMultipart message
  # The email client will try to render the last part first
  message.attach(part1)
  message.attach(part2)

  if data:
    context = ssl.create_default_context()
    with smtplib.SMTP_SSL(smtp_server, smtp_port, context=context) as server:
      server.login(smtp_user, smtp_p)
      server.sendmail(
            smtp_user, recipients, message.as_string(),
      )
  else:
    print ('[ nettemp ][ alarm send ] Nothig to do')
else:
  print ('[ nettemp ][ alarm send ] No recepients')
