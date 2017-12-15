#! /bin/bash 

{
install/1w/1wire on off off
} >> $dir/install_log.txt 2>&1

exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] 1wire"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] 1wire"
fi
