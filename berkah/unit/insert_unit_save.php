<?php

include "koneksi.php";

$id_unit = $_POST['id_unit'];
$nm_unit = $_POST['nm_unit'];
$alamat = $_POST['alamat'];
$kontak = $_POST['kontak'];
$email = $_POST['email'];

$Simpan = mysql_query("INSERT INTO unit VALUES('$id_unit', '$nm_unit', '$alamat', '$kontak', '$email')");

echo mysql_error();
?>
<script language="javascript">alert('Data Sudah Disimpan');
document.location='insert_unit.php'</script>

			<? 
?>