#!/usr/bin/python
# -*- coding: UTF-8 -*-

import serial, time, struct, array, sys
from datetime import datetime

if len(sys.argv) > 1:
    usb = sys.argv[1]

ser = serial.Serial()
ser.port = usb
ser.baudrate = 9600

ser.open()
ser.flushInput()

byte, lastbyte = "\x00", "\x00"
cnt = 0
while True:
    lastbyte = byte
    byte = ser.read(size=1)
#    print("Got byte %x" %ord(byte))
    # We got a valid packet header
    if lastbyte == "\xAA" and byte == "\xC0":
        sentence = ser.read(size=8) # Read 8 more bytes
#        print "Sentence size {}".format(len(sentence))
        readings = struct.unpack('<hhxxcc',sentence) # Decode the packet - big endian, 2 shorts for pm2.5 and pm10, 2 reserved bytes, checksum, message tail
#        print array.array('B',sentence)
        pm_25 = readings[0]/10.0
        pm_10 = readings[1]/10.0
        # ignoring the checksum and message tail
        
        if (cnt == 0 ):
            line = "{} {}".format(pm_25, pm_10)
            #print(datetime.now().strftime("%d %b %Y %H:%M:%S.%f: ")+line)
	    print(line)
        cnt += 1
        if (cnt == 1):
        #    cnt = 0
	    break
	
 