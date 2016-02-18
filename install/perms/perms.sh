#! /bin/bash

umask 002 $dir/tmp
umask 002 $dir/db
umask 002 $dir/dbf

$dir/modules/tools/update_su
$dir/modules/tools/update_perms

