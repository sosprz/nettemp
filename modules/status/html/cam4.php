<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM camera where id='4'");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { return; }
    foreach ($row as $a) { 	?>

<span class="belka">&nbsp Camera <?php echo $a['name'] ?><span class="okno">

<embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" autoplay="yes" loop="no" width="320" height="300" target="<?php echo $a['link'] ?>" />
<object classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab" style="display:none;"></object>

</span></span>

<?php
}
?>
