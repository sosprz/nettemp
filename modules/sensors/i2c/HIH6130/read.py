#!/usr/bin/python

#code from https://github.com/dhhagan/python-hih6130

from io import HIH6130

rht = HIH6130()
rht.read()
print ("RH: {0} Temp: {1}".format(rht.rh, rht.t))