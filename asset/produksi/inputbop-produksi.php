<body style="background-image:url(../gambar/bg2.png)">
<?php
include('../fungsi_indotgl3.php');
include('../countday.php');
include('../fungsi_indotgl.php');
include('../ribuan.php');

$qwkt = mysql_query("Select * from user where leveluser='Finance' ");
$dwkt = mysql_fetch_assoc($qwkt);
$wkt_habis = $dwkt['jam'];
$wkt_habis2 = $wkt_habis+15;
mysql_query("update user set jam='$wkt_habis2' where leveluser='Finance' ");

	$field = $_GET['field'];
	$keyword = $_GET['keyword'];
	$keyword2 = $_GET['thn'].'-'.$_GET['bln'];
if($field=='id_produksi')
{
$field2='ID Produksi';
}else
if($field=='id_farm')
{
$field2='ID Farm';
}
?>
<style type="text/css">
      /*<![CDATA[*/
        .ScrollTable-container {
          display: table-cell;
        }
        .ScrollTable thead tr {
          position: relative;
        }
        .ScrollTable tbody {
          overflow: auto;
        }
        .ScrollTable tbody tr {
          height: auto;
        }
        .ScrollTable tbody tr td:last-child {
          padding-right: 50px;
        }
      /*]]>*/
    </style>
<!--[if IE]>
    <style type="text/css">
      /*<![CDATA[*/
        .ScrollTable {
          overflow-y: auto;
          width: 1px;
        }
      /*]]>*/
    </style>
<![endif]-->
<div class="ScrollTable-container">
<div class="ScrollTable" style="height: 410px;">
<table border="1" bordercolor="" cellpadding="4" cellspacing="0" align="center" width="400px" style="color:#000000;font-family:tahoma,arial;font-size:11px;">
<thead>
<div align="left" style="font-size:12"><strong><?php
?></strong></div>
<tr><td colspan="15">
<form action="input_bop.php" method="get" enctype="multipart/form-data">
  <select name="field">
   <?php
  if(empty($field))
  {
    echo"<option>--Pilih--</option>";
  }else
  {
  	echo"<option value=\"$field\">$field2</option>";
  }?>
    <option value="">----------</option>
	<option value="id_produksi">ID Produksi</option>
    <option value="id_farm">ID Farm</option>
  </select>
  <font color="#000000">Keyword </font><input name="keyword" type="text" id="keyword" size="24" value="<?php echo"$keyword"; ?>"/>
<input name="cari" type="submit" id="cari" value="cari"/>
</form>
</td></tr>
<tr align="center" bgcolor="#999999">
	<td rowspan="3" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID&nbsp;Produksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td rowspan="3" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td rowspan="3" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td rowspan="3" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;ID&nbsp;Kontrak&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td rowspan="3" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;Sistem&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td colspan="6" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DOC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td rowspan="3" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td rowspan="3" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td rowspan="3" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr align="center" bgcolor="#999999">
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tanggal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;Pokok&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;Bonus&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;Mati.Box&nbsp;</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;Total&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
</thead>
<tbody style="height: 400px;" >
<?php
$field = $_GET['field'];
$keyword = $_GET['keyword'];
if($field=='')
{
$query = " SELECT * FROM produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where rhpp.panenbulan='0000-00-00' order by rhpp.id_produksi desc";
$hasil = @mysql_query( $query ) or die(mysql_error());
$banyak = @mysql_num_rows($hasil);

$totaldoc=0;$totalpakan=0;$totalekorpanen=0;$totaltonasepanen=0;$totalekormati=0;$totalpersenmati=0;$totalfeedintake=0;

if($banyak > 0 )
{	$i=0;
	while( $data = @mysql_fetch_assoc($hasil) )
	{	
		//kandang//
		$qkandang = @mysql_query("select * from farm where id_farm='$data[id_farm]'");
		$dkandang = @mysql_fetch_assoc($qkandang);
		//ts//
		$qts = @mysql_query("select * from karyawan join produksi on (produksi.ts=karyawan.nip) where id_produksi='$data[id_produksi]'");
		$dts = @mysql_fetch_assoc($qts);
		$id_kontrak = substr(($data['id_kontrak']),0,3);
		$k = substr(($data['id_kontrak']),0,3);
		$k2 = substr(($data['id_kontrak']),3,3);
		if($k == 'KMT')
		{
			$sistem='KEMITRAAN';
		}else
		if(($k == 'MKL')and($k2 !='.KK'))
		{
			$sistem='MAKLOON';
		}else
		if(($k == 'MKL')and($k2 =='.KK'))
		{
			$sistem='COMPANY FARM';
		}
		echo"<tr bgcolor=\"#FFFFFF\">
			 <td align=\"center\" valign=\"top\">$data[id_produksi]</td>
			 <td align=\"left\" valign=\"top\">$dkandang[nama]</td>
			 <td align=\"left\" valign=\"top\">$dkandang[desa]</td> 
			 <td align=\"left\" valign=\"top\">$data[id_kontrak]</td> 
			 <td align=\"left\" valign=\"top\">$sistem</td>";
		//penjualan barang//
		$populasi=0;$populasix=0;$retpopulasi=0;
		$pokokdoc=0;$bonusdoc=0;$matiboxdoc=0;
		$tgl_chick_in='';
		$nama_doc='';
		$qbarang = @mysql_query("select * from jual where id_produksi='$data[id_produksi]' and id_barang like '%D-%'");
		while($dbarang = @mysql_fetch_assoc($qbarang))
		{
		$populasix = $populasi+($dbarang['qty']+$dbarang['bonus']);
		$pokokdoc = $pokokdoc+$dbarang['qty'];
		$bonusdoc = $bonusdoc+$dbarang['bonus'];
		$matiboxdoc = $matiboxdoc+$dbarang['mati_box'];
		$tgl_chick_in3 = $dbarang['tanggal'];
		$tgl_chick_in = tgl_indo($dbarang['tanggal']);
		$qbarang2 = @mysql_query("select * from barang where id_barang='$dbarang[id_barang]'");
		$dbarang2 = @mysql_fetch_assoc($qbarang2);
		$nama_doc = $dbarang2['nama'];
		}
		$populasi=$populasix;
		$pokokdocribuan=ribuan($pokokdoc);
		$bonusdocribuan=ribuan($bonusdoc);
		$matiboxdocribuan=ribuan($matiboxdoc);
		$populasiribuan=ribuan($populasi);
		
		if($tgl_chick_in != '')
		{
		echo"<td align=\"center\" valign=\"top\">$nama_doc</td>";
		echo"<td align=\"center\" valign=\"top\">$tgl_chick_in</td>";
		}else
		{
		echo"<td align=\"center\" valign=\"top\">---</td>";
		echo"<td align=\"center\" valign=\"top\">---</td>";
		}
		echo"<td align=\"right\" valign=\"top\">$pokokdocribuan</td>
			 <td align=\"right\" valign=\"top\">$bonusdocribuan</td>
			 <td align=\"right\" valign=\"top\">$matiboxdocribuan</td>
			 <td align=\"right\" valign=\"top\">$populasiribuan</td>";
			
			if($data['bop_awal']=='')
			{
			echo"<td align=\"center\" valign=\"top\">Belum Ada BOP</td>";
			}else
			{
			$bop1 = ribuan($data['bop_awal']);
			echo"<td align=\"right\" valign=\"top\">$bop1</td>";
			}
		
			echo"<td align=\"right\" valign=\"top\"><a href=\"bop1.php?id=$data[id_produksi]\"><img src=\"../gambar/Input_0.bmp\" border=\"0\" width=\"50\"/></a></td>";
		
			echo"<td align=\"right\" valign=\"top\"><a href=\"view.php?id=$data[id_produksi]\"><img src=\"../gambar/DETAIL_0.bmp\" border=\"0\" width=\"50\"/></a></td>";
		
		$totpop = $totpop+$populasi;
		$totpok = $totpok+$pokokdoc;
		$totbon = $totbon+$bonusdoc;
		$totmax = $totmax+$matiboxdoc;
		$totbop1 = $totbop1+$data['bop_awal'];
		$totbop2 = $totbop2+$data['bop_tengah'];
		$totbop3 = $totbop3+$dsisa_mkl['jml'];
		echo"</tr>";	 
	}
	$totpopr = ribuan($totpop);
	$totpokr = ribuan($totpok);
	$totbonr = ribuan($totbon);
	$totmaxr = ribuan($totmax);
	$totbop1r = ribuan($totbop1);
	$totbop2r = ribuan($totbop2);
	$totbop3r = ribuan($totbop3);
	echo"<tr bgcolor=\"red\"><td colspan=\"7\" align=\"center\"><b>Total</td><td align=\"right\">$totpokr</td><td align=\"right\">$totbonr</td><td align=\"right\">$totmaxr</td><td align=\"right\">$totpopr</td><td align=\"right\">$totbop1r</td><td align=\"right\">&nbsp;</td><td align=\"right\">&nbsp;</td></tr>";
}
else
{
	echo '<tr><tr><td><b><font color="#FFFFFF">Data Kosong</font></b></td></tr></tr><br>';
	
}

}else
{
$query = " SELECT * FROM produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where rhpp.panenbulan='0000-00-00' and rhpp.$field like '%$keyword%' order by rhpp.id_produksi desc";
$hasil = @mysql_query( $query ) or die(mysql_error());
$banyak = @mysql_num_rows($hasil);

$totaldoc=0;$totalpakan=0;$totalekorpanen=0;$totaltonasepanen=0;$totalekormati=0;$totalpersenmati=0;$totalfeedintake=0;

if($banyak > 0 )
{	$i=0;
	while( $data = @mysql_fetch_assoc($hasil) )
	{	
		//kandang//
		$qkandang = @mysql_query("select * from farm where id_farm='$data[id_farm]'");
		$dkandang = @mysql_fetch_assoc($qkandang);
		//ts//
		$qts = @mysql_query("select * from karyawan join produksi on (produksi.ts=karyawan.nip) where id_produksi='$data[id_produksi]'");
		$dts = @mysql_fetch_assoc($qts);
		$id_kontrak = substr(($data['id_kontrak']),0,3);
		$k = substr(($data['id_kontrak']),0,3);
		$k2 = substr(($data['id_kontrak']),3,3);
		if($k == 'KMT')
		{
			$sistem='KEMITRAAN';
		}else
		if(($k == 'MKL')and($k2 !='.KK'))
		{
			$sistem='MAKLOON';
		}else
		if(($k == 'MKL')and($k2 =='.KK'))
		{
			$sistem='COMPANY FARM';
		}
		echo"<tr bgcolor=\"#FFFFFF\">
			 <td align=\"center\" valign=\"top\">$data[id_produksi]</td>
			 <td align=\"left\" valign=\"top\">$dkandang[nama]</td>
			 <td align=\"left\" valign=\"top\">$dkandang[desa]</td> 
			 <td align=\"left\" valign=\"top\">$data[id_kontrak]</td> 
			 <td align=\"left\" valign=\"top\">$sistem</td>";
		//penjualan barang//
		$populasi=0;$populasix=0;$retpopulasi=0;
		$pokokdoc=0;$bonusdoc=0;$matiboxdoc=0;
		$tgl_chick_in='';
		$nama_doc='';
		$qbarang = @mysql_query("select * from jual where id_produksi='$data[id_produksi]' and id_barang like '%D-%'");
		while($dbarang = @mysql_fetch_assoc($qbarang))
		{
		$populasix = $populasi+($dbarang['qty']+$dbarang['bonus']);
		$pokokdoc = $pokokdoc+$dbarang['qty'];
		$bonusdoc = $bonusdoc+$dbarang['bonus'];
		$matiboxdoc = $matiboxdoc+$dbarang['mati_box'];
		$tgl_chick_in3 = $dbarang['tanggal'];
		$tgl_chick_in = tgl_indo($dbarang['tanggal']);
		$qbarang2 = @mysql_query("select * from barang where id_barang='$dbarang[id_barang]'");
		$dbarang2 = @mysql_fetch_assoc($qbarang2);
		$nama_doc = $dbarang2['nama'];
		}
		$populasi=$populasix;
		$pokokdocribuan=ribuan($pokokdoc);
		$bonusdocribuan=ribuan($bonusdoc);
		$matiboxdocribuan=ribuan($matiboxdoc);
		$populasiribuan=ribuan($populasi);
		
		if($tgl_chick_in != '')
		{
		echo"<td align=\"center\" valign=\"top\">$nama_doc</td>";
		echo"<td align=\"center\" valign=\"top\">$tgl_chick_in</td>";
		}else
		{
		echo"<td align=\"center\" valign=\"top\">---</td>";
		echo"<td align=\"center\" valign=\"top\">---</td>";
		}
		echo"<td align=\"right\" valign=\"top\">$pokokdocribuan</td>
			 <td align=\"right\" valign=\"top\">$bonusdocribuan</td>
			 <td align=\"right\" valign=\"top\">$matiboxdocribuan</td>
			 <td align=\"right\" valign=\"top\">$populasiribuan</td>";
			
			if($data['bop_awal']=='')
			{
			echo"<td align=\"center\" valign=\"top\">Belum Ada BOP</td>";
			}else
			{
			$bop1 = ribuan($data['bop_awal']);
			echo"<td align=\"right\" valign=\"top\">$bop1</td>";
			}
		
			echo"<td align=\"right\" valign=\"top\"><a href=\"bop1.php?id=$data[id_produksi]\"><img src=\"../gambar/Input_0.bmp\" border=\"0\" width=\"50\"/></a></td>";
		
			echo"<td align=\"right\" valign=\"top\"><a href=\"view.php?id=$data[id_produksi]\"><img src=\"../gambar/DETAIL_0.bmp\" border=\"0\" width=\"50\"/></a></td>";

		$totpop = $totpop+$populasi;
		$totpok = $totpok+$pokokdoc;
		$totbon = $totbon+$bonusdoc;
		$totmax = $totmax+$matiboxdoc;
		$totbop1 = $totbop1+$data['bop_awal'];
		$totbop2 = $totbop2+$data['bop_tengah'];
		$totbop3 = $totbop3+$dsisa_mkl['jml'];
		echo"</tr>";	 
	}
	$totpopr = ribuan($totpop);
	$totpokr = ribuan($totpok);
	$totbonr = ribuan($totbon);
	$totmaxr = ribuan($totmax);
	$totbop1r = ribuan($totbop1);
	$totbop2r = ribuan($totbop2);
	$totbop3r = ribuan($totbop3);
	echo"<tr bgcolor=\"red\"><td colspan=\"7\" align=\"center\"><b>Total</td><td align=\"right\">$totpokr</td><td align=\"right\">$totbonr</td><td align=\"right\">$totmaxr</td><td align=\"right\">$totpopr</td><td align=\"right\">$totbop1r</td><td align=\"right\">&nbsp;</td><td align=\"right\">&nbsp;</td></tr>";
}
else
{
	echo '<tr><tr><td><b><font color="#FFFFFF">Data Kosong</font></b></td></tr></tr><br>';
	
}
}
?></tbody>
</table>
  </div>
</div>
