<?php	
$dir = '';
$file="tmp/gpio_log.txt";
$log_del = isset($_POST['log_del']) ? $_POST['log_del'] : '';
	if ($log_del == "Clear"){
	exec("echo log cleared > $file");	
	echo $dir; 
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 


	 ?>	
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">GPIO logs</h3>
</div>
<div class="panel-body">
<form action="" method="post">
    <input type="submit" name="log_del" value="Clear" class="btn btn-danger" />
</form>

<br />
<div style="height:300px;overflow:auto;padding:5px;">
<pre>
<?php
$filearray = file("$file");
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

