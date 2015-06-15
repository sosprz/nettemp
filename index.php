<?php 
ob_start();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$dbfile='dbf/nettemp.db';
if ( '' == file_get_contents( $dbfile ) )
{ ?>
<html>
<h1><font color="blue">nettemp.pl</font></h2>
<h2><font color="red">Database not found <?php echo $dbfile; ?></font></h2>
<h3>Go to shell and reset/create nettemp database:<h3>
/var/www/nettemp/modules/tools/db_reset <br />
</html>
<?php }
else {
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="media/custom.css" rel="stylesheet">

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
		<img src="media/png/nettemp.pl.png" lass="img-rounded">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
	              </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li <?php echo $id == 'status' ? ' class="active"' : ''; ?>><a href="status" >Status</a></li>
              <li <?php echo $id == 'view' ? ' class="active"' : ''; ?>><a href="view" >Charts </a></li>
              <li <?php echo $id == 'info' ? ' class="active"' : ''; ?>><a href="info">Info</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Settings<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>
	    <form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>        
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

<div class="container">


	<?php if ($numRows1 == 1 && ( $perms == "adm" )) { ?>
		<li><a href='devices'<?php echo $id == 'devices' ? ' class="active"' : ''; ?>><span <?php echo $id == 'devices' ? ' class="active"' : ''; ?>>Devices</span></a></li>
		<li><a href='notification'<?php echo $id == 'notification' ? ' class="active"' : ''; ?>><span <?php echo $id == 'notification' ? ' class="active"' : ''; ?>>Notification</span></a></li>
		<li><a href='security'<?php echo $id == 'security' ? ' class="active"' : ''; ?>><span <?php echo $id == 'security' ? ' class="active"' : ''; ?>>Security</span></a></li>
		<li><a href='settings'<?php echo $id == 'settings' ? ' class="active"' : ''; ?>><span <?php echo $id == 'settings' ? ' class="active"' : ''; ?>>Settings</span></a></li>
		<li><a href='tools'<?php echo $id == 'tools' ? ' class="active"' : ''; ?>><span <?php echo $id == 'tools' ? ' class="active"' : ''; ?>>Tools</span></a></li> 
		<li><a href='info'<?php echo $id == 'info' ? ' class="active"' : ''; ?>><span <?php echo $id == 'info' ? ' class="active"' : ''; ?>>Info</span></a></li>
 <?php } 
?>
<?php  
switch ($id)
{ 
default: case '$id': include('modules/status/html/status.php'); break;
case 'view': include('modules/view/html/view.php'); break;
case 'devices': include('modules/devices/html/devices.php'); break;
case 'notification': include('modules/notification/html/notification.php'); break;
case 'security': include('modules/security/html/security.php'); break;
case 'settings': include('modules/settings/settings.php'); break;
case 'tools': include('modules/tools/html/tools.php'); break;
case 'info': include('modules/info/info.php'); break;
case 'denied': include('modules/login/denied.php'); break;
case 'diag': include('modules/tools/html/tools_file_check.php'); break;
case 'upload': include('modules/tools/backup/html/upload.php'); break;
case 'receiver': include('modules/sensors/html/receiver.php'); break;
case 'espupload': include('modules/sensors/wireless/espupload/espupload.php'); break;

}
?>

<?php } 
?>




</div>




<footer class="footer">
      <div class="container text-center">
        <p class="text-muted">Donate for developing paypal <?php //include('modules/info/paypal.php'); ?> build <?php passthru("/usr/bin/git branch |grep [*]|awk '{print $2}' && awk '/Changelog/{y=1;next}y' readme.md |head -2 |grep -v '^$'"); ?></td><td>| System time <?php $today=date("H:i:s"); echo $today;?></p>
      </div>
    </footer>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>



