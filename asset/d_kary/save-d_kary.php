<?php
//extract($HTTP_POST_VARS);
$nama = htmlspecialchars(mysql_escape_string($_POST['nama']));
$tmp_lhr = htmlspecialchars(mysql_escape_string($_POST['tmp_lhr']));
$tgl_lhr = htmlspecialchars(mysql_escape_string($_POST['tgl_lhr']));
$jk = htmlspecialchars(mysql_escape_string($_POST['jk']));
$tgl_masuk = htmlspecialchars(mysql_escape_string($_POST['tgl_masuk']));
$kel = htmlspecialchars(mysql_escape_string($_POST['kel']));
$kec = htmlspecialchars(mysql_escape_string($_POST['kec']));
$kota = htmlspecialchars(mysql_escape_string($_POST['kota']));
$email = htmlspecialchars(mysql_escape_string($_POST['email']));
$foto = htmlspecialchars(mysql_escape_string($_POST['foto']));
$st_marital = htmlspecialchars(mysql_escape_string($_POST['st_marital']));
$status_aktf = htmlspecialchars(mysql_escape_string($_POST['status_aktf']));
$tlp = htmlspecialchars(mysql_escape_string($_POST['tlp']));
$id_unit = htmlspecialchars(mysql_escape_string($_POST['id_unit']));
$id_jabatan = htmlspecialchars(mysql_escape_string($_POST['id_jabatan']));
$kd_bank = htmlspecialchars(mysql_escape_string($_POST['kd_bank']));
$no_rek = htmlspecialchars(mysql_escape_string($_POST['no_rek']));
$atas_nama = htmlspecialchars(mysql_escape_string($_POST['atas_nama']));
$pend_akhir = htmlspecialchars(mysql_escape_string($_POST['pend_akhir']));
$gol_darah = htmlspecialchars(mysql_escape_string($_POST['gol_darah']));
$agama = htmlspecialchars(mysql_escape_string($_POST['agama']));
$no_ktp = htmlspecialchars(mysql_escape_string($_POST['no_ktp']));
$saldo = htmlspecialchars(mysql_escape_string($_POST['saldo']));
$xtgl_lhr = explode('-', $tgl_lhr);
$xtgl_masuk = explode('-', $tgl_masuk);
$thn_lhr = substr($xtgl_lhr[0], -2);
$bln_lhr = $xtgl_lhr[1];
$thn_msk = substr($xtgl_masuk[0], -2);
$bln_msk = $xtgl_masuk[1];
$jumlah = mysql_query("SELECT COUNT(*) from karyawan");
$jml_awal = $jumlah + 2;
$urut = sprintf("%04d", $jml_awal);

$nik = "$thn_lhr$bln_lhr$thn_msk$bln_msk$urut";


include "../../include/koneksi.php";
$simpan_rek = mysql_query("INSERT INTO rekening VALUES ('$no_rek','$atas_nama', '$kd_bank','$nik')");

$simpan = mysql_query("INSERT INTO karyawan VALUES ('$nik','$nama','$tmp_lhr','$tgl_lhr','$jk','$tgl_masuk', '$kel', '$email','$foto','$st_marital','$status_aktf','$id_unit','$id_jabatan','$tlp', '$pend_akhir','$gol_darah','$agama','$no_ktp', '$kec', '$kota','$saldo')");

$simpan_username = mysql_query("INSERT INTO login VALUES ('','$email', md5('$tgl_lhr'),'on', '$nik' )");
echo mysql_error();
?> 

<script language="javascript">alert('Data Sudah Disimpan');
    window.location = 'karyawan';
    window.refresh(1);
</script>