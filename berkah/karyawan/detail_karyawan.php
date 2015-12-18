<?php
session_start();
if(!isset($_SESSION['username'])) {
header("Location: ../../index.php");
}
?>

<table  size="3" border="0">
<?php
	include"../koneksi.php";
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
		join bank on bank.kd_bank = rekening.kd_bank where nik='$_GET[id]'");
			
	while($data = mysql_fetch_array($query)) {
?> 

	<table>
		<tr>
			<td>DETAIL BIODATA KARYAWAN PT. BERKAH GROUP</td>
		</tr>
		<br><br>
		<tr>
			<td rowspan = "2">
			
				<table> <!---Table Kedua--->
					<tr>
						<td colspan="3"><center><align="top"><img src="<?php echo "gambar/$data[foto]"; ?>"width="120" height="120"/><br><br></center></td>
					</tr>
					<tr>
						<td>NIK</td>
						<td>:</td>
						<td><?php echo $data['nik']; ?></td>
					</tr>
					<tr>
						<td>Nama Pegawai</td>
						<td>:</td>
						<td><?php echo $data['nama']; ?></td>
					</tr>
					<tr>
						<td>Tempat, Tanggal Lahir</td>
						<td>:</td>
						<td><?php echo $data['tmp_lhr'];  ?>,<?php echo $data['tgl_lhr'];  ?></td>
					</tr>
					<tr>
						<td>Gender</td>
						<td>:</td>
						<td><?php echo $data['jk']; ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td>:</td>
						<td><?php echo $data['email']; ?></td>
					</tr>
					<tr>
						<td>Telepon</td>
						<td>:</td>
						<td><?php echo $data['tlp']; ?></td>
					</tr>
					<tr>
						<td>Tanggal Masuk</td>
						<td>:</td>
						<td><?php echo $data['tgl_masuk']; ?></td>
					</tr>
					<tr>
						<td>Status Pernikahan</td>
						<td>:</td>
						<td><?php echo $data['st_marital']; ?></td>
					</tr>
					<tr>
						<td>Unit</td>
						<td>:</td>
						<td><?php echo $data['nm_unit']; ?></td>
					</tr>
					<tr>
						<td>Jabatan</td>
						<td>:</td>
						<td><?php echo $data['nm_jabatan']; ?></td>
					</tr>
					<tr>
						<td>Nomor Rekening</td>
						<td>:</td>
						<td><?php echo $data['no_rek']; ?></td>
					</tr>
					<tr>
						<td>Atas Nama</td>
						<td>:</td>
						<td><?php echo $data['atas_nama']; ?></td>
					</tr>
					<tr>
						<td>Nama Bank</td>
						<td>:</td>
						<td><?php echo $data['nm_bank']; ?></td>
					</tr>
					<tr>
						<td>Status Keaktifan</td>
						<td>:</td>
						<td><?php echo $data['status_aktf']; ?></td>
					</tr>
					<tr>
						<td>Pendidikan Terakhir</td>
						<td>:</td>
						<td><?php echo $data['pend_akhir']; ?></td>
					</tr>
					<tr>
						<td>Golongan Darah</td>
						<td>:</td>
						<td><?php echo $data['gol_darah']; ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
		
<?php
	}
?>

</table>

<!-- Konten popup sampai disini--><a class="popup-close" href="tampil_karyawan.php"> Back[x]</a>