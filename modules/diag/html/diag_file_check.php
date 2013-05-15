<span class="belka">&nbsp File diagnostic:<span class="okno">


<?php

// czy katalogi istnieja
$katalogw[] = 'db';
$katalogw[] = 'dbf';
$katalogw[] = 'img';
$katalogw[] = 'img/instant';
$katalogw[] = 'img/view1';
$katalogw[] = 'modules';
$katalogw[] = 'media';
$katalogw[] = 'media/ico';
$katalogw[] = 'media/png';

foreach($katalogw as $katalogw) {
if (!file_exists($katalogw)) { echo "<font color=\"#FF0000\">Dir $katalogw not exist</font><br />"; } 
elseif (!is_writable($katalogw)) { echo "<font color=\"#FF0000\">Dir $katalogw not writeble</font><br />"; } 
}


// czy bazy sa do zapisu
$filename1[] = "tmp/.digitemprc";
$filename1[] = "dbf/nettemp.db";

foreach($filename1 as $filename1) {
if (!file_exists($filename1)) { echo "<font color=\"#FF0000\">File $filename1 not exist </font><br />"; } 

}


// img
foreach (glob("img/instant/*") as $filename4) {
if (!is_writable($filename4)) { echo "<font color=\"#FF0000\">File $filename4 not writable </font><br />"; }
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
$pliki_html[] = 'index.php';

foreach($pliki_html as $filename6) {
if (!file_exists($filename6)) { echo "<font color=\"#FF0000\">File $filename6 not exist </font><br />"; } 
elseif (!is_readable($filename6)) { echo "<font color=\"#FF0000\">File $filename6 not readable </font><br />"; }
}

?>
</span></span>


