<?php
header("Pragma: no-cache");
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from sensors where jg='on' ORDER BY position ASC");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { ?>
<script>
<?php
$kw = 1;
foreach ($result as $a) {
?>
g<?=$kw++?>.refresh('<?php
if($a['type']=='elec') { echo $a['current']; } else if($a['tmp']=='error') { echo '0'; } else { echo $a['tmp']; }
?>');
<?php
}
?>
</script>
<?php }  ?>