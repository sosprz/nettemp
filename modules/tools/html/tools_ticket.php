<div class="panel panel-default">
<div class="panel-heading">Send ticket</div>
<div class="panel-body">


<form class="form-horizontal" action="" method="post">
<fieldset>
	
<center><p>You can send debug files and log's from nettemp. I will check and try repair ;)</p></center>


<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">You'r comment</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="textarea" name="comment">Nettemp is geat!</textarea>
  </div>
</div>
<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="send"></label>
  <div class="col-md-4">
    <button id="send" name="send" value="send" class="btn btn-xs btn-success">Send</button>
  </div>
</div>

</fieldset>
</form>

<?php
$comment = isset($_POST['comment']) ? $_POST['comment'] : '';
$send = isset($_POST['send']) ? $_POST['send'] : '';

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	
	$lighttpd = file_get_contents('/var/log/lighttpd/error.log', true);
	$install = file_get_contents('/var/www/nettemp/install_log.txt', true);
    
    $message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
				<html>
				<head>
				<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
				</head>
				<body>
				<h4>User message:</h4>
				</br>
			    '.$comment.'
			    </br>
			    
			    <h4>lighttpd</h4>
			    <pre>
			    '.$lighttpd.'
			    </pre>			    
			    </br>
			    
			    <h4>install log</h4>
			    <pre>
			    '.$install.'
			    </pre>			    
			    </br>
			    
				</body>
				</html>';
    

if  ($send == "send") {
	 //$comment=escapeshellarg($comment);
	 if ( mail ('debug@nettemp.pl','Nettemp debug', $message, $headers ) ) {
?>

    		<center><span class="label label-success">Mail send ok</span></center>
    		<br>
<?php
	 } else { 
?>

			<center><span class="label label-alert">Cannot send mail</span></center>
			<br>

<?php
	 }

}

?>

</div>
</div>
