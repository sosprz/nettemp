<?php
$rs485id = isset($_POST['rs485id']) ? $_POST['rs485id'] : '';
$rmrs485 = isset($_POST['rmrs485']) ? $_POST['rmrs485'] : '';

$addr = isset($_POST['addr']) ? $_POST['addr'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$baud = isset($_POST['baud']) ? $_POST['baud'] : '';

$add = isset($_POST['add']) ? $_POST['add'] : '';

    if (!empty($rs485id) && ($_POST['rmrs485'] == "rmrs485") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("DELETE FROM rs485 WHERE id='$rs485id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    if ($_POST['add'] == "add"){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("INSERT OR IGNORE INTO rs485 (dev, addr, baudrate) VALUES ('$name','$addr', '$baud')") or die ("cannot insert to DB" );
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $default = isset($_POST['default']) ? $_POST['default'] : '';
    if ($default == "default") { 
    $db = new PDO("sqlite:dbf/nettemp.db");	
    $db->exec("DELETE from rs485") or header("Location: html/errors/db_error.php");
    $db->exec("INSERT OR IGNORE INTO rs485 (dev, addr, baudrate) VALUES ('SDM120','2', '9600')") or header("Location: html/errors/db_error.php");
    $db->exec("INSERT OR IGNORE INTO rs485 (dev, addr, baudrate) VALUES ('SDM630','1', '9600')") or header("Location: html/errors/db_error.php");
    

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



?>
<thead>
<tr>
<th>Name</th>
<th>Address</th>
<th>Baudrate</th>
<th></th>
</tr>
</thead>

<tr>	
    <form action="" method="post" class="form-horizontal">
    <div class="form-group">
    <td class="col-md-1">
    <select name="name" class="form-control input-sm">
        <option value="SDM120">SDM120</option>
        <option value="SDM630">SDM630</option>
         <option value="OR-WE">OR-WE</option>
    </select>
    </td>
    
	<td class="col-md-1">
	<input type="text" name="addr" value="" class="form-control input-sm" required=""/>
    </td>
	
	<td class="col-md-1">
    <select name="baud" class="form-control input-sm">
        <option value="2400">2400</option>
        <option value="9600">9600</option>
         <option value="115200">115200</option>
    </select>
    </td>
	
	<input type="hidden" name="add" value="add" class="form-control"/>
    <td class="col-md-9">
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button>
    </td>
    </div>
    </form>
</tr>





<?php foreach ($row as $a) { 	
	
?>
<tr>
    <td class="col-md-1">
	<img src="media/ico/TO-220-icon.png" />
	<?php echo $a['dev']; ?>
    </td>
    
	<td class="col-md-1">
	<?php echo  $a["addr"] ;?>
    </td>
	
	<td class="col-md-1">
	<?php echo  $a["baudrate"] ;?>
    </td>


    <td class="col-md-9">
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
<tr>
<td>

<form class="form-horizontal" action="" method="post">


  <div class="col-md-1">
    <input type="hidden" name="default" value="default">
    <button id="singlebutton" name="singlebutton" class="btn btn-xs btn-success">Reset to default</button>
  </div>


</form>
</td>

</td><td>
</td><td>
</td><td>

</tr>
</table>

</div>
</div>
