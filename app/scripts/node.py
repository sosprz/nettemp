import requests
requests.packages.urllib3.disable_warnings()
import json
import socket
import os
import mysql.connector
from configobj import ConfigObj

dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
config = ConfigObj(dir+'/data/config.cfg')

mydb = mysql.connector.connect(
  host=config.get('MYSQL_HOST'),
  user=config.get('MYSQL_USER'),
  passwd=config.get('MYSQL_PASSWORD'),
  database=config.get('MYSQL_DB')
)

print("[ nettemp ][ node ]")
hostname = socket.gethostname()
group = hostname

def send(token,data, url):
  r = requests.post(url,headers={'Content-Type':'application/json', 'Authorization': 'Bearer {}'.format(token)},json=data, verify=False)
  print (r.content)

def data():
  m = mydb.cursor()
  sql = "SELECT tmp, name, rom, type, node_url, node_token FROM sensors WHERE node='on' AND nodata!='nodata' AND node_url!='None' AND node_url is not null AND node_token!='None' AND node_token is not null"
  m.execute(sql)
  data = m.fetchall()  
  m.close()
  return data

if data:
  for value, name, rom, type, url, token in data():
    rom = rom+'_'+group
    name = name+'_'+group
    data = [{"rom":rom,"type":type,"name":name,"value":value,"group":group}]
    send(token, data, url)
else:
      print("[ nettemp ][ node ] nothing to do")


