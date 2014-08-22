<div id="left">
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$rrd=$a["rrd"];
$hc=$a["highcharts"];
}
if ($hc == "on" ) { include("modules/highcharts/humi_menu.php"); }
if ($rrd == "on" ) { include("modules/view/html/humi_view_graph.php"); }
else { ?>
<span class="belka">&nbsp Info<span class="okno">
Go to settings and set highcharts or RRD
</span></span>
<?php
}
?>
</div>
