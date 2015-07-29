<?php
$i2cid = isset($_POST['i2cid']) ? $_POST['i2cid'] : '';
$rmi2c = isset($_POST['rmi2c']) ? $_POST['rmi2c'] : '';

$addr = isset($_POST['addr']) ? $_POST['addr'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$add = isset($_POST['add']) ? $_POST['add'] : '';

    if (!empty($i2cid) && ($_POST['rmi2c'] == "rmi2c") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("DELETE FROM i2c WHERE id='$i2cid'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    if (!empty($addr) && ($_POST['add'] == "add") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("INSERT OR IGNORE INTO i2c (name, addr) VALUES ('$name', '$addr')") or die ("cannot insert to DB" );
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $default = isset($_POST['default']) ? $_POST['default'] : '';
    if ($default == "default") { 
    $db = new PDO("sqlite:dbf/nettemp.db");	
    $db->exec("DELETE table i2c") or header("Location: html/errors/db_error.php");
    $db->exec("INSERT OR IGNORE INTO i2c (name, addr) VALUES ('bmp180','77')") or header("Location: html/errors/db_error.php");
    $db->exec("INSERT OR IGNORE INTO i2c (name, addr) VALUES ('tsl2561','39')") or header("Location: html/errors/db_error.php");
    $db->exec("INSERT OR IGNORE INTO i2c (name, addr) VALUES ('ds2482','18')") or header("Location: html/errors/db_error.php");	
    $db->exec("INSERT OR IGNORE INTO i2c (name, addr) VALUES ('htu21d','40')") or header("Location: html/errors/db_error.php");
    $db->exec("INSERT OR IGNORE INTO i2c (name, addr) VALUES ('mpl3115a2','60')") or header("Location: html/errors/db_error.php");
    $db->exec("INSERT OR IGNORE INTO i2c (name, addr) VALUES ('hih6130','27')") or header("Location: html/errors/db_error.php");
    $db->exec("INSERT OR IGNORE INTO i2c (name, addr) VALUES ('tmp102','48')") or header("Location: html/errors/db_error.php");

    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }
?>




<div class="panel panel-default">
<div class="panel-heading">I2C address</div>

<div class="table-responsive">
<table class="table table-hover">

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM i2c") or header("Location: html/errors/db_error.php");
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
    <select name="name" class="form-control">
        <option value="ds2482">ds2482</option>
        <option value="bmp180">bmp180</option>
	<option value="tsl2561">tsl2561</option>
	<option value="htu21d">htu21d</option>
	<option value="mpl3115a2">mpl3115a2</option>
	<option value="hih6130">hih6130</option>
	<option value="tmp102">tmp102</option>
    </select>
    </td>
    <td class="col-md-2">
	<input type="text" name="addr" value="" class="form-control" required=""/>
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
	<?php echo $a["name"]; ?>
    </td>
    <td class="col-md-2">
	<?php echo  $a["addr"] ;?>
    </td>


    <td class="col-md-8">
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="i2cid" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="rmi2c" value="rmi2c" />
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
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Reset to default</button>
  </div>
</div>
</fieldset>
</form>
</div>
</div>
</div>