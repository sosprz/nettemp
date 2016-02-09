<?php
$id = isset($_POST['id']) ? $_POST['id'] : '';
$name1 = isset($_POST['name1']) ? $_POST['name1'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';

if ($name1 == "name2"){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET name='$name' WHERE id='$id'") or die("name exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 


//if (!empty($mode)) { 
?>
<!--     <td><img type="image" src="media/ico/SMD-64-pin-icon_24.png" ></td> -->
    <?php //echo $a['name']; 
    //}
    //else { 
?>

<?php
if (empty($mode)) { 
?>

<form action="" method="post" style=" display:inline!important;">
    <img type="image" src="media/ico/SMD-64-pin-icon_24.png" >
    <input type="text" name="name" value="<?php echo $a['name']; ?>" size="6">
    <input type="hidden" name="name1" value="name2">
    <input type="hidden" name="id" value="<?php echo $a['id']; ?>" >
<button class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span> </button>
</form>
<?php 
    }
?>
