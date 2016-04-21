<?php
$rs485id = isset($_POST['rs485id']) ? $_POST['rs485id'] : '';
$rmrs485 = isset($_POST['rmrs485']) ? $_POST['rmrs485'] : '';

$addr = isset($_POST['addr']) ? $_POST['addr'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$add = isset($_POST['add']) ? $_POST['add'] : '';

    if (!empty($rs485id) && ($_POST['rmrs485'] == "rmrs485") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("DELETE FROM rs485 WHERE id='$rs485id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    if (!empty($addr) && ($_POST['add'] == "add") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("INSERT OR IGNORE INTO rs485 (dev, addr) VALUES ('$name', '$addr')") or die ("cannot insert to DB" );
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $default = isset($_POST['default']) ? $_POST['default'] : '';
    if ($default == "default") { 
    $db = new PDO("sqlite:dbf/nettemp.db");	
    $db->exec("DELETE from rs485") or header("Location: html/errors/db_error.php");
    $db->exec("INSERT OR IGNORE INTO rs485 (dev, addr) VALUES ('sdm120','2')") or header("Location: html/errors/db_error.php");
    $db->exec("INSERT OR IGNORE INTO rs485 (dev, addr) VALUES ('sdm630','1')") or header("Location: html/errors/db_error.php");
    

    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }
?>




<div class="panel panel-default">
<div class="panel-heading">rs485 address</div>

<div class="table-responsive">
<table class="table table-hover table-condensed small">

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM rs485") or header("Location: html/errors/db_error.php");
$row = $rows->fetchAll();

$lcd = $db->query("SELECT * FROM settings") or header("Location: html/errors/db_error.php");
$lcd = $lcd->fetchAll();
foreach ($lcd as $c) {
$lcd=$c['lcd'];
}


?>
<thead>
<tr>
<th>Name</th>
<th>Address</th>
<th></th>
</tr>
</thead>

<tr>	
    <form action="" method="post" class="form-horizontal">
    <div class="form-group">
    <td class="col-md-2">
    <select name="name" class="form-control input-sm">
        <option value="SDM120">sdm120</option>
        <option value="SDM630">sdm630</option>
    </select>
    </td>
    <td class="col-md-2">
	<input type="text" name="addr" value="" class="form-control input-sm" required=""/>
    </td>
	<input type="hidden" name="add" value="add" class="form-control"/>
    <td class="col-md-8">
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button>
    </td>
    </div>
    </form>
</tr>





<?php foreach ($row as $a) { 	
	
?>
<tr>
    <td class="col-md-2">
	<img src="media/ico/TO-220-icon.png" />
	<?php echo $a['dev']; ?>
    </td>
    <td class="col-md-2">
	<?php echo  $a["addr"] ;?>
    </td>


    <td class="col-md-8">
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="rs485id" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="rmrs485" value="rmrs485" />
	<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
    </form>
    </td>
</tr>
<?php 
}  
?>
</table>

<div class="panel-body">
<form class="form-horizontal" action="" method="post">
<fieldset>
<div class="form-group">
  <div class="col-md-1">
    <input type="hidden" name="default" value="default">
    <button id="singlebutton" name="singlebutton" class="btn btn-xs btn-success">Reset to default</button>
  </div>
</div>
</fieldset>
</form>
</div>
</div>
</div>