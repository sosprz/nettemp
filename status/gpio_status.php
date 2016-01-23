<?php 
$root=$_SERVER["DOCUMENT_ROOT"];
$dir="modules/gpio/";
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from gpio where mode='trigger' or mode='simple' or mode='day' or mode='week' or mode='temp' or mode='call' ");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<div class="grid-item gs">
<div class="panel panel-default">
            <div class="panel-heading">GPIO</div>
<table class="table table-hover table-condensed">
<?php
foreach ( $result as $a) {
$gpio=$a['gpio'];
?>
<tr <?php echo $a['status'] == 'ALARM' ? 'class="danger"' : '' ?>>
    <td colspan=3>
		<?php 
		    if (strpos($a['status'],'ON') !== false) { 
			echo '<span class="label label-success">';
		    } else {
			echo '<span class="label label-danger">';
		    }
		    ?>
		    <img type="image" src="media/ico/SMD-64-pin-icon_24.png" />
		    <?php echo $a['name']." ".$a['status']; ?>
		    
		</span>
    </td>
</tr>

<?php
if (($a['mode']=='day') || ($a['mode']=='temp') && ($a['day_run']=='on')) {
?>
<?php
//$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from day_plan where gpio='$gpio'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $dp) { 
?>
<tr>
    <td>
	<span class="label label-info">
	    <?php echo $dp["name"];?>
	</span>
    </td>
    <td>
    <span class="label label-default">
    <?php echo $dp["Mon"];?>
    <?php echo $dp["Tue"];?>
    <?php echo $dp["Wed"];?>
    <?php echo $dp["Thu"];?>
    <?php echo $dp["Fri"];?>
    <?php echo $dp["Sat"];?>
    <?php echo $dp["Sun"];?>
    </span>
    </td>
    <td>
    <span class="label label-warning">
    <?php echo $dp["stime"];?>
    <?php echo $dp["etime"];?>
    </span>
    </td>
</tr>
<?php 
    }
?>

<?php
foreach (range(1, $a['fnum']) as $v) {
    if (!empty($a['temp_temp'.$v])) {
    ?>
    <tr>
	<?php 
	$max=$a['temp_temp'.$v] + $a['temp_hyst'.$v]; ?>
	<td>
	<span class="label label-info"><?php echo $v ?></span>
	</td>
	<td>
	<span class="label label-default"><?php echo "Start: ".$a['temp_temp'.$v]; ?></span>
	<span class="label label-default"><?php echo "Stop: ".$max; ?></span>
	</td>
	<td>
	<span class="label label-warning"><?php echo $a['temp_onoff'.$v]; ?></span>
	<span class="label label-info"><?php echo $a['temp_week_plan'.$v]; ?></span>
	</td>
    </tr>
    <?php
    unset($max); 
    } //if

    if ( (!empty($a['temp_sensor_diff'.$v])) && (empty($a['temp_hyst'.$v])) )  {
    ?>
    <tr>
	<td>
	<span class="label label-info"><?php echo $v ?></span>
	</td>
	<td>
	<?php
	$sfg=$a['temp_sensor'.$v];
	$sfg2=$a['temp_sensor_diff'.$v];
	$db = new PDO('sqlite:dbf/nettemp.db');
	
	$sth = $db->prepare("select name,tmp from sensors WHERE id='$sfg'");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $gs) { ?>
	    <span class="label label-default"><?php echo $gs['name']." ".$gs['tmp']?></span>
	<?php
	}
	?>
	<span class="label label-default">
	    <?php 
		if ($a['temp_op'.$v]=='lt') {echo '<'; }
		if ($a['temp_op'.$v]=='gt') {echo '>'; } 
		if ($a['temp_op'.$v]=='ge') {echo '>='; } 
		if ($a['temp_op'.$v]=='le') {echo '<='; } 
	    ?>
	</span>
	<?php
	$sth = $db->prepare("select name,tmp from sensors WHERE id='$sfg2'");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $gs) { ?>
	    <span class="label label-default"><?php echo $gs['name']." ".$gs['tmp']?></span>
	<?php
	}
	?>

	</td>
	<td>
	<span class="label label-warning"><?php echo $a['temp_onoff'.$v]; ?></span>
	<span class="label label-info"><?php echo $a['temp_week_plan'.$v]; ?></span>
	</td>
    </tr>
    <?php
    unset($max); 

    } //if

    if ( (!empty($a['temp_sensor_diff'.$v])) && (!empty($a['temp_hyst'.$v])) )  {
    ?>
    <tr>
	<td>
	<span class="label label-info"><?php echo $v ?></span>
	</td>
	<td>
	<span class="label label-default">
	<?php
	$sfg=$a['temp_sensor'.$v];
	$sfg2=$a['temp_sensor_diff'.$v];
	$db = new PDO('sqlite:dbf/nettemp.db');
	
	$sth = $db->prepare("select * from sensors where id='$sfg'");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $gs) { 
	    echo $gs['name']." ".$gs['tmp']; 
	}
	?></span>
	<span class="label label-default">
	<?php
	$sth = $db->prepare("select * from sensors where id='$sfg2'");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $gs2) { 
	    echo $gs2['name']." ".($gs2['tmp'] + $a['temp_hyst'.$v]);
	}
	?></span>
	</td>
	<td>
	    <span class="label label-warning"><?php echo $a['temp_onoff'.$v]; ?></span>
	    <span class="label label-info"><?php echo $a['temp_week_plan'.$v]; ?></span>
	</td>
    </tr>
    <?php
    unset($max); 

    } //if


}//foreach
?>

<?php
    } //foreach
} //if
?>

</table>
</div>
</div>
<?php 
    } // first foreach
?>
