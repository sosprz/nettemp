# init.lua

chage ap and pass in init.lua

push code to ESP
./luatool.py -p /dev/ttyUSB0 -f init.lua -t init.lua
./luatool.py -p /dev/ttyUSB0 -f dht.lua -t dht.lua