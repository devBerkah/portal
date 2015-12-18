<?php

include "koneksi.php";

$id_unit = $_POST['id_unit'];
$nm_unit = $_POST['nm_unit'];
$alamat = $_POST['alamat'];
$kontak = $_POST['kontak'];
$email = $_POST['email'];

$Simpan = mysql_query("UPDATE unit SET id_unit = '$id_unit', nm_unit = '$nm_unit', alamat = '$alamat', kontak = '$kontak', email = '$email' where id_unit = '$id_unit'");

echo mysql_error();
?>
<script language="javascript">alert('Data Sudah Disimpan');
//javascript:history.go(-1);</script>
			<? 
?>