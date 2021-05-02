from app import app
from flask import Flask, request, render_template
import sqlite3
from flask_login import login_required
from flask_mysqldb import MySQL
mysql = MySQL()
from app import clean

def get_data(rom, limit, offset, val_s, time_s):
  conn = sqlite3.connect('data/db/'+rom+'.sql')
  c = conn.cursor()
  if val_s and val_s is not None:
   sql = "SELECT rowid,* FROM def WHERE value LIKE ? ORDER BY rowid DESC LIMIT ? OFFSET ?"
   get = (val_s+'%', limit, offset,)
   c.execute(sql, get)
  elif time_s and time_s is not None:
   sql = "SELECT rowid,* FROM def WHERE time LIKE ? ORDER BY rowid DESC LIMIT ? OFFSET ?"
   get = [time_s+'%', limit, offset]
   c.execute(sql, get)
  else:
   sql = "SELECT rowid,* FROM def ORDER BY rowid DESC LIMIT ? OFFSET ?"
   get = [limit, offset]
   c.execute(sql, get)
  data = c.fetchall()
  conn.close()
  return data

def get_count(rom, limit, offset, val_s, time_s):
  conn = sqlite3.connect('data/db/'+rom+'.sql')
  c = conn.cursor()
  if val_s and val_s is not None:
   sql = "SELECT count(*) FROM def WHERE value LIKE ? ORDER BY rowid DESC LIMIT ? OFFSET ?"
   get = (val_s+'%', limit, offset,)
   c.execute(sql, get)
  elif time_s and time_s is not 'None':
   sql = "SELECT count(*) FROM def WHERE time LIKE ? ORDER BY rowid DESC LIMIT ? OFFSET ?"
   get = [time_s+'%', limit, offset]
   c.execute(sql, get)
  else:
   sql = "SELECT count(*) FROM def ORDER BY rowid DESC LIMIT ? OFFSET ?"
   get = [limit, offset]
   c.execute(sql, get)
  data = c.fetchone()
  conn.close()
  return data

def get_data_mysql(rom, limit, offset, val_s, time_s):
  rom = 'db_'+str(rom)
  limit = int(limit)
  c = mysql.connection.cursor()
  if val_s and val_s is not None:
   sql = "SELECT * FROM {} WHERE value LIKE %s ORDER BY id DESC LIMIT %s OFFSET %s".format(rom)
   get = [val_s+'%', limit, offset]
   c.execute(sql, get)
  elif time_s and time_s is not None:
   sql = "SELECT * FROM {} WHERE time LIKE %s ORDER BY id DESC LIMIT %s OFFSET %s".format(rom)
   get = [time_s+'%', limit, offset]
   c.execute(sql, get)
  else:
   sql = "SELECT * FROM {} ORDER BY id DESC LIMIT %s OFFSET %s".format(rom)
   get = (limit, offset)
   c.execute(sql, get)
  data = c.fetchall()
  return data

def get_count_mysql(rom, limit, offset, val_s, time_s):
  rom = 'db_'+rom
  limit = int(limit)
  c = mysql.connection.cursor()
  if val_s and val_s is not None:
   sql = "SELECT count(*) FROM {} WHERE value LIKE %s ORDER BY id DESC LIMIT %s OFFSET %s".format(rom)
   get = [val_s+'%', limit, offset]
   c.execute(sql, get)
  elif time_s and time_s is not 'None':
   sql = "SELECT count(*) FROM {} WHERE time LIKE %s ORDER BY id DESC LIMIT %s OFFSET %s".format(rom)
   get = [time_s+'%', limit, offset]
   c.execute(sql, get)
  else:
   sql = "SELECT count(*) FROM {} ORDER BY id DESC LIMIT %s OFFSET %s".format(rom)
   get =(limit,offset)
   c.execute(sql, get)

  data = c.fetchone()
  c.close()
  return data

@app.route('/settings/db/edit', methods=['GET', 'POST'])
@login_required
def db_edit():
  if request.method == "GET":
    rom = request.args.get("rom")
    page = request.args.get("page")
    limit = request.args.get("limit")
    val_s = request.args.get("val_s")
    time_s = request.args.get("time_s")

    if request.form.get('send-clear') == 'yes':
      conn = sqlite3.connect('data/db/'+rom+'.sql')
      c = conn.cursor()
      c.execute("DELETE FROM def")
      conn.commit()
      conn.close()
 
    if request.args.get('edit-row') == 'yes':
      rom = request.args.get('rom')
      id = request.args.get('id') 
      val = request.args.get('val') 
      conn = sqlite3.connect('data/db/'+rom+'.sql')
      c = conn.cursor()
      sql = "UPDATE def SET value=? WHERE rowid=?"
      c.execute(sql, (val, id,))
      conn.commit()
      conn.close()

    if request.args.get('del-row') == 'yes':
      rom = request.args.get('rom')
      id = request.args.get('id')
      conn = sqlite3.connect('data/db/'+rom+'.sql')
      c = conn.cursor()
      sql = "DELETE FROM def WHERE rowid=?"
      c.execute(sql, (id,))
      conn.commit()
      conn.close()
  
  offset=0
  #limit=int(limit)
  rom=str(rom)

  if not page:
    page=1
  if not limit:
    limit=100
  if int(page)<1:
    page=1
  
  try:
    count=get_count(rom, limit, offset, val_s, time_s)
    count=count[0]
  except:
    count=0

  pages = (int(count)//int(limit))+2
  offset= (int(page)-1)*int(limit)

  try:
    data=get_data(rom, limit, offset, val_s, time_s)
  except:
    data=[]

  return render_template('db_edit.html', data=data, count=int(count), pages=int(pages), limit=int(limit), page=int(page), rom=str(rom), val_s=str(val_s), time_s=str(time_s))

@app.route('/settings/mysql/edit', methods=['GET', 'POST'])
@login_required
def db_edit_mysql():

  rom = request.args.get("rom")
  page = request.args.get("page")
  limit = request.args.get("limit")
  val_s = request.args.get("val_s")
  time_s = request.args.get('time_s')

  rom = clean.clean(rom)
  rom = rom.clean_rom()

  if request.method == "POST":
    if request.form.get('clear') == 'yes':
      rom = request.form['rom']
      rom = clean.clean(rom)
      rom = rom.clean_rom()
      m = mysql.connection.cursor()
      rom1 = "db_"+rom
      sql = "DELETE FROM {}".format(rom1)
      m.execute(sql)
      m.connection.commit()
      m.close()

    if request.form.get('edit-row') == 'yes':
      rom = request.form['rom']
      id = request.form['id'] 
      val = request.form['val']
      m = mysql.connection.cursor()
      rom = clean.clean(rom)
      rom = rom.clean_rom()
      rom1 = 'db_'+rom
      sql = "UPDATE {} SET value=%s WHERE id=%s".format(rom1)
      get = [val, id]
      m.execute(sql, get)
      m.connection.commit()
      m.close()

    if request.form.get('del-row') == 'yes':
      rom = request.form['rom']
      id = request.form['id']
      m = mysql.connection.cursor()
      rom1 = 'db_'+rom
      sql = "DELETE FROM {} WHERE id=%s".format(rom1)
      get = [id]
      m.execute(sql, get)
      m.connection.commit()
      m.close()
  
  offset=0
  rom=str(rom)

  if not page:
    page=1
  if not limit:
    limit=100
  if int(page)<1:
    page=1
  
  try:
    count=get_count_mysql(rom, limit, offset, val_s, time_s)
    count=count[0]
  except:
    count=0

  pages = (int(count)//int(limit))+2
  offset= (int(page)-1)*int(limit)

  try:
    data=get_data_mysql(rom, limit, offset, val_s, time_s)
  except:
    data=[]

  return render_template('db_edit.html', data=data, count=int(count), pages=int(pages), limit=int(limit), page=int(page), rom=str(rom), val_s=str(val_s), time_s=str(time_s))
