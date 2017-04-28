<?php
$file = isset($_GET['file']) ? $_GET['file'] : '';
$filee = isset($_POST['filee']) ? $_POST['filee'] : '';
$save = isset($_POST['save']) ? $_POST['save'] : '';
$value = isset($_POST['value']) ? $_POST['value'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$replace= isset($_POST['replace']) ? $_POST['replace'] : '';
$sreplace= isset($_POST['sreplace']) ? $_POST['sreplace'] : '';
$rreplace= isset($_POST['rreplace']) ? $_POST['rreplace'] : '';
$search= $_POST['search'];
//$search= isset($_POST['search']) ? $_POST['search'] : '';
if(empty($search)) {
	$search= isset($_GET['search']) ? $_GET['search'] : '';
}
if (($save == "save")){
    $db = new PDO("sqlite:db/$filee.sql");
    $db->exec("UPDATE def SET value='$value' WHERE rowid='$id'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if ($replace == "set"){
    $db = new PDO("sqlite:db/$filee.sql");
    $db->exec("UPDATE def SET value='$rreplace' WHERE value='$sreplace'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}

?>
<div class="panel panel-default">
<div class="panel-heading">Search in <?php echo $file.".sql" ?></div>
<div class="panel-body">
	<form action="" method="post" style="display:inline!important;">
      Search value: <input type="input" size="4" name="search" value="<?php echo $search ?>" />
    	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button>
    	<input type="hidden" name="save" value="empty" />
    </form>
    <form action="" method="post">
      <input type="hidden" name="filee" value="<?php echo $file ?>" />
      Search value: <input type="input" size="4" name="sreplace" value="" />
      replace: <input type="input" size="4" name="rreplace" value="" />
    	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button>
    	<input type="hidden" name="replace" value="set" />
    </form>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">Edit: <?php echo $file.".sql" ?></div>

<?php
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$pstop=100;
$pstart = ($page-1) * $pstop; 

$db = new PDO("sqlite:db/$file.sql");
if(empty($search)) {
	$rows = $db->query("SELECT rowid,* FROM def Limit $pstart, $pstop");
}
else {
	$rows = $db->query("SELECT rowid,* FROM def WHERE value='$search' Limit $pstart, $pstop");
}
$row = $rows->fetchAll();
?>
<table class="table table-striped table-hover small">
<thead>
<tr>
<th>id</th>
<th>time</th>
<th>value / current</th>
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
      <input type="input" size="4" name="current" value="<?php echo $a['current']?>" />
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
<?php
	
	
	if(empty($search)) {
		$rows = $db->query("SELECT * FROM def");
	}
	else {
		$rows = $db->query("SELECT * FROM def WHERE value='$search'");
	}
	$row = $rows->fetchAll();
	$total_records = count($row);
	
	if($total_records >=101) {
	
	$total_pages = ceil($total_records / $pstop); 
	
	echo "<a href='index.php?id=tools&type=dbedit2&file=$file&search=$search&page=1'>".'|<'."</a> ";
	
	for ($i=1; $i<=$total_pages; $i++) { 
            echo "<a href='index.php?id=tools&type=dbedit2&file=$file&search=$search&page=".$i."'>".$i."</a> "; 
	}; 	
	
	echo "<a href='index.php?id=tools&type=dbedit2&file=$file&search=$search&page=$total_pages'>".'>|'."</a> "; 
	
}
	?>
</div>