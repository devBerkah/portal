
<?php
session_start();
if(!isset($_SESSION['username'])) {
header("Location: ../../index.php");
}
?>


<?php
include"../koneksi.php";
  $user=$_SESSION['username'];
  $query = mysql_query("select * from login where username='$user'");
  $k=mysql_fetch_array($query);

   $nik=$k['nik'];

   $query1 = mysql_query("select karyawan.*, unit.nm_unit,
	jabatan.nm_jabatan from karyawan join unit on unit.id_unit = karyawan.id_unit
	join jabatan on jabatan.id_jabatan=karyawan.id_jabatan where nik= $nik");
  $l=mysql_fetch_array($query1);
   
 
?>


Selamat Datang, <font color="green" align="right"> <?php echo $l['nama']; ?>  , Anda Login sebagai <?php echo $l['nm_jabatan']; ?> </font> |  <a href="logout.php">Keluar</a></b></div><br>

<label><b>DATA KARYAWAN</b></label><br><br>


<?php 
	include"../koneksi.php";
	//pagging
	$per_hal=3;
	$jumlah_record=mysql_query("SELECT COUNT(*) from karyawan");
	$jum=mysql_result($jumlah_record, 0);
	$halaman=ceil($jum / $per_hal);
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start = ($page - 1) * $per_hal;
	echo "Jumlah karyawan : ".$jum." karyawan <br/>";
?>
<br>
<br>
<br>
<a href=<?php echo "karyawan.php"?>>Input</a>
<br>
<br>
<form action='tampil_karyawan.php' method='post' > 
	cari Berdasarkan<br>
	<select name="kategori">
		<option value=''>--Pilih Berdasarkan--</option>
		<option value="nik">NIK</option>
		<option value="nama">Nama</option>
	 </select>

	<input type="text" name="search" id="search" size="20"><input type="submit" name="submit" id="submit" value="cari">
 </form>

<table border='1'>
	<tr>
		<td>NIK</td>
		<td>Foto</td>
		<td>Nama Pegawai</td>
		<td>Tempat Lahir</td>
		<td>Tanggal Lahir</td>
		<td>Jenis Kelamin</td>
		<td>Alamat</td>
		<td>Email</td>
		<td>Status Aktif</td>
		<td>Unit</td>
		<td>Jabatan</td>
		<td>Aksi</td>
	</tr>
	
<?php
	extract($_POST);
	if ((isset($_POST['submit'])) AND ($_POST['search']) AND ($_POST['kategori'] == "nik")) {
		$search = $_POST['search'];
		$query = mysql_query("select karyawan.nik, karyawan.foto, karyawan.nama, 
		karyawan.tmp_lhr, 
		karyawan.tgl_lhr, 
		karyawan.jk, 
		karyawan.email, 
		karyawan.tlp, 
		karyawan.tgl_masuk, 
		karyawan.st_marital, 
		karyawan.no_rek,
		karyawan.pend_akhir,
		karyawan.gol_darah,
		karyawan.status_aktf,
		unit.nm_unit,
		jabatan.nm_jabatan,
		bank.nm_bank,
		rekening.atas_nama from karyawan join unit on unit.id_unit = karyawan.id_unit
		join jabatan on jabatan.id_jabatan=karyawan.id_jabatan
		join rekening on rekening.no_rek = karyawan.no_rek
		join bank on bank.kd_bank = rekening.kd_bank WHERE nik like '%$search%' order by nik ASC ") or die(mysql_error());
		$jumlah = mysql_num_rows($query); 
		if ($jumlah > 0) {
			echo '<p>Ada '.$jumlah.' data yang sesuai.</p>';
			$nomer=0;
		} 
	} else if ((isset($_POST['submit'])) AND ($_POST['search']) AND ($_POST['kategori'] == "nama")){
		$search = $_POST['search'];
		$query = mysql_query("select karyawan.nik, karyawan.foto, karyawan.nama, 
		karyawan.tmp_lhr, 
		karyawan.tgl_lhr, 
		karyawan.jk, 
		karyawan.email, 
		karyawan.tlp, 
		karyawan.tgl_masuk, 
		karyawan.st_marital, 
		karyawan.no_rek,
		karyawan.pend_akhir,
		karyawan.gol_darah,
		karyawan.status_aktf,
		unit.nm_unit,
		jabatan.nm_jabatan,
		bank.nm_bank,
		rekening.atas_nama from karyawan join unit on unit.id_unit = karyawan.id_unit
		join jabatan on jabatan.id_jabatan=karyawan.id_jabatan
		join rekening on rekening.no_rek = karyawan.no_rek
		join bank on bank.kd_bank = rekening.kd_bank WHERE nama like '%$search%' order by nik ASC ") or die(mysql_error());
		$jumlah = mysql_num_rows($query); 
		if ($jumlah > 0) {
			echo '<p>Ada '.$jumlah.' data yang sesuai.</p>';
			$nomer=0;
		}
	} else {
		$query = mysql_query("select karyawan.nik, karyawan.foto, karyawan.nama, 
		karyawan.tmp_lhr, 
		karyawan.tgl_lhr, 
		karyawan.jk, 
		karyawan.alamat, 
		karyawan.email, 
		karyawan.tlp, 
		karyawan.tgl_masuk, 
		karyawan.st_marital, 
		karyawan.no_rek,
		karyawan.pend_akhir,
		karyawan.gol_darah,
		karyawan.status_aktf,
		unit.nm_unit,
		jabatan.nm_jabatan,
		bank.nm_bank,
		rekening.atas_nama from karyawan join unit on unit.id_unit = karyawan.id_unit
		join jabatan on jabatan.id_jabatan=karyawan.id_jabatan
		join rekening on rekening.no_rek = karyawan.no_rek
		join bank on bank.kd_bank = rekening.kd_bank order by nik ASC ");
	}
	while($data = mysql_fetch_array($query)) {
	?>
	<tr>
		<td><?php echo $data['nik']; ?></td>
		<td><img src="<?php echo "gambar/$data[foto]"; ?>"width="60" height="60"/></td>
		<td><?php echo $data['nama']; ?><?php  ?></td>
		<td><?php echo $data['tmp_lhr']; ?><?php  ?></td>
		<td><?php echo $data['tgl_lhr']; ?><?php  ?></td>
		<td><?php echo $data['jk']; ?><?php  ?></td>
		<td><?php echo $data['alamat']; ?><?php  ?></td>
		<td><?php echo $data['email']; ?><?php  ?></td>
		<td><?php echo $data['status_aktf']; ?><?php  ?></td>
		<td><?php echo $data['nm_unit']; ?><?php  ?></td>
		<td><?php echo $data['nm_jabatan']; ?><?php  ?></td>
		<td><a href=<?php echo "detail_karyawan.php?id=$data[0]"?>>Detail</a> &nbsp;<a href=<?php echo "edit.php?id=$data[0]"?>>Edit</a>&nbsp;<a href=<?php echo "hapus.php?id=$data[0]"?> onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Hapus</a></td>
	</tr>
	<?php
	}
	?>
	</tr></table>