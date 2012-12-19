<span class="belka">&nbsp Status:<span class="okno">
<?php 

$dir="modules/logoterma/";

if ($_POST['off'] == "Logoterma is ON" ) {
exec("$dir/logoterma run 0");
header("location: " . $_SERVER['REQUEST_URI']);
exit();

}

if ($_POST['on'] == "Logoterma is OFF" ) {
exec("$dir/logoterma run 3600");
header("location: " . $_SERVER['REQUEST_URI']);
exit();

}




exec("$dir/relay", $out);

foreach ($out as $relay)
{
  
if ($relay == 'on') {  
?>
<form action="logoterma" method="post"><input type="submit" name="off" value="Logoterma is ON" /></form>
<?php
} 
elseif ($relay == 'off') {   
?>
<form action="logoterma" method="post"><input type="submit" name="on" value="Logoterma is OFF" /></form>

<?php }

}


?>
</span></span>