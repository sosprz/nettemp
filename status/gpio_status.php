<?php 
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("SELECT * FROM gpio WHERE position !=0 AND (ip is null OR ip='') AND ( mode='trigger' or mode='simple' or mode='day' or mode='week' or mode='temp' or mode='call' or mode='read') ORDER BY position ASC");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<div class="grid-item gs">
<div class="panel panel-default">
<div class="panel-heading">GPIO</div>
<table class="table table-hover table-condensed small">
<?php
foreach ( $result as $a) {
$gpio=$a['gpio'];

if ($a['mode'] != 'read') {
?>
<tr <?php echo $a['status'] == 'ALARM' ? 'class="danger"' : '' ?>>
    <td colspan="3">
		<a href="index.php?id=view&type=gpio&max=day&single=<?php echo $a['name']?>" title="Last update: <?php echo $a['status']?>"
		<?php 
		    if (strpos($a['status'],'ON') !== false) { 
		?>  
		    class="label label-success"
		<?php
		    } else {
		?>
		    class="label label-danger"
		<?php
		    }
		?>
		>
		    <img src="media/ico/SMD-64-pin-icon_24.png" alt="" />
		<?php
		    echo $a['name']." ".$a['status']; 
		?>
		    </span>
		</a>
    </td>
</tr>

<?php
}

if ($a['mode'] == 'read') {
    include("$root/status/gpio_status_read.php");
}
if ($a['mode'] != 'read') {
    include("$root/status/gpio_status_day_temp.php");
}

    } // first foreach
?>
</table>
</div>
</div>
<?php
} //if
?>
