<script type="text/JavaScript">
$('#custom').live('change', function(){
      if ( $(this).is(':checked') ) {
         $('#customi').show();
     } else {
         $('#customi').hide();
     }
 });
</script>
<?php
    $ssh = isset($_POST['ssh']) ? $_POST['ssh'] : '';
    $icmp = isset($_POST['icmp']) ? $_POST['icmp'] : '';
    $http = isset($_POST['http']) ? $_POST['http'] : '';
    $https = isset($_POST['https']) ? $_POST['https'] : '';
    $vpn = isset($_POST['vpn']) ? $_POST['vpn'] : '';
    $radius = isset($_POST['radius']) ? $_POST['vpn'] : '';
    $mysql = isset($_POST['mysql']) ? $_POST['mysql'] : '';
    $custom = isset($_POST['custom']) ? $_POST['custom'] : '';
    
    if(!empty($ssh)) {
		$proto[]=$ssh;   
    }
	 if(!empty($icmp)) {
		$proto[]=$icmp;
    }
    if(!empty($http)) {
		$proto[]=$http;  
    }
    if(!empty($https)) {
		$proto[]=$https;    
    }
    if(!empty($radius)) {
		$proto[]=$radius;   
    }
    if(!empty($mysql)) {
		$proto[]=$mysql;    
    }   
    if(!empty($vpn)) {
		$proto[]=$vpn;    
    }  
     if(!empty($custom)) {
		$proto[]=$custom;    
    } 
    
    print_r($proto);
    
    
    $fw_add = isset($_POST['fw_add']) ? $_POST['fw_add'] : '';
    $ip = isset($_POST['ip']) ? $_POST['ip'] : '';
    if (($fw_add == "fw_add") ){
    	foreach($proto as $proto){
		shell_exec("/bin/bash modules/security/fw/fw add $ip $proto");
		}
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
    }
    
    $rule = isset($_POST['rule']) ? $_POST['rule'] : '';
	 $rm = isset($_POST['rm']) ? $_POST['rm'] : '';
	 if (($rm == "rm") ){
	 	shell_exec("/bin/bash modules/security/fw/fw rm $rule");
	 	header("location: " . $_SERVER['REQUEST_URI']);
		exit();  	
	 }
?>


<div class="panel panel-default">
<div class="panel-heading">Add rules for incoming connections, output is always ACCEPT</div>
<div class="panel-body">

		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-inline">

  		<div class="form-group">
			<label for="ip">Set single IP or network addres:</label>
			<input id="ip" name="ip" type="text" maxlength="20" value="" class="form-control input-sm" required="" placeholder="ex. 0.0.0.0/0 for all"/> 
		</div>
				
		<input  id="checkbox" name="ssh" type="checkbox" value="ssh" data-toggle="toggle" data-size="mini" data-on="SSH" data-off="SSH"/>
		<input name="icmp" type="checkbox" value="icmp" data-toggle="toggle" data-size="mini" data-on="ICMP" data-off="ICMP" />
		<input name="http" type="checkbox" value="http" data-toggle="toggle" data-size="mini" data-on="HTTP" data-off="HTTP" />
		<input name="https" type="checkbox" value="https" data-toggle="toggle" data-size="mini" data-on="HTTPS" data-off="HTTPS" />
		<input name="radius" type="checkbox" value="radius" " data-toggle="toggle" data-size="mini" data-on="RADIUS" data-off="RADIUS"/>
		<input name="vpn" type="checkbox" value="vpn" data-toggle="toggle" data-size="mini" data-on="VPN" data-off="VPN" />
		<input name="mysql" type="checkbox" value="mysql" data-toggle="toggle" data-size="mini" data-on="MYSQL" data-off="MYSQL"/>
		
		<div class="form-group">
			<input id="custom" type="checkbox" value="mysql" data-toggle="toggle" data-size="mini" data-on="Port" data-off="Port"/>
			<input id="customi" name="custom" type="text" maxlength="6" value="" class="form-control input-sm"  placeholder="ex. 8080" style="display:none; width: 80px;"/>
		</div>

		<div class="form-group">
			<input type="hidden" name="fw_add" value="fw_add" />
			<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button>
		</div>
		
		</form>

<br>

<?php		
$cmd="sudo /sbin/iptables -nL NETTEMP --line-numbers";
$res=shell_exec($cmd); 
$arr = explode("\n", $res);

foreach($arr as $line)
if (strpos($line, 'ACCEPT') !== false) {
	$line=str_replace("limit: avg 1/sec burst 5","",$line);
	$line=str_replace("dpt:","",$line);
	$ipl[]=$line;
}
?>
<table class="table table-hover table-condensed small" border="0">
<thead>
<tr>
<th>Num</th>	
<th>IP</th>
<th>Proto</th>
<th>Port</th>
<th></th>
</tr>
</thead>
<?php
foreach($ipl as $ipl){
	$iplp=preg_split('/\s+/', $ipl);
	//print_r($iplp);

?>
<tr>
	<td class="col-md-1">
		<span class="label label-default"><?php echo $iplp[0];?></span>
	</td>
	<td class="col-md-1">
		<span class="label label-default"><?php echo $iplp[4];?></span>
	</td>
	<td class="col-md-1">
		<span class="label label-default"><?php echo $iplp[2];?></span>
	</td>
	<td class="col-md-1">
		<span class="label label-default"><?php echo $iplp[7];?></span>
	</td>
	<td class="col-md-10">
		<form action="" method="post" class="form-horizontal">
	    <input type="hidden" name="rule" value="<?php echo $iplp[0];?>" />
	    <input type="hidden" type="submit" name="rm" value="rm" />
	    <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
		</form>
	</td>
</tr>
	
<?php

}

?>
</table>
		
</div>
</div>


