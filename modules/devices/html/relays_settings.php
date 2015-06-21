<div class="panel panel-default">
            <div class="panel-heading">Relays</div>
<table class="table table-striped">

<?php
$rname = isset($_POST['rname']) ? $_POST['rname'] : '';
$rid = isset($_POST['rid']) ? $_POST['rid'] : '';
$rchg = isset($_POST['rchg']) ? $_POST['rchg'] : '';
$rrom = isset($_POST['rrom']) ? $_POST['rrom'] : '';
$rrm = isset($_POST['rrm']) ? $_POST['rrm'] : '';


if(!empty($rrom) && ($rrm == "rrm")) { 
$db = new PDO('sqlite:dbf/nettemp.db');
$db->exec("DELETE FROM relays WHERE rom='$rrom'") or die ($db->lastErrorMsg()); 
header("location: " . $_SERVER['REQUEST_URI']);
exit();
}	

if (!empty($rname) && !empty($rid) && ( $rchg == "rchg") ){
$rep = str_replace(" ", "_", $rname);
$db = new PDO('sqlite:dbf/nettemp.db');
$db->exec("UPDATE relays SET name='$rep' WHERE id='$rid'") or die ($db->lastErrorMsg());
header("location: " . $_SERVER['REQUEST_URI']);
exit();
}




$db = new PDO('sqlite:dbf/nettemp.db');
$sth2 = $db->prepare("select * from relays ");
$sth2->execute();
$row = $sth2->fetchAll();

?>
<thead>
<tr>
<th></th>
<th>Name</th>
<th>id</th>
<th>Remove</th>
</tr>
</thead>



<?php foreach ($row as $a) { 	
	
?>
<tr>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<td><img src="media/ico/TO-220-icon.png" /></td>
<td><input type="text" name="rname" size="12" maxlength="30" value="<?php echo $a["name"]; ?>" />
<input type="hidden" name="rid" value="<?php echo $a["id"]; ?>" />
<input type="hidden" name="rchg" value="rchg"/>
<button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span> </button></td>
</form>


<td><?php 	echo  $a["rom"] ;?></td>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
<input type="hidden" name="rrom" value="<?php echo $a["rom"]; ?>" />
<input type="hidden" name="rrm" value="rrm" />
<td><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button></td>

</form>

</tr>
		

<?php 
}  
?>
</table>
</div>
