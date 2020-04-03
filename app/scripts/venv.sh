#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
cd $dir
python3 -m venv venv
source venv/bin/activate
pip install -r requirements.txt
pip install git+https://github.com/nicmcd/vcgencmd.git
deactivate
