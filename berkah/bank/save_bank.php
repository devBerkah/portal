<?php
include("../koneksi.php");
$kode=$_POST['kd_bank'];
$nama=$_POST['nm_bank'];
mysql_query("insert into bank values ('$kode','$nama')") ;
echo"<script>alert ('data telah di tersimpan ');document.location='tampil_bank.php' </script> ";
?>
