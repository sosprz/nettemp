<?php	
$log_del = isset($_POST['log_del']) ? $_POST['log_del'] : '';
	if ($log_del == "Clear"){
	exec("echo log cleared > tmp/log.txt");	
	echo $dir; 
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	 ?>	


<div id="left"><span class="belka">&nbsp Log <span class="okno">
<form action="index.php?id=tools&type=log" method="post"><input type="submit" name="log_del" value="Clear" /></form>
<br />
<div style="width:990px;height:300px;overflow:auto;padding:5px;">
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
</span></span>
</div>
