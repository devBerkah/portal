<?php
include "../../include/koneksi.php";
$id=htmlspecialchars(mysql_escape_string($_GET[id]));
	$edit = mysql_query("SELECT karyawan.*, unit.nm_unit, jabatan.nm_jabatan from karyawan join unit on karyawan.id_unit = unit.id_unit join jabatan on karyawan.id_jabatan = jabatan.id_jabatan where md5(karyawan.nik)='$id'") or die (mysql_error(0));
	$edit1 = mysql_query("select rekening.no_rek, rekening.atas_nama, bank.kd_bank from rekening join bank on rekening.kd_bank = bank.kd_bank where md5(nik)='$id'") or die (mysql_error(0));
	$r=mysql_fetch_array($edit);
	$s=mysql_fetch_array($edit1);?>
	
	<div class="headbox">
    <label><i class="fa fa-plus-circle"></i> Edit Data Karyawan<label>
            </div>

            <form action='update-karyawan' method='post'>
				<div class='formbox'>
					<label>NIK</label>
					<input type='text' name='nik' readonly  value='<?php echo "$r[nik]";?>'  class='inp-sm'>
				</div>
                <div class="formbox">
                    <label>Nama</label>
                    <input type="text" name="nama" class="inp-sm" required='required' value='<?php echo "$r[nama]";?>'>
                </div>
                <div class="formbox">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tmp_lhr" required='required' value='<?php echo "$r[tmp_lhr]";?>'>
                </div>
                <div class="formbox">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tgl_lhr" required='required' value='<?php echo "$r[tgl_lhr]"; ?>'>
                </div>
                <div class="formbox">
                    <label>Jenis Kelamin</label>
                    <select name="jk" required='required'>
					<?php
						if ($r[jk]==''){
							echo "<option value=0 selected>- Pilih Jenis Kelamin -</option>
								  <option value='Perempuan'>Perempuan</option>
								  <option value='Laki-laki'>Laki-laki</option>";
						} else if ($r[jk]=='Perempuan'){
							echo "<option value='Perempuan' selected>Perempuan</option>
								  <option value='Laki-laki'>Laki-laki</option>";
						} else if ($r[jk]=='Laki-laki'){
							echo "<option value='Perempuan' >Perempuan</option>
								  <option value='Laki-laki' selected>Laki-laki</option>";
						} 
					?> 
                    </select>
                </div>
                <div class="formbox">
                    <label>Agama</label>
                    <select name="agama" required='required'>
					<?php
						if ($r[agama]==''){
							echo "<option value='' selected>- Pilih Agama -</option>
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
					?>
                    </select>
                </div>
                <div class="formbox">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tgl_masuk" required='required' value='<?php echo "$r[tgl_masuk]"; ?>'>
                </div>
                <div class="formbox-grup">
                    <label>Alamat</label>
                    <label>Kelurahan</label>
                    <input type="text" name="kel" required='required' value='<?php echo "$r[kel]"; ?>'>
                    <label>Kecamatan</label>
                    <input type="text" name="kec" required='required' value='<?php echo "$r[kec]"; ?>'>
                    <label>Kota/Kabupaten</label>
                    <input type="text" name="kota" required='required' value='<?php echo "$r[kota]"; ?>'>
                </div>
                <div class="formbox">
                    <label>Email</label>
                    <input type="text" name="email" required='required' value='<?php echo "$r[email]"; ?>'>
                </div>
                <div class="formbox">
                    <label>Foto</label>
                    <input type="file" name="foto" required='required' value='<?php echo "$r[foto]"; ?>'>
                </div>
                <div class="formbox">
                    <label>Status Martial</label>
                    <select name="st_marital" required='required'>
					<?php
						if ($r[st_marital]=='Menikah'){
							echo"<option>--Pilih Status Martial--</option>
								 <option value='Menikah' selected>Menikah</option>
								 <option value='Belum Menikah'>Belum Menikah</option>";
						} else if ($r[st_marital]=='Belum Menikah'){ 
							echo "<option>--Pilih Status Martial--</option>
								  <option value='Menikah'>Menikah</option>
								  <option value='Belum Menikah' selected>Belum Menikah</option>";
						} else {
							echo "<option>--Pilih Status Martial--</option>
								  <option value='Menikah'>Menikah</option>
								  <option value='Belum Menikah'>Belum Menikah</option>";
						}
					?>
                    </select>
                </div>
                <div class="formbox">
                    <label>Status Aktif</label>
                    <select name="status_aktf" required='required'>
					<?php
						if ($r[status_aktf]=='Aktif'){
							echo"<option>--Pilih Status Aktif--</option>
									<option value='Aktif' selected>Aktif</option>
									<option value='Tidak Aktif'>Tidak Aktif</option>
									<option value='Cuti'>Cuti</option>
									<option value='Baru'>Baru</option>";
							} if($r[status_aktf]=='Tidak Aktif'){
									echo"<option>--Pilih Status Aktif--</option>
									<option value='Aktif'>Aktif</option>
									<option value='Tidak Aktif' selected>Tidak Aktif</option>
									<option value='Cuti'>Cuti</option>
									<option value='Baru'>Baru</option>";
							} if($r[status_aktf]=='Cuti'){
									echo"<option>--Pilih Status Aktif--</option>
									<option value='Aktif'>Aktif</option>
									<option value='Tidak Aktif'>Tidak Aktif</option>
									<option value='Cuti' selected>Cuti</option>
									<option value='Baru'>Baru</option>";
							} else if($r[status_aktf]=='Baru'){ 
								echo"<option>--Pilih Status Aktif--</option>
									<option value='Aktif'>Aktif</option>
									<option value='Tidak Aktif'>Tidak Aktif</option>
									<option value='Cuti' >Cuti</option>
									<option value='Baru' selected>Baru</option>";
							} else if ($r[status_aktf]==''){
								echo"<option>--Pilih Status Aktif--</option>
									<option value='Aktif'>Aktif</option>
									<option value='Tidak Aktif'>Tidak Aktif</option>
									<option value='Cuti'>Cuti</option>
									<option value='Baru'>Baru</option>";
							}
					?>
                    </select>
                </div>
                <div class="formbox">
                    <label>No Telepon</label>
                    <input type="text" name="tlp" required='required' value='<?php echo "$r[tlp]"; ?>'>
                </div>
                <div class="formbox">
                    <label>Unit</label>
                    <input type='text' name='id_unit' value='<?php echo "$r[nm_unit]"; ?>' readonly>
                </div> 
                <div class="formbox">
                    <label>Jabatan</label>
                    <input type='text' name='id_jabatan' value='<?php echo "$r[nm_jabatan]"; ?>' readonly>
                </div>
                <div class="formbox">
                    <label>Bank</label>
                    <select name='kd_bank' required='required'>
					<option value=''>- Pilih Bank -</option>
					<?php
						$sql = mysql_query('SELECT * FROM bank ORDER BY nm_bank ASC');
						while($row = mysql_fetch_array($sql)){
							if ($s[kd_bank]==$row[kd_bank]){
							echo "<option value='$row[kd_bank]' selected>$row[nm_bank]</option>";
							} else{
								echo "<option value='$row[kd_bank]' selected>$row[nm_bank]</option>";
							}
						}
					?></select> 
                </div>
                <div class="formbox">
                    <label>No Rekening</label>
                    <input type="text" name="no_rek" required='required' value='<?php echo "$s[no_rek]";?>'>
                </div>
                <div class="formbox">
                    <label>Nama Rekening</label>
                    <input type="text" name="atas_nama" required='required' value='<?php echo "$s[atas_nama]"; ?>'>
                </div>
                <div class="formbox">
                    <label>Pendidikan Terakhir</label>
                    <select name="pend_akhir" required='required'>
					<?php
						if ($r[pend_akhir]=='SMA/SMK'){
							echo"<option>--Pilih Pendidikan Terakhir--</option>
								<option value='SMA/SMK' selected>SMA/SMK</option>
								<option value='D1'>D1</option>
								<option value='D3'>D3</option>
								<option value='S1'>S1</option>
								<option value='S2'>S2</option>
								<option value='S3'>S3</option>";
						} else if($r[pend_akhir]=='D1'){
								echo"<option>--Pilih Pendidikan Terakhir--</option>
								<option value='SMA/SMK'>SMA/SMK</option>
								<option value='D1' selected>D1</option>
								<option value='D3'>D3</option>
								<option value='S1'>S1</option>
								<option value='S2'>S2</option>
								<option value='S3'>S3</option>";
						} else if($r[pend_akhir]=='D3'){
								echo"<option>--Pilih Pendidikan Terakhir--</option>
								<option value='SMA/SMK'>SMA/SMK</option>
								<option value='D1'>D1</option>
								<option value='D3' selected>D3</option>
								<option value='S1'>S1</option>
								<option value='S2'>S2</option>
								<option value='S3'>S3</option>";
						} else if($r[pend_akhir]=='S1'){
								echo"<option>--Pilih Pendidikan Terakhir--</option>
								<option value='SMA/SMK'>SMA/SMK</option>
								<option value='D1'>D1</option>
								<option value='D3'>D3</option>
								<option value='S1' selected>S1</option>
								<option value='S2'>S2</option>
								<option value='S3'>S3</option>";
						} else if($r[pend_akhir]=='S2'){ 
							echo"<option>--Pilih Pendidikan Terakhir--</option>
								<option value='SMA/SMK'>SMA/SMK</option>
								<option value='D1'>D1</option>
								<option value='D3'>D3</option>
								<option value='S1'>S1</option>
								<option value='S2' selected>S2</option>
								<option value='S3'>S3</option>";
						} else if($r[pend_akhir]=='S3'){ 
							echo"<option>--Pilih Pendidikan Terakhir--</option>
								<option value='SMA/SMK'>SMA/SMK</option>
								<option value='D1'>D1</option>
								<option value='D3'>D3</option>
								<option value='S1'>S1</option>
								<option value='S2'>S2</option>
								<option value='S3'  selected>S3</option>";
						} else { 
							echo"<option>--Pilih Pendidikan Terakhir--</option>
								<option value='SMA/SMK'>SMA/SMK</option>
								<option value='D1'>D1</option>
								<option value='D3'>D3</option>
								<option value='S1'>S1</option>
								<option value='S2'>S2</option>
								<option value='S3'>S3</option>";
						} ?>
                    </select>
                </div>
                <div class="formbox">
                    <label>Golongan Darah</label>
                    <select name="gol_darah" required='required'>
					<?php
					if ($r[gol_darah]=='A'){
						echo"<option>--Pilih Golongan Darah--</option>
							<option value='A' selected>A</option>
							<option value='B'>B</option>
							<option value='AB'>AB</option>
							<option value='O'>O</option>";
					} if($r[gol_darah]=='B'){
							echo"<option>--Pilih Golongan Darah--</option>
							<option value='A'>A</option>
							<option value='B' selected>B</option>
							<option value='AB'>AB</option>
							<option value='O'>O</option>";
					} if($r[gol_darah]=='AB'){
							echo"<option>--Pilih Golongan Darah--</option>
							<option value='A'>A</option>
							<option value='B'>B</option>
							<option value='AB' selected>AB</option>
							<option value='O'>O</option>";
					} else if($r[gol_darah]=='O'){ 
						echo"<option>--Pilih Golongan Darah--</option>
							<option value='A'>A</option>
							<option value='B'>B</option>
							<option value='AB'>AB</option>
							<option value='O' selected>O</option>";
					} else { 
						echo"<option>--Pilih Golongan Darah--</option>
						<option value='A'>A</option>
							<option value='B'>B</option>
							<option value='AB'>AB</option>
							<option value='O'>O</option>";
						}
					?>
                    </select>
                </div>
                <div class="formbox">
                    <label>No KTP <i></i></label>
                    <input type='text' name='no_ktp' required='required' value='<?php echo "$r[no_ktp]"; ?>'>
                </div>
                <div class="formbox">
                    <label>Saldo</label>
                    <input type='text' name='saldo' required='required' value='<?php echo "$r[saldo_awal]"; ?>'>
                </div>
                <div>
                    <label>&nbsp;</label>
                    <button type="submit" class="btn-reg">Edit</button>
                    <button type="reset" class="btn-stop">Reset</button>
                </div>
		</form>
	</html>