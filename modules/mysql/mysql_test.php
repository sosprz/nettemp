<div class="panel panel-default">
  <div class="panel-heading">Connection test</div>
  <div class="panel-body">
   
<?php

include_once('modules/mysql/mysql_conf.php');
$conn = mysql_connect($IP, $USER, $PASS,$DB,$PORT);

if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_close($conn);
?>
 </div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">Info</div>
  <div class="panel-body">

 GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'password' WITH GRANT OPTION;<br>
 bind-address		= 127.0.0.1 -> #bind-address		= 127.0.0.1
 </div>
</div>
