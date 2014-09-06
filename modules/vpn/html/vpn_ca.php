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

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="download" value="download">
<td><input  type="submit" value="Download ca.crt"  /></td>
</form>
