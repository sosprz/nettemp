<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$html = $db->query("SELECT * FROM html");
$html1 = $html->fetchAll();
foreach($html1 as $hp){
       if($hp['name']=='info') {
       	$html_info=$hp['state'];
       }
       if($hp['name']=='footer') {
       	$html_footer=$hp['state'];
       }
        if($hp['name']=='screen') {
       	$html_screen=$hp['state'];
       }
       if($hp['name']=='nettemp_alt') {
       	$html_nettemp_alt=$hp['value'];
       }
       if($hp['name']=='nettemp_logo') {
       	$html_nettemp_logo=$hp['value'];
       }
       if($hp['name']=='nettemp_link') {
       	$html_nettemp_link=$hp['value'];
       }
       if($hp['name']=='charts_max') {
       	$html_charts_max=$hp['value'];
       }
       if($hp['name']=='map_width') {
       	$html_map_width=$hp['value'];
       }
       if($hp['name']=='map_height') {
       	$html_map_height=$hp['value'];
       }
}
?>