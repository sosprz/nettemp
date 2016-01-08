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
<div class="grid-item grid-item2 gs">
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
$db = new PDO('sqlite:dbf/nettemp.db');
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
    }
}
?>

</table>
</div>
</div>
<?php 
    }  
?>
