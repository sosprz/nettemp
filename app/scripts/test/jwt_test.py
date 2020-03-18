import requests
import json
requests.packages.urllib3.disable_warnings()

url = "https://172.18.10.13/register"

data = {'username':'admin','password':'admin'}
print ("[*] Register and send", (data))
headers={'Accept':'application/json','Content-Type': 'application/json'}
r = requests.post(url, data=json.dumps(data), headers=headers, verify=False)
token=r.json()
print ('[*] Got access_token')
token=token['access_token']
print (token)

def send(token,data):
  url = "https://172.18.10.13/sensor"
  r = requests.post(url,headers={'Content-Type':'application/json', 'Authorization': 'Bearer {}'.format(token)},json=data, verify=False)
  print (r.content)

data = [{"rom":"test1","type":"temp", "name":"test1","value":"-10"},{"rom":"test2","type":"temp", "name":"test2","value":"-10"}]
#data = [{"rom":"test1","type":"temp", "name":"test1","value":"-10"}]
send(token, data)
print ('[*] Data send with access_token')


