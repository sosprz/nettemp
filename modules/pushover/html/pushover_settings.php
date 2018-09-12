<?php

	$po_onoff = isset($_POST['po_onoff']) ? $_POST['po_onoff'] : '';
    $po_onoff1 = isset($_POST['po_onoff1']) ? $_POST['po_onoff1'] : '';
    if (($po_onoff1 == "po_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$po_onoff' WHERE option='pusho_active'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	
	$pouserkey = isset($_POST['pouserkey']) ? $_POST['pouserkey'] : '';
    $poapikey = isset($_POST['poapikey']) ? $_POST['poapikey'] : '';
	$posave = isset($_POST['posave']) ? $_POST['posave'] : '';
	
    if (($posave == "posave") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$pouserkey' WHERE option='pusho_user_key'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE nt_settings SET value='$poapikey' WHERE option='pusho_api_key'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?>

<div class="grid-item">
		<div class="panel panel-default">
			<div class="panel-heading">Pushover (Android / iOs)</div>
			
		<div class="table-responsive">
		<table class="table table-hover table-condensed">
			<tbody>	
	   
			<tr>
				<td><label>Active:</label></td>
				<td>
					<form action="" method="post" style="display:inline!important;">
						<input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="po_onoff" value="on" <?php echo $nts_pusho_active == 'on' ? 'checked="checked"' : ''; ?>  />
						<input type="hidden" name="po_onoff1" value="po_onoff2" />
					</form>
				</td>
			</tr>
				<form action="" method="post">	
			<tr>
				<td><label>User KEY:</label></td>
				<td>
					<input name="pouserkey" class="form-control input-md"  type="text" value="<?php echo $nts_pusho_user_key; ?>">
				</td>
			</tr>
			
			<tr>
				<td><label>API KEY:</label></td>
				<td>
					<input name="poapikey"  class="form-control input-md"  type="text" value="<?php echo $nts_pusho_api_key; ?>">
				</td>
			</tr>
			
			
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="posave" value="posave" />
					<button class="btn btn-xs btn-success"><span>Save</span> </button>
				</form>
				<form action="" method="post" style="display:inline!important;">
					<input type="hidden" name="potest" value="potest" />
					<button class="btn btn-xs btn-success"><span>Test</span> </button>
				</form>
					<?php
					$potest = isset($_POST['potest']) ? $_POST['potest'] : '';
					
					if (($potest == "potest") ){
						
						curl_setopt_array($ch = curl_init(), array(
						  CURLOPT_URL => "https://api.pushover.net/1/messages.json",
						  CURLOPT_POSTFIELDS => array(
							"token" => "$nts_pusho_api_key",
							"user" => "$nts_pusho_user_key",
							"message" => "Test message from nettemp",
							"priority" => "1",
						  ),
						  CURLOPT_SAFE_UPLOAD => true,
						  CURLOPT_RETURNTRANSFER => true,
						));
						curl_exec($ch);
						curl_close($ch);	
					}
					?>
				</td>
			</tr>

			</tbody>
		</table>
		</div>
		</div>
	</div>