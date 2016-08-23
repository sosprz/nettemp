<?php
    $screen_onoff = isset($_POST['screen_onoff']) ? $_POST['screen_onoff'] : '';
    $screen_onoff1 = isset($_POST['screen_onoff1']) ? $_POST['screen_onoff1'] : '';
    if (($screen_onoff1 == "screen_onoff2") ){
    $db->exec("UPDATE html SET state='$screen_onoff' WHERE name='screen'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Screen</h3>
</div>
<div class="panel-body"> 
<form action="" method="post">
  <input type="hidden" name="screen_onoff1" value="screen_onoff2"  />
  <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="screen_onoff" value="on"  <?php echo $html_screen == 'on' ? 'checked="checked"' : ''; ?> >
</form>
</div>
</div>


