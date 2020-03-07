import requests
url = "http://localhost:8080/sensor"

data = {"rom":"psos","type":"temp", "device":"1wire", "ip":"", "gpio":"", "i2c":"", "usb":"","name":"psos","value":"-10"}
r = requests.post(url,json=data)

data = {"rom":"press","type":"press","device":"usb", "ip":"", "gpio":"", "i2c":"", "usb":"","name":"press","value":"10"}
r = requests.post(url,json=data)

data = {"rom":"humid","type":"humid","device":"usb", "ip":"", "gpio":"", "i2c":"", "usb":"","name":"humid","value":"10"}
r = requests.post(url,json=data)