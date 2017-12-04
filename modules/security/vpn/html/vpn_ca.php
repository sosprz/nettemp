<?php
$homepage = file_get_contents('/etc/openvpn/ca.crt');
?>

<script language="javascript"> 
function toggle() {
    var ele = document.getElementById("toggleText");
    var text = document.getElementById("displayText");
    if(ele.style.display == "block") {
	    ele.style.display = "none";
	text.innerHTML = "<button>Show ca.crt</button>";
    }
    else {
	ele.style.display = "block";
	text.innerHTML = "<button>Hide ca.crt</button>";
    }
} 
</script>
 
<a id="displayText" href="javascript:toggle();">
<button>Show ca.crt</button></a>
<div id="toggleText" style="display: none">
<br>
<font color="grey">Note: Copy and paste bellow lines to ca.crt file.</font>

<br>
<pre>
<?php  echo $homepage; ?>
</pre>
</div>

<?php
$dca = isset($_POST['dca']) ? $_POST['dca'] : '';
    if (($dca == "dca") ){
$file='/etc/openvpn/ca.crt';
    header('Content-Description: File Transfer');
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit();
}
?>
<form method="post" action="" method"post">
    <input type="hidden" name="dca" value="dca" />
    <input type="submit" name="submit" value="Download ca.crt" />
</form>



