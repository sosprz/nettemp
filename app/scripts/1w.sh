#! /bin/bash

CONFIG=/boot/config.txt

act="$1"


if [ "$act" == "on" ]; then
    sed $CONFIG -i -e "s/^#dtoverlay=w1-gpio/dtoverlay=w1-gpio/"
    if ! grep -q -E "^dtoverlay=w1-gpio" $CONFIG; then
      printf "dtoverlay=w1-gpio\n" >> $CONFIG
    fi

elif [ "$act" == "off" ]; then
    sed $CONFIG -i -e "s/^dtoverlay=w1-gpio/#dtoverlay=w1-gpio/"
fi

if grep -q -E "^dtoverlay=w1-gpio" $CONFIG; then
  echo "on"
else 
  w1=off
  echo "off"
fi


