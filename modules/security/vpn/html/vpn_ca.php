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


# create new zip opbject
$zip = new ZipArchive();

# create a temp file & open it
$tmp_file = tempnam('.','');
$zip->open($tmp_file, ZipArchive::CREATE);

# loop through each file
#foreach($files as $file){

    # download file
    $download_file = file_get_contents($file);

    #add it to the zip
    $zip->addFromString(basename($file),$download_file);

#}

# close zip
$zip->close();

# send the file to the browser as a download
header('Content-disposition: attachment; filename=ca.zip');
header('Content-type: application/zip');
readfile($tmp_file);
}
?>
<form method="post" action="" method"post">
    <input type="hidden" name="dca" value="dca" />
    <input type="submit" name="submit" value="Download ca.crt" />
</form>



