

<span class="belka">&nbsp Manual settings:<span class="okno">
<?php 

$dir="modules/logoterma";

if ($_POST['off'] == "Logoterma is ON" ) {
exec("$dir/relay off");
}

if ($_POST['on'] == "Logoterma is OFF" ) {
exec("$dir/relay on");
}




exec("$dir/logoterma", $out_logoterma);

foreach ($out_logoterma as $relay_logoterma)
{
echo "$relay_logoterma</br >";
}


?>

</span>
</span>