<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die("cannot open the database");

$temperatura='';
$wilgotnosc='';
$cisnienie='';

$rows = $db->query("SELECT onoff FROM meteo where id='1'");
$row = $rows->fetchAll();
foreach ($row as $a) {
    $onoff=$a["onoff"];
    }

if ( $onoff == "on") { 

require_once("status/Meteo.class.php"); 
$meteo=new Meteo();
$sila_grawitacji=$meteo->getSilaGrawitacji();//9.780313*(pow(1+0.005324*SIN($szerokosc),2)-0.0000058*pow(SIN(2*$szerokosc),2)-0.000003085*$wysokosc);
$temp_znormalizowana=$meteo->getTemperaturaZnormalizowana();//((2*($temperatura+273.15))+((0.6*$wysokosc)/100))/2;
$tz=$meteo->getTemperaturaZnormalizowana()-273.15;//$temp_znormalizowana-273.15;
$cz=$meteo->getCisnienieZnormalizowane();//($cisnienie*(EXP(($sila_grawitacji*$wysokosc)/(287.05*$temp_znormalizowana)))*10)/10;
$tpr=$meteo->getTpr();//243.12*(((LOG10($wilgotnosc)-2)/0.4343)+(17.5*$temperatura)/(243.12+$temperatura))/(17.62-(((LOG10($wilgotnosc)-2)/0.4343)+(17.5*$temperatura)/(243.12+$temperatura)));
$cisnienie_pary_nasyconej=$meteo->getCisnienieParyNasyconej();//6.112*EXP((17.67*$temperatura)/($temperatura+243.5));
$cisnienie_pary=$meteo->getCisnieniePary();//$wilgotnosc/(1/$cisnienie_pary_nasyconej)/100;
$wb=$meteo->getWb();//2165*(($cisnienie_pary/10)/(273.15+$temperatura));
?>
<script>
	function normalized(){
    document.getElementById("normalized").innerHTML = <?php echo number_format($cz, 2, '.', '')."hPa npm"; ?>
};
</script>
<?php
	if ( $onoff == "on" ) {
?>
<div class="grid-item ms">
<div class="panel panel-default">
  <div class="panel-heading">Meteo (lang pl)</div>
<table class="table stripped table-condensed small">

<tr>
    <td>Sila grawitacji [m/s^2]"</td>
    <td><?php 
	    //$sila_grawitacji=9.780313*(pow(1+0.005324*SIN($szerokosc),2)-0.0000058*pow(SIN(2*$szerokosc),2)-0.000003085*$wysokosc);
	    echo number_format($sila_grawitacji, 2, '.', '');
	?>
    </td>
</tr>

<tr>
    <td>Temperatura znormalizowana [K]
    <td>
	<?php 
	    //$temp_znormalizowana=((2*($temperatura+273.15))+((0.6*$wysokosc)/100))/2;
	    echo number_format($temp_znormalizowana, 2, '.', '');
	?>
    </td>
</tr>

<tr>
    <td>Temperatura znormalizowana [C]
    <td>
	<?php 
	    //$tz=$temp_znormalizowana-273.15;
	    echo number_format($tz, 2, '.', '');
	?>
    </td>
</tr>

<tr>
    <td>Cisnienie znormalizowane [hPa]
    <td>
	<?php 
	    //$cz=($cisnienie*(EXP(($sila_grawitacji*$wysokosc)/(287.05*$temp_znormalizowana)))*10)/10;
	    echo number_format($cz, 2, '.', '');
	?>
    </td>
</tr>


<tr>
    <td>Temperatura punktu rosy [°C]
    <td>
	<?php 
	    //$tpr=243.12*(((LOG10($wilgotnosc)-2)/0.4343)+(17.5*$temperatura)/(243.12+$temperatura))/(17.62-(((LOG10($wilgotnosc)-2)/0.4343)+(17.5*$temperatura)/(243.12+$temperatura)));
	    echo number_format($tpr, 2, '.', '');
	?>
    </td>
</tr>


<tr>
    <td>Cisnienie pary wodnej nasyconej [hPa]
    <td>
	<?php 
	    //$cisnienie_pary_nasyconej=6.112*EXP((17.67*$temperatura)/($temperatura+243.5));
	    echo number_format($cisnienie_pary_nasyconej, 2, '.', '');
	?>
    </td>
</tr>

<tr>
    <td>Cisnienie pary wodnej [hPa]
    <td>
	<?php 
	    //$cisnienie_pary=$wilgotnosc/(1/$cisnienie_pary_nasyconej)/100;
	    echo number_format($cisnienie_pary, 2, '.', '');
	?>
    </td>
</tr>
<tr>
    <td>Wilgotnosc bezwzgledna [g/m^3]
    <td>
	<?php 
	    //$wb=2165*(($cisnienie_pary/10)/(273.15+$temperatura));
	    echo number_format($wb, 2, '.', '');
	?>
    </td>
</tr>



</table>
</div>
</div>
<?php
	}
}
?>
