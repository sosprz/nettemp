<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
</script>
<body onload="JavaScript:timedRefresh(60000);">
<div id="left">
<?php 
include('modules/sensors/html/sensor_status.php');
include('modules/hosts/html/hosts_status.php');
include('modules/gpio/html/gpio_status.php');
include('modules/kwh/html/kwh_status.php');
include('modules/tools/html/tools_file_check.php');

?>
</div>




