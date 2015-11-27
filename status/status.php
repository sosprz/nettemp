<style type="text/css">
.grid-item { 
    width: 330px; 
    }
.grid-item {
  padding: 0px 5px 0px 0px;
  float: left;
}
*, *:before, *:after {box-sizing:  border-box !important;}


.grid {
 -moz-column-width: 21em;
 -webkit-column-width: 21em;
 -moz-column-gap: 0em;
 -webkit-column-gap:0em; 
}

#ss,#ow1,#ow2,#ow3,#gs,#hs,#rs,#kwh,#ms,#cam {
 display: inline-block;
 padding:  1px;
}

.grid-item {
 position:relative;
 display: block;
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
    <div id="kwh"><?php 
	include_once('status/kwh_status.php'); 
    ?></div>
    <div id="ms"><?php 
	include_once('status/meteo_status.php'); 
    ?></div>
    <div id="cam"><?php 
	include('status/ipcam_status.php'); 
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
</script>





