<script src="html/masonry/masonry.pkgd.min.js"></script>
<script type="text/JavaScript">
</script>



<style type="text/css">

.grid-item {
  width: 350px;
  float: left;
  padding: 0px 5px 0px 0px;
}
</style>

<div class="grid">
    <?php include('modules/sensors/html/sensor_status.php'); ?>
    <?php include('modules/ipcam/cam1.php'); ?>
    <?php include('modules/settings/ownwidget.php'); ?>
    <?php include('modules/hosts/html/hosts_status.php'); ?>
    <?php include('modules/gpio/html/gpio_status.php'); ?>
    <?php include('modules/relays/html/relays_status.php'); ?>
    <?php include('modules/kwh/html/kwh_status.php'); ?>
    <?php include('modules/tools/html/tools_file_check.php'); ?>
    <?php include('modules/settings/meteo_status.php'); ?>
</div>

<script src="html/jquery/jquery.js"></script>
<script>
var auto_refresh = setInterval(
(function () {
    $("#res").load("modules/sensors/html/sensor_status.php");
}), 60000);
</script>
