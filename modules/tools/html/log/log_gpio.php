<?php
$ggpio = isset($_GET['gpio']) ? $_GET['gpio'] : '';
$pgpio = isset($_POST['pgpio']) ? $_POST['pgpio'] : '';

$dir = '';
$log_del = isset($_POST['log_del']) ? $_POST['log_del'] : '';
	if ($log_del == "Clear"){
	exec("echo log cleared > tmp/gpio_".$pgpio."_log.txt");	
	echo $dir; 
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 


?>


<p>
<?php 
$glf=glob('tmp/gpio_*_log.txt');
foreach($glf as $gpiof) {  
    $gf1=str_replace("tmp/gpio_", "", $gpiof);
    $gpiof=str_replace("_log.txt", "", $gf1);
?>
    
    <a href="index.php?id=tools&type=log&log=gpio&gpio=<?php echo $gpiof ?>" ><button class="btn btn-default btn-xs"><?php echo "GPIO ".$gpiof ?></button></a>
<?php 
    }
?>
</p>

<?php
if (!empty($ggpio)) { ?>
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">GPIO <?php echo $ggpio ?> logs</h3>
</div>
<div class="panel-body">
<form action="" method="post">
    <input type="submit" name="log_del" value="Clear" class="btn btn-danger" />
    <input type="hidden" name="pgpio" value="<?php echo $ggpio?>" class="btn btn-danger" />
</form>

<br />
<div style="height:300px;overflow:auto;padding:5px;">
<pre>
<?php
$filearray = file("tmp/gpio_".$ggpio."_log.txt");
$filearray = array_reverse($filearray);
//$last = array_slice($filearray,-100);
$last = $filearray;
    foreach($last as $f){
    	echo $f;
    }
?>
</pre>
</div>
</div>
</div>
<?php
    }
?>

