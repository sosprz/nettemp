#!/usr/bin/env python

#script from https://raw.githubusercontent.com/coolex/sdm630/master/get-values.py

import sys

if len(sys.argv) > 1:
getusb = sys.argv[1]
addr = int(sys.argv[2], 16)
brate = int(sys.argv[3],16)
#---------------------------------------------------------------------------# 
# loading pymodbus modules
#---------------------------------------------------------------------------# 
from pymodbus.constants import Endian
from pymodbus.payload import BinaryPayloadDecoder
from pymodbus.payload import BinaryPayloadBuilder
from pymodbus.client.sync import ModbusSerialClient as ModbusClient

#---------------------------------------------------------------------------# 
# client logging
#---------------------------------------------------------------------------# 
import logging
logging.basicConfig()
log = logging.getLogger()
log.setLevel(logging.INFO)

#---------------------------------------------------------------------------# 
# Connect info KW/H meter
#---------------------------------------------------------------------------# 
client = ModbusClient(method='rtu', port=getusb, baudrate=brate, timeout=3)
#client = ModbusClient(method='rtu', port='/dev/ttyUSB0', baudrate=9600, timeout=0.5)
client.connect()

#---------------------------------------------------------------------------# 
# 
#---------------------------------------------------------------------------# 
builder = BinaryPayloadBuilder(endian=Endian.Big)
builder.add_string('abcdefgh')
builder.add_32bit_float(22.34)
builder.add_16bit_uint(0x1234)
builder.add_8bit_int(0x12)
builder.add_bits([0,1,0,1,1,0,1,0])
payload = builder.build()
#address = 0x01
address = addr
result  = client.write_registers(address, payload, skip_encode=True)

#---------------------------------------------------------------------------# 
# Read data and convert to float and creating output files
#---------------------------------------------------------------------------# 

#L1 V
result  = client.read_input_registers(0x00, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",
#L1 A
result  = client.read_input_registers(0x06, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",
#L1 W
result  = client.read_input_registers(0x0C, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",

#L2 V
result  = client.read_input_registers(0x02, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",
#L2 A
result  = client.read_input_registers(0x08, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",
#L2 W
result  = client.read_input_registers(0x0E, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",

#L3 V
result  = client.read_input_registers(0x04, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",
#L3 A
result  = client.read_input_registers(0x0A, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",
#L3 W
result  = client.read_input_registers(0x10, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",
#all
result  = client.read_input_registers(0x48, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",

# 0x3C -suma energii biernej z 3 faz. (0x18 - L1, 0x1A -L2, 0x1C -L3)
result  = client.read_input_registers(0x3C, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",

# 0x4A -export energii czynnej (kWh)
result  = client.read_input_registers(0x4A, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",

# 0x4E - eksport energii biernej (kVArh)
result  = client.read_input_registers(0x4E, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",

# 0x4C - import energii biernej (kVArh)
result  = client.read_input_registers(0x4C, 2)
decoder = BinaryPayloadDecoder.fromRegisters(result.registers, endian=Endian.Big)
print '{0:0.2f}'.format(decoder.decode_32bit_float()), "\n",

#---------------------------------------------------------------------------# 
# close the client
#---------------------------------------------------------------------------# 
client.close()

