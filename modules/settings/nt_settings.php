<?php
if(!empty($_SERVER["DOCUMENT_ROOT"])){
    $root=$_SERVER["DOCUMENT_ROOT"];
}else{
    $root=__DIR__;
    for($i=0;$i<5;$i++){
        $root = file_exists($root.'/dbf/nettemp.db') ? $root : dirname($root) ;
    }
}
if(!isset($db)){
    $db = new PDO("sqlite:$root/dbf/nettemp.db");
}
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
      	$nts_info=$a['value'];
    }
    if($a['option']=='footer') {
       	$nts_footer=$a['value'];
    }
    if($a['option']=='nettemp_alt') {
       	$nts_nettemp_alt=$a['value'];
    }
    if($a['option']=='nettemp_logo') {
       	$nts_nettemp_logo=$a['value'];
    }
    if($a['option']=='nettemp_link') {
       	$nts_nettemp_link=$a['value'];
    }
    if($a['option']=='map_width') {
       	$nts_map_width=$a['value'];
    }
    if($a['option']=='map_height') {
       	$nts_map_height=$a['value'];
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
    if($a['option']=='screen') {
       	$nts_screen=$a['value'];
    }
	if($a['option']=='ups_delay_on') {
       	$nts_ups_delay_on=$a['value'];
    }
	if($a['option']=='ups_delay_off') {
       	$nts_ups_delay_off=$a['value'];
    }
	if($a['option']=='ups_language') {
       	$nts_ups_language=$a['value'];
    }
	if($a['option']=='ups_akku_discharged') {
       	$nts_ups_akku_discharged=$a['value'];
    }
	if($a['option']=='ups_lcd_scroll') {
       	$nts_ups_lcd_scroll=$a['value'];
    }
	if($a['option']=='ups_lcd_backlight') {
       	$nts_ups_lcd_backlight=$a['value'];
    }
	if($a['option']=='ups_time_off') {
       	$nts_ups_time_off=$a['value'];
    }
	if($a['option']=='ups_akku_temp') {
       	$nts_ups_akku_temp=$a['value'];
    }
	if($a['option']=='ups_toff_start') {
       	$nts_ups_toff_start=$a['value'];
    }
	if($a['option']=='ups_count') {
       	$nts_ups_count=$a['value'];
    }
	if($a['option']=='ups_toff_stop') {
       	$nts_ups_toff_start=$a['value'];
    }
	if($a['option']=='hide_gpio') {
       	$nts_hide_gpio=$a['value'];
    }
	if($a['option']=='hide_minmax') {
       	$nts_hide_minmax=$a['value'];
    }
	if($a['option']=='hide_counters') {
       	$nts_hide_counters=$a['value'];
    }
	if($a['option']=='hide_ups') {
       	$nts_hide_ups=$a['value'];
    }
	if($a['option']=='ups_backl_time') {
       	$nts_ups_backl_time=$a['value'];
    }
	if($a['option']=='client_port') {
       	$nts_client_port=$a['value'];
    }
	if($a['option']=='mapon') {
       	$nts_mapon=$a['value'];
    }
	if($a['option']=='pusho_active') {
       	$nts_pusho_active=$a['value'];
    }
	if($a['option']=='pusho_user_key') {
       	$nts_pusho_user_key=$a['value'];
    }
	if($a['option']=='pusho_api_key') {
       	$nts_pusho_api_key=$a['value'];
    }
	
}

//different way..
foreach ($result as $a) {
    $NT_SETTINGS[$a['option']] = $a['value'];
}

if($sth = $db->query("SELECT * FROM version LIMIT 1;")){
$result = $sth->fetch(PDO::FETCH_ASSOC);
$NT_SETTINGS['DB_VER']=$result['db_ver'];
$NT_SETTINGS['DB_LAST_UPDATE']=$result['lastupdate'];
}
unset($sth,$result,$a);
?>
