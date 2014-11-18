<?php
$katalogw[] = 'db';
$katalogw[] = 'dbf';
$katalogw[] = 'modules';
$katalogw[] = 'media';
$katalogw[] = 'tmp';

foreach($katalogw as $katalogw) {
    if (!file_exists($katalogw)) { 
	$tofix[]="<font color=\"#FF0000\">Dir $katalogw not exist</font><br />"; 
	$exit=true;
    } 
    elseif (!is_writable($katalogw)) { 
	//echo "<font color=\"#FF0000\">Dir $katalogw not writeble</font><br />"; 
	$exit=true;
    } 
}

foreach(glob("db/*") as $db) {
    if (!is_writable($db)) { 
	$tofix[]="<font color=\"#FF0000\">File $db not writable </font><br />"; 
	$exit=true;
    } 
}

foreach(glob("dbf/*") as $db) {
    if (!is_writable($db)) {
	$tofix[]="<font color=\"#FF0000\">File $db not writable </font><br />"; 
	$exit=true;
    } 
}

foreach (glob("tmp/*") as $tmp) {
if (!is_writable($tmp)) { 
    $tofix[]="<font color=\"#FF0000\">File $tmp not writable </font><br />"; 
    $exit=true;
    }
}

if ($exit == true ) { ?>
    <span class="belka">&nbsp File diagnostic<span class="okno">
    <?php
    foreach ($tofix as $line) {
	echo $line;
    }
    include('modules/tools/html/tools_perms.php');
    ?>
    </span></span>
    <?php
}
elseif ( $id == 'tools' ){ ?>
    <span class="belka">&nbsp File diagnostic<span class="okno">
    <?php
    echo "It's ok";
    ?>
    </span></span>
<?php
    }
?>

