#! /bin/bash

DIR=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

/bin/bash $DIR/app/scripts/ds2482.sh
/bin/rm $DIR/data/reboot
/bin/rm $DIR/data/nettemp.pid
