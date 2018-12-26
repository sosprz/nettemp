<?php	

$ROOT=dirname(dirname(dirname(dirname(dirname(__FILE__)))));

$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");

$dir = '';
$log_del = isset($_POST['log_del']) ? $_POST['log_del'] : '';
	if ($log_del == "Clear"){
	exec("echo log cleared > tmp/log.txt");	
	echo $dir; 
	
	$db->exec("DELETE FROM logs");
	
	
	
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 

	 ?>	
<div class="panel panel-default">
<div class="panel-heading">Logs</div>
<div class="panel-body">

<form action="index.php?id=tools&type=log" method="post">
    <input type="submit" name="log_del" value="Clear" class="btn btn-xs btn-danger" />
</form>
<br />
<div id="logs" style="height:600px; overflow:auto">
<pre>
<?php
$filearray = file("tmp/log.txt");
$last = array_slice($filearray,-100);
    foreach($last as $f){
    	echo $f;
    }
	
	
	
	$query = $db->query("SELECT * FROM logs");
    $result= $query->fetchAll();
	
    foreach($result as $log) {
		
		echo $log['date']." - ".$log['type']." - ".$log['message']."\n";		
	}
	
	
	
?>
</pre>
</div>
</div>
</div>

<script type="text/javascript">
$('#logs').scrollTop($('#logs')[0].scrollHeight);

    setInterval( function() {
		$("#logs").load(location.href+" #logs>*",""); 
		
		$('#logs').scrollTop($('#logs')[0].scrollHeight);
		
    
   
	
}, 5000);
</script>

