#! /bin/bash

sudo apt-get install i2c-tools python-smbus python-pip libjpeg-dev
sudo pip install pillow
git clone https://github.com/rm-hull/ssd1306
cd ssd1306
sudo python setup.py install