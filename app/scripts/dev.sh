#! /bin/bash

trap 'systemctl start gunicorn.service' EXIT
systemctl stop gunicorn.service
source venv/bin/activate

export PYTHONDONTWRITEBYTECODE=1
export FLASK_APP=nettemp.py
export FLASK_ENV=development
export FLASK_RUN_PORT=8080
export FLASK_RUN_HOST=127.0.0.1
flask run