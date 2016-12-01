<?php
$ROOT=dirname(dirname(dirname(__FILE__)));

$date = date("Y-m-d H:i:s"); 


try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
	
	$found=false;
	$packages_list= file("$ROOT/install/apt/packages_list");
	$lines = file('/var/lib/dpkg/status');
	
	foreach($packages_list as $search) {
		$search=trim($search);
		foreach($lines as $line)
			{
				if(strpos($line, "Package: ".$search) !== false)
					{
					$found = true;
					}
			}
			if(!$found)
		{
			echo $search."\n";
			$install[]=$search;
		}
		$found=false;
	}
	
	if(!empty($install)) {
		$string = rtrim(implode(' ', $install), ',');
		echo $date." Packages to install: ".$install;
		$cmd="sudo /usr/bin/aptitude update";
		shell_exec($cmd);
		$cmd="sudo /usr/bin/aptitude install -y $string";
		shell_exec($cmd);
	} else {
		echo $date."Nothing to install";
						
} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>
