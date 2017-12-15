<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>nettemp</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../custom.css" rel="stylesheet">

    <!-- jQuery -->
    <script type="text/javascript" src="../jquery/jquery-1.11.3.min.js"></script>

    <!-- bootstrap-toogle -->
    <link href="../bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
    <script type="text/javascript" src="../bootstrap-toggle/bootstrap-toggle.min.js"></script>

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
		<a href="http://nettemp.pl" target="_blank"><img src="../../media/png/nettemp.pl.png" height="50"></a>

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
	              </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
		<li><a href="../../status">Home</a></li>
		<li><a href="no_db.php">Reset DB</a></li>
            </ul>

    	</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
        </nav>
 

<div class="container">
<?php include('../../modules/tools/html/tools_reset.php'); ?>
</div>


<footer class="footer">
      <div class="container text-center">
        <p class="text-muted"><table><tr>Donate for developing <?php include('../../modules/info/paypal.php'); ?> <?php passthru("/usr/bin/git branch |grep [*]|awk '{print $2}' && awk '/Changelog/{y=1;next}y' ../../readme.md |head -2 |grep -v '^$'"); ?>| System time <?php passthru("date +%H:%M:%S");?></tr></table></p>
      </div>
</footer>

    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->


  </body>
</html>
