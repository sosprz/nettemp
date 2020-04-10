#!/usr/bin/python3

import mysql.connector
import os,re
from configobj import ConfigObj

dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
config = ConfigObj(dir+'/data/config.cfg')

mydb = mysql.connector.connect(
  host=config.get('MYSQL_HOST'),
  user=config.get('MYSQL_USER'),
  passwd=config.get('MYSQL_PASSWORD'),
  database=config.get('MYSQL_DB')
)


statement = ""
m = mydb.cursor()  
for line in open(dir+'/app/schema/nettemp.sql'):
  if re.match(r'--', line):  # ignore sql comment lines
    continue
  if not re.search(r';$', line):  # keep appending lines that don't end in ';'
    statement = statement + line
  else:  # when you get a line ending in ';' then exec statement and reset for next statement
    statement = statement + line
    #print "\n\n[DEBUG] Executing SQL statement:\n%s" % (statement)
    try:
      m.execute(statement)
    except (OperationalError, ProgrammingError) as e:
      print("\n[WARN] MySQLError during execute statement \n\tArgs: '%s'" % (str(e.args)))
    statement = ""

mydb.commit()

