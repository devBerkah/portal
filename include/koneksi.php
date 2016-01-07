<?php
$host='localhost';
$user='root';
$pass=''; 
$db='berkah'; 
if(!mysql_connect($host,$user,$pass)) echo "Tdk Konek Ke Database, Silahkan Cek Apakah Konfigurasi sudah sesuai ?";
if(!mysql_select_db($db)) echo "Database Tdk Ada, Silahkan cek kembali !";
include_once 'fungsi-std.php';
?>
