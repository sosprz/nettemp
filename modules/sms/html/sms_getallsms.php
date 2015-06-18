<?php
        if ($_POST['getall'] == "getall"){
         exec("gammu -c tmp/gammurc getallsms > tmp/gammu_getallsms");  
         header("location: " . $_SERVER['REQUEST_URI']);
         exit();
         } 
        if ($_POST['delall'] == "delall"){
         exec("gammu -c tmp/gammurc deleteallsms 1"); 
         exec("gammu -c tmp/gammurc getallsms > tmp/gammu_getallsms");
         header("location: " . $_SERVER['REQUEST_URI']);
         exit();
         } 
         

?>

<form action="" method="post">
<button class="btn btn-primary" type="submit" name="getall" value="getall">Get sms</button>
</form>


<form action="" method="post">
<button class="btn btn-primary" type="submit" name="delall" value="delall">Remove all SMS</button>
</form>

<?php
    if (file_exists("tmp/gammu_getallsms")) {
?>
<div style="width:990px;height:auto;overflow:auto;padding:5px;">
<pre><?php include('tmp/gammu_getallsms'); ?></pre>
</div>
<?php
}
?>



