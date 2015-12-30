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
	<td >
	    <img type="image" src="media/ico/SMD-64-pin-icon_24.png" />
	</td>
	<td >
	    
		<?php echo $a['name']; ?>
	    
	</td>
	<td >
	    
		<?php echo $a['mode']; ?>
	    
	</td>
	<td >
	    
		<?php 
		    if (strpos($a['status'],'ON') !== false) { 
			echo '<span class="label label-success">';
		    } else {
			echo '<span class="label label-danger">';
		    }
		    ?>
		    <?php echo $a['status']; ?>
		</span>
	    
	</td>
    </tr>
<?php
}

?>
</table>
</div>
</div>
<?php }  ?>
