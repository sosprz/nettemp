<?php
$simpleexit = isset($_POST['simpleexit']) ? $_POST['simpleexit'] : '';
if (($simpleexit == "simpleexit") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

include('gpio_onoff.php');

$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
   $sth = $db->prepare("select * from gpio where gpio='$gpio'");
   $sth->execute();
   $result = $sth->fetchAll();    
   foreach ($result as $a) { 
        if ( empty($a["simple"])) { 
include('gpio_rev.php');

?>
<form action="" method="post">
    <td><input type="image" name="simpleexit" value="exit" src="media/ico/Close-2-icon.png" title="Back"   onclick="this.form.submit()" /><td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="simpleexit" value="simpleexit" />
</form>

<td>Status: OFF</td>
<form action="" method="post">
    <td><input type="image" src="media/ico/Button-Turn-On-icon.png" title="Simple on/off" onclick="this.form.submit()" /></td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="on" value="on" />
</form>

<?php 
} 
    else 
    {
    ?>
    <td>Status: ON</td>
    <form action="" method="post">
    <td><input type="image" src="media/ico/Button-Turn-Off-icon.png" title="Simple on/off" onclick="this.form.submit()" /></td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="off" value="off" />
    </form>
    <?php 
    } 
}
?>
