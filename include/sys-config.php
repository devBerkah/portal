<?php
$mesin = "localhost";
$username = "berkahgl_man";
$password = "berkahbgb-man";
$database = "berkahgl_man";
$server=$_SERVER["SERVER_NAME"];
define('skt_nm_unit', "BGB");
define('ful_nm_unit',"BERKAH GLOBAL BUSINESS");
define('alamat', dirname(__FILE__).'/');
// Koneksi dan memilih database di server
mysql_connect($mesin,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");
#####################
define('VALIDASI', 1);
//include('./include/fungsi.php');
?>
