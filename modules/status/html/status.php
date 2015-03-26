<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
</script>
<!-- <body onload="JavaScript:timedRefresh(60000);"> -->

<script src="media/masonry.pkgd.min.js"></script>
<script type="text/JavaScript">
var container = document.querySelector('#container');
var msnry = new Masonry( container, {
  //options
  columnWidth: 50,
  itemSelector: '.item'
});
</script>

<STYLE type="text/css">
* {
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
}
.masonry {
  margin: 0 auto;
}
.masonry .item {
  width:  341px;
  float: left;
}
</STYLE>


<div class="masonry js-masonry"  data-masonry-options='{ "isFitWidth": true }'>
  <div class="item"><?php include('modules/sensors/html/sensor_status.php'); ?></div>
  <div class="item "><?php include('modules/status/html/cam.php'); ?></div>
  <div class="item"><?php include('modules/hosts/html/hosts_status.php'); ?></div>
  <div class="item"><?php include('modules/gpio/html/gpio_status.php'); ?></div>
  <div class="item"><?php include('modules/kwh/html/kwh_status.php'); ?></div>
  <div class="item"><?php include('modules/tools/html/tools_file_check.php'); ?></div>
</div>














