#! /bin/bash -x

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

cd $dir
git pull
python3 $dir/app/scripts/db_update.py
$dir/app/scripts/perms.sh
systemctl restart gunicorn

