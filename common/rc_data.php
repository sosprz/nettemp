<?php
$root = "/var/www/nettemp";
$dir = "$root/db";
$dst = "$root/tmp/highcharts";
$name=$_GET["name"];
$type=$_GET["type"];
$max=$_GET["max"];
$mode=$_GET["mode"];
$group=$_GET["group"];
$single=$_GET["single"];
$array=null;

$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT * FROM highcharts WHERE id='1'");
$row = $rows->fetchAll();
foreach($row as $a) {
$charts_fast=$a['charts_fast'];
}

function query($max,&$query) {
if ($max == '15min') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-15 minutes')";
    } 
if ($max == 'hour') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 hour')";
    } 
if ($max == 'day') {
      $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 day')";
    } 
if ($max == 'week') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-7 day')";
    } 
if ($max == 'month') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 months')";
    } 
if ($max == 'months') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-6 months')";
    } 
if ($max == 'year') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 year')";
    } 
if ($max == 'all') {
    $query = "select strftime('%s', time),value FROM def";
    }
}


function querymod($max,&$query) {
if ($max == '15min') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-15 minutes')";
    } 
if ($max == 'hour') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 hour')";
    } 
if ($max == 'day') {
      $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 day') AND rowid % 60=0";
    } 
if ($max == 'week') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-7 day') AND rowid % 240=0";
    } 
if ($max == 'month') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 months') AND rowid % 1440=0";
    } 
if ($max == 'months') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-6 months') AND rowid % 1440=0";
    } 
if ($max == 'year') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 year') AND rowid % 10080=0";
    } 
if ($max == 'all') {
    $query = "select strftime('%s', time),value FROM def";
    }
}

function queryc($max,&$query) {
if ($max == '15min') {
    $query = "select strftime('%s', time),current from def WHERE time >= datetime('now','localtime','-15 minutes')";
    } 
if ($max == 'hour') {
    $query = "select strftime('%s', time),current from def WHERE time >= datetime('now','localtime','-1 hour')";
    } 
if ($max == 'day') {
      $query = "select strftime('%s', time),current from def WHERE time >= datetime('now','localtime','-1 day')";
    } 
if ($max == 'week') {
    $query = "select strftime('%s', time),current from def WHERE time >= datetime('now','localtime','-7 day')";
    } 
if ($max == 'month') {
    $query = "select strftime('%s', time),current from def WHERE time >= datetime('now','localtime','-1 months')";
    } 
if ($max == 'months') {
    $query = "select strftime('%s', time),current from def WHERE time >= datetime('now','localtime','-6 months')";
    } 
if ($max == 'year') {
    $query = "select strftime('%s', time),current from def WHERE time >= datetime('now','localtime','-1 year')";
    } 
if ($max == 'all') {
    $query = "select strftime('%s', time),current FROM def";
    }

}


	 $colors = array("blue", "red", "green", "yellow", "purple");


if ($type == 'system') {
	 $file=array("memory","cpu","memory_cached");
	 foreach($file as $file) {
    $dirb = "sqlite:$root/db/system_$file.sql";
    $dbh = new PDO($dirb) or die("cannot open database");

    	if($charts_fast=='on') {
    		querymod($max,$query);
    	}
		else {
    		query($max,$query);
    	}
	   foreach ($dbh->query($query) as $row) {
			$data[]=array(x => $row[0]*1000, y => (int)$row[1]);
		}
	      $c=array_rand($colors);
    		$array[color]=$colors[$c];
    		$array[name]=$file;
    		$array[data]=$data;
     		$all[]=$array;
  			unset($data);
    		unset($array);
	}
   print json_encode($all);
} 


elseif ($type == 'hosts') {
 	 $db = new PDO("sqlite:$root/dbf/nettemp.db");
 	 if(empty($single)) {
    	$rows = $db->query("SELECT * FROM hosts");
    }
    else {
    	$rows = $db->query("SELECT * FROM hosts WHERE name='$single'");
    	}
    $row = $rows->fetchAll();
    
    foreach($row as $a) {
		$file[$a['rom']]=$a['name'];
    }

	 foreach($file as $file => $name) {
    	$dirb = "sqlite:$root/db/$file.sql";
    	$dbh = new PDO($dirb) or die("cannot open database");
    	if($charts_fast=='on') {
    		querymod($max,$query);
    	}
		else {
    		query($max,$query);
    	}
	   foreach ($dbh->query($query) as $row) {
			$data[]=array(x => $row[0]*1000, y => (int)$row[1]);
		}
	     $c=array_rand($colors);
    		$array[color]=$colors[$c];
    		$array[name]=$name;
    		$array[data]=$data;
     		$all[]=$array;
  			unset($data);
    		unset($array);
	}
   print json_encode($all);


}

elseif ($type == 'gpio') {

    $db = new PDO("sqlite:$root/dbf/nettemp.db");
    if(empty($single)) {
     		$rows = $db->query("SELECT * FROM gpio");
     	} 
     	else {
     		$rows = $db->query("SELECT * FROM gpio WHERE name='$single'");
     	}
    $row = $rows->fetchAll();
	 foreach($row as $a) {
		$file[$a['gpio']]=$a['name'];
    }
    
    foreach($file as $file => $name) {
    	$dirb = "sqlite:$root/db/gpio_stats_$file.sql";
    	$dbh = new PDO($dirb) or die("cannot open database");
    	if($charts_fast=='on') {
    		querymod($max,$query);
    	}
		else {
    		query($max,$query);
    	}
	   foreach ($dbh->query($query) as $row) {
			$data[]=array(x => $row[0]*1000, y => (int)$row[1]);
		}
	     $c=array_rand($colors);
    		$array[color]=$colors[$c];
    		$array[name]=$name;
    		$array[data]=$data;
    		if(!empty($data)) {
     			$all[]=$array;
     		}
  			unset($data);
    		unset($array);
	}
   print json_encode($all);
}    
elseif ($type == 'group'){
    $db = new PDO("sqlite:$root/dbf/nettemp.db");
    $rows = $db->query("SELECT * FROM sensors WHERE ch_group='$group'");
    $row = $rows->fetchAll();
    foreach($row as $a) {
		$file[$a['rom']]=$a['name'];
    }
     foreach($file as $file => $name) {
    	$dirb = "sqlite:$root/db/$file.sql";
    	$dbh = new PDO($dirb) or die("cannot open database");
    	if($charts_fast=='on') {
    		querymod($max,$query);
    	}
		else {
    		query($max,$query);
    	}
	   foreach ($dbh->query($query) as $row) {
			$data[]=array(x => $row[0]*1000, y => (int)$row[1]);
		}
	     $c=array_rand($colors);
    		$array[color]=$colors[$c];
    		$array[name]=$name;
    		$array[data]=$data;
     		$all[]=$array;
  			unset($data);
    		unset($array);
	}
   print json_encode($all);
}
    
else {
    
    $db = new PDO("sqlite:$root/dbf/nettemp.db");
     if(empty($single)) {
     		$rows = $db->query("SELECT * FROM sensors WHERE type='temp' AND charts='on'");
     	} 
     	else {
     		$rows = $db->query("SELECT * FROM sensors WHERE type='temp' AND name='$single'");
     	}
     		
    $row = $rows->fetchAll();
    
    foreach($row as $a) {
		$file[$a['rom']]=$a['name'];
    }

	 foreach($file as $file => $name) {
    	$dirb = "sqlite:$root/db/$file.sql";
    	$dbh = new PDO($dirb) or die("cannot open database");
    	if($charts_fast=='on') {
    		querymod($max,$query);
    	}
		else {
    		query($max,$query);
    	}
	   foreach ($dbh->query($query) as $row) {
			$data[]=array(x => $row[0]*1000, y => (int)$row[1]);
		}
	     $c=array_rand($colors);
    		$array[color]=$colors[$c];
    		$array[name]=$name;
    		$array[data]=$data;
     		$all[]=$array;
  			unset($data);
    		unset($array);
	}
   print json_encode($all);
}
?>


