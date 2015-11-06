<div id="own_widget1">
<div class="grid-item">
<?php
$root=$_SERVER["DOCUMENT_ROOT"];
if ( 0 != filesize("$root/tmp/ownwidget1.php") )
{ ?>

    <div class="panel panel-default"><div class="panel-heading">Widget</div>
	<div class="panel-body">
	<?php include("$root/tmp/ownwidget1.php"); ?>
	</div>
    </div>


<?php 
} 
//else { echo "problem"; }
?>
</div>
</div>