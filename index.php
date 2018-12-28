<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$dbfile=$root.'/dbf/nettemp.db';

if( !file_exists($dbfile) || !is_readable($dbfile) || filesize($dbfile) == 0 ){
    header("Location: html/errors/no_db.php");
}else{
    $db = new PDO("sqlite:$root/dbf/nettemp.db");

    include("modules/login/login.php");
    ob_start();
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $art=isset($_GET['type']) ? $_GET['type'] : '';
    include("modules/settings/nt_settings.php");
	
	
//variables in session
$_SESSION['nts_charts_max'] = $nts_charts_max;

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>nettemp <?php echo gethostname(); ?></title>

    <!-- Bootstrap -->
    <link href="html/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="html/custom.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="html/jquery/jquery-1.11.3.min.js"></script>
    <script src="html/jquery/jquery-migrate-1.2.1.min.js"></script>

    <!-- bootstrap-toogle -->
    <link href="html/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
    <script type="text/javascript" src="html/bootstrap-toggle/bootstrap-toggle.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn''t work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 </head>
<body>

<?php
if($id != 'screen') {
	?>
 <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
		<a href="<?php echo $nts_nettemp_link ?>" target="_blank"><img src="<?php echo $nts_nettemp_logo ?>" height="50" alt="<?php echo $nts_nettemp_alt ?>"></a>

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
<div id="navbar" class="navbar-collapse collapse">
<ul class="nav navbar-nav">
<?php
$rows1 = $db->query("SELECT * FROM gpio WHERE mode='trigger' OR mode='call'") or header("Location: html/errors/db_error.php");
$rows2 = $db->query("SELECT * FROM sensors WHERE type='relay'") or header("Location: html/errors/db_error.php");
$row1 = $rows1->fetchAll();
$row2 = $rows2->fetchAll();
$numsimple = count($row1);
$numsimple2 = count($row2);

if($getseen = $db->query("SELECT COUNT(id) as newseen FROM newdev WHERE seen IS NULL")){
//    $gs = $getseen->fetch(PDO::FETCH_ASSOC);
//    $seen = $gs['newseen'];
    $seen = $getseen->fetch(PDO::FETCH_ASSOC)['newseen'];
}else{
    $seen = -1;
}
function new_seen($seen){
	if($seen > 0 || $seen == -1)
	{	
		return '<span class="badge">'.$seen.'</span>';
	}
}
?>


<li <?php echo $id == 'status' ? ' class="active"' : ''; ?>><a href="index.php?id=status"><span class="glyphicon glyphicon-th-large" aria-hidden="true"> Status</span></a></li>
<li <?php echo $id == 'view' ? ' class="active"' : ''; ?>><a href="index.php?id=view&type=temp&max=<?php echo $nts_charts_max?>"><span class="glyphicon glyphicon-stats" aria-hidden="true"> Charts</span></a></li>
<?php
	if($nts_screen=='on')
	{
	?>
	<li <?php echo $id == 'screen' ? ' class="active"' : ''; ?>><a href="index.php?id=screen"><span class="glyphicon glyphicon-modal-window" aria-hidden="true"> Screen</span></a></li>
<?php
	}
	if(($_SESSION["perms"] == 'adm') || (isset($_SESSION["user"]))) {
   if (( $numsimple >= "1") || ( $numsimple2 >= "1"))  {
   ?>
   <li <?php echo $id == 'controls' ? ' class="active"' : ''; ?>><a href="index.php?id=controls"><span class="glyphicon glyphicon-record" aria-hidden="true"> Controls</span></a></li>
<?php
	}
 	if($_SESSION["perms"] == 'adm') {
	
	if ($nts_mapon == 'on'){
	?>

	<li <?php echo $id == 'map' ? ' class="active"' : ''; ?>><a href="index.php?id=map"><span class="glyphicon glyphicon-picture" aria-hidden="true"> Map</span> </a></li><?php }?>
<li <?php echo $id == 'device' ? ' class="active"' : ''; ?>><a href="index.php?id=device"><span class="glyphicon glyphicon-cog" aria-hidden="true"> Device <?php echo new_seen($seen);?></span></a></li>
<li <?php echo $id == 'security' ? ' class="active"' : ''; ?>><a href="index.php?id=security"><span class="glyphicon glyphicon-lock" aria-hidden="true"> Security</span></a></li>
<li <?php echo $id == 'settings' ? ' class="active"' : ''; ?>><a href="index.php?id=settings"><span class="glyphicon glyphicon-tasks" aria-hidden="true"> Settings</span></a></li>
<li <?php echo $id == 'tools' ? ' class="active"' : ''; ?>><a href="index.php?id=tools"><span class="glyphicon glyphicon-wrench" aria-hidden="true"> Tools</span></a></li>
<?php
	}
}
if($nts_info=='on') {
?>
<li <?php echo $id == 'info' ? ' class="active"' : ''; ?>><a href="index.php?id=info"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"> Info</span></a></li>
<?php
	}
	?>
<li> <?php include('modules/settings/access_time_check.php'); ?></li>
<?php if (file_exists("tmp/update")) {  ?>
<li><a href="index.php?id=tools&type=update"><span class="glyphicon" aria-hidden="true"></span><span class="btn btn-xs btn-info">Update</span></a></li>

<?php } ?>
</ul>



    <?php if(!isset($_SESSION["user"])) {?>
	    <form method="post" class="navbar-form navbar-right" >
            <div class="form-group">
              <input type="text" name="username" placeholder="User" class="form-control input-sm" required="">
            </div>
            <div class="form-group">
              <input type="password" name="password" placeholder="Password" class="form-control input-sm" required="">
            </div>
	    <input type="hidden" name="form_login" value="log">
            <button type="submit" class="btn btn-xs btn-success">Sign in</button>
          </form>
    <?php
    }
		if(isset($_SESSION["user"])) {?>
	<form method="post" action="index.php?id=logout" class="navbar-form navbar-right" >
	    <?php echo $_SESSION["user"];?>
	    <button type="submit" class="btn btn-xs btn-success">Log Out</button>
	</form>
	<form action="" method="post" class="navbar-form navbar-right">
		Remember me:
		<input type="checkbox" data-toggle="toggle" data-size="mini" name="autologout_value" value="on" <?php echo $autologout == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" />
		<input type="hidden" name="setautologout" value="onoff" />
    </form>
    <?php } ?>
    	</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</nav>
<?php
	}
	?>

<div class="container-nettemp">
<?php
if (file_exists("tmp/reboot")) {  ?>
<div class="alert alert-warning" role="alert"><a href="index.php?id=tools&type=reboot" class="btn btn-xs btn-warning">Reboot required</a></div>
<?php
}
?>

<?php
switch ($id)
{
default: case '$id': include('status/status.php'); break;
case 'view': include('modules/charts/menu.php'); break;
case 'map': include('modules/map/map_main.php'); break;
case 'device': include('modules/devices/html/devices.php'); break;
case 'security': include('modules/security/html/security.php'); break;
case 'settings': include('modules/settings/settings.php'); break;
case 'tools': include('modules/tools/html/tools.php'); break;
case 'info': include('html/info/info.php'); break;
case 'denied': include('modules/login/denied.php'); break;
case 'logout': include('modules/login/logout.php'); break;
case 'upload': include('modules/tools/backup/html/upload.php'); break;
case 'csv': include('common/csv.php'); break;
case 'receiver': include('modules/sensors/html/receiver.php'); break;
case 'controls': include('modules/relays/html/relays_controls.php'); include('modules/relays/html/switch_controls.php'); include('modules/gpio/html/gpio_controls.php'); break;
case 'screen': include('modules/screen/screen.php'); break;
}
?>
</div>
<script type="text/javascript">
var refreshTime = 30000; 
window.setInterval( function() {
    $.ajax({
        cache: false,
        type: "GET",
        url: "common/refreshSession.php",
        success: function(data) {
        }
    });
}, refreshTime );
</script>

<?php
	if(($nts_footer=='on')&&($id!='screen')){ ?>
<footer class="footer">
      <div class="container text-center">
			<a href="https://nettemp.pl/forum/viewforum.php?f=35" target="_blank" class="btn btn-xs btn-primary"><?php passthru("/usr/bin/git branch |grep [*]|awk '{print $2}' && awk '/Changelog/{y=1;next}y' readme.md |head -2 |grep -v '^$'"); ?> </a>
			
		<button class="btn btn-xs btn-primary uptime">
			<?php include('html/index/uptime.php');?>
		</button>
			
	    <?php include('html/info/paypal.php');?>
			<button class="btn btn-xs btn-primary systime">
			<?php include('html/index/systime.php');?>
			</button>
	    
		<a href="http://wiki.abc-service.com.pl/doku.php" target="_blank" class="btn btn-xs btn-primary">NT WIKI </a>

      </div>
</footer>
<?php 
	}
	?>

    <!-- jQuery (necessary for Bootstrap''s JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
    <script src="html/bootstrap/js/bootstrap.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  </body>
</html>
<?php
} //end of : if( !file_exists($dbfile) || !is_readable($dbfile) || filesize($dbfile) == 0 )
?>
