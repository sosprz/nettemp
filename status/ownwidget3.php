<div id="own_widget3">
<?php
$root=$_SERVER["DOCUMENT_ROOT"];
if ( 0 != filesize("$root/tmp/ownwidget3.php") )
{ ?>
<div class="grid-item">
    <div class="panel panel-default"><div class="panel-heading">Widget</div>
	<div class="panel-body">
	<?php include("$root/tmp/ownwidget3.php"); ?>
	</div>
    </div>
</div>

<?php 
}
?>
</div>