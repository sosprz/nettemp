<div class="panel panel-default">
<div class="panel-heading">Sensors</div>

<div class="table-responsive">
<table class="table table-hover">

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();

$lcd = $db->query("SELECT * FROM settings");
$lcd = $lcd->fetchAll();
foreach ($lcd as $c) {
$lcd=$c['lcd'];
}


?>
<thead>
<tr>
<th>Name</th>
<th>id</th>
<th>Size</th>
<th>Status</th>
<?php if ( $lcd == 'on' ) { ?> <th>LCD</th> <?php } ?>
<th></th>
</tr>
</thead>



<?php foreach ($row as $a) { 	
	
?>
<tr>
    <td class="col-md-2">
	<img src="media/ico/TO-220-icon.png" />
    <form action="" method="post" style="display:inline!important;">
	<input type="text" name="name_new" size="12" maxlength="30" value="<?php echo $a["name"]; ?>" />
	<button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span> </button>
	<input type="hidden" name="name_id" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="id_name2" value="id_name3"/>
    </form>
    </td>
    <td class="col-md-1">
	<?php echo  $a["rom"] ;?>
    </td>
<?php
	$id_rom3 = str_replace(" ", "_", $a["rom"]);
	$id_rom2 = "$id_rom3.sql";
	$file3 =  "db/$id_rom2";
	if (file_exists($file3) && ( 0 != filesize($file3)))
	{
?>
<td class="col-md-1"><?php $filesize = (filesize("$file3") * .0009765625) * .0009765625; echo round($filesize, 3) ?>MB</td>
<td class="col-md-1"><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-ok"></span> </button></td>
<!-- </form>-->
<?php   }
else { ?> 
<td class="col-md-1">Error - no sql base</td>
<?php } ?>

<?php 
if ( $lcd == 'on' ) { 
?>
    <td class="col-md-1">
    <form action="" method="post" style="display:inline!important;"> 	
	<input type="hidden" name="lcdid" value="<?php echo $a["id"]; ?>" />
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="lcdon" value="on" <?php echo $a["lcd"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="lcd" value="lcd" />
    </form>
    </td>
<?php
}
?>
    <td class="col-md-6">
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="usun_czujniki" value="<?php echo $a["rom"]; ?>" />
	<input type="hidden" name="usun2" value="usun3" />
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