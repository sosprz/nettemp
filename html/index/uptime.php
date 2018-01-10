<?php
		$data = shell_exec('uptime');
		$uptime = explode(' up ', $data);
		$uptime = explode(',', $uptime[1]);
		$uptime = $uptime[0].', '.$uptime[1];
		echo ('Uptime: '.$uptime.'');
?>