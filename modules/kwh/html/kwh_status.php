    <?php $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from settings where id='1'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
    $kwh=$a["kwh"];
    }
    ?>


<span class="belka">&nbsp kWh status<span class="okno"> 
<?php if ( $kwh == 'on' ) { ?>
<pre>
<?php $command='modules/kwh/kwh_status'; passthru($command);  ?>
</pre>
<?php } 
else { echo "<span class=\"empty\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }
?>

</span></span>
 