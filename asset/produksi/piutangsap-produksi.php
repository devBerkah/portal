<div align="right"><a href="#" title="print" onClick="javascript:window.print(); return false"><img src="../gambar/p.gif" border="0"></a></div>
<table border="1" bordercolor="" cellpadding="0" cellspacing="0" align="center" width="600px" style="color:#000000;font-family:tahoma,arial;font-size:11px;">
<tr><td colspan="24" align="center"> 
<?php
$field = $_POST['field'];
$keyword = $_POST['keyword'];
$keyword2 = $_POST['keyword2'];
if($field=='id_produksi')
{
$field2='ID Produksi';
}else
if($field=='panenbulan')
{
$field2='Produksi Bulan-';
}else
if($field=='id_farm')
{
$field2='ID Farm';
}

?>
<form action="piutang_sap.php" method="post" enctype="multipart/form-data">
  <select name="field">
   <option value="<?php echo"$field"; ?>"><?php echo"$field"; ?></option>
   <option value="">---------------------</option>
   <option value="id_produksi">ID Produksi</option>
   <option value="panenbulan">Produksi Bulan-</option>
   <option value="id_farm">ID Farm</option>
  </select>
  <font color="#000000">Keyword </font><input name="keyword" type="text" id="keyword" value="<?php echo"$keyword"; ?>"/>
<input name="cari" type="submit" id="cari" value="cari"/>
</form>
</td></tr>
<tr bgcolor="#999999">
<td colspan="24" align="center"><b>UTANG PIUTANG FARM</b></td>
</tr>
<tr bgcolor="#999999">
<td align="center" rowspan="2">ID Produksi</td>
<td align="center" rowspan="2">ID Farm</td>
<td align="center" rowspan="2">Nama</td>
<td align="center" rowspan="2">Alamat</td>
<td align="center" rowspan="2">SAPRONAK</td>
<td align="center" rowspan="2">Retur</td>
<td align="center" rowspan="2">Penjualan Ayam</td>
<td align="center" rowspan="2">BOP</td>
<td align="center" colspan="5">Bonus Prestasi</td>
<td align="center" rowspan="2">Sangsi</td>
<td align="center" rowspan="2">Kompensasi</td>
<td align="center" rowspan="2">Tabungan</td>
<td align="center" rowspan="2">Cicilan Hutang Uang&amp;Alat</td>
<td align="center" rowspan="2">Cicilan Hutang Produksi</td>
<td align="center" rowspan="2">Pengurang Lain-Lain</td>
<td align="center" rowspan="2">THP</td>
<td align="center" rowspan="2"></td>
</tr>
<tr bgcolor="#999999">
<td align="center">IP</td>
<td align="center">SHP</td>
<td align="center">Kematian</td>
<td align="center">FC</td>
<td align="center">BB-FC</td>
</tr>
<?php
$field = $_POST['field'];
$keyword = $_POST['keyword'];

if($keyword=='')
{

$qutang = mysql_query("select * from rhpp where panenbulan='0000-00-00' order by id_produksi");
$butang = mysql_num_rows($qutang);
if($butang > 0)
{   $i=0;
	while($dutang = mysql_fetch_array($qutang))
	{
if(($i%2) == 1)
{
	$a ="#FFFFFF";
}else
{
	$a ="#CCCCCC";
}		
		$qf = mysql_query("select * from farm where id_farm='$dutang[id_farm]'");
		$df = mysql_fetch_array($qf);
		echo"<tr><tr bgcolor=\"$a\">
		<td align=\"center\">$dutang[id_produksi]</td>
		<td align=\"center\">$dutang[id_farm]</td>
		<td align=\"left\">$df[nama]</td>
		<td align=\"left\">$df[desa]</td>";
		//jual sapronak
		$qprd = mysql_query("select * from produksi where id_produksi='$dutang[id_produksi]'");
		$dprd = mysql_fetch_array($qprd);
		$kontrak = $dprd['id_kontrak'];
		$id_kontrak=substr(($kontrak),0,3);
		$total_sap=0;$total_rsap=0;$Ttotal_ayam=0;$kompensasi=0;
		if($id_kontrak=='MKL')
		{
			if($dutang['sapronak']=='')
			{
		
			$query = mysql_query("SELECT * FROM jual where id_produksi='$dutang[id_produksi]' ")or die(mysql_error());
			$jumlah = mysql_num_rows($query);
			while($djual = mysql_fetch_assoc($query))
			{
				$id_barang = $djual['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				$hrg = $data2['hrg_beli'];
				$sTotal2 = $hrg*$djual['qty'];
				$total_sap = $total_sap+$sTotal2;
			}
			
			}else
			{
				$total_sap=$dutang['sapronak'];
			}
			
			//retur
			if($dutang['retur_sapronak']=='')
			{

			$qretur = mysql_query("SELECT * FROM retur_jual where id_produksi='$dutang[id_produksi]' ")or die(mysql_error());
			$jretur = mysql_num_rows($qretur);
			while($dretur = mysql_fetch_assoc($qretur))
			{
				$id_barang = $dretur['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				$hrg = $data2['hrg_beli'];
				$retur = $hrg*$dretur['qty'];
				$total_rsap = $total_rsap+$retur;
			}
			
			}else
			{
				$total_rsap = $dutang['retur_sapronak'];
			}
			
			//PJA
			if($dutang['p_ayam']=='')
			{

			$qayam = " SELECT * FROM pja where id_produksi='$dutang[id_produksi]' ";
			$hayam = mysql_query( $qayam ) or die(mysql_error());
			while( $dayam = mysql_fetch_assoc($hayam) )
			{
			$total_ayam = $dayam['tonase_real']*$dayam['hrg_real'];
			$Ttotal_ayam=$Ttotal_ayam+$total_ayam;
			}
			
			}else
			{
			$Ttotal_ayam=$dutang['p_ayam'];
			}
			
		}else
		{
			//jual sap
			if($dutang['sapronak']=='')
			{

			$query = mysql_query("SELECT * FROM jual where id_produksi='$dutang[id_produksi]' order by id_barang ")or die(mysql_error());
			$jumlah = mysql_num_rows($query);
			$kontrak = mysql_query(" select * from kontrak_kmt where id_kontrak='$kontrak' ");
			$dkontrak = mysql_fetch_assoc($kontrak);
			while($djual = mysql_fetch_assoc($query))
			{
				$id_barang = $djual['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				if(substr(($djual['id_barang']),6,3)=='DOC')
				{
				$hrg = $dkontrak['DOC'];
				}else
				if(substr(($djual['id_barang']),6,3)=='BST')
				{
				$hrg = $dkontrak['BST'];
				}else
				if(substr(($djual['id_barang']),6,3)=='STR')
				{
				$hrg = $dkontrak['STR'];
				}else
				if(substr(($djual['id_barang']),6,3)=='FNS')
				{
				$hrg = $dkontrak['FNS'];
				}else
				{
				$hrg = $data2['hrg_jual'];
				}
				$sTotal2 = $hrg*$djual['qty'];
				$total_sap = $total_sap+$sTotal2;
			}
			}else
			{
				$total_sap=$dutang['sapronak'];
			}
			
			//retur
			if($dutang['retur_sapronak']=='')
			{

			$qretur = mysql_query("SELECT * FROM retur_jual where id_produksi='$dutang[id_produksi]' ")or die(mysql_error());
			$jretur = mysql_num_rows($qretur);
			while($dretur = mysql_fetch_assoc($qretur))
			{
				$id_barang = $dretur['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				if(substr(($dretur['id_barang']),6,3)=='DOC')
				{
				$hrg = $dkontrak['DOC'];
				}else
				if(substr(($dretur['id_barang']),6,3)=='BST')
				{
				$hrg = $dkontrak['BST'];
				}else
				if(substr(($dretur['id_barang']),6,3)=='STR')
				{
				$hrg = $dkontrak['STR'];
				}else
				if(substr(($dretur['id_barang']),6,3)=='FNS')
				{
				$hrg = $dkontrak['FNS'];
				}else
				{
				$hrg = $data2['hrg_jual'];
				}
				$retur = $hrg*$dretur['qty'];
				$total_rsap = $total_rsap+$retur;
			}
			}else
			{
				$total_rsap = $dutang['retur_sapronak'];
			}
			
			//PJA
			if($dutang['p_ayam']=='')
			{

			$qayam = " SELECT * FROM pja where id_produksi='$dutang[id_produksi]' ";
			$hayam = mysql_query( $qayam ) or die(mysql_error());
			while( $dayam = mysql_fetch_assoc($hayam) )
			{
			$bw = substr(($dayam['tonase_real']/$dayam['ekor_real']),0,4);
			$kayam = mysql_query ("SELECT * FROM harga_ayam where id_harga = '$dkontrak[id_harga]' and (bb_min <= $bw) and ($bw <= bb_max)");
			$kayam3 = mysql_fetch_assoc($kayam);
			$hrg_ayam = $kayam3['harga'];
			$total_ayam = $dayam['tonase_real']*$hrg_ayam;
			$Ttotal_ayam=$Ttotal_ayam+$total_ayam;
			}
			
			}else
			{
			$Ttotal_ayam=$dutang['p_ayam'];
			}
			
		}
		$utang = ($Ttotal_ayam+$total_rsap)-$total_sap;
		$utang2=ribuan($utang);
		$kompensasi2=ribuan($kompensasi);
		$total_sap2=ribuan($total_sap);
		$total_rsap2=ribuan($total_rsap);
		$Ttotal_ayam2=ribuan($Ttotal_ayam);
		$panenbulan = $dutang['panenbulan'];
	echo"<td align=\"right\">$total_sap2</td>";
	echo"<td align=\"right\">$total_rsap2</td>";
	echo"<td align=\"right\">$Ttotal_ayam2</td>";
	
	//bop awal	
	if($dutang['bop_awal'] != '')
	{
	$bop_awal=ribuan($dutang['bop_awal']);
	echo"<td align=\"right\">$bop_awal</td>";
	}else
	{
	$bop_awal=0;
	echo"<td align=\"right\">0</td>";
	}

	//bonus IP
	if($dutang['bonus_ip'] != '')
	{
	$bonus_ip=ribuan($dutang['bonus_ip']);
	echo"<td align=\"right\">$bonus_ip</td>";
	}else
	{
	$bonus_ip=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus SHP
	if($dutang['bonus_shp'] != '')
	{
	$bonus_shp=ribuan($dutang['bonus_shp']);
	echo"<td align=\"right\">$bonus_shp</td>";
	}else
	{
	$bonus_shp=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus Kematian
	if($dutang['bonus_mati'] != '')
	{
	$bonus_mati=ribuan($dutang['bonus_mati']);
	echo"<td align=\"right\">$bonus_mati</td>";
	}else
	{
	$bonus_mati=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus fc
	if($dutang['bonus_fc'] != '')
	{
	$bonus_fc=ribuan($dutang['bonus_fc']);
	echo"<td align=\"right\">$bonus_fc</td>";
	}else
	{
	$bonus_fc=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus bb fc
	if($dutang['bonus_fc_bb'] != '')
	{
	$bonus_fc_bb=ribuan($dutang['bonus_fc_bb']);
	echo"<td align=\"right\">$bonus_fc_bb</td>";
	}else
	{
	$bonus_fc_bb=0;
	echo"<td align=\"right\">0</td>";
	}
	//sangsi
	if($dutang['sangsi'] != '')
	{
	$sangsi=ribuan($dutang['sangsi']);
	echo"<td align=\"right\">$sangsi</td>";
	}else
	{
	$sangsi=0;
	echo"<td align=\"right\">0</td>";
	}
	//kompensasi
	$kompensasi=0;
	if(($dutang['npenambah_lain1'] != '')or($dutang['npenambah_lain2'] != '')or($dutang['npenambah_lain3'] != '')or($dutang['npenambah_lain4'] != '')or($dutang['npenambah_lain5'] != ''))
	{
	$kompensasi=$dutang['npenambah_lain1']+$dutang['npenambah_lain2']+$dutang['npenambah_lain3']+$dutang['npenambah_lain4']+$dutang['npenambah_lain5'];
	$kompensasi2=ribuan($kompensasi);
	echo"<td align=\"right\">$kompensasi2</td>";
	}else
	{
	$kompensasi=0;
	echo"<td align=\"right\">0</td>";
	}
	//tabungan
	if($dutang['tabungan'] != '')
	{
	$tabungan=ribuan($dutang['tabungan']);
	echo"<td align=\"right\">$tabungan</td>";
	}else
	{
	$tabungan=0;
	echo"<td align=\"right\">0</td>";
	}
	//cicilan hutang uang dan alat
	if($dutang['cicilan'] != '')
	{
	$cicilan =ribuan($dutang['cicilan']);
	echo"<td align=\"right\">$cicilan</td>";
	}else
	{
	$cicilan ==0;
	echo"<td align=\"right\">0</td>";
	}
	//cicilan hutang produksi
	if($dutang['jml_cicilan_prod'] != '')
	{
	$jml_cicilan_prod =ribuan($dutang['jml_cicilan_prod']);
	echo"<td align=\"right\">$jml_cicilan_prod</td>";
	}else
	{
	$jml_cicilan_prod ==0;
	echo"<td align=\"right\">0</td>";
	}
	//pengurang
	$pengurang=0;
	if(($dutang['npengurang_lain1'] != '')or($dutang['npengurang_lain2'] != '')or($dutang['npengurang_lain3'] != '')or($dutang['npengurang_lain4'] != ''))
	{
	$pengurang=$dutang['npengurang_lain1']+$dutang['npengurang_lain2']+$dutang['npengurang_lain3']+$dutang['npengurang_lain4'];
	$pengurang2=ribuan($pengurang);
	echo"<td align=\"right\">$pengurang2</td>";
	}else
	{
	$pengurang=0;
	echo"<td align=\"right\">0</td>";
	}

	//if($dutang['panenbulan']!='0000-00-00')
	if($dutang['tanggal']!='0000-00-00')
	{
	$thp = $dutang['thp_ternak'];
	$thp2=ribuan($thp);
	echo"<td align=\"right\">$thp2</td>";
	}else
	{
	$thp = 0;
	$thp2=ribuan($thp);
	echo"<td align=\"right\">$thp2</td>";
	}
	//periode produksi
	if($dutang['panenbulan']!='0000-00-00')
	{
	echo"<td valign=\"top\" align=\"center\">$panenbulan</td>";
	}else
	{
	echo"<td valign=\"top\" align=\"center\"><a href=\"fix.php?id=$dutang[id_produksi]&sap=$dutang[sapronak]&ret=$dutang[retur_sapronak]&pja=$dutang[p_ayam]&kontrak=$kontrak&nama=$df[nama]&alamat=$df[desa]&id_farm=$dutang[id_farm]&bop1=$dutang[bop_awal]&bonus_ip=$dutang[bonus_ip]&bonus_shp=$dutang[bonus_shp]&bonus_mati=$dutang[bonus_mati]&bonus_fc=$dutang[bonus_fc]&bonus_fc_bb=$dutang[bonus_fc_bb]&sangsi=$dutang[sangsi]&kompensasi=$kompensasi&tabungan=$dutang[tabungan]&cicilan=$dutang[cicilan]&cicilan_prod=$dutang[jml_cicilan_prod]&pengurang=$pengurang&thp=$thp&bop_diambil=$dutang[bop_awal]&bop_kantor=$dutang[bop_akhir]\"><img src=\"../gambar/FIX_0.bmp\" height=\"20\" width=\"50\" border=\"0\" /></a></td>";
	}
		$Ttotal_bop=$Ttotal_bop+$total_bop;
		$Trl_prod=$Trl_prod+$rl_prod;
		$Tbop_awal=$Tbop_awal+$dutang['bop_awal'];
		$Tbop_tengah=$Tbop_tengah+$dutang['bop_tengah'];
		$Tbonus_ip=$Tbonus_ip+$dutang['bonus_ip'];
		$Tbonus_shp=$Tbonus_shp+$dutang['bonus_shp'];
		$Tbonus_mati=$Tbonus_mati+$dutang['bonus_mati'];
		$Tbonus_fc=$Tbonus_fc+$dutang['bonus_fc'];
		$Tbonus_fc_bb=$Tbonus_fc_bb+$dutang['bonus_fc_bb'];
		$Tsangsi=$Tsangsi+$dutang['sangsi'];
		$Tkompensasi=$Tkompensasi+$kompensasi;
		$Ttabungan=$Ttabungan+$dutang['tabungan'];
		$Tcicilan=$Tcicilan+$dutang['cicilan'];
		$Tcicilan_prod=$Tcicilan_prod+$dutang['jml_cicilan_prod'];
		$Tpengurang=$Tpengurang+$pengurang;
		$total_sapronak = $total_sapronak+$total_sap;
		$total_rsapronak = $total_rsapronak+$total_rsap;
		$total_payam = $total_payam+$Ttotal_ayam;
		$Tutang = $Tutang+$utang9;
		$Tthp=$Tthp+$dutang['thp_ternak'];
		echo"</tr>";$i++;
	}
	$total_sapronak2=ribuan($total_sapronak);$total_payam2=ribuan($total_payam);$Trl_prod2=ribuan($Trl_prod);$Tbop_awal2=ribuan($Tbop_awal);$Tcicilan_prod2=ribuan($Tcicilan_prod);$Tbonus_ip2=ribuan($Tbonus_ip);$Tbonus_shp2=ribuan($Tbonus_shp);$Tbonus_mati2=ribuan($Tbonus_mati);$Tbonus_fc2=ribuan($Tbonus_fc);$Tbonus_fc_bb2=ribuan($Tbonus_fc_bb);$Tsangsi2=ribuan($Tsangsi);$Tkompensasi2=ribuan($Tkompensasi);$Ttabungan2=ribuan($Ttabungan);$Tcicilan2=ribuan($Tcicilan);$Tpengurang2=ribuan($Tpengurang);
	$total_rsapronak2=ribuan($total_rsapronak);$Tutang2=ribuan($Tutang);$Tthp2=ribuan($Tthp);$Ttotal_bop2=ribuan($Ttotal_bop);
	echo"<tr bgcolor=\"red\"><td colspan=\"4\" align=\"center\"><b>Total</b></td><td align=\"right\">$total_sapronak2</td><td align=\"right\">$total_rsapronak2</td><td align=\"right\">$total_payam2</td><td align=\"right\">$Tbop_awal2</td><td align=\"right\">$Tbonus_ip2</td><td align=\"right\">$Tbonus_shp2</td><td align=\"right\">$Tbonus_mati2</td><td align=\"right\">$Tbonus_fc2</td><td align=\"right\">$Tbonus_fc_bb2</td><td align=\"right\">$Tsangsi</td><td align=\"right\">$Tkompensasi2</td><td align=\"right\">$Ttabungan2</td><td align=\"right\">$Tcicilan2</td><td align=\"right\">$Tcicilan_prod2</td><td align=\"right\">$Tpengurang2</td><td align=\"right\">$Tthp2</td><td></td></tr>";
}else
{
 echo"<tr><tr bgcolor=\"$a\"><td colspan=\"21\" align=\"center\">Data Kosong</td></tr>";
}

}else
if($field=='panenbulan')
{
$qutang = @mysql_query("select * from rhpp where panenbulan like '%$keyword%' order by id_produksi");
$butang = @mysql_num_rows($qutang);
if($butang > 0)
{   $i=0;
	while($dutang = @mysql_fetch_assoc($qutang))
	{
if(($i%2) == 1)
{
	$a ="#FFFFFF";
}else
{
	$a ="#CCCCCC";
}		
		$qf = @mysql_query("select * from farm where id_farm='$dutang[id_farm]'");
		$df = @mysql_fetch_assoc($qf);
		echo"<tr><tr bgcolor=\"$a\">
		<td align=\"center\">$dutang[id_produksi]</td>
		<td align=\"center\">$dutang[id_farm]</td>
		<td align=\"left\">$df[nama]</td>
		<td align=\"left\">$df[desa]</td>";
		//jual sapronak
		$qprd = mysql_query("select * from produksi where id_produksi='$dutang[id_produksi]'");
		$dprd = mysql_fetch_assoc($qprd);
		$kontrak = $dprd['id_kontrak'];
		$id_kontrak=substr(($kontrak),0,3);
		$total_sap=0;$total_rsap=0;$Ttotal_ayam=0;$kompensasi=0;
		if($id_kontrak=='MKL')
		{
			if($dutang['sapronak']=='')
			{
		
			$query = @mysql_query("SELECT * FROM jual where id_produksi='$dutang[id_produksi]' ")or die(mysql_error());
			$jumlah = @mysql_num_rows($query);
			while($djual = mysql_fetch_assoc($query))
			{
				$id_barang = $djual['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				$hrg = $data2['hrg_beli'];
				$sTotal2 = $hrg*$djual['qty'];
				$total_sap = $total_sap+$sTotal2;
			}
			
			}else
			{
				$total_sap=$dutang['sapronak'];
			}
			
			//retur
			if($dutang['retur_sapronak']=='')
			{

			$qretur = @mysql_query("SELECT * FROM retur_jual where id_produksi='$dutang[id_produksi]' ")or die(mysql_error());
			$jretur = @mysql_num_rows($qretur);
			while($dretur = mysql_fetch_assoc($qretur))
			{
				$id_barang = $dretur['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				$hrg = $data2['hrg_beli'];
				$retur = $hrg*$dretur['qty'];
				$total_rsap = $total_rsap+$retur;
			}
			
			}else
			{
				$total_rsap = $dutang['retur_sapronak'];
			}
			
			//PJA
			if($dutang['p_ayam']=='')
			{

			$qayam = " SELECT * FROM pja where id_produksi='$dutang[id_produksi]' ";
			$hayam = mysql_query( $qayam ) or die(mysql_error());
			while( $dayam = mysql_fetch_assoc($hayam) )
			{
			$total_ayam = $dayam['tonase_real']*$dayam['hrg_real'];
			$Ttotal_ayam=$Ttotal_ayam+$total_ayam;
			}
			
			}else
			{
			$Ttotal_ayam=$dutang['p_ayam'];
			}
			
		}else
		{
			//jual sap
			if($dutang['sapronak']=='')
			{

			$query = @mysql_query("SELECT * FROM jual where id_produksi='$dutang[id_produksi]' order by id_barang ")or die(mysql_error());
			$jumlah = @mysql_num_rows($query);
			$kontrak = mysql_query(" select * from kontrak_kmt where id_kontrak='$kontrak' ");
			$dkontrak = mysql_fetch_assoc($kontrak);
			while($djual = mysql_fetch_assoc($query))
			{
				$id_barang = $djual['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				if(substr(($djual['id_barang']),6,3)=='DOC')
				{
				$hrg = $dkontrak['DOC'];
				}else
				if(substr(($djual['id_barang']),6,3)=='BST')
				{
				$hrg = $dkontrak['BST'];
				}else
				if(substr(($djual['id_barang']),6,3)=='STR')
				{
				$hrg = $dkontrak['STR'];
				}else
				if(substr(($djual['id_barang']),6,3)=='FNS')
				{
				$hrg = $dkontrak['FNS'];
				}else
				{
				$hrg = $data2['hrg_jual'];
				}
				$sTotal2 = $hrg*$djual['qty'];
				$total_sap = $total_sap+$sTotal2;
			}
			}else
			{
				$total_sap=$dutang['sapronak'];
			}
			
			//retur
			if($dutang['retur_sapronak']=='')
			{

			$qretur = @mysql_query("SELECT * FROM retur_jual where id_produksi='$dutang[id_produksi]' ")or die(mysql_error());
			$jretur = @mysql_num_rows($qretur);
			while($dretur = mysql_fetch_assoc($qretur))
			{
				$id_barang = $dretur['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				if(substr(($dretur['id_barang']),6,3)=='DOC')
				{
				$hrg = $dkontrak['DOC'];
				}else
				if(substr(($dretur['id_barang']),6,3)=='BST')
				{
				$hrg = $dkontrak['BST'];
				}else
				if(substr(($dretur['id_barang']),6,3)=='STR')
				{
				$hrg = $dkontrak['STR'];
				}else
				if(substr(($dretur['id_barang']),6,3)=='FNS')
				{
				$hrg = $dkontrak['FNS'];
				}else
				{
				$hrg = $data2['hrg_jual'];
				}
				$retur = $hrg*$dretur['qty'];
				$total_rsap = $total_rsap+$retur;
			}
			}else
			{
				$total_rsap = $dutang['retur_sapronak'];
			}
			
			//PJA
			if($dutang['p_ayam']=='')
			{

			$qayam = " SELECT * FROM pja where id_produksi='$dutang[id_produksi]' ";
			$hayam = mysql_query( $qayam ) or die(mysql_error());
			while( $dayam = mysql_fetch_assoc($hayam) )
			{
			$bw = @substr(($dayam['tonase_real']/$dayam['ekor_real']),0,4);
			$kayam = @mysql_query ("SELECT * FROM harga_ayam where id_harga = '$dkontrak[id_harga]' and (bb_min <= $bw) and ($bw <= bb_max)");
			$kayam3 = @mysql_fetch_assoc($kayam);
			$hrg_ayam = $kayam3['harga'];
			$total_ayam = $dayam['tonase_real']*$hrg_ayam;
			$Ttotal_ayam=$Ttotal_ayam+$total_ayam;
			}
			
			}else
			{
			$Ttotal_ayam=$dutang['p_ayam'];
			}
			
		}
		$utang = ($Ttotal_ayam+$total_rsap)-$total_sap;
		$utang2=ribuan($utang);
		$kompensasi2=ribuan($kompensasi);
		$total_sap2=ribuan($total_sap);
		$total_rsap2=ribuan($total_rsap);
		$Ttotal_ayam2=ribuan($Ttotal_ayam);
		$panenbulan = tgl_indo2($dutang['panenbulan']);
	echo"<td align=\"right\">$total_sap2</td>";
	echo"<td align=\"right\">$total_rsap2</td>";
	echo"<td align=\"right\">$Ttotal_ayam2</td>";
	
	//bop awal	
	if($dutang['bop_awal'] != '')
	{
	$bop_awal=ribuan($dutang['bop_awal']);
	echo"<td align=\"right\">$bop_awal</td>";
	}else
	{
	$bop_awal=0;
	echo"<td align=\"right\">0</td>";
	}

	//bonus IP
	if($dutang['bonus_ip'] != '')
	{
	$bonus_ip=ribuan($dutang['bonus_ip']);
	echo"<td align=\"right\">$bonus_ip</td>";
	}else
	{
	$bonus_ip=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus SHP
	if($dutang['bonus_shp'] != '')
	{
	$bonus_shp=ribuan($dutang['bonus_shp']);
	echo"<td align=\"right\">$bonus_shp</td>";
	}else
	{
	$bonus_shp=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus Kematian
	if($dutang['bonus_mati'] != '')
	{
	$bonus_mati=ribuan($dutang['bonus_mati']);
	echo"<td align=\"right\">$bonus_mati</td>";
	}else
	{
	$bonus_mati=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus fc
	if($dutang['bonus_fc'] != '')
	{
	$bonus_fc=ribuan($dutang['bonus_fc']);
	echo"<td align=\"right\">$bonus_fc</td>";
	}else
	{
	$bonus_fc=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus bb fc
	if($dutang['bonus_fc_bb'] != '')
	{
	$bonus_fc_bb=ribuan($dutang['bonus_fc_bb']);
	echo"<td align=\"right\">$bonus_fc_bb</td>";
	}else
	{
	$bonus_fc_bb=0;
	echo"<td align=\"right\">0</td>";
	}
	//sangsi
	if($dutang['sangsi'] != '')
	{
	$sangsi=ribuan($dutang['sangsi']);
	echo"<td align=\"right\">$sangsi</td>";
	}else
	{
	$sangsi=0;
	echo"<td align=\"right\">0</td>";
	}
	//kompensasi
	$kompensasi=0;
	if(($dutang['npenambah_lain1'] != '')or($dutang['npenambah_lain2'] != '')or($dutang['npenambah_lain3'] != '')or($dutang['npenambah_lain4'] != '')or($dutang['npenambah_lain5'] != ''))
	{
	$kompensasi=$dutang['npenambah_lain1']+$dutang['npenambah_lain2']+$dutang['npenambah_lain3']+$dutang['npenambah_lain4']+$dutang['npenambah_lain5'];
	$kompensasi2=ribuan($kompensasi);
	echo"<td align=\"right\">$kompensasi2</td>";
	}else
	{
	$kompensasi=0;
	echo"<td align=\"right\">0</td>";
	}
	//tabungan
	if($dutang['tabungan'] != '')
	{
	$tabungan=ribuan($dutang['tabungan']);
	echo"<td align=\"right\">$tabungan</td>";
	}else
	{
	$tabungan=0;
	echo"<td align=\"right\">0</td>";
	}
	//cicilan hutang uang dan alat
	if($dutang['cicilan'] != '')
	{
	$cicilan =ribuan($dutang['cicilan']);
	echo"<td align=\"right\">$cicilan</td>";
	}else
	{
	$cicilan ==0;
	echo"<td align=\"right\">0</td>";
	}
	//cicilan hutang produksi
	if($dutang['jml_cicilan_prod'] != '')
	{
	$jml_cicilan_prod =ribuan($dutang['jml_cicilan_prod']);
	echo"<td align=\"right\">$jml_cicilan_prod</td>";
	}else
	{
	$jml_cicilan_prod ==0;
	echo"<td align=\"right\">0</td>";
	}
	//pengurang
	$pengurang=0;
	if(($dutang['npengurang_lain1'] != '')or($dutang['npengurang_lain2'] != '')or($dutang['npengurang_lain3'] != '')or($dutang['npengurang_lain4'] != ''))
	{
	$pengurang=$dutang['npengurang_lain1']+$dutang['npengurang_lain2']+$dutang['npengurang_lain3']+$dutang['npengurang_lain4'];
	$pengurang2=ribuan($pengurang);
	echo"<td align=\"right\">$pengurang2</td>";
	}else
	{
	$pengurang=0;
	echo"<td align=\"right\">0</td>";
	}

	//if($dutang['panenbulan']!='0000-00-00')
	if($dutang['tanggal']!='0000-00-00')
	{
	$thp = $dutang['thp_ternak'];
	$thp2=ribuan($thp);
	echo"<td align=\"right\">$thp2</td>";
	}else
	{
	$thp = 0;
	$thp2=ribuan($thp);
	echo"<td align=\"right\">$thp2</td>";
	}
	//periode produksi
	if($dutang['panenbulan']!='0000-00-00')
	{
	echo"<td valign=\"top\" align=\"center\">$panenbulan</td>";
	}else
	{
	echo"<td valign=\"top\" align=\"center\"><a href=\"fix.php?id=$dutang[id_produksi]&sap=$dutang[sapronak]&ret=$dutang[retur_sapronak]&pja=$dutang[p_ayam]&kontrak=$kontrak&nama=$df[nama]&alamat=$df[desa]&id_farm=$dutang[id_farm]&bop1=$dutang[bop_awal]&bonus_ip=$dutang[bonus_ip]&bonus_shp=$dutang[bonus_shp]&bonus_mati=$dutang[bonus_mati]&bonus_fc=$dutang[bonus_fc]&bonus_fc_bb=$dutang[bonus_fc_bb]&sangsi=$dutang[sangsi]&kompensasi=$kompensasi&tabungan=$dutang[tabungan]&cicilan=$dutang[cicilan]&cicilan_prod=$dutang[jml_cicilan_prod]&pengurang=$pengurang&thp=$thp&bop_diambil=$dutang[bop_awal]&bop_kantor=$dutang[bop_akhir]\"><img src=\"../gambar/FIX_0.bmp\" height=\"20\" width=\"50\" border=\"0\" /></a></td>";
	}
		$Ttotal_bop=$Ttotal_bop+$total_bop;
		$Trl_prod=$Trl_prod+$rl_prod;
		$Tbop_awal=$Tbop_awal+$dutang['bop_awal'];
		$Tbop_tengah=$Tbop_tengah+$dutang['bop_tengah'];
		$Tbonus_ip=$Tbonus_ip+$dutang['bonus_ip'];
		$Tbonus_shp=$Tbonus_shp+$dutang['bonus_shp'];
		$Tbonus_mati=$Tbonus_mati+$dutang['bonus_mati'];
		$Tbonus_fc=$Tbonus_fc+$dutang['bonus_fc'];
		$Tbonus_fc_bb=$Tbonus_fc_bb+$dutang['bonus_fc_bb'];
		$Tsangsi=$Tsangsi+$dutang['sangsi'];
		$Tkompensasi=$Tkompensasi+$kompensasi;
		$Ttabungan=$Ttabungan+$dutang['tabungan'];
		$Tcicilan=$Tcicilan+$dutang['cicilan'];
		$Tcicilan_prod=$Tcicilan_prod+$dutang['jml_cicilan_prod'];
		$Tpengurang=$Tpengurang+$pengurang;
		$total_sapronak = $total_sapronak+$total_sap;
		$total_rsapronak = $total_rsapronak+$total_rsap;
		$total_payam = $total_payam+$Ttotal_ayam;
		$Tutang = $Tutang+$utang9;
		$Tthp=$Tthp+$dutang['thp_ternak'];
		echo"</tr>";$i++;
	}
	$total_sapronak2=ribuan($total_sapronak);$total_payam2=ribuan($total_payam);$Trl_prod2=ribuan($Trl_prod);$Tbop_awal2=ribuan($Tbop_awal);$Tcicilan_prod2=ribuan($Tcicilan_prod);$Tbonus_ip2=ribuan($Tbonus_ip);$Tbonus_shp2=ribuan($Tbonus_shp);$Tbonus_mati2=ribuan($Tbonus_mati);$Tbonus_fc2=ribuan($Tbonus_fc);$Tbonus_fc_bb2=ribuan($Tbonus_fc_bb);$Tsangsi2=ribuan($Tsangsi);$Tkompensasi2=ribuan($Tkompensasi);$Ttabungan2=ribuan($Ttabungan);$Tcicilan2=ribuan($Tcicilan);$Tpengurang2=ribuan($Tpengurang);
	$total_rsapronak2=ribuan($total_rsapronak);$Tutang2=ribuan($Tutang);$Tthp2=ribuan($Tthp);$Ttotal_bop2=ribuan($Ttotal_bop);
	echo"<tr bgcolor=\"red\"><td colspan=\"4\" align=\"center\"><b>Total</b></td><td align=\"right\">$total_sapronak2</td><td align=\"right\">$total_rsapronak2</td><td align=\"right\">$total_payam2</td><td align=\"right\">$Tbop_awal2</td><td align=\"right\">$Tbonus_ip2</td><td align=\"right\">$Tbonus_shp2</td><td align=\"right\">$Tbonus_mati2</td><td align=\"right\">$Tbonus_fc2</td><td align=\"right\">$Tbonus_fc_bb2</td><td align=\"right\">$Tsangsi</td><td align=\"right\">$Tkompensasi2</td><td align=\"right\">$Ttabungan2</td><td align=\"right\">$Tcicilan2</td><td align=\"right\">$Tcicilan_prod2</td><td align=\"right\">$Tpengurang2</td><td align=\"right\">$Tthp2</td><td></td></tr>";
}else
{
 echo"<tr><tr bgcolor=\"$a\"><td colspan=\"21\" align=\"center\">Data Kosong</td></tr>";
}

}else
{
$qutang = @mysql_query("select * from rhpp where $field like '%$keyword%' order by id_produksi");
$butang = @mysql_num_rows($qutang);
if($butang > 0)
{   $i=0;
	while($dutang = @mysql_fetch_assoc($qutang))
	{
if(($i%2) == 1)
{
	$a ="#FFFFFF";
}else
{
	$a ="#CCCCCC";
}		
		$qf = @mysql_query("select * from farm where id_farm='$dutang[id_farm]'");
		$df = @mysql_fetch_assoc($qf);
		echo"<tr><tr bgcolor=\"$a\">
		<td align=\"center\">$dutang[id_produksi]</td>
		<td align=\"center\">$dutang[id_farm]</td>
		<td align=\"left\">$df[nama]</td>
		<td align=\"left\">$df[desa]</td>";
		//jual sapronak
		$qprd = mysql_query("select * from produksi where id_produksi='$dutang[id_produksi]'");
		$dprd = mysql_fetch_assoc($qprd);
		$kontrak = $dprd['id_kontrak'];
		$id_kontrak=substr(($kontrak),0,3);
		$total_sap=0;$total_rsap=0;$Ttotal_ayam=0;$kompensasi=0;
		if($id_kontrak=='MKL')
		{
			if($dutang['sapronak']=='')
			{
		
			$query = @mysql_query("SELECT * FROM jual where id_produksi='$dutang[id_produksi]' ")or die(mysql_error());
			$jumlah = @mysql_num_rows($query);
			while($djual = mysql_fetch_assoc($query))
			{
				$id_barang = $djual['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				$hrg = $data2['hrg_beli'];
				$sTotal2 = $hrg*$djual['qty'];
				$total_sap = $total_sap+$sTotal2;
			}
			
			}else
			{
				$total_sap=$dutang['sapronak'];
			}
			
			//retur
			if($dutang['retur_sapronak']=='')
			{

			$qretur = @mysql_query("SELECT * FROM retur_jual where id_produksi='$dutang[id_produksi]' ")or die(mysql_error());
			$jretur = @mysql_num_rows($qretur);
			while($dretur = mysql_fetch_assoc($qretur))
			{
				$id_barang = $dretur['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				$hrg = $data2['hrg_beli'];
				$retur = $hrg*$dretur['qty'];
				$total_rsap = $total_rsap+$retur;
			}
			
			}else
			{
				$total_rsap = $dutang['retur_sapronak'];
			}
			
			//PJA
			if($dutang['p_ayam']=='')
			{

			$qayam = " SELECT * FROM pja where id_produksi='$dutang[id_produksi]' ";
			$hayam = mysql_query( $qayam ) or die(mysql_error());
			while( $dayam = mysql_fetch_assoc($hayam) )
			{
			$total_ayam = $dayam['tonase_real']*$dayam['hrg_real'];
			$Ttotal_ayam=$Ttotal_ayam+$total_ayam;
			}
			
			}else
			{
			$Ttotal_ayam=$dutang['p_ayam'];
			}
			
		}else
		{
			//jual sap
			if($dutang['sapronak']=='')
			{

			$query = @mysql_query("SELECT * FROM jual where id_produksi='$dutang[id_produksi]' order by id_barang ")or die(mysql_error());
			$jumlah = @mysql_num_rows($query);
			$kontrak = mysql_query(" select * from kontrak_kmt where id_kontrak='$kontrak' ");
			$dkontrak = mysql_fetch_assoc($kontrak);
			while($djual = mysql_fetch_assoc($query))
			{
				$id_barang = $djual['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				if(substr(($djual['id_barang']),6,3)=='DOC')
				{
				$hrg = $dkontrak['DOC'];
				}else
				if(substr(($djual['id_barang']),6,3)=='BST')
				{
				$hrg = $dkontrak['BST'];
				}else
				if(substr(($djual['id_barang']),6,3)=='STR')
				{
				$hrg = $dkontrak['STR'];
				}else
				if(substr(($djual['id_barang']),6,3)=='FNS')
				{
				$hrg = $dkontrak['FNS'];
				}else
				{
				$hrg = $data2['hrg_jual'];
				}
				$sTotal2 = $hrg*$djual['qty'];
				$total_sap = $total_sap+$sTotal2;
			}
			}else
			{
				$total_sap=$dutang['sapronak'];
			}
			
			//retur
			if($dutang['retur_sapronak']=='')
			{

			$qretur = @mysql_query("SELECT * FROM retur_jual where id_produksi='$dutang[id_produksi]' ")or die(mysql_error());
			$jretur = @mysql_num_rows($qretur);
			while($dretur = mysql_fetch_assoc($qretur))
			{
				$id_barang = $dretur['id_barang'];
				$query2 = mysql_query("SELECT * FROM barang where id_barang='$id_barang'")or die(mysql_error());	
				$data2 = mysql_fetch_assoc($query2);
				if(substr(($dretur['id_barang']),6,3)=='DOC')
				{
				$hrg = $dkontrak['DOC'];
				}else
				if(substr(($dretur['id_barang']),6,3)=='BST')
				{
				$hrg = $dkontrak['BST'];
				}else
				if(substr(($dretur['id_barang']),6,3)=='STR')
				{
				$hrg = $dkontrak['STR'];
				}else
				if(substr(($dretur['id_barang']),6,3)=='FNS')
				{
				$hrg = $dkontrak['FNS'];
				}else
				{
				$hrg = $data2['hrg_jual'];
				}
				$retur = $hrg*$dretur['qty'];
				$total_rsap = $total_rsap+$retur;
			}
			}else
			{
				$total_rsap = $dutang['retur_sapronak'];
			}
			
			//PJA
			if($dutang['p_ayam']=='')
			{

			$qayam = " SELECT * FROM pja where id_produksi='$dutang[id_produksi]' ";
			$hayam = mysql_query( $qayam ) or die(mysql_error());
			while( $dayam = mysql_fetch_assoc($hayam) )
			{
			$bw = @substr(($dayam['tonase_real']/$dayam['ekor_real']),0,4);
			$kayam = @mysql_query ("SELECT * FROM harga_ayam where id_harga = '$dkontrak[id_harga]' and (bb_min <= $bw) and ($bw <= bb_max)");
			$kayam3 = @mysql_fetch_assoc($kayam);
			$hrg_ayam = $kayam3['harga'];
			$total_ayam = $dayam['tonase_real']*$hrg_ayam;
			$Ttotal_ayam=$Ttotal_ayam+$total_ayam;
			}
			
			}else
			{
			$Ttotal_ayam=$dutang['p_ayam'];
			}
			
		}
		$utang = ($Ttotal_ayam+$total_rsap)-$total_sap;
		$utang2=ribuan($utang);
		$kompensasi2=ribuan($kompensasi);
		$total_sap2=ribuan($total_sap);
		$total_rsap2=ribuan($total_rsap);
		$Ttotal_ayam2=ribuan($Ttotal_ayam);
		$panenbulan = tgl_indo2($dutang['panenbulan']);
	echo"<td align=\"right\">$total_sap2</td>";
	echo"<td align=\"right\">$total_rsap2</td>";
	echo"<td align=\"right\">$Ttotal_ayam2</td>";
	
	//bop awal	
	if($dutang['bop_awal'] != '')
	{
	$bop_awal=ribuan($dutang['bop_awal']);
	echo"<td align=\"right\">$bop_awal</td>";
	}else
	{
	$bop_awal=0;
	echo"<td align=\"right\">0</td>";
	}

	//bonus IP
	if($dutang['bonus_ip'] != '')
	{
	$bonus_ip=ribuan($dutang['bonus_ip']);
	echo"<td align=\"right\">$bonus_ip</td>";
	}else
	{
	$bonus_ip=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus SHP
	if($dutang['bonus_shp'] != '')
	{
	$bonus_shp=ribuan($dutang['bonus_shp']);
	echo"<td align=\"right\">$bonus_shp</td>";
	}else
	{
	$bonus_shp=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus Kematian
	if($dutang['bonus_mati'] != '')
	{
	$bonus_mati=ribuan($dutang['bonus_mati']);
	echo"<td align=\"right\">$bonus_mati</td>";
	}else
	{
	$bonus_mati=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus fc
	if($dutang['bonus_fc'] != '')
	{
	$bonus_fc=ribuan($dutang['bonus_fc']);
	echo"<td align=\"right\">$bonus_fc</td>";
	}else
	{
	$bonus_fc=0;
	echo"<td align=\"right\">0</td>";
	}
	//bonus bb fc
	if($dutang['bonus_fc_bb'] != '')
	{
	$bonus_fc_bb=ribuan($dutang['bonus_fc_bb']);
	echo"<td align=\"right\">$bonus_fc_bb</td>";
	}else
	{
	$bonus_fc_bb=0;
	echo"<td align=\"right\">0</td>";
	}
	//sangsi
	if($dutang['sangsi'] != '')
	{
	$sangsi=ribuan($dutang['sangsi']);
	echo"<td align=\"right\">$sangsi</td>";
	}else
	{
	$sangsi=0;
	echo"<td align=\"right\">0</td>";
	}
	//kompensasi
	$kompensasi=0;
	if(($dutang['npenambah_lain1'] != '')or($dutang['npenambah_lain2'] != '')or($dutang['npenambah_lain3'] != '')or($dutang['npenambah_lain4'] != '')or($dutang['npenambah_lain5'] != ''))
	{
	$kompensasi=$dutang['npenambah_lain1']+$dutang['npenambah_lain2']+$dutang['npenambah_lain3']+$dutang['npenambah_lain4']+$dutang['npenambah_lain5'];
	$kompensasi2=ribuan($kompensasi);
	echo"<td align=\"right\">$kompensasi2</td>";
	}else
	{
	$kompensasi=0;
	echo"<td align=\"right\">0</td>";
	}
	//tabungan
	if($dutang['tabungan'] != '')
	{
	$tabungan=ribuan($dutang['tabungan']);
	echo"<td align=\"right\">$tabungan</td>";
	}else
	{
	$tabungan=0;
	echo"<td align=\"right\">0</td>";
	}
	//cicilan hutang uang dan alat
	if($dutang['cicilan'] != '')
	{
	$cicilan =ribuan($dutang['cicilan']);
	echo"<td align=\"right\">$cicilan</td>";
	}else
	{
	$cicilan ==0;
	echo"<td align=\"right\">0</td>";
	}
	//cicilan hutang produksi
	if($dutang['jml_cicilan_prod'] != '')
	{
	$jml_cicilan_prod =ribuan($dutang['jml_cicilan_prod']);
	echo"<td align=\"right\">$jml_cicilan_prod</td>";
	}else
	{
	$jml_cicilan_prod ==0;
	echo"<td align=\"right\">0</td>";
	}
	//pengurang
	$pengurang=0;
	if(($dutang['npengurang_lain1'] != '')or($dutang['npengurang_lain2'] != '')or($dutang['npengurang_lain3'] != '')or($dutang['npengurang_lain4'] != ''))
	{
	$pengurang=$dutang['npengurang_lain1']+$dutang['npengurang_lain2']+$dutang['npengurang_lain3']+$dutang['npengurang_lain4'];
	$pengurang2=ribuan($pengurang);
	echo"<td align=\"right\">$pengurang2</td>";
	}else
	{
	$pengurang=0;
	echo"<td align=\"right\">0</td>";
	}

	//if($dutang['panenbulan']!='0000-00-00')
	if($dutang['tanggal']!='0000-00-00')
	{
	$thp = $dutang['thp_ternak'];
	$thp2=ribuan($thp);
	echo"<td align=\"right\">$thp2</td>";
	}else
	{
	$thp = 0;
	$thp2=ribuan($thp);
	echo"<td align=\"right\">$thp2</td>";
	}
	//periode produksi
	if($dutang['panenbulan']!='0000-00-00')
	{
	echo"<td valign=\"top\" align=\"center\">$panenbulan</td>";
	}else
	{
	echo"<td valign=\"top\" align=\"center\"><a href=\"fix.php?id=$dutang[id_produksi]&sap=$dutang[sapronak]&ret=$dutang[retur_sapronak]&pja=$dutang[p_ayam]&kontrak=$kontrak&nama=$df[nama]&alamat=$df[desa]&id_farm=$dutang[id_farm]&bop1=$dutang[bop_awal]&bonus_ip=$dutang[bonus_ip]&bonus_shp=$dutang[bonus_shp]&bonus_mati=$dutang[bonus_mati]&bonus_fc=$dutang[bonus_fc]&bonus_fc_bb=$dutang[bonus_fc_bb]&sangsi=$dutang[sangsi]&kompensasi=$kompensasi&tabungan=$dutang[tabungan]&cicilan=$dutang[cicilan]&cicilan_prod=$dutang[jml_cicilan_prod]&pengurang=$pengurang&thp=$thp&bop_diambil=$dutang[bop_awal]&bop_kantor=$dutang[bop_akhir]\"><img src=\"../gambar/FIX_0.bmp\" height=\"20\" width=\"50\" border=\"0\" /></a></td>";
	}
		$Ttotal_bop=$Ttotal_bop+$total_bop;
		$Trl_prod=$Trl_prod+$rl_prod;
		$Tbop_awal=$Tbop_awal+$dutang['bop_awal'];
		$Tbop_tengah=$Tbop_tengah+$dutang['bop_tengah'];
		$Tbonus_ip=$Tbonus_ip+$dutang['bonus_ip'];
		$Tbonus_shp=$Tbonus_shp+$dutang['bonus_shp'];
		$Tbonus_mati=$Tbonus_mati+$dutang['bonus_mati'];
		$Tbonus_fc=$Tbonus_fc+$dutang['bonus_fc'];
		$Tbonus_fc_bb=$Tbonus_fc_bb+$dutang['bonus_fc_bb'];
		$Tsangsi=$Tsangsi+$dutang['sangsi'];
		$Tkompensasi=$Tkompensasi+$kompensasi;
		$Ttabungan=$Ttabungan+$dutang['tabungan'];
		$Tcicilan=$Tcicilan+$dutang['cicilan'];
		$Tcicilan_prod=$Tcicilan_prod+$dutang['jml_cicilan_prod'];
		$Tpengurang=$Tpengurang+$pengurang;
		$total_sapronak = $total_sapronak+$total_sap;
		$total_rsapronak = $total_rsapronak+$total_rsap;
		$total_payam = $total_payam+$Ttotal_ayam;
		$Tutang = $Tutang+$utang9;
		$Tthp=$Tthp+$dutang['thp_ternak'];
		echo"</tr>";$i++;
	}
	$total_sapronak2=ribuan($total_sapronak);$total_payam2=ribuan($total_payam);$Trl_prod2=ribuan($Trl_prod);$Tbop_awal2=ribuan($Tbop_awal);$Tcicilan_prod2=ribuan($Tcicilan_prod);$Tbonus_ip2=ribuan($Tbonus_ip);$Tbonus_shp2=ribuan($Tbonus_shp);$Tbonus_mati2=ribuan($Tbonus_mati);$Tbonus_fc2=ribuan($Tbonus_fc);$Tbonus_fc_bb2=ribuan($Tbonus_fc_bb);$Tsangsi2=ribuan($Tsangsi);$Tkompensasi2=ribuan($Tkompensasi);$Ttabungan2=ribuan($Ttabungan);$Tcicilan2=ribuan($Tcicilan);$Tpengurang2=ribuan($Tpengurang);
	$total_rsapronak2=ribuan($total_rsapronak);$Tutang2=ribuan($Tutang);$Tthp2=ribuan($Tthp);$Ttotal_bop2=ribuan($Ttotal_bop);
	echo"<tr bgcolor=\"red\"><td colspan=\"4\" align=\"center\"><b>Total</b></td><td align=\"right\">$total_sapronak2</td><td align=\"right\">$total_rsapronak2</td><td align=\"right\">$total_payam2</td><td align=\"right\">$Tbop_awal2</td><td align=\"right\">$Tbonus_ip2</td><td align=\"right\">$Tbonus_shp2</td><td align=\"right\">$Tbonus_mati2</td><td align=\"right\">$Tbonus_fc2</td><td align=\"right\">$Tbonus_fc_bb2</td><td align=\"right\">$Tsangsi</td><td align=\"right\">$Tkompensasi2</td><td align=\"right\">$Ttabungan2</td><td align=\"right\">$Tcicilan2</td><td align=\"right\">$Tcicilan_prod2</td><td align=\"right\">$Tpengurang2</td><td align=\"right\">$Tthp2</td><td></td></tr>";
}else
{
 echo"<tr><tr bgcolor=\"$a\"><td colspan=\"21\" align=\"center\">Data Kosong</td></tr>";
}
}
?>
</table>
