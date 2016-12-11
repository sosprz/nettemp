#! /bin/bash

list=$(cat $dir/install/apt/packages_list)
clear
echo -n -e "Updating repo \r"
apt-get -y update 

clear
echo -n -e "Instaling packages \r"
apt-get -y install $list 

clear
for i in $package; do
    dpkg-query -W -f='${Package}\t\t${Status}' $i 
    exitstatus=$?
    echo -e
    if [ $exitstatus = '1' ]; then
    echo -e No package $i  >> $dir/install_log.txt 2>&1
    echo -e No package $i
    echo -e "[ ${RED}error${R} ] packages"
    exit
    fi
done

exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] packages"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] packages"
fi


