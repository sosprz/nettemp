<div class="panel panel-default">
<div class="panel-heading">GPIO</div>
<div class="panel-body">
<pre>
<?php
passthru("/usr/local/bin/gpio readall");

?>
</pre>

<?php
$wp = '/usr/local/bin/gpio';
if (file_exists($wp)) {
	exec("$wp -v |grep Type:", $wpout );
	$wpout=$wpout[0];
	echo '<span class="label label-info">'.$wpout.'</span></br>';
}
?>
</div>
</div>