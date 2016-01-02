<table  size="3" border="0">
    <?php
    include "../../include/koneksi.php";

    $id = htmlspecialchars(mysql_escape_string($_GET[id]));
    $detail = mysql_query("SELECT karyawan.*, unit.nm_unit, jabatan.nm_jabatan from karyawan join unit on karyawan.id_unit = unit.id_unit join jabatan on karyawan.id_jabatan = jabatan.id_jabatan where md5(karyawan.nik)='$id'") or die(mysql_error(0));
    $detail1 = mysql_query("select rekening.no_rek, rekening.atas_nama, bank.nm_bank from rekening join bank on rekening.kd_bank = bank.kd_bank where md5(nik)='$id'") or die(mysql_error(0));
    $r = mysql_fetch_array($detail);
    $s = mysql_fetch_array($detail1);
    ?> 

    <div class="headbox">
        <label><i class="fa fa-database"></i> Detail Data Karyawan<label>
                <button class="btn-reg fl-right cetak"><i class="fa fa-print"></i> Cetak</button>
                </div>
                <div class="box-img bg-pth pd-reg">
                    <div class="box-foto">
                        <a href="profil"><img src="<?php echo "gambar/$data[foto]"; ?>"width="120" height="120"/></a>
                    </div>
                </div>
                <div class='databox'>
                    <label>NIK</label>
                    <?php echo "$r[nik]"; ?>
                </div>
                <div class="databox">
                    <label>Nama</label>
                    <?php echo "$r[nama]"; ?>
                </div>
                <div class="databox">
                    <label>Tempat Lahir</label>
                    <?php echo "$r[tmp_lhr]"; ?>
                </div>
                <div class="databox">
                    <label>Tanggal Lahir</label>
                    <?php echo "$r[tgl_lhr]"; ?>
                </div>
                <div class="databox">
                    <label>Jenis Kelamin</label>
                    <?php echo"$r[jk]"; ?>
                </div>
                <div class="databox">
                    <label>Agama</label>
                    <?php echo"$r[agama]"; ?>
                </div>
                <div class="databox">
                    <label>Tanggal Masuk</label>
                    <?php echo "$r[tgl_masuk]"; ?>
                </div>
                <div class="databox">
                    <label>Alamat</label>
                    <?php echo "$r[kel]kel"; ?>
                    <?php echo "$r[kec]kec"; ?>
                    <?php echo "$r[kota]kab"; ?>
                </div>
                <div class="databox">
                    <label>Email</label>
                    <?php echo "$r[email]"; ?>
                </div>
                <div class="databox">
                    <label>Status Martial</label>
                    <?php echo"$r[st_marital]"; ?>
                </div>
                <div class="databox">
                    <label>Status Aktif</label>
                    <?php echo"$r[status_aktf]"; ?>
                </div>
                <div class="databox">
                    <label>No Telepon</label>
                    <?php echo "$r[tlp]"; ?>
                </div>
                <div class="databox">
                    <label>Unit</label>
                    <?php echo "$r[nm_unit]"; ?>
                </div> 
                <div class="databox">
                    <label>Jabatan</label>
                    <?php echo "$r[nm_jabatan]"; ?>
                </div>
                <div class="databox">
                    <label>Bank</label>
                    <?php echo "$s[nm_bank] bank"; ?>
                </div>
                <div class="databox">
                    <label>No Rekening</label>
                    <?php echo "$s[no_rek]rekening"; ?>
                </div>

                </form>