<?php
$root = "/var/www/nettemp";
$dir = "$root/db";
$name=$_GET["name"];
$type=$_GET["type"];
$max=$_GET["max"];
$mode=$_GET["mode"];
$group=$_GET["group"];
$single=$_GET["single"];

$data='';
$adj='';


$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT * FROM highcharts WHERE id='1'");
$row = $rows->fetchAll();
foreach($row as $a) {
$charts_fast=$a['charts_fast'];
$charts_min=$a['charts_min'];
}

function query($max,&$query) {
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


function querymod($max,$charts_min,&$query) {
if ($max == 'hour') {
    	$query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 hour')";
    } 
if ($max == 'day') {
		$mod=60/$charts_min;
      $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 day') AND rowid % $mod=0";
    } 
if ($max == 'week') {
	 	$mod=240/$charts_min;
    	$query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-7 day') AND rowid % $mod=0";
    } 
if ($max == 'month') {
		$mod=1440/$charts_min;
    	$query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 months') AND rowid % $mod=0";
    } 
if ($max == 'months') {
		$mod=1400/$charts_min;
    	$query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-6 months') AND rowid % $mod=0";
    } 
if ($max == 'year') {
		$mod=10080/$charts_min;
    	$query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 year') AND rowid % $mod=0";
    } 
if ($max == 'all') {
    	$query = "select strftime('%s', time),value FROM def";
    }
}

function queryc($max,&$query) {
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


if ($type == 'system') {
	 $file=array("memory","cpu","memory_cached");
	 foreach($file as $file) {
    $dirb = "sqlite:$root/db/system_$file.sql";
    $dbh = new PDO($dirb) or die("cannot open database");

    	if($charts_fast=='on') {
    		querymod($max,$charts_min,$query);
    	}
		else {
    		query($max,$query);
    	}
    	
  		foreach ($dbh->query($query) as $row) {
			$data[]=array('x' => $row[0]*1000, 'y' => $row[1]);
		}
    		$array['key']=$file;
    		$array['values']=$data;
     		$all[]=$array;
  			unset($data);
    		unset($array);
	}
   print json_encode($all);
} 


elseif ($type == 'host') {
 	 $db = new PDO("sqlite:$root/dbf/nettemp.db");
 	 if(empty($single)) {
    	$rows = $db->query("SELECT * FROM hosts");
    }
    else {
    	$rows = $db->query("SELECT * FROM hosts WHERE name='$single'");
    	}
    $row = $rows->fetchAll();
    
    foreach($row as $a) {
		$file=$a['rom'];
		$name=$a['name'];
   
    	$dirb = "sqlite:$root/db/$file.sql";
    	$dbh = new PDO($dirb) or die("cannot open database");
    	if($charts_fast=='on') {
    		querymod($max,$charts_min,$query);
    	}
		else {
    		query($max,$query);
    	}
	   foreach ($dbh->query($query) as $row) {
			$data[]=array('x' => $row[0]*1000, 'y' => $row[1]+$adj);
		}
    		$array['key']=$name;
    		$array['values']=$data;
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
		$file=$a['gpio'];
		$name=$a['name'];

    	$dirb = "sqlite:$root/db/gpio_stats_$file.sql";
    	$dbh = new PDO($dirb) or die("cannot open database");
    	if($charts_fast=='on') {
    		querymod($max,$charts_min,$query);
    	}
		else {
    		query($max,$query);
    	}
	   foreach ($dbh->query($query) as $row) {
			$data[]=array('x' => $row[0]*1000, 'y' => $row[1]+$adj);
		}
    		$array['key']=$name;
    		$array['values']=$data;
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
		$file=$a['rom'];
		$name=$a['name'];
		$adj=$a['adj'];
		
    	$dirb = "sqlite:$root/db/$file.sql";
    	$dbh = new PDO($dirb) or die("cannot open database");
    	if($charts_fast=='on') {
    		querymod($max,$charts_min,$query);
    	}
		else {
    		query($max,$query);
    	}
	   foreach ($dbh->query($query) as $row) {
			$data[]=array('x' => $row[0]*1000, 'y' => $row[1]+$adj);
		}
    		$array['key']=$name;
    		$array['values']=$data;
     		$all[]=$array;
  			unset($data);
    		unset($array);
	}
   print json_encode($all);
}

elseif ($type == 'elec' && $mode == 2) {

		$db = new PDO("sqlite:$root/dbf/nettemp.db");
     if(empty($single)) {
     		$rows = $db->query("SELECT * FROM sensors WHERE type='$type' AND charts='on'");
     	} 
     	else {
     		$rows = $db->query("SELECT * FROM sensors WHERE type='$type' AND name='$single'");
     	}
     		
    $row = $rows->fetchAll();
    
    foreach($row as $a) {
		$file=$a['rom'];
		$name=$a['name'];
		$adj=$a['adj'];
		$type=$a['type'];

    	$dirb = "sqlite:$root/db/$file.sql";
    	$dbh = new PDO($dirb) or die("cannot open database");
    	if($charts_fast=='on') {
    		queryc($max,$charts_min,$query);
    	}
		else {
    		queryc($max,$query);
    	}
	   foreach ($dbh->query($query) as $row) {
			$data[]=array('x' => $row[0]*1000, 'y' => $row[1]+$adj);
		}
    		$array['key']=$name;
    		$array['values']=$data;
    		//$array['units']=$type;
     		$all[]=$array;
  			unset($data);
    		unset($array);
	}
   print json_encode($all);
}

else {
    
    $db = new PDO("sqlite:$root/dbf/nettemp.db");
     if(empty($single)) {
     		$rows = $db->query("SELECT * FROM sensors WHERE type='$type' AND charts='on'");
     	} 
     	else {
     		$rows = $db->query("SELECT * FROM sensors WHERE type='$type' AND name='$single'");
     	}
     		
    $row = $rows->fetchAll();
    
    foreach($row as $a) {
		$file=$a['rom'];
		$name=$a['name'];
		$adj=$a['adj'];
		$type=$a['type'];

    	$dirb = "sqlite:$root/db/$file.sql";
    	$dbh = new PDO($dirb) or die("cannot open database");
    	if($charts_fast=='on') {
    		querymod($max,$charts_min,$query);
    	}
		else {
    		query($max,$query);
    	}
	   foreach ($dbh->query($query) as $row) {
			$data[]=array('x' => $row[0]*1000, 'y' => $row[1]+$adj);
		}
    		$array['key']=$name;
    		$array['values']=$data;
    		//$array['units']=$type;
     		$all[]=$array;
  			unset($data);
    		unset($array);
	}
   print json_encode($all);
}
?>


