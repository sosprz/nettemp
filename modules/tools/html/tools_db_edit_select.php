<?php
$file = isset($_GET['file']) ? $_GET['file'] : '';
$filee = isset($_POST['filee']) ? $_POST['filee'] : '';
$save = isset($_POST['save']) ? $_POST['save'] : '';
$value = isset($_POST['value']) ? $_POST['value'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';
if (($save == "save")){
    $db = new PDO("sqlite:db/$filee.sql");
    $db->exec("UPDATE def SET value='$value' WHERE rowid='$id'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}

?>
<div class="panel panel-default">
<div class="panel-heading">Edit: <?php echo $file.".sql" ?></div>

<?php
$db = new PDO("sqlite:db/$file.sql");
$rows = $db->query("SELECT rowid,* FROM def");
$row = $rows->fetchAll();
?>
<table class="table table-striped table-hover small">
<thead>
<tr>
<th>id</th>
<th>time</th>
<th>value</th>
</tr>
</thead>


<?php 
    foreach ($row as $a) { 	
?>
<tr>
	 <td class="col-md-0"><?php echo $a['rowid']?></td>
    <td class="col-md-0"><?php echo $a['time']?></td>
    <td class="col-md-10">
    <form action="" method="post" style="display:inline!important;">
      <input type="input" size="4" name="value" value="<?php echo $a['value']?>" />
      <input type="hidden" name="filee" value="<?php echo $file ?>" />
      <input type="hidden" name="id" value="<?php echo $a['rowid'] ?>" />
    	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
    	<input type="hidden" name="save" value="save" />
    </form>
    </td>
</tr>
<?php 
    }
?>
</table>
</div>