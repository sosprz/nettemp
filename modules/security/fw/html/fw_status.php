<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">FW status</h3>
</div>
<div class="panel-body">
IP
<pre>
<?php passthru('sudo iptables -L -n'); ?>
</pre>
NAT
<pre>
<?php passthru('sudo iptables -L -n -t nat'); ?>
</pre>
</div>
</div>
