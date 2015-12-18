<?php
	include "koneksi.php";
?>
<html>
<head>
<title></title>
</head>

<table border="0" cellpading="5" cellspacing="2" width="520" align="center">
<th align="center" colspan="6">
	<b>Data Unit</b>
</th>
<tr align="center" bgcolor="#FFCC00">
	<td >Id Unit</td>
	<td >Nama Unit</td>
	<td width="">Alamat</td>
	<td width="">Kontak</td>
	<td width="">Email</td>
</tr>
<?php
	$sql = "SELECT * FROM unit";
		  $result = @mysql_query($sql,$connection) or die (mysql_error());
		  $num = @mysql_num_rows($result);
	
	mysql_close();
		
	$i = 0;
	while ($i < $num)
	{
	$id_unit = mysql_result($result,$i,"id_unit");
	$nm_unit = mysql_result($result,$i,"nm_unit");
	$alamat = mysql_result($result,$i,"alamat");
	$kontak = mysql_result($result,$i,"kontak");
	$email = mysql_result($result,$i,"email");
	?>
          <tr align="center" bgcolor="#FFFF99"> 
            <td><?php echo "$id_unit"; ?></td>
			<td align="left"><?php echo "$nm_unit"; ?></td>
			<td width="" align="center"><?php echo "$alamat"; ?></td>
			<td width=""><?php echo "$kontak"; ?></td>
			<td width="" align="center"><?php echo "$email"; ?></td>
			<td><?php echo "<a href='update_unit.php?id_unit=$id_unit'>Edit</a>"; ?></td>
			<td><?php echo "<a href='hapus_unit.php?id_unit=$id_unit'>Hapus</a>"; ?></td>
          </tr>
          <?php
  				++$i;
  			}
  		  ?>
</table>
<br>
<center><a href="insert_unit.php">Tambah Unit</a></center>
</html>