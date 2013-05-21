<?php	

	if ($_POST['log_del'] == "Clear"){
	exec("echo log cleared > tmp/log.txt");	
	echo $dir; 
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	 ?>	


<div id="left"><span class="belka">&nbsp Log <span class="okno">
<form action="log" method="post"><input type="submit" name="log_del" value="Clear" /></form>
<br />
<pre>
<?php
$file = file("tmp/log.txt");
$file = array_reverse($file);
foreach($file as $f){
    echo $f;
}

?>
</pre>
</span></span>
</div>
