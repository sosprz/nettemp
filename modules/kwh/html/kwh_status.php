<?php 
    $kwh = "";

    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from gpio where mode='kwh'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
    $kwh=$a["kwh_run"];
    }
    ?>

<?php if ( $kwh == 'on' ) { ?>
<span class="belka">&nbsp kWh status<span class="okno"> 
<pre>
<?php $command='modules/kwh/kwh_status'; passthru($command);  ?>
</pre>
</span></span>
<?php } 
?>
 