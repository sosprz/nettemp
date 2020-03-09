import smtplib, ssl, sqlite3
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from flask import Flask, g
from app import app
import datetime
from datetime import timedelta

dba='data/dba/alarms.db'

def get_db(dba):
    db = getattr(g, '_database', None)
    if db is None:
        db = g._database = sqlite3.connect(dba)
    return db

def new_dba():
  conn = sqlite3.connect(dba)
  c = conn.cursor()
  c.execute(''' SELECT count() FROM sqlite_master WHERE type='table' AND name='def' ''')
  if c.fetchone()[0]==1:
    print ("Database DBA exists" )
    return True
  else:
    with app.app_context():
      db = get_db(dba)
      with app.open_resource('schema/alarms_db_schema.sql', mode='r') as f:
        db.cursor().executescript(f.read())
        db.commit()
    print ("Database DBA created" )
    return False

def insert_dba(name, value, unit, action, status, min, max, type):
  conn = sqlite3.connect(dba)
  c = conn.cursor()
  c.execute(''' SELECT count() FROM sqlite_master WHERE type='table' AND name='def' ''')
  if c.fetchone()[0]==1:
    data = [name, value, unit, action, status, min, max, type]
    sql = ''' INSERT OR IGNORE INTO def (name, value, unit, action, status, min, max, type) VALUES (?,?,?,?,?,?,?,?) '''
    c.execute(sql, data)
    conn.commit()
    conn.close()
    print ("Database %s insert ok" %dba)
    return True
  else:
    print ("Database %s not exist" %dba)
    return False


def check_alarm():
  conn = sqlite3.connect(app.db)
  c = conn.cursor()
  c.execute("select sensors.id, sensors.name, sensors.tmp, types.unit, sensors.tmp_min, sensors.tmp_max, sensors.alarm_status, sensors.type FROM sensors INNER JOIN types ON sensors.type = types.type  WHERE sensors.alarm=='on'")
  data = c.fetchall()
  conn.close()

  def update_alarm_status(id, status):
    """ action sent or recovery """
    conn = sqlite3.connect(app.db)
    c = conn.cursor()
    if status == 'recovery':
      data = [id]
      sql = ''' UPDATE sensors SET alarm_status='', alarm_recovery_time=datetime(CURRENT_TIMESTAMP, 'localtime') WHERE id=? '''
    else:
      sql = ''' UPDATE sensors SET alarm_status=? WHERE id=? '''
      data = [status, id]
    c.execute(sql, data)
    conn.commit()
    conn.close()

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
 
  conn = sqlite3.connect(app.db)
  c = conn.cursor()
  c.execute("select sensors.id, sensors.name, sensors.tmp, types.unit, sensors.tmp_min, \
             sensors.tmp_max, sensors.email_status, sensors.email_time, sensors.email_delay, \
             sensors.alarm_recovery_time, sensors.alarm_status, sensors.nodata \
             FROM sensors INNER JOIN types ON sensors.type = types.type  WHERE sensors.email='on'")
  data = c.fetchall()
  conn.close()

  def update_mail(id, action):
    """ action sent or recovery """
    conn = sqlite3.connect(app.db)
    c = conn.cursor()
    if action == 'recovery':
      data = [id]
      sql = ''' UPDATE sensors SET email_status='' WHERE id=? '''
    else:
      sql = ''' UPDATE sensors SET email_status=?, email_time=datetime(CURRENT_TIMESTAMP, 'localtime') WHERE id=? '''
      data = [action, id]
    c.execute(sql, data)
    conn.commit()
    conn.close()

  msg_all = []
  for id, name, tmp, unit, min, max, email_status, email_time, email_delay, alarm_recovery_time, alarm_status, nodata in data:
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
        msg=("No data for %s >= 5min." % (name))
        msg_all.append(msg)
        print("Mail 0 "+msg)
    elif alarm_status and td_mins < email_delay and alarm_recovery_time:
        msg=("Delay for %s %.2f%s is %d minutes. Passed %s minutes." % (name,tmp,unit,email_delay,td_mins))
        print("Mail 1 "+msg)
    elif alarm_status and email_status != 'sent':
        update_mail(id,'sent')
        msg=("Alarm for %s %.2f%s. Max alarm set to: %.2f%s " % (name,tmp,unit,max,unit))
        msg_all.append(msg)
        print("Mail 2 "+msg)
    elif alarm_status and email_status=='sent':
        msg=("Already sent for %s %.2f%s" % (name,tmp,unit))
        print("Mail 3 "+msg)
    elif not alarm_status and email_status=='sent':
        update_mail(id, 'recovery')
        msg=("Recovery for %s %.2f%s" % (name,tmp,unit))
        msg_all.append(msg)
        print("Mail 4 "+msg)

  data='<br>'.join(str(x) for x in msg_all)
  return data




# MAIN 
check_alarm()

conn = sqlite3.connect(app.db)
c = conn.cursor()
c.execute("select email FROM users WHERE receive_mail=='yes' ")
recipients = [str(x[0]) for x in c.fetchall()]
conn.close()

if recipients:
  data=check_mail()
  conn = sqlite3.connect(app.db)
  conn.row_factory = sqlite3.Row
  c = conn.cursor()
  c.execute(''' SELECT option, value FROM nt_settings ''')
  s = c.fetchall()  
  conn.close()

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
  """.format(data=data)
  html = """\
  <html>
    <body>
      <p>
         {data}<br>
       <br >
         <a href="http://techfreak.pl/tag/nettemp"> <img src="http://techfreak.pl/wp-content/uploads/2012/12/nettemp.pl_.png" style="width:120px;height:40px;"></a><br>
      </p>
    </body>
  </html>
  """.format(data=data)

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
    print ('Nothig to do')
else:
  print ('No recepients')


