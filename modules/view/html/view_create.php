<span class="belka">&nbsp Generate graph:<span class="okno">
<?php 
$arrayFiles=glob('db/*.rrd'); //do sprawdania czy mozna generowac widok
if($_POST['gen2'] == "gen3") { 

$arrayFiles=glob('db/*.rrd');
if($arrayFiles){
  foreach ($arrayFiles as $filename) {
      			$path_parts = pathinfo($filename);
      			$ls[]=$path_parts['filename'];   

        } } echo "brak baz";

$time=$_POST["time"]; 

$dane[]="rrdtool graph img/view1/$time.png \
--imgformat PNG \
--title=\"$time\" \
--width 894 --height 300 \
--vertical-label=\"Degrees C\" \
-s -1$time \\\n";
     
	$i=0;
	foreach ($ls as $file_name) {
	$zm1 = str_replace("_", " ", $file_name);
	//$db = new SQLite3('dbf/nettemp.db');
	//$r = $db->query("select * from sensors WHERE rom='$zm1'");
	//while ($a = $r->fetchArray()) {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$sth = $db1->prepare("select * from sensors WHERE rom='$zm1'");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $a) {	
		$name=$a[name];
}

// random dla kolorów
if ($i==0){$kolor="#0000ff";}
if ($i==1){$kolor="#FF0000";}
if ($i==2){$kolor="#008000";}
if ($i==3){$kolor="#FFFF00";}
if ($i==4){$kolor="#663300";}
if ($i==5){$kolor="#FF3399";}
if ($i==6){$kolor="#00FFFF";}
if ($i>=7){$kolor="#0000ff";}

$name2=str_pad($name, 25);
$dane2[]="DEF:temp$i=db/$file_name.rrd:temp:AVERAGE \
LINE2:temp$i$kolor:\"$name2\" \
GPRINT:temp$i:LAST:\"cur\\: %2.2lf C \" \
GPRINT:temp$i:MIN:\"min\\: %2.2lf C \" \
GPRINT:temp$i:MAX:\"max\\: %2.2lf C \" \
GPRINT:temp$i:AVERAGE:\"ave\\: %2.2lf C\" \
\"COMMENT:\\n\" \\\n";
	$i++;
	}

//rrd
$file1 = "scripts/rrd/rrd_$time";
$fp1 = fopen($file1, "w");
flock($fp1, 2);
foreach ($dane as $element1) { 
fputs($fp1,$element1); }
flock($fp1, 3);
fclose($fp1);

$file2 = "scripts/rrd/rrd_$time";
$fp2 = fopen($file2, "a");
flock($fp2, 2);
foreach ($dane2 as $element2) { 
fputs($fp2,$element2); }
flock($fp2, 3);
fclose($fp2); 
 
 chmod("scripts/rrd/rrd_$time", 0755);
 system("scripts/rrd/rrd_$time");
 chmod("img/view1/$time.png", 0777);
 header("location: " . $_SERVER['REQUEST_URI']);
 exit();
}


?>

<?php if(!empty($arrayFiles)){ ?>
<table>
<tr>
<td><form action="view" method="post">
<input type="hidden" name="time" value="hour" />
<input type="hidden" name="gen2" value="gen3" />
&nbsp Hour &nbsp <input type="image" src="media/ico/graph-icon.png" />
</form><td>
<td><form action="view" method="post"> 
<input type="hidden" name="time" value="day" />
<input type="hidden" name="gen2" value="gen3" />
&nbsp Day &nbsp<input type="image" src="media/ico/graph-icon.png" />
</form><td>
<td><form action="view" method="post"> 
<input type="hidden" name="time" value="week" />
<input type="hidden" name="gen2" value="gen3" />
&nbsp Week &nbsp<input type="image" src="media/ico/graph-icon.png"  />
</form><td>
<td><form action="view" method="post"> 
<input type="hidden" name="time" value="month" />
<input type="hidden" name="gen2" value="gen3" />
&nbsp Month &nbsp<input type="image" src="media/ico/graph-icon.png"  />
</form><td>
<td><form action="view" method="post"> 
<input type="hidden" name="time" value="year" />
<input type="hidden" name="gen2" value="gen3" />
&nbsp Year &nbsp<input type="image" src="media/ico/graph-icon.png"  />
</form></td>
</tr></table>

<?php } else { ?>
<span class="brak"><img src="media/ico/Sign-Stop-icon.png" /> No sensors added</span>
<?php } ?>
</span></span>
