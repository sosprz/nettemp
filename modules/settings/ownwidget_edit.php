<?php 


$ow = isset($_POST['ow']) ? $_POST['ow'] : '';
$ow_name = isset($_POST['ow_name']) ? $_POST['ow_name'] : '';
$bodystext = isset($_POST['bodystext']) ? $_POST['bodystext'] : '';
$name_new = isset($_POST['name_new']) ? $_POST['name_new'] : '';
$id= isset($_POST['id']) ? $_POST['id'] : '';

//body
if(!empty($id) && ($ow == "ow")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE ownwidget SET body='$bodystext' WHERE id='$id'");
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
//visible
$if_logon= isset($_POST['if_logon']) ? $_POST['if_logon'] : '';
$logon= isset($_POST['logon']) ? $_POST['logon'] : '';
if(!empty($id) && !empty($logon) && ($if_logon == "if_logon")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE ownwidget SET iflogon='$logon' WHERE id='$id'");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
} 


$db = new PDO('sqlite:dbf/nettemp.db');

$rows = $db->query("SELECT * FROM ownwidget");
$row = $rows->fetchAll();
foreach($row as $z) {
	$owbodys = $z['body'];
	$owname = $z['name'];
	
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
			<textarea name="bodystext"><?php echo$z['body'];?></textarea><br />
			</div>
			
			<input type="hidden" name="id" value="<?php echo $z["id"]; ?>" />
			<input type="hidden" name="ow" value="ow"/>
			<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
		 </form>
		  
		 <form action="" method="post" style="display:inline!important;">
		 <label for="exampleInputName2">In status:</label>
			<input type="hidden" name="id" value="<?php echo $z["id"]; ?>" />
			<button type="submit" name="visible" value="<?php echo $z["onoff"] == 'on' ? 'off' : 'on'; ?>" <?php echo $z["onoff"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>> <?php echo $z["onoff"] == 'on' ? 'ON' : 'OFF'; ?></button>
			<input type="hidden" name="visibleonoff" value="visibleonoff" />
		</form>
		
		<form action="" method="post" style="display:inline!important;">
			<input type="hidden" name="id" value="<?php echo $z["id"]; ?>" />
			<button type="submit" name="logon" value="<?php echo $z["iflogon"] == 'on' ? 'off' : 'on'; ?>" <?php echo $z["iflogon"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>> <?php echo $z["iflogon"] == 'on' ? 'ON' : 'OFF'; ?></button>
			<input type="hidden" name="if_logon" value="if_logon" />
		</form>
</div>
</div>
	
<?php	
	
	
	
}

?>
<style>
   textarea { width: 100%; height: 100%; }
</style>

<div class="panel panel-default">
<div class="panel-heading">Widget example</div>
    <div class="panel-body">
	
	
	
<pre>
    &lt;div class="panel-heading"&gt;Widget&lt;/div&gt;
    &lt;div class="panel-body"&gt;
    &lt;?php 
	echo "My first nettemp widget";
    ?&gt;
    &lt;/div&gt;
</pre>
</div>
</div>



<?php
foreach (range(1, 10) as $v) {

$file = "tmp/ownwidget".$v.".php";
$text = file_get_contents($file);

if (isset($_POST['text'.$v]))
{
    file_put_contents($file, $_POST['text'.$v]);

    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
    exit();
}

?>

<div class="panel panel-default">
  <div class="panel-heading"><?php echo "Widget ".$v;?></div>
  <div class="panel-body">

  <form action="" method="post">
    <div style="height:300px;overflow:auto;padding:5px;">
	<textarea name="bodystext"><?php echo$z['body'];?></textarea><br />
    </div>
	
	<input type="hidden" name="ow" value="ow"/>
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
   
   
   
  </form>
</div>
</div>

<?php
unset($v);
    }
?>