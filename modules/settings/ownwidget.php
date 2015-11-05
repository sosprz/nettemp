<?php
if ( 0 != filesize('tmp/ownwidget1.php') )
{ ?>
<div class="grid-item">
    <div class="panel panel-default"><div class="panel-heading">Widget</div>
	<div class="panel-body">
	<?php include('tmp/ownwidget1.php'); ?>
	</div>
    </div>
</div>

<?php 
}

if ( 0 != filesize('tmp/ownwidget2.php') )
{ ?>
<div class="grid-item">
    <div class="panel panel-default"><div class="panel-heading">Widget</div>
	<div class="panel-body">
	<?php include('tmp/ownwidget2.php'); ?>
	</div>
    </div>
</div>

<?php 
}

if ( 0 != filesize('tmp/ownwidget3.php') )
{ ?>
<div class="grid-item">
    <div class="panel panel-default"><div class="panel-heading">Widget</div>
	<div class="panel-body">
	<?php include('tmp/ownwidget3.php'); ?>
	</div>
    </div>
</div>

<?php 
}
?>
