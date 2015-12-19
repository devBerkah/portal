<?php
include "../koneksi.php";
$edit = mysql_query("SELECT karyawan.*, unit.nm_unit, jabatan.nm_jabatan from karyawan join unit on karyawan.id_unit = unit.id_unit join jabatan on karyawan.id_jabatan = jabatan.id_jabatan where karyawan.nik='$_GET[id]'");
	$r=mysql_fetch_array($edit);

$lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(000000,999999);
  $nama_file_unik = $acak.$nama_file; 

$nama = $_POST['nama'];
$tmp_lhr = $_POST['tmp_lhr'];
$tgl_lhr = $_POST['tgl_lhr'];
$jk = $_POST['jk'];
$tgl_masuk = $_POST['tgl_masuk'];
$kel = $_POST['kel'];
$kec = $_POST['kec'];
$kota = $_POST['kota'];
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
$agama = $_POST['agama'];
$no_ktp = $_POST['no_ktp'];
$saldo = $_POST['saldo'];
 
  
  $a=mysql_query("UPDATE rekening SET no_rek = '$no_rek', atas_nama = '$atas_nama', kd_bank = '$kd_bank' where nik = '$r[nik]'") or die (mysql_error());
   
   if($a){
				echo"
				<script type='text/javascript'>
				window.alert('Data Berhasil Diubah');
				window.location='tampil_karyawan.php';
				window.refresh(1);
				</script>";
			} else {
				echo "<script type='text/javascript'>
				window.alert('Data Gagal Diubah');
				window.location='tampil_karyawan.php';
				window.refresh(1);
				</script>";
			}

   
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
									WHERE nik   = '$_GET[id]'") or die (mysql_error());
	if($b){
				echo"
				<script type='text/javascript'>
				window.alert('Data Berhasil Diubah');
				window.location='tampil_karyawan.php';
				window.refresh(1);
				</script>";
			} else {
				echo "<script type='text/javascript'>
				window.alert('Data Gagal Diubah');
				window.location='tampil_karyawan.php';
				window.refresh(1);
				</script>";
			}
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
									
								WHERE nik   = '$_GET[id]'")  or die (mysql_error());
		echo "<script>window.alert('Berhasil di upload');
				window.location='tampil_karyawan.php';window.refresh(1);";
	}
	}
  
  
  ?>