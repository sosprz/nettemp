import requests
import json
requests.packages.urllib3.disable_warnings()

url = "https://172.18.10.12/register"

data = {'username':'admin','password':'admin'}
print ("[*] Register and send", (data))
headers={'Accept':'application/json','Content-Type': 'application/json'}
r = requests.post(url, data=json.dumps(data), headers=headers, verify=False)
token=r.json()
print ('[*] Got access_token')
token=token['access_token']
print (token)

def send(token,data):
  url = "https://172.18.10.12/sensor"
  r = requests.post(url,headers={'Content-Type':'application/json', 'Authorization': 'Bearer {}'.format(token)},json=data, verify=False)
  print (r.content)

data = {"rom":"test_test","type":"temp", "device":"1wire", "ip":"", "gpio":"", "i2c":"", "usb":"","name":"psos","value":"-10"}
send(token, data)
print ('[*] Data send with access_token')


#r = requests.post(url,json=data)

#data = {"rom":"press","type":"press","device":"usb", "ip":"", "gpio":"", "i2c":"", "usb":"","name":"press","value":"10"}
#r = requests.post(url,json=data)

#data = {"rom":"humid","type":"humid","device":"usb", "ip":"", "gpio":"", "i2c":"", "usb":"","name":"humid","value":"10"}
#r = requests.post(url,json=data)