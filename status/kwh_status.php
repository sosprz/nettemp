<?php 
    $kwh = "";
    $root=$_SERVER["DOCUMENT_ROOT"];

    $db = new PDO("sqlite:$root/dbf/nettemp.db");
    $sth = $db->prepare("select * from gpio where mode='kwh'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
    $kwh=$a["kwh_run"];
    }
    ?>

<?php if ( $kwh == 'on' ) { ?>
<div class="grid-item">
    <div class="panel panel-default">
	<div class="panel-heading"><h3 class="panel-title">kWh status</h3></div>
	    <div class="panel-body">
<pre>
<?php $command='$root/modules/kwh/kwh_status'; passthru($command);  ?>
</pre>
	    </div>
    </div>
</div>
<?php } 
?>
 