<?php
$exit = "";
$katalogw[] = 'db';
$katalogw[] = 'dbf';
$katalogw[] = 'modules';
$katalogw[] = 'media';
$katalogw[] = 'tmp';

foreach($katalogw as $katalogw) {
    if (!file_exists($katalogw)) { 
	$tofix[]="Dir $katalogw not exist<br />"; 
	$exit=true;
    } 
    elseif (!is_writable($katalogw)) { 
	//echo "Dir $katalogw not writeble<br />"; 
	$exit=true;
    } 
}

foreach(glob("db/*") as $db) {
    if (!is_writable($db)) { 
	$tofix[]="File $db not writable"; 
	$exit=true;
    } 
}

foreach(glob("dbf/*") as $db) {
    if (!is_writable($db)) {
	$tofix[]="File $db not writable"; 
	$exit=true;
    } 
}

foreach (glob("tmp/*") as $tmp) {
if (!is_writable($tmp)) { 
    $tofix[]="File $tmp not writable"; 
    $exit=true;
    }
}

if ($exit == true ) { ?>
<div class="grid-item">
<div class="alert alert-danger" role="alert">

    <?php
    foreach ($tofix as $line) {
	echo $line . "<br>";
    }
    //include('modules/tools/html/tools_perms.php');
    ?>
</div>
</div>

    <?php
}
//elseif ( $id == 'tools' ){ ?>
<?php
    //include('modules/tools/html/tools_perms.php');
?>
<?php
//    }
?>

