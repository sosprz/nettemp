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

//hide ownwidget in edit
	$hideowe = isset($_POST['hideowe']) ? $_POST['hideowe'] : '';
	$hideoweid = isset($_POST['hideoweid']) ? $_POST['hideoweid'] : '';
	$hideowestate = isset($_POST['hideowestate']) ? $_POST['hideowestate'] : '';
	
	if (!empty($hideoweid) && $hideowe == 'hideowe'){
		if ($hideowestate == 'on') {$hideowestate = 'off';
		}elseif ($hideowestate == 'off') {$hideowestate = 'on';}
		
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE ownwidget SET edithide='$hideowestate' WHERE id='$hideoweid'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }	

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
	$db->exec("INSERT INTO ownwidget ('name', 'body', 'onoff', 'iflogon', 'refresh', 'hide') VALUES ('My_widget','$ownr', 'on', 'off', 'off', 'off')");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
} 

//body
if(!empty($id) && ($ow == "ow")) { 
	file_put_contents("tmp/ownwidget".$ow_num.".php", $bodystext);
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
} 

//name
if(!empty($id) && !empty($name_new) && ($ow_name == "ow_name")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$name_new2 = str_replace(' ', '_', $name_new);
	$db->exec("UPDATE ownwidget SET name='$name_new2' WHERE id='$id'");
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
//refresh
$ref= isset($_POST['ref']) ? $_POST['ref'] : '';
$refresh= isset($_POST['refresh']) ? $_POST['refresh'] : '';
if(!empty($id) && !empty($refresh) && ($ref == "ref")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE ownwidget SET refresh='$refresh' WHERE id='$id'");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
} 

//del from base
$del= isset($_POST['del']) ? $_POST['del'] : '';
if(!empty($id) && !empty($del) && ($del == "delete")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM ownwidget WHERE id='$id'");
	if (file_exists("tmp/ownwidget".$ow_num.".php")) {
        unlink("tmp/ownwidget".$ow_num.".php");
	}
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
} 



$db = new PDO('sqlite:dbf/nettemp.db');

$rows = $db->query("SELECT * FROM ownwidget");
$row = $rows->fetchAll();
foreach($row as $z) {
	$ownum = $z['body'];
	$owname = str_replace('_', ' ', $z['name']);
	$owhedit = $z['edithide'];
	
	$file = "tmp/ownwidget".$ownum.".php";
    $text = file_get_contents($file);
	

?>

  <div class="panel panel-default">
  <div class="panel-heading">
   
 <div class="pull-left"><?php echo "Widget name:  "?>
  
		  <form action="" method="post" style="display:inline!important;">
				<input type="text" name="name_new" size="15" maxlength="30" value="<?php echo $owname; ?>" />
				<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
				<input type="hidden" name="id" value="<?php echo $z["id"]; ?>" />
				<input type="hidden" name="ow_name" value="ow_name"/>
		  </form>
  
  </div>
  
  <div class="pull-right">
		<div class="text-right">
			 <form action="" method="post" style="display:inline!important;">
					
					<input type="hidden" name="hideowestate" value="<?php echo $owhedit; ?>" />
					<input type="hidden" name="hideowe" value="hideowe"/>
					<input type="hidden" name="hideoweid" value="<?php echo $z["id"]; ?>"/>
					<?php
					if($owhedit =='off'){ ?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-top"></span> </button>
					<?php } elseif($owhedit =='on'){?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-bottom"></span> </button>
					<?php } ?>
				</form>	
		</div>
  </div>
  <div class="clearfix"></div>
</div>
  
<?php
if ($owhedit == 'off') { ?>
  
  
	<div class="panel-body">

		  <form action="" method="post" style="display:inline!important;">
			<div style="height:300px;overflow:auto;padding:5px;">
			<textarea name="bodystext"><?php echo htmlspecialchars($text) ?></textarea><br />
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
		<label>Logon required:</label>
			<input type="hidden" name="id" value="<?php echo $z["id"]; ?>" />
			<button type="submit" name="logon" value="<?php echo $z["iflogon"] == 'on' ? 'off' : 'on'; ?>" <?php echo $z["iflogon"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>> <?php echo $z["iflogon"] == 'on' ? 'ON' : 'OFF'; ?></button>
			<input type="hidden" name="if_logon" value="if_logon" />
		</form>
		
		<form action="" method="post" style="display:inline!important;">
		<label>Refresh:</label>
			<input type="hidden" name="id" value="<?php echo $z["id"]; ?>" />
			<button type="submit" name="refresh" value="<?php echo $z["refresh"] == 'on' ? 'off' : 'on'; ?>" <?php echo $z["refresh"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>> <?php echo $z["refresh"] == 'on' ? 'ON' : 'OFF'; ?></button>
			<input type="hidden" name="ref" value="ref" />
		</form>
		
		<form action="" method="post" style="display:inline!important;">
			<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
			<input type="hidden" name="id" value="<?php echo $z['id']; ?>" />
			<input type="hidden" name="ow_num" value="<?php echo $z["body"]; ?>" />
			<input type="hidden" name="del" value="delete"/>
		</form>
	</div>
</div>
	
<?php	
	
	
}
}

?>

