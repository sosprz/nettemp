<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$sth = $db->query("SELECT * FROM nt_settings");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
	if($a['option']=='gpio') {
		$nts_gpio=$a['value'];
	}
	if($a['option']=='gpio_demo') {
		$nts_gpio_demo=$a['value'];
	}
	if($a['option']=='MCP23017') {
		$nts_MCP23017=$a['value'];
	}
	if($a['option']=='mail_onoff') {
		$nts_mail_onoff=$a['value'];
	}
	if($a['option']=='temp_scale') {
		$nts_temp_scale=$a['value'];
	}
	if($a['option']=='charts_default') {
		$nts_charts_default=$a['value'];
	}
	if($a['option']=='charts_theme') {
		$nts_charts_theme=$a['value'];
	}
	if($a['option']=='charts_meteogram') {
		$nts_charts_meteogram=$a['value'];
	}
	if($a['option']=='charts_min') {
		$nts_charts_min=$a['value'];
	}
	if($a['option']=='charts_max') {
       	$nts_charts_max=$a['value'];
    }
    if($a['option']=='charts_fast') {
       	$nts_charts_fast=$a['value'];
    }
	if($a['option']=='server_key') {
		$nts_server_key=$a['value'];
	}
	if($a['option']=='client_ip') {
		$nts_client_ip=$a['value'];
	}
	if($a['option']=='client_key') {
		$nts_client_key=$a['value'];
	}
	if($a['option']=='client_on') {
		$nts_client_on=$a['value'];
	}
	if($a['option']=='cauth_on') {
		$nts_cauth_on=$a['value'];
	}
	if($a['option']=='cauth_login') {
		$nts_cauth_login=$a['value'];
	}
	if($a['option']=='cauth_pass') {
		$nts_cauth_pass=$a['value'];
	}
    if($a['option']=='info') {
      	$html_info=$a['value'];
    }
    if($a['option']=='footer') {
       	$html_footer=$a['value'];
    }
    if($a['option']=='screen') {
       	$html_screen=$a['value'];
    }
    if($a['option']=='nettemp_alt') {
       	$html_nettemp_alt=$a['value'];
    }
    if($a['option']=='nettemp_logo') {
       	$html_nettemp_logo=$a['value'];
    }
    if($a['option']=='nettemp_link') {
       	$html_nettemp_link=$a['value'];
    }
    if($a['option']=='map_width') {
       	$html_map_width=$a['value'];
    }
    if($a['option']=='map_height') {
       	$html_map_height=$a['value'];
    }
    if($a['option']=='sms') {
       	$nts_sms=$a['value'];
    }
    if($a['option']=='vpn') {
       	$nts_vpn=$a['value'];
    }
    if($a['option']=='fw') {
       	$nts_fw=$a['value'];
    }
    if($a['option']=='authmod') {
       	$nts_authmod=$a['value'];
    }
    if($a['option']=='radius') {
       	$nts_radius=$a['value'];
    }
    if($a['option']=='lcd') {
       	$nts_lcd=$a['value'];
    }
    if($a['option']=='lcd4') {
       	$nts_lcd4=$a['value'];
    }
    if($a['option']=='minmax_mode') {
       	$nts_minmax_mode=$a['value'];
    }
    if($a['option']=='ups_status') {
       	$nts_ups_status=$a['value'];
    }
}


?>
