#! /bin/bash

echo -n -e "Updating repo \r"
apt -y update 
apt -y install sqlite3 git-core mc htop sudo i2c-tools lm-sensors nginx python3-pip python3-venv acl mariadb-server libmariadb-dev libgpiod2 mycli libatlas-base-dev
