#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
cp $dir/etc/gunicorn_dev.service /etc/systemd/system/gunicorn.service
systemctl enable --now gunicorn
systemctl daemon-reload
systemctl restart gunicorn
