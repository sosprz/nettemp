#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
cp $dir/etc/config.cfg $dir/data/
x=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
x1=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
sed -i "s/\"random_secret_key_for_nettemp\"/\"$x\"/g" $dir/data/config.cfg
sed -i "s/\"random_secret_key_for_nettemp_jwt\"/\"$x1\"/g" $dir/data/config.cfg
