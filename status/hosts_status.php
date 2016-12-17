<?php 
$root=$_SERVER["DOCUMENT_ROOT"];
$dir="modules/gpio/"; 
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from sensors WHERE position!=0 AND type='host' AND status!='on' AND (ch_group='' OR ch_group is null) ORDER BY position ASC");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<div class="grid-item hs" >
<div class="panel panel-default">
<div class="panel-heading">Monitoring</div>
<table class="table table-hover condensed small">
<?php
foreach ( $result as $a) {
?>
    <tr>
	<td >
		<img src="media/ico/Computer-icon.png" alt="" />
		<?php echo $a["name"]; ?>
	</td>
	<td>
	    <a href="index.php?id=view&type=host&max=day&single=<?php echo $a['name']?>" title="Last update: <?php echo $a['time']?>"
		    <?php echo $a['tmp'] == 'error' ? '<span class="label label-danger">' : '<span class="label label-success">' ?>
		    <?php echo $a['tmp'] == 'error' ? 'offline' : $a['tmp']." ms"?>
		</span>
	    </a>
	</td>
    </tr>

<?php
    }
?>
    </table>
</div>
</div>
<?php 
    }  
?>
