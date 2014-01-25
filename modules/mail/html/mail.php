<?php
session_start();
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 
?>


<?php
    $ms = $_POST["ms"];
    if ($_POST['ms1'] == "ms2" ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET mail='$ms'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$mail=$a["mail"];
}
?>

<div id="left">
<span class="belka">&nbsp Mail<span class="okno">

<?php
    if ($mail == "on" ) { ?>
	<?php include("mail_settings.php"); ?>
<hr>
	<?php include("mail_test.php"); ?>

<?php	 } 
    else { echo "OFF"; }
?>
</span></span>
</div>

<?php }
    else { 
    	    header("Location: diened");
	} 
?>
