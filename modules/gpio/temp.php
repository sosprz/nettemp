<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM gpio");
$row = $rows->fetchAll();
foreach ($row as $a) {
		$list[]=$a['gpio'];
}

foreach ($list as $a) {
	$rows = $db->query("SELECT * FROM g_func WHERE gpio='$a'");
	$gf = $rows->fetchAll();
	foreach ($gf as $a) {
		echo $a['gpio'];
	}

}
?>
