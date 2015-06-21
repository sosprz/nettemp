wifi.setmode(wifi.STATION)
wifi.sta.config("ssid","pass")

pin4 = 4
gpio.mode(pin4,gpio.OUTPUT)

srv=net.createServer(net.TCP)
srv:listen(80,function(conn)
    conn:on(
	"receive",function(conn,payload)
	print(payload)
	if string.find(payload,"on") ~= nil then gpio.write(pin4,gpio.HIGH) end
	if string.find(payload,"off") ~= nil then gpio.write(pin4,gpio.LOW) end
	if string.find(payload,"status") ~= nil then conn:send('status ' ..gpio.read(pin4)) end 
	conn:send("nettemp.pl relay") end
	) 
    conn:on("sent",function(conn) conn:close() end) 
end)