<?php
$ip = isset($_POST['ip']) ? $_POST['ip'] : '';
$relay = isset($_POST['relay']) ? $_POST['relay'] : '';
$ronoff = isset($_POST['ronoff']) ? $_POST['ronoff'] : '';
if (($ronoff == "ronoff")){
    if ($relay == 'on' ){
    $cmd="curl $ip/on";
    exec($cmd);
    } else { 
    $cmd="curl $ip/off";
    exec($cmd);
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$db = new PDO('sqlite:dbf/nettemp.db');
$sth2 = $db->prepare("select * from relays");
$sth2->execute();
$result2 = $sth2->fetchAll();
foreach ( $result2 as $a) {
$ip=$a['ip'];

$cmd="curl $ip/status";
exec($cmd, $i);
$s=$i[0];
$o=str_replace('status', '', $s);
if ( $o == '1') { $rs='on'; }
if ( $o == '0') { $rs='off'; }
?>


<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><?php echo $a['name']; ?></h3>
</div>
<div class="panel-body">
    <form action="" method="post">
    <input type="checkbox"  data-toggle="toggle"  onchange="this.form.submit()" name="relay" value="<?php echo $rs == on  ? 'off' : 'on'; ?>" <?php echo $rs == 'on' ? 'checked="checked"' : ''; ?>  />
    <input type="hidden" name="ip" value="<?php echo $a['ip']; ?>"/>
    <input type="hidden" name="ronoff" value="ronoff" />
</form>
</div></div>
<?php 
}
?>
