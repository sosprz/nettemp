#!/usr/bin/python

import smbus
import time
import sys

nbus = sys.argv[1]
bus = smbus.SMBus(int(nbus))
data = bus.read_i2c_block_data(0x48, 0)
msb = data[0]
lsb = data[1]
# Print degrees Celsius
print (((msb << 8) | lsb) >> 4) * 0.0625
