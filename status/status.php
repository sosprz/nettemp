<style type="text/css">

* {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}


/* ---- grid ---- */

.grid {
	<?php if($id=='screen') { ?>
   	width: 800px;
   <?php } ?>
}

/* clearfix */
.grid:after {
  content: '';
  display: block;
  clear: both;
}

/* ---- grid-item ---- */

.grid-item {
    width: 340px;
    float: left;
    border-radius: 5px;
}

</style>

<script src="html/justgage/raphael-2.1.4.min.js"></script>
<script src="html/justgage/justgage.js"></script>

<div class="grid">
    <div class="grid-sizer"></div>
    <?php
		$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { ?>
<div class="grid-item sg<?php echo $ch_g ?>">
<div class="panel panel-default">
<div class="panel-body">
Go to device scan!
<a href="index.php?id=devices&type=scan" class="btn btn-success">GO!</a>
</div>
</div>
<?php
}


    //GROUPS
    $rows = $db->query("SELECT ch_group,type FROM sensors ORDER BY position_group ASC") or header("Location: html/errors/db_error.php");
	$result_ch_g = $rows->fetchAll();
	$unique=array();
	
	foreach($result_ch_g as $uniq) {
		if(!empty($uniq['ch_group'])&&$uniq['ch_group']!='none'&&!in_array($uniq['ch_group'], $unique)) {
			$unique[]=$uniq['ch_group'];
			$ch_g=$uniq['ch_group'];
			include('status/sensor_groups.php');
		}
	}	
	//END GROUPS
	//JG GROUPS
	foreach($result_ch_g as $uniqa) {
		if(!empty($uniqa['ch_group'])&&$uniqa['ch_group']!='none'&&!in_array($uniqa['ch_group'], $uniquea)) {
			$uniquea[]=$uniqa['ch_group'];
			$ch_g=$uniqa['ch_group'];
			include('status/justgage_status.php');
		}
	}	

	//END JG GROUPS
	
    
    include('status/minmax_status.php');
    include('status/gpio_status.php');
    include('status/counters_status.php');
    include('status/relays_status.php');
    include('status/meteo_status.php');
    foreach (range(1, 10) as $v) {
		$ow=$v;
		include('status/ownwidget.php');
    }
    include('status/ipcam_status.php');
    include('status/ups_status.php');
    ?>
</div>

<script type="text/javascript">
    setInterval( function() {

    <?php
		foreach ($unique as $key => $ch_g) { 
	?>
		$('.sg<?php echo $ch_g?>').load("status/sensor_groups.php?ch_g=<?php echo $ch_g?>");
	<?php
		}
	?>
	
	    <?php
		foreach ($uniquea as $key => $ch_g) { 
	?>
		$('#justgage_refresh').load("status/justgage_refresh.php?ch_g=<?php echo $ch_g?>");
	<?php
		}
	?>
	
    $('.co').load("status/counters_status.php");
    $('.gs').load("status/gpio_status.php");
    $('.ms').load("status/meteo_status.php");
    $('.ow2').load("status/ownwidget2.php");
    $('.ow3').load("status/ownwidget3.php");
    $('.mm').load("status/minmax_status.php");
    $('.ups').load("status/ups_status.php");
    $('.rs').load("status/relays_status.php");
}, 60000);

$(document).ready( function() {

  $('.grid').masonry({
    itemSelector: '.grid-item',
    columnWidth: 350
  });
  
});
</script>
<script src="html/masonry/masonry.pkgd.min.js"></script>
<div id="justgage_refresh"></div>

