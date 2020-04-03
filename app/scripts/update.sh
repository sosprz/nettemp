#! /bin/bash -x

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

systemctl stop gunicorn
cd $dir
git pull
python3 $dir/app/scripts/db_update.py
$dir/app/scripts/perms.sh
$dir/app/scripts/sudo.sh
$dir/app/scripts/cron_update.sh
systemctl start gunicorn

