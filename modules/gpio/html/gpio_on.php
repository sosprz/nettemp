<?php
    exec("/usr/local/bin/gpio -g mode $gpio_post output");
        if ( $a["rev"] == "on") { 
        exec("/usr/local/bin/gpio -g write $gpio_post 0");	
        }
        else { 
        exec("/usr/local/bin/gpio -g write $gpio_post 1");	
        }
    exec("modules/gpio/timestamp $gpio_post 1");	
?>