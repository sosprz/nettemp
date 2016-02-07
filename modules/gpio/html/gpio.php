<?php 
$gpios=isset($_GET['gpios']) ? $_GET['gpios'] : '';
switch ($gpios)
{ 
default: case '$gpios': include('modules/gpio/html/gpio_settings.php'); break;
}

	include("gpio_menu.php");
	include("gpio_add.php"); 
?>
