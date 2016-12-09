#! /bin/bash

echo "Please wait installing packages"
{
	
package=$(cat packages_list)

echo $package

apt-get -y update
apt-get -y install $package
} >> $dir/install_log.txt 2>&1

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


