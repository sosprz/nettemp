<?php $del_graf = $_POST["del_graf"]; ?>
<?php $del_rrd = $_POST["del_rrd"]; ?>

<?php //sekcja kasowania grafu

if(!empty($del_graf) && ($_POST['del_graf1'] == "del_graf2")) {
	unlink($del_graf);
	header("location: " . $_SERVER['REQUEST_URI']);
  	   exit();
}
?>
