<?php
$trigzero = isset($_POST['trigzero']) ? $_POST['trigzero'] : '';
$trigone = isset($_POST['trigone']) ? $_POST['trigone'] : '';
$trigrom = isset($_POST['trigrom']) ? $_POST['trigrom'] : '';
$trigupdatez = isset($_POST['trigupdatez']) ? $_POST['trigupdatez'] : '';
$trigupdateo = isset($_POST['trigupdateo']) ? $_POST['trigupdateo'] : '';
$zeroclr = isset($_POST['zeroclr']) ? $_POST['zeroclr'] : '';
$oneclr = isset($_POST['oneclr']) ? $_POST['oneclr'] : '';

    if ( !empty($trigupdatez) && ($trigupdatez == "trigupdatez")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET trigzero='$trigzero' WHERE rom='$trigrom'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE sensors SET trigzeroclr='$zeroclr' WHERE rom='$trigrom'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 
	
	if ( !empty($trigupdateo) && ($trigupdateo == "trigupdateo")){
    $db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET trigone='$trigone' WHERE rom='$trigrom'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE sensors SET trigoneclr='$oneclr' WHERE rom='$trigrom'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 
	
	
$smsrom = isset($_POST['smsrom']) ? $_POST['smsrom'] : '';
$ssms = isset($_POST['ssms']) ? $_POST['ssms'] : '';
$smsonoff = isset($_POST['smsonoff']) ? $_POST['smsonoff'] : '';

	if ( !empty($smsonoff) && ($smsonoff == "smsonoff")){
    $db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET ssms='$ssms' WHERE rom='$smsrom'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 

$mailrom = isset($_POST['mailrom']) ? $_POST['mailrom'] : '';
$smail = isset($_POST['smail']) ? $_POST['smail'] : '';
$mailonoff = isset($_POST['mailonoff']) ? $_POST['mailonoff'] : '';

	if ( !empty($mailonoff) && ($mailonoff == "mailonoff")){
    $db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET smail='$smail' WHERE rom='$mailrom'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 

$scriptrom = isset($_POST['scriptrom']) ? $_POST['scriptrom'] : '';
$script_path = isset($_POST['script_path']) ? $_POST['script_path'] : '';
$scriptp = isset($_POST['scriptp']) ? $_POST['scriptp'] : '';

	if ( !empty($scriptp) && ($scriptp == "scriptp")){
    $db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET script='$script_path' WHERE rom='$scriptrom'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 
	
$scriptrom1 = isset($_POST['scriptrom1']) ? $_POST['scriptrom1'] : '';
$script_path1 = isset($_POST['script_path1']) ? $_POST['script_path1'] : '';
$scriptp1 = isset($_POST['scriptp1']) ? $_POST['scriptp1'] : '';

	if ( !empty($scriptp1) && ($scriptp1 == "scriptp1")){
    $db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET script1='$script_path1' WHERE rom='$scriptrom1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 





$rows_trig = $db->query("SELECT rom, name, trigzero, trigone, trigzeroclr, trigoneclr, ssms, smail, script, script1 FROM sensors WHERE type='trigger' ORDER BY position ASC ");
$rowtr = $rows_trig->fetchAll();
$labels = array('label-default', 'label-primary', 'label-success', 'label-info', 'label-danger');
?>

<div class="panel panel-default">
<div class="panel-heading">Trigger Settings</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small" border="0">
<th>Trigger name</th>
<th>Settings for value = 0</th>
<th>Settings for value = 1</th>
<th>SMS</th>
<th>Mail</th>
<th>Script 0->1</th>
<th>Script 1->0</th>
<?php
foreach($rowtr as $tr) { ?>
<tr>
	<td class="col-md-0"><span class="label label-default"><?php echo str_replace("_", " ", $tr['name']) ?></span>
</td>

<td class="col-md-0">
	<form action="" method="post" class="form-inline" style="display:inline!important;"> 
		<input type="hidden" name="trigrom" value="<?php echo $tr['rom']; ?>" />
		<label>Bind value:</label>
		<input type="text" name="trigzero" size="10" value="<?php echo $tr['trigzero']; ?>" />
		<label>Color:</label>
		<select name="zeroclr" class="form-control input-sm">
		<?php foreach ($labels as $color) { ?>
			<option class="<?php echo $color; ?>" value="<?php echo $color; ?>"<?php echo $tr['trigzeroclr'] == $color ? 'selected="selected"' : ''; ?>><?php echo $color; ?></option>
		<?php } ?>	
		</select>
		<input type="hidden" name="trigupdatez" value="trigupdatez" />
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
	</form>
</td>

<td class="col-md-0">
	<form action="" method="post" class="form-inline" style="display:inline!important;"> 
		<input type="hidden" name="trigrom" value="<?php echo $tr['rom']; ?>" />
		<label>Bind value:</label>
		<input type="text" name="trigone" size="10" value="<?php echo $tr['trigone']; ?>" />
	
		<label>Color:</label>
		<select name="oneclr" class="form-control input-sm">
		<?php foreach ($labels as $color) { ?>
			<option class="<?php echo $color; ?>" value="<?php echo $color; ?>"<?php echo $tr['trigoneclr'] == $color ? 'selected="selected"' : ''; ?>><?php echo $color; ?></option>
		<?php } ?>
		</select>
		<input type="hidden" name="trigupdateo" value="trigupdateo" />
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
	</form>
</td>
<td class="col-md-1">

	<form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="smsrom" value="<?php echo $tr['rom']; ?>" />
		<button type="submit" name="ssms" value="<?php echo $tr["ssms"] == 'on' ? 'off' : 'on'; ?>" <?php echo $tr["ssms"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>><?php echo $tr["ssms"] == 'on' ? 'ON' : 'OFF'; ?></button>
		<input type="hidden" name="smsonoff" value="smsonoff" />
    </form>
</td>
<td class="col-md-1">

	<form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="mailrom" value="<?php echo $tr['rom']; ?>" />
		<button type="submit" name="smail" value="<?php echo $tr["smail"] == 'on' ? 'off' : 'on'; ?>" <?php echo $tr["smail"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>><?php echo $tr["smail"] == 'on' ? 'ON' : 'OFF'; ?></button>
		<input type="hidden" name="mailonoff" value="mailonoff" />
    </form>
</td>

<td class="col-md-1">

	<form action="" method="post" style="display:inline!important;">
		<input type="text" name="script_path" size="10" maxlength="50" value="<?php echo $tr["script"]; ?>" />
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
		<input type="hidden" name="scriptrom" value="<?php echo $tr["rom"]; ?>" />
		<input type="hidden" name="scriptp" value="scriptp"/>
    </form>

</td>
<td class="col-md-1">

	<form action="" method="post" style="display:inline!important;">
		<input type="text" name="script_path1" size="10" maxlength="50" value="<?php echo $tr["script1"]; ?>" />
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
		<input type="hidden" name="scriptrom1" value="<?php echo $tr["rom"]; ?>" />
		<input type="hidden" name="scriptp1" value="scriptp1"/>
    </form>

</td>
<td class="col-md-1">
</td>

</tr>
	
<?php
}
?>

</table>
</div>
</div>
