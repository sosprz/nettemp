#! /bin/bash -x

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

mkdir -p $dir/data/db
mkdir -p $dir/data/dbf
mkdir -p $dir/data/dba
mkdir -p $dir/data/sensors/dht22/

chown -R root.www-data $dir
chmod -R 770 $dir
chmod -R g+s $dir


