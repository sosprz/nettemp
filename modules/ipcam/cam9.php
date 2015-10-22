<?php 

$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM camera where id='9'");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { return; }
foreach ($row as $a) {
$name=$a['name'];
$link=$a['link'];
}
?>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><?php echo $name; ?></h3>
</div>
<div class="panel-body">

<?php 
if($accesstime == 'yes' && $_SESSION['accesscam'] == 'yes' ){

if (strpos($link,'http') !== false) { ?>

    <img width="300" height="300" src="<?php echo $link;?>">

<?php
} else { 
?>

<embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" autoplay="yes" loop="no" width="300" height="300" target="<?php echo $link;?>" />
<object classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab" style="display:none;"></object>


<?php
}
} else { ?> 
<span class="label label-warning">No access</span>
<?php
}
?>




</div>
</div>

