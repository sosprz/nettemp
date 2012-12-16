<span class="belka">&nbsp Logoterma status:<span class="okno">
<?php 

$dir="modules/logoterma/";

if ($_POST['off'] == "Logoterma is ON" ) {
exec("$dir/relay off");
}

if ($_POST['on'] == "Logoterma is OFF" ) {
exec("$dir/relay on");
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
</span>