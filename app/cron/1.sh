#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../ && pwd )

# sensors
source $dir/../venv/bin/activate
cd $dir/sensors/enabled/

for f in $(ls)
do
    python3 $f
done

# mail
cd $dir && cd ..
python3 -m app.modules.send_mail


# node
cd $dir && cd ..
python3 app/scripts/node.py

# no data
cd $dir && cd ..
python3 app/scripts/no_data.py