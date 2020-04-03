#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
if cat /proc/cpuinfo |grep Raspberry; then
  if cat /etc/modules |grep i2c-dev 1> /dev/null; then
    echo -e "[ ${GREEN}ok${R} ] i2c-dev allready added"
    else
    sed -i '$ai2c-dev' /etc/modules
    touch $dir/data/reboot
    fi

  if ! grep -q -E "^(device_tree_param|dtparam)=([^,]*,)*i2c(_arm)?=[^,]*" /boot/config.txt; then
    printf "dtparam=i2c_arm=on\n" >> /boot/config.txt
    touch $dir/data/reboot
  fi

fi
