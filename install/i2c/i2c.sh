#! /bin/bash 

{
if [ -n "$rpi" ]; then
    if cat /etc/modules |grep i2c-bcm2708 1> /dev/null; then
	echo -e "[ ${GREEN}ok${R} ] i2c-bcm2708  allready added"
    else
	sed -i '$ai2c-bcm2708' /etc/modules
    fi
fi

if cat /etc/modules |grep i2c-dev 1> /dev/null; then
	echo -e "[ ${GREEN}ok${R} ] i2c-dev allready added"
    else
	sed -i '$ai2c-dev' /etc/modules
    fi

if ! grep -q -E "^(device_tree_param|dtparam)=([^,]*,)*i2c(_arm)?=[^,]*" /boot/config.txt; then
    printf "dtparam=i2c_arm=on\n" >> /boot/config.txt
fi
    
modprobe i2c-bcm2708
modprobe i2c-dev
touch $dir/tmp/reboot

} >> $dir/install_log.txt 2>&1

exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] I2C"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] I2C"
fi


