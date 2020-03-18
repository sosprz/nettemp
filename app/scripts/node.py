import requests
requests.packages.urllib3.disable_warnings()
import json
import sqlite3
import socket
import os
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
DB=dir+'/data/dbf/nettemp.db'

print("[ nettemp ] NODE")
hostname = socket.gethostname()
group = hostname

def send(token,data, url):
  r = requests.post(url,headers={'Content-Type':'application/json', 'Authorization': 'Bearer {}'.format(token)},json=data, verify=False)
  print (r.content)

def data():
  conn = sqlite3.connect(DB)
  c = conn.cursor()
  c.execute(''' SELECT tmp, name, rom, type, node_url, node_token FROM sensors WHERE node='on' AND nodata!='nodata' AND node_url!='None' AND node_url is not null AND node_token!='None' AND node_token is not null ''')
  data = c.fetchall()  
  conn.close()
  return data

if data:
  for value, name, rom, type, url, token in data():
    rom = rom+'-'+group
    name = name+'-'+group
    data = [{"rom":rom,"type":type,"name":name,"value":value,"group":group}]
    send(token, data, url)
else:
      print("[ nettemp ] nothing to do")


