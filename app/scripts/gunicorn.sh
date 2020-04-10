#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
cp $dir/etc/gunicorn.service /etc/systemd/system/
systemctl enable --now gunicorn
systemctl daemon-reload
systemctl start gunicorn
systemctl restart gunicorn
