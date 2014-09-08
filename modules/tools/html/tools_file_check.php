<span class="belka">&nbsp File diagnostic<span class="okno">
If empty, files are ok.<br />

<?php

// czy katalogi istnieja
$katalogw[] = 'db';
$katalogw[] = 'dbf';
$katalogw[] = 'modules';
$katalogw[] = 'media';
$katalogw[] = 'tmp';

foreach($katalogw as $katalogw) {
if (!file_exists($katalogw)) { echo "<font color=\"#FF0000\">Dir $katalogw not exist</font><br />"; } 
elseif (!is_writable($katalogw)) { echo "<font color=\"#FF0000\">Dir $katalogw not writeble</font><br />"; } 
}

$files[] = 'conf.php';
foreach($files as $files) {
if (!file_exists($files)) { echo "<font color=\"#FF0000\">File $files not exist</font><br />"; } 
elseif (!is_writable($files)) { echo "<font color=\"#FF0000\">File $files not writeble</font><br />"; } 
}



// czy bazy sa do zapisu
foreach(glob("dbf/*") as $db) {
if (!is_writable($db)) { echo "<font color=\"#FF0000\">File $db not writable </font><br />"; } 
}

// tmp
foreach (glob("tmp/*") as $tmp) {
if (!is_writable($tmp)) { echo "<font color=\"#FF0000\">File $tmp not writable </font><br />"; }
}


//skrypty
#$script[] = 'scripts/mail';
#$script[] = 'scripts/temp';
#$script[] = 'scripts/scan';
#foreach($script as $filename5) {
#if (!file_exists($filename5)) { echo "<font color=\"#FF0000\">File $filename5 not exist </font><br />"; } 
#elseif (!is_readable($filename5)) { echo "<font color=\"#FF0000\">File $filename5 not readable </font><br />"; }
#}

//mczy pliki html sa do odczytu
//$pliki_html[] = 'index.php';

//foreach($pliki_html as $filename6) {
//if (!file_exists($filename6)) { echo "<font color=\"#FF0000\">File $filename6 not exist </font><br />"; } 
//elseif (!is_readable($filename6)) { echo "<font color=\"#FF0000\">File $filename6 not readable </font><br />"; }
//}

include('tools_perms.php');

?>
</span></span>


