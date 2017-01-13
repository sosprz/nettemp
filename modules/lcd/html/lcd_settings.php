<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>
<?php

function checkdata($data) {
    preg_match('/^[a-z0-9_ \-\.]+$/i',$data) ? : $data='';
    return $data;
}

foreach (array('lcdmode', 'lcdmodeon', 'lcd', 'lcdon', 'lcd4', 'lcdon4') as $v){
    ${$v} = isset($_POST[$v]) ? checkdata($_POST[$v]) : '';
}

//settings
    if (($lcdmode == 'adv')){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET lcdmode='$lcdmodeon' WHERE id='1'") or die ($db->lastErrorMsg());
    shell_exec("sudo touch tmp/reboot");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    if (($lcd == "lcd") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET lcd='$lcdon' WHERE id='1'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE settings SET lcd4='off' WHERE id='1'") or die ($db->lastErrorMsg());
    shell_exec("sudo touch tmp/reboot");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    if (($lcd4 == "lcd4") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET lcd4='$lcdon4' WHERE id='1'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE settings SET lcd='off' WHERE id='1'") or die ($db->lastErrorMsg());
    shell_exec("sudo touch tmp/reboot");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

//DB Connect
try {
    $db = new PDO("sqlite:".$root."/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n".$e;
    exit;
}

$sth = $db->prepare("select * from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
    $lcd=$a["lcd"];
    $lcd4=$a["lcd4"];
    $lcdmode=$a["lcdmode"];
}
?>
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">
    <form action="" method="post">
    <label>LCD Configuration</label>
    <input data-toggle="toggle" data-on="Advanced" data-off="Basic" data-onstyle="primary" data-offstyle="success" data-size="mini" onchange="this.form.submit()" type="checkbox" name="lcdmodeon" value=<?php echo $lcdmode == 'adv' ? '"" checked="checked"' : '"adv"'; ?> /></td>
    <input type="hidden" name="lcdmode" value="adv" />
    </form>
</h3>
</div>
<div class="panel-body">
<?php
if ( $lcdmode == 'adv' ){
//advanced mode
//    adv($db,$root);
    foreach (array('add','del','name','addr', 'rows', 'cols', 'clock', 'avg', 'active', 'group', 'activeonoff', 'activeon') as $v){
        ${$v} = isset($_POST[$v]) ? $_POST[$v] : '';
    }

    if ( $add == 'add' && !empty($name) && !empty($addr) ){
//add
        $db->exec("INSERT OR REPLACE INTO lcds (name, addr, rows, cols, clock, avg, active, grp) VALUES ('$name', '$addr', '$rows', '$cols', '$clock', '$avg', '$active', '$group')");
        exec("sudo touch ".$root."/tmp/reboot");
        header("location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
    if ( $del == 'del' && !empty($name) && !empty($addr) ){
//del
        $db->exec("DELETE FROM lcds WHERE name = '$name' AND addr = '$addr'");
        exec("sudo touch ".$root."/tmp/reboot");
        header("location: " . $_SERVER['REQUEST_URI']);
    }
    if ( $activeonoff == 'onoff' && !empty($active) ){
//swap active on <-> off
        $db->exec("UPDATE lcds SET active='$activeon' WHERE id='$active'");
        exec("sudo touch ".$root."/tmp/reboot");
        header("location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
?>

<?php /* input form */ ?>
<?php
//group list
//prepare group list
    $sth = $db->prepare("SELECT name,grpkey FROM lcd_groups WHERE active = 'on'");
    $sth->execute();
    $result = $sth->fetchAll();
    $group_option='<option selected value="">none</option>';
    foreach ($result as $a) {
        $group_option .= '<option value="'.$a['name'].'">'.$a['name'].'</option>';
    }
?>
    <div class="table-responsive">
    <table class="table table-hover table-condensed small">
    <thead><tr><th>Name</th><th>Addr</th><th>Rows</th><th>Cols</th><th>Permament Clock</th><th>Average Values</th><th>Display Group</th><th>Active</th><th></th></tr></thead>
    <tbody>
        <tr>
        <form action="" method="post">
           <td class="col-md-2"><input type="text" name="name" size="20" pattern="[A-Za-z0-9 _-]+" class="form-control input-sm" required=""/></td>
           <td class="col-md-1"><input type="text" name="addr" size="2" pattern="0x[A-Fa-f0-9]{2}" value="0x27" class="form-control input-sm" required=""/></td>
           <td class="col-md-1"><input type="text" name="rows" size="2" pattern="[0-9]{1,2}" value="2" class="form-control input-sm" required=""/></td>
           <td class="col-md-1"><input type="text" name="cols" size="2" pattern="[0-9]{1,2}" value="16" class="form-control input-sm" required=""/></td>
           <td class="col-md-1"><select name="clock" class="form-control input-sm"><option selected value="off">off</option><option value="on">on</option></td>
           <td class="col-md-1"><select name="avg" class="form-control input-sm"><option selected value="off">off</option><option value="on">on</option></td>
           <td class="col-md-1"><select name="group" class="form-control input-sm"><?php echo $group_option; ?></td>
           <td class="col-md-1"><select name="active" class="form-control input-sm"><option selected value="off">off</option><option value="on">on</option></td>
           <input type="hidden" name="add" value="add" />
           <td class="col-md-1"></td>
           <td class="col-md-4"><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></td>
        </form>
        </tr>

<?php
/* lcd list */
    $sth = $db->prepare("select * from lcds");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
?>
    <tr>
       <td class="col-md-2">
           <img type="image" src="media/ico/Devices-video-television-icon.png" />
           <?php echo $a["name"];?>
       </td>
       <td class="col-md-1">
           <?php echo $a["addr"];?>
       </td>
       <td class="col-md-1">
           <?php echo $a["rows"];?>
       </td>
       <td class="col-md-1">
           <?php echo $a["cols"];?>
       </td>
       <td class="col-md-1">
           <?php echo $a["clock"];?>
       </td>
       <td class="col-md-1">
           <?php echo $a["avg"];?>
       </td>
       <td class="col-md-1">
           <?php echo $a["grp"];?>
       </td>
       <td class="col-md-1">
          <form action="" method="post" style="display:inline!important;">
          <input type="hidden" name="active" value="<?php echo $a['id']; ?>" />
          <input type="checkbox" data-toggle="toggle" data-size="mini"  name="activeon" value="on" <?php echo $a["active"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
          <input type="hidden" name="activeonoff" value="onoff" />
          </form>
       </td>
       <td class="col-md-1">
       </td>
       <td class="col-md-4">
          <form action="" method="post">
          <input type="hidden" name="name" value="<?php echo $a['name']; ?>" />
          <input type="hidden" name="addr" value="<?php echo $a['addr']; ?>" />
          <input type="hidden" type="submit" name="del" value="del" />
          <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
          </form>
       </td>
    </tr>
<?php
    } //foreach ($result as $a)
    unset($a);
?>
    </tbody>
    </table>
    </div>
    <div class="panel-body">
    <span id="helpBlock" class="help-block">If You want change LCD settings like name or any other setting  please fill ADD form, but use ADDR of LCD to change</span>
    <span id="helpBlock" class="help-block">Default I<sup>2</sup>C Addres: 0x27</span>
    <span id="helpBlock" class="help-block">Valid values: 0x**</span>
    </div>
    </div>
<?php
}else{	//if ( $lcdmode == 'adv' )
//basic mode
?>
    <form action="" method="post">
    <label>LCD 1602 HD44780 PCF8574 I2C 2x16</label>
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="lcdon" value="on" <?php echo $lcd == 'on' ? 'checked="checked"' : ''; ?> /></td>
    <input type="hidden" name="lcd" value="lcd" />
    </form>
    <form action="" method="post">
    <label>LCD 1602 HD44780 PCF8574 I2C 4x20</label>
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="lcdon4" value="on" <?php echo $lcd4 == 'on' ? 'checked="checked"' : ''; ?> /></td>
    <input type="hidden" name="lcd4" value="lcd4" />
    </form>
<?php
}	//if ( $lcdmode == 'adv' )
?>
</div>
</div>
