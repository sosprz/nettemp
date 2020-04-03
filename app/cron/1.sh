#! /bin/bash

start=`date +%s`
dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
time=$1

echo "[ nettemp ][ cron ] Script time: " $time
echo [ nettemp ][ cron ] `date "+%Y-%m-%d %H:%M:%S"`

scripts() {
  source $dir/venv/bin/activate
  cd $dir
  # NO background
  python3 app/scripts/no_data.py
  # mail, allow background &
  cd $dir
  python3 app/scripts/alarm_send_mail.py &
  # 4 node, allow background &
  cd $dir
  python3 app/scripts/node.py &
  # 5 system, allow background &
  wait
  cd $dir
  python3 app/scripts/system.py
}

sensors() {
  source $dir/venv/bin/activate
  sdir=$dir/data/sensors/enabled/$time/
  for f in $(ls $sdir)
  do
    echo [ nettemp ][ cron ] `date "+%Y-%m-%d %H:%M:%S"` run  $sdir$f
    python3 $sdir$f &
  done
  wait
}

if [[ $time == '01' ]]; then
  sensors
  scripts
elif [[ $time == '05' ]] || [[ $time == '10' ]] || [[ $time == '15' ]] || [[ $time == '20' ]] || [[ $time == '30' ]] || [[ $time == '60' ]]; then
  sensors
fi

end=`date +%s`
echo [ nettemp ][ cron ] Execution time `expr $end - $start` seconds.
