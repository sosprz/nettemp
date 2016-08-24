<?php
    $save = isset($_POST['save']) ? $_POST['save'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
    $unit2 = isset($_POST['unit2']) ? $_POST['unit2'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
	 $ico = isset($_POST['ico']) ? $_POST['ico'] : '';
    $save_id = isset($_POST['save_id']) ? $_POST['save_id'] : '';
	 $add = isset($_POST['add']) ? $_POST['add'] : '';
   	 
    if ($save == 'save1'){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE types SET title='$title',unit2='$unit2',unit='$unit',type='$type',ico='$ico' WHERE id='$save_id'") or die ("cannot update to DB" );
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    if ($add == 'add1'){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('$type','$unit','$unit2','$ico','$title')") or die ("cannot insert to DB");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    if ($add == 'del1'){
    $db = new PDO('sqlite:dbf/nettemp.db');
	 $db->exec("DELETE FROM types WHERE id='$save_id'") or die ("cannot insert to DB");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>

<div class="panel panel-default">
<div class="panel-heading">Types</div>

<div class="table-responsive">
<table class="table table-hover table-condensed small" border="0">

<?php
$rows = $db->query("SELECT * FROM types ");
$row = $rows->fetchAll();
?>
<thead>
<tr>
<th></th>
<th>Type</th>
<th>Unit</th>
<th>Unit2</th>
<th>ICO</th>
<th>Title</th>
<th></th>
</tr>
</thead>


<tr>
	 <td>
	 </td>
	 <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
		<input type="text" name="type" size="10" maxlength="30" value="" />
    </td>
     <td class="col-md-0">
		<input type="text" name="unit" size="10" maxlength="30" value="" />
    </td>
     <td class="col-md-0">
		<input type="text" name="unit2" size="10" maxlength="30" value="" />
    </td>
    <td class="col-md-0">
		<input type="text" name="ico" size="25" maxlength="30" value="" />
    </td>
	<td class="col-md-0">
		<input type="text" name="title" size="10" maxlength="30" value="" />
    </td>
    <td class="col-md-0">
	
    </td>
    <td class="col-md-6">
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button>
		<input type="hidden" name="add" value="add1"/>
    </form>
    </td>
</tr>
<?php 
   foreach ($row as $a) { 	
	?>
<tr>
	 <td>
	 <?php echo $type="<img src=\"".$a['ico']."\" alt=\"\" title=\"".$a['title']."\"/>"; ?>
	 </td>
	 <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
		<input type="text" name="type" size="10" maxlength="30" value="<?php echo $a['type']; ?>" />
    </td>
     <td class="col-md-0">
		<input type="text" name="unit" size="10" maxlength="30" value="<?php echo $a['unit']; ?>" />
    </td>
     <td class="col-md-0">
		<input type="text" name="unit2" size="10" maxlength="30" value="<?php echo $a['unit2']; ?>" />
    </td>
    <td class="col-md-0">
		<input type="text" name="ico" size="25" maxlength="30" value="<?php echo $a['ico']; ?>" />
    </td>
	<td class="col-md-0">
		<input type="text" name="title" size="10" maxlength="30" value="<?php echo $a['title']; ?>" />
    </td>
    <td class="col-md-0">
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-save"></span> </button>
		<input type="hidden" name="save_id" value="<?php echo $a['id']; ?>" />
		<input type="hidden" name="save" value="save1"/>
    </td>
    </form>
    <td class="col-md-6">
    <form action="" method="post" style="display:inline!important;">
		<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
		<input type="hidden" name="save_id" value="<?php echo $a['id']; ?>" />
		<input type="hidden" name="add" value="del1"/>
    </form>
    </td>
</tr>
   
<?php
	}
	?>



</table>
</div>

