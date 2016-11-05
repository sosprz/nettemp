#!/usr/bin/env python
#
# !!! Needs psutil (+ dependencies) installing:
#
#    $ sudo apt-get install python-dev
#    $ sudo pip install psutil
#

import os
import sys
if os.name != 'posix':
    sys.exit('platform not supported')

from datetime import datetime
from oled.device import ssd1306, sh1106
from oled.render import canvas
from PIL import ImageFont

fname = "/var/www/nettemp/tmp/lcd"

def stats(oled):
    font = ImageFont.load_default()
    font2 = ImageFont.truetype('fonts/C&C Red Alert [INET].ttf', 22)
    with canvas(oled) as draw:
	with open(fname) as f:
	    for i, line in enumerate(f):
		if i == 1:
        	    draw.text((0, 0), line, font=font2, fill=255)
		elif i == 2:
    		    draw.text((0, 22), line, font=font2, fill=255)
		elif i == 3:
    		    draw.text((0, 44), line, font=font2, fill=255)

def main():
    oled = ssd1306(port=1, address=0x3C)
    stats(oled)

if __name__ == "__main__":
    main()
