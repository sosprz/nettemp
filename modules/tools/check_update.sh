#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

#http://stackoverflow.com/questions/3258243/check-if-pull-needed-in-git

[ $(git rev-parse HEAD) = $(git ls-remote $(git rev-parse --abbrev-ref @{u} | \
sed 's/\// /g') | cut -f1) ] && echo up to date || touch $dir/tmp/update

chmod 777 $dir/tmp/update

