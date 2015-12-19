<?php
	include "../koneksi.php";
	$edit = mysql_query("SELECT karyawan.*, unit.nm_unit, jabatan.nm_jabatan from karyawan join unit on karyawan.id_unit = unit.id_unit join jabatan on karyawan.id_jabatan = jabatan.id_jabatan where karyawan.nik='$_GET[id]'");
	$edit1 = mysql_query("select rekening.no_rek, rekening.atas_nama, bank.kd_bank from rekening join bank on rekening.kd_bank = bank.kd_bank where nik='$_GET[id]'");
	$r=mysql_fetch_array($edit);
	$s=mysql_fetch_array($edit1);
echo"
	<html>
		<head>
			<title>Edit Data Karyawan</title>
		</head>

		<form action='edit_kary.php' method='post'>
		<div>
			<label><b>Edit Data Karyawan</b></label>
		</div>
		<div>
			<label>NIK</label>
			<input type='text' name='nik' readonly  value=$r[nik]>
		</div>
		<div>
			<label>Nama</label>
			<input type='text' name='nama' value=$r[nama]>
		</div>
		<div>
			<label>Tempat Lahir</label>
			<input type='text' name='tmp_lhr' value=$r[tmp_lhr]>
		</div>
		<div>
			<label>Tempat Lahir</label>
			<input type='text' name='tgl_lhr' value=$r[tgl_lhr]>
		</div>
		<div>
			<label>Jenis Kelamin</label>
			<select name='jk'>";
				if ($r[jk]==''){
					echo "<option value=0 selected>- Pilih Kategori -</option>
						  <option value='Perempuan'>Perempuan</option>
					  	  <option value='Laki-laki'>Laki-laki</option>";
				} else if ($r[jk]=='Perempuan'){
					echo "<option value='Perempuan' selected>Perempuan</option>
					  	  <option value='Laki-laki'>Laki-laki</option>";
				} else if ($r[jk]=='Laki-laki'){
					echo "<option value='Perempuan' >Perempuan</option>
 						  <option value='Laki-laki' selected>Laki-laki</option>";
				} 
			echo "</select>
		</div>
		<div>
			<label>Agama</label>
			<select name='agama'>";
				if ($r[agama]==''){
					echo "<option value='' selected>- Pilih Kategori -</option>
						  <option value='Islam'>Islam</option>
						  <option value='Kristen'>Kristen</option>
						  <option value='Budha'>Budha</option>
						  <option value='Hindu'>Hindu</option>";
				} else if ($r[agama]=='Islam'){
					echo "<option value=''>- Pilih Kategori -</option>
						  <option value='Islam' selected>Islam</option>
						  <option value='Kristen'>Kristen</option>
						  <option value='Budha'>Budha</option>
						  <option value='Hindu'>Hindu</option>";
				} else if ($r[agama]=='Kristen'){
					echo "<option value=''>- Pilih Kategori -</option>
						  <option value='Islam' >Islam</option>
						  <option value='Kristen' selected>Kristen</option>
						  <option value='Budha'>Budha</option>
						  <option value='Hindu'>Hindu</option>";
				} else if ($r[agama]=='Budha'){
					echo "<option value=''>- Pilih Kategori -</option>
						  <option value='Islam'>Islam</option>
						  <option value='Kristen'>Kristen</option>
						  <option value='Budha' selected>Budha</option>
						  <option value='Hindu'>Hindu</option>";
				} else if ($r[agama]=='Hindu'){
					echo "<option value=''>- Pilih Kategori -</option>
						  <option value='Islam'>Islam</option>
						  <option value='Kristen' >Kristen</option>
						  <option value='Budha'>Budha</option>
						  <option value='Hindu' selected>Hindu</option>";
				}
			echo "</select>
		</div><div>
			<label>Tanggal Masuk</label>
			<input type='date' name='tgl_masuk' value=$r[tgl_masuk]>
		</div>
		<div>
			<label>Alamat:</label><br>
			&nbsp <label>Kelurahan</label>
			<input type='text' name='kel'><br>
			&nbsp <label>Kecamatan</label>
			<input type='text' name='kec'><br>
			&nbsp <label>Kota/Kabupaten</label>
			<input type='text' name='kota>
		</div>
		<div>
			<label>Email</label>
			<input type='text' name='email' value=$r[email]>
		</div>
		<div>
			<label>Foto</label>
			<input type='file' name='foto' value=$r[foto]>
		</div>
		<div>
			<label>Status Martial</label>
			<select name='st_marital'>";
				if ($r[st_marital]=='Menikah'){
					echo"<option value='Menikah' selected>Menikah</option>
				 		 <option value='Belum Menikah'>Belum Menikah</option>";
				} else if ($r[st_marital]=='Belum Menikah'){ 
					echo "<option value='Menikah'>Menikah</option>
						  <option value='Belum Menikah' selected>Belum Menikah</option>";
				} else {
					echo "<option value='Menikah'>Menikah</option>
						  <option value='Belum Menikah'>Belum Menikah</option>";
				}
		echo"</select>
		</div>
		<div>
			<label>Status Aktif</label>
			<select name='status_aktf' value=$r[status_aktf]>";
				if ($r[status_aktf]=='Aktif'){
					echo"<option value='Aktif' selected>Aktif</option>
							<option value='Tidak Aktif'>Tidak Aktif</option>
							<option value='Cuti'>Cuti</option>
							<option value='Baru'>Baru</option>";
					} if($r[status_aktf]=='Tidak Aktif'){
							echo"<option value='Aktif'>Aktif</option>
							<option value='Tidak Aktif' selected>Tidak Aktif</option>
							<option value='Cuti'>Cuti</option>
							<option value='Baru'>Baru</option>";
					} if($r[status_aktf]=='Cuti'){
							echo"<option value='Aktif'>Aktif</option>
							<option value='Tidak Aktif'>Tidak Aktif</option>
							<option value='Cuti' selected>Cuti</option>
							<option value='Baru'>Baru</option>";
					} else if($r[status_aktf]=='Baru'){ 
						echo"<option value='Aktif'>Aktif</option>
							<option value='Tidak Aktif'>Tidak Aktif</option>
							<option value='Cuti' >Cuti</option>
							<option value='Baru' selected>Baru</option>";
					} else if ($r[status_aktf]==''){
						echo"<option value='Aktif'>Aktif</option>
							<option value='Tidak Aktif'>Tidak Aktif</option>
							<option value='Cuti'>Cuti</option>
							<option value='Baru'>Baru</option>";
					}
		echo"</select>												
		</div>
		<div>
			<label>No Telepon</label>
			<input type='text' name='tlp' value=$r[tlp]>
		</div>
		<div>
			<label>Unit</label>
			<input type='text' name='id_unit' value='$r[nm_unit]' readonly>
		</div> 

		<div>
			<label>Jabatan</label>
			<input type='text' name='id_jabatan' value='$r[nm_jabatan]' readonly>
		</div>
		<div>
			<label>Bank</label>
			<select name='kd_bank' required='required'>
					<option value=''>- Pilih Bank -</option>";
						$sql = mysql_query('SELECT * FROM bank ORDER BY nm_bank ASC');
						while($row = mysql_fetch_array($sql)){
							if ($s[kd_bank]==$row[kd_bank]){
							echo "<option value='$row[kd_bank]' selected>$row[nm_bank]</option>";
							} else{
								echo "<option value='$row[kd_bank]' selected>$row[nm_bank]</option>";
							}
						}
			echo"</select> 
		</div>
		<div>
			<label>No Rekening</label>
			<input type='text' name='no_rek' value=$s[no_rek]>
		</div>
		<div>
			<label>Nama Rekening</label>
			<input type='text' name='atas_nama' value=$s[atas_nama]>
		</div>
		<div>
			<label>Pendidikan Terakhir</label>
			<select name='pend_akhir' value=$r[pend_akhir]>";
					if ($r[pend_akhir]=='SMA/SMK'){
						echo"<option value='SMA/SMK' selected>SMA/SMK</option>
							<option value='D1'>D1</option>
							<option value='D3'>D3</option>
							<option value='S1'>S1</option>
							<option value='S2'>S2</option>
							<option value='S3'>S3</option>";
					} else if($r[pend_akhir]=='D1'){
							echo"<<option value='SMA/SMK'>SMA/SMK</option>
							<option value='D1' selected>D1</option>
							<option value='D3'>D3</option>
							<option value='S1'>S1</option>
							<option value='S2'>S2</option>
							<option value='S3'>S3</option>";
					} else if($r[pend_akhir]=='D3'){
							echo"<option value='SMA/SMK'>SMA/SMK</option>
							<option value='D1'>D1</option>
							<option value='D3' selected>D3</option>
							<option value='S1'>S1</option>
							<option value='S2'>S2</option>
							<option value='S3'>S3</option>";
					} else if($r[pend_akhir]=='S1'){
							echo"<option value='SMA/SMK'>SMA/SMK</option>
							<option value='D1'>D1</option>
							<option value='D3'>D3</option>
							<option value='S1' selected>S1</option>
							<option value='S2'>S2</option>
							<option value='S3'>S3</option>";
					} else if($r[pend_akhir]=='S2'){ 
						echo"<option value='SMA/SMK'>SMA/SMK</option>
							<option value='D1'>D1</option>
							<option value='D3'>D3</option>
							<option value='S1'>S1</option>
							<option value='S2' selected>S2</option>
							<option value='S3'>S3</option>";
					} else if($r[pend_akhir]=='S3'){ 
						echo"<option value='SMA/SMK'>SMA/SMK</option>
							<option value='D1'>D1</option>
							<option value='D3'>D3</option>
							<option value='S1'>S1</option>
							<option value='S2'>S2</option>
							<option value='S3'  selected>S3</option>";
					} else { 
						echo"<option value='SMA/SMK'>SMA/SMK</option>
							<option value='D1'>D1</option>
							<option value='D3'>D3</option>
							<option value='S1'>S1</option>
							<option value='S2'>S2</option>
							<option value='S3'>S3</option>";
					}
		echo"</select>												
		</div>
		<div>
			<label>Golongan Darah</label>
			<select name='gol_darah' value=$r[gol_darah]>";
					if ($r[gol_darah]=='A'){
						echo"<option value='A' selected>A</option>
							<option value='B'>B</option>
							<option value='AB'>AB</option>
							<option value='O'>O</option>";
					} if($r[gol_darah]=='B'){
							echo"<option value='A'>A</option>
							<option value='B' selected>B</option>
							<option value='AB'>AB</option>
							<option value='O'>O</option>";
					} if($r[gol_darah]=='AB'){
							echo"<option value='A'>A</option>
							<option value='B'>B</option>
							<option value='AB' selected>AB</option>
							<option value='O'>O</option>";
					} else if($r[gol_darah]=='O'){ 
						echo"<option value='A'>A</option>
							<option value='B'>B</option>
							<option value='AB'>AB</option>
							<option value='O' selected>O</option>";
					} else { 
						echo"<option value='A'>A</option>
							<option value='B'>B</option>
							<option value='AB'>AB</option>
							<option value='O'>O</option>";
						}
		echo"</select>												
		</div>
		<div>
			<label>No KTP</label>
			<input type='text' name='no_ktp' value=$r[no_ktp]>
		</div>
		<div>
			<label>Saldo</label>
			<input type='text' name='saldo' value=$r[saldo_awal]>
		</div>
		<div>
			<label>&nbsp;</label>
			<label><input type=submit name=submit value=Edit><input type=reset name=reset value=Batal></label>
		</div>
		</table>
		</form>
	</html>";
?>