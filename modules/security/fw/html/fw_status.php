<div class="panel panel-primary">
<div class="panel-heading">FW status</div>
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
