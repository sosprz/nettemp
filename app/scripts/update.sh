#! /bin/bash -x

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

systemctl stop gunicorn
cd $dir
git pull
$dir/app/scripts/apt.sh
source venv/bin/activate
python3 $dir/app/scripts/db_update.py
python3 $dir/app/scripts/sensors_db_fix.py
pip install -r $dir/requirements.txt
deactivate
$dir/app/scripts/perms.sh
$dir/app/scripts/sudo.sh
$dir/app/scripts/cron_update.sh
systemctl start gunicorn

