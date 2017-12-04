--    Test communication of DHT sensor
--    Tested with Lua NodeMCU 0.9.5 build 20150127 floating point !!!
-- 1. Flash Lua NodeMCU to ESP module.
-- 2. Set in program wots.lua humidity sensor type. This is parameter typeSensor="dht11" or "dht22".
-- 3. Load program init.lua and dht.lua to ESP8266 with LuaLoader
-- 4. HW reset module
-- 5. Run program wots.lua - dofile(wots.lua)
-- 6. techfreak.pl - add server www
 



sensorType="dht11"          -- set sensor type dht11 or dht22
 
    PIN = 7 
    humi=0
    temp=0
    --load DHT module for read sensor
function ReadDHT()
    dht=require("dht")
    dht.read(PIN)
    chck=1
    h=dht.getHumidity()
    t=dht.getTemperature()
    if h==nil then h=0 chck=0 end
    if sensorType=="dht11"then
        humi=h/256
        temp=t/256
    else
        humi=h/10
        temp=t/10
    end
    fare=(temp*9/5+32)
    --print("Humidity:    "..humi.."%")
    --print("Temperature: "..temp.."C")
    -- release module
    dht=nil
    package.loaded["dht"]=nil
end

function readADC()                 -- simple read adc function
         vcc = vcc+adc.read(0)*4/978
         return vcc
end 

wifi.setmode(wifi.STATION)
wifi.sta.config("gateway7","142w1f1m0rm0w1f1142")
ip = wifi.sta.getip()
print(ip)  

srv=net.createServer(net.TCP)
    srv:listen(80,function(conn)
	ReadDHT()
	readADC()
    conn:send("<!DOCTYPE html><html><body><b>nettemp.pl DHT11V</b><br>Humidity: " .. string.format("%d",humi) .. " %<br>Temperature: " .. string.format("%d",temp) .. " &degC <br>Voltage: " .. vcc .. " </body></html>")
    conn:on("sent",function(conn) conn:close() end)
end)

