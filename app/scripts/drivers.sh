#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
cd $dir
source venv/bin/activate
pip install -r requirements2.txt
pip install git+https://github.com/nicmcd/vcgencmd.git
deactivate
