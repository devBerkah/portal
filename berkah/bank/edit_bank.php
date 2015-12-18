<?php
include"../koneksi.php";
$query = mysql_query("select * from bank where kd_bank='$_GET[id]'");
while($data = mysql_fetch_array($query))
{
?>



<b>Master Bank </b><br><br>
<form action=" " method="post">
<label>Kode Bank</label>
<label><input type="Text" name="kd_bank" value="<?php echo $data['kd_bank'];?>"></label><br><br>
<label>Nama Bank</label>
<label><input type="Text" name="nm_bank" value="<?php echo $data['nm_bank'];?>"></label><br><br>
<label><input type="submit" name="submit" value="Simpan">&nbsp;&nbsp;<input type="reset" name="reset" value="Batal"></label>
</form>

<?php
}
?>


<?php
			if (isset($_POST['submit']))
{

$kd=$_POST['kd_bank'];
$nama=$_POST['nm_bank'];


if ($kd==" " ||$nama=="")
	{
		//jika ada inputan yang kosong
		echo "<script>alert('data bank belum lengkap. Silahkan isi data Gejala  dengan lengkap');document.location='edit_bank.php' </script>" ;
		
		
		}else

		{
$simpan=mysql_query("update bank SET nm_bank='$nama' WHERE kd_bank='$_GET[id]'");
if($simpan)
{
echo"<script>alert ('Data berhasil di update!');document.location='tampil_bank.php' </script> ";
}
else
{
echo"<script>alert ('Maaf Data Belum lengkap. Lengkapi dulu!');document.location='edit_bank.php' </script> ";
}
}
}

         ?>
			  



