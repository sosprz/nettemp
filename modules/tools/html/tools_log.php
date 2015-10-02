<?php	
$dir = '';
$log_del = isset($_POST['log_del']) ? $_POST['log_del'] : '';
	if ($log_del == "Clear"){
	exec("echo log cleared > tmp/log.txt");	
	echo $dir; 
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 

$call_log_del = isset($_POST['call_log_del']) ? $_POST['call_log_del'] : '';
	if ($call_log_del == "Clear"){
	exec("echo log cleared > tmp/incoming_calls.txt");	
	echo $dir; 
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 


	 ?>	
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Logs form nettemp</h3>
</div>
<div class="panel-body">

<form action="index.php?id=tools&type=log" method="post">
    <input type="submit" name="log_del" value="Clear" class="btn btn-danger" />
</form>
<br />
<div style="height:300px;overflow:auto;padding:5px;">
<pre>
<?php
$filearray = file("tmp/log.txt");
$last = array_slice($filearray,-100);
    foreach($last as $f){
    	echo $f;
    }
?>
</pre>
</div>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Call logs</h3>
</div>
<div class="panel-body">
<form action="index.php?id=tools&type=log" method="post">
    <input type="submit" name="call_log_del" value="Clear" class="btn btn-danger" />
</form>

<br />
<div style="height:300px;overflow:auto;padding:5px;">
<pre>
<?php
$filearray = file("tmp/incoming_calls.txt");
$last = array_slice($filearray,-100);
    foreach($last as $f){
    	echo $f;
    }
?>
</pre>
</div>
</div>
</div>
