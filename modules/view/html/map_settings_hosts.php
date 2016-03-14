<?php
 	 $h_map = isset($_POST['h_map']) ? $_POST['h_map'] : '';
    $h_maponoff = isset($_POST['h_maponoff']) ? $_POST['h_maponoff'] : '';
    $h_mapon = isset($_POST['h_mapon']) ? $_POST['h_mapon'] : '';
    if (($h_maponoff == "onoff")){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE hosts SET map='$h_mapon' WHERE id='$map'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
    }
    
       
    ?>
    
    
<div class="panel panel-default">
<div class="panel-heading">Hosts</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small">
<thead>
<tr>
<th>Name</th>
<th>Map</th>
</tr>
</thead>


<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from hosts ORDER BY position ASC");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {  
?>
<tr>
 	<td><?php echo str_replace("host_", "",$a["name"]);?>
 	</td>
	<td>
	<form action="" method="post" style="display:inline!important;"> 	
	    <input type="hidden" name="h_map" value="<?php echo $a["id"]; ?>" />
	    <input type="checkbox" data-toggle="toggle" data-size="mini"  name="h_mapon" value="on" <?php echo $a["map"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	    <input type="hidden" name="h_maponoff" value="onoff" />
	</form>
	</td>
</tr>
	
<?php 
    }
?>
</table>
</div>
</div>