import requests
url = "http://localhost:8080/local"


for i in -4,-2,2,4,6:
  data = {"rom":"psos","type":"temp", "device":"1wire", "ip":"", "gpio":"", "i2c":"", "usb":"","name":"psos","value":i}
  r = requests.post(url,json=data)

  data = {"rom":"press","type":"press","device":"usb", "ip":"", "gpio":"", "i2c":"", "usb":"","name":"press","value":i}
  r = requests.post(url,json=data)

  data = {"rom":"humid","type":"humid","device":"usb", "ip":"", "gpio":"", "i2c":"", "usb":"","name":"humid","value":i}
  r = requests.post(url,json=data)