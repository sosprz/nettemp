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
 
<a id="displayText" href="javascript:toggle();"><button>Show ca.crt</button></a>
<div id="toggleText" style="display: none">
<br>
Copy and paste bellow lines to ca.crt file.
<br>
<pre>
<?php  echo $homepage; ?>
</pre>

</div>
