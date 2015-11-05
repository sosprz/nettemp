#!/usr/bin/env python

#http://ciaduck.blogspot.com/2014/12/mpl3115a2-sensor-with-raspberry-pi.html

from smbus import SMBus
import time
import sys

# Special Chars
deg = u'\N{DEGREE SIGN}'

# I2C Constants
ADDR = 0x60
CTRL_REG1 = 0x26
PT_DATA_CFG = 0x13

nbus = sys.argv[1]
bus = SMBus(int(nbus))

who_am_i = bus.read_byte_data(ADDR, 0x0C)
print hex(who_am_i)
if who_am_i != 0xc4:
    print "Device not active."
    exit(1)

# Set oversample rate to 128
setting = bus.read_byte_data(ADDR, CTRL_REG1)
newSetting = setting | 0x38
bus.write_byte_data(ADDR, CTRL_REG1, newSetting)

# Enable event flags
bus.write_byte_data(ADDR, PT_DATA_CFG, 0x07)

# Toggel One Shot
setting = bus.read_byte_data(ADDR, CTRL_REG1)
if (setting & 0x02) == 0:
    bus.write_byte_data(ADDR, CTRL_REG1, (setting | 0x02))

# Read sensor data
print "Waiting for data..."
status = bus.read_byte_data(ADDR,0x00)
while (status & 0x08) == 0:
    #print bin(status)
    status = bus.read_byte_data(ADDR,0x00)
    time.sleep(0.5)

print "Reading sensor data..."
p_data = bus.read_i2c_block_data(ADDR,0x01,3)
t_data = bus.read_i2c_block_data(ADDR,0x04,2)
status = bus.read_byte_data(ADDR,0x00)
print "status: "+bin(status)

p_msb = p_data[0]
p_csb = p_data[1]
p_lsb = p_data[2]
t_msb = t_data[0]
t_lsb = t_data[1]

pressure = (p_msb << 10) | (p_csb << 2) | (p_lsb >> 6)
p_decimal = ((p_lsb & 0x30) >> 4)/4.0

celsius = t_msb + (t_lsb >> 4)/16.0
fahrenheit = (celsius * 9)/5 + 32

print "Pressure and Temperature at "+time.strftime('%m/%d/%Y %H:%M:%S%z')
print str(pressure+p_decimal)+" Pa"
print str(celsius)+deg+"C"
print str(fahrenheit)+deg+"F"
