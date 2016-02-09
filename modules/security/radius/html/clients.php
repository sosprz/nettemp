<?php

$nasname = isset($_POST['nasname']) ? $_POST['nasname'] : '';
$nasnet = isset($_POST['nasnet']) ? $_POST['nasnet'] : '';
$naspass = isset($_POST['naspass']) ? $_POST['naspass'] : '';
$addnas = isset($_POST['addnas']) ? $_POST['addnas'] : '';

if ($addnas == "add"){ 
    shell_exec("sudo sed -i '\$aclient '$nasname' { ipaddr = '$nasnet' , secret = '$naspass' }' /usr/local/etc/raddb/clients.conf"); 
    shell_exec("sudo pkill radiusd && radiusd");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


$rmclient = isset($_POST['rmclient']) ? $_POST['rmclient'] : '';
$rmc = isset($_POST['rmc']) ? $_POST['rmc'] : '';
if ($rmc == "rmc"){ 
    
    $rmclient=str_replace('/', '\/', $rmclient);
    $rmclient=rtrim($rmclient);
    $rmclient=trim($rmclient);
    shell_exec("sudo sed -i '/$rmclient/d' /usr/local/etc/raddb/clients.conf"); 
    shell_exec("sudo pkill radiusd && radiusd");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}

?>


<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">Clients </h3></div>

<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>Name</th><th>Network</th><th>Password</th><th></th></tr></thead>
<tr>	
    <form action="" method="post" class="form-horizontal">
    <div class="form-group">
    <td ><input type="text" name="nasname" value="" class="form-control" required=""/></td>
    <td ><input type="text" name="nasnet" value="" class="form-control" required="" placeholder="ex. 192.168.0.0/24 "/></td>
    <td ><input type="text" name="naspass" value="" class="form-control" /></td>
    <input type="hidden" name="addnas" value="add" class="form-control"/>
    <td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button></td>
    </div>
    </form>
</tr>


<?php

$myFile = "/usr/local/etc/raddb/clients.conf";
$lines = file($myFile); 

$arr = array('ipaddr','secret','client');

foreach ($lines as $line) {
    if (strpos($line,'ipaddr') !== false) {
	if (strpos($line,'secret') !== false) {
	    if (strpos($line,'client') !== false) {
		$pieces = explode(" ", $line);
		?>
		<tr>
		<td>		
			<?php echo $pieces[1]; ?> 
		</td>
		<td>
		    <?php echo $pieces[5]; ?>
		</td>
		<td>
		    <?php echo $pieces[9]; ?>
		</td>
		<td>
		    <form action="" method="post" style=" display:inline!important;">
		    <input type="hidden" name="rmclient" value="<?php echo "$line"; ?>" />
		    <input type="hidden" name="rmc" value="rmc" />
    		    <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
		    </form>
		</td>
		</tr>
		<?php
	
    	    }
	}
    }
}
?>
</table>
</div>
</div>