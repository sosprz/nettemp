#! /bin/bash 

rpi=$(cat /proc/cmdline | awk -v RS=" " -F= '/boardrev/ { print $2 }')
if [ -n "$rpi" ]; then
    echo -e "[ ${GREEN}ok${R} ] Raspberry Pi detected"
fi

