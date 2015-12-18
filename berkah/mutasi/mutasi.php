<script type="text/javascript" src="..js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  //apabila terjadi event onchange terhadap object <select id=propinsi>
  $("#nik").change(function(){
    var nik = $("#nik").val();
    $.ajax({
        url: "mutasi.php",
        data: "nik="+nik,
        cache: false,
        success: function(msg){
            $("#id_unit_awal").html(msg);
        }
    });
  });
  $("#id_unit_asal").change(function(){
    var id_unit_awal = $("#id_unit_asal").val();
    $.ajax({
        url: "mutasi.php",
        data: "id_unit_asal="+id_unit_asal,
        cache: false,
        success: function(msg){
            $("#id_unit_asal").html(msg);
        }
    });
  });
});
</script>


<?php
include"../koneksi.php";
$nik = $_GET['q'];
$unitasal = mysql_query("SELECT karyawan.nik,  unit.nm_unit, jabatan.nm_jabatan from karyawan join unit on karyawan.id_unit = unit.id_unit join jabatan on karyawan.id_jabatan = jabatan.id_jabatan WHERE nik='$nik' order by nm_unit");
while($u = mysql_fetch_array($unitasal)){
    echo "<input type=text value=\"".$u['id_unit']."\">".$u['nm_unit'];
}
?>




<?php
include"../koneksi.php";
$aksi="modul/aturan/aksi_mutasi.php";
$mutasi = mysql_query("SELECT karyawan.nik, karyawan.nama, unit.nm_unit, jabatan.nm_jabatan from karyawan join unit on karyawan.id_unit = unit.id_unit join jabatan on karyawan.id_jabatan = jabatan.id_jabatan join rekening on karyawan.no_rek = rekening.no_rek join bank on rekening.kd_bank = bank.kd_bank");
	$r=mysql_fetch_array($mutasi);
	

    echo "<h1>Data Mutasi Karyawan</h1>
		 <form method='POST' action='aksi_mutasi.php'>
		  <div>
            <label>Pilih Jenis Mutasi</label>
            <select name='katergori'>
				<option value=''>--Pilih--</option>
				<option value='unit'>Unit</option>
				<option value='jabatan'>jabatan</option>
			 </select>
            </div>
            <div>
				<label>Nama Karyawan</label>
				<select name='nik' required='required' id='nik'>
					<option value=''>- Pilih Karyawan -</option>";
						$sql = mysql_query('SELECT * FROM karyawan ORDER BY nama ASC');
						while($row = mysql_fetch_array($sql)){
							echo "<option value='$row[nik]' required='required'>$row[nama]</option>";
						}
			echo"</select> 
			</div>
			<div>
				<label>Nama Unit Asal</label>
				<input type='text' name='id_unit_asal' value='$r[nm_unit]' readonly id='id_unit_asal'>";
				$id_unit_asal = mysql_query("SELECT * FROM unit ORDER BY nama_unit");
while($p=mysql_fetch_array($sql)){
echo "<option value=\"$p[id_unit]\">$p[nm_unit]</option>\n";
}
			echo"</div>
			<div>
				<label>Nama Jabatan Asal</label>
				<input type='text' name='id_jabatan_asal' value='$r[nm_jabatan]' readonly id='id_jabatan_asal'>
			</div>
				<label>Nama Unit Tujuan</label>
				<select name='id_unit' required='required'>
					<option value=''>- Pilih Unit -</option>";
						$sql = mysql_query('SELECT * FROM unit ORDER BY nm_unit ASC');
						while($row = mysql_fetch_array($sql)){
							echo "<option value='$row[id_unit]' required='required'>$row[nm_unit]</option>";
						}
			echo"</select> 
			</div>
			<div>
				<label>Nama Jabatan Tujuan</label>
				<select name='id_jabatan' required='required'>
					<option value=''>- Pilih Jabatan -</option>";
						$sql = mysql_query('SELECT * FROM jabatan ORDER BY nm_jabatan ASC');
						while($row = mysql_fetch_array($sql)){
							echo "<option value='$row[id_jabatan]' required='required'>$row[nm_jabatan]</option>";
						}
			echo"</select> 
			</div>
			<div>
				<label>&nbsp;</label>
				<label><input type=submit name=submit value=Ubah><input type=reset name=reset value=Batal></label>
			</div>
			</form>

		<form action='' method='post' > 
			cari Berdasarkan<br>
			<select name='kategori'>
				<option value=''>--Pilih Berdasarkan--</option>
				<option value='nama'>Nama</option>
				<option value='unit'>Unit</option>
			 </select>
			<input type='text' name='search' id='search' size='20'><input type='submit' name='submit' id='submit' value='cari'>
		</form>

	
        <table border='1'>
        <tr>
            <td>No</td>
			<td>NIK</td>
            <td>Nama Karyawan</td>
            <td>Nama Unit</td>
            <td>Nama Jabatan</td>
            <td>Tanggal Mutasi</td>
        </tr>";
	if ((isset($_POST['submit'])) AND ($_POST['search']) AND ($_POST['kategori'] == "nama")) {
		$search = $_POST['search'];
		$cari=mysql_query("SELECT unit.nm_unit, jabatan.nm_jabatan, karyawan.nik, karyawan.nama, mutasi.tgl_mutasi from mutasi join unit on mutasi.id_unit=unit.id_unit join jabatan on mutasi.id_jabatan=jabatan.id_jabatan join karyawan on mutasi.nik=karyawan.nik WHERE nama like '%$search%' order by tgl_mutasi ASC ") or die(mysql_error());
		$jumlah = mysql_num_rows($cari); 
		if ($jumlah > 0) {
			echo '<p>Ada '.$jumlah.' data yang sesuai.</p>';
			$nomer=0;
		} 
	} else if ((isset($_POST['submit'])) AND ($_POST['search']) AND ($_POST['kategori'] == "unit")){
		$search = $_POST['search'];
		$cari=mysql_query("SELECT unit.nm_unit, jabatan.nm_jabatan, karyawan.nik, karyawan.nama, mutasi.tgl_mutasi from mutasi join unit on mutasi.id_unit=unit.id_unit join jabatan on mutasi.id_jabatan=jabatan.id_jabatan join karyawan on mutasi.nik=karyawan.nik WHERE nm_unit like '%$search%' order by tgl_mutasi ASC ") or die(mysql_error());
		$jumlah = mysql_num_rows($cari); 
		if ($jumlah > 0) {
			echo '<p>Ada '.$jumlah.' data yang sesuai.</p>';
			$nomer=0;
		} 
	} else if ((isset($_POST['submit'])) AND ($_POST['search']) AND ($_POST['kategori'] == "jabatan")){
		$search = $_POST['search'];
		$cari=mysql_query("SELECT unit.nm_unit, jabatan.nm_jabatan, karyawan.nik, karyawan.nama, mutasi.tgl_mutasi from mutasi join unit on mutasi.id_unit=unit.id_unit join jabatan on mutasi.id_jabatan=jabatan.id_jabatan join karyawan on mutasi.nik=karyawan.nik WHERE nm_jabatan like '%$search%' order by tgl_mutasi ASC ") or die(mysql_error());
		$jumlah = mysql_num_rows($cari); 
		if ($jumlah > 0) {
			echo '<p>Ada '.$jumlah.' data yang sesuai.</p>';
			$nomer=0;
		} 
	} else {
		$cari=mysql_query("SELECT unit.nm_unit, jabatan.nm_jabatan, karyawan.nik, karyawan.nama, mutasi.tgl_mutasi from mutasi join unit on mutasi.id_unit=unit.id_unit join jabatan on mutasi.id_jabatan=jabatan.id_jabatan join karyawan on mutasi.nik=karyawan.nik order by tgl_mutasi ASC ") or die(mysql_error());
	}
		
		
	$no=1;	
	$per_hal=3;
	$jumlah_record=mysql_query("SELECT COUNT(*) from mutasi");
	$jum=mysql_result($jumlah_record, 0);
	$halaman=ceil($jum / $per_hal);
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start = ($page - 1) * $per_hal;
	echo "Jumlah karyawan mutasi: ".$jum." karyawan <br/>";
	
    $tampil=mysql_query("SELECT unit.nm_unit, jabatan.nm_jabatan, karyawan.nik, karyawan.nama, mutasi.tgl_mutasi from mutasi join unit on mutasi.id_unit=unit.id_unit join jabatan on mutasi.id_jabatan=jabatan.id_jabatan join karyawan on mutasi.nik=karyawan.nik ORDER BY tgl_mutasi ASC ");
	
    while ($r=mysql_fetch_array($cari)){
      echo "<tr><td>$no</td>
            <td>$r[nik]</td>
            <td>$r[nama]</td>
            <td>$r[nm_unit]</td>
            <td>$r[nm_jabatan]</td>
            <td>$r[tgl_mutasi]</td>
            </td></tr>";
			
			$no++;
    }
    echo "</table>";
?>
