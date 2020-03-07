#! /bin/bash -x

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

if [[ -e /dev/i2c-0 ]]; then
    nbus="i2c-0"
elif [[ -e /dev/i2c-1 ]]; then
    nbus="i2c-1"
elif [[ -e /dev/i2c-2 ]]; then
    nbus="i2c-2"
elif [[ -e /dev/i2c-3 ]]; then
    nbus="i2c-3"
fi


if [[ -e $dir/data/sensors/ds2482 ]]; then
  modprobe ds2482
  modprobe w1-therm
  sleep 3
  echo ds2482 0x18 > /sys/bus/i2c/devices/$nbus/new_device
  sleep 3
  echo ds2482 0x19 > /sys/bus/i2c/devices/$nbus/new_device
  sleep 3 
  echo ds2482 0x1a > /sys/bus/i2c/devices/$nbus/new_device
  sleep 3 
  echo ds2482 0x1b > /sys/bus/i2c/devices/$nbus/new_device
  sleep 3
  echo 0 > /sys/bus/w1/devices/w1_bus_master1/w1_master_pullup

  #echo 0 > /sys/bus/w1/devices/w1_bus_master1/w1_master_search

fi

