<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>
<div class="panel panel-default">
<div class="panel-heading"><label>Groups Configuration</label></div>

<?php
function checkdata($data) {
    preg_match('/^[a-z0-9_ \-\.]+$/i',$data) ? : $data='';
    return $data;
}

foreach (array('add','del','name','group', 'charts', 'active', 'activeonoff', 'activeon', 'swap', 'name_del') as $v){
    ${$v} = isset($_POST[$v]) ? checkdata($_POST[$v]) : '';
}
$edit = isset($_GET['edit']) ? checkdata($_GET['edit']) : '';

//DB Connect
try {
    $db = new PDO("sqlite:".$root."/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n".$e;
    exit;
}

//error message def
$err='<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>Something went terribly wrong:</button>';

//add group
if ( $add == "add" && !empty($name) )
{
   $db->exec("INSERT OR REPLACE INTO lcd_groups (name,active,charts) VALUES ('$name','$active','$charts')") or die ($err."<pre>".print_r($db->errorInfo(), true)."</pre>");
   header("location: " . $_SERVER['REQUEST_URI']);
   exit();
}
//del group
if ( $del == "del" && !empty($name_del) )
{
   $db->exec("DELETE FROM lcd_group_assign WHERE grpkey IN (SELECT grpkey FROM lcd_groups WHERE name='$name_del')");
   $db->exec("DELETE FROM lcd_groups WHERE name='$name_del'");
   header("location: " . $_SERVER['REQUEST_URI']);
   exit();
}
//group settings swap onoff?
if ($activeonoff == "onoff" && !empty($swap) && !empty($active)){
    if($swap == 'active'){
	$db->exec("UPDATE lcd_groups SET active='$activeon' WHERE id='$active'") or die (print_r($db->errorInfo(), true));
    }elseif($swap == 'charts'){
	$db->exec("UPDATE lcd_groups SET charts='$activeon' WHERE id='$active'") or die (print_r($db->errorInfo(), true));
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
//Change sensor to group assignment
if (!empty($edit) && !empty($active) && $activeonoff == "onoff"){
    if( $activeon == 'on' ){
	$db->exec("INSERT OR REPLACE INTO lcd_group_assign (rom, grpkey) VALUES ('$active', '$edit')") or die (print_r($db->errorInfo(), true));
    }else{
	$db->exec("DELETE FROM lcd_group_assign WHERE grpkey='$edit' AND rom='$active'") or die (print_r($db->errorInfo(), true));
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<?php /* add table */ ?>
<div class="table-responsive">
<table class="table table-hover table-condensed small">
<thead><tr><th>Name</th><th>Active</th><?php /*<th>Charts</th>*/ ?><th>Key</th><th></th></tr></thead>
<tbody>
    <tr>
    <form action="" method="post">
       <td class="col-md-2"><input type="text" name="name" size="20" value="" class="form-control input-sm" required=""/></td>
       <td class="col-md-1"><select name="active" class="form-control input-sm"><option value="off">off</option><option value="on" selected>on</option></td>
<?php /*       <td class="col-md-1"><select name="charts" class="form-control input-sm"><option value="off" selected>off</option><option value="on">on</option></td> */ ?>
       <td class="col-md-1"><input type="text" name="grpkey" size="2" value="" class="form-control input-sm" disabled/></td>
       <input type="hidden" name="add" value="add" />
       <td class="col-md-4"><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></td>
    </form>
    </tr>

<?php
//List groups
$sth = $db->prepare("SELECT * FROM lcd_groups");
$sth->execute();
$groups = $sth->fetchAll();
foreach ($groups as $group) {
?>
<tr>
   <td class="col-md-2">
       <?php echo $group["name"];?>
   </td>
   <td class="col-md-1">
      <form action="" method="post" style="display:inline!important;">
      <input type="hidden" name="active" value="<?php echo $group['id']; ?>" />
      <input type="hidden" name="swap" value="active" />
      <button type="submit" name="activeon" value="<?php echo $group["active"] == 'on' ? 'off' : 'on'; ?>" <?php echo $group["active"] == 'on' ? 'class="btn btn-sm btn-primary"' : 'class="btn btn-sm btn-default"'; ?>><?php echo $group["active"] == 'on' ? 'ON' : 'OFF'; ?></button></td>
      <input type="hidden" name="activeonoff" value="onoff" />
      </form>
   </td>
<?php
/*
//for further use
   <td class="col-md-1">
      <form action="" method="post" style="display:inline!important;">
      <input type="hidden" name="active" value="<?php echo $group['id']; ?>" />
      <input type="hidden" name="swap" value="charts" />
      <input type="checkbox" data-toggle="toggle" data-size="mini"  name="activeon" value="on" <?php echo $group["charts"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
      <input type="hidden" name="activeonoff" value="onoff" />
      </form>
   </td>
*/
?>
   <td class="col-md-1">
       <?php echo $group["grpkey"];?>
   </td>
   <td class="col-md-4">
      <form action="" method="post">
      <input type="hidden" name="name_del" value="<?php echo $group["name"]; ?>" />
      <input type="hidden" type="submit" name="del" value="del" />
      <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
      </form>
   </td>
</tr>
<?php } ?>

</tbody>
</table>
</div>
</div>

<?php
if( count($groups) > 0 ){
?>
    <div class="panel panel-default">
    <div class="panel-heading"><label>Group List</label></div>
    <div class="panel-body">
    <p>
    <?php
    $name = '';
    $grpkeys = '';
    foreach($groups as $group){ ?>
	<a href="index.php?id=device&type=lcd&lcd=groups&edit=<?php echo $group['grpkey'];?>" ><button class="btn btn-xs btn-success <?php echo $edit == $group['grpkey'] ? 'active' : ''; ?>"><?php echo $group['name'];?></button></a>
	<?php $name = $group['grpkey'] == $edit ? $group['name'] : $name; ?>
	<?php $grpkeys .= ' '.$group['grpkey']; ?>
    <?php
    }
    ?>
    </p>
    </div>
    </div>

<?php
//group editing table
    if(!empty($edit) && strpos($grpkeys,$edit)){
	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading"><label>Group <b>"'.$name.'"</b> - edit</label></div>';
	$sth = $db->prepare("select rom,grpkey from lcd_group_assign WHERE grpkey = '$edit'") or die ($err."<pre>".print_r($db->errorInfo(), true)."</pre>");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $n) {
	    $active[$n['rom']]=$n['grpkey'];
	}
?>
	<div class="table-responsive">
	<table class="table table-hover table-condensed small">
	<thead><tr><th>Position</th><th>Name</th><th>Rom</th><th>Active</th></tr></thead>
	<tbody>
<?php
	$sth = $db->prepare("select position,name,rom,lcd from sensors ORDER BY position ASC") or die ($err."<pre>".print_r($db->errorInfo(), true)."</pre>");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $a) { ?>
	    <tr>
	   <td class="col-md-1"><input type="text" name="position" size="20" value="<?php echo $a['position'] ?>" class="form-control input-sm" disabled/></td>
	   <td class="col-md-2"><input type="text" name="name" size="2" value="<?php echo $a['name'] ?>" class="form-control input-sm" disabled/></td>
	   <td class="col-md-2"><input type="text" name="rom" size="2" value="<?php echo $a['rom'] ?>" class="form-control input-sm" disabled/></td>
	   <td class="col-md-1">
	      <form action="" method="post" style="display:inline!important;">
	      <input type="hidden" name="active" value="<?php echo $a["rom"]; ?>" />
	      <button type="submit" name="activeon" value="<?php echo !empty($active[$a['rom']]) ? 'off' : 'on'; ?>" <?php echo !empty($active[$a['rom']]) ? 'class="btn btn-sm btn-primary"' : 'class="btn btn-sm btn-default"'; ?>><?php echo !empty($active[$a['rom']]) ? 'ON' : 'OFF'; ?></button></td>
	      <input type="hidden" name="activeonoff" value="onoff" />
	      </form>
	   </td>
	   </tr>
<?php
	}
?>
	</tbody>
	</table>
	</div>
<?php //group editing table footer
?>
	<div class="panel-footer">
<?php
	$sth = $db->prepare("select server_key from settings WHERE id='1'");
	$sth->execute();
	$result = $sth->fetch();
	$skey=$result['server_key'];
?>
	<span id="helpBlock" class="help-block">Server key is: <b><?php echo $skey ?></b></span>
	<span id="helpBlock" class="help-block"></span>
	<span id="helpBlock" class="help-block">Group link: <?php echo "http://".$_SERVER['SERVER_NAME']."/lcdfeed.php?key=$skey&group=$edit" ?></span>
	</div>
	</div>
<?php
    } //end if(!empty($edit))
} //end count($groups)
?>
