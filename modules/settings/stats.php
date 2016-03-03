<?php
    $save = isset($_POST['save']) ? $_POST['save'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $nick = isset($_POST['nick']) ? $_POST['nick'] : '';
    $sensor_temp = isset($_POST['sensor_temp']) ? $_POST['sensor_temp'] : '';
    $agreement = isset($_POST['agreement']) ? $_POST['agreement'] : '';
    if ($save == "save"){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE statistics SET location='$location', nick='$nick', agreement='$agreement', sensor_temp='$sensor_temp' WHERE id='1'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from statistics WHERE id='1'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
    $agreement=$a['agreement'];
    $nick=$a['nick'];
    $location=$a['location'];
    $sensor_temp=$a['sensor_temp'];
    }

    $sth = $db->prepare("SELECT * FROM sensors");
    $sth->execute();
    $sensors = $sth->fetchAll();
?>


<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Statistics</h3>
</div>
<div class="panel-body">

If You want send anonymous info about Your nettemp write in agreement: <span class="label label-success">yes</span><br>
Your nettemp will send ID (md5sum from mac-addres), os name, hardware type, nick, location and value from sensor if set.<br>
Go to <a href="http://stats.nettemp.pl" class="label label-info">stats.nettemp.pl</a> and check what looks statistic. <br>
<br>


<div id="map-canvas" class="center" style="float: none; margin-left: auto; margin-right: auto;"></div>

<!-- <p>Lat: <input type="text" id="latitude" /> Lng: <input type="text" id="longitude" /></p> -->

</br>
<form action="" method="post" class="form-horizontal">
<fieldset>


<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">ID:</label>  
  <div class="col-md-4">
  <input id="textinput"  placeholder="" class="form-control input-md" required="" type="text" value="<?php $md5=passthru('sudo cat /sys/class/net/eth0/address |md5sum |cut -c 1-32 || sudo cat /sys/class/net/wlan0/address |md5sum |cut -c 1-32') ?>" disabled>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Version:</label>  
  <div class="col-md-4">
  <input id="textinput"  placeholder="" class="form-control input-md" required="" type="text" value="<?php passthru("/usr/bin/git branch |grep [*]|awk '{print $2\" \"}' && awk '/Changelog/{y=1;next}y' readme.md |head -2 |grep -v '^$'"); ?>" disabled>
  </div>
</div>

<div class="form-group">   <label class="col-md-4 control-label" for="textinput">OS:</label>   <div class="col-md-4">   <input id="textinput"  placeholder="" class="form-control input-md" required="" type="text" value="<?php passthru('cat /etc/os-release | grep PRETT | sed \'s/^.*=\"\\(.*\\)\".*/\\1/g\'');?>" disabled>   </div> </div>
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Seensor:</label>
  <div class="col-md-4">
    <select id="selectbasic" name="sensor_temp" class="form-control">
	<?php foreach($sensors as $a) { ?>
	    <option value="<?php echo $a['id'] ?>"  <?php echo $a['id'] == $sensor_temp ? 'selected="selected"' : ''; ?> ><?php echo $a['name'] ?></option>
	<?php
	    }
	?>
		    <option value="none" <?php echo $sensor_temp == 'none' ? 'selected="selected"' : ''; ?>  >none</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="latitude">Location:</label>  
  <div class="col-md-4">
  <input id="latitude" name="location" placeholder="" class="form-control input-md"  type="text" value="<?php echo $location; ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Nickname:</label>  
  <div class="col-md-4">
  <input id="textinput" name="nick" placeholder="" class="form-control input-md"  type="text" value="<?php echo $nick; ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Agreement:</label>  
  <div class="col-md-4">
  <input id="textinput" name="agreement" placeholder="write yes or no" class="form-control input-md" type="text" value="<?php echo $agreement; ?>">
    <input type="hidden" name="save" value="save" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-success">Save</button>
  </div>
</div>

</fieldset>
</form>

</div>
</div>

<style>
#map-canvas {
    height:400px;
    width:400px;
}
#iwContent {
    height: 40px;
    width: 150px;
}
</style>


<script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry"></script>

<script>
 var map;
    var marker;
    var infowindowPhoto = new google.maps.InfoWindow();
    var latPosition;
    var longPosition;
    
    function initialize() {
    
        var mapOptions = {
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: new google.maps.LatLng(10,10)
        };
    
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        
        initializeMarker();
    }
    
    function initializeMarker() {
    
        if (navigator.geolocation) {
            
            navigator.geolocation.getCurrentPosition(function (position) {
                
                var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    
                latPosition = position.coords.latitude;
                longPosition = position.coords.longitude;
		//console.log(longPosition);
    
                marker = new google.maps.Marker({
                    position: pos,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    map: map
                });
                
                map.setCenter(pos);
                updatePosition();
    
                google.maps.event.addListener(marker, 'click', function (event) {
                    updatePosition();
                });
    
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    updatePosition();
                });
            });
        }
    }
    
    function updatePosition() {
    
        latPosition = marker.getPosition().lat();
        longPosition = marker.getPosition().lng();
    
        contentString = '<div id="iwContent">Lat: <span id="latbox">' + latPosition + '</span><br />Lng: <span id="lngbox">' + longPosition + '</span></div>';
        
        document.getElementById('latitude').value = latPosition + ',' + longPosition ;
        //document.getElementById('longitude').value = longPosition;
        
        infowindowPhoto.setContent(contentString);
        infowindowPhoto.open(map, marker);
    }
    
    initialize();
</script>

