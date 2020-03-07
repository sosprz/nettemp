#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
echo $dir

# dump
#sqlite3 $dir/data/dbf/nettemp.db .dump > $dir/data/dbf/nettemp.dump

# reset
rm $dir/data/dbf/nettemp.db
sqlite3 -cmd '.timeout 2000' $dir/data/dbf/nettemp.db < $dir/app/schema/nettemp.sql

#restore 
#sqlite3 $dir/data/dbf/nettemp.db < $dir/data/dbf/nettemp.dump

# update
python3 $dir/app/scripts/db_update.py

# set admin pass
cd $dir
source venv/bin/activate
python3 $dir/app/scripts/set_admin.py

chown -R root.www-data $dir
chmod -R 770 $dir
chmod -R g+s $dir
