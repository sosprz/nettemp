#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

dstdir=$dir/app/schema/nettemp.sql

echo "BEGIN TRANSACTION;" > $dstdir
sqlite3 $dir/data/dbf/nettemp.db ".schema" >> $dstdir
echo "COMMIT;" >> $dstdir
