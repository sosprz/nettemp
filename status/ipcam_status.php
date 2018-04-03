<?php 


//hide cam in status
	$hidecamid = isset($_POST['hidecamid']) ? $_POST['hidecamid'] : '';
	$hidecam = isset($_POST['hidecam']) ? $_POST['hidecam'] : '';
	$hidecamstate = isset($_POST['hidecamstate']) ? $_POST['hidecamstate'] : '';
	
	if (!empty($hidecamid) && $hidecam == 'hidecam'){
		if ($hidecamstate == 'on') {$hidecamstate = 'off';
		}elseif ($hidecamstate == 'off') {$hidecamstate = 'on';}
		
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE camera SET value='$hidecamstate' WHERE id='$hidecamid'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }


$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM camera");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { return; }
foreach ($row as $a) {
$id=$a['id'];
$name=$a['name'];
$link=$a['link'];
$hide=$a['hide'];
?>
<div class="grid-item">
    <div class="panel panel-default">
	<div class="panel-heading"> 
	<div class="pull-left"><?php echo $name; ?></div>
	<div class="pull-right">
		<div class="text-right">
			<form action="" method="post" style="display:inline!important;">
					<input type="hidden" name="hidecamid" value="<?php echo $id; ?>" />
					<input type="hidden" name="hidecamstate" value="<?php echo $hide; ?>" />
					<input type="hidden" name="hidecam" value="hidecam"/>
					<?php
					if($hide == 'off'){ ?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-top"></span> </button>
					<?php } elseif($hide == 'on'){?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-bottom"></span> </button>
					<?php } ?>
			</form>	
		</div>
	</div>
	<div class="clearfix"></div>
	</div>
	
<?php 
if ($hide == 'off') { ?>
	
	
	
	    <div class="panel-body">

<?php 
if(($accesstime == 'yes' && $_SESSION['accesscam'] == 'yes') || ($_SESSION['user'] == 'admin') || ($a['access_all'] == 'on')){
    if (strpos($link,'http') !== false) { ?>
	<img width="300" height="300" src="<?php echo $link;?>">
    <?php
    } else { 
    ?>
	<embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" autoplay="yes" loop="no" width="300" height="280" target="<?php echo $link;?>" />
	<object classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab" style="display:none;"></object>
    <?php
    }
} else { ?> 
    <span class="label label-warning">No access</span>
<?php
}
?>

	</div>
<?php
}
?>
    </div>
</div>
<?php 
    }
?>
