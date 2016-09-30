<div class="panel panel-default">
<div class="panel-heading">Heaters</div>
<div class="table-responsive">
<table class="table table-hover " border="0">

<?php
$hname = isset($_POST['hname']) ? $_POST['hname'] : '';
$hid = isset($_POST['hid']) ? $_POST['hid'] : '';
$hchg = isset($_POST['hchg']) ? $_POST['hchg'] : '';
$hrom = isset($_POST['hrom']) ? $_POST['hrom'] : '';
//$h2rom = isset($_POST['h2rom']) ? $_POST['h2rom'] : '';
$hrm = isset($_POST['hrm']) ? $_POST['hrm'] : '';
$tempset = isset($_POST['tempset']) ? $_POST['tempset'] : '';
$hidts = isset($_POST['hidts']) ? $_POST['hidts'] : '';
$hts = isset($_POST['hts']) ? $_POST['ts'] : '';
$hposition = isset($_POST['hposition']) ? $_POST['hposition'] : '';
$hposition_id = isset($_POST['hposition_id']) ? $_POST['hposition_id'] : '';






    if (!empty($hposition_id) && ($_POST['hpositionok'] == "ok")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE heaters SET position='$hposition' WHERE id='$hposition_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 





   if (!empty($tempset) && !empty($hidts)  ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE heaters SET temp_set='$tempset' WHERE id='$hidts'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
   }

if(!empty($hrom) && ($hrm == "hrm")) { 
$db = new PDO('sqlite:dbf/nettemp.db');
$db->exec("DELETE FROM heaters WHERE rom='$hrom'") or die ($db->lastErrorMsg()); 
header("location: " . $_SERVER['REQUEST_URI']);
exit();
}	

if (!empty($hname) && !empty($hid) && ( $hchg == "hchg") ){
$rep = str_replace(" ", "_", $hname);
$db = new PDO('sqlite:dbf/nettemp.db');
$db->exec("UPDATE heaters SET name='$rep' WHERE id='$hid'") or die ($db->lastErrorMsg());
header("location: " . $_SERVER['REQUEST_URI']);
exit();
}




$db = new PDO('sqlite:dbf/nettemp.db');
$sth2 = $db->prepare("SELECT * FROM heaters ORDER BY position ASC");
$sth2->execute();
$row = $sth2->fetchAll();

?>
<thead>
<tr>
<th>Positioning</th>
<th>Name</th>
<th>id</th>
<th>Set Temp.</th>
<th>Mode</th>
<th>Status</th>
<th></th>
</tr>
</thead>



<?php foreach ($row as $a) { 	
	
?>
<tr>

<td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="hposition_id" value="<?php echo $a["id"]; ?>" />
	<input type="text" name="hposition" size="1" maxlength="3" value="<?php echo $a['position']; ?>" />
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
	<input type="hidden" name="hpositionok" value="ok" />
    </form>
    </td>

    <td class="col-md-0"><img src="media/ico/heat.png" />
    <form action="" method="post" style="display:inline!important;">
	<input type="text" name="hname" size="12" maxlength="30" value="<?php echo $a["name"]; ?>" />
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
	<input type="hidden" name="hid" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="hchg" value="hchg"/>
	
    </form>
    </td>
    <td class="col-md-0">
	<?php echo $a["rom"] ;?>
    </td>
	<td class="col-md-0">
	<form action="" method="post" style="display:inline!important;"> 
		<input type="hidden" name="hidts" value="<?php echo $a["id"]; ?>" />
		<input type="text" name="tempset" size="10" value="<?php echo $a["temp_set"]; ?>"
		<input type="hidden" name="hts" value="hts" />
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>
	</td>
	
	
	
	
	
	
	<td class="col-md-0">
	<form action="" method="post" style="display:inline!important;"> 
		<input type="hidden" name="h2rom" value="<?php echo $a["rom"]; ?>" />
		<input type="text" name="tempset" size="3" value="<?php echo $a["mode"]; ?>"
		<input type="hidden" name="hchg" value="hchg" />
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>
	</td>
	
	<td class="col-md-0">
	<form action="" method="post" style="display:inline!important;"> 
		<input type="hidden" name="h2rom" value="<?php echo $a["rom"]; ?>" />
		<input type="text" name="tempset" size="3" value="<?php echo $a["status"]; ?>"
		<input type="hidden" name="hchg" value="hchg" />
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>
	</td>
	
	
	
	
	
	
    <td class="col-md-8">
    <form action="" method="post" style="display:inline!important;" >
	<input type="hidden" name="hrom" value="<?php echo $a["rom"]; ?>" />
	<input type="hidden" name="hrm" value="hrm" />
	<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
    </form>
    </td>
</tr>
</tr>		

<?php 
}  
?>
</table>
</div>
</div>