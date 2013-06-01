<?php	

	if ($_POST['log_del'] == "Clear"){
	exec("echo log cleared > tmp/log.txt");	
	echo $dir; 
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	 ?>	


<div id="left"><span class="belka">&nbsp Log <span class="okno">
<form action="tools" method="post"><input type="submit" name="log_del" value="Clear" /></form>
<br />
<div style="width:990px;height:300px;overflow:auto;padding:5px;">
<pre>
<?php
$file = file("tmp/log.txt");
$file = array_reverse($file);
foreach($file as $f){
    echo $f;
}

?>
</pre>
</div>
</span></span>
</div>
