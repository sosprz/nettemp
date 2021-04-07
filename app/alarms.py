from app import app
from flask import Flask, request, render_template
from flask_login import login_required
from flask_mysqldb import MySQL
mysql = MySQL()

def get_alarms(limit, offset):
  m = mysql.connection.cursor()
  sql = "SELECT time, value, name, unit, status, action, min, max, type FROM alarms ORDER BY id DESC LIMIT %s OFFSET %s"
  get = [limit, offset]
  m.execute(sql, get)
  data = m.fetchall()
  m.close()
  return data

def get_count():
  m = mysql.connection.cursor()
  sql = "SELECT count(*) FROM alarms"
  m.execute(sql)
  data = m.fetchone()[0]
  m.close()
  return data

@app.route('/alarms', methods=['GET', 'POST'])
@login_required
def alarms():
  if request.form.get('send-alarms-clear') == 'yes':
    m = mysql.connection.cursor()
    m.execute("DELETE FROM alarms")
    m.connection.commit()
    m.close()

  page = request.args.get("page")
  offset= 0
  limit = request.args.get("limit")

  if not page:
    page=1
  if not limit:
    limit=100
  if int(page)<1:
    page=1
  
  try:
    count=get_count()
  except:
    count=0

  pages = (int(count)//int(limit))+2
  offset= (int(page)-1)*int(limit)

  try:
    data=get_alarms(limit, offset)
  except:
    data=[]

  try:
    count=get_count()
  except:
    count=0

  return render_template('alarms.html', data=data, count=int(count), pages=int(pages), limit=int(limit), page=int(page))
