<?php
$off = isset($_POST['off']) ? $_POST['off'] : '';
if ($off == "off") {
        if ( $a["rev"] == "on") { 
        exec("/usr/local/bin/gpio -g write $gpio_post 1");	
        }
        else { 
        exec("/usr/local/bin/gpio -g write $gpio_post 0");
        }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    
}

$on = isset($_POST['on']) ? $_POST['on'] : '';
if ($on == "on")  {
    exec("/usr/local/bin/gpio -g mode $gpio_post output");
        if ( $a["rev"] == "on") { 
        exec("/usr/local/bin/gpio -g write $gpio_post 0");	
        }
        else { 
        exec("/usr/local/bin/gpio -g write $gpio_post 1");	
        }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>