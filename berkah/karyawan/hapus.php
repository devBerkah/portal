 <?php
 include "../koneksi.php";
 $query=mysql_query("DELETE FROM karyawan WHERE nik='$_GET[id]'");
	 
	 if($query){
				echo"
				<script type='text/javascript'>
				window.alert('Data Berhasil Dihapus');
				window.location='tampil_karyawan.php';
				window.refresh(1);
				</script>";
			} else {
				echo "<script type='text/javascript'>
				window.alert('Data Gagal Dihapus');
				window.location='tampil_karyawan.php';
				window.refresh(1);
				</script>";
			}
?>