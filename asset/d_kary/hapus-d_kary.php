 <?php
include "../../include/koneksi.php";
 $query1=mysql_query("DELETE FROM login WHERE nik='$_GET[id]'");
 $query2=mysql_query("DELETE FROM rekening WHERE nik='$_GET[id]'");
  $query=mysql_query("DELETE FROM karyawan WHERE nik='$_GET[id]'");
?>

<script language="javascript">alert('Data Sudah Dihapus');
	window.location='karyawan';
	window.refresh(1);
</script>