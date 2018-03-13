<?php	
$dir = '';
$piups_log_del = isset($_POST['piups_log_del']) ? $_POST['piups_log_del'] : '';
	if ($piups_log_del == "Clear"){
	exec("echo log cleared > tmp/piups_log.txt");	
	echo $dir; 
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 

	 ?>	
<div class="panel panel-default">
<div class="panel-heading">PiUPS</div>
<div class="panel-body">

<form action="index.php?id=tools&type=log&log=piups" method="post">
    <input type="submit" name="piups_log_del" value="Clear" class="btn btn-xs btn-danger" />
</form>
<br />
<div style="height:300px;overflow:auto;padding:5px;">
<pre>
<?php
$filearray = file("tmp/piups_log.txt");
$last = array_slice($filearray,-100);
    foreach($last as $f){
    	echo $f;
    }
?>
</pre>
</div>
</div>
</div>

