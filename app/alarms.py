from app import app
from flask import Flask, request, render_template
import sqlite3
from flask_login import login_required

def get_alarms(limit, offset):
  conn = sqlite3.connect(app.dba)
  c = conn.cursor()
  sql = "SELECT * FROM def ORDER BY rowid DESC LIMIT ? OFFSET ?"
  get = [limit, offset]
  c.execute(sql, get)
  data = c.fetchall()
  conn.close()
  return data

def get_count():
  conn = sqlite3.connect(app.dba)
  c = conn.cursor()
  sql = "SELECT count(*) FROM def"
  c.execute(sql)
  data = c.fetchone()  
  conn.close()
  return data



@app.route('/alarms', methods=['GET', 'POST'])
@login_required
def alarms():
  if request.form.get('send-alarms-clear') == 'yes':
    conn = sqlite3.connect(app.dba)
    c = conn.cursor()
    c.execute("DELETE FROM def")
    conn.commit()
    conn.close()

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
    count=count[0]
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
    count=count[0]
  except:
    count=0

  return render_template('alarms.html', data=data, count=int(count), pages=int(pages), limit=int(limit), page=int(page))
