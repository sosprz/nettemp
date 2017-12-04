#! /bin/bash 

{
cd $dir/install/sdm120
make install
cd $dir
} >> $dir/install_log.txt 2>&1

exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] SDM120"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] SDM120"
fi

