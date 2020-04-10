#! /bin/bash -x

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

mkdir -p $dir/data/db
mkdir -p $dir/data/dbf
mkdir -p $dir/data/dba
mkdir -p $dir/data/upload
mkdir -p $dir/data/sensors/dht22/
mkdir -p $dir/data/sensors/dht11/
mkdir -p $dir/data/sensors/enabled/01/
mkdir -p $dir/data/sensors/enabled/05/
mkdir -p $dir/data/sensors/enabled/10/
mkdir -p $dir/data/sensors/enabled/15/
mkdir -p $dir/data/sensors/enabled/20/
mkdir -p $dir/data/sensors/enabled/30/
mkdir -p $dir/data/sensors/enabled/60/

chown -R root.www-data $dir
chmod -R 770 $dir
chmod -R g+s $dir


