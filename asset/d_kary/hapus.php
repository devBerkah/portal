 <?php
 include "../koneksi.php";
 $query=mysql_query("DELETE FROM karyawan WHERE nik='$_GET[id]'");
 $query1=mysql_query("DELETE FROM login WHERE nik='$_GET[id]'");
 $query2=mysql_query("DELETE FROM rekening WHERE nik='$_GET[id]'");
	 
	 if(($query) && ($query1) && ($query)){
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