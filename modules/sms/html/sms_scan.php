<?php
include('conf.php');

        if ($_POST['scan'] == "Scan"){
         exec("sh $global_dir/modules/sms/sms_scan");   
         header("location: " . $_SERVER['REQUEST_URI']);
         exit();
         } 
         

?>
<table><tr>
<td>Search modem</td>
<form action="sms" method="post">
<td><input type="submit" name="scan" value="Scan" /></td>
</form>
</tr></table>

<?php
    $sd = $_POST["sd"];
    
   if ($_POST['sd1'] == "sd2") {
   	$db = new PDO('sqlite:dbf/nettemp.db');
   	$db->exec("UPDATE sms_settings SET default_dev='off'") or die ($db->lastErrorMsg());
   	$db->exec("UPDATE sms_settings SET default_dev='on' WHERE id='$sd'") or die ($db->lastErrorMsg());
   	$sth = $db->prepare("SELECT * FROM sms_settings WHERE id='$sd'");
   	$sth->execute();
   	$result = $sth->fetchAll();
			foreach ($result as $sdd) {
				$ssd1=$sdd['dev'];
				$fh = fopen('tmp/gammurc', 'w'); 
				fwrite($fh, "[gammu]\n"); 
				fwrite($fh, "port=$ssd1\n");
				fwrite($fh, "connection=at\n");
				fclose ($fh);
			}
   exec("gammu -c tmp/gammurc identify > tmp/gammu_identify");
	header("location: " . $_SERVER['REQUEST_URI']);
   exit();
     } 
?> 



<?php 
    $dd = $_POST["dd"];
    if (!empty($dd) && ($_POST['dd1'] == "dd2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("DELETE FROM sms_settings WHERE id='$dd'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>




<table>

<tr><td>
<form action="sms" method="post"> 
<select name="sd"  onchange="this.form.submit()" >
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from sms_settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
?>
<option <?php echo $a['default_dev'] == 'on' ? 'selected="selected"' : ''; ?> value="<?php echo $a['id']; ?>"> Device <?php echo $a["name"]; ?> <?php echo $a["dev"]; ?> </option>

<?php } ?>
</select>
<input type="hidden" name="sd1" value="sd2" />
</td>
</form>
<tr><td><pre><?php include('tmp/gammu_identify'); ?></pre></td></tr>
</tr>

</table>