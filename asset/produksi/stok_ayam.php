<?
include("../koneksi.php");
$qwkt = mysql_query("Select * from user where leveluser='Produksi' ");
$dwkt = mysql_fetch_assoc($qwkt);
$wkt_habis = $dwkt['jam'];
$wkt_habis2 = $wkt_habis+15;
mysql_query("update user set jam='$wkt_habis2' where leveluser='Produksi' ");
?>
<body background="../gambar/bg2.png"><br>
<table border="0" cellpadding="0" width="1200" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
<tr><td>
Stok Ayam, 
Tanggal : <?php include('../fungsi_indotgl.php');
$today = date("Y-m-d"); $tanggal = tgl_indo($today); echo"$tanggal"; 
$todayr= substr(($today),0,8);
$todayr2=$todayr.'00';

include('../ribuan.php');
include('../countday.php');
include('../fungsi_indotgl3.php');
?>
<table border="1" cellpadding="0" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
<tr align="center">
	<td align="center" width="100" bgcolor="#999999" valign="middle">&nbsp;&nbsp;&nbsp;1,2 - 1,4&nbsp;&nbsp;&nbsp;</td>
	<td align="left" valign="top" bgcolor="#FFFFFF">
	<table border="1" width="1100" cellpadding="0" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
	<tr><td>&nbsp;<b>No.&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Id.Produksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Pop.(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Umur&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Mati(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Killing(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Jatah(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td><b>&nbsp;Panen(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td><b>&nbsp;&nbsp;&nbsp;Sisa(ekor)&nbsp;&nbsp;&nbsp;</td></tr>
<?php
$a1 = 1;
$qp1 = mysql_query("select * from rhpp where panenbulan='0000-00-00' order by id_produksi");
while($dp1 = mysql_fetch_assoc($qp1))
{
	$id_produksi1=$dp1['id_produksi'];
	//mencari nama peternak
	$qf1 = mysql_query("select * from farm where id_farm='$dp1[id_farm]'");
	$df1 = mysql_fetch_assoc($qf1);
	//mencari beban
	$bb1=0;
	$qbb1 =  mysql_query("select * from beban where id_produksi='$id_produksi1'");
	while($dbb1 = mysql_fetch_assoc($qbb1))
	{
		$bb1 = $bb1+$dbb1['qty'];	
	}
	//mencari tgl chick in dan populasi
	$populasi1=0;$populasi11=0;$umur1=0; $chick_in11='';
	$qpop1 =  mysql_query("select * from jual where id_produksi='$id_produksi1' and id_barang like 'D-%'");
	while($dpop1 = mysql_fetch_assoc($qpop1))
	{
	$populasi11 = $populasi11+$dpop1['qty'];
	$chick_in11 = $dpop1['tanggal'];
	}
	$populasi1=$populasi11-$bb1;
	$rpopulasi1=ribuan($populasi1);
	$chick_in1 = tgl_indo($chick_in11);
	if(!empty($chick_in11))
	{
	$umur1 = cday( $chick_in11, $today, $pemisah = '-' );
	}else
	{
	$umur1 = 0;
	}
	if(($umur1 >= 28)and($umur1 <= 30))
	{
		//mencari kematian
		$kematian1=0;
		$qmt1 =  mysql_query("select * from kematian where id_produksi='$id_produksi1'");
		while($dmt1 = mysql_fetch_assoc($qmt1))
		{
			$kematian1=$kematian1+$dmt1['jml'];
		}
		$rkematian1 = ribuan($kematian1);
		//mencari killing
		$kill1=0;
		$qkl1 =  mysql_query("select * from killing where id_produksi='$id_produksi1'");
		while($dkl1 = mysql_fetch_assoc($qkl1))
		{
			$kill1=$kill1+$dkl1['jml_ekor'];
		}
		$rkill1=ribuan($kill1);
		//mencari jatah
		$jta1=0;
		$qjta1 =  mysql_query("select * from jatah_ayam where id_produksi='$id_produksi1'");
		while($djta1 = mysql_fetch_assoc($qjta1))
		{
			$jta1=$jta1+$djta1['jml_ekor'];
		}
		$rjta1=ribuan($jta1);
		//mencari ayam terpanen
		$pn1=0;
		$qpn1 =  mysql_query("select * from pja where id_produksi='$id_produksi1'");
		while($dpn1 = mysql_fetch_assoc($qpn1))
		{
			if($dpn1['ekor_real']=='')
			{
			$pn1=$pn1+$dpn1['ekor_rcn'];
			}else
			{
			$pn1=$pn1+$dpn1['ekor_real'];
			}
		}
		$rpn1=ribuan($pn1);
		//sisa ayam di kandang
		$sisa1 = $populasi1-($kill1+$kematian1+$jta1+$pn1);
		$rsisa1=ribuan($sisa1);
		
		$Tkill1 = $Tkill1+$kill1;
		$Tpop1 = $Tpop1+$populasi1;
		$Tkematian1 = $Tkematian1+$kematian1;
		$Tjta1 = $Tjta1+$jta1;
		$Tpn1 = $Tpn1+$pn1;
		$Tsisa1 = $Tsisa1+$sisa1;
		echo"<tr>
		<td>&nbsp;$a1.&nbsp;</td>
		<td>&nbsp;$id_produksi1</td>
		<td>&nbsp;$df1[nama]</td>
		<td>&nbsp;$df1[desa]</td>
		<td align=\"right\">$rpopulasi1</td>
		<td align=\"right\">$umur1</td>
		<td align=\"right\">$rkematian1</td>
		<td align=\"right\">$rkill1</td>
		<td align=\"right\">$rjta1</td>
		<td align=\"right\">$rpn1</td>
		<td align=\"right\">$rsisa1</td>
		";
		echo"</tr>";
		$a1++;
	}
}
	$rTkill1 = ribuan($Tkill1);
	$rTpop1 = ribuan($Tpop1);
	$rTkematian1 = ribuan($Tkematian1);
	$rTjta1 = ribuan($Tjta1);
	$rTpn1 = ribuan($Tpn1);
	$rTsisa1 = ribuan($Tsisa1);
echo"<tr bgcolor=\"red\"><td colspan=\"4\" align=\"center\"><b>TOTAL</td><td align=\"right\">$rTpop1</td><td align=\"right\">&nbsp;</td><td align=\"right\">$rTkematian1</td><td align=\"right\">$rTkill1</td><td align=\"right\">$rTjta1</td><td align=\"right\">$rTpn1</td><td align=\"right\">$rTsisa1</td></tr>";
?>	</table>
	</td>
</tr>
<tr align="center">
	<td align="center"  bgcolor="#999999" valign="middle">&nbsp;&nbsp;&nbsp;1,4 - 1,6&nbsp;&nbsp;&nbsp;</td>
	<td bgcolor="#FFFFFF">
	<table  width="1100" border="1" cellpadding="0" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
	<tr><td>&nbsp;<b>No.&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Id.Produksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Pop.(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Umur&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Mati(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Killing(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Jatah(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td><b>&nbsp;Panen(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td><b>&nbsp;&nbsp;&nbsp;Sisa(ekor)&nbsp;&nbsp;&nbsp;</td></tr>
<?php
$a2 = 1;
$qp2 = mysql_query("select * from rhpp where panenbulan='0000-00-00' order by id_produksi");
while($dp2 = mysql_fetch_assoc($qp2))
{
	$id_produksi2=$dp2['id_produksi'];
	//mencari nama peternak
	$qf2 = mysql_query("select * from farm where id_farm='$dp2[id_farm]'");
	$df2 = mysql_fetch_assoc($qf2);
	//mencari beban
	$bb2=0;
	$qbb2 =  mysql_query("select * from beban where id_produksi='$id_produksi2'");
	while($dbb2 = mysql_fetch_assoc($qbb2))
	{
		$bb2 = $bb2+$dbb2['qty'];	
	}
	//mencari tgl chick in dan populasi
	$populasi2=0;$populasi22=0;$umur2=0; $chick_in22='';
	$qpop2 =  mysql_query("select * from jual where id_produksi='$id_produksi2' and id_barang like 'D-%'");
	while($dpop2 = mysql_fetch_assoc($qpop2))
	{
	$populasi22 = $populasi22+$dpop2['qty'];
	$chick_in22 = $dpop2['tanggal'];
	}
	$populasi2=$populasi22-$bb2;
	$rpopulasi2=ribuan($populasi2);
	$chick_in2 = tgl_indo($chick_in22);
	if(!empty($chick_in22))
	{
	$umur2 = cday( $chick_in22, $today, $pemisah = '-' );
	}else
	{
	$umur2 = 0;
	}
	if(($umur2 >= 31)and($umur2 <= 32))
	{
		//mencari kematian
		$kematian2=0;
		$qmt2 =  mysql_query("select * from kematian where id_produksi='$id_produksi2'");
		while($dmt2 = mysql_fetch_assoc($qmt2))
		{
			$kematian2=$kematian2+$dmt2['jml'];
		}
		$rkematian2 = ribuan($kematian2);
		//mencari killing
		$kill2=0;
		$qkl2 =  mysql_query("select * from killing where id_produksi='$id_produksi2'");
		while($dkl2 = mysql_fetch_assoc($qkl2))
		{
			$kill2=$kill2+$dkl2['jml_ekor'];
		}
		$rkill2=ribuan($kill2);
		//mencari jatah
		$jta2=0;
		$qjta2 =  mysql_query("select * from jatah_ayam where id_produksi='$id_produksi2'");
		while($djta2 = mysql_fetch_assoc($qjta2))
		{
			$jta2=$jta2+$djta2['jml_ekor'];
		}
		$rjta2=ribuan($jta2);
		//mencari ayam terpanen
		$pn2=0;
		$qpn2 =  mysql_query("select * from pja where id_produksi='$id_produksi2'");
		while($dpn2 = mysql_fetch_assoc($qpn2))
		{
			if($dpn2['ekor_real']=='')
			{
			$pn2=$pn2+$dpn2['ekor_rcn'];
			}else
			{
			$pn2=$pn2+$dpn2['ekor_real'];
			}
		}
		$rpn2=ribuan($pn2);
		//sisa ayam di kandang
		$sisa2 = $populasi2-($kill2+$kematian2+$jta2+$pn2);
		$rsisa2=ribuan($sisa2);
		
		$Tkill2 = $Tkill2+$kill2;
		$Tpop2 = $Tpop2+$populasi2;
		$Tkematian2 = $Tkematian2+$kematian2;
		$Tjta2 = $Tjta2+$jta2;
		$Tpn2 = $Tpn2+$pn2;
		$Tsisa2 = $Tsisa2+$sisa2;
		echo"<tr>
		<td>&nbsp;$a2.&nbsp;</td>
		<td>&nbsp;$id_produksi2</td>
		<td>&nbsp;$df2[nama]</td>
		<td>&nbsp;$df2[desa]</td>
		<td align=\"right\">$rpopulasi2</td>
		<td align=\"right\">$umur2</td>
		<td align=\"right\">$rkematian2</td>
		<td align=\"right\">$rkill2</td>
		<td align=\"right\">$rjta2</td>
		<td align=\"right\">$rpn2</td>
		<td align=\"right\">$rsisa2</td>
		";
		echo"</tr>";
		$a2++;
	}
}
	$rTkill2 = ribuan($Tkill2);
	$rTpop2 = ribuan($Tpop2);
	$rTkematian2 = ribuan($Tkematian2);
	$rTjta2 = ribuan($Tjta2);
	$rTpn2 = ribuan($Tpn2);
	$rTsisa2 = ribuan($Tsisa2);
echo"<tr bgcolor=\"red\"><td colspan=\"4\" align=\"center\"><b>TOTAL</td><td align=\"right\">$rTpop2</td><td align=\"right\">&nbsp;</td><td align=\"right\">$rTkematian2</td><td align=\"right\">$rTkill2</td><td align=\"right\">$rTjta2</td><td align=\"right\">$rTpn2</td><td align=\"right\">$rTsisa2</td></tr>";
?>  </table>
	</td>
</tr>
<tr align="center">
	<td align="center" bgcolor="#999999" valign="middle">&nbsp;&nbsp;&nbsp;1,6 - 1,8&nbsp;&nbsp;&nbsp;</td>
	<td align="center" bgcolor="#FFFFFF">
	<table  width="1100" border="1" cellpadding="0" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
	<tr><td>&nbsp;<b>No.&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Id.Produksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Pop.(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Umur&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Mati(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Killing(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Jatah(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td><b>&nbsp;Panen(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td><b>&nbsp;&nbsp;&nbsp;Sisa(ekor)&nbsp;&nbsp;&nbsp;</td></tr>
<?php
$a3 = 1;
$qp3 = mysql_query("select * from rhpp where panenbulan='0000-00-00' order by id_produksi");
while($dp3 = mysql_fetch_assoc($qp3))
{
	$id_produksi3=$dp3['id_produksi'];
	//mencari nama peternak
	$qf3 = mysql_query("select * from farm where id_farm='$dp3[id_farm]'");
	$df3 = mysql_fetch_assoc($qf3);
	//mencari beban
	$bb3=0;
	$qbb3 =  mysql_query("select * from beban where id_produksi='$id_produksi3'");
	while($dbb3 = mysql_fetch_assoc($qbb3))
	{
		$bb3 = $bb3+$dbb3['qty'];	
	}
	//mencari tgl chick in dan populasi
	$populasi3=0;$populasi33=0;$umur3=0; $chick_in33='';
	$qpop3 =  mysql_query("select * from jual where id_produksi='$id_produksi3' and id_barang like 'D-%'");
	while($dpop3 = mysql_fetch_assoc($qpop3))
	{
	$populasi33 = $populasi33+$dpop3['qty'];
	$chick_in33 = $dpop3['tanggal'];
	}
	$populasi3=$populasi33-$bb3;
	$rpopulasi3=ribuan($populasi3);
	$chick_in3 = tgl_indo($chick_in33);
	if(!empty($chick_in33))
	{
	$umur3 = cday( $chick_in33, $today, $pemisah = '-' );
	}else
	{
	$umur3 = 0;
	}
	if(($umur3 >= 33)and($umur3 <= 35))
	{
		//mencari kematian
		$kematian3=0;
		$qmt3 =  mysql_query("select * from kematian where id_produksi='$id_produksi3'");
		while($dmt3 = mysql_fetch_assoc($qmt3))
		{
			$kematian3=$kematian3+$dmt3['jml'];
		}
		$rkematian3 = ribuan($kematian3);
		//mencari killing
		$kill3=0;
		$qkl3 =  mysql_query("select * from killing where id_produksi='$id_produksi3'");
		while($dkl3 = mysql_fetch_assoc($qkl3))
		{
			$kill3=$kill3+$dkl3['jml_ekor'];
		}
		$rkill3=ribuan($kill3);
		//mencari jatah
		$jta3=0;
		$qjta3 =  mysql_query("select * from jatah_ayam where id_produksi='$id_produksi3'");
		while($djta3 = mysql_fetch_assoc($qjta3))
		{
			$jta3=$jta3+$djta3['jml_ekor'];
		}
		$rjta3=ribuan($jta3);
		//mencari ayam terpanen
		$pn3=0;
		$qpn3 =  mysql_query("select * from pja where id_produksi='$id_produksi3'");
		while($dpn3 = mysql_fetch_assoc($qpn3))
		{
			if($dpn3['ekor_real']=='')
			{
			$pn3=$pn3+$dpn3['ekor_rcn'];
			}else
			{
			$pn3=$pn3+$dpn3['ekor_real'];
			}
		}
		$rpn3=ribuan($pn3);
		//sisa ayam di kandang
		$sisa3 = $populasi3-($kill3+$kematian3+$jta3+$pn3);
		$rsisa3=ribuan($sisa3);
		
		$Tkill3 = $Tkill3+$kill3;
		$Tpop3 = $Tpop3+$populasi3;
		$Tkematian3 = $Tkematian3+$kematian3;
		$Tjta3 = $Tjta3+$jta3;
		$Tpn3 = $Tpn3+$pn3;
		$Tsisa3 = $Tsisa3+$sisa3;
		echo"<tr>
		<td>&nbsp;$a3.&nbsp;</td>
		<td>&nbsp;$id_produksi3</td>
		<td>&nbsp;$df3[nama]</td>
		<td>&nbsp;$df3[desa]</td>
		<td align=\"right\">$rpopulasi3</td>
		<td align=\"right\">$umur3</td>
		<td align=\"right\">$rkematian3</td>
		<td align=\"right\">$rkill3</td>
		<td align=\"right\">$rjta3</td>
		<td align=\"right\">$rpn3</td>
		<td align=\"right\">$rsisa3</td>
		";
		echo"</tr>";
		$a3++;
	}
}
	$rTkill3 = ribuan($Tkill3);
	$rTpop3 = ribuan($Tpop3);
	$rTkematian3 = ribuan($Tkematian3);
	$rTjta3 = ribuan($Tjta3);
	$rTpn3 = ribuan($Tpn3);
	$rTsisa3 = ribuan($Tsisa3);
echo"<tr bgcolor=\"red\"><td colspan=\"4\" align=\"center\"><b>TOTAL</td><td align=\"right\">$rTpop3</td><td align=\"right\">&nbsp;</td><td align=\"right\">$rTkematian3</td><td align=\"right\">$rTkill3</td><td align=\"right\">$rTjta3</td><td align=\"right\">$rTpn3</td><td align=\"right\">$rTsisa3</td></tr>";
?>  </table>
	</td>
</tr>
<tr align="center">
	<td align="center" bgcolor="#999999">&nbsp;&nbsp;&nbsp;> 1,8&nbsp;&nbsp;&nbsp;</td>
	<td align="center" bgcolor="#FFFFFF">
	<table  width="1100" border="1" cellpadding="0" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
	<tr><td>&nbsp;<b>No.&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Id.Produksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Pop.(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Umur&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Mati(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Killing(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;<b>Jatah(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td><b>&nbsp;Panen(ekor)&nbsp;&nbsp;&nbsp;</td>
	<td><b>&nbsp;&nbsp;&nbsp;Sisa(ekor)&nbsp;&nbsp;&nbsp;</td></tr>
<?php
$a4 = 1;
$qp4 = mysql_query("select * from rhpp where panenbulan='0000-00-00' order by id_produksi");
while($dp4 = mysql_fetch_assoc($qp4))
{
	$id_produksi4=$dp4['id_produksi'];
	//mencari nama peternak
	$qf4 = mysql_query("select * from farm where id_farm='$dp4[id_farm]'");
	$df4 = mysql_fetch_assoc($qf4);
	//mencari beban
	$bb4=0;
	$qbb4 =  mysql_query("select * from beban where id_produksi='$id_produksi4'");
	while($dbb4 = mysql_fetch_assoc($qbb4))
	{
		$bb4 = $bb4+$dbb4['qty'];	
	}
	//mencari tgl chick in dan populasi
	$populasi4=0;$populasi44=0;$umur4=0; $chick_in44='';
	$qpop4 =  mysql_query("select * from jual where id_produksi='$id_produksi4' and id_barang like 'D-%'");
	while($dpop4 = mysql_fetch_assoc($qpop4))
	{
	$populasi44 = $populasi44+$dpop4['qty'];
	$chick_in44 = $dpop4['tanggal'];
	}
	$populasi4=$populasi44-$bb4;
	$rpopulasi4=ribuan($populasi4);
	$chick_in4 = tgl_indo($chick_in44);
	if(!empty($chick_in44))
	{
	$umur4 = cday( $chick_in44, $today, $pemisah = '-' );
	}else
	{
	$umur4 = 0;
	}
	if($umur4 > 35)
	{
		//mencari kematian
		$kematian4=0;
		$qmt4 =  mysql_query("select * from kematian where id_produksi='$id_produksi4'");
		while($dmt4 = mysql_fetch_assoc($qmt4))
		{
			$kematian4=$kematian4+$dmt4['jml'];
		}
		$rkematian4 = ribuan($kematian4);
		//mencari killing
		$kill4=0;
		$qkl4 =  mysql_query("select * from killing where id_produksi='$id_produksi4'");
		while($dkl4 = mysql_fetch_assoc($qkl4))
		{
			$kill4=$kill4+$dkl4['jml_ekor'];
		}
		$rkill4=ribuan($kill4);
		//mencari jatah
		$jta4=0;
		$qjta4 =  mysql_query("select * from jatah_ayam where id_produksi='$id_produksi4'");
		while($djta4 = mysql_fetch_assoc($qjta4))
		{
			$jta4=$jta4+$djta4['jml_ekor'];
		}
		$rjta4=ribuan($jta4);
		//mencari ayam terpanen
		$pn4=0;
		$qpn4 =  mysql_query("select * from pja where id_produksi='$id_produksi4'");
		while($dpn4 = mysql_fetch_assoc($qpn4))
		{
			if($dpn4['ekor_real']=='')
			{
			$pn4=$pn4+$dpn4['ekor_rcn'];
			}else
			{
			$pn4=$pn4+$dpn4['ekor_real'];
			}
		}
		$rpn4=ribuan($pn4);
		//sisa ayam di kandang
		$sisa4 = $populasi4-($kill4+$kematian4+$jta4+$pn4);
		$rsisa4=ribuan($sisa4);
		
		$Tkill4 = $Tkill4+$kill4;
		$Tpop4 = $Tpop4+$populasi4;
		$Tkematian4 = $Tkematian4+$kematian4;
		$Tjta4 = $Tjta4+$jta4;
		$Tpn4 = $Tpn4+$pn4;
		$Tsisa4 = $Tsisa4+$sisa4;
		echo"<tr>
		<td>&nbsp;$a4.&nbsp;</td>
		<td>&nbsp;$id_produksi4</td>
		<td>&nbsp;$df4[nama]</td>
		<td>&nbsp;$df4[desa]</td>
		<td align=\"right\">$rpopulasi4</td>
		<td align=\"right\">$umur4</td>
		<td align=\"right\">$rkematian4</td>
		<td align=\"right\">$rkill4</td>
		<td align=\"right\">$rjta4</td>
		<td align=\"right\">$rpn4</td>
		<td align=\"right\">$rsisa4</td>
		";
		echo"</tr>";
		$a4++;
	}
}
	$rTkill4 = ribuan($Tkill4);
	$rTpop4 = ribuan($Tpop4);
	$rTkematian4 = ribuan($Tkematian4);
	$rTjta4 = ribuan($Tjta4);
	$rTpn4 = ribuan($Tpn4);
	$rTsisa4 = ribuan($Tsisa4);
echo"<tr bgcolor=\"red\"><td colspan=\"4\" align=\"center\"><b>TOTAL</td><td align=\"right\">$rTpop4</td><td align=\"right\">&nbsp;</td><td align=\"right\">$rTkematian4</td><td align=\"right\">$rTkill4</td><td align=\"right\">$rTjta4</td><td align=\"right\">$rTpn4</td><td align=\"right\">$rTsisa4</td></tr>";
?>  </table>
	</td>
</tr>
<tr align="center" bgcolor="#FF0000">
<td align="center">Total&nbsp;Stok</td>
<td align="right"><?php $totalekora=$Tsisa4+$Tsisa3+$Tsisa2+$Tsisa1; $totalekora2=ribuan($totalekora);	echo"$totalekora2";	?></td>
</tr></table>

</td></tr>
<tr><td><br>
Resume Produksi
<table border="1" bordercolor="" cellpadding="4" cellspacing="0" style="color:#000000;font-family:tahoma,arial;font-size:12px;">
<tr align="center" bgcolor="#999999">
<td rowspan="2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Populasi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td rowspan="2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jml.Pakan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td colspan="2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Panen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td colspan="2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kematian&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td rowspan="2" >&nbsp;BW&nbsp;(Kg)&nbsp;</td>
<td rowspan="2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FI&nbsp;(Kg)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td rowspan="2" >&nbsp;Umur(hari)&nbsp;</td>
<td rowspan="2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FCR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td rowspan="2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr align="center" bgcolor="#999999">
	<td >&nbsp;&nbsp;&nbsp;Ekor&nbsp;&nbsp;&nbsp;</td>
	<td >&nbsp;&nbsp;&nbsp;Tonase&nbsp;&nbsp;&nbsp;</td>
	<td >&nbsp;&nbsp;Ekor&nbsp;&nbsp;</td>
	<td >&nbsp;&nbsp;%&nbsp;&nbsp;</td>
</tr>
<?php
$qr1 = @mysql_query("select * from rhpp where panenbulan = '$todayr2' order by id_produksi");
while($dr1 = @mysql_fetch_assoc($qr1))
{
	$id_produksi = $dr1['id_produksi'];
	//mencari beban
	$bb=0;
	$qbb =  @mysql_query("select * from beban where id_produksi='$id_produksi'");
	while($dbb = @mysql_fetch_assoc($qbb))
	{
		$bb = $bb+$dbb['qty'];	
	}
	//mencari tgl chick in dan populasi
	$populasiz=0;
	$qpop =  @mysql_query("select * from jual where id_produksi='$id_produksi' and id_barang like 'D-%'");
	while($dpop = @mysql_fetch_assoc($qpop))
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
	$rTpopulasi=ribuan($Tpopulasi);
	$rTpakan_total=ribuan($Tpakan_total);
	$rTpanen_tonase=ribuan($Tpanen_tonase);
	$rTpanen_ekor=ribuan($Tpanen_ekor);
	$rTmati = ribuan($Tmati);
	$persenmati = @substr((($Tmati/$Tpopulasi)*100),0,5);
	$Tavr = @substr(($Tbw/$Tpopulasi),0,4);
	$fi=@substr(($Tpakan_total/$Tpanen_ekor),0,4);
	$avr_umur =@substr(($sub_umur/$Tpopulasi),0,5);
	$avr_fc =@substr(($sub_fc/$Tpopulasi),0,5);
	$avr_ip =@substr(($sub_ip/$Tpopulasi),0,6);
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



