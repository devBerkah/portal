<b><CENTER> Data Master Bank</CENTER></B><BR>


<?php 
include"../koneksi.php";
error_reporting(0);
//pagging
$per_hal=3;
$jumlah_record=mysql_query("SELECT COUNT(*) from bank");
$jum=mysql_result($jumlah_record, 0);
$halaman=ceil($jum / $per_hal);
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_hal;
echo "Jumlah bank : ".$jum." bank <br/>";
?>
<br>
<form enctype='multipart/form-data' action='tampil_bank.php' method='post' > 
 cari Berdasarkan<br>
	 <select name="kategori">
	 <option value="Pilih">--Pilih Berdasarkan--</option>
	 <option value="kd_bank">Kode Bank</option>
	 <option value="nm_bank">Nama Bank</option></select>
		 <input type="text" name="search" id="search" size="20">
		 <input type="submit" name="submit" id="submit" value="cari">
 </form>
 <br>
 <a href="input_bank.php">Tambah Data Bank</a>
 <br>
  <br>

<table  size="3" border="2">
			<tr>
			<td>No.</td>
			   <td>Kode Bank</td>
				<td>Nama Bank</td>
				
				<td><center>Aksi</center></td>

			</tr>
<?php
	
if ((isset($_POST['submit'])) AND ($_POST['search']) AND ($_POST['kategori'] =="kd_bank")) {
  $search = $_POST['search'];
  $query = mysql_query("select * from bank WHERE kd_bank like '%$search%'") or die(mysql_error());
$jumlah = mysql_num_rows($query); 
  if ($jumlah > 0) {
    echo '<p>Ada '.$jumlah.' data yang sesuai.</p>';
    $nomer=0;} }  
  else if ((isset($_POST['submit'])) AND ($_POST['search']) AND ($_POST['kategori'] =="nm_bank")){
	 $search = $_POST['search'];
  $query = mysql_query("select * from bank WHERE nm_bank like '%$search%'") or die(mysql_error());

	
	//menampilkan jumlah hasil pencarian
  $jumlah = mysql_num_rows($query); 
  if ($jumlah > 0) {
    echo '<p>Ada '.$jumlah.' data yang sesuai.</p>';
    $nomer=0;}
	}
else{
$query = mysql_query("select * from bank");
}
			while($data = mysql_fetch_array($query))
			{
			$no++;
			?>
			<tr>
				<td><?php echo "$no" ?></td>
				<td><?php echo $data['kd_bank']; ?></td>
				<td><?php echo $data['nm_bank']; ?></td>
				<td></a> &nbsp;<a href=<?php echo "edit_bank.php?id=$data[0]"?>>Edit</a>&nbsp; <a href="<?php echo"tampil_bank.php?aksi=hapus&id=$data[0]"?>" onclick="return confirm('Apakah anda akan menghapus data ini?')">Hapus</a></td>
			</tr>
			<?php
			}
			?>

			</td>
			</tr>
			</table>
			
			<?php
//hapus bank
extract($_GET);
if(isset($aksi))
{
if($aksi=="hapus")
{
mysql_query("delete from bank where kd_bank='$_GET[id]'") or die("Gagal menghapus data.");
echo "<script>alert('data telah di hapus');document.location='tampil_bank.php' </script> ";
}
}
?>