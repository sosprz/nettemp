<div class="panel panel-default">
<div class="panel-heading">FW status</div>
<div class="panel-body">
IP
<pre>
<?php passthru('sudo iptables -L -n --line-numbers'); ?>
</pre>
NAT
<pre>
<?php passthru('sudo iptables -L -n -t nat --line-numbers'); ?>
</pre>
</div>
</div>
