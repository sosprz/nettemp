#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

sudo chmod -R 775 $dir
sudo chown -R root.www-data $dir

sqlite3 -cmd ".timeout 2000" $dir/dbf/nettemp.db "CREATE TABLE g_func (id INTEGER PRIMARY KEY, position INTEGER DEFAULT 0, sensor TEXT, sensor2 TEXT, onoff TEXT, value TEXT, op TEXT, hyst TEXT, source TEXT, gpio TEXT, w_profile TEXT);"

