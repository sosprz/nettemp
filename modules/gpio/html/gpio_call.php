<?php

$callexit = isset($_POST['callexit']) ? $_POST['callexit'] : '';
if (($callexit == "callexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio' ") or exit(header("Location: html/errors/db_error.php"));
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$savenum = isset($_POST['savenum']) ? $_POST['savenum'] : '';
    if ($savenum == "savenum") {
    shell_exec("sudo /usr/bin/pkill -f call");
    $cmd=("nohup modules/gpio/call_proc");
    shell_exec( $cmd . "> /dev/null 2>/dev/null &" );
    }
?>

<table class="table table-striped">
<tbody>
<th>Name</th><th>Tel</th>
</tbody>
<?php 
    $db = new PDO("sqlite:dbf/nettemp.db");
    $rows = $db->query("SELECT * FROM users where ctr='$gpio'");
    $result = $rows->fetchAll();
    foreach ($result as $a) { ?>
    <tr><td><?php echo $a['login'];?></td> <td><?php echo $a['tel'];?></td></tr>
<?php
    }
?>
<table>




<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="callexit" value="callexit" />
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>

