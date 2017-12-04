#! /bin/bash 

{
cd /tmp
git clone https://github.com/adafruit/Adafruit_Python_BMP
cd Adafruit_Python_BMP
sudo python setup.py install

git clone https://github.com/adafruit/Adafruit_Python_DHT.git
cd Adafruit_Python_DHT
sudo python setup.py install
cd $dir
} >> $dir/install_log.txt 2>&1

exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] DHT"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] DHT"
fi




