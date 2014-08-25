<span class="belka">&nbsp OpenVPN status<span class="okno">
<?php
if ($_POST['download'] == "download") { 
$path = "/etc/openvpn/";
$filename = "ca.crt";

header("Content-Type:image/file");
header("Content-Disposition: attachment; filename=".$filename);
header("Cache-control: private");
header('X-Sendfile: '.$path);
readfile($path);
exit;
}
?>

<form action="index.php?id=vpn" method="post">
<input type="hidden" name="download" value="download">
<td><input  type="submit" value="Download ca.crt"  /></td>
</form>
</span></span>
