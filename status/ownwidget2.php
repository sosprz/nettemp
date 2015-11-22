<div id="own_widget2">
<?php
$root=$_SERVER["DOCUMENT_ROOT"];
if ( 0 != filesize("$root/tmp/ownwidget2.php") )
{ ?>
<div class="grid-item">
    <div class="panel panel-default">
	<?php include("$root/tmp/ownwidget2.php"); ?>
    </div>
</div>

<?php 
}
?>
</div>