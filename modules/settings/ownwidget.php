<?php
if ( 0 != filesize('tmp/ownwidget.php') )
{ ?>
<div class="grid-item">
    <div class="panel panel-default"><div class="panel-heading">Widget</div>
	<div class="panel-body">
	<?php include('tmp/ownwidget.php'); ?>
	</div>
    </div>
</div>

<?php 
}
?>
