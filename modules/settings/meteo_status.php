<?php
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");

$rows = $db->query("SELECT onoff FROM meteo where id='1'");
$row = $rows->fetchAll();
foreach ($row as $a) {
    $onoff=$a["onoff"];
    }

if ( $onoff == "on") { 


$met1 = $db->prepare("SELECT * FROM meteo WHERE id='1'");
$met1->execute();
$resultmet1 = $met1->fetchAll();
foreach ($resultmet1 as $me) { 
    $szerokosc=$me['latitude'];
    $wysokosc=$me['height'];
    $idtmp=$me['temp'];
    $idpre=$me['pressure'];
    $idhum=$me['humid'];
}

$sth = $db->prepare("select tmp from sensors where id='$idtmp'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$temperatura=$a['tmp'];
}

$sth = $db->prepare("select tmp from sensors where id='$idpre'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$cisnienie=$a['tmp'];
}

$sth = $db->prepare("select tmp from sensors where id='$idhum'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$wilgotnosc=$a['tmp'];
}
?>
<div class="panel panel-default">
  <div class="panel-heading">Meteo</div>
<table class="table stripped">

<tr>
    <td>sila grawitacji [m/s^2]"</td>
    <td><?php echo $sila_grawitacji=9.780313*(pow(1+0.005324*SIN($szerokosc),2)-0.0000058*pow(SIN(2*$szerokosc),2)-0.000003085*$wysokosc);?></td>
</tr>

<tr>
    <td>temp znormalizowana [K]
    <td><?php echo $temp_znormalizowana=((2*($temperatura+273.15))+((0.6*$wysokosc)/100))/2;?></td>
</tr>

<tr>
    <td>temp znormalizowana [C]
    <td><?php echo $temp_znormalizowana-273,15;?></td>
</tr>

<tr>
    <td>cisnienie znormalizowane [hPa]
    <td><?php echo ($cisnienie*(EXP(($sila_grawitacji*$wysokosc)/(287.05*$temp_znormalizowana)))*10)/10;?></td>
</tr>


<tr>
    <td>temperatura punku rosy [°C]
    <td><?php echo 243.12*(((LOG10($wilgotnosc)-2)/0.4343)+(17.5*$temperatura)/(243.12+$temperatura))/(17.62-(((LOG10($wilgotnosc)-2)/0.4343)+(17.5*$temperatura)/(243.12+$temperatura)));?></td>
</tr>


<tr>
    <td>cisnienie pary wodnej nasyconej [hPa]
    <td><?php echo $cisnienie_pary_nasyconej=6.112*EXP((17.67*$temperatura)/($temperatura+243.5));?></td>
</tr>

<tr>
    <td>cisnienie pary wodnej [hPa]
    <td><?php echo $cisnienie_pary=$wilgotnosc/(1/$cisnienie_pary_nasyconej)/100;?></td>
</tr>
<tr>
    <td>wilgotnosc bezwzgledna [g/m^3]
    <td><?php echo 2165*(($cisnienie_pary/10)/(273.15+$temperatura));?></td>
</tr>



</table>
</div>
</div>

<?php
}
?>