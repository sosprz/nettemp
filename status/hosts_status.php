<?php 
$root=$_SERVER["DOCUMENT_ROOT"];
$dir="modules/gpio/";
$db = new PDO("sqlite:$root/dbf/hosts.db") or die ("cannot open database");
$sth = $db->prepare("select * from hosts");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<div class="panel panel-default">
<div class="panel-heading">Monitoring</div>
<table class="table table-hover">
<?php
foreach ( $result as $a) {
?>
    <tr <?php echo $a['status'] == 'error' ? 'class="danger"' : '' ?>>
	<td >
		<img type="image" src="media/ico/Computer-icon.png" />
		<?php echo str_replace("host_","",$a["name"]); ?>
	</td>
	<td>
		<?php echo $a['status'] == 'error' ? '<span class="label label-danger">' : '<span class="label label-success">' ?>
		    <?php echo $a['last']." ms"; ?>
		</span>
	</td>
    </tr>

<?php
    }
?>
    </table>
</div>
<?php 
    }  
?>
