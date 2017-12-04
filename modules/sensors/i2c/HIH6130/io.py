import smbus
import os.path
import sys
from datetime import datetime

__all__ = ['HIH6130']


class HIH6130:
	''' HIH6130() returns an instance of the RHT sensor with default address of 0x27. '''
	def __init__(self, address = 0x27):
		self.address = address
		self.status = None
		self.rh = None
		self.t = None
		self._buffer = None
		self.timestamp = None

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
    
                try:
                       
                       self.i2c = smbus.SMBus(int(nbus))
		
		except:
			raise IOError("Could not find i2c device.")

		return

	def read(self):
		''' updates rh, t, and timestamp for the HIH6130 instance '''
		try:
			self._buffer = self.i2c.read_i2c_block_data(self.address, 1, 4)
		except:
			raise IOError("Could not read from i2c device located at %s." % self.address )
		
		self.timestamp = datetime.now()
		self.status = self._buffer[0] >> 6 & 0x03
		self.rh = round(((self._buffer[0] & 0x3f) << 8 | self._buffer[1]) * 100.0 / (2**14 - 1), 2)
		self.t = round((float((self._buffer[2] << 6) + (self._buffer[3] >> 2)) / (2**14 - 1)) * 165.0 - 40, 2)

		return