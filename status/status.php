<style type="text/css">

* {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

//body { font-family: sans-serif; }

/* ---- grid ---- */

.grid {
  //background: #EEE;
  //max-width: 1200px;
}

/* clearfix */
.grid:after {
  content: '';
  display: block;
  clear: both;
}

/* ---- grid-item ---- */

.grid-item {
  width: 370px;
  float: left;
  //background: #D26;
  //border: 2px solid #333;
  //border-color: hsla(0, 0%, 0%, 0.5);
  border-radius: 10px;
    //padding: 10px;
}

</style>



<div id="grid" class="grid">
    <div id="ss"> <?php 
	include_once('status/sensor_status.php'); 
    ?></div>
    <div id="hs"><?php 
	include_once('status/hosts_status.php'); 
    ?></div>
    <div id="rs"><?php 
	include_once('status/relays_status.php'); 
    ?></div>
    
    <div id="ow1"><?php 
	include_once('status/ownwidget1.php'); 
    ?></div>
    <div id="ow2"><?php 
	include_once('status/ownwidget2.php'); 
    ?></div>
    <div id="ow3"><?php 
	include_once('status/ownwidget3.php'); 
    ?></div>
    <div id="co"><?php 
	include_once('status/counters_status.php'); 
    ?></div>
    <div id="gs"><?php 
	include_once('status/gpio_status.php'); 
    ?></div>
    <div id="ms"><?php 
	include_once('status/meteo_status.php'); 
    ?></div>
    <div id="cam"><?php 
	include('status/ipcam_status.php'); 
    ?></div>
    <div id="mm"><?php 
	include('status/minmax_status.php'); 
    ?></div>
</div>

<script type="text/javascript">
    setInterval( function() {
    $("#ss").load("status/sensor_status.php");
    $('#co').load("status/counters_status.php");
    $('#gs').load("status/gpio_status.php");
    $('#hs').load("status/hosts_status.php");
    $('#rs').load("status/relays_status.php");
    $('#ms').load("status/meteo_status.php");
    $('#kwh').load("status/kwh_status.php");
    $('#ow2').load("status/ownwidget2.php");
    $('#ow3').load("status/ownwidget3.php");
}, 60000);

$(document).ready( function() {

  $('.grid').masonry({
    itemSelector: '.grid-item',
    columnWidth: 380
  });
  
});
</script>
<script src="html/masonry/masonry.pkgd.min.js"></script>





