<div class="headbox">
    <label><i class="fa fa-plus-circle"></i> Input Data Karyawan<label>
            </div>
<div class="alt-reg"><i class="fa fa-warning"></i> Kolom merah tidak bisa dikosongkan !!!</div>
            <form action='save_karyawan' method='post'>
                <div class="formbox">
                    <label>Nama</label>
                    <input type="text" name="nama" class="inp-sm" required='required'>
                </div>
                <div class="formbox">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tmp_lhr" required='required'>
                </div>
                <div class="formbox">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tgl_lhr" required='required'>
                </div>
                <div class="formbox">
                    <label>Jenis Kelamin</label>
                    <select name="jk" required='required'><option>--Pilih Jenis Kelamin--</option>
                        <option value="Laki-Laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="formbox">
                    <label>Agama</label>
                    <select name="agama" required='required'><option>--Pilih Agama--</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Budha">Budha</option>
                        <option value="Hindu">Hindu</option>
                    </select>
                </div>
                <div class="formbox">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tgl_masuk" required='required'>
                </div>
                <div class="formbox-grup">
                    <label>Alamat</label>
                    <label>Kelurahan</label>
                    <input type="text" name="kel" required='required'>
                    <label>Kecamatan</label>
                    <input type="text" name="kec" required='required'>
                    <label>Kota/Kabupaten</label>
                    <input type="text" name="kota" required='required'>
                </div>
                <div class="formbox">
                    <label>Email</label>
                    <input type="text" name="email" required='required'>
                </div>
                <div class="formbox">
                    <label>Foto</label>
                    <input type="file" name="foto">
                </div>
                <div class="formbox">
                    <label>Status Martial</label>
                    <select name="st_marital" required='required'><option>--Pilih Status Martial--</option>
                        <option value="Menikah" >Menikah</option>
                        <option value="Belum Menikah">Belum Menikah</option>
                    </select>
                </div>
                <div class="formbox">
                    <label>Status Aktif</label>
                    <select name="status_aktf" required='required'><option>--Pilih Status Aktif--</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Baru">Baru</option>
                    </select>
                </div>
                <div class="formbox">
                    <label>No Telepon</label>
                    <input type="text" name="tlp" required='required'>
                </div>
                <div class="formbox">
                    <label>Unit</label>
                    <select name="id_unit" required='required'><option value=''>--Pilih Unit--</option>
                        <?php
                        $sql = mysql_query('SELECT * FROM unit ORDER BY nm_unit ASC');
                        while ($row = mysql_fetch_array($sql)) {
                            echo "<option value='$row[id_unit]' required='required'>( $row[id_unit] ) $row[nm_unit]</option>";
                        }
                        ?>
                    </select></label>
                </div> 
                <div class="formbox">
                    <label>Jabatan</label>
                    <select name="id_jabatan" required='required'><option value=''>--Pilih Jabatan--</option>
                        <?php
                        $sql = mysql_query('SELECT * FROM jabatan ORDER BY nm_jabatan ASC');
                        while ($row = mysql_fetch_array($sql)) {
                            echo "<option value='$row[id_jabatan]' required='required'>$row[nm_jabatan]</option>";
                        }
                        ?>
                    </select></label>
                </div>
                <div class="formbox">
                    <label>Bank</label>
                    <select name="kd_bank" required='required'><option value=''>--Pilih Bank--</option>
                        <?php
                        $sql = mysql_query('SELECT * FROM bank ORDER BY nm_bank ASC');
                        while ($row = mysql_fetch_array($sql)) {
                            echo "<option value='$row[kd_bank]' required='required'>$row[nm_bank]</option>";
                        }
                        ?>
                    </select></label>
                </div>
                <div class="formbox">
                    <label>No Rekening</label>
                    <input type="text" name="no_rek" required='required'>
                </div>
                <div class="formbox">
                    <label>Nama Rekening</label>
                    <input type="text" name="atas_nama" required='required'>
                </div>
                <div class="formbox">
                    <label>Pendidikan Terakhir</label>
                    <select name="pend_akhir" required='required'><option value=''>-Pilih Pendidikan Terakhir--</option>
                        <option value="SMA/SMK">SMA/SMK</option>
                        <option value="D1">D1</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>
                <div class="formbox">
                    <label>Golongan Darah</label>
                    <select name="gol_darah" required='required'><option value=''>--Pilih Golongan Darah--</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select></label>
                </div>
                <div class="formbox">
                    <label>No KTP <i></i></label>
                    <input type='text' name='no_ktp' required='required'>
                </div>
                <div class="formbox">
                    <label>Saldo</label>
                    <input type='text' name='saldo' required='required'>
                </div>
                <div>
                    <label>&nbsp;</label>
                    <button type="submit" class="btn-reg">Simpan</button>
                    <button type="reset" class="btn-stop">Reset</button>
                </div>
            </form>
            </html>
