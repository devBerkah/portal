<?php
	$id_unit = $_GET['id_unit'];
	include "koneksi.php";
	$sql = "SELECT * FROM unit  where id_unit='$id_unit'";
	$result = @mysql_query($sql, $connection) or die (mysql_error());
	$row = @mysql_fetch_array($result,MYSQLI_ASSOC);
	
	//mysql_close();
				
	$id_unit = $row["id_unit"];
	$nm_unit = $row["nm_unit"];
	$alamat = $row["alamat"];
	$kontak = $row["kontak"];
	$email = $row["email"];

?>

<html>
<head>
	<title> Insert Unit</title>
</head>

	<form action="update_unit_save.php" method="post">
		<div> 
			<label>ID Unit</label>
			<input type="text" name="id_unit" value="<?php echo "$id_unit"; ?>">
		</div> 
		<div> 
			<label>Nama Unit</label>
			<input type="text" name="nm_unit" value="<?php echo "$nm_unit"; ?>">
		</div> 
		<div> 
			<label>Alamat</label>
			<input type="textarea" name="alamat" value="<?php echo "$alamat"; ?>"> 
		</div> 
		<div> 
			<label>Kontak</label>
			<input type="text" name="kontak" value="<?php echo "$kontak"; ?>">
		</div> 
		<div> 
			<label>email</label>
			<input type="text" name="email" value="<?php echo "$email"; ?>">
		</div> 
		<div> 
			<input type=submit name="update" value="Update">
		</div> 

	</form>

</html>