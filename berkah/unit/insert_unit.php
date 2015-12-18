<html>
<head>
	<title> Insert Unit</title>
</head>

	<form action="insert_unit_save.php" method="post">
		<div> 
			<label>ID Unit</label>
			<input type="text" name="id_unit">
		</div> 
		<div> 
			<label>Nama Unit</label>
			<input type="text" name="nm_unit">
		</div> 
		<div> 
			<label>Alamat</label>
			<textarea rows ="4" cols="50" name="alamat"></textarea>
		</div> 
		<div> 
			<label>Kontak</label>
			<input type="text" name="kontak">
		</div> 
		<div> 
			<label>email</label>
			<input type="text" name="email">
		</div> 
		<div> 
			<input type=submit name="insert" value="Insert">
		</div> 

	</form>

</html>