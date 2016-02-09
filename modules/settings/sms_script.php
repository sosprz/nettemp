<div class="panel panel-info">
  <div class="panel-heading">Edit file in tmp/sms_script</div>
  <div class="panel-body">



<pre>
<?php
$file = "tmp/sms_script";
if (file_exists($file)) {
$filearray = file($file);
$last = array_slice($filearray,-100);
    foreach($last as $f){
	echo $f;
    }
}
else {
$current = file_get_contents($file);
$current .= "#!/bin/bash\n";
$current .= "sudo reboot\n";
file_put_contents($file, $current);
chmod($file, 0755);
header("location: " . $_SERVER['REQUEST_URI']);
exit();

}
?>
  </div>
</div>
