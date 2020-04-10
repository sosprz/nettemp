#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

mysqldump -u root -p --no-data nettemp | sed 's/ AUTO_INCREMENT=[0-9]*//g' > $dir/app/schema/nettemp.sql