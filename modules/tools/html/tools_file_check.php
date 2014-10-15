<span class="belka">&nbsp File diagnostic<span class="okno">
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

// czy bazy sa do zapisu
foreach(glob("db/*") as $db) {
if (!is_writable($db)) { echo "<font color=\"#FF0000\">File $db not writable </font><br />"; } 
}

// czy bazy sa do zapisu
foreach(glob("dbf/*") as $db) {
if (!is_writable($db)) { echo "<font color=\"#FF0000\">File $db not writable </font><br />"; } 
}

// tmp
foreach (glob("tmp/*") as $tmp) {
if (!is_writable($tmp)) { echo "<font color=\"#FF0000\">File $tmp not writable </font><br />"; }
}

passthru('modules/tools/check_sudoers');

include('tools_perms.php');

?>
</span></span>


