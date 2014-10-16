$gpio_rev_hilo = isset($_POST['gpio_rev_hilo']) ? $_POST['gpio_rev_hilo'] : '';
$gpio_rev_hilo1 = isset($_POST['gpio_rev_hilo1']) ? $_POST['gpio_rev_hilo1'] : '';
if (($gpio_rev_hilo1 == "gpio_rev_hilo2") ){
    //exec("/usr/local/bin/gpio -g mode $gpio_post output");
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
    $sth->execute();
    $result = $sth->fetchAll();    
    foreach ($result as $a) { 
	if ( $a["gpio_rev_hilo"] == "on") { 
	$db->exec("UPDATE gpio SET gpio_rev_hilo='off' where gpio='$gpio_post' ") or die("exec error");
	//exec("/usr/local/bin/gpio -g write $gpio_post 0");	
	}
	else { 
	$db->exec("UPDATE gpio SET gpio_rev_hilo='on' where gpio='$gpio_post' ") or die("exec error");
	//exec("/usr/local/bin/gpio -g write $gpio_post 1");	
	}
   }
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
