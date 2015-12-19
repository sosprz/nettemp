#!/usr/bin/python

import smbus
import time
import os.patch

if  os.path.exists("/dev/i2c-0"):
    bus = "0"
elif os.path.exists("/dev/i2c-1"):
    bus = "1"
elif os.path.exists("/dev/i2c-2"):
     bus = "2"
elif os.path.exists("/dev/i2c-3"):
     bus = "3"

bus = smbus.SMBus(int(bus))
data = bus.read_i2c_block_data(0x48, 0)
msb = data[0]
lsb = data[1]
# Print degrees Celsius
print (((msb << 8) | lsb) >> 4) * 0.0625
