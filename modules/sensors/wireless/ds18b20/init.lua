wifi.setmode(wifi.STATION)
wifi.sta.config("ssid","pass")
print(wifi.sta.getip())

require('ds18b20')
ds18b20.setup(4)
srv=net.createServer(net.TCP)
srv:listen(80,
     function(conn)
          conn:send("<!DOCTYPE HTML>" ..
              "<html><body>" ..
              "<b>nettemp.pl ds18b20</b><br>" ..
              "Temperature: " .. ds18b20.read() .. "<br>" ..
              "</html></body>")          
          conn:on("sent",function(conn) conn:close() end)
     end
)
