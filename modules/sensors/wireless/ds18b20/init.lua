--'
-- 18b20 one wire example for NODEMCU
-- NODEMCU TEAM
-- LICENCE: http://opensource.org/licenses/MIT
-- Vowstar <vowstar@nodemcu.com>
-- code from http://www.esp8266.com/viewtopic.php?f=19&t=752
--' 

print(wifi.sta.getip())
wifi.setmode(wifi.STATION)
wifi.sta.config("ap","pass")
print(wifi.sta.getip())



    pin = 4
    ow.setup(pin)

    counter=0
    lasttemp=-999

    function bxor(a,b)
       local r = 0
       for i = 0, 31 do
          if ( a % 2 + b % 2 == 1 ) then
             r = r + 2^i
          end
          a = a / 2
          b = b / 2
       end
       return r
    end

    function getTemp()
            tmr.wdclr()     
            ow.reset(pin)
            ow.skip(pin)
            ow.write(pin,0x44,1)
            tmr.delay(800000)
            ow.reset(pin)
            ow.skip(pin)
            ow.write(pin,0xBE,1)

            data = nil
            data = string.char(ow.read(pin))
            data = data .. string.char(ow.read(pin))
            t = (data:byte(1) + data:byte(2) * 256)
             if (t > 32768) then
                        t = (bxor(t, 0xffff)) + 1
                        t = (-1) * t
                       end
             t = t * 625
                       lasttemp = t
             print("Last temp: " .. lasttemp)
    end

    srv=net.createServer(net.TCP)
    srv:listen(80,function(conn)
        getTemp()
        t1 = lasttemp / 10000
        t2 = (lasttemp >= 0 and lasttemp % 10000) or (10000 - lasttemp % 10000)
	conn:send("<!DOCTYPE html><html><body><p><b>nettemp.pl ds18b20</b><br>Temperature: " .. string.format("%2d", t1) .. "." .. string.format("%02d", t2) .. "</p></body></html>")
       conn:on("sent",function(conn) conn:close() end)
    end)


