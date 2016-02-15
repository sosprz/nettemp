<?php
//$ow=isset($_GET['ow']) ? $_GET['ow'] : '';
$root=$_SERVER["DOCUMENT_ROOT"];
if ( 0 != filesize("$root/tmp/ownwidget".$ow.".php") )
{ ?>
<div class="grid-item">
    <div class="panel panel-default">
	<?php include("$root/tmp/ownwidget".$ow.".php"); ?>
    </div>
</div>
<?php 
} 
?>
