<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new SQLite3("$root/dbf/nettemp.db");
$sth = $db->query("SELECT tmp, time, name, type FROM sensors WHERE position !=0 AND type!='elec' ORDER BY position ASC");
$data = array();
while ($result = $sth->fetchArray(SQLITE3_ASSOC))
{
    array_push($data, $result);
}
echo json_encode($data);
?>
