<?php
$dayexit = isset($_POST['dayexit']) ? $_POST['dayexit'] : '';
if (($dayexit == "dayexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$dayrun = isset($_POST['dayrun']) ? $_POST['dayrun'] : '';
if ($dayrun == "on")  {
    $db->exec("UPDATE gpio SET status='Wait',day_run='on' WHERE gpio='$gpio_post'") or die("dayrun on error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

if ($dayrun == "off")  {
    include('gpio_off.php');
    $db->exec("UPDATE gpio SET day_run='', status='OFF' WHERE gpio='$gpio_post'") or die("dayrun off error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }


    $day_run=$a['day_run'];
    if ($day_run == 'on') { 
?>

  
	Status:<?php echo $a['status']; ?> 
	
	<form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-danger">Exit</button>
	<input type="hidden" name="dayrun" value="off" />
	<input type="hidden" name="off" value="off" />
	</form>

<?php 
    }
	else 
    {
    include('gpio_day_plan.php'); 
?>
    <form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-success">ON</button>
	<input type="hidden" name="dayrun" value="on" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="dayoff" value="off" />
	<button type="submit" class="btn btn-xs btn-danger">Exit</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="dayexit" value="dayexit" />
   </form>
   
<?php
    }
?>

