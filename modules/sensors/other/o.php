<?php 

$cmd=("exec 3</dev/ttyUSB0 && echo -n 'O\r' >/dev/ttyUSB0 && head -1 <&3; exec 3<&-");
$out=shell_exec($cmd);
$d4=$out;
    $out=trim($out);
    $data=explode(" ",$out);
	$d3=$data;
   var_dump($out);
   var_dump($data);
   
   
   for($i=0;$i<count($data);$i++){
          
		  echo  $d1=$data[$i]."\n";
			//$d2=$data[1];
			//$d3=$data[2];
			//$d4=$data[3];
           
   }



?>