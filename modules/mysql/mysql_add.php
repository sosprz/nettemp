<?php

include_once('modules/mysql/mysql_conf.php');
$conn = new mysqli($IP, $USER, $PASS, $DB);

 $add = isset($_POST['add']) ? $_POST['add'] : '';
 $name = isset($_POST['name']) ? $_POST['name'] : '';
 if (($add == "add")){
 	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "CREATE TABLE $name (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	value INTEGER
	)";

	if ($conn->query($sql) === TRUE) {
    	echo "Table $name created successfully";
	} else {
   	 echo "Error creating table: " . $conn->error;
	}		
	$conn->close();
       
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
	
	
 $rm = isset($_POST['rm']) ? $_POST['rm'] : '';
 $name = isset($_POST['name']) ? $_POST['name'] : '';
 if (($rm== "rm")){
	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "DROP TABLE $name";

	if ($conn->query($sql) === TRUE) {
    	echo "Table $name removed successfully";
	} else {
   	 echo "Error removing table: " . $conn->error;
	}		
	$conn->close();
     
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    	
}
	
	
    
  

?> 

<div class="panel panel-default">
<div class="panel-heading">Sensors</div>

<div class="table-responsive">
<table class="table table-hover table-condensed small" border="0">

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors ORDER BY position ASC");
$row = $rows->fetchAll();
?>
<thead>
<tr>
<th>Name</th>
<th>SQL</th>
<th>Create table</th>
<th>Delete table</th>
</tr>
</thead>



<?php 
    foreach ($row as $a) { 	
?>
<tr>
	
		
    <td class="col-md-1">
		<?php echo $a['name']; ?>
	</td>
	<td class="col-md-1">
	<?php
	$rom=$a['rom'];
	$check_exists = $conn->query("SHOW TABLES LIKE '$rom'");
	$table_exists = $check_exists->num_rows;
	if ($table_exists > 0) {
   	echo "Table $rom exist";
	} 
	else {
  		echo "Table $rom not exist: " . $conn->error;
	}	


	
	?>
	</td>

    <td class="col-md-1">
    <form action="" method="post" style="display:inline!important;"> 	
	<input type="hidden" name="name" value="<?php echo $a["rom"]; ?>" />
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button>
	<input type="hidden" name="add" value="add" />
    </form>
  
	<td class="col-md-1">
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="name" value="<?php echo $a["rom"]; ?>" />
	<input type="hidden" name="rm" value="rm" />
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
