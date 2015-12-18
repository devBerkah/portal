<?php
session_start();
include('../koneksi.php');
$nik = $_POST['nik'];
$id_unit = $_POST['id_unit'];
$id_jabatan = $_POST['id_jabatan'];

$mutasi = mysql_query ("INSERT INTO mutasi VALUES ('', '$nik','$id_unit', '$id_jabatan',now() )");

if($mutasi){
				echo"
				<script type='text/javascript'>
				window.alert('Data Berhasil Diubah');
				window.location='mutasi.php';
				window.refresh(1);
				</script>";
			} else {
				echo "<script type='text/javascript'>
				window.alert('Data Gagal Diubah');
				window.location='mutasi.php';
				window.refresh(1);
				</script>";
			}
?>
