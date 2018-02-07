<?php 

$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");


$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM ownwidget");
$row = $rows->fetchAll();
$numRows = count($row);

if ( $numRows > '0' ) { 

	foreach ($row as $ow) {	

	if (($ow['onoff'] == "on") && ($ow['iflogon'] == "off"))  {
		
		include("$root/tmp/ownwidget".$ow['body'].".php");
		
	} else { if (($ow['onoff'] == "on") && ($ow['iflogon'] == "on"))  {
			
			if(($_SESSION["perms"] == 'adm') || (isset($_SESSION["user"]))) {

				include("$root/tmp/ownwidget".$ow['body'].".php");
		
			 } 
			
			}
		}
	}
}?>