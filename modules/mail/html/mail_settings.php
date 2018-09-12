<?php
$cfile = '/etc/msmtprc';

$fh = fopen($cfile, 'r');
$theData = fread($fh, filesize($cfile));
$cread = array();
$my_array = explode(PHP_EOL, $theData);
foreach($my_array as $line)
{
    $tmp = explode(" ", $line);
    $cread[$tmp[0]] = $tmp[1];
}
fclose($fh);
$a=$cread;


$db = new PDO('sqlite:dbf/nettemp.db');
$ns_row = $db->query("SELECT value FROM nt_settings WHERE option='mail_topic'") or header("Location: html/errors/db_error.php");
$ns_rows = $ns_row->fetchAll();

foreach ($ns_rows as $v) { 	
	$mail_topic=$v['value'];
}


$address = isset($_POST['address']) ? $_POST['address'] : '';
$user = isset($_POST['user']) ? $_POST['user'] : '';
$host = isset($_POST['host']) ? $_POST['host'] : '';
$port = isset($_POST['port']) ? $_POST['port'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$auth = isset($_POST['auth']) ? $_POST['auth'] : '';
$tls = isset($_POST['tls']) ? $_POST['tls'] : '';
$tlscheck = isset($_POST['tlscheck']) ? $_POST['tlscheck'] : '';
$topic = isset($_POST['topic']) ? $_POST['topic'] : '';



$change_password1 = isset($_POST['change_password1']) ? $_POST['change_password1'] : '';
if  ($change_password1 == "change_password2") {
	if (!file_exists($cfile)) {
		$cmd = "sudo touch $cfile && sudo chown www-data $cfile && sudo chmod 600 $cfile";
		shell_exec($cmd);
	
	}
		$fh = fopen($cfile, 'w');

		if(empty($address)||$address=='default'){
			$address=$user;
		}

$conf = array (
    'defaults' => '', 
    'tls' => "$tls",
    'tls_starttls' => "$tls",
 // 'tls_trust_file' => '/etc/ssl/certs/ca-certificates.crt',
    'tls_certcheck' => "$tlscheck",
    'account' => 'default',
	 'host' => "$host",
	 'port' => "$port",
	 'auth' => "$auth",
	 'user' => "$user",
	 'password' => "$password",
	 'from' => "$address",
	 'logfile' => '/var/log/msmtp.log'
    );
  

		foreach ($conf as $index => $string) {
    		fwrite($fh, $index." ".$string."\n");
		}
		

		$db->exec("UPDATE nt_settings SET value='$topic' WHERE option='mail_topic'") or die ($db->lastErrorMsg());
		
		header("location: " . $_SERVER['REQUEST_URI']);
    	exit();
}
?>

<div class="grid-item">
		<div class="panel panel-default">
			<div class="panel-heading">Email</div>
			
		<div class="table-responsive">
		<table class="table table-hover table-condensed">
			<tbody>	
	   
			<tr>
				<td><label>Active:</label></td>
				<td>
					<form action="" method="post">
						<input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="ms_onoff" value="on" <?php echo $nts_mail_onoff == 'on' ? 'checked="checked"' : ''; ?>  />
						<input type="hidden" name="ms_onoff1" value="ms_onoff2" />
					</form>
				</td>
			</tr>
		<form action="" method="post">	
			<tr>
				<td><label>From:</td>
				<td>
					<input id="user" name="address" placeholder="not required" class="form-control input-md" type="text" value="<?php echo $a['from']; ?>">
				</td>
			</tr>
			
			<tr>
				<td><label>Username:</label></td>
				<td>
					<input id="user" name="user" placeholder="ex. nettemp@nettemp.pl" class="form-control input-md" required="" type="text" value="<?php echo $a['user']; ?>">
				</td>
			</tr>
			
			<tr>
				<td><label>Password:</label></td>
				<td>
					<input id="password" name="password" placeholder="" class="form-control input-md" required="" type="password" value="<?php echo $a['password']; ?>">
				</td>
			</tr>
			
			<tr>
				<td><label>SMTP Server:</label></td>
				<td>
					<input id="host" name="host" placeholder="smtp.gmail.com" class="form-control input-md" required="" type="text" value="<?php echo $a['host']; ?>">
				</td>
			</tr>
			
			<tr>
				<td><label>Port:</label></td>
				<td>
					<input id="port" name="port" placeholder="587" class="form-control input-md" required="" type="text" value="<?php echo $a['port']; ?>">
				</td>
			</tr>
			
			<tr>
				<td><label>Auth:</label></td>
				<td>
					<select id="auth" name="auth" class="form-control">
						<option value="on" <?php echo $a['auth'] == 'on' ? 'selected="selected"' : ''; ?>>on</option>
						<option value="off" <?php echo $a['auth'] == 'off' ? 'selected="selected"' : ''; ?>>off</option>
						<option value="login" <?php echo $a['auth'] == 'login' ? 'selected="selected"' : ''; ?>>login</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><label>TLS:</label></td>
				<td>
					<select id="tls" name="tls" class="form-control">
						<option value="on" <?php echo $a['tls'] == 'on' ? 'selected="selected"' : ''; ?>>on</option>
						<option value="off" <?php echo $a['tls'] == 'off' ? 'selected="selected"' : ''; ?>>off</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><label>TLS Check:</label></td>
				<td>
					<select id="tlscheck" name="tlscheck" class="form-control">
						<option value="on" <?php echo $a['tls_certcheck'] == 'on' ? 'selected="selected"' : ''; ?>>on</option>
						<option value="off" <?php echo $a['tls_certcheck'] == 'off' ? 'selected="selected"' : ''; ?> >off</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><label>Mail topic:</label></td>
				<td>
					<input id="topic" name="topic" placeholder="" class="form-control input-md" required="" type="topic" value="<?php echo $mail_topic ?>">
				</td>
			</tr>
			
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="change_password1" value="change_password2" />
					<button id="mailsave" name="mailsave" class="btn btn-xs btn-success">Save</button>
		</form>
				</td>
			</tr>
			</form>
			
			<?php
			$db = new PDO('sqlite:dbf/nettemp.db');
			$sth = $db->prepare("select value from nt_settings WHERE option='mail_onoff'");
			$sth->execute();
			$result = $sth->fetchAll();
			foreach ($result as $a) {
				$mail=$a["value"];
			}

			if ($mail == "on" ) { 
				
			?>
			
			<tr>
				<td><label>Test email:</label></td>
				<td>
				<form action="" method="post">
					<input id="mail_test" name="test_mail" class="form-control input-md" required="" type="text" value="" placeholder="test@nettemp.pl">
				</td>	
			</tr>
			<tr>
				<td>
					
					
				
				</td>
				<td>
				
				<button id="send" name="send" value="send" class="btn btn-xs btn-success">Test</button>
				
				</form>
				
				<?php
				$test_mail = isset($_POST['test_mail']) ? $_POST['test_mail'] : '';
				$send = isset($_POST['send']) ? $_POST['send'] : '';
				$headers = "From: ".$a['user']."\r\n";

				if  ($send == "send") {
					 $test_mail1=escapeshellarg($test_mail);
					 if ( mail ($test_mail, $mail_topic, 'Working Fine.', $headers ) ) {
				?>
							<span class="label label-success">Test OK</span>
				<?php
					 } else { 
				?>
							<span class="label label-warning">Test fail</span>
				<?php
					 }
				}
				?>
				</td>
			</tr>
			<?php
			}
			?>			
				
			</tbody>
		</table>
		</div>
		</div>
	</div>