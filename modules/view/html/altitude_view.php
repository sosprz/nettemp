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
if ($hc == "on" ) { include("modules/highcharts/html/altitude_menu.php"); }
if ($rrd == "on" ) { include("modules/view/html/altitude_view_graph.php"); }
?>
</div>
