<?php
include "../../include/koneksi.php";
$nik = htmlspecialchars(mysql_escape_string($_POST['nik']));  
$edit = mysql_query("SELECT karyawan.*, unit.nm_unit, jabatan.nm_jabatan from karyawan join unit on karyawan.id_unit = unit.id_unit join jabatan on karyawan.id_jabatan = jabatan.id_jabatan where karyawan.nik='$nik'");
	$r=mysql_fetch_array($edit);
$edit1 = mysql_query("SELECT rekening.*, bank.nm_bank from rekening join bank on rekening.kd_bank = bank.kd_bank where nik='$nik'");
	
$lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(000000,999999);
  $nama_file_unik = $acak.$nama_file; 
  


$nama = htmlspecialchars(mysql_escape_string($_POST['nama']));
$tmp_lhr = htmlspecialchars(mysql_escape_string($_POST['tmp_lhr']));
$tgl_lhr = htmlspecialchars(mysql_escape_string($_POST['tgl_lhr']));
$jk = htmlspecialchars(mysql_escape_string($_POST['jk']));
$tgl_masuk = htmlspecialchars(mysql_escape_string($_POST['tgl_masuk']));
$kel = htmlspecialchars(mysql_escape_string($_POST['kel']));
$kec = htmlspecialchars(mysql_escape_string($_POST['kec']));
$kota = htmlspecialchars(mysql_escape_string($_POST['kota']));
$email = htmlspecialchars(mysql_escape_string($_POST['email']));
$foto = htmlspecialchars(mysql_escape_string($_POST['foto']));
$st_marital = htmlspecialchars(mysql_escape_string($_POST['st_marital']));
$status_aktf = htmlspecialchars(mysql_escape_string($_POST['status_aktf']));
$tlp = htmlspecialchars(mysql_escape_string($_POST['tlp']));
$id_unit = htmlspecialchars(mysql_escape_string($_POST['id_unit']));
$id_jabatan = htmlspecialchars(mysql_escape_string($_POST['id_jabatan']));
$kd_bank = htmlspecialchars(mysql_escape_string($_POST['kd_bank']));
$no_rek = htmlspecialchars(mysql_escape_string($_POST['no_rek']));
$atas_nama = htmlspecialchars(mysql_escape_string($_POST['atas_nama']));
$pend_akhir = htmlspecialchars(mysql_escape_string($_POST['pend_akhir']));
$gol_darah = htmlspecialchars(mysql_escape_string($_POST['gol_darah']));
$agama = htmlspecialchars(mysql_escape_string($_POST['agama']));
$no_ktp = htmlspecialchars(mysql_escape_string($_POST['no_ktp']));
$saldo = htmlspecialchars(mysql_escape_string($_POST['saldo']));
 
 //Apabila gambar tidak diganti
  if (empty($lokasi_file)){
    $b=mysql_query("UPDATE karyawan SET nama = '$nama',
									tmp_lhr = '$tmp_lhr',
									jk = '$jk',
									tgl_masuk = '$tgl_masuk',
									agama = '$agama', 
									kel = '$kel', 
									kec = '$kec', 
									kota = '$kota', 
									email = '$email',
									st_marital 	= '$st_marital',
									status_aktf = '$status_aktf',
									tlp 	= '$tlp',
									pend_akhir 	= '$pend_akhir',
									no_ktp 	= '$no_ktp',
									saldo_awal 	= '$saldo_awal',
									gol_darah 	= '$gol_darah'
									WHERE nik   = '$nik'") or die (mysql_error());
  }
  else{
    if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
    echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
        window.location='tampil_karyawan.php';window.refresh(1);</script>";
    }
    else{
    UploadGallery($nama_file_unik);
    mysql_query("UPDATE karyawan SET nama = '$nama',
									tmp_lhr = '$tmp_lhr',
									jk = '$jk',
									tgl_masuk = '$tgl_masuk',
									agama = '$agama', 
									kel = '$kel', 
									kec = '$kec', 
									kota = '$kota', 
									email = '$email',
									st_marital 	= '$st_marital',
									status_aktf = '$status_aktf',
									tlp 	= '$tlp',
									pend_akhir 	= '$pend_akhir',
									no_ktp 	= '$no_ktp',
									saldo_awal 	= '$saldo_awal',
									gol_darah 	= '$gol_darah',
									foto 	= '$nama_file_unik'
									
								WHERE nik   = '$nik'")  or die (mysql_error());
	}
	}

  
  $a=mysql_query("UPDATE rekening SET no_rek = '$no_rek', atas_nama = '$atas_nama', kd_bank = '$kd_bank' where nik = '$nik'") or die (mysql_error());
   	
  ?>
  
  <script language="javascript">alert('Data Sudah Disimpan');
	window.location='karyawan';
	window.refresh(1);
</script>