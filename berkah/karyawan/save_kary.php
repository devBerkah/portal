<?php
//extract($HTTP_POST_VARS);
$nik = $_POST['nik'];
$nama = $_POST['nama'];
$tmp_lhr = $_POST['tmp_lhr'];
$tgl_lhr = $_POST['tgl_lhr'];
$jk = $_POST['jk'];
$tgl_masuk = $_POST['tgl_masuk'];
$alamat = $_POST['alamat'];
$email = $_POST['email'];
$foto =$_POST['foto'];
$st_marital =$_POST['st_marital'];
$status_aktf = $_POST['status_aktf'];
$tlp = $_POST['tlp'];
$id_unit = $_POST['id_unit'];
$id_jabatan = $_POST['id_jabatan'];
$kd_bank = $_POST['kd_bank'];
$no_rek =$_POST['no_rek'];
$atas_nama = $_POST['atas_nama'];
$pend_akhir = $_POST['pend_akhir'];
$gol_darah = $_POST['gol_darah'];


include "../koneksi.php";
$simpan_rek = mysql_query ("INSERT INTO rekening VALUES ('$no_rek','$atas_nama', '$kd_bank' )");

$simpan = mysql_query ("INSERT INTO karyawan VALUES ('$nik','$nama','$tmp_lhr','$tgl_lhr','$jk','$tgl_masuk','$alamat',
	'$email','$foto','$st_marital','$status_aktf','$id_unit','$id_jabatan','$tlp','$no_rek', '$pend_akhir','$gol_darah')");
	
$simpan_username = mysql_query ("INSERT INTO login VALUES ('','$email', md5('$tgl_lhr'),'on', '$nik' )");
	echo mysql_error();				   
?> 

<script language="javascript">alert('Data Sudah Disimpan');
	window.location='tampil_karyawan.php';
	window.refresh(1);
</script>