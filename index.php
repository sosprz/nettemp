<?php
include("modules/login/login.php");
ob_start();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$art=isset($_GET['type']) ? $_GET['type'] : '';
$dbfile='dbf/nettemp.db';
if ( '' == file_get_contents( $dbfile ) ) {
header("Location: html/errors/no_db.php");
}
else {
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
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 </head>
<body>

 <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
		<a href="http://nettemp.pl" target="_blank"><img src="media/png/nettemp.pl.png" height="50" alt="nettemp.pl"></a>

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
$db1 = new PDO('sqlite:dbf/nettemp.db');
$rows1 = $db1->query("SELECT * FROM gpio WHERE mode='simple' OR mode='moment' OR mode='trigger' OR mode='call'") or header("Location: html/errors/db_error.php");
$rows2 = $db1->query("SELECT * FROM relays WHERE type='relay'") or header("Location: html/errors/db_error.php");
$row1 = $rows1->fetchAll();
$row2 = $rows2->fetchAll();
$numsimple = count($row1);
$numsimple2 = count($row2);
?>
<li <?php echo $id == 'status' ? ' class="active"' : ''; ?>><a href="index.php?id=status"><span class="glyphicon glyphicon-th-large" aria-hidden="true"> Status</span></a></li>
<li <?php echo $id == 'view' ? ' class="active"' : ''; ?>><a href="index.php?id=view&type=temp&max=day"><span class="glyphicon glyphicon-stats" aria-hidden="true"> Charts</span></a></li>
<?php 
if(($_SESSION["perms"] == 'adm') || (isset($_SESSION["user"]))) {
    if (( $numsimple >= "1") || ( $numsimple2 >= "1"))  { 
    ?>
    <li <?php echo $id == 'controls' ? ' class="active"' : ''; ?>><a href="index.php?id=controls"><span class="glyphicon glyphicon-record" aria-hidden="true"> Controls</span></a></li>
	<?php 
	}
 if($_SESSION["perms"] == 'adm') { 
 ?>
<li <?php echo $id == 'map' ? ' class="active"' : ''; ?>><a href="index.php?id=map"><span class="glyphicon glyphicon-picture" aria-hidden="true"> Map</span> </a></li>
<li<?php echo $id == 'devices' ? ' class="active"' : ''; ?>><a href="index.php?id=devices"><span class="glyphicon glyphicon-cog" aria-hidden="true"> Device</span></a></li>
<li <?php echo $id == 'security' ? ' class="active"' : ''; ?>><a href="index.php?id=security"><span class="glyphicon glyphicon-tower" aria-hidden="true"> Security</span></a></li>
<li <?php echo $id == 'settings' ? ' class="active"' : ''; ?>><a href="index.php?id=settings"><span class="glyphicon glyphicon-tasks" aria-hidden="true"> Settings</span></a></li>
<li <?php echo $id == 'tools' ? ' class="active"' : ''; ?>><a href="index.php?id=tools"><span class="glyphicon glyphicon-wrench" aria-hidden="true"> Tools</span></a></li>
<?php 
	} 
}
?>
<li <?php echo $id == 'info' ? ' class="active"' : ''; ?>><a href="index.php?id=info"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"> Info</span></a></li>
<li> <?php include('modules/settings/access_time_check.php'); ?></li>

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
    <?php } ?>
    <?php if(isset($_SESSION["user"])) {?>
	<form method="post" action="logout" class="navbar-form navbar-right" >
	    <?php echo $_SESSION["user"];?>
	    <button type="submit" class="btn btn-xs btn-success">Log Out</button>
	</form>        
    <?php } ?>
    	</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
        </nav>
 

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
case 'devices': include('modules/devices/html/devices.php'); break;
case 'security': include('modules/security/html/security.php'); break;
case 'settings': include('modules/settings/settings.php'); break;
case 'tools': include('modules/tools/html/tools.php'); break;
case 'info': include('html/info/info.php'); break;
case 'denied': include('modules/login/denied.php'); break;
case 'logout': include('modules/login/logout.php'); break;
case 'upload': include('modules/tools/backup/html/upload.php'); break;
case 'csv': include('common/csv.php'); break;
case 'receiver': include('modules/sensors/html/receiver.php'); break;
case 'controls': include('modules/relays/html/relays_controls.php'); include('modules/gpio/html/gpio_controls.php'); break;
}
?>
</div>

<footer class="footer">
      <div class="container text-center">
	    <a href="https://nettemp.pl/forum/viewtopic.php?f=20&t=765&p=11209" target="_blank" class="btn btn-xs btn-primary"><?php passthru("/usr/bin/git branch |grep [*]|awk '{print $2}' && awk '/Changelog/{y=1;next}y' readme.md |head -2 |grep -v '^$'"); ?> </a>
	    <?php include('html/info/paypal.php');?>
	    <button class="btn btn-xs btn-primary">System time <?php passthru("date +%H:%M:%S");?></button>

	    
      </div>
</footer>

    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
    <script src="html/bootstrap/js/bootstrap.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  </body>
</html>
<?php 
}
?>

