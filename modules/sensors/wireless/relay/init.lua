wifi.setmode(wifi.STATION)
wifi.sta.config("ssid","pass")

pin = 4
gpio.mode(pin,gpio.OUTPUT)

srv=net.createServer(net.TCP)
srv:listen(80,function(conn)
    conn:on(
	"receive",function(conn,payload)
	print(payload)
	if string.find(payload,"on") ~= nil then gpio.write(pin,gpio.HIGH) end
	if string.find(payload,"off") ~= nil then gpio.write(pin,gpio.LOW) end
	if string.find(payload,"status") ~= nil then conn:send('status' .. gpio.read(pin) .. ) end 
	conn:send("nettemp.pl relay") end
	) 
    conn:on("sent",function(conn) conn:close() end) 
end)