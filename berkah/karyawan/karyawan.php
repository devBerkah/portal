<?php
	include "../koneksi.php";
?>
<html>
	<head>
		<title>Input Data Karyawan</title>
	</head>
	
	<form action="save_kary.php" method="post">
		<div>
			<label>Input Data Karyawan<label>
		</div>
		
		<div>
			<label>NIK</label>
			<input type="text" name="nik">
		</div>
		<div>
			<label>Nama</label>
			<input type="text" name="nama">
		</div>
		<div>
			<label>Tempat Lahir</label>
			<input type="text" name="tmp_lhr">
		</div>
		<div>
			<label>Tanggal Lahir</label>
			<input type="date" name="tgl_lhr">
		</div>
		<div>
			<label>Jenis Kelamin</label>
			<select name="jk"><option>--Pilih Jenis Kelamin--</option>
				<option value="Laki-Laki">Laki-laki</option>
				<option value="Perempuan">Perempuan</option>
			</select>
		</div>
		<div>
			<label>Tanggal Masuk</label>
			<input type="date" name="tgl_masuk">
		</div>
		<div>
			<label>Alamat</label>
			<textarea name="alamat"></textarea>
		</div>
		<div>
			<label>Email</label>
			<input type="text" name="email">
		</div>
		<div>
			<label>Foto</label>
			<input type="file" name="foto">
		</div>
		<div>
			<label>Status Martial</label>
			<select name="st_marital"><option>--Pilih Status Martial--</option>
				<option value="Menikah">Menikah</option>
				<option value="Belum Menikah">Belum Menikah</option>
			</select>
		</div>
		<div>
			<label>Status Aktif</label>
			<select name="status_aktf"><option>--Pilih Status Aktif--</option>
				<option value="Aktif">Aktif</option>
				<option value="Tidak Aktif">Tidak Aktif</option>
				<option value="Cuti">Cuti</option>
				<option value="Baru">Baru</option>
			</select>
		</div>
		<div>
			<label>No Telepon</label>
			<input type="text" name="tlp">
		</div>
		<div>
			<label>Unit</label>
			<select name="id_unit"><option>--Pilih Unit--</option>
				<?php
					$sql = mysql_query('SELECT * FROM unit ORDER BY nm_unit ASC');
					while($row = mysql_fetch_array($sql)){
						echo "<option value='$row[id_unit]' required='required'>$row[nm_unit]</option>";
					}
				  ?>
			</select></label>
		</div> 
		<div>
			<label>Jabatan</label>
			<select name="id_jabatan"><option>--Pilih Jabatan--</option>
				<?php
					$sql = mysql_query('SELECT * FROM jabatan ORDER BY nm_jabatan ASC');
					while($row = mysql_fetch_array($sql)){
						echo "<option value='$row[id_jabatan]' required='required'>$row[nm_jabatan]</option>";
					}
				?>
			</select></label>
		</div>
		<div>
			<label>Bank</label>
			<select name="kd_bank"><option>--Pilih Bank--</option>
				<?php
					$sql = mysql_query('SELECT * FROM bank ORDER BY nm_bank ASC');
					while($row = mysql_fetch_array($sql)){
						echo "<option value='$row[kd_bank]' required='required'>$row[nm_bank]</option>";
					}
				?>
			</select></label>
		</div>
		<div>
			<label>No Rekening</label>
			<input type="text" name="no_rek">
		</div>
		<div>
			<label>Nama Rekening</label>
			<input type="text" name="atas_nama">
		</div>
		<div>
			<label>Pendidikan Terakhir</label>
			<select name="pend_akhir"><option>-Pilih Pendidikan Terakhir--</option>
				<option value="SMA/SMK">SMA/SMK</option>
				<option value="D1">D1</option>
				<option value="D3">D3</option>
				<option value="S1">S1</option>
				<option value="S2">S2</option>
				<option value="S3">S3</option>
			</select>
		</div>
		<div>
			<label>Golongan Darah</label>
			<select name="gol_darah"><option>--Pilih Golongan Darah--</option>
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="AB">AB</option>
				<option value="O">O</option>
			</select></label>
		</div>
		<div>
			<label>&nbsp;</label>
			<input type=submit name=submit value=Simpan><input type=reset name=reset value=Batal>
		</div>
	</form>
</html>
