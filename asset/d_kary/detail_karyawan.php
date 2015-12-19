<table  size="3" border="0">
<?php
	include"../koneksi.php";
	$query = mysql_query("SELECT karyawan.*, unit.nm_unit, jabatan.nm_jabatan from karyawan join unit on karyawan.id_unit = unit.id_unit join jabatan on karyawan.id_jabatan = jabatan.id_jabatan where nik='$_GET[id]'");
			
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
					<tr>
						<td>No KTP</td>
						<td>:</td>
						<td><?php echo $data['no_ktp']; ?></td>
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