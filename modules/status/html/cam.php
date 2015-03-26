<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM camera");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { return; }


    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db1->prepare("select * from camera where id='1'");
    $sth->execute();
    $result = $sth->fetchAll(); ?>
     <?php       
    foreach ($result as $a) { 	?>

<span class="belka">&nbsp Camera<span class="okno">

<embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" autoplay="yes" loop="no" width="320" height="300" target="<?php echo $a['link'] ?>" />
<object classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab" style="display:none;"></object>

</span></span>

<?php
}
?>
