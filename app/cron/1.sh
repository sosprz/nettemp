#! /bin/bash

start=`date +%s`
dir=$( cd "$( dirname "$0" )" && cd ../ && pwd )

# 1 sensors
source $dir/../venv/bin/activate
cd $dir/sensors/enabled/

for f in $(ls)
do
    python3 $f &
done

wait

# 2 no data #
cd $dir && cd ..
python3 app/scripts/no_data.py

# 3 mail, allow background &
cd $dir && cd ..
python3 app/scripts/alarm_send_mail.py &

# 4 node, allow background &
cd $dir && cd ..
python3 app/scripts/node.py &

# 5 system, allow background &
cd $dir && cd ..
python3 app/scripts/system.py

wait
end=`date +%s`
echo Execution time was `expr $end - $start` seconds.
