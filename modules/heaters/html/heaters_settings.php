<div class="panel panel-default">
<div class="panel-heading">Heaters</div>
<div class="table-responsive">
<table class="table table-striped table-condensed small">

<?php
$rname = isset($_POST['hname']) ? $_POST['hname'] : '';
$rid = isset($_POST['hid']) ? $_POST['hid'] : '';
$rchg = isset($_POST['hchg']) ? $_POST['hchg'] : '';
$rrom = isset($_POST['hrom']) ? $_POST['hrom'] : '';
$rrm = isset($_POST['hrm']) ? $_POST['hrm'] : '';


if(!empty($rrom) && ($rrm == "hrm")) { 
$db = new PDO('sqlite:dbf/nettemp.db');
$db->exec("DELETE FROM heaters WHERE rom='$hrom'") or die ($db->lastErrorMsg()); 
header("location: " . $_SERVER['REQUEST_URI']);
exit();
}	

if (!empty($rname) && !empty($rid) && ( $rchg == "hchg") ){
$rep = str_replace(" ", "_", $hname);
$db = new PDO('sqlite:dbf/nettemp.db');
$db->exec("UPDATE heaters SET name='$rep' WHERE id='$hid'") or die ($db->lastErrorMsg());
header("location: " . $_SERVER['REQUEST_URI']);
exit();
}




$db = new PDO('sqlite:dbf/nettemp.db');
$sth2 = $db->prepare("select * from heaters ");
$sth2->execute();
$row = $sth2->fetchAll();

?>
<thead>
<tr>
<th>Name</th>
<th>id</th>
<th></th>
</tr>
</thead>



<?php foreach ($row as $a) { 	
	
?>
<tr>
    <td class="col-md-3"><img src="media/ico/TO-220-icon.png" />
    <form action="" method="post" style="display:inline!important;">
	<input type="text" name="rname" size="12" maxlength="30" value="<?php echo $a["name"]; ?>" />
	<input type="hidden" name="rid" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="rchg" value="rchg"/>
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>
    </td>
    <td class="col-md-2">
	<?php echo $a["rom"] ;?>
    </td>
    <td class="col-md-8">
    <form action="" method="post" style="display:inline!important;" >
	<input type="hidden" name="rrom" value="<?php echo $a["rom"]; ?>" />
	<input type="hidden" name="rrm" value="rrm" />
	<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
    </form>
    </td>
</tr>
		

<?php 
}  
?>
</table>
</div>
</div>