<?php 

$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM camera where id='8'");
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
<h3 class="panel-title"><?php echo $name ?></h3>
</div>
<div class="panel-body">
<?php //if(!isset($_SESSION['user'])){ echo "Video available after login"; return; }
?>
<embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" autoplay="yes" loop="no" width="300" height="300" target="<?php if($accesstime == 'yes' && $_SESSION['accesscam'] == 'yes' ){ echo $link;} ?>" />
<object classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab" style="display:none;"></object>
</div>
</div>

