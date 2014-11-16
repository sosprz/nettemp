#!/usr/bin/env python
import math
import time
import sys, os
from ctypes import *
#cdll.LoadLibrary("./bcm2835.so")
dir=os.getcwd()
sensor = CDLL(dir + "/modules/sensors/i2c/MPL3115A2/sensor.so")

class mpl3115a2:
	def __init__(self):
		if (0 == sensor.bcm2835_init()):
			print "bcm3835 driver init failed."
			return
			
	def writeRegister(self, register, value):
	    sensor.MPL3115A2_WRITE_REGISTER(register, value)
	    
	def readRegister(self, register):
		return sensor.MPL3115A2_READ_REGISTER(register)

	def active(self):
		sensor.MPL3115A2_Active()

	def standby(self):
		sensor.MPL3115A2_Standby()

	def initAlt(self):
		sensor.MPL3115A2_Init_Alt()

	def initBar(self):
		sensor.MPL3115A2_Init_Bar()

	def readAlt(self):
		return sensor.MPL3115A2_Read_Alt()

	def readTemp(self):
		return sensor.MPL3115A2_Read_Temp()

	def setOSR(self, osr):
		sensor.MPL3115A2_SetOSR(osr);

	def setStepTime(self, step):
		sensor.MPL3115A2_SetStepTime(step)

	def getTemp(self):
		t = self.readTemp()
		t_m = (t >> 8) & 0xff;
		t_l = t & 0xff;

		if (t_l > 99):
			t_l = t_l / 100.0
		else:
			t_l = t_l / 10.0
		return (t_m + t_l)

	def getAlt(self):
		alt = self.readAlt()
		alt_m = alt >> 8 
		alt_l = alt & 0xff
		
		if (alt_l > 99):
			alt_l = alt_l / 10.0
		else:
			alt_l = alt_l / 1.0
			
		return self.twosToInt(alt_m, 16) + alt_l
	def getBar(self):
		alt = self.readAlt()
		alt_m = alt >> 6 
		alt_l = alt & 0x03
		
		if (alt_l > 99):
			alt_l = alt_l
		else:
			alt_l = alt_l

		return (self.twosToInt(alt_m, 18) / 100.0)

	def twosToInt(self, val, len):
		# Convert twos compliment to integer
		if(val & (1 << len - 1)):
			val = val - (1<<len)

		return val
		
mpl = mpl3115a2()
#mpl.initAlt()
mpl.initBar()
mpl.active()
time.sleep(1)
while 1:
        print "Press:", mpl.getBar(), "Temp:", mpl.getTemp()
	#time.sleep(0.1)
	break