#!/usr/bin/python

import smbus
import time
import os.path
import sys

if len(sys.argv) > 1:
    nbus = sys.argv[1]
elif  os.path.exists("/dev/i2c-0"):
    nbus = "0"
elif os.path.exists("/dev/i2c-1"):
    nbus = "1"
elif os.path.exists("/dev/i2c-2"):
    nbus = "2"
elif os.path.exists("/dev/i2c-3"):
    nbus = "3"

bus = smbus.SMbus(int(nbus))
data = bus.read_i2c_block_data(0x48, 0)
msb = data[0]
lsb = data[1]
# Print degrees Celsius
print (((msb << 8) | lsb) >> 4) * 0.0625
