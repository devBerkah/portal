<?php
include"../koneksi.php";
$idjab = $_GET['id_jabatan'];
if($idjab){
$query = mysql_query("SELECT nm_jabatan FROM jabatan WHERE id_jabatan='$idjab'");
while($d = mysql_fetch_array($query)){
       echo $d['nm_jabatan'];
}
}
?>