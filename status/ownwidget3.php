<?php
$root=$_SERVER["DOCUMENT_ROOT"];
if ( 0 != filesize("$root/tmp/ownwidget3.php") )
{ ?>
    <div class="panel panel-default">
	<?php include("$root/tmp/ownwidget3.php"); ?>
    </div>
<?php 
}
?>
