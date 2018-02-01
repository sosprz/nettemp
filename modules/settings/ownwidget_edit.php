<style>
   textarea { width: 100%; height: 100%; }
</style>

<div class="panel panel-default">
<div class="panel-heading">Widget example</div>
    <div class="panel-body">
	
	
	
<pre>
  
    &lt;?php 
	echo "My first nettemp widget";
    ?&gt;
 
</pre>

		<form action="" method="post" style="display:inline!important;">
			<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-plus"></span> </button>
			<input type="hidden" name="addow" value="addow"/>
		</form>
</div>
</div>

<?php 





$ow = isset($_POST['ow']) ? $_POST['ow'] : '';
$ow_name = isset($_POST['ow_name']) ? $_POST['ow_name'] : '';
$bodystext = isset($_POST['bodystext']) ? $_POST['bodystext'] : '';
$name_new = isset($_POST['name_new']) ? $_POST['name_new'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$ow_num = isset($_POST['ow_num']) ? $_POST['ow_num'] : '';


//add ow to base
$addow = isset($_POST['addow']) ? $_POST['addow'] : '';
if(!empty($addow) && ($addow == "addow")) { 
	$ownr=substr(rand(), 0, 4);
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("INSERT INTO ownwidget ('name', 'body', 'onoff', 'iflogon') VALUES ('My widget','$ownr', 'off', 'off')");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
} 

//body
if(!empty($id) && ($ow == "ow")) { 

	file_put_contents("tmp/ownwidget".$ow_num.".php", $_POST['text'.$ownum]);
	$db = new PDO('sqlite:dbf/nettemp.db');
	//$db->exec("UPDATE ownwidget SET body='$bodystext' WHERE id='$id'");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
} 

//name
if(!empty($id) && !empty($name_new) && ($ow_name == "ow_name")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE ownwidget SET name='$name_new' WHERE id='$id'");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
}

//visible
$visibleonoff= isset($_POST['visibleonoff']) ? $_POST['visibleonoff'] : '';
$visible= isset($_POST['visible']) ? $_POST['visible'] : '';
if(!empty($id) && !empty($visible) && ($visibleonoff == "visibleonoff")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE ownwidget SET onoff='$visible' WHERE id='$id'");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
} 
//if logon
$if_logon= isset($_POST['if_logon']) ? $_POST['if_logon'] : '';
$logon= isset($_POST['logon']) ? $_POST['logon'] : '';
if(!empty($id) && !empty($logon) && ($if_logon == "if_logon")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE ownwidget SET iflogon='$logon' WHERE id='$id'");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
} 

//del from base
$del= isset($_POST['del']) ? $_POST['del'] : '';
if(!empty($id) && !empty($del) && ($del == "delete")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM ownwidget WHERE id='$id'");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
} 



$db = new PDO('sqlite:dbf/nettemp.db');

$rows = $db->query("SELECT * FROM ownwidget");
$row = $rows->fetchAll();
foreach($row as $z) {
	$ownum = $z['body'];
	$owname = $z['name'];
	
	$file = "tmp/ownwidget".$ownum.".php";
    $text = file_get_contents($file);
	
	if (isset($_POST['text'.$ownum]))
{
    file_put_contents($file, $_POST['text'.$ownum]);

 }
	
?>




  <div class="panel panel-default">
  <div class="panel-heading"><?php echo "Widget name:  "?>
  
		  <form action="" method="post" style="display:inline!important;">
				<input type="text" name="name_new" size="15" maxlength="30" value="<?php echo $z["name"]; ?>" />
				<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
				<input type="hidden" name="id" value="<?php echo $z["id"]; ?>" />
				<input type="hidden" name="ow_name" value="ow_name"/>
		  </form>
  
  </div>
	<div class="panel-body">

		  <form action="" method="post" style="display:inline!important;">
			<div style="height:300px;overflow:auto;padding:5px;">
			<textarea name="<?php echo text.$ownum?>"><?php echo htmlspecialchars($text) ?></textarea><br />
			</div>
			<input type="hidden" name="ow_num" value="<?php echo $z["body"]; ?>" />
			<input type="hidden" name="id" value="<?php echo $z["id"]; ?>" />
			<input type="hidden" name="ow" value="ow"/>
			<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
		 </form>
		  
		 <form action="" method="post" style="display:inline!important;">
		 <label>Status:</label>
			<input type="hidden" name="id" value="<?php echo $z["id"]; ?>" />
			<button type="submit" name="visible" value="<?php echo $z["onoff"] == 'on' ? 'off' : 'on'; ?>" <?php echo $z["onoff"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>> <?php echo $z["onoff"] == 'on' ? 'ON' : 'OFF'; ?></button>
			<input type="hidden" name="visibleonoff" value="visibleonoff" />
		</form>
		
		<form action="" method="post" style="display:inline!important;">
		<label>Logon:</label>
			<input type="hidden" name="id" value="<?php echo $z["id"]; ?>" />
			<button type="submit" name="logon" value="<?php echo $z["iflogon"] == 'on' ? 'off' : 'on'; ?>" <?php echo $z["iflogon"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>> <?php echo $z["iflogon"] == 'on' ? 'ON' : 'OFF'; ?></button>
			<input type="hidden" name="if_logon" value="if_logon" />
		</form>
		
		<form action="" method="post" style="display:inline!important;">
			<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
			<input type="hidden" name="id" value="<?php echo $z['id']; ?>" />
			<input type="hidden" name="del" value="delete"/>
		</form>
	</div>
</div>
	
<?php	
	
	
	
}

?>

