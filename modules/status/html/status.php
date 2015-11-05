<script src="html/masonry/masonry.pkgd.min.js"></script>

<style type="text/css">
.grid-item { width: 330px; 
    }

.grid-item {
  padding: 0px 5px 0px 0px;
  float: left;
}


}
</style>

<div class="grid">
    <?php include('modules/sensors/html/sensor_status.php'); ?>
    <?php include('modules/settings/ownwidget.php'); ?>
    <?php include('modules/hosts/html/hosts_status.php'); ?>
    <?php include('modules/gpio/html/gpio_status.php'); ?>
    <?php include('modules/relays/html/relays_status.php'); ?>
    <?php include('modules/kwh/html/kwh_status.php'); ?>
    <?php include('modules/tools/html/tools_file_check.php'); ?>
    <?php include('modules/settings/meteo_status.php'); ?>
    <?php include('modules/ipcam/cam1.php'); ?>
</div>

<script type="text/javascript">
$(window).load(function(){
 var $container = $('.grid');
 // initialize
 $container.masonry({
 itemSelector: '.grid-item'
 });
});
</script>