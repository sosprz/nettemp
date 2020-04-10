#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
echo $dir
cd $dir
source venv/bin/activate

#restore
python3 $dir/app/scripts/db_schema.py

# update
python3 $dir/app/scripts/db_update.py

# set admin pass
python3 $dir/app/scripts/set_admin.py

chown -R root.www-data $dir
chmod -R 770 $dir
chmod -R g+s $dir

deactivate