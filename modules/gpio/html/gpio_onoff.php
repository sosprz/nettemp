<?php
$off = isset($_POST['off']) ? $_POST['off'] : '';
if ($off == "off") {
    //$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    //$sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
    //$sth->execute();
    //$result = $sth->fetchAll();    
   //foreach ($result as $a) { 
        if ( $a["rev"] == "on") { 
        exec("/usr/local/bin/gpio -g write $gpio_post 1");	
        }
        else { 
        exec("/usr/local/bin/gpio -g write $gpio_post 0");	
        }
//    }
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    
}

$on = isset($_POST['on']) ? $_POST['on'] : '';
if ($on == "on")  {
    exec("/usr/local/bin/gpio -g mode $gpio_post output");
    //$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    //$db->exec("UPDATE gpio SET status='on' WHERE gpio='$gpio_post'") or die("PDO exec error");
   //$sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
   //$sth->execute();
   //$result = $sth->fetchAll();    
   //foreach ($result as $a) { 
        if ( $a["rev"] == "on") { 
        exec("/usr/local/bin/gpio -g write $gpio_post 0");	
        }
        else { 
        exec("/usr/local/bin/gpio -g write $gpio_post 1");	
        }
    //}
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>