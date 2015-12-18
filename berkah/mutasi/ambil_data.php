<?php
include"../koneksi.php";
$id_unit = $_GET['id_unit'];
if($id_unit){
$query = mysql_query("SELECT nm_unit FROM unit WHERE id_unit='$id_unit'");
while($d = mysql_fetch_array($query)){
       echo $d['nm_unit'];
}
}
?>