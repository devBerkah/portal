
<?php
$host='localhost';
$user='root';
$pass=''; 
$db='berkahgl_data'; 
if(!mysql_connect($host,$user,$pass)) echo "Tdk Konek Ke Database, Silahkan Cek Apakah Konfigurasi sudah sesuai ?";
if(!mysql_select_db($db)) echo "Database Tdk Ada, Silahkan cek kembali !";

?>
