<span class="belka">&nbsp Base diagnostic:<span class="okno">
<?php
echo "Table users<br>";
echo "<table border=1>"; 
$db1 = new PDO('sqlite:dbf/nettemp.db');
$sth = $db1->prepare("select * from users ");
$sth->execute();
$result = $sth->fetchAll();
echo "<tr>"; 
echo "<td>id</td>"; 
echo "<td>login</td>";
echo "<td>perms</td>"; 
echo "</tr>";
foreach ($result as $a)  {
  echo "<tr>"; 
        echo "<td>".$a['id']."</td>"; 
        echo "<td>".$a['login']."</td>"; 
        echo "<td>".$a['perms']."</td>"; 
  echo "</tr>"; }
echo "</table>"; 

echo "Tabele sensors<br>";
echo "<table border=1>"; 
//$db = new SQLite3('./dbf/nettemp.db');
//$r = $db->query("select * from sensors ");
$sth = $db1->prepare("select * from sensors ");
$sth->execute();
$result = $sth->fetchAll();
echo "<tr>"; 
echo "<td>id</td>"; 
echo "<td>name</td>"; 
echo "<td>rom</td>"; 
echo "<td>tmp</td>"; 
echo "<td>tmp_min</td>"; 
echo "<td>tmp_max</td>";
echo "<td>hour</td>";
echo "<td>day</td>";
echo "<td>week</td>";
echo "<td>month</td>";
echo "<td>year</td>";
echo "<td>logoterma</td>";
echo "<td>alarm</td>";
echo "</tr>";
foreach ($result as $a)  {
  echo "<tr>"; 
        echo "<td>".$a['id']."</td>"; 
        echo "<td>".$a['name']."</td>"; 
 		  echo "<td>".$a['rom']."</td>"; 
        echo "<td>".$a['tmp']."</td>";
		  echo "<td>".$a['tmp_min']."</td>"; 
        echo "<td>".$a['tmp_max']."</td>"; 
            echo "<td>".$a['hour']."</td>";
                echo "<td>".$a['day']."</td>";
                    echo "<td>".$a['week']."</td>";
                        echo "<td>".$a['month']."</td>";
                            echo "<td>".$a['year']."</td>";
    echo "<td>".$a['logoterma']."</td>";
 		  echo "<td>".$a['alarm']."</td>"; 
  echo "</tr>"; }
echo "</table>"; 

echo "Tabele recipient<br>";
echo "<table border=1>"; 
$sth = $db1->prepare("select * from recipient ");
$sth->execute();
$result = $sth->fetchAll();
echo "<tr>"; 
echo "<td>id</td>"; 
echo "<td>name</td>"; 
echo "<td>mail</td>"; 
echo "<td>tel</td>";
echo "<td>mail_alarm</td>"; 
echo "<td>sms_alarm</td>";  
echo "</tr>";
foreach ($result as $a)  {
  echo "<tr>"; 
        echo "<td>".$a['id']."</td>"; 
        echo "<td>".$a['name']."</td>"; 
        echo "<td>".$a['mail']."</td>";
        echo "<td>".$a['tel']."</td>";
        echo "<td>".$a['mail_alarm']."</td>";
        echo "<td>".$a['sms_alarm']."</td>";
  echo "</tr>"; }
echo "</table>";  

echo "Table mail settings<br>";
echo "<table border=1>"; 
$sth = $db1->prepare("select * from mail_settings ");
$sth->execute();
$result = $sth->fetchAll();
echo "<tr>"; 
//echo "<td>address</td>"; 
echo "<td>user</td>"; 
echo "<td>host</td>"; 
echo "<td>port</td>"; 
echo "</tr>";
foreach ($result as $a)  {
  echo "<tr>"; 
        echo "<td>".$a['user']."</td>"; 
		  echo "<td>".$a['host']."</td>";
		    echo "<td>".$a['port']."</td>"; 
  echo "</tr>"; }
echo "</table>"; 
?>
<br />



</span></span>
