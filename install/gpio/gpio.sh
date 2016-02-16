#! /bin/bash 


{
git clone git://git.drogon.net/wiringPi 
cd wiringPi
./build
cd $dir
} >> $dir/install_log.txt 2>&1

exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] GPIO"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] GPIO"
fi





