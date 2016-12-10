#! /bin/bash

package=$(cat $dir/install/apt/packages_list)
clear
echo -n -e "Updating repo \r"
{
	apt-get -y update
}  >> $dir/install_log.txt 2>&1

for i in $package
    do
    clear
    echo -n -e "Installing $i \r"
    { 
	apt-get -y install $i 
    } >> $dir/install_log.txt 2>&1
done


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






echo "Please wait installing packages"
package=$($dir/install/apt/packages_list)

{
package=$(cat packages_list)
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


