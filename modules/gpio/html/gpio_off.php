<?php
        if ( $a["rev"] == "on") { 
        exec("/usr/local/bin/gpio -g write $gpio_post 1");	
        }
        else { 
        exec("/usr/local/bin/gpio -g write $gpio_post 0");
        }
	exec("modules/gpio/timestamp $gpio_post 0");
?>