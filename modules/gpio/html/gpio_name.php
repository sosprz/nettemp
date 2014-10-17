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
?>

<form action="" method="post">
    <td><img type="image" src="media/ico/SMD-64-pin-icon_24.png" ></td>
    <td><input type="text" name="name" value="<?php echo $a['name']; ?>" size="10"></td>
    <input type="hidden" name="name1" value="name2">
    <input type="hidden" name="id" value="<?php echo $a['id']; ?>" >
    <td><input type="image" src="media/ico/Actions-edit-redo-icon.png" alt="Submit" title="Reload" ></td>
</form>

