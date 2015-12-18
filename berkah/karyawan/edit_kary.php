<?php
include "../koneksi.php";
$edit = mysql_query("SELECT karyawan.nik, karyawan.nama, karyawan.tmp_lhr, karyawan.tgl_lhr, karyawan.jk, karyawan.tgl_masuk, karyawan.alamat, karyawan.email, karyawan.foto, karyawan.st_marital, karyawan.status_aktf, karyawan.tlp, karyawan.pend_akhir, karyawan.gol_darah, unit.nm_unit, jabatan.nm_jabatan, karyawan.no_rek, bank.nm_bank, rekening.atas_nama from karyawan join unit on karyawan.id_unit = unit.id_unit join jabatan on karyawan.id_jabatan = jabatan.id_jabatan join rekening on karyawan.no_rek = rekening.no_rek join bank on rekening.kd_bank = bank.kd_bank where karyawan.nik='$_GET[id]'");
	$r=mysql_fetch_array($edit);

$lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(000000,999999);
  $nama_file_unik = $acak.$nama_file; 

  $no_rek=$_POST['no_rek'];
  $atas_nama=$_POST['atas_nama'];
  $kd_bank=$_POST['kd_bank'];
  $nik=$_POST['nik'];
  $nama=$_POST['nama'];
  $tmp_lhr=$_POST['tmp_lhr'];
  $jk=$_POST['jk'];
  $tgl_masuk=$_POST['tgl_masuk'];
  $alamat=$_POST['alamat'];
  $email=$_POST['email'];
  $foto=$_POST['foto'];
  $st_marital=$_POST['st_marital'];
  $status_aktf=$_POST['status_aktf'];
  $tlp=$_POST['tlp'];
  $pend_akhir=$_POST['pend_akhir'];
  $gol_darah=$_POST['gol_darah'];
  
 
  
  $a=mysql_query("UPDATE rekening SET no_rek = '$no_rek', atas_nama = '$atas_nama', kd_bank = '$kd_bank' where no_rek = '$r[no_rek]'") or die (mysql_error());
   
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
									alamat = '$alamat', 
									email = '$email',
									st_marital 	= '$st_marital',
									status_aktf = '$status_aktf',
									tlp 	= '$tlp',
									pend_akhir 	= '$pend_akhir',
									gol_darah 	= '$gol_darah'
									WHERE nik   = '123'") or die (mysql_error());
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
									alamat = '$alamat', 
									email = '$email',
									st_marital 	= '$st_marital',
									status_aktf 	= '$status_aktf',
									tlp 	= '$tlp',
									foto 	= '$nama_file_unik',
									pend_akhir 	= '$pend_akhir',
									gol_darah 	= '$gol_darah'
								WHERE nik   = '$_GET[id]'")  or die (mysql_error());
		echo "<script>window.alert('Berhasil di upload');
				window.location='tampil_karyawan.php';window.refresh(1);";
	}
	}
  
  
  ?>