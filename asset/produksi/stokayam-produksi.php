<?php
include "";
?>
<table border="0" cellpadding="0" width="1200" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
<tr><td>
Stok Ayam, 
Tanggal : <?php $todayr2=date("Y-m-d"); echo date("d M Y"); ?>
<table border="1" cellpadding="0" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
<tr align="center">
	<td align="center" width="100" bgcolor="#999999" valign="middle">1,2 - 1,4</td>
	<td align="left" valign="top" bgcolor="#FFFFFF">
	<table border="1" width="1100" cellpadding="0" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
	<tr><td><b>No.</td>
	<td><b>Id.Produksi</td>
	<td><b>Nama</td>
	<td><b>Alamat</td>
	<td><b>Pop.(ekor)</td>
	<td><b>Umur</td>
	<td><b>Mati(ekor)</td>
	<td><b>Killing(ekor)</td>
	<td><b>Jatah(ekor)</td>
	<td><b>Panen(ekor)</td>
	<td><b>Sisa(ekor)</td></tr>
<?php
$a1 = 1;
$qp1 = mysql_query("select * from rhpp where panenbulan='0000-00-00' order by id_produksi");
while ($dp1 = mysql_fetch_array($qp1)) {
	$id_produksi1=$dp1['id_produksi'];
	//mencari nama peternak
	$qf1 = mysql_query("select * from farm where id_farm='$dp1[id_farm]'");
	$df1 = mysql_fetch_array($qf1);
	//mencari beban
	$bb1=0;
	$qbb1 =  mysql_query("select * from beban where id_produksi='$id_produksi1'");
	while($dbb1 = mysql_fetch_array($qbb1))
	{
		$bb1 = $bb1+$dbb1['qty'];	
	}
	//mencari tgl chick in dan populasi
	$populasi1=0;$populasi11=0;$umur1=0; $chick_in11='';
	$qpop1 =  mysql_query("select * from jual where id_produksi='$id_produksi1' and id_barang like 'D-%'");
	while($dpop1 = mysql_fetch_array($qpop1))
	{
		$populasi11 = $populasi11+$dpop1['qty'];
		$chick_in11 = $dpop1['tanggal'];
	}
	$populasi1=$populasi11-$bb1;
	$rpopulasi1=$populasi1;	
	$chick_in1 = $chick_in11;
	if(!empty($chick_in11)) {
		$today1 = date ("Y-m-d");
		$umur1 = selisihTgl($today1,$chick_in1);
	} else {
		$umur1 = 0;
	}
	if(($umur1 >= 28)and($umur1 <= 30)){
		//mencari kematian
		$kematian1=0;
		$qmt1 =  mysql_query("select * from kematian where id_produksi='$id_produksi1'");
		while($dmt1 = mysql_fetch_array($qmt1))
		{
			$kematian1=$kematian1+$dmt1['jml'];
		}
		//mencari killing
		$kill1=0;
		$qkl1 =  mysql_query("select * from killing where id_produksi='$id_produksi1'");
		while($dkl1 = mysql_fetch_array($qkl1))
		{
			$kill1=$kill1+$dkl1['jml_ekor'];
		}
		$rkill1=$kill1;
		//mencari jatah
		$jta1=0;
		$qjta1 =  mysql_query("select * from jatah_ayam where id_produksi='$id_produksi1'");
		while($djta1 = mysql_fetch_array($qjta1))
		{
			$jta1=$jta1+$djta1['jml_ekor'];
		}
		$rjta1=$jta1;
		//mencari ayam terpanen
		$pn1=0;
		$qpn1 =  mysql_query("select * from pja where id_produksi='$id_produksi1'");
		while($dpn1 = mysql_fetch_array($qpn1))
		{
			if($dpn1['ekor_real']=='')
			{
			$pn1=$pn1+$dpn1['ekor_rcn'];
			}else
			{
			$pn1=$pn1+$dpn1['ekor_real'];
			}
		}
		$rpn1=$pn1;
		//sisa ayam di kandang
		$sisa1 = $populasi1-($kill1+$kematian1+$jta1+$pn1);
		$rsisa1=$sisa1;
		
		$Tkill1 = $Tkill1+$kill1;
		$Tpop1 = $Tpop1+$populasi1;
		$Tkematian1 = $Tkematian1+$kematian1;
		$Tjta1 = $Tjta1+$jta1;
		$Tpn1 = $Tpn1+$pn1;
		$Tsisa1 = $Tsisa1+$sisa1;
		echo"<tr>
		<td>$a1.</td>
		<td>$id_produksi1</td>
		<td>$df1[nama]</td>
		<td>$df1[desa]</td>
		<td align=\"right\">$rpopulasi1</td>
		<td align=\"right\">$umur1</td>
		<td align=\"right\">$kematian1</td>
		<td align=\"right\">$rkill1</td>
		<td align=\"right\">$rjta1</td>
		<td align=\"right\">$rpn1</td>
		<td align=\"right\">$rsisa1</td>
		";
		echo"</tr>";
		$a1++;
	}
}
	$rTkill1 = $Tkill1;
	$rTpop1 = $Tpop1;
	$rTkematian1 = $Tkematian1;
	$rTjta1 = $Tjta1;
	$rTpn1 = $Tpn1;
	$rTsisa1 = $Tsisa1;
echo"<tr bgcolor=\"red\"><td colspan=\"4\" align=\"center\"><b>TOTAL</td><td align=\"right\">$rTpop1</td><td align=\"right\"></td><td align=\"right\">$rTkematian1</td><td align=\"right\">$rTkill1</td><td align=\"right\">$rTjta1</td><td align=\"right\">$rTpn1</td><td align=\"right\">$rTsisa1</td></tr>";
	
?>	</table>
	</td>
</tr>
<tr align="center">
	<td align="center"  bgcolor="#999999" valign="middle">1,4 - 1,6</td>
	<td bgcolor="#FFFFFF">
	<table  width="1100" border="1" cellpadding="0" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
	<tr><td><b>No.</td>
	<td><b>Id.Produksi</td>
	<td><b>Nama</td>
	<td><b>Alamat</td>
	<td><b>Pop.(ekor)</td>
	<td><b>Umur</td>
	<td><b>Mati(ekor)</td>
	<td><b>Killing(ekor)</td>
	<td><b>Jatah(ekor)</td>
	<td><b>Panen(ekor)</td>
	<td><b>Sisa(ekor)</td></tr>
<?php
$a2 = 1;
$qp2 = mysql_query("select * from rhpp where panenbulan='0000-00-00' order by id_produksi");
while($dp2 = mysql_fetch_array($qp2))
{
	
	$id_produksi2=$dp2['id_produksi'];
	//mencari nama peternak
	$qf2 = mysql_query("select * from farm where id_farm='$dp2[id_farm]'");
	$df2 = mysql_fetch_array($qf2);
	//mencari beban
	$bb2=0;
	$qbb2 =  mysql_query("select * from beban where id_produksi='$id_produksi2'");
	while($dbb2 = mysql_fetch_array($qbb2))
	{
		$bb2 = $bb2+$dbb2['qty'];	
	}
	//mencari tgl chick in dan populasi
	$populasi2=0;$populasi22=0;$umur2=0; $chick_in22='';
	$qpop2 =  mysql_query("select * from jual where id_produksi='$id_produksi2' and id_barang like 'D-%'");
	while($dpop2 = mysql_fetch_array($qpop2))
	{
		$populasi22 = $populasi22+$dpop2['qty'];
		$chick_in22 = $dpop2['tanggal'];
	}
	$populasi2=$populasi22-$bb2;
	$rpopulasi2=$populasi2;	
	$chick_in2 = $chick_in22;
	if(!empty($chick_in22)) {
		$today2 = date ("Y-m-d");
		$umur2 = selisihTgl($today2,$chick_in2);
	} else {
		$umur2 = 0;
	}
	if(($umur2 >= 31)and($umur2 <= 32)){
		//mencari kematian
		$kematian2=0;
		$qmt2 =  mysql_query("select * from kematian where id_produksi='$id_produksi2'");
		while($dmt2 = mysql_fetch_array($qmt2))
		{
			$kematian2=$kematian2+$dmt2['jml'];
		}
		//mencari killing
		$kill2=0;
		$qkl2 =  mysql_query("select * from killing where id_produksi='$id_produksi2'");
		while($dkl2 = mysql_fetch_array($qkl2))
		{
			$kill2=$kill2+$dkl2['jml_ekor'];
		}
		$rkill2=$kill2;
		//mencari jatah
		$jta2=0;
		$qjta2 =  mysql_query("select * from jatah_ayam where id_produksi='$id_produksi2'");
		while($djta2 = mysql_fetch_array($qjta2))
		{
			$jta2=$jta2+$djta2['jml_ekor'];
		}
		$rjta2=$jta2;
		//mencari ayam terpanen
		$pn2=0;
		$qpn2 =  mysql_query("select * from pja where id_produksi='$id_produksi2'");
		while($dpn2 = mysql_fetch_array($qpn2))
		{
			if($dpn2['ekor_real']=='')
			{
			$pn2=$pn2+$dpn2['ekor_rcn'];
			}else
			{
			$pn2=$pn2+$dpn2['ekor_real'];
			}
		}
		$rpn2=$pn2;
		//sisa ayam di kandang
		$sisa2 = $populasi2-($kill2+$kematian2+$jta2+$pn2);
		$rsisa2=$sisa2;
		
		$Tkill2 = $Tkill2+$kill2;
		$Tpop2 = $Tpop2+$populasi2;
		$Tkematian2 = $Tkematian2+$kematian2;
		$Tjta2 = $Tjta2+$jta2;
		$Tpn2 = $Tpn2+$pn2;
		$Tsisa2 = $Tsisa2+$sisa2;
		echo"<tr>
		<td>$a2.</td>
		<td>$id_produksi2</td>
		<td>$df2[nama]</td>
		<td>$df2[desa]</td>
		<td align=\"right\">$rpopulasi2</td>
		<td align=\"right\">$umur2</td>
		<td align=\"right\">$kematian2</td>
		<td align=\"right\">$rkill2</td>
		<td align=\"right\">$rjta2</td>
		<td align=\"right\">$rpn2</td>
		<td align=\"right\">$rsisa2</td>
		";
		echo"</tr>";
		$a2++;
	}
}
	$rTkill2 = $Tkill2;
	$rTpop2 = $Tpop2;
	$rTkematian2 = $Tkematian2;
	$rTjta2 = $Tjta2;
	$rTpn2 = $Tpn2;
	$rTsisa2 = $Tsisa2;
echo"<tr bgcolor=\"red\"><td colspan=\"4\" align=\"center\"><b>TOTAL</td><td align=\"right\">$rTpop2</td><td align=\"right\"></td><td align=\"right\">$rTkematian2</td><td align=\"right\">$rTkill2</td><td align=\"right\">$rTjta2</td><td align=\"right\">$rTpn2</td><td align=\"right\">$rTsisa2</td></tr>";
?>  </table>
	</td>
</tr>
<tr align="center">
	<td align="center" bgcolor="#999999" valign="middle">1,6 - 1,8</td>
	<td align="center" bgcolor="#FFFFFF">
	<table  width="1100" border="1" cellpadding="0" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
	<tr><td><b>No.</td>
	<td><b>Id.Produksi</td>
	<td><b>Nama</td>
	<td><b>Alamat</td>
	<td><b>Pop.(ekor)</td>
	<td><b>Umur</td>
	<td><b>Mati(ekor)</td>
	<td><b>Killing(ekor)</td>
	<td><b>Jatah(ekor)</td>
	<td><b>Panen(ekor)</td>
	<td><b>Sisa(ekor)</td></tr>
<?php
$a3 = 1;
$qp3 = mysql_query("select * from rhpp where panenbulan='0000-00-00' order by id_produksi");
while($dp3 = mysql_fetch_array($qp3))
{
	
	$id_produksi3=$dp3['id_produksi'];
	//mencari nama peternak
	$qf3 = mysql_query("select * from farm where id_farm='$dp3[id_farm]'");
	$df3 = mysql_fetch_array($qf3);
	//mencari beban
	$bb3=0;
	$qbb3 =  mysql_query("select * from beban where id_produksi='$id_produksi3'");
	while($dbb3 = mysql_fetch_array($qbb3))
	{
		$bb3 = $bb3+$dbb3['qty'];	
	}
	//mencari tgl chick in dan populasi
	$populasi3=0;$populasi33=0;$umur3=0; $chick_in33='';
	$qpop3 =  mysql_query("select * from jual where id_produksi='$id_produksi3' and id_barang like 'D-%'");
	while($dpop3 = mysql_fetch_array($qpop3))
	{
		$populasi33 = $populasi33+$dpop3['qty'];
		$chick_in33 = $dpop3['tanggal'];
	}
	$populasi3=$populasi33-$bb3;
	$rpopulasi3=$populasi3;	
	$chick_in3 = $chick_in33;
	if(!empty($chick_in33)) {
		$today3 = date ("Y-m-d");
		$umur3 = selisihTgl($today3,$chick_in3);
	} else {
		$umur3 = 0;
	}
	if(($umur3 >= 33)and($umur3 <= 35)){
		//mencari kematian
		$kematian3=0;
		$qmt3 =  mysql_query("select * from kematian where id_produksi='$id_produksi3'");
		while($dmt3 = mysql_fetch_array($qmt3))
		{
			$kematian3=$kematian3+$dmt3['jml'];
		}
		//mencari killing
		$kill3=0;
		$qkl3 =  mysql_query("select * from killing where id_produksi='$id_produksi3'");
		while($dkl3 = mysql_fetch_array($qkl3))
		{
			$kill3=$kill3+$dkl3['jml_ekor'];
		}
		$rkill3=$kill3;
		//mencari jatah
		$jta3=0;
		$qjta3 =  mysql_query("select * from jatah_ayam where id_produksi='$id_produksi3'");
		while($djta3 = mysql_fetch_array($qjta3))
		{
			$jta3=$jta3+$djta3['jml_ekor'];
		}
		$rjta3=$jta3;
		//mencari ayam terpanen
		$pn3=0;
		$qpn3 =  mysql_query("select * from pja where id_produksi='$id_produksi3'");
		while($dpn3 = mysql_fetch_array($qpn3))
		{
			if($dpn3['ekor_real']=='')
			{
			$pn3=$pn3+$dpn3['ekor_rcn'];
			}else
			{
			$pn3=$pn3+$dpn3['ekor_real'];
			}
		}
		$rpn3=$pn3;
		//sisa ayam di kandang
		$sisa3 = $populasi3-($kill3+$kematian3+$jta3+$pn3);
		$rsisa3=$sisa3;
		
		$Tkill3 = $Tkill3+$kill3;
		$Tpop3 = $Tpop3+$populasi3;
		$Tkematian3 = $Tkematian3+$kematian3;
		$Tjta3 = $Tjta3+$jta3;
		$Tpn3 = $Tpn3+$pn3;
		$Tsisa3 = $Tsisa3+$sisa3;
		echo"<tr>
		<td>$a3.</td>
		<td>$id_produksi3</td>
		<td>$df3[nama]</td>
		<td>$df3[desa]</td>
		<td align=\"right\">$rpopulasi3</td>
		<td align=\"right\">$umur3</td>
		<td align=\"right\">$kematian3</td>
		<td align=\"right\">$rkill3</td>
		<td align=\"right\">$rjta3</td>
		<td align=\"right\">$rpn3</td>
		<td align=\"right\">$rsisa3</td>
		";
		echo"</tr>";
		$a3++;
	}
}
	$rTkill3 = $Tkill3;
	$rTpop3 = $Tpop3;
	$rTkematian3 = $Tkematian3;
	$rTjta3 = $Tjta3;
	$rTpn3 = $Tpn3;
	$rTsisa3 = $Tsisa3;
echo"<tr bgcolor=\"red\"><td colspan=\"4\" align=\"center\"><b>TOTAL</td><td align=\"right\">$rTpop3</td><td align=\"right\"></td><td align=\"right\">$rTkematian3</td><td align=\"right\">$rTkill3</td><td align=\"right\">$rTjta3</td><td align=\"right\">$rTpn3</td><td align=\"right\">$rTsisa3</td></tr>";
?>  </table>
	</td>
</tr>
<tr align="center">
	<td align="center" bgcolor="#999999">> 1,8</td>
	<td align="center" bgcolor="#FFFFFF">
	<table  width="1100" border="1" cellpadding="0" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
	<tr><td><b>No.</td>
	<td><b>Id.Produksi</td>
	<td><b>Nama</td>
	<td><b>Alamat</td>
	<td><b>Pop.(ekor)</td>
	<td><b>Umur</td>
	<td><b>Mati(ekor)</td>
	<td><b>Killing(ekor)</td>
	<td><b>Jatah(ekor)</td>
	<td><b>Panen(ekor)</td>
	<td><b>Sisa(ekor)</td></tr>
<?php
$a4 = 1;
$qp4 = mysql_query("select * from rhpp where panenbulan='0000-00-00' order by id_produksi");
while($dp4 = mysql_fetch_array($qp4))
{
	
	$id_produksi4=$dp4['id_produksi'];
	//mencari nama peternak
	$qf4 = mysql_query("select * from farm where id_farm='$dp4[id_farm]'");
	$df4 = mysql_fetch_array($qf4);
	//mencari beban
	$bb4=0;
	$qbb4 =  mysql_query("select * from beban where id_produksi='$id_produksi4'");
	while($dbb4 = mysql_fetch_array($qbb4))
	{
		$bb4 = $bb4+$dbb4['qty'];	
	}
	//mencari tgl chick in dan populasi
	$populasi4=0;$populasi44=0;$umur4=0; $chick_in44='';
	$qpop4 =  mysql_query("select * from jual where id_produksi='$id_produksi4' and id_barang like 'D-%'");
	while($dpop4 = mysql_fetch_array($qpop4))
	{
		$populasi44 = $populasi44+$dpop4['qty'];
		$chick_in44 = $dpop4['tanggal'];
	}
	$populasi4=$populasi44-$bb4;
	$rpopulasi4=$populasi4;	
	$chick_in4 = $chick_in44;
	if(!empty($chick_in44)) {
		$today4 = date ("Y-m-d");
		$umur4 = selisihTgl($today4,$chick_in4);
	} else {
		$umur4 = 0;
	}
	if($umur4 > 35){
		//mencari kematian
		$kematian4=0;
		$qmt4 =  mysql_query("select * from kematian where id_produksi='$id_produksi4'");
		while($dmt4 = mysql_fetch_array($qmt4))
		{
			$kematian4=$kematian4+$dmt4['jml'];
		}
		//mencari killing
		$kill4=0;
		$qkl4 =  mysql_query("select * from killing where id_produksi='$id_produksi4'");
		while($dkl4 = mysql_fetch_array($qkl4))
		{
			$kill4=$kill4+$dkl4['jml_ekor'];
		}
		$rkill4=$kill4;
		//mencari jatah
		$jta4=0;
		$qjta4 =  mysql_query("select * from jatah_ayam where id_produksi='$id_produksi4'");
		while($djta4 = mysql_fetch_array($qjta4))
		{
			$jta4=$jta4+$djta4['jml_ekor'];
		}
		$rjta4=$jta4;
		//mencari ayam terpanen
		$pn4=0;
		$qpn4 =  mysql_query("select * from pja where id_produksi='$id_produksi4'");
		while($dpn4 = mysql_fetch_array($qpn4))
		{
			if($dpn4['ekor_real']=='')
			{
			$pn4=$pn4+$dpn4['ekor_rcn'];
			}else
			{
			$pn4=$pn4+$dpn4['ekor_real'];
			}
		}
		$rpn4=$pn4;
		//sisa ayam di kandang
		$sisa4 = $populasi4-($kill4+$kematian4+$jta4+$pn4);
		$rsisa4=$sisa4;
		
		$Tkill4 = $Tkill4+$kill4;
		$Tpop4 = $Tpop4+$populasi4;
		$Tkematian4 = $Tkematian4+$kematian4;
		$Tjta4 = $Tjta4+$jta4;
		$Tpn4 = $Tpn4+$pn4;
		$Tsisa4 = $Tsisa4+$sisa4;
		echo"<tr>
		<td>$a4.</td>
		<td>$id_produksi4</td>
		<td>$df4[nama]</td>
		<td>$df4[desa]</td>
		<td align=\"right\">$rpopulasi4</td>
		<td align=\"right\">$umur4</td>
		<td align=\"right\">$kematian4</td>
		<td align=\"right\">$rkill4</td>
		<td align=\"right\">$rjta4</td>
		<td align=\"right\">$rpn4</td>
		<td align=\"right\">$rsisa4</td>
		";
		echo"</tr>";
		$a4++;
	}
}
	$rTkill4 = $Tkill4;
	$rTpop4 = $Tpop4;
	$rTkematian4 = $Tkematian4;
	$rTjta4 = $Tjta4;
	$rTpn4 = $Tpn4;
	$rTsisa4 = $Tsisa4;
echo"<tr bgcolor=\"red\"><td colspan=\"4\" align=\"center\"><b>TOTAL</td><td align=\"right\">$rTpop4</td><td align=\"right\"></td><td align=\"right\">$rTkematian4</td><td align=\"right\">$rTkill4</td><td align=\"right\">$rTjta4</td><td align=\"right\">$rTpn4</td><td align=\"right\">$rTsisa4</td></tr>";
?>  </table>
	</td>
</tr>
<tr align="center" bgcolor="#FF0000">
<td align="center">TotalStok</td>
<td align="right"><?php $totalekora=$Tsisa4+$Tsisa3+$Tsisa2+$Tsisa1; $totalekora2=$totalekora;	echo"$totalekora2";	?></td>
</tr></table>

</td></tr>
<tr><td><br>
Resume Produksi
<table border="1" bordercolor="" cellpadding="4" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
<tr align="center" bgcolor="#999999">
<td rowspan="2" >Populasi</td>
<td rowspan="2" >Jml.Pakan</td>
<td colspan="2" >Panen</td>
<td colspan="2" >Kematian</td>
<td rowspan="2" >BW(Kg)</td>
<td rowspan="2" >FI(Kg)</td>
<td rowspan="2" >Umur(hari)</td>
<td rowspan="2" >FCR</td>
<td rowspan="2" >IP</td>
</tr>
<tr align="center" bgcolor="#999999">
	<td >Ekor</td>
	<td >Tonase</td>
	<td >Ekor</td>
	<td >%</td>
</tr>
<?php
$qr1 = mysql_query("select * from rhpp where panenbulan = '$todayr2' order by id_produksi");
while($dr1 = mysql_fetch_array($qr1))
{
	$id_produksi = $dr1['id_produksi'];
	//mencari beban
	$bb=0;
	$qbb =  mysql_query("select * from beban where id_produksi='$id_produksi'");
	while($dbb = mysql_fetch_array($qbb))
	{
		$bb = $bb+$dbb['qty'];	
	}
	echo $id_produksi;
	//mencari tgl chick in dan populasi
	$populasiz=0;
	$qpop =  mysql_query("select * from jual where id_produksi='$id_produksi' and id_barang like 'D-%'");
	while($dpop = mysql_fetch_array($qpop))
	{
	$populasiz = $populasiz+($dpop['qty']+$dpop['bonus']);
	$chick_in = $dpop['tanggal'];
	}
	$populasi=$populasiz-$bb;
	$Tpopulasi=$Tpopulasi+$populasi;
	$Tpakan_total = $Tpakan_total+$dr1['pakan_total'];
	$Tpanen_ekor = $Tpanen_ekor+$dr1['panen_ekor'];
	$Tpanen_tonase = $Tpanen_tonase+$dr1['panen_tonase'];
	$Tmati = $Tmati+$dr1['mati'];
	//mencari umur
	$s_umur = $populasi*$dr1['avr_umur'];
	$sub_umur = $sub_umur+$s_umur;
	//mencari fc
	$s_fc = $populasi*$dr1['fc'];
	$sub_fc = $sub_fc+$s_fc;
	//mencari ip
	$s_ip = $populasi*$dr1['ip'];
	$sub_ip = $sub_ip+$s_ip;
	//avr bw
	$bw = $populasi*$dr1['avr_bb'];
	$Tbw = $Tbw+$bw;
}
	$rTpopulasi=$Tpopulasi;
	$rTpakan_total=$Tpakan_total;
	$rTpanen_tonase=$Tpanen_tonase;
	$rTpanen_ekor=$Tpanen_ekor;
	$rTmati = $Tmati;
	$persenmati = substr((($Tmati/$Tpopulasi)*100),0,5);
	$Tavr = substr(($Tbw/$Tpopulasi),0,4);
	$fi=substr(($Tpakan_total/$Tpanen_ekor),0,4);
	$avr_umur =substr(($sub_umur/$Tpopulasi),0,5);
	$avr_fc =substr(($sub_fc/$Tpopulasi),0,5);
	$avr_ip =substr(($sub_ip/$Tpopulasi),0,6);
	echo"<tr bgcolor=\"white\">
	<td align=\"right\">$rTpopulasi</td>
	<td align=\"right\">$rTpakan_total</td>
	<td align=\"right\">$rTpanen_ekor</td>
	<td align=\"right\">$rTpanen_tonase</td>
	<td align=\"right\">$rTmati</td>
	<td align=\"right\">$persenmati</td>
	<td align=\"right\">$Tavr</td>
	<td align=\"right\">$fi</td>
	<td align=\"right\">$avr_umur</td>
	<td align=\"right\">$avr_fc</td>
	<td align=\"right\">$avr_ip</td>
	</tr>";
?>
</table>
</td></tr>
</table>
