<?php
	include "koneksi.php";
	$id_unit = $_GET['id_unit'];	
	$sql = "DELETE FROM unit where id_unit = '$id_unit'";
			$result = @mysql_query($sql,$connection) or die (mysql_error());
	
	?> <script language="javascript">
			document.location='tampil_unit.php'</script>
		<?
?>