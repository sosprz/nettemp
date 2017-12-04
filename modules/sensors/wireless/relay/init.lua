wifi.setmode(wifi.STATION)
wifi.sta.config("ssid","pass")

pin = 4
gpio.mode(pin,gpio.OUTPUT)
state = 'not'

srv=net.createServer(net.TCP)
srv:listen(80,function(conn)
    conn:on(
	"receive",function(conn,payload)
	print(payload)
	if string.find(payload,"seton") ~= nil then 
	    gpio.write(pin,gpio.HIGH) 
	    state = 'on'
	end
	if string.find(payload,"setoff") ~= nil then 
	    gpio.write(pin,gpio.LOW) 
	    state = 'off'
	end
	if string.find(payload,"showstatus") ~= nil then 
	    conn:send('status ' .. state) 
	else 
	conn:send("nettemp.pl relay") 
	end
	end) 
    conn:on("sent",function(conn) conn:close() end) 
end)