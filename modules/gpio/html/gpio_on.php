<?php

if ($gpio_post >= '100') {
    exec("/usr/local/bin/gpio -x mcp23017:$gpio_post:0x20 mode $gpio_post out");
        if ( $a["rev"] == "on") { 
	    exec("/usr/local/bin/gpio -x mcp23017:$gpio_post:0x20 write $gpio_post 0");
        }
        else { 
	    exec("/usr/local/bin/gpio -x mcp23017:$gpio_post:0x20 write $gpio_post 1");
    	}

} else {
    exec("/usr/local/bin/gpio -g mode $gpio_post output");
        if ( $a["rev"] == "on") { 
    	    exec("/usr/local/bin/gpio -g write $gpio_post 0");	
        }
    	    else { 
        exec("/usr/local/bin/gpio -g write $gpio_post 1");	
        }
}

exec("modules/gpio/timestamp $gpio_post 1");	
?>