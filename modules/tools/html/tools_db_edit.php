<div class="panel panel-default">
<div class="panel-heading">DB edit</div>

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();


//DEL from Def
$rom = isset($_POST['rom']) ? $_POST['rom'] : '';
$delolder = isset($_POST['delolder']) ? $_POST['delolder'] : '';

if(!empty($rom) && !empty($delolder)) { 

	$db2 = new PDO("sqlite:db/$rom.sql");
	
	if ($delolder !='all') {
		
	
		$db2->exec("DELETE FROM def WHERE time <= datetime('now','localtime','$delolder')") or die ("No data to delete." );
		
		
	} else {
		
		$db2->exec("DELETE FROM def") or die ("cannot insert to DB humi2 " );
	}
	$db2->exec("vacuum") or die ("No vacuum." );	
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();

} 


?>
<table class="table table-striped table-hover small">
<thead>
<tr>
<th>Name</th>
<th>Rom</th>
<th>Delete older than:</th>
<th>Size</th>
<th>Edit</th>

</tr>
</thead>


<?php 
    foreach ($row as $a) { 	
	
	$file = $a['rom'].'.sql';
	$file2 = "db/$file";
?>
<tr>
    <td class="col-md-1"><?php echo $a['name']?></td>
    <td class="col-md-1"><?php echo $a['rom']?></td>
	
	<td class="col-md-2">
	<form action="" method="post" style="display:inline!important;">
    <input type="hidden" name="rom" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-danger">1 mth</button>
    <input type="hidden" name="delolder" value="-1 months" />
    </form>
	
	<form action="" method="post" style="display:inline!important;">
    <input type="hidden" name="rom" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-danger">3 mth</button>
    <input type="hidden" name="delolder" value="-3 months" />
    </form>
	
	<form action="" method="post" style="display:inline!important;">
    <input type="hidden" name="rom" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-danger">6 mth</span></button>
    <input type="hidden" name="delolder" value="-6 months" />
    </form>
	
	<form action="" method="post" style="display:inline!important;">
    <input type="hidden" name="rom" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-danger">Year</span></button>
    <input type="hidden" name="delolder" value="-1 year" />
    </form>
	
	<form action="" method="post" style="display:inline!important;">
    <input type="hidden" name="rom" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-danger">All</button>
    <input type="hidden" name="delolder" value="all" />
    </form>
    </td>
	
	<td class="col-md-1">
		<span class="label label-info"><?php $filesize = (filesize("$file2") * .0009765625) * .0009765625; echo round($filesize, 3)." MB" ?></span>
	</td>
	
	
    <td class="col-md-7">
    <form action="?id=tools&type=dbedit2&file=<?php echo $a['rom']?>" method="post" style="display:inline!important;">
    <input type="hidden" name="file" value="<?php echo $a['rom']?>" />
    <button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
    <input type="hidden" name="csv" value="get" />
    </form>
	</td>
</tr>
<?php 
    }
?>
</table>
</div>