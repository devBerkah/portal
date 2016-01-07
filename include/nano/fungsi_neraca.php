<?php
//include("../koneksi.php");
//include("../ribuan.php");
//include('../fungsi_indotgl.php');
//include('../fungsi_indotgl2.php');

$qwkt = mysql_query("Select * from user where leveluser='Finance' ");
$dwkt = mysql_fetch_assoc($qwkt);
$wkt_habis = $dwkt['jam'];
$wkt_habis2 = $wkt_habis+15;
mysql_query("update user set jam='$wkt_habis2' where leveluser='Finance' ");

$qperusahaan = mysql_query("select * from perusahaan");
$dperusahaan = mysql_fetch_assoc($qperusahaan);
$comp = $dperusahaan['nama'];
$alamat = $dperusahaan['alamat'];
$kota = $dperusahaan['kota'];
$telp = $dperusahaan['telp'];
$fax = $dperusahaan['fax'];

//===============================================================perubahan tanggal dari sini===============================================================\\
$today = date("Y-m-d");
$tgl = substr($today,8,2);
$bln = substr($today,5,2);
$thn = substr($today,0,4);

if($bln > 9)
{
$all2=$thn.'-'.$bln.'-'.'00';
}else
{
$all2=$thn.'-'.$bln.'-'.'00';
}
$all=$thn.'-'.$bln;
$today2 = tgl_indo2($all);

if($bln == '1')
{
	$blnz = '01';
}else
if($bln == '2')
{
	$blnz = '02';
}else
if($bln == '3')
{
	$blnz = '03';
}else
if($bln == '4')
{
	$blnz = '04';
}else
if($bln == '5')
{
	$blnz = '05';
}else
if($bln == '6')
{
	$blnz = '06';
}else
if($bln == '7')
{
	$blnz = '07';
}else
if($bln == '8')
{
	$blnz = '08';
}else
if($bln == '9')
{
	$blnz = '09';
}else
{
	$blnz = $bln;
}
$berikutnyax=$blnz+1;
if($berikutnyax < 10)
{
	$berikutnya='0'.$berikutnyax;
}else
{
	$berikutnya=$berikutnyax;
}

$all_berikutnya=$thn.'-'.$berikutnya;
$all=$thn.'-'.$blnz;
$prl=$thn.'-'.$blnz;
$all2=$thn.'-'.$blnz.'-'.'00';
//===============================================================perubahan tanggal sampai sini===============================================================\\

//===========================================OPERASIONAL===========================================\\

$x=1;
$query = mysql_query("select * from rules_akun where id_akun like '110%' order by id_akun");
while($data = mysql_fetch_assoc($query))
{
	$id_akun = $data['id_akun'];
	$t1 = $data['debet'];
	$t2 = $data['kredit'];
	$normal = $data['normal'];
	$q1 = mysql_query("select * from akun where id_akun = '$id_akun' ");
	$d2 = mysql_fetch_assoc($q1);
//cari saldo awal
$Tawal =0;	$Totawal =0; $T = 0;
$qawal = @mysql_query("select * from jurnal where tgl < '$all' ");
$bawal = @mysql_num_rows($qawal);
if($bawal>0)
{
	while($dawal = @mysql_fetch_assoc($qawal))
	{
		if($dawal['akun1']== $id_akun)
		{
		$tanggal_awal = tgl_indo($dawal['tgl']);
		$debet_awal = ribuan($dawal['debet1']); 	
		$kredit_awal = ribuan($dawal['kredit1']);
		$debet_awal9 = $dawal['debet1']; 	
		$kredit_awal9 = $dawal['kredit1'];
		
		//mencari nama akun//
		$qakun_awal = @mysql_query("select * from akun where id_akun='$dawal[akun1]' ");
		$dakun_awal = @mysql_fetch_assoc($qakun_awal);
		
		//mengatur operator
		if(($t1 == '+')and($t2 == '-'))
		{
		$awal = ($Tawal+$debet_awal9)-$kredit_awal9;
		}else
		if(($t1 == '-')and($t2 == '+'))
		{
		$awal = ($Tawal-$debet_awal9)+$kredit_awal9;
		}
		
		$Tawal = $awal;
		$Tawalribuan = ribuan($Tawal);
		
		}else
		if($dawal['akun2']== $id_akun)
		{
		$tanggal_awal = tgl_indo($dawal['tgl']);
		$debet_awal = ribuan($dawal['debet2']); 	
		$kredit_awal = ribuan($dawal['kredit2']);
		$debet_awal9 = $dawal['debet2']; 	
		$kredit_awal9 = $dawal['kredit2'];

		//mencari nama akun//
		$qakun_awal = @mysql_query("select * from akun where id_akun='$dawal[akun2]' ");
		$dakun_awal = @mysql_fetch_assoc($qakun_awal);

		if(($t1 == '+')and($t2 == '-'))
		{
		$awal = ($Tawal+$debet_awal9)-$kredit_awal9;
		}else
		if(($t1 == '-')and($t2 == '+'))
		{
		$awal = ($Tawal-$debet_awal9)+$kredit_awal9;
		}

		$Tawal = $awal;
		$Tawalribuan = ribuan($Tawal);

		}
	}
}
if($Tawal != '')
{
$T = $Tawal;
$Tribuan= ribuan($T);
}else
{
$T = 0;
$Tribuan= ribuan($T);
}

$q = @mysql_query("select * from jurnal where tgl like '%$all%' order by tgl ");
$b = @mysql_num_rows($q);
	while($d = @mysql_fetch_assoc($q))
	{

		if($d['akun1']==$id_akun)
		{
		$tanggal = tgl_indo($d['tgl']);
		$debet = ribuan($d['debet1']); 	
		$kredit = ribuan($d['kredit1']);
		$debet9 = $d['debet1']; 	
		$kredit9 = $d['kredit1'];

		//mencari nama akun//
		$qakun = @mysql_query("select * from akun where id_akun='$d[akun1]' ");
		$dakun = @mysql_fetch_assoc($qakun);

		//mengatur operator
		if(($t1 == '+')and($t2 == '-'))
		{
		$k = ($T+$debet9)-$kredit9;
		}else
		if(($t1 == '-')and($t2 == '+'))
		{
		$k = ($T-$debet9)+$kredit9;
		}
		$T = $k;
		$Tribuan = ribuan($T);

		}else
		if($d['akun2']==$id_akun)
		{
		$tanggal = tgl_indo($d['tgl']);
		$debet = ribuan($d['debet2']); 	
		$kredit = ribuan($d['kredit2']);
		$debet9 = $d['debet2']; 	
		$kredit9 = $d['kredit2'];

		//mencari nama akun//
		$qakun = @mysql_query("select * from akun where id_akun='$d[akun2]' ");
		$dakun = @mysql_fetch_assoc($qakun);

		//mengatur operator
		if(($t1 == '+')and($t2 == '-'))
		{
		$k = ($T+$debet9)-$kredit9;
		}else
		if(($t1 == '-')and($t2 == '+'))
		{
		$k = ($T-$debet9)+$kredit9;
		}
		$T = $k;
		$Tribuan = ribuan($T);
		}
	}
	$TotalT = $TotalT+$T;
	if($normal=='DEBET')
	{
	}else
	{
	}

	$x++;
}
$TotalT2=ribuan($TotalT);
?>
<?
//=========================================HUTANG JANGKA PENDEK=========================================\\
/* UTANG SUPPLIER */
$saldoawal=0;$saldoawal2=0;
$q_supp_awal = " SELECT * FROM supplier order by nama";
$h_supp_awal = mysql_query($q_supp_awal) or die ("Ada kesalahan :".mysql_error());
while($d_supp_awal = mysql_fetch_assoc($h_supp_awal))
{
//=====================mencari pembelian barang sebelum tanggal pencarian====================//
$qbelib_awal = " SELECT * FROM beli join barang on (beli.id_barang=barang.id_barang) where beli.id_barang like '%$d_supp_awal[id_supplier]%' and tanggal < '$all' order by tanggal";
$hbelib_awal = mysql_query( $qbelib_awal ) or die(mysql_error());
$bbelib_awal = @mysql_num_rows($hbelib_awal);
$total_pembelian_awal =0;$total_pembelian2_awal=0;$total_pembelian22_awal=0;
	while( $dbelib_awal = mysql_fetch_assoc($hbelib_awal) )
	{
	$total_pembelian_awal = $dbelib_awal['qty']*$dbelib_awal['hrg_beli'];
	$total_pembelian2_awal= $total_pembelian2_awal+$total_pembelian_awal;
	}
	$total_pembelian22_awal=$total_pembelian2_awal*(1);
//=====================mencari pembelian ayam sebelum tanggal pencarian====================//
$qcpl_awal = " SELECT * FROM pja_luar where id_supplier='$d_supp_awal[id_supplier]' and tanggal < '$all' order by tanggal";
$hcpl_awal = mysql_query( $qcpl_awal) or die(mysql_error());
$bcpl_awal = @mysql_num_rows($hcpl_awal);
$tpsl_awal=0;$tps22l_awal=0;$tps2l_awal=0;
	while( $dcpl_awal = mysql_fetch_assoc($hcpl_awal) )
	{
		if($dcpl_awal['hrg_beli_real'] != '')
		{
		$tpsl_awal = ($dcpl_awal['hrg_beli_real']*($dcpl_awal['tonase_real']+$dcpl_awal['tonase_susut']));
		}else
		{
		$tpsl_awal = ($dcpl_awal['hrg_beli_rcn']*$dcpl_awal['tonase_rcn']);
		}
		$tps22l_awal= $tps22l_awal+$tpsl_awal;	
	}
	$tps2l_awal=$tps22l_awal*(1);
//====================================================================================// 
//=====================mencari pinjaman pusat sebelum tanggal pencarian====================//
if($d_supp_awal['id_supplier']=='DFP')
{
$qdfp_awal = " SELECT * FROM tambah_utang_supplier where tanggal < '$all' order by tanggal";
$hdfp_awal = mysql_query( $qdfp_awal ) or die(mysql_error());
$bdfp_awal = @mysql_num_rows($hdfp_awal);
$tdfp_awal=0;$tdfp2_awal=0;
	while( $ddfp_awal = mysql_fetch_assoc($hdfp_awal) )
	{
		$tdfp_awal = $ddfp_awal['jml']+$tdfp_awal;
	}
	$tdfp2_awal=$tdfp_awal*(1);
}else
{
	$tdfp2_awal=0;
}
//====================================================================================// 
//=====================mencari pembayaran sebelum tanggal pencarian====================//
$qbaysupp_awal = " SELECT * FROM pembayaran_supplier where id_supplier ='$d_supp_awal[id_supplier]' and tgl_bayar < '$all' order by tgl_bayar";
$hbaysupp_awal = mysql_query($qbaysupp_awal) or die(mysql_error());
$bbaysupp_awal = @mysql_num_rows($hbaysupp_awal);
$debet_awal =0;$tbs_awal =0;
	while( $dbaysupp_awal = mysql_fetch_assoc($hbaysupp_awal) )
	{	
	$debet_awal = $dbaysupp_awal['jml_bayar']*(-1); 
	$tbs_awal = $tbs_awal+$debet_awal;
	}
//=====================mencari pot.pembayaran sebelum tanggal pencarian====================//
$qptsupp_aw = " SELECT * FROM pembayaran_supplier where id_supplier ='$d_supp_awal[id_supplier]' and tgl_bayar < '$all' order by tgl_bayar";
$hptsupp_aw = mysql_query( $qptsupp_aw ) or die(mysql_error());
$bptsupp_aw = @mysql_num_rows($hptsupp_aw);
$tbts_aw=0;$debetpot_aw=0;
	while( $dptsupp_aw = mysql_fetch_assoc($hptsupp_aw) )
	{	
	$debetpot_aw = $dptsupp_aw['jml_potongan']*(-1); 
	$tbts_aw = $tbts_aw+$debetpot_aw;
	}
//=====================mencari ret.pembayaran sebelum tanggal pencarian====================//
$qrtsupp = " SELECT * FROM pembayaran_supplier where id_supplier ='$d_supp_awal[id_supplier]' and tgl_bayar < '$all' order by tgl_bayar";
$hrtsupp = mysql_query( $qrtsupp ) or die(mysql_error());
$brtsupp = @mysql_num_rows($hrtsupp);
$debetret=0;$tbret=0;
	while( $drtsupp = mysql_fetch_assoc($hrtsupp) )
	{	
	$debetret = $drtsupp['jml_retur']; 
	$tbret = $tbret+$debetret;
	}
//=====================mencari retur sebelum tanggal pencarian=========================//
$qretsupp_awal = " SELECT * FROM retur_beli join barang on (retur_beli.id_barang=barang.id_barang) where retur_beli.id_barang like '%$d_supp_awal[id_supplier]%' and tgl_rsup < '$all' order by tgl_rsup";
$hretsupp_awal = mysql_query( $qretsupp_awal ) or die(mysql_error());
$tret_awal =0;$debetret_awal =0;
	while( $dretsupp_awal = mysql_fetch_assoc($hretsupp_awal) )
	{
	$debetret_awal = ($dretsupp_awal['qty']*$dretsupp_awal['hrg_beli'])*(-1); 
	$tret_awal = $tret_awal+$debetret_awal;
	}
//====================================================================================// 
$saldoawal = (($tbs_awal+$tbts_aw+$total_pembelian22_awal+$tps2l_awal+$tdfp2_awal)+$tret_awal+$tbret)+($d_supp_awal['saldo_awal']*(-1));
$saldoawal2=ribuan($saldoawal);
//========================================================================================================================================================================// 
$qbelib = " SELECT * FROM beli join barang on (beli.id_barang=barang.id_barang) where beli.id_barang like '%$d_supp_awal[id_supplier]%' and tanggal like '$all%' order by tanggal";
$hbelib = mysql_query( $qbelib ) or die(mysql_error());
$bbelib = @mysql_num_rows($hbelib);
$total_pembelian =0;$total_pembelian2=0;$total_pembelian22=0;
	while( $dbelib = mysql_fetch_assoc($hbelib) )
	{
	$total_pembelian = $dbelib['qty']*$dbelib['hrg_beli'];
	$total_pembelian2= $total_pembelian2+$total_pembelian;
	}
	$total_pembelian22=$total_pembelian2*(1);
//========================================================================================================================================================================//
$qcpl = " SELECT * FROM pja_luar where id_supplier='$d_supp_awal[id_supplier]' and tanggal like '$all%' order by tanggal";
$hcpl = mysql_query( $qcpl) or die(mysql_error());
$bcpl = @mysql_num_rows($hcpl);
$tpsl=0;$tps22l=0;$tps2l=0;
	while( $dcpl = mysql_fetch_assoc($hcpl) )
	{
		if($dcpl['hrg_beli_real'] != '')
		{
		$tpsl = ($dcpl['hrg_beli_real']*($dcpl['tonase_real']+$dcpl['tonase_susut']));
		}else
		{
		$tpsl = ($dcpl['hrg_beli_rcn']*$dcpl['tonase_rcn']);
		}
		$tps22l= $tps22l+$tpsl;	
	}
	$tps2l=$tps22l*(1);
//========================================================================================================================================================================//
if($d_supp_awal['id_supplier']=='DFP')
{
$qdfp = " SELECT * FROM tambah_utang_supplier where tanggal like '$all%' order by tanggal";
$hdfp = mysql_query( $qdfp ) or die(mysql_error());
$bdfp = @mysql_num_rows($hdfp);
$tdfp=0;$tdfp2=0;
	while( $ddfp = mysql_fetch_assoc($hdfp) )
	{
		$tdfp = $ddfp['jml']+$tdfp;
	}
	$tdfp2=$tdfp*(1);
}else
{
	$tdfp2=0;
}
//========================================================================================================================================================================//
$qbaysupp = " SELECT * FROM pembayaran_supplier where id_supplier ='$d_supp_awal[id_supplier]' and tgl_bayar like '$all%' order by tgl_bayar";
$hbaysupp = mysql_query($qbaysupp) or die(mysql_error());
$bbaysupp = @mysql_num_rows($hbaysupp);
$debet =0;$tbs =0;
	while( $dbaysupp = mysql_fetch_assoc($hbaysupp) )
	{	
	$debet = $dbaysupp['jml_bayar']*(-1); 
	$tbs = $tbs+$debet;
	}
//========================================================================================================================================================================//
$qptsupp = " SELECT * FROM pembayaran_supplier where id_supplier = '$d_supp_awal[id_supplier]' and tgl_bayar like '$all%' order by tgl_bayar";
$hptsupp = mysql_query( $qptsupp ) or die(mysql_error());
$bptsupp = @mysql_num_rows($hptsupp);
$tbts=0;$debetpot=0;
	while( $dptsupp = mysql_fetch_assoc($hptsupp) )
	{	
	$debetpot = $dptsupp['jml_potongan']*(-1); 
	$tbts = $tbts+$debetpot;
	}
//========================================================================================================================================================================//
$qretsupp = " SELECT * FROM pembayaran_supplier where id_supplier = '$d_supp_awal[id_supplier]' and tgl_bayar like '$all%' order by tgl_bayar";
$hretsupp = mysql_query( $qretsupp ) or die(mysql_error());
$bretsupp = @mysql_num_rows($hretsupp);
$saldoretbayar=0;$Tretbayar=0;
	while( $dretsupp = mysql_fetch_assoc($hretsupp) )
	{	
	$saldoretbayar=$saldoretbayar+$dretsupp['jml_retur'];
	}
//========================================================================================================================================================================// 
$qretsupp = " SELECT * FROM retur_beli join barang on (retur_beli.id_barang=barang.id_barang) where retur_beli.id_barang like '%$d_supp_awal[id_supplier]%' and tgl_rsup like '$all%' order by tgl_rsup";
$hretsupp = mysql_query( $qretsupp ) or die(mysql_error());
$tret =0;$debetret =0;
	while( $dretsupp = mysql_fetch_assoc($hretsupp) )
	{
	$debetret = ($dretsupp['qty']*$dretsupp['hrg_beli'])*(-1); 
	$tret = $tret_awal+$debetret;
	}
//========================================================================================================================================================================// 
$saldoakhir = (($tbs+$tbts+$total_pembelian22+$tps2l+$tdfp2)+$tret+$saldoretbayar)+($saldoawal);
$saldoakhir2=ribuan($saldoakhir);

$Tsaldo_akhir = $Tsaldo_akhir+$saldoakhir;
}
$Tsaldo_akhir2=ribuan($Tsaldo_akhir);
?>
<?
//Hutang AB Ke Peternak//
$qprod_pja = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where panenbulan='0000-00-00' or panenbulan > '$all_berikutnya%' order by produksi.id_produksi");
$Ttps22=0;$Tppa_awal=0;$Tppa=0;$Totps22=0;
while($dprod_pja = mysql_fetch_assoc($qprod_pja))
{	
	$id_prod_pja = $dprod_pja['id_produksi'];
	//tanggal sebelumnya//
	$tps22_awal=0;
	$qpja_awal = mysql_query("select * from pja where id_produksi='$id_prod_pja' and tanggal < '$all%'");	
	$bpja_awal = mysql_num_rows($qpja_awal);
	if(($bpja_awal != '')or($bpja_awal != 0))
	{
		$tps_awal=0;
		while($dpja_awal = mysql_fetch_assoc($qpja_awal))
		{
			if(($dpja_awal['hrg_kirim'] != '')and($dpja_awal['jml_jual'] != ''))
			{
			$tps_awal=$dpja_awal['hrg_kirim']*$dpja_awal['jml_jual'];
			}
			else
			if($dpja_awal['susut_tonase'] != '')
			{
			$nsusut_awal = $dpja_awal['hrg_real']*$dpja_awal['tonase_susut'];;
			$tps_awal = ($dpja_awal['hrg_real']*$dpja_awal['tonase_real'])-$nsusut_awal;
			}else
			if(($dpja_awal['hrg_real'] != '')and($dpja_awal['tonase_susut'] == ''))
			{
			$tps_awal = ($dpja_awal['hrg_real']*$dpja_awal['tonase_real']);
			}else
			{
			$tps_awal = ($dpja_awal['hrg_rcn']*$dpja_awal['tonase_rcn']);
			}
			$tps22_awal= $tps22_awal+$tps_awal;		
		}
	}
	//tanggal sekarang//
	$tps22=0;
	$qpja = mysql_query("select * from pja where id_produksi='$id_prod_pja' and tanggal like '$all%'");	
	$bpja = mysql_num_rows($qpja);
	if(($bpja != '')or($bpja != 0))
	{
		$tps=0;
		while($dpja = mysql_fetch_assoc($qpja))
		{
			if(($dpja['hrg_kirim'] != '')and($dpja['jml_jual'] != ''))
			{
			$tps=$dpja['hrg_kirim']*$dpja['jml_jual'];
			}
			else
			if($dpja['susut_tonase'] != '')
			{
			$nsusut = $dpja['hrg_real']*$dpja['tonase_susut'];;
			$tps = ($dpja['hrg_real']*$dpja['tonase_real'])-$nsusut;
			}else
			if(($dpja['hrg_real'] != '')and($dpja['tonase_susut'] == ''))
			{
			$tps = ($dpja['hrg_real']*$dpja['tonase_real']);
			}else
			{
			$tps = ($dpja['hrg_rcn']*$dpja['tonase_rcn']);
			}
			$tps22= $tps22+$tps;		
		}
	}
	
	$Totps22=$Totps22+($tps22_awal+$tps22);
}
//mencari margin penjualan ayam
$qcplb_awal = " SELECT * FROM pja_luar where tonase_real='' and tanggal < '$all%' order by tanggal";
$hcplb_awal = mysql_query( $qcplb_awal) or die(mysql_error());
$bcplb_awal = @mysql_num_rows($hcplb_awal);
$tpslb_awal=0;$tps22lb_awal=0;$tps2lb_awal=0;
	while( $dcplb_awal = mysql_fetch_assoc($hcplb_awal) )
	{
		$penjlb_awal=$dcplb_awal['tonase_rcn']*$dcplb_awal['hrg_rcn'];
		$pemblb_awal=$dcplb_awal['tonase_rcn']*$dcplb_awal['hrg_beli_rcn'];
		$marginlb_awal=$penjlb_awal-$pemblb_awal;
		$tps22lb_awal= $tps22lb_awal+$marginlb_awal;	
	}
	$tps2lb_awal=$tps22lb_awal;
	
$qcplb = " SELECT * FROM pja_luar where tonase_real='' and tanggal like '$all%' order by tanggal";
$hcplb = mysql_query( $qcplb) or die(mysql_error());
$bcplb = @mysql_num_rows($hcplb);
$tpslb=0;$tps22lb=0;$tps2lb=0;
	while( $dcplb = mysql_fetch_assoc($hcplb) )
	{
		$penjlb=$dcplb['tonase_rcn']*$dcplb['hrg_rcn'];
		$pemblb=$dcplb['tonase_rcn']*$dcplb['hrg_beli_rcn'];
		$marginlb=$penjlb-$pemblb;
		$tps22lb= $tps22lb+$marginlb;	
	}
	$tps2lb=$tps22lb;
$totallb=$tps2lb+$tps2lb_awal;
//===========================================BIAYA POT.PENJ.AYAM SEBELUMNYA===========================================\\
$qppa_awal = mysql_query("select * from rhpp where panenbulan='0000-00-00'");
while($dppa_awal=mysql_fetch_assoc($qppa_awal))
{
	$id_prod_ppa_awal=$dppa_awal['id_produksi'];
	$ppa_awal=0;
	$qpem_ppa_awal=mysql_query("select * from pembayaran_konsumen where id_produksi='$id_prod_ppa_awal' and tgl_bayar < '$all%' order by id_produksi");
	while($dpem_ppa_awal=mysql_fetch_assoc($qpem_ppa_awal))
	{
		$ppa_awal=$ppa_awal+$dpem_ppa_awal['jml_potongan'];
	}
	$Tppa_awal=$Tppa_awal+$ppa_awal;
}
$Totppa_awal=$Tppa_awal*(-1);
//===========================================BIAYA POT.PENJ.AYAM SEKARANG===========================================\\
$qppa = mysql_query("select * from rhpp where panenbulan='0000-00-00'");
while($dppa=mysql_fetch_assoc($qppa))
{
	$id_prod_ppa=$dppa['id_produksi'];
	$ppa=0;
	$qpem_ppa=mysql_query("select * from pembayaran_konsumen where id_produksi='$id_prod_ppa' and tgl_bayar like '$all%' order by id_produksi");
	while($dpem_ppa=mysql_fetch_assoc($qpem_ppa))
	{
		$ppa=$ppa+$dpem_ppa['jml_potongan'];
	}
	$Tppa=$Tppa+$ppa;
}
$Totppa=$Tppa*(-1);

$Totps22r=ribuan($Totps22+($Totppa_awal+$Totppa)+$totallb);

$x_9=3;
$query_9 = mysql_query("select * from rules_akun where id_akun like '210%' and id_akun != '210.01' and id_akun != '210.02' order by id_akun");
while($data_9 = mysql_fetch_assoc($query_9))
{
	$id_akun_9 = $data_9['id_akun'];
	$t1_9 = $data_9['debet'];
	$t2_9 = $data_9['kredit'];
	$normal_9 = $data_9['normal'];
	$q1_9 = mysql_query("select * from akun where id_akun = '$id_akun_9' ");
	$d2_9 = mysql_fetch_assoc($q1_9);
//cari saldo awal
$Tawal_9 =0;	$Totawal_9 =0; $T_9 = 0;
$qawal_9 = @mysql_query("select * from jurnal where tgl < '$all' ");
$bawal_9 = @mysql_num_rows($qawal_9);
if($bawal_9>0)
{
	while($dawal_9 = @mysql_fetch_assoc($qawal_9))
	{
		if($dawal_9['akun1']== $id_akun_9)
		{
		$tanggal_awal_9 = tgl_indo($dawal_9['tgl']);
		$debet_awal_9 = ribuan($dawal_9['debet1']); 	
		$kredit_awal_9 = ribuan($dawal_9['kredit1']);
		$debet_awal9_9 = $dawal_9['debet1']; 	
		$kredit_awal9_9 = $dawal_9['kredit1'];
		
		//mencari nama akun//
		$qakun_awal_9 = @mysql_query("select * from akun where id_akun='$dawal_9[akun1]' ");
		$dakun_awal_9 = @mysql_fetch_assoc($qakun_awal_9);
		
		//mengatur operator
		if(($t1_9 == '+')and($t2_9 == '-'))
		{
		$awal_9 = ($Tawal_9+$debet_awal9_9)-$kredit_awal9_9;
		}else
		if(($t1_9 == '-')and($t2_9 == '+'))
		{
		$awal_9 = ($Tawal_9-$debet_awal9_9)+$kredit_awal9_9;
		}
		
		$Tawal_9 = $awal_9;
		$Tawalribuan_9 = ribuan($Tawal_9);
		
		}else
		if($dawal_9['akun2']== $id_akun_9)
		{
		$tanggal_awal_9 = tgl_indo($dawal_9['tgl']);
		$debet_awal_9 = ribuan($dawal_9['debet2']); 	
		$kredit_awal_9 = ribuan($dawal_9['kredit2']);
		$debet_awal9_9 = $dawal_9['debet2']; 	
		$kredit_awal9_9 = $dawal_9['kredit2'];

		//mencari nama akun//
		$qakun_awal_9 = @mysql_query("select * from akun where id_akun='$dawal_9[akun2]' ");
		$dakun_awal_9 = @mysql_fetch_assoc($qakun_awal_9);

		if(($t1_9 == '+')and($t2_9 == '-'))
		{
		$awal_9 = ($Tawal_9+$debet_awal9_9)-$kredit_awal9_9;
		}else
		if(($t1_9 == '-')and($t2_9 == '+'))
		{
		$awal_9 = ($Tawal_9-$debet_awal9_9)+$kredit_awal9_9;
		}

		$Tawal_9 = $awal_9;
		$Tawalribuan_9 = ribuan($Tawal_9);

		}
	}
}
if($Tawal_9 != '')
{
$T_9 = $Tawal_9;
$Tribuan_9= ribuan($T_9);
}else
{
$T_9 = 0;
$Tribuan_9= ribuan($T_9);
}

$q_9 = @mysql_query("select * from jurnal where tgl like '%$all%' order by tgl ");
$b_9 = @mysql_num_rows($q_9);
	while($d_9 = @mysql_fetch_assoc($q_9))
	{

		if($d_9['akun1']==$id_akun_9)
		{
		$tanggal_9 = tgl_indo($d_9['tgl']);
		$debet_9 = ribuan($d_9['debet1']); 	
		$kredit_9 = ribuan($d_9['kredit1']);
		$debet9_9 = $d_9['debet1']; 	
		$kredit9_9 = $d_9['kredit1'];

		//mencari nama akun//
		$qakun_9 = @mysql_query("select * from akun where id_akun='$d_9[akun1]' ");
		$dakun_9 = @mysql_fetch_assoc($qakun_9);

		//mengatur operator
		if(($t1_9 == '+')and($t2_9 == '-'))
		{
		$k_9 = ($T_9+$debet9_9)-$kredit9_9;
		}else
		if(($t1_9 == '-')and($t2_9 == '+'))
		{
		$k_9 = ($T_9-$debet9_9)+$kredit9_9;
		}
		$T_9 = $k_9;
		$Tribuan_9 = ribuan($T_9);

		}else
		if($d_9['akun2']==$id_akun_9)
		{
		$tanggal_9 = tgl_indo($d_9['tgl']);
		$debet_9 = ribuan($d_9['debet2']); 	
		$kredit_9 = ribuan($d_9['kredit2']);
		$debet9_9 = $d_9['debet2']; 	
		$kredit9_9 = $d_9['kredit2'];

		//mencari nama akun//
		$qakun_9 = @mysql_query("select * from akun where id_akun='$d_9[akun2]' ");
		$dakun_9 = @mysql_fetch_assoc($qakun_9);

		//mengatur operator
		if(($t1_9 == '+')and($t2_9 == '-'))
		{
		$k_9 = ($T_9+$debet9_9)-$kredit9_9;
		}else
		if(($t1_9 == '-')and($t2_9 == '+'))
		{
		$k_9 = ($T_9-$debet9_9)+$kredit9_9;
		}
		$T_9 = $k_9;
		$Tribuan_9 = ribuan($T_9);
		}
	}
	$TotalT_9 = $TotalT_9+$T_9;
	if($normal_9=='DEBET')
	{
	}else
	{
	}

	$x_9++;
}
$TotalT2_9=ribuan($TotalT_9+$Tsaldo_akhir+$Totps22+($Totppa_awal+$Totppa)+$totallb);
?>
<?
//=========================================NON OPERASIONAL=========================================\\
$x_2=1;
$query_2 = mysql_query("select * from rules_akun where id_akun like '111%' order by id_akun");
while($data_2 = mysql_fetch_assoc($query_2))
{
	$id_akun_2 = $data_2['id_akun'];
	$t1_2 = $data_2['debet'];
	$t2_2 = $data_2['kredit'];
	$normal_2 = $data_2['normal'];
	$q1_2 = mysql_query("select * from akun where id_akun = '$id_akun_2' ");
	$d2_2 = mysql_fetch_assoc($q1_2);
//cari saldo awal
$Tawal_2 =0;	$Totawal_2 =0; $T_2 = 0;
$qawal_2 = @mysql_query("select * from jurnal where tgl < '$all' ");
$bawal_2 = @mysql_num_rows($qawal_2);
if($bawal_2>0)
{
	while($dawal_2 = @mysql_fetch_assoc($qawal_2))
	{
		if($dawal_2['akun1']== $id_akun_2)
		{
		$tanggal_awal_2 = tgl_indo($dawal_2['tgl']);
		$debet_awal_2 = ribuan($dawal_2['debet1']); 	
		$kredit_awal_2 = ribuan($dawal_2['kredit1']);
		$debet_awal9_2 = $dawal_2['debet1']; 	
		$kredit_awal9_2 = $dawal_2['kredit1'];
		
		//mencari nama akun//
		$qakun_awal_2 = @mysql_query("select * from akun where id_akun='$dawal_2[akun1]' ");
		$dakun_awal_2 = @mysql_fetch_assoc($qakun_awal_2);
		
		//mengatur operator
		if(($t1_2 == '+')and($t2_2 == '-'))
		{
		$awal_2 = ($Tawal_2+$debet_awal9_2)-$kredit_awal9_2;
		}else
		if(($t1_2 == '-')and($t2_2 == '+'))
		{
		$awal_2 = ($Tawal_2-$debet_awal9_2)+$kredit_awal9_2;
		}
		
		$Tawal_2 = $awal_2;
		$Tawalribuan_2 = ribuan($Tawal_2);
		
		}else
		if($dawal_2['akun2']== $id_akun_2)
		{
		$tanggal_awal_2 = tgl_indo($dawal_2['tgl']);
		$debet_awal_2 = ribuan($dawal_2['debet2']); 	
		$kredit_awal_2 = ribuan($dawal_2['kredit2']);
		$debet_awal9_2 = $dawal_2['debet2']; 	
		$kredit_awal9_2 = $dawal_2['kredit2'];

		//mencari nama akun//
		$qakun_awal_2 = @mysql_query("select * from akun where id_akun='$dawal_2[akun2]' ");
		$dakun_awal_2 = @mysql_fetch_assoc($qakun_awal_2);

		if(($t1_2 == '+')and($t2_2 == '-'))
		{
		$awal_2 = ($Tawal_2+$debet_awal9_2)-$kredit_awal9_2;
		}else
		if(($t1_2 == '-')and($t2_2 == '+'))
		{
		$awal_2 = ($Tawal_2-$debet_awal9_2)+$kredit_awal9_2;
		}

		$Tawal_2 = $awal_2;
		$Tawalribuan_2 = ribuan($Tawal_2);

		}
	}
}
if($Tawal_2 != '')
{
$T_2 = $Tawal_2;
$Tribuan_2= ribuan($T_2);
}else
{
$T_2 = 0;
$Tribuan_2= ribuan($T_2);
}

$q_2 = @mysql_query("select * from jurnal where tgl like '%$all%' order by tgl ");
$b_2 = @mysql_num_rows($q_2);
	while($d_2 = @mysql_fetch_assoc($q_2))
	{

		if($d_2['akun1']==$id_akun_2)
		{
		$tanggal_2 = tgl_indo($d_2['tgl']);
		$debet_2 = ribuan($d_2['debet1']); 	
		$kredit_2 = ribuan($d_2['kredit1']);
		$debet9_2 = $d_2['debet1']; 	
		$kredit9_2 = $d_2['kredit1'];

		//mencari nama akun//
		$qakun_2 = @mysql_query("select * from akun where id_akun='$d_2[akun1]' ");
		$dakun_2 = @mysql_fetch_assoc($qakun_2);

		//mengatur operator
		if(($t1_2 == '+')and($t2_2 == '-'))
		{
		$k_2 = ($T_2+$debet9_2)-$kredit9_2;
		}else
		if(($t1_2 == '-')and($t2_2 == '+'))
		{
		$k_2 = ($T_2-$debet9_2)+$kredit9_2;
		}
		$T_2 = $k_2;
		$Tribuan_2 = ribuan($T_2);

		}else
		if($d_2['akun2']==$id_akun_2)
		{
		$tanggal_2 = tgl_indo($d_2['tgl']);
		$debet_2 = ribuan($d_2['debet2']); 	
		$kredit_2 = ribuan($d_2['kredit2']);
		$debet9_2 = $d_2['debet2']; 	
		$kredit9_2 = $d_2['kredit2'];

		//mencari nama akun//
		$qakun_2 = @mysql_query("select * from akun where id_akun='$d_2[akun2]' ");
		$dakun_2 = @mysql_fetch_assoc($qakun_2);

		//mengatur operator
		if(($t1_2 == '+')and($t2_2 == '-'))
		{
		$k_2 = ($T_2+$debet9_2)-$kredit9_2;
		}else
		if(($t1_2 == '-')and($t2_2 == '+'))
		{
		$k_2 = ($T_2-$debet9_2)+$kredit9_2;
		}
		$T_2 = $k_2;
		$Tribuan_2 = ribuan($T_2);
		}
	}
	$TotalT_2 = $TotalT_2+$T_2;
	if($normal_2=='DEBET')
	{
	}else
	{
	}

	$x_2++;
}
$TotalT2_2=ribuan($TotalT_2);
?>
<?
//===========================================HUTANG BANK===========================================\\
//DO_HL
$ql_hl = " SELECT * FROM leasing_hl order by id_leasing_hl ";
$hl_hl = mysql_query( $ql_hl ) or die(mysql_error());
while($dl_hl = mysql_fetch_assoc($hl_hl))
{
	//sekarang
	$ttotal =0;$Tbunga =0;
	$saldo_awal=$dl_hl['saldo_awal'];
	$qdol_hl = " SELECT * FROM do_leasing_hl where id_leasing_hl='$dl_hl[id_leasing_hl]' and tgl like '$all%' order by tgl ";
	$hdol_hl = mysql_query( $qdol_hl ) or die(mysql_error());
	$bdol_hl = @mysql_num_rows($hdol_hl);
	while( $ddol_hl = mysql_fetch_assoc($hdol_hl) )
	{	
		$ttotal = $ttotal+$ddol_hl['jumlah'];
		$Tbunga = $Tbunga+$ddol_hl['bunga'];
	}
	
	//sebelumnya
	$ttotal_aw =0;$Tbunga_aw =0;
	$qdol_hl_aw = " SELECT * FROM do_leasing_hl where id_leasing_hl='$dl_hl[id_leasing_hl]' and tgl < '$all%' order by tgl ";
	$hdol_hl_aw = mysql_query( $qdol_hl_aw) or die(mysql_error());
	$bdol_hl_aw = @mysql_num_rows($hdol_hl_aw);
	while( $ddol_hl_aw = mysql_fetch_assoc($hdol_hl_aw) )
	{	
		$ttotal_aw = $ttotal_aw+$ddol_hl_aw['jumlah'];
		$Tbunga_aw = $Tbunga_aw+$ddol_hl_aw['bunga'];
	}

	$tot_dol_hl = $tot_dol_hl+$ttotal+$Tbunga+$ttotal_aw+$Tbunga_aw+$saldo_awal;
} 
$tot_dol_hl2=ribuan($tot_dol_hl);
//Pembayaran
$qpl_aw2 = " SELECT * FROM pembayaran_leasing_hl where tgl_bayar < '$all%' order by tgl_bayar ";
$hpl_aw2 = mysql_query( $qpl_aw2 ) or die(mysql_error());
while($dpl_aw2 = mysql_fetch_assoc($hpl_aw2))
{
	$jpl_aw2 = $jpl_aw2+$dpl_aw2['jml_bayar'];
	$bpl_aw2 = $bpl_aw2+$dpl_aw2['bunga'];
} 
$qpl2 = " SELECT * FROM pembayaran_leasing_hl where tgl_bayar like '$all%' order by tgl_bayar ";
$hpl2 = mysql_query( $qpl2 ) or die(mysql_error());
while($dpl2 = mysql_fetch_assoc($hpl2))
{
	$jpl2 = $jpl2+$dpl2['jml_bayar'];
	$bpl2 = $bpl2+$dpl2['bunga'];
} 
//Potongan
$qpotl_aw2 = " SELECT * FROM pembayaran_leasing_hl where tgl_bayar < '$all%' order by tgl_bayar ";
$hpotl_aw2 = mysql_query( $qpotl_aw2 ) or die(mysql_error());
while($dpotl_aw2 = mysql_fetch_assoc($hpotl_aw2))
{
	$jpotl_aw2 = $jpotl_aw2+$dpotl_aw2['jml_potongan'];
} 
$qpotl2 = " SELECT * FROM pembayaran_leasing_hl where tgl_bayar like '$all%' order by tgl_bayar ";
$hpotl2 = mysql_query( $qpotl2 ) or die(mysql_error());
while($dpotl2 = mysql_fetch_assoc($hpotl2))
{
	$jpotl2 = $jpotl2+$dpotl2['jml_potongan'];
} 
//Retur
$qretl_aw2 = " SELECT * FROM pembayaran_leasing_hl where tgl_bayar < '$all%' order by tgl_bayar ";
$hretl_aw2 = mysql_query( $qretl_aw2 ) or die(mysql_error());
while($dretl_aw2 = mysql_fetch_assoc($hretl_aw2))
{
	$jretl_aw2 = $jretl_aw2+$dretl_aw2['jml_retur'];
} 
$qretl2 = " SELECT * FROM pembayaran_leasing_hl where tgl_bayar like '$all%' order by tgl_bayar ";
$hretl2 = mysql_query( $qretl2 ) or die(mysql_error());
while($dretl2 = mysql_fetch_assoc($hretl2))
{
	$jretl2 = $jretl2+$dretl2['jml_retur'];
} 
$total_hutang_leasing_hl = $tot_dol_hl-($jpl_aw2+$jpl2+$jpotl_aw2+$jpotl2+$bpl_aw2+$bpl2)+($jretl_aw2+$jretl2);
$total_hutang_leasing_hl2=ribuan($total_hutang_leasing_hl);
?>
<?
//===========================================HUTANG LEASING===========================================\\
//DO_HT
$ql = " SELECT * FROM leasing order by id_leasing ";
$hl = mysql_query( $ql ) or die(mysql_error());
while($dl = mysql_fetch_assoc($hl))
{
	//sekarang
	$ttotalx =0;$Tbungax =0;
	$saldo_awalx=$dl['saldo_awal'];
	$qdol = " SELECT * FROM do_leasing where id_leasing='$dl[id_leasing]' and tgl like '$all%' order by tgl ";
	$hdol = mysql_query( $qdol ) or die(mysql_error());
	$bdol = @mysql_num_rows($hdol);
	while( $ddol = mysql_fetch_assoc($hdol) )
	{	
		$ttotalx = $ttotalx+$ddol['jumlah'];
		$Tbungax = $Tbungax+$ddol['bunga'];
	}
	//sebelumnya
	$ttotalx_aw =0;$Tbungax_aw =0;
	$qdol_aw = " SELECT * FROM do_leasing where id_leasing='$dl[id_leasing]' and tgl < '$all%' order by tgl ";
	$hdol_aw = mysql_query( $qdol_aw ) or die(mysql_error());
	$bdol_aw = @mysql_num_rows($hdol_aw);
	while( $ddol_aw = mysql_fetch_assoc($hdol_aw) )
	{	
		$ttotalx_aw = $ttotalx_aw+$ddol_aw['jumlah'];
		$Tbungax_aw = $Tbungax_aw+$ddol_aw['bunga'];
	}
	
	$tot_dol = $tot_dol+$ttotalx+$Tbungax+$ttotalx_aw+$Tbungax_aw+$saldo_awalx;
} 
$tot_dol2=ribuan($tot_dol);
//Pembayaran
$qpl_aw = " SELECT * FROM pembayaran_leasing where tgl_bayar < '$all%' order by tgl_bayar ";
$hpl_aw = mysql_query( $qpl_aw ) or die(mysql_error());
while($dpl_aw = mysql_fetch_assoc($hpl_aw))
{
	$jpl_aw = $jpl_aw+$dpl_aw['jml_bayar'];
	$bpl_aw = $bpl_aw+$dpl_aw['bunga'];
} 
$qpl = " SELECT * FROM pembayaran_leasing where tgl_bayar like '$all%' order by tgl_bayar ";
$hpl = mysql_query( $qpl ) or die(mysql_error());
while($dpl = mysql_fetch_assoc($hpl))
{
	$jpl = $jpl+$dpl['jml_bayar'];
	$bpl = $bpl+$dpl['bunga'];
} 
//Potongan
$qpotl_aw = " SELECT * FROM pembayaran_leasing where tgl_bayar < '$all%' order by tgl_bayar ";
$hpotl_aw = mysql_query( $qpotl_aw ) or die(mysql_error());
while($dpotl_aw = mysql_fetch_assoc($hpotl_aw))
{
	$jpotl_aw = $jpotl_aw+$dpotl_aw['jml_potongan'];
} 
$qpotl = " SELECT * FROM pembayaran_leasing where tgl_bayar like '$all%' order by tgl_bayar ";
$hpotl = mysql_query( $qpotl ) or die(mysql_error());
while($dpotl = mysql_fetch_assoc($hpotl))
{
	$jpotl = $jpotl+$dpotl['jml_potongan'];
} 
//Retur
$qretl_aw = " SELECT * FROM pembayaran_leasing where tgl_bayar < '$all%' order by tgl_bayar ";
$hretl_aw = mysql_query( $qretl_aw ) or die(mysql_error());
while($dretl_aw = mysql_fetch_assoc($hretl_aw))
{
	$jretl_aw = $jretl_aw+$dretl_aw['jml_retur'];
} 
$qretl = " SELECT * FROM pembayaran_leasing where tgl_bayar like '$all%' order by tgl_bayar ";
$hretl = mysql_query( $qretl ) or die(mysql_error());
while($dretl = mysql_fetch_assoc($hretl))
{
	$jretl = $jretl+$dretl['jml_retur'];
} 

$total_hutang_leasing = $tot_dol-($jpl_aw+$jpl+$jpotl_aw+$jpotl+$bpl_aw+$bpl)+($jretl_aw+$jretl);
$total_hutang_leasing2=ribuan($total_hutang_leasing);
?>
<?
//===========================================HUTANG TABUNGAN PETERNAK===========================================\\
$query = " SELECT * FROM farm order by nama ";
$hasil = mysql_query( $query ) or die(mysql_error());
$banyak = @mysql_num_rows($hasil);
if($banyak > 0 )
{	
	while( $data = mysql_fetch_assoc($hasil) )
	{	
		//sebelumnya
		$tab=0;$amb=0;
		$qt=@mysql_query("select * from tabungan where id_farm='$data[id_farm]' and tanggal < '$all%' order by tanggal");
		while($dt=@mysql_fetch_assoc($qt))
		{
			$tab = $tab+$dt['jml_tabungan'];
		}
		$tab2=ribuan($tab);
		$qt2=@mysql_query("select * from tabungan where id_farm='$data[id_farm]' and tanggal < '$all%' order by tanggal");
		while($dt2=@mysql_fetch_assoc($qt2))
		{
			$amb = $amb+$dt2['jml_ambil_tabungan'];
		}
		$amb2=ribuan($amb);
		//sekarang
		$tab_now=0;$amb_now=0;
		$qt_now=@mysql_query("select * from tabungan where id_farm='$data[id_farm]' and tanggal like '$all%' order by tanggal");
		while($dt_now=@mysql_fetch_assoc($qt_now))
		{
			$tab_now = $tab_now+$dt_now['jml_tabungan'];
		}
		$tab2_now=ribuan($tab_now);
		$qt2_now=@mysql_query("select * from tabungan where id_farm='$data[id_farm]' and tanggal like '$all%' order by tanggal");
		while($dt2_now=@mysql_fetch_assoc($qt2_now))
		{
			$amb_now = $amb_now+$dt2_now['jml_ambil_tabungan'];
		}
		$amb2_now=ribuan($amb_now);
		$sa = ($data['saldo_awal_tab']+$tab+$tab_now)-$amb-$amb_now;
		$sa2=ribuan($sa);

		$Tsal = $Tsal+$data['saldo_awal_tab'];
		$Ttab = $Ttab+$tab;
		$Tamb = $Tamb+$amb;
		$Tsa = $Tsa+$sa;	
	}
}
$Tsa_r=ribuan($Tsa);
//===========================================HUTANG JANGKA PANJANG===========================================\\
$x_10=4;
$query_10 = mysql_query("select * from rules_akun where id_akun like '220%' and id_akun!='220.01' and id_akun!='220.02' and id_akun!='220.03' order by id_akun");
while($data_10 = mysql_fetch_assoc($query_10))
{
	$id_akun_10 = $data_10['id_akun'];
	$t1_10 = $data_10['debet'];
	$t2_10 = $data_10['kredit'];
	$normal_10 = $data_10['normal'];
	$q1_10 = mysql_query("select * from akun where id_akun = '$id_akun_10' ");
	$d2_10 = mysql_fetch_assoc($q1_10);
//cari saldo awal
$Tawal_10 =0;	$Totawal_10 =0; $T_10 = 0;
$qawal_10 = @mysql_query("select * from jurnal where tgl < '$all' ");
$bawal_10 = @mysql_num_rows($qawal_10);
if($bawal_10>0)
{
	while($dawal_10 = @mysql_fetch_assoc($qawal_10))
	{
		if($dawal_10['akun1']== $id_akun_10)
		{
		$tanggal_awal_10 = tgl_indo($dawal_10['tgl']);
		$debet_awal_10 = ribuan($dawal_10['debet1']); 	
		$kredit_awal_10 = ribuan($dawal_10['kredit1']);
		$debet_awal9_10 = $dawal_10['debet1']; 	
		$kredit_awal9_10 = $dawal_10['kredit1'];
		
		//mencari nama akun//
		$qakun_awal_10 = @mysql_query("select * from akun where id_akun='$dawal_10[akun1]' ");
		$dakun_awal_10 = @mysql_fetch_assoc($qakun_awal_10);
		
		//mengatur operator
		if(($t1_10 == '+')and($t2_10 == '-'))
		{
		$awal_10 = ($Tawal_10+$debet_awal9_10)-$kredit_awal9_10;
		}else
		if(($t1_10 == '-')and($t2_10 == '+'))
		{
		$awal_10 = ($Tawal_10-$debet_awal9_10)+$kredit_awal9_10;
		}
		
		$Tawal_10 = $awal_10;
		$Tawalribuan_10 = ribuan($Tawal_10);
		
		}else
		if($dawal_10['akun2']== $id_akun_10)
		{
		$tanggal_awal_10 = tgl_indo($dawal_10['tgl']);
		$debet_awal_10 = ribuan($dawal_10['debet2']); 	
		$kredit_awal_10 = ribuan($dawal_10['kredit2']);
		$debet_awal9_10 = $dawal_10['debet2']; 	
		$kredit_awal9_10 = $dawal_10['kredit2'];

		//mencari nama akun//
		$qakun_awal_10 = @mysql_query("select * from akun where id_akun='$dawal_10[akun2]' ");
		$dakun_awal_10 = @mysql_fetch_assoc($qakun_awal_10);

		if(($t1_10 == '+')and($t2_10 == '-'))
		{
		$awal_10 = ($Tawal_10+$debet_awal9_10)-$kredit_awal9_10;
		}else
		if(($t1_10 == '-')and($t2_10 == '+'))
		{
		$awal_10 = ($Tawal_10-$debet_awal9_10)+$kredit_awal9_10;
		}

		$Tawal_10 = $awal_10;
		$Tawalribuan_10 = ribuan($Tawal_10);

		}
	}
}
if($Tawal_10 != '')
{
$T_10 = $Tawal_10;
$Tribuan_10= ribuan($T_10);
}else
{
$T_10 = 0;
$Tribuan_10= ribuan($T_10);
}

$q_10 = @mysql_query("select * from jurnal where tgl like '%$all%' order by tgl ");
$b_10 = @mysql_num_rows($q_10);
	while($d_10 = @mysql_fetch_assoc($q_10))
	{

		if($d_10['akun1']==$id_akun_10)
		{
		$tanggal_10 = tgl_indo($d_10['tgl']);
		$debet_10 = ribuan($d_10['debet1']); 	
		$kredit_10 = ribuan($d_10['kredit1']);
		$debet9_10 = $d_10['debet1']; 	
		$kredit9_10 = $d_10['kredit1'];

		//mencari nama akun//
		$qakun_10 = @mysql_query("select * from akun where id_akun='$d_10[akun1]' ");
		$dakun_10 = @mysql_fetch_assoc($qakun_10);

		//mengatur operator
		if(($t1_10 == '+')and($t2_10 == '-'))
		{
		$k_10 = ($T_10+$debet9_10)-$kredit9_10;
		}else
		if(($t1_10 == '-')and($t2_10 == '+'))
		{
		$k_10 = ($T_10-$debet9_10)+$kredit9_10;
		}
		$T_10 = $k_10;
		$Tribuan_10 = ribuan($T_10);

		}else
		if($d_10['akun2']==$id_akun_10)
		{
		$tanggal_10 = tgl_indo($d_10['tgl']);
		$debet_10 = ribuan($d_10['debet2']); 	
		$kredit_10 = ribuan($d_10['kredit2']);
		$debet9_10 = $d_10['debet2']; 	
		$kredit9_10 = $d_10['kredit2'];

		//mencari nama akun//
		$qakun_10 = @mysql_query("select * from akun where id_akun='$d_10[akun2]' ");
		$dakun_10 = @mysql_fetch_assoc($qakun_10);

		//mengatur operator
		if(($t1_10 == '+')and($t2_10 == '-'))
		{
		$k_10 = ($T_10+$debet9_10)-$kredit9_10;
		}else
		if(($t1_10 == '-')and($t2_10 == '+'))
		{
		$k_10 = ($T_10-$debet9_10)+$kredit9_10;
		}
		$T_10 = $k_10;
		$Tribuan_10 = ribuan($T_10);
		}
	}
	$TotalT_10 = $TotalT_10+$T_10;
	if($normal_10=='DEBET')
	{
	}else
	{
	}

	$x_10++;
}
$TotalT2_10=ribuan($TotalT_10+$Tsa+$total_hutang_leasing_hl+$total_hutang_leasing); 
?>
<?
//===========================================PIUTANG===========================================\\
$q_cust = " SELECT * FROM konsumen order by id_konsumen";
$h_cust = mysql_query( $q_cust ) or die(mysql_error());
$b_cust = @mysql_num_rows($h_cust);
$saldoakhir=0;$i=0;$saldoakhir_cust=0;
while( $d_cust = mysql_fetch_assoc($h_cust) )
{
	//=====================mencari penjualan sebelum tanggal pencarian====================//
	$qcp_awal = " SELECT * FROM pja where id_konsumen='$d_cust[id_konsumen]' and tanggal < '$all' order by tanggal";
	$hcp_awal = mysql_query( $qcp_awal ) or die(mysql_error());
	$bcp_awal = @mysql_num_rows($hcp_awal);
	$tps22_awal=0;$tps_awal =0;$tps2_awal=0;
	while( $dcp_awal = mysql_fetch_assoc($hcp_awal) )
	{
		if(($dcp_awal['hrg_kirim'] != '')and($dcp_awal['jml_jual'] != ''))
		{
		$tps_awal=$dcp_awal['hrg_kirim']*$dcp_awal['jml_jual'];
		}
		else
		if($dcp_awal['susut_tonase'] != '')
		{
		$nsusut_awal = $dcp_awal['hrg_real']*$dcp_awal['tonase_susut'];;
		$tps_awal = ($dcp_awal['hrg_real']*$dcp_awal['tonase_real'])-$nsusut_awal;
		}else
		if(($dcp_awal['hrg_real'] != '')and($dcp_awal['tonase_susut'] == ''))
		{
		$tps_awal = ($dcp_awal['hrg_real']*$dcp_awal['tonase_real']);
		}else
		{
		$tps_awal = ($dcp_awal['hrg_rcn']*$dcp_awal['tonase_rcn']);
		}
		$tps22_awal= $tps22_awal+$tps_awal;		
	}
	$tps2_awal=$tps22_awal*(1);
//====================================================================================// 
//=====================mencari penjualan luar sebelum tanggal pencarian====================//
$qcplu_awal = " SELECT * FROM pja_luar where id_konsumen='$d_cust[id_konsumen]' and tanggal < '$all' order by tanggal";
$hcplu_awal = mysql_query( $qcplu_awal ) or die(mysql_error());
$bcplu_awal = @mysql_num_rows($hcplu_awal);
$tpslu_awal=0;$tps22lu_awal=0;$tps2lu_awal=0;
	while( $dcplu_awal = mysql_fetch_assoc($hcplu_awal) )
	{
		if($dcplu_awal['hrg_real'] != '')
		{
		$tpslu_awal = ($dcplu_awal['hrg_real']*$dcplu_awal['tonase_real']);
		}else
		{
		$tpslu_awal = ($dcplu_awal['hrg_rcn']*$dcplu_awal['tonase_rcn']);
		}
		
		$tps22lu_awal= $tps22lu_awal+$tpslu_awal;		
	}
	$tps2lu_awal=$tps22lu_awal*(1);
//====================================================================================// 
//=====================mencari pembayaran sebelum tanggal pencarian====================//
$qcba_awal = " SELECT * FROM pembayaran_konsumen where id_konsumen='$d_cust[id_konsumen]' and tgl_bayar < '$all' order by tgl_bayar";
$hcba_awal = mysql_query( $qcba_awal ) or die(mysql_error());
$bcba_awal = @mysql_num_rows($hcba_awal);
$tbsa_awal =0;$debeta_awal =0;$debet2a_awal =0;
	while( $dcba_awal = mysql_fetch_assoc($hcba_awal) )
	{	
		if(empty($dcba_awal['jml_bayar']))
		{  
			$debeta_awal = $dcba_awal['jml_potongan'];  
		}else 
		if(($dcba_awal['jml_bayar']>0)&&($dcba_awal['jml_potongan']>0))
		{
			$debeta_awal = $dcba_awal['jml_bayar']+$dcba_awal['jml_potongan'];
		}else
		{ 
			$debeta_awal = $dcba_awal['jml_bayar']; 
		}
		
		if($dcba_awal['jml_retur'] != '')
		{
			$debet2a_awal = $dcba_awal['jml_retur'];
		}else
		{
			$debet2a_awal = 0;
		}
		
		$tbsa_awal = $tbsa_awal+$debeta_awal-$debet2a_awal;
	}
//=============================== Saldo awal ==========================================//
$so_awal_piutang_cust=0;$saldoawal_cust=0;
$qbandar_cust = " SELECT * FROM konsumen where id_konsumen='$d_cust[id_konsumen]'";
$hbandar_cust = mysql_query( $qbandar_cust ) or die(mysql_error());
$dbandar_cust = mysql_fetch_assoc($hbandar_cust);
$so_awal_piutang_cust = $dbandar_cust['saldo_awal']*(-1); 
$saldoawal_cust = (($so_awal_piutang_cust+$tps2_awal+$tps2lu_awal)-$tbsa_awal);
$saldoawalribuan_cust=ribuan($saldoawal_cust);
//====================================================================================//
//========================penjualan ayam==============================//
	$qcp_ayam = " SELECT * FROM pja where id_konsumen='$d_cust[id_konsumen]' and tanggal like '$all%' order by tanggal";
	$hcp_ayam = mysql_query( $qcp_ayam ) or die(mysql_error());
	$bcp_ayam = @mysql_num_rows($hcp_ayam);
	$tps22_ayam=0;$tps_ayam =0;$tps2_ayam=0;
	while( $dcp_ayam = mysql_fetch_assoc($hcp_ayam) )
	{
		if(($dcp_ayam['hrg_kirim'] != '')and($dcp_ayam['jml_jual'] != ''))
		{
		$tps_ayam=$dcp_ayam['hrg_kirim']*$dcp_ayam['jml_jual'];
		}
		else
		if($dcp_ayam['susut_tonase'] != '')
		{
		$nsusut_ayam = $dcp_ayam['hrg_real']*$dcp_ayam['tonase_susut'];;
		$tps_ayam = ($dcp_ayam['hrg_real']*$dcp_ayam['tonase_real'])-$nsusut_ayam;
		}else
		if(($dcp_ayam['hrg_real'] != '')and($dcp_ayam['tonase_susut'] == ''))
		{
		$tps_ayam = ($dcp_ayam['hrg_real']*$dcp_ayam['tonase_real']);
		}else
		{
		$tps_ayam = ($dcp_ayam['hrg_rcn']*$dcp_ayam['tonase_rcn']);
		}
		$tps22_ayam= $tps22_ayam+$tps_ayam;		
	}
	$tps2_ayam=$tps22_ayam*(1);
//=====================mencari penjualan luar sesuai tanggal pencarian====================//
	$qcplu_ayam = " SELECT * FROM pja_luar where id_konsumen='$d_cust[id_konsumen]' and tanggal like '$all%' order by tanggal";
	$hcplu_ayam = mysql_query( $qcplu_ayam ) or die(mysql_error());
	$bcplu_ayam = @mysql_num_rows($hcplu_ayam);
	$tpslu_ayam=0;$tps22lu_ayam=0;$tps2lu_ayam=0;
		while( $dcplu_ayam = mysql_fetch_assoc($hcplu_ayam) )
		{
			if($dcplu_ayam['hrg_real'] != '')
			{
			$tpslu_ayam = ($dcplu_ayam['hrg_real']*$dcplu_ayam['tonase_real']);
			}else
			{
			$tpslu_ayam = ($dcplu_ayam['hrg_rcn']*$dcplu_ayam['tonase_rcn']);
			}
			
			$tps22lu_ayam= $tps22lu_ayam+$tpslu_ayam;		
		}
		$tps2lu_ayam=$tps22lu_ayam*(1);

//=====================mencari pembayaran sesuai tanggal pencarian====================//
$qcba_ayam = " SELECT * FROM pembayaran_konsumen where id_konsumen='$d_cust[id_konsumen]' and tgl_bayar like '$all%' order by tgl_bayar";
$hcba_ayam = mysql_query( $qcba_ayam ) or die(mysql_error());
$bcba_ayam = @mysql_num_rows($hcba_ayam);
$tbsa_ayam =0;$debeta_ayam =0;$debet2a_ayam =0;
	while( $dcba_ayam = mysql_fetch_assoc($hcba_ayam) )
	{	
		if(empty($dcba_ayam['jml_bayar']))
		{  
			$debeta_ayam = $dcba_ayam['jml_potongan'];  
		}else 
		if(($dcba_ayam['jml_bayar']>0)&&($dcba_ayam['jml_potongan']>0))
		{
			$debeta_ayam = $dcba_ayam['jml_bayar']+$dcba_ayam['jml_potongan'];
		}else
		{ 
			$debeta_ayam = $dcba_ayam['jml_bayar']; 
		}
		
		if($dcba_ayam['jml_retur'] != '')
		{
			$debet2a_ayam = $dcba_ayam['jml_retur'];
		}else
		{
			$debet2a_ayam = 0;
		}
		
		$tbsa_ayam = $tbsa_ayam+$debeta_ayam-$debet2a_ayam;
	}
$saldoakhir_cust = (($saldoawal_cust+$tps2_ayam+$tps2lu_ayam)-$tbsa_ayam);
$Tsaldoakhir_cust = $Tsaldoakhir_cust+$saldoakhir_cust;
}
$Tsaldoakhir_cust2=ribuan($Tsaldoakhir_cust);
?>
<?
$q_kar = " SELECT * FROM karyawan order by nama ";
$h_kar = mysql_query( $q_kar ) or die(mysql_error());
$b_kar = @mysql_num_rows($h_kar);
$sa=0;
while( $d_kar = mysql_fetch_assoc($h_kar))
{	
		//--------------------------------------------------------------------sebelumnya-----------------------------------------------------------\\
		$byr_kar=0;$ret_kar=0;$totall_kar=0;$pk_kar=0;
		$qt_kar=mysql_query("select * from pembayaran_karyawan where nip='$d_kar[nip]' and jml_potongan > 0 and tgl_bayar < '$all%' order by tgl_bayar");
		while($dt_kar=mysql_fetch_assoc($qt_kar))
		{
			$byr_kar = $byr_kar+$dt_kar['jml_potongan'];
		}
		$byr2_kar=ribuan($byr_kar);
		//retur
		$qt2_kar=mysql_query("select * from pembayaran_karyawan where nip='$d_kar[nip]' and jml_retur > 0 and tgl_bayar < '$all%' order by tgl_bayar");
		while($dt2_kar=mysql_fetch_assoc($qt2_kar))
		{
			$ret_kar = $ret_kar+$dt2_kar['jml_retur'];
		}
		$rett_kar=$ret_kar*(-1);
		$ret2_kar=ribuan($rett_kar);
		//cari utang
		$qt3_kar=mysql_query("select * from utang_karyawan where nip='$d_kar[nip]' and tanggal < '$all%' order by tanggal");
		while($dt3_kar=@mysql_fetch_assoc($qt3_kar))
		{
			$jumlah_kar=$dt3_kar['jumlah'];
			$totall_kar=$totall_kar+$jumlah_kar;
		}
		$total_kar=$totall_kar*(-1);
		//Pembayaran
		$qt4_kar=mysql_query("select * from pembayaran_karyawan where nip='$d_kar[nip]' and jml_bayar > 0 and tgl_bayar < '$all%' order by tgl_bayar ");
		while($dt4_kar=@mysql_fetch_assoc($qt4_kar))
		{
			$pk_kar=$pk_kar+$dt4_kar['jml_bayar'];
		}
		$pk2_kar=ribuan($pk_kar);
		$total2_kar=ribuan($total_kar);
		//--------------------------------------------------------------------sekarang-----------------------------------------------------------\\
		$byr_kar_now=0;$ret_kar_now=0;$totall_kar_now=0;$pk_kar_now=0;
		$qt_kar_now=mysql_query("select * from pembayaran_karyawan where nip='$d_kar[nip]' and jml_potongan > 0 and tgl_bayar like '$all%' order by tgl_bayar");
		while($dt_kar_now=mysql_fetch_assoc($qt_kar_now))
		{
			$byr_kar_now = $byr_kar_now+$dt_kar_now['jml_potongan'];
		}
		$byr2_kar_now=ribuan($byr_kar_now);
		//retur
		$qt2_kar_now=mysql_query("select * from pembayaran_karyawan where nip='$d_kar[nip]' and jml_retur > 0 and tgl_bayar like '$all%' order by tgl_bayar");
		while($dt2_kar_now=mysql_fetch_assoc($qt2_kar_now))
		{
			$ret_kar_now = $ret_kar_now+$dt2_kar_now['jml_retur'];
		}
		$rett_kar_now=$ret_kar_now*(-1);
		$ret2_kar_now=ribuan($rett_kar_now);
		//cari utang
		$qt3_kar_now=mysql_query("select * from utang_karyawan where nip='$d_kar[nip]' and tanggal like '$all%' order by tanggal");
		while($dt3_kar_now=@mysql_fetch_assoc($qt3_kar_now))
		{
			$jumlah_kar_now=$dt3_kar_now['jumlah'];
			$totall_kar_now=$totall_kar_now+$jumlah_kar_now;
		}
		$total_kar_now=$totall_kar_now*(-1);
		//Pembayaran
		$qt4_kar_now=mysql_query("select * from pembayaran_karyawan where nip='$d_kar[nip]' and jml_bayar > 0 and tgl_bayar like '$all%' order by tgl_bayar ");
		while($dt4_kar_now=@mysql_fetch_assoc($qt4_kar_now))
		{
			$pk_kar_now=$pk_kar_now+$dt4_kar_now['jml_bayar'];
		}
		//----------------------------------------------------------------------------------------------------------------------------------------\\
		$sa = ($d_kar['saldo_awal']+$total_kar+$rett_kar+$total_kar_now+$rett_kar_now)+$pk_kar+$byr_kar+$pk_kar_now+$byr_kar_now;
		$sa2_kar=ribuan($sa_kar);
		$Totsa=$Totsa+$sa;
}
$Totsa3=($Totsa*(-1));
$Totsa2=ribuan($Totsa*(-1));
?>
<?
$q_farm = " SELECT * FROM farm order by nama ";
$h_farm = mysql_query( $q_farm ) or die(mysql_error());
$b_farm = @mysql_num_rows($h_farm);
$Totsa_farm==0;
while( $d_farm = mysql_fetch_assoc($h_farm) )
{	
		//--------------------------------------------------------------------sebelumnya-----------------------------------------------------------\\
		//cari pembayaran
		$byr_farm=0;$rp_farm=0;$totall_farm=0;$pk_farm=0;
		$qt_farm=mysql_query("select * from pembayaran_farm where id_farm='$d_farm[id_farm]' and tgl_bayar < '$all%' order by tgl_bayar");
		while($dt_farm=mysql_fetch_assoc($qt_farm))
		{
			$byr_farm = $byr_farm+$dt_farm['jml_bayar'];
		}
		$byr2_farm=ribuan($byr_farm);
		//PIUTANG PERALATAN
		$Ttotal_sfarm=0;$total_sfarm=0;$Ttotal_sfarm2=0;$tot_sfarm=0;
		$qt3_sfarm=mysql_query("select * from utang_peralatan where id_farm='$d_farm[id_farm]' and approve='' and tgl_bon < '$all%' order by tgl_bon");
		while($dt3_sfarm=mysql_fetch_assoc($qt3_sfarm))
		{
			$totall_sfarm=0;
			$id_barang_sfarm=$dt3_sfarm['id_barang'];
			$qty_sfarm=$dt3_sfarm['qty'];
			$qbrg_sfarm=mysql_query("select * from barang where id_barang='$id_barang_sfarm' ");
			$dbrg_sfarm=mysql_fetch_assoc($qbrg_sfarm);
			$tot_sfarm=$qty_sfarm*$dbrg_sfarm['hrg_jual'];
			$totall_sfarm=$totall_sfarm+$tot_sfarm;
		$total_sfarm=$totall_sfarm;
		$Ttotal_sfarm=$Ttotal_sfarm+$total_sfarm;
		}
		$Ttotal_sfarm2=ribuan($Ttotal_sfarm);

		//Piutang Kas		
		$qt4_farm=mysql_query("select * from utang_kas where id_farm='$d_farm[id_farm]' and tanggal < '$all%' order by tanggal ");
		while($dt4_farm=mysql_fetch_assoc($qt4_farm))
		{
			$pk_farm=$pk_farm+$dt4_farm['jml'];
		}
		$pkk_farm=$pk_farm*(1);
		$pk2_farm=ribuan($pkk_farm);
		$total2_farm=ribuan($total_farm);
		$rp2_farm=ribuan($rp_farm);
		//--------------------------------------------------------------------sekarang-----------------------------------------------------------\\
		//cari pembayaran
		$byr_farm_now=0;$rp_farm_now=0;$totall_farm_now=0;$pk_farm_now=0;$tot_sfarm_now=0;
		$qt_farm_now=mysql_query("select * from pembayaran_farm where id_farm='$d_farm[id_farm]' and tgl_bayar like '$all%' order by tgl_bayar");
		while($dt_farm_now=mysql_fetch_assoc($qt_farm_now))
		{
			$byr_farm_now = $byr_farm_now+$dt_farm_now['jml_bayar'];
		}
		$byr2_farm_now=ribuan($byr_farm_now);
		//PIUTANG PERALATAN
		$Ttotal_sfarm_now=0;$total_sfarm_now=0;$Ttotal_sfarm2_now=0;
		$qt3_sfarm_now=mysql_query("select * from utang_peralatan where id_farm='$d_farm[id_farm]' and approve='' and tgl_bon like '$all%' order by tgl_bon");
		while($dt3_sfarm_now=mysql_fetch_assoc($qt3_sfarm_now))
		{
			$totall_sfarm_now=0;
			$id_barang_sfarm_now=$dt3_sfarm_now['id_barang'];
			$qty_sfarm_now=$dt3_sfarm_now['qty'];
			$qbrg_sfarm_now=mysql_query("select * from barang where id_barang='$id_barang_sfarm_now' ");
			$dbrg_sfarm_now=mysql_fetch_assoc($qbrg_sfarm_now);
			$tot_sfarm_now=$qty_sfarm_now*$dbrg_sfarm_now['hrg_jual'];
			$totall_sfarm_now=$totall_sfarm_now+$tot_sfarm_now;
		$total_sfarm_now=$totall_sfarm_now;
		$Ttotal_sfarm_now=$Ttotal_sfarm_now+$total_sfarm_now;
		}
		$Ttotal_sfarm2_now=ribuan($Ttotal_sfarm_now);

		//Piutang Kas		
		$qt4_farm_now=mysql_query("select * from utang_kas where id_farm='$d_farm[id_farm]' and tanggal like '$all%' order by tanggal ");
		while($dt4_farm_now=mysql_fetch_assoc($qt4_farm_now))
		{
			$pk_farm_now=$pk_farm_now+$dt4_farm_now['jml'];
		}
		$pkk_farm_now=$pk_farm_now*(1);
		$pk2_farm_now=ribuan($pkk_farm_now);
		$total2_farm_now=ribuan($total_farm_now);
		$rp2_farm_now=ribuan($rp_farm_now);
		//----------------------------------------------------------------------------------------------------------------------------------------\\
		$sa_farm = (($d_farm['saldo_awal']*-1)+$Ttotal_sfarm+$pkk_farm+$Ttotal_sfarm_now+$pkk_farm_now)-$byr_farm-$byr_farm_now;
		$sa2_farm=ribuan($sa_farm);
		$Totsa_farm=$Totsa_farm+$sa_farm;
}
$Totsa_farm3=($Totsa_farm*(1));
$Totsa_farm2=ribuan($Totsa_farm*(1));
?>
<?
$q_cab = " SELECT * FROM cabang order by id_cabang ";
$h_cab = mysql_query( $q_cab ) or die(mysql_error());
$b_cab = @mysql_num_rows($h_cab);

while( $d_cab = mysql_fetch_assoc($h_cab) )
{	

	$sa_cab=$d_cab['saldo_awal'];
	$Tsa_cab=$Tsa_cab+$sa_cab;
	$q_jc_aw = mysql_query("select * from jual_cabang where tgl_nota < '$all%' order by tgl_nota ");
	$sub_jcab_aw=0;$Tsub_jcab_aw=0;
	while($d_jc_aw=mysql_fetch_assoc($q_jc_aw))
	{
		$id_barang_jcab_aw=$d_jc_aw['id_barang'];
		$qty_jcab_aw=$d_jc_aw['qty'];
		//barang//
		$q_bar_aw = mysql_query("select * from barang where id_barang='$id_barang_jcab_aw'");
		$d_bar_aw = mysql_fetch_assoc($q_bar_aw);
		$hrg_bar_aw = $d_bar_aw['hrg_beli'];
		$sub_jcab_aw = $hrg_bar_aw*$qty_jcab_aw;
		$Tsub_jcab_aw=$Tsub_jcab_aw+$sub_jcab_aw;
	}

	$q_jc = mysql_query("select * from jual_cabang where tgl_nota like '$all%' order by tgl_nota ");
	$sub_jcab=0;$Tsub_jcab=0;$Totsub_jcab=0;
	while($d_jc=mysql_fetch_assoc($q_jc))
	{
		$id_barang_jcab=$d_jc['id_barang'];
		$qty_jcab=$d_jc['qty'];
		//barang//
		$q_bar = mysql_query("select * from barang where id_barang='$id_barang_jcab'");
		$d_bar = mysql_fetch_assoc($q_bar);
		$hrg_bar = $d_bar['hrg_beli'];
		$sub_jcab = $hrg_bar*$qty_jcab;
		$Tsub_jcab=$Tsub_jcab+$sub_jcab;
	}
	
	$q_bcab_aw = mysql_query("select * from pembayaran_cabang where tgl_bayar < '$all%' order by tgl_bayar ");
	$Tbayar_cab_aw=0;$Tpotbayar_cab_aw=0;$Tretbayar_cab_aw=0;
	while($d_bcab_aw=mysql_fetch_assoc($q_bcab_aw))
	{
		$bayar_cab_aw=$d_bcab_aw['jml_bayar'];
		$potbayar_cab_aw=$d_bcab_aw['jml_potongan'];
		$retbayar_cab_aw=$d_bcab_aw['jml_retur'];
		
		$Tbayar_cab_aw=$Tbayar_cab_aw+$bayar_cab_aw;
		$Tpotbayar_cab_aw=$Tpotbayar_cab_aw+$potbayar_cab_aw;
		$Tretbayar_cab_aw=$Tretbayar_cab_aw+$retbayar_cab_aw;
	}
	$q_bcab = mysql_query("select * from pembayaran_cabang where tgl_bayar like '$all%' order by tgl_bayar ");
	$Tbayar_cab=0;$Tpotbayar_cab=0;$Tretbayar_cab=0;
	while($d_bcab=mysql_fetch_assoc($q_bcab))
	{
		$bayar_cab=$d_bcab['jml_bayar'];
		$potbayar_cab=$d_bcab['jml_potongan'];
		$retbayar_cab=$d_bcab['jml_retur'];
		
		$Tbayar_cab=$Tbayar_cab+$bayar_cab;
		$Tpotbayar_cab=$Tpotbayar_cab+$potbayar_cab;
		$Tretbayar_cab=$Tretbayar_cab+$retbayar_cab;
	}

}
$Totsub_jcab=$Tsub_jcab_aw+$Tsub_jcab+($Tsa_cab)-$Tbayar_cab-$Tpotbayar_cab+$Tretbayar_cab-$Tbayar_cab_aw-$Tpotbayar_cab_aw+$Tretbayar_cab_aw;
$Totalsub_jcab=$Totalsub_jcab+$Totsub_jcab;
$Totalsub_jcab2=ribuan($Totalsub_jcab);

$x_piutang=5;
$query_piutang = mysql_query("select * from rules_akun where id_akun like '112%' and id_akun != '112.01'and id_akun != '112.02'and id_akun != '112.03' and id_akun != '112.04' and id_akun != '112.05' order by id_akun");
while($data_piutang = mysql_fetch_assoc($query_piutang))
{
	$id_akun_piutang = $data_piutang['id_akun'];
	$t1_piutang = $data_piutang['debet'];
	$t2_piutang = $data_piutang['kredit'];
	$normal_piutang = $data_piutang['normal'];
	$q1_piutang = mysql_query("select * from akun where id_akun = '$id_akun_piutang' ");
	$d2_piutang = mysql_fetch_assoc($q1_piutang);
//cari saldo awal
$Tawal_piutang =0;	$Totawal_piutang =0; $T_piutang = 0;
$qawal_piutang = @mysql_query("select * from jurnal where tgl < '$all' ");
$bawal_piutang = @mysql_num_rows($qawal_piutang);
if($bawal_piutang>0)
{
	while($dawal_piutang = @mysql_fetch_assoc($qawal_piutang))
	{
		if($dawal_piutang['akun1']== $id_akun_piutang)
		{
		$tanggal_awal_piutang = tgl_indo($dawal_piutang['tgl']);
		$debet_awal_piutang = ribuan($dawal_piutang['debet1']); 	
		$kredit_awal_piutang = ribuan($dawal_piutang['kredit1']);
		$debet_awal9_piutang = $dawal_piutang['debet1']; 	
		$kredit_awal9_piutang = $dawal_piutang['kredit1'];
		
		//mencari nama akun//
		$qakun_awal_piutang = @mysql_query("select * from akun where id_akun='$dawal_piutang[akun1]' ");
		$dakun_awal_piutang = @mysql_fetch_assoc($qakun_awal_piutang);
		
		//mengatur operator
		if(($t1_piutang == '+')and($t2_piutang == '-'))
		{
		$awal_piutang = ($Tawal_piutang+$debet_awal9_piutang)-$kredit_awal9_piutang;
		}else
		if(($t1_piutang == '-')and($t2_piutang == '+'))
		{
		$awal_piutang = ($Tawal_piutang-$debet_awal9_piutang)+$kredit_awal9_piutang;
		}
		
		$Tawal_piutang = $awal_piutang;
		$Tawalribuan_piutang = ribuan($Tawal_piutang);
		
		}else
		if($dawal_piutang['akun2']== $id_akun_piutang)
		{
		$tanggal_awal_piutang = tgl_indo($dawal_piutang['tgl']);
		$debet_awal_piutang = ribuan($dawal_piutang['debet2']); 	
		$kredit_awal_piutang = ribuan($dawal_piutang['kredit2']);
		$debet_awal9_piutang = $dawal_piutang['debet2']; 	
		$kredit_awal9_piutang = $dawal_piutang['kredit2'];

		//mencari nama akun//
		$qakun_awal_piutang = @mysql_query("select * from akun where id_akun='$dawal_piutang[akun2]' ");
		$dakun_awal_piutang = @mysql_fetch_assoc($qakun_awal_piutang);

		if(($t1_piutang == '+')and($t2_piutang == '-'))
		{
		$awal_piutang = ($Tawal_piutang+$debet_awal9_piutang)-$kredit_awal9_piutang;
		}else
		if(($t1_piutang == '-')and($t2_piutang == '+'))
		{
		$awal_piutang = ($Tawal_piutang-$debet_awal9_piutang)+$kredit_awal9_piutang;
		}

		$Tawal_piutang = $awal_piutang;
		$Tawalribuan_piutang = ribuan($Tawal_piutang);

		}
	}
}
if($Tawal_piutang != '')
{
$T_piutang = $Tawal_piutang;
$Tribuan_piutang= ribuan($T_piutang);
}else
{
$T_piutang = 0;
$Tribuan_piutang= ribuan($T_piutang);
}

$q_piutang = @mysql_query("select * from jurnal where tgl like '%$all%' order by tgl ");
$b_piutang = @mysql_num_rows($q_piutang);
	while($d_piutang = @mysql_fetch_assoc($q_piutang))
	{

		if($d_piutang['akun1']==$id_akun_piutang)
		{
		$tanggal_piutang = tgl_indo($d_piutang['tgl']);
		$debet_piutang = ribuan($d_piutang['debet1']); 	
		$kredit_piutang = ribuan($d_piutang['kredit1']);
		$debet9_piutang = $d_piutang['debet1']; 	
		$kredit9_piutang = $d_piutang['kredit1'];

		//mencari nama akun//
		$qakun_piutang = @mysql_query("select * from akun where id_akun='$d_piutang[akun1]' ");
		$dakun_piutang = @mysql_fetch_assoc($qakun_piutang);

		//mengatur operator
		if(($t1_piutang == '+')and($t2_piutang == '-'))
		{
		$k_piutang = ($T_piutang+$debet9_piutang)-$kredit9_piutang;
		}else
		if(($t1 == '-')and($t2 == '+'))
		{
		$k_piutang = ($T_piutang-$debet9_piutang)+$kredit9_piutang;
		}
		$T_piutang = $k_piutang;
		$Tribuan_piutang = ribuan($T_piutang);

		}else
		if($d_piutang['akun2']==$id_akun_piutang)
		{
		$tanggal_piutang = tgl_indo($d_piutang['tgl']);
		$debet_piutang = ribuan($d_piutang['debet2']); 	
		$kredit_piutang = ribuan($d_piutang['kredit2']);
		$debet9_piutang = $d_piutang['debet2']; 	
		$kredit9_piutang = $d_piutang['kredit2'];

		//mencari nama akun//
		$qakun_piutang = @mysql_query("select * from akun where id_akun='$d_piutang[akun2]' ");
		$dakun_piutang = @mysql_fetch_assoc($qakun_piutang);

		//mengatur operator
		if(($t1_piutang == '+')and($t2_piutang == '-'))
		{
		$k_piutang = ($T_piutang+$debet9_piutang)-$kredit9_piutang;
		}else
		if(($t1_piutang == '-')and($t2_piutang == '+'))
		{
		$k_piutang = ($T_piutang-$debet9_piutang)+$kredit9_piutang;
		}
		$T_piutang = $k_piutang;
		$Tribuan_piutang = ribuan($T_piutang);
		}
	}
	$TotalT_piutang = $TotalT_piutang+$T_piutang;
	if($normal_piutang=='DEBET')
	{
	}else
	{
	}

	$x++;
}
$TotalT2_piutang=ribuan($TotalT_piutang);

$TotalPiutang=$Totalsub_jcab+$Totsa_farm3+$Totsa3+$Tsaldoakhir_cust+$TotalT_piutang;
$TotalPiutang2=ribuan($TotalPiutang);
?>
<?
//===========================================BIAYA BIAYA SEBELUMNYA===========================================\\
$x_by_awal=1;
$query_by_awal = mysql_query("select * from rules_akun where id_akun like '5%' and id_akun != '580.04' order by id_akun");
while($data_by_awal = mysql_fetch_assoc($query_by_awal))
{
	$id_akun_by_awal = $data_by_awal['id_akun'];
	$t1_by_awal = $data_by_awal['debet'];
	$t2_by_awal = $data_by_awal['kredit'];
	$normal_by_awal = $data_by_awal['normal'];
	$q1_by_awal = mysql_query("select * from akun where id_akun = '$id_akun_by_awal' ");
	$d2_by_awal = mysql_fetch_assoc($q1_by_awal);

//cari saldo awal
$Tawal_by_awal =0;	$Totawal_by_awal =0; $T_by_awal = 0;
$qawal_by_awal = @mysql_query("select * from jurnal where tgl < '$all%' ");
$bawal_by_awal = @mysql_num_rows($qawal_by_awal);
if($bawal_by_awal>0)
{
	while($dawal_by_awal = @mysql_fetch_assoc($qawal_by_awal))
	{
		if($dawal_by_awal['akun1']== $id_akun_by_awal)
		{
		$tanggal_awal_by_awal = tgl_indo($dawal_by_awal['tgl']);
		$debet_awal_by_awal = ribuan($dawal_by_awal['debet1']); 	
		$kredit_awal_by_awal = ribuan($dawal_by_awal['kredit1']);
		$debet_awal9_by_awal = $dawal_by_awal['debet1']; 	
		$kredit_awal9_by_awal = $dawal_by_awal['kredit1'];
		
		//mencari nama akun//
		$qakun_awal_by_awal = @mysql_query("select * from akun where id_akun='$dawal_by_awal[akun1]' ");
		$dakun_awal_by_awal = @mysql_fetch_assoc($qakun_awal_by_awal);
		
		//mengatur operator
		if(($t1_by_awal == '+')and($t2_by_awal == '-'))
		{
		$awal_by_awal = ($Tawal_by_awal+$debet_awal9_by_awal)-$kredit_awal9_by_awal;
		}else
		if(($t1_by_awal == '-')and($t2_by_awal == '+'))
		{
		$awal_by_awal = ($Tawal_by_awal-$debet_awal9_by_awal)+$kredit_awal9_by_awal;
		}
		
		$Tawal_by_awal = $awal_by_awal;
		$Tawalribuan_by_awal = ribuan($Tawal_by_awal);
		
		}else
		if($dawal_by_awal['akun2']== $id_akun_by_awal)
		{
		$tanggal_awal_by_awal = tgl_indo($dawal_by_awal['tgl']);
		$debet_awal_by_awal = ribuan($dawal_by_awal['debet2']); 	
		$kredit_awal_by_awal = ribuan($dawal_by_awal['kredit2']);
		$debet_awal9_by_awal = $dawal_by_awal['debet2']; 	
		$kredit_awal9_by_awal = $dawal_by_awal['kredit2'];

		//mencari nama akun//
		$qakun_awal_by_awal = @mysql_query("select * from akun where id_akun='$dawal_by_awal[akun2]' ");
		$dakun_awal_by_awal = @mysql_fetch_assoc($qakun_awal_by_awal);

		if(($t1_by_awal == '+')and($t2_by_awal == '-'))
		{
		$awal_by_awal = ($Tawal_by_awal+$debet_awal9_by_awal)-$kredit_awal9_by_awal;
		}else
		if(($t1_by_awal == '-')and($t2_by_awal == '+'))
		{
		$awal_by_awal = ($Tawal_by_awal-$debet_awal9_by_awal)+$kredit_awal9_by_awal;
		}

		$Tawal_by_awal = $awal_by_awal;
		$Tawalribuan_by_awal = ribuan($Tawal_by_awal);

		}
	}
}
	$Tawal_by_awalr=ribuan($Tawal_by_awal);
	$TotalT_by_awal = $TotalT_by_awal+$Tawal_by_awal;
	$x_by_awal++;
}
$TotalT_biaya_awal = $TotalT_by_awal*(-1);

//===========================================RHPP SEBELUMNYA===========================================\\
$qrhpp_awal = mysql_query("select * from rhpp where panenbulan < '$all2' and panenbulan != '0000-00-00' order by id_produksi");
$brhpp_awal = mysql_num_rows($qrhpp_awal);
while($drhpp_awal=mysql_fetch_assoc($qrhpp_awal))
{
$qfarm_awal = mysql_query("select * from farm where id_farm='$drhpp_awal[id_farm]'");
$dfarm_awal = mysql_fetch_assoc($qfarm_awal);
$rl_awal = ribuan($drhpp_awal['thp_company']);

$total_rl_awal = $total_rl_awal+$drhpp_awal['thp_company'];
}
$total_rl2_awal=ribuan($total_rl_awal);

//===========================================PENDAPATAN LAIN" SEBELUMNYA===========================================\\
$Tawalpit_awal =0;	$Totawalpit_awal =0; $Tpit_awal = 0; $Tribuanpit_awal=0;
$querypit_awal = mysql_query("select * from rules_akun where id_akun like '420%' order by id_akun");
while($datapit_awal = mysql_fetch_assoc($querypit_awal))
{
	$id_akunpit_awal = $datapit_awal['id_akun'];
	$t1pit_awal = $datapit_awal['debet'];
	$t2pit_awal = $datapit_awal['kredit'];
	$normalpit_awal = $datapit_awal['normal'];
	$q1pit_awal = mysql_query("select * from akun where id_akun = '$id_akunpit_awal' ");
	$d2pit_awal = mysql_fetch_assoc($q1pit_awal);

$qpit_awal = @mysql_query("select * from jurnal where tgl < '$all%' order by tgl ");
$bpit_awal = @mysql_num_rows($qpit_awal);
if($bpit_awal>0)
{

	while($dpit_awal = @mysql_fetch_assoc($qpit_awal))
	{

		if($dpit_awal['akun1']==$id_akunpit_awal)
		{
		$tanggalpit_awal = tgl_indo($dpit_awal['tgl']);
		$debetpit_awal = ribuan($dpit_awal['debet1']); 	
		$kreditpit_awal = ribuan($dpit_awal['kredit1']);
		$debet9pit_awal = $dpit_awal['debet1']; 	
		$kredit9pit_awal = $dpit_awal['kredit1'];
		//mencari nama akun//
		$qakunpit_awal = @mysql_query("select * from akun where id_akun='$dpit_awal[akun1]' ");
		$dakunpit_awal = @mysql_fetch_assoc($qakunpit_awal);

		//mengatur operator
		if(($t1pit_awal == '+')and($t2pit_awal == '-'))
		{
		$kpit_awal = ($Tpit_awal)+$kredit9pit_awal;
		}else
		if(($t1pit_awal == '-')and($t2pit_awal == '+'))
		{
		$kpit_awal = ($Tpit_awal)+$kredit9pit_awal;
		}
		$Tpit_awal = $kpit_awal;
		$Tribuanpit_awal = ribuan($Tpit_awal);

		}else
		if($dpit_awal['akun2']==$id_akunpit_awal)
		{
		$tanggalpit_awal = tgl_indo($dpit_awal['tgl']);
		$debetpit_awal = ribuan($dpit_awal['debet2']); 	
		$kreditpit_awal = ribuan($dpit_awal['kredit2']);
		$debet9pit_awal = $dpit_awal['debet2']; 	
		$kredit9pit_awal = $dpit_awal['kredit2'];
		//mencari nama akun//
		$qakunpit_awal = @mysql_query("select * from akun where id_akun='$dpit_awal[akun2]' ");
		$dakunpit_awal = @mysql_fetch_assoc($qakunpit_awal);

		//mengatur operator
		if(($t1pit_awal == '+')and($t2pit_awal == '-'))
		{
		$kpit_awal = ($Tpit_awal)+$kredit9pit_awal;
		}else
		if(($t1pit_awal == '-')and($t2pit_awal == '+'))
		{
		$kpit_awal = ($Tpit_awal)+$kredit9pit_awal;
		}
		
		$Tpit_awal = $kpit_awal;
		$Tribuanpit_awal = ribuan($Tpit_awal);
		}
	}	
}

}

//===========================================BAGI HASIL SEBELUMNYA===========================================\\
$x_by_awalBH=1;
$query_by_awalBH = mysql_query("select * from rules_akun where id_akun='710.01' order by id_akun");
while($data_by_awalBH = mysql_fetch_assoc($query_by_awalBH))
{
	$id_akun_by_awalBH = $data_by_awalBH['id_akun'];
	$t1_by_awalBH = $data_by_awalBH['debet'];
	$t2_by_awalBH = $data_by_awalBH['kredit'];
	$normal_by_awalBH = $data_by_awalBH['normal'];
	$q1_by_awalBH = mysql_query("select * from akun where id_akun = '$id_akun_by_awalBH' ");
	$d2_by_awalBH = mysql_fetch_assoc($q1_by_awalBH);

//cari saldo awal
$Tawal_by_awalBH =0;	$Totawal_by_awalBH =0; $T_by_awalBH = 0;
$qawal_by_awalBH = @mysql_query("select * from jurnal where tgl < '$all%' ");
$bawal_by_awalBH = @mysql_num_rows($qawal_by_awalBH);
if($bawal_by_awalBH>0)
{
	while($dawal_by_awalBH = @mysql_fetch_assoc($qawal_by_awalBH))
	{
		if($dawal_by_awalBH['akun1']== $id_akun_by_awalBH)
		{
		$tanggal_awal_by_awalBH = tgl_indo($dawal_by_awalBH['tgl']);
		$debet_awal_by_awalBH = ribuan($dawal_by_awalBH['debet1']); 	
		$kredit_awal_by_awalBH = ribuan($dawal_by_awalBH['kredit1']);
		$debet_awal9_by_awalBH = $dawal_by_awalBH['debet1']; 	
		$kredit_awal9_by_awalBH = $dawal_by_awalBH['kredit1'];
		
		//mencari nama akun//
		$qakun_awal_by_awalBH = @mysql_query("select * from akun where id_akun='$dawal_by_awalBH[akun1]' ");
		$dakun_awal_by_awalBH = @mysql_fetch_assoc($qakun_awal_by_awalBH);
		
		//mengatur operator
		if(($t1_by_awalBH == '+')and($t2_by_awalBH == '-'))
		{
		$awal_by_awalBH = ($Tawal_by_awalBH+$debet_awal9_by_awalBH)-$kredit_awal9_by_awalBH;
		}else
		if(($t1_by_awalBH == '-')and($t2_by_awalBH == '+'))
		{
		$awal_by_awalBH = ($Tawal_by_awalBH-$debet_awal9_by_awalBH)+$kredit_awal9_by_awalBH;
		}
		
		$Tawal_by_awalBH = $awal_by_awalBH;
		$Tawalribuan_by_awalBH = ribuan($Tawal_by_awalBH);
		
		}else
		if($dawal_by_awalBH['akun2']== $id_akun_by_awalBH)
		{
		$tanggal_awal_by_awalBH = tgl_indo($dawal_by_awalBH['tgl']);
		$debet_awal_by_awalBH = ribuan($dawal_by_awalBH['debet2']); 	
		$kredit_awal_by_awalBH = ribuan($dawal_by_awalBH['kredit2']);
		$debet_awal9_by_awalBH = $dawal_by_awalBH['debet2']; 	
		$kredit_awal9_by_awalBH = $dawal_by_awalBH['kredit2'];

		//mencari nama akun//
		$qakun_awal_by_awalBH = @mysql_query("select * from akun where id_akun='$dawal_by_awalBH[akun2]' ");
		$dakun_awal_by_awalBH = @mysql_fetch_assoc($qakun_awal_by_awalBH);

		if(($t1_by_awalBH == '+')and($t2_by_awalBH == '-'))
		{
		$awal_by_awalBH = ($Tawal_by_awalBH+$debet_awal9_by_awalBH)-$kredit_awal9_by_awalBH;
		}else
		if(($t1_by_awalBH == '-')and($t2_by_awalBH == '+'))
		{
		$awal_by_awalBH = ($Tawal_by_awalBH-$debet_awal9_by_awalBH)+$kredit_awal9_by_awalBH;
		}

		$Tawal_by_awalBH = $awal_by_awalBH;
		$Tawalribuan_by_awalBH = ribuan($Tawal_by_awalBH);

		}
	}
}
	$Tawal_by_awalrBH=ribuan($Tawal_by_awalBH);
	$TotalT_by_awalBH = $TotalT_by_awalBH+$Tawal_by_awalBH;
	$x_by_awalBH++;
}
$TotalT_biaya_awalBH = $TotalT_by_awalBH*(-1);
//===========================================BAGI HASIL===========================================\\
$x_by_awalBH2=1;
$query_by_awalBH2 = mysql_query("select * from rules_akun where id_akun='710.01' order by id_akun");
while($data_by_awalBH2 = mysql_fetch_assoc($query_by_awalBH2))
{
	$id_akun_by_awalBH2 = $data_by_awalBH2['id_akun'];
	$t1_by_awalBH2 = $data_by_awalBH2['debet'];
	$t2_by_awalBH2 = $data_by_awalBH2['kredit'];
	$normal_by_awalBH2 = $data_by_awalBH2['normal'];
	$q1_by_awalBH2 = mysql_query("select * from akun where id_akun = '$id_akun_by_awalBH2' ");
	$d2_by_awalBH2 = mysql_fetch_assoc($q1_by_awalBH2);

//cari saldo awal
$Tawal_by_awalBH2 =0;	$Totawal_by_awalBH2 =0; $T_by_awalBH2 = 0;
$qawal_by_awalBH2 = @mysql_query("select * from jurnal where tgl like '$all%' ");
$bawal_by_awalBH2 = @mysql_num_rows($qawal_by_awalBH2);
if($bawal_by_awalBH2>0)
{
	while($dawal_by_awalBH2 = @mysql_fetch_assoc($qawal_by_awalBH2))
	{
		if($dawal_by_awalBH2['akun1']== $id_akun_by_awalBH2)
		{
		$tanggal_awal_by_awalBH2 = tgl_indo($dawal_by_awalBH2['tgl']);
		$debet_awal_by_awalBH2 = ribuan($dawal_by_awalBH2['debet1']); 	
		$kredit_awal_by_awalBH2 = ribuan($dawal_by_awalBH2['kredit1']);
		$debet_awal9_by_awalBH2 = $dawal_by_awalBH2['debet1']; 	
		$kredit_awal9_by_awalBH2 = $dawal_by_awalBH2['kredit1'];
		
		//mencari nama akun//
		$qakun_awal_by_awalBH2 = @mysql_query("select * from akun where id_akun='$dawal_by_awalBH2[akun1]' ");
		$dakun_awal_by_awalBH2 = @mysql_fetch_assoc($qakun_awal_by_awalBH2);
		
		//mengatur operator
		if(($t1_by_awalBH2 == '+')and($t2_by_awalBH2 == '-'))
		{
		$awal_by_awalBH2 = ($Tawal_by_awalBH2+$debet_awal9_by_awalBH2)-$kredit_awal9_by_awalBH2;
		}else
		if(($t1_by_awalBH2 == '-')and($t2_by_awalBH2 == '+'))
		{
		$awal_by_awalBH2 = ($Tawal_by_awalBH2-$debet_awal9_by_awalBH2)+$kredit_awal9_by_awalBH2;
		}
		
		$Tawal_by_awalBH2 = $awal_by_awalBH2;
		$Tawalribuan_by_awalBH2 = ribuan($Tawal_by_awalBH2);
		
		}else
		if($dawal_by_awalBH2['akun2']== $id_akun_by_awalBH2)
		{
		$tanggal_awal_by_awalBH2 = tgl_indo($dawal_by_awalBH2['tgl']);
		$debet_awal_by_awalBH2 = ribuan($dawal_by_awalBH2['debet2']); 	
		$kredit_awal_by_awalBH2 = ribuan($dawal_by_awalBH2['kredit2']);
		$debet_awal9_by_awalBH2 = $dawal_by_awalBH2['debet2']; 	
		$kredit_awal9_by_awalBH2 = $dawal_by_awalBH2['kredit2'];

		//mencari nama akun//
		$qakun_awal_by_awalBH2 = @mysql_query("select * from akun where id_akun='$dawal_by_awalBH2[akun2]' ");
		$dakun_awal_by_awalBH2 = @mysql_fetch_assoc($qakun_awal_by_awalBH2);

		if(($t1_by_awalBH2 == '+')and($t2_by_awalBH2 == '-'))
		{
		$awal_by_awalBH2 = ($Tawal_by_awalBH2+$debet_awal9_by_awalBH2)-$kredit_awal9_by_awalBH2;
		}else
		if(($t1_by_awalBH2 == '-')and($t2_by_awalBH2 == '+'))
		{
		$awal_by_awalBH2 = ($Tawal_by_awalBH2-$debet_awal9_by_awalBH2)+$kredit_awal9_by_awalBH2;
		}

		$Tawal_by_awalBH2 = $awal_by_awalBH2;
		$Tawalribuan_by_awalBH2 = ribuan($Tawal_by_awalBH2);

		}
	}
}
	$Tawal_by_awalrBH2=ribuan($Tawal_by_awalBH2);
	$TotalT_by_awalBH2 = $TotalT_by_awalBH2+$Tawal_by_awalBH2;
	$x_by_awalBH2++;
}
$TotalT_biaya_awalBH2 = $TotalT_by_awalBH2*(-1);

//===========================================RL SEBELUMNYA===========================================\\
$q_rl_berjalan = mysql_query("select * from rugi_laba_berjalan");
$d_rl_berjalan = mysql_fetch_assoc($q_rl_berjalan);
$saldo_rl_berjalan = $d_rl_berjalan['nilai'];

$total_rl_bulan_ini_awal = $Tpit_awal+$total_rl_awal+$TotalT_biaya_awal+$saldo_rl_berjalan+$TotalT_biaya_awalBH+$TotalT_biaya_awalBH2;
$total_rl_bulan_ini2_awal=ribuan($total_rl_bulan_ini_awal);
?>
<?
//===========================================BIAYA BIAYA SEKARANG===========================================\\
$x_by=1;
$query_by = mysql_query("select * from rules_akun where id_akun like '5%' and id_akun != '580.04' order by id_akun");
while($data_by = mysql_fetch_assoc($query_by))
{
	$id_akun_by = $data_by['id_akun'];
	$t1_by = $data_by['debet'];
	$t2_by = $data_by['kredit'];
	$normal_by = $data_by['normal'];
	$q1_by = mysql_query("select * from akun where id_akun = '$id_akun_by' ");
	$d2_by = mysql_fetch_assoc($q1_by);

//cari saldo awal
$Tawal_by =0;	$Totawal_by =0; $T_by = 0;
$qawal_by = @mysql_query("select * from jurnal where tgl like '$all%' ");
$bawal_by = @mysql_num_rows($qawal_by);
if($bawal_by>0)
{
	while($dawal_by = @mysql_fetch_assoc($qawal_by))
	{
		if($dawal_by['akun1']== $id_akun_by)
		{
		$tanggal_awal_by = tgl_indo($dawal_by['tgl']);
		$debet_awal_by = ribuan($dawal_by['debet1']); 	
		$kredit_awal_by = ribuan($dawal_by['kredit1']);
		$debet_awal9_by = $dawal_by['debet1']; 	
		$kredit_awal9_by = $dawal_by['kredit1'];
		
		//mencari nama akun//
		$qakun_awal_by = @mysql_query("select * from akun where id_akun='$dawal_by[akun1]' ");
		$dakun_awal_by = @mysql_fetch_assoc($qakun_awal_by);
		
		//mengatur operator
		if(($t1_by == '+')and($t2_by == '-'))
		{
		$awal_by = ($Tawal_by+$debet_awal9_by)-$kredit_awal9_by;
		}else
		if(($t1_by == '-')and($t2_by == '+'))
		{
		$awal_by = ($Tawal_by-$debet_awal9_by)+$kredit_awal9_by;
		}
		
		$Tawal_by = $awal_by;
		$Tawalribuan_by = ribuan($Tawal_by);
		
		}else
		if($dawal_by['akun2']== $id_akun_by)
		{
		$tanggal_awal_by = tgl_indo($dawal_by['tgl']);
		$debet_awal_by = ribuan($dawal_by['debet2']); 	
		$kredit_awal_by = ribuan($dawal_by['kredit2']);
		$debet_awal9_by = $dawal_by['debet2']; 	
		$kredit_awal9_by = $dawal_by['kredit2'];

		//mencari nama akun//
		$qakun_awal_by = @mysql_query("select * from akun where id_akun='$dawal_by[akun2]' ");
		$dakun_awal_by = @mysql_fetch_assoc($qakun_awal_by);

		if(($t1_by == '+')and($t2_by == '-'))
		{
		$awal_by = ($Tawal_by+$debet_awal9_by)-$kredit_awal9_by;
		}else
		if(($t1_by == '-')and($t2_by == '+'))
		{
		$awal_by = ($Tawal_by-$debet_awal9_by)+$kredit_awal9_by;
		}

		$Tawal_by = $awal_by;
		$Tawalribuan_by = ribuan($Tawal_by);

		}
	}
}
	$Tawal_byr=ribuan($Tawal_by);
	$TotalT_by = $TotalT_by+$Tawal_by;
	$x_by++;
}
$TotalT_biaya = $TotalT_by*(-1);

//===========================================RHPP SEKARANG===========================================\\
$qrhpp = mysql_query("select * from rhpp where panenbulan='$all2' order by id_produksi");
$brhpp = mysql_num_rows($qrhpp);
while($drhpp=mysql_fetch_assoc($qrhpp))
{
$qfarm = mysql_query("select * from farm where id_farm='$drhpp[id_farm]'");
$dfarm = mysql_fetch_assoc($qfarm);
$rl = ribuan($drhpp['thp_company']);

$total_rl = $total_rl+$drhpp['thp_company'];
}
$total_rl2=ribuan($total_rl);

//===========================================PENDAPATAN LAIN" SEKARANG===========================================\\
$Tawalpit =0;	$Totawalpit =0; $Tpit = 0; $Tribuanpit=0;
$querypit = mysql_query("select * from rules_akun where id_akun like '420%' order by id_akun");
while($datapit = mysql_fetch_assoc($querypit))
{
	$id_akunpit = $datapit['id_akun']; 
	$t1pit = $datapit['debet'];
	$t2pit = $datapit['kredit'];
	$normalpit = $datapit['normal'];
	$q1pit = mysql_query("select * from akun where id_akun = '$id_akunpit' ");
	$d2pit = mysql_fetch_assoc($q1pit);

$qpit = @mysql_query("select * from jurnal where tgl like '$all%' order by tgl ");
$bpit = @mysql_num_rows($qpit);
if($bpit>0)
{

	while($dpit = @mysql_fetch_assoc($qpit))
	{

		if($dpit['akun1']==$id_akunpit)
		{
		$tanggalpit = tgl_indo($dpit['tgl']);
		$debetpit = ribuan($dpit['debet1']); 	
		$kreditpit = ribuan($dpit['kredit1']);
		$debet9pit = $dpit['debet1']; 	
		$kredit9pit = $dpit['kredit1'];
		//mencari nama akun//
		$qakunpit = @mysql_query("select * from akun where id_akun='$dpit[akun1]' ");
		$dakunpit = @mysql_fetch_assoc($qakunpit);

		//mengatur operator
		if(($t1pit == '+')and($t2pit == '-'))
		{
		$kpit = ($Tpit)+$kredit9pit;
		}else
		if(($t1pit == '-')and($t2pit == '+'))
		{
		$kpit = ($Tpit)+$kredit9pit;
		}
		$Tpit = $kpit;
		$Tribuanpit = ribuan($Tpit);

		}else
		if($dpit['akun2']==$id_akunpit)
		{
		$tanggalpit = tgl_indo($dpit['tgl']);
		$debetpit = ribuan($dpit['debet2']); 	
		$kreditpit = ribuan($dpit['kredit2']);
		$debet9pit = $dpit['debet2']; 	
		$kredit9pit = $dpit['kredit2'];
		//mencari nama akun//
		$qakunpit = @mysql_query("select * from akun where id_akun='$dpit[akun2]' ");
		$dakunpit = @mysql_fetch_assoc($qakunpit);

		//mengatur operator
		if(($t1pit == '+')and($t2pit == '-'))
		{
		$kpit = ($Tpit)+$kredit9pit;
		}else
		if(($t1pit == '-')and($t2pit == '+'))
		{
		$kpit = ($Tpit)+$kredit9pit;
		}
		
		$Tpit = $kpit;
		$Tribuanpit = ribuan($Tpit);
		}
	}	
}

}
$total_rl_bulan_ini = $Tpit+$total_rl+$TotalT_biaya;
$total_rl_bulan_ini2=ribuan($total_rl_bulan_ini);
$total_rl_semuanya=$total_rl_bulan_ini+$total_rl_bulan_ini_awal;
$total_rl_semuanya2=ribuan($total_rl_semuanya);
?>
<?
//===========================================SEWA DIBAYAR DIMUKA===========================================\\
$x_4=1;
$query_4 = mysql_query("select * from rules_akun where id_akun like '113%' order by id_akun");
while($data_4 = mysql_fetch_assoc($query_4))
{
	$id_akun_4 = $data_4['id_akun'];
	$t1_4 = $data_4['debet'];
	$t2_4 = $data_4['kredit'];
	$normal_4 = $data_4['normal'];
	$q1_4 = mysql_query("select * from akun where id_akun = '$id_akun_4' ");
	$d2_4 = mysql_fetch_assoc($q1_4);
//cari saldo awal
$Tawal_4 =0;	$Totawal_4 =0; $T_4 = 0;
$qawal_4 = @mysql_query("select * from jurnal where tgl < '$all' ");
$bawal_4 = @mysql_num_rows($qawal_4);
if($bawal_4>0)
{
	while($dawal_4 = @mysql_fetch_assoc($qawal_4))
	{
		if($dawal_4['akun1']== $id_akun_4)
		{
		$tanggal_awal_4 = tgl_indo($dawal_4['tgl']);
		$debet_awal_4 = ribuan($dawal_4['debet1']); 	
		$kredit_awal_4 = ribuan($dawal_4['kredit1']);
		$debet_awal9_4 = $dawal_4['debet1']; 	
		$kredit_awal9_4 = $dawal_4['kredit1'];
		
		//mencari nama akun//
		$qakun_awal_4 = @mysql_query("select * from akun where id_akun='$dawal_4[akun1]' ");
		$dakun_awal_4 = @mysql_fetch_assoc($qakun_awal_4);
		
		//mengatur operator
		if(($t1_4 == '+')and($t2_4 == '-'))
		{
		$awal_4 = ($Tawal_4+$debet_awal9_4)-$kredit_awal9_4;
		}else
		if(($t1_4 == '-')and($t2_4 == '+'))
		{
		$awal_4 = ($Tawal_4-$debet_awal9_4)+$kredit_awal9_4;
		}
		
		$Tawal_4 = $awal_4;
		$Tawalribuan_4 = ribuan($Tawal_4);
		
		}else
		if($dawal_4['akun2']== $id_akun_4)
		{
		$tanggal_awal_4 = tgl_indo($dawal_4['tgl']);
		$debet_awal_4 = ribuan($dawal_4['debet2']); 	
		$kredit_awal_4 = ribuan($dawal_4['kredit2']);
		$debet_awal9_4 = $dawal_4['debet2']; 	
		$kredit_awal9_4 = $dawal_4['kredit2'];

		//mencari nama akun//
		$qakun_awal_4 = @mysql_query("select * from akun where id_akun='$dawal_4[akun2]' ");
		$dakun_awal_4 = @mysql_fetch_assoc($qakun_awal_4);

		if(($t1_4 == '+')and($t2_4 == '-'))
		{
		$awal_4 = ($Tawal_4+$debet_awal9_4)-$kredit_awal9_4;
		}else
		if(($t1_4 == '-')and($t2_4 == '+'))
		{
		$awal_4 = ($Tawal_4-$debet_awal9_4)+$kredit_awal9_4;
		}

		$Tawal_4 = $awal_4;
		$Tawalribuan_4 = ribuan($Tawal_4);

		}
	}
}
if($Tawal_4 != '')
{
$T_4 = $Tawal_4;
$Tribuan_4= ribuan($T_4);
}else
{
$T_4 = 0;
$Tribuan_4= ribuan($T_4);
}

$q_4 = @mysql_query("select * from jurnal where tgl like '%$all%' order by tgl ");
$b_4 = @mysql_num_rows($q_4);
	while($d_4 = @mysql_fetch_assoc($q_4))
	{

		if($d_4['akun1']==$id_akun_4)
		{
		$tanggal_4 = tgl_indo($d_4['tgl']);
		$debet_4 = ribuan($d_4['debet1']); 	
		$kredit_4 = ribuan($d_4['kredit1']);
		$debet9_4 = $d_4['debet1']; 	
		$kredit9_4 = $d_4['kredit1'];

		//mencari nama akun//
		$qakun_4 = @mysql_query("select * from akun where id_akun='$d_4[akun1]' ");
		$dakun_4 = @mysql_fetch_assoc($qakun_4);

		//mengatur operator
		if(($t1_4 == '+')and($t2_4 == '-'))
		{
		$k_4 = ($T_4+$debet9_4)-$kredit9_4;
		}else
		if(($t1_4 == '-')and($t2_4 == '+'))
		{
		$k_4 = ($T_4-$debet9_4)+$kredit9_4;
		}
		$T_4 = $k_4;
		$Tribuan_4 = ribuan($T_4);

		}else
		if($d_4['akun2']==$id_akun_4)
		{
		$tanggal_4 = tgl_indo($d_4['tgl']);
		$debet_4 = ribuan($d_4['debet2']); 	
		$kredit_4 = ribuan($d_4['kredit2']);
		$debet9_4 = $d_4['debet2']; 	
		$kredit9_4 = $d_4['kredit2'];

		//mencari nama akun//
		$qakun_4 = @mysql_query("select * from akun where id_akun='$d_4[akun2]' ");
		$dakun_4 = @mysql_fetch_assoc($qakun_4);

		//mengatur operator
		if(($t1_4 == '+')and($t2_4 == '-'))
		{
		$k_4 = ($T_4+$debet9_4)-$kredit9_4;
		}else
		if(($t1_4 == '-')and($t2_4 == '+'))
		{
		$k_4 = ($T_4-$debet9_4)+$kredit9_4;
		}
		$T_4 = $k_4;
		$Tribuan_4 = ribuan($T_4);
		}
	}
	$TotalT_4 = $TotalT_4+$T_4;
	if($normal_4=='DEBET')
	{
	}else
	{
	}

	$x_4++;
}
$TotalT2_4=ribuan($TotalT_4);
?>
<?
//===========================================PERSEDIAAN GD.KANTOR===========================================\\
/* DOC */
$qgudang_doc = mysql_query("select * from barang where id_barang like 'D-%' order by id_barang");
while($dgudang_doc = mysql_fetch_assoc($qgudang_doc))
{
	//Tanggal sebelumnya//
	$hrgbeligudang_doc = $dgudang_doc['hrg_beli'];
	
	$subbeli_doc_awal=0;$qtybeli_doc_awal=0;
	$qbeli_doc_awal = mysql_query("select * from beli where id_barang='$dgudang_doc[id_barang]' and tanggal < '$all%' ");
	while($dbeli_doc_awal=mysql_fetch_assoc($qbeli_doc_awal))
	{
		$qtybeli_doc_awal = $qtybeli_doc_awal+$dbeli_doc_awal['qty'];
	}
	$qtyreturjual_doc_awal=0;
	$qreturjual_doc_awal = mysql_query("select * from retur_jual where id_barang='$dgudang_doc[id_barang]' and tgl_rsap < '$all%' ");
	while($dreturjual_doc_awal=mysql_fetch_assoc($qreturjual_doc_awal))
	{
		$qtyreturjual_doc_awal = $qtyreturjual_doc_awal+$dreturjual_doc_awal['qty'];
	}
	$qtyreturbeli_doc_awal=0;
	$qreturbeli_doc_awal = mysql_query("select * from retur_beli where id_barang='$dgudang_doc[id_barang]' and tgl_rsup < '$all%'");
	while($dreturbeli_doc_awal=mysql_fetch_assoc($qreturbeli_doc_awal))
	{
		$qtyreturbeli_doc_awal = $qtyreturbeli_doc_awal+$dreturbeli_doc_awal['qty'];
	}
	$qtyjual_doc_awal=0;
	$qjual_doc_awal = mysql_query("select * from jual where id_barang='$dgudang_doc[id_barang]' and tanggal < '$all%'");
	while($djual_doc_awal=mysql_fetch_assoc($qjual_doc_awal))
	{
		$qtyjual_doc_awal = $qtyjual_doc_awal+$djual_doc_awal['qty'];
	}
	$qtyjualcabang_doc_awal=0;
	$qjualcabang_doc_awal = mysql_query("select * from jual_cabang where id_barang='$dgudang_doc[id_barang]' and tgl_nota < '$all%' ");
	while($djualcabang_doc_awal=mysql_fetch_assoc($qjualcabang_doc_awal))
	{
		$qtyjualcabang_doc_awal = $qtyjualcabang_doc_awal+$djualcabang_doc_awal['qty'];
	}
	$qtyjualtunai_doc_awal=0;
	$qjualtunai_doc_awal = mysql_query("select * from jual_tunai where id_barang='$dgudang_doc[id_barang]' and tgl_nota < '$all%' ");
	while($djualtunai_doc_awal=mysql_fetch_assoc($qjualtunai_doc_awal))
	{
		$qtyjualtunai_doc_awal = $qtyjualtunai_doc_awal+$djualtunai_doc_awal['qty'];
	}
	$qtyutang_peralatan_doc_awal=0;
	$qutang_peralatan_doc_awal = mysql_query("select * from utang_peralatan where id_barang='$dgudang_doc[id_barang]' and tgl_bon < '$all%'");
	while($dutang_peralatan_doc_awal=mysql_fetch_assoc($qutang_peralatan_doc_awal))
	{
		$qtyutang_peralatan_doc_awal = $qtyutang_peralatan_doc_awal+$dutang_peralatan_doc_awal['qty'];
	}
	$plus=0;$min=0;
	$qpeny = mysql_query("select * from peny_barang where id_barang='$dgudang_doc[id_barang]' and tanggal < '$all%'");
	while($dpeny=mysql_fetch_assoc($qpeny))
	{
		$plus = $plus+$dpeny['qty_plus'];
		$min = $min+$dpeny['qty_min'];
	}
	$total_peny_brg = $plus-$min;

	$Totqty_awal = $dgudang_doc['stok_awal']+($qtyreturjual_doc_awal+$qtybeli_doc_awal)-($qtyutang_peralatan_doc_awal+$qtyjualtunai_doc_awal+$qtyjualcabang_doc_awal+$qtyjual_doc_awal+$qtyreturbeli_doc_awal)+$total_peny_brg;
	$subbeli_doc_awal = $hrgbeligudang_doc*$Totqty_awal;
	$Totbeli_doc_awal = $Totbeli_doc_awal+$subbeli_doc_awal;
	//Tanggal Sekarang//
	$subbeli_doc=0;$qtybeli_doc=0;
	$qbeli_doc = mysql_query("select * from beli where id_barang='$dgudang_doc[id_barang]' and tanggal like '$all%' ");
	while($dbeli_doc=mysql_fetch_assoc($qbeli_doc))
	{
		$qtybeli_doc = $qtybeli_doc+$dbeli_doc['qty'];
	}
	$qtyreturjual_doc=0;
	$qreturjual_doc = mysql_query("select * from retur_jual where id_barang='$dgudang_doc[id_barang]' and tgl_rsap like '$all%' ");
	while($dreturjual_doc=mysql_fetch_assoc($qreturjual_doc))
	{
		$qtyreturjual_doc = $qtyreturjual_doc+$dreturjual_doc['qty'];
	}
	$qtyreturbeli_doc=0;
	$qreturbeli_doc = mysql_query("select * from retur_beli where id_barang='$dgudang_doc[id_barang]' and tgl_rsup like '$all%'");
	while($dreturbeli_doc=mysql_fetch_assoc($qreturbeli_doc))
	{
		$qtyreturbeli_doc = $qtyreturbeli_doc+$dreturbeli_doc['qty'];
	}
	$qtyjual_doc=0;
	$qjual_doc = mysql_query("select * from jual where id_barang='$dgudang_doc[id_barang]' and tanggal like '$all%'");
	while($djual_doc=mysql_fetch_assoc($qjual_doc))
	{
		$qtyjual_doc = $qtyjual_doc+$djual_doc['qty'];
	}
	$qtyjualcabang_doc=0;
	$qjualcabang_doc = mysql_query("select * from jual_cabang where id_barang='$dgudang_doc[id_barang]' and tgl_nota like '$all%' ");
	while($djualcabang_doc=mysql_fetch_assoc($qjualcabang_doc))
	{
		$qtyjualcabang_doc = $qtyjualcabang_doc+$djualcabang_doc['qty'];
	}
	$qtyjualtunai_doc=0;
	$qjualtunai_doc = mysql_query("select * from jual_tunai where id_barang='$dgudang_doc[id_barang]' and tgl_nota like '$all%' ");
	while($djualtunai_doc=mysql_fetch_assoc($qjualtunai_doc))
	{
		$qtyjualtunai_doc = $qtyjualtunai_doc+$djualtunai_doc['qty'];
	}
	$qtyutang_peralatan_doc=0;
	$qutang_peralatan_doc = mysql_query("select * from utang_peralatan where id_barang='$dgudang_doc[id_barang]' and tgl_bon like '$all%'");
	while($dutang_peralatan_doc=mysql_fetch_assoc($qutang_peralatan_doc))
	{
		$qtyutang_peralatan_doc = $qtyutang_peralatan_doc+$dutang_peralatan_doc['qty'];
	}
	$plus_now=0;$min_now=0;
	$qpeny_now = mysql_query("select * from peny_barang where id_barang='$dgudang_doc[id_barang]' and tanggal like '$all%'");
	while($dpeny_now=mysql_fetch_assoc($qpeny_now))
	{
		$plus_now = $plus_now+$dpeny_now['qty_plus'];
		$min_now = $min_now+$dpeny_now['qty_min'];
	}
	$total_peny_brg_now = $plus_now-$min_now;

	$Totqty = ($qtyreturjual_doc+$qtybeli_doc)-($qtyutang_peralatan_doc+$qtyjualtunai_doc+$qtyjualcabang_doc+$qtyjual_doc+$qtyreturbeli_doc)+$total_peny_brg_now;
	$subbeli_doc = ($hrgbeligudang_doc*$Totqty);
	$Totbeli_doc = $Totbeli_doc+$subbeli_doc;
}
$Totbeli_doc3=$Totbeli_doc+$Totbeli_doc_awal;
$Totbeli_doc2=ribuan($Totbeli_doc3);

/* PAKAN */
$qgudang_pkn = mysql_query("select * from barang where id_barang like 'F-%' order by id_barang");
while($dgudang_pkn = mysql_fetch_assoc($qgudang_pkn))
{
	$hrgbeligudang_pkn = $dgudang_pkn['hrg_beli'];
	
	//tanggal sebelumnya//
	$subbeli_pkn_awal=0;$qtybeli_pkn_awal=0;
	$qbeli_pkn_awal = mysql_query("select * from beli where id_barang='$dgudang_pkn[id_barang]' and tanggal < '$all%' ");
	while($dbeli_pkn_awal=mysql_fetch_assoc($qbeli_pkn_awal))
	{
		$qtybeli_pkn_awal = $qtybeli_pkn_awal+$dbeli_pkn_awal['qty'];
	}
	$qtyreturjual_pkn_awal=0;
	$qreturjual_pkn_awal = mysql_query("select * from retur_jual where id_barang='$dgudang_pkn[id_barang]' and tgl_rsap < '$all%'");
	while($dreturjual_pkn_awal=mysql_fetch_assoc($qreturjual_pkn_awal))
	{
		$qtyreturjual_pkn_awal = $qtyreturjual_pkn_awal+$dreturjual_pkn_awal['qty'];
	}
	$qtyreturbeli_pkn_awal=0;
	$qreturbeli_pkn_awal = mysql_query("select * from retur_beli where id_barang='$dgudang_pkn[id_barang]' and tgl_rsup < '$all%'");
	while($dreturbeli_pkn_awal=mysql_fetch_assoc($qreturbeli_pkn_awal))
	{
		$qtyreturbeli_pkn_awal = $qtyreturbeli_pkn_awal+$dreturbeli_pkn_awal['qty'];
	}
	$qtyjual_pkn_awal=0;
	$qjual_pkn_awal = mysql_query("select * from jual where id_barang='$dgudang_pkn[id_barang]' and tanggal < '$all%'");
	while($djual_pkn_awal=mysql_fetch_assoc($qjual_pkn_awal))
	{
		$qtyjual_pkn_awal = $qtyjual_pkn_awal+$djual_pkn_awal['qty'];
	}
	$qtyjualcabang_pkn_awal=0;
	$qjualcabang_pkn_awal = mysql_query("select * from jual_cabang where id_barang='$dgudang_pkn[id_barang]' and tgl_nota < '$all%'");
	while($djualcabang_pkn_awal=mysql_fetch_assoc($qjualcabang_pkn_awal))
	{
		$qtyjualcabang_pkn_awal = $qtyjualcabang_pkn_awal+$djualcabang_pkn_awal['qty'];
	}
	$qtyjualtunai_pkn_awal=0;
	$qjualtunai_pkn_awal = mysql_query("select * from jual_tunai where id_barang='$dgudang_pkn[id_barang]' and tgl_nota < '$all%'");
	while($djualtunai_pkn_awal=mysql_fetch_assoc($qjualtunai_pkn_awal))
	{
		$qtyjualtunai_pkn_awal = $qtyjualtunai_pkn_awal+$djualtunai_pkn_awal['qty'];
	}
	$qtyutang_peralatan_pkn_awal=0;
	$qutang_peralatan_pkn_awal = mysql_query("select * from utang_peralatan where id_barang='$dgudang_pkn[id_barang]' and tgl_bon < '$all%'");
	while($dutang_peralatan_pkn_awal=mysql_fetch_assoc($qutang_peralatan_pkn_awal))
	{
		$qtyutang_peralatan_pkn_awal = $qtyutang_peralatan_pkn_awal+$dutang_peralatan_pkn_awal['qty'];
	}
	$plus_pkn=0;$min_pkn=0;
	$qpeny_pkn = mysql_query("select * from peny_barang where id_barang='$dgudang_pkn[id_barang]' and tanggal < '$all%'");
	while($dpeny_pkn=mysql_fetch_assoc($qpeny_pkn))
	{
		$plus_pkn = $plus_pkn+$dpeny_pkn['qty_plus'];
		$min_pkn = $min_pkn+$dpeny_pkn['qty_min'];
	}
	$total_peny_brg_pkn = $plus_pkn-$min_pkn;

	$Totqtypkn_awal = $dgudang_pkn['stok_awal']+($qtyreturjual_pkn_awal+$qtybeli_pkn_awal)-($qtyutang_peralatan_pkn_awal+$qtyjualtunai_pkn_awal+$qtyjualcabang_pkn_awal+$qtyjual_pkn_awal+$qtyreturbeli_pkn_awal)+$total_peny_brg_pkn;
	$subbeli_pkn_awal = $hrgbeligudang_pkn*$Totqtypkn_awal;
	$Totbeli_pkn_awal = $Totbeli_pkn_awal+$subbeli_pkn_awal;
	//tanggal sekarang//
	$subbeli_pkn=0;$qtybeli_pkn=0;
	$qbeli_pkn = mysql_query("select * from beli where id_barang='$dgudang_pkn[id_barang]' and tanggal like '$all%'");
	while($dbeli_pkn=mysql_fetch_assoc($qbeli_pkn))
	{
		$qtybeli_pkn = $qtybeli_pkn+$dbeli_pkn['qty'];
	}
	$qtyreturjual_pkn=0;
	$qreturjual_pkn = mysql_query("select * from retur_jual where id_barang='$dgudang_pkn[id_barang]' and tgl_rsap like '$all%'");
	while($dreturjual_pkn=mysql_fetch_assoc($qreturjual_pkn))
	{
		$qtyreturjual_pkn = $qtyreturjual_pkn+$dreturjual_pkn['qty'];
	}
	$qtyreturbeli_pkn=0;
	$qreturbeli_pkn = mysql_query("select * from retur_beli where id_barang='$dgudang_pkn[id_barang]' and tgl_rsup like '$all%'");
	while($dreturbeli_pkn=mysql_fetch_assoc($qreturbeli_pkn))
	{
		$qtyreturbeli_pkn = $qtyreturbeli_pkn+$dreturbeli_pkn['qty'];
	}
	$qtyjual_pkn=0;
	$qjual_pkn = mysql_query("select * from jual where id_barang='$dgudang_pkn[id_barang]' and tanggal like '$all%'");
	while($djual_pkn=mysql_fetch_assoc($qjual_pkn))
	{
		$qtyjual_pkn = $qtyjual_pkn+$djual_pkn['qty'];
	}
	$qtyjualcabang_pkn=0;
	$qjualcabang_pkn = mysql_query("select * from jual_cabang where id_barang='$dgudang_pkn[id_barang]' and tgl_nota like '$all%'");
	while($djualcabang_pkn=mysql_fetch_assoc($qjualcabang_pkn))
	{
		$qtyjualcabang_pkn = $qtyjualcabang_pkn+$djualcabang_pkn['qty'];
	}
	$qtyjualtunai_pkn=0;
	$qjualtunai_pkn = mysql_query("select * from jual_tunai where id_barang='$dgudang_pkn[id_barang]' and tgl_nota like '$all%'");
	while($djualtunai_pkn=mysql_fetch_assoc($qjualtunai_pkn))
	{
		$qtyjualtunai_pkn = $qtyjualtunai_pkn+$djualtunai_pkn['qty'];
	}
	$qtyutang_peralatan_pkn=0;
	$qutang_peralatan_pkn = mysql_query("select * from utang_peralatan where id_barang='$dgudang_pkn[id_barang]' and tgl_bon like '$all%'");
	while($dutang_peralatan_pkn=mysql_fetch_assoc($qutang_peralatan_pkn))
	{
		$qtyutang_peralatan_pkn = $qtyutang_peralatan_pkn+$dutang_peralatan_pkn['qty'];
	}
	$plus_pkn_now=0;$min_pkn_now=0;
	$qpeny_pkn_now = mysql_query("select * from peny_barang where id_barang='$dgudang_pkn[id_barang]' and tanggal like '$all%'");
	while($dpeny_pkn_now=mysql_fetch_assoc($qpeny_pkn_now))
	{
		$plus_pkn_now = $plus_pkn_now+$dpeny_pkn_now['qty_plus'];
		$min_pkn_now = $min_pkn_now+$dpeny_pkn_now['qty_min'];
	}
	$total_peny_brg_pkn_now = $plus_pkn_now-$min_pkn_now;

	$Totqtypkn = ($qtyreturjual_pkn+$qtybeli_pkn)-($qtyutang_peralatan_pkn+$qtyjualtunai_pkn+$qtyjualcabang_pkn+$qtyjual_pkn+$qtyreturbeli_pkn)+$total_peny_brg_pkn_now;
	$subbeli_pkn = ($hrgbeligudang_pkn*$Totqtypkn);
	$Totbeli_pkn = $Totbeli_pkn+$subbeli_pkn;
}
$Totbeli_pkn3=$Totbeli_pkn+$Totbeli_pkn_awal;
$Totbeli_pkn2=ribuan($Totbeli_pkn3);

/* OVK */
$qgudang_ovk = mysql_query("select * from barang where id_barang like 'M-%' order by id_barang");
while($dgudang_ovk = mysql_fetch_assoc($qgudang_ovk))
{
	$hrgbeligudang_ovk = $dgudang_ovk['hrg_beli'];
	//tanggal sebelumnya//
	$subbeli_ovk_awal=0;$qtybeli_ovk_awal=0;
	$qbeli_ovk_awal = mysql_query("select * from beli where id_barang='$dgudang_ovk[id_barang]' and tanggal < '$all%'");
	while($dbeli_ovk_awal=mysql_fetch_assoc($qbeli_ovk_awal))
	{
		$qtybeli_ovk_awal = $qtybeli_ovk_awal+$dbeli_ovk_awal['qty'];
	}
	$qtyreturjual_ovk_awal=0;
	$qreturjual_ovk_awal = mysql_query("select * from retur_jual where id_barang='$dgudang_ovk[id_barang]' and tgl_rsap < '$all%'");
	while($dreturjual_ovk_awal=mysql_fetch_assoc($qreturjual_ovk_awal))
	{
		$qtyreturjual_ovk_awal = $qtyreturjual_ovk_awal+$dreturjual_ovk_awal['qty'];
	}
	$qtyreturbeli_ovk_awal=0;
	$qreturbeli_ovk_awal = mysql_query("select * from retur_beli where id_barang='$dgudang_ovk[id_barang]' and tgl_rsup < '$all%'");
	while($dreturbeli_ovk_awal=mysql_fetch_assoc($qreturbeli_ovk_awal))
	{
		$qtyreturbeli_ovk_awal = $qtyreturbeli_ovk+$dreturbeli_ovk_awal['qty'];
	}
	$qtyjual_ovk_awal=0;
	$qjual_ovk_awal = mysql_query("select * from jual where id_barang='$dgudang_ovk[id_barang]' and tanggal < '$all%'");
	while($djual_ovk_awal=mysql_fetch_assoc($qjual_ovk_awal))
	{
		$qtyjual_ovk_awal = $qtyjual_ovk_awal+$djual_ovk_awal['qty'];
	}
	$qtyjualcabang_ovk_awal=0;
	$qjualcabang_ovk_awal = mysql_query("select * from jual_cabang where id_barang='$dgudang_ovk[id_barang]' and tgl_nota < '$all%'");
	while($djualcabang_ovk_awal=mysql_fetch_assoc($qjualcabang_ovk_awal))
	{
		$qtyjualcabang_ovk_awal = $qtyjualcabang_ovk_awal+$djualcabang_ovk_awal['qty'];
	}
	$qtyjualtunai_ovk_awal=0;
	$qjualtunai_ovk_awal = mysql_query("select * from jual_tunai where id_barang='$dgudang_ovk[id_barang]' and tgl_nota < '$all%'");
	while($djualtunai_ovk_awal=mysql_fetch_assoc($qjualtunai_ovk_awal))
	{
		$qtyjualtunai_ovk_awal = $qtyjualtunai_ovk_awal+$djualtunai_ovk_awal['qty'];
	}
	$qtyutang_peralatan_ovk_awal=0;
	$qutang_peralatan_ovk_awal = mysql_query("select * from utang_peralatan where id_barang='$dgudang_ovk[id_barang]' and tgl_bon < '$all%'");
	while($dutang_peralatan_ovk_awal=mysql_fetch_assoc($qutang_peralatan_ovk_awal))
	{
		$qtyutang_peralatan_ovk_awal = $qtyutang_peralatan_ovk_awal+$dutang_peralatan_ovk_awal['qty'];
	}
	$plus_ovk=0;$min_ovk=0;
	$qpeny_ovk = mysql_query("select * from peny_barang where id_barang='$dgudang_ovk[id_barang]' and tanggal < '$all%'");
	while($dpeny_ovk=mysql_fetch_assoc($qpeny_ovk))
	{
		$plus_ovk = $plus_ovk+$dpeny_ovk['qty_plus'];
		$min_ovk = $min_ovk+$dpeny_ovk['qty_min'];
	}
	$total_peny_brg_ovk = $plus_ovk-$min_ovk;

	$Totqtyovk_awal = $dgudang_ovk['stok_awal']+($qtyreturjual_ovk_awal+$qtybeli_ovk_awal)-($qtyutang_peralatan_ovk_awal+$qtyjualtunai_ovk_awal+$qtyjualcabang_ovk_awal+$qtyjual_ovk_awal+$qtyreturbeli_ovk_awal)+$total_peny_brg_ovk;
	$subbeli_ovk_awal = $hrgbeligudang_ovk*$Totqtyovk_awal;
	$Totbeli_ovk_awal = $Totbeli_ovk_awal+$subbeli_ovk_awal;
	//tanggal sekarang//
	$subbeli_ovk=0;$qtybeli_ovk=0;
	$qbeli_ovk = mysql_query("select * from beli where id_barang='$dgudang_ovk[id_barang]' and tanggal like '$all%'");
	while($dbeli_ovk=mysql_fetch_assoc($qbeli_ovk))
	{
		$qtybeli_ovk = $qtybeli_ovk+$dbeli_ovk['qty'];
	}
	$qtyreturjual_ovk=0;
	$qreturjual_ovk = mysql_query("select * from retur_jual where id_barang='$dgudang_ovk[id_barang]' and tgl_rsap like '$all%'");
	while($dreturjual_ovk=mysql_fetch_assoc($qreturjual_ovk))
	{
		$qtyreturjual_ovk = $qtyreturjual_ovk+$dreturjual_ovk['qty'];
	}
	$qtyreturbeli_ovk=0;
	$qreturbeli_ovk = mysql_query("select * from retur_beli where id_barang='$dgudang_ovk[id_barang]' and tgl_rsup like '$all%'");
	while($dreturbeli_ovk=mysql_fetch_assoc($qreturbeli_ovk))
	{
		$qtyreturbeli_ovk = $qtyreturbeli_ovk+$dreturbeli_ovk['qty'];
	}
	$qtyjual_ovk=0;
	$qjual_ovk = mysql_query("select * from jual where id_barang='$dgudang_ovk[id_barang]' and tanggal like '$all%'");
	while($djual_ovk=mysql_fetch_assoc($qjual_ovk))
	{
		$qtyjual_ovk = $qtyjual_ovk+$djual_ovk['qty'];
	}
	$qtyjualcabang_ovk=0;
	$qjualcabang_ovk = mysql_query("select * from jual_cabang where id_barang='$dgudang_ovk[id_barang]' and tgl_nota like '$all%'");
	while($djualcabang_ovk=mysql_fetch_assoc($qjualcabang_ovk))
	{
		$qtyjualcabang_ovk = $qtyjualcabang_ovk+$djualcabang_ovk['qty'];
	}
	$qtyjualtunai_ovk=0;
	$qjualtunai_ovk = mysql_query("select * from jual_tunai where id_barang='$dgudang_ovk[id_barang]' and tgl_nota like '$all%'");
	while($djualtunai_ovk=mysql_fetch_assoc($qjualtunai_ovk))
	{
		$qtyjualtunai_ovk = $qtyjualtunai_ovk+$djualtunai_ovk['qty'];
	}
	$qtyutang_peralatan_ovk=0;
	$qutang_peralatan_ovk = mysql_query("select * from utang_peralatan where id_barang='$dgudang_ovk[id_barang]' and tgl_bon like '$all%'");
	while($dutang_peralatan_ovk=mysql_fetch_assoc($qutang_peralatan_ovk))
	{
		$qtyutang_peralatan_ovk = $qtyutang_peralatan_ovk+$dutang_peralatan_ovk['qty'];
	}
	$plus_ovk_now=0;$min_ovk_now=0;
	$qpeny_ovk_now = mysql_query("select * from peny_barang where id_barang='$dgudang_ovk[id_barang]' and tanggal like '$all%'");
	while($dpeny_ovk_now=mysql_fetch_assoc($qpeny_ovk_now))
	{
		$plus_ovk_now = $plus_ovk_now+$dpeny_ovk_now['qty_plus'];
		$min_ovk_now = $min_ovk_now+$dpeny_ovk_now['qty_min'];
	}
	$total_peny_brg_ovk_now = $plus_ovk_now-$min_ovk_now;

	$Totqtyovk = ($qtyreturjual_ovk+$qtybeli_ovk)-($qtyutang_peralatan_ovk+$qtyjualtunai_ovk+$qtyjualcabang_ovk+$qtyjual_ovk+$qtyreturbeli_ovk)+$total_peny_brg_ovk_now;
	$subbeli_ovk = $hrgbeligudang_ovk*$Totqtyovk;
	$Totbeli_ovk = $Totbeli_ovk+$subbeli_ovk;
}
$Totbeli_ovk3=$Totbeli_ovk+$Totbeli_ovk_awal;
$Totbeli_ovk2=ribuan($Totbeli_ovk3);

/* EQUIPMENT */
$qgudang_eqp = mysql_query("select * from barang where id_barang like 'E-%' order by id_barang");
while($dgudang_eqp = mysql_fetch_assoc($qgudang_eqp))
{
	$hrgbeligudang_eqp = $dgudang_eqp['hrg_beli'];
	//tanggal sebelumnya//
	$subbeli_eqp_awal=0;$qtybeli_eqp_awal=0;
	$qbeli_eqp_awal = mysql_query("select * from beli where id_barang='$dgudang_eqp[id_barang]' and tanggal < '$all%'");
	while($dbeli_eqp_awal=mysql_fetch_assoc($qbeli_eqp_awal))
	{
		$qtybeli_eqp_awal = $qtybeli_eqp_awal+$dbeli_eqp_awal['qty'];
	}
	$qtyreturjual_eqp_awal=0;
	$qreturjual_eqp_awal = mysql_query("select * from retur_jual where id_barang='$dgudang_eqp[id_barang]' and tgl_rsap < '$all%'");
	while($dreturjual_eqp_awal=mysql_fetch_assoc($qreturjual_eqp_awal))
	{
		$qtyreturjual_eqp_awal = $qtyreturjual_eqp_awal+$dreturjual_eqp_awal['qty'];
	}
	$qtyreturbeli_eqp_awal=0;
	$qreturbeli_eqp_awal = mysql_query("select * from retur_beli where id_barang='$dgudang_eqp[id_barang]' and tgl_rsup < '$all%'");
	while($dreturbeli_eqp_awal=mysql_fetch_assoc($qreturbeli_eqp_awal))
	{
		$qtyreturbeli_eqp_awal = $qtyreturbeli_eqp_awal+$dreturbeli_eqp_awal['qty'];
	}
	$qtyjual_eqp_awal=0;
	$qjual_eqp_awal = mysql_query("select * from jual where id_barang='$dgudang_eqp[id_barang]' and tanggal < '$all%'");
	while($djual_eqp_awal=mysql_fetch_assoc($qjual_eqp_awal))
	{
		$qtyjual_eqp_awal = $qtyjual_eqp_awal+$djual_eqp_awal['qty'];
	}
	$qtyjualcabang_eqp_awal=0;
	$qjualcabang_eqp_awal = mysql_query("select * from jual_cabang where id_barang='$dgudang_eqp[id_barang]' and tgl_nota < '$all%'");
	while($djualcabang_eqp_awal=mysql_fetch_assoc($qjualcabang_eqp_awal))
	{
		$qtyjualcabang_eqp_awal = $qtyjualcabang_eqp_awal+$djualcabang_eqp_awal['qty'];
	}
	$qtyjualtunai_eqp_awal=0;
	$qjualtunai_eqp_awal = mysql_query("select * from jual_tunai where id_barang='$dgudang_eqp[id_barang]' and tgl_nota < '$all%'");
	while($djualtunai_eqp_awal=mysql_fetch_assoc($qjualtunai_eqp_awal))
	{
		$qtyjualtunai_eqp_awal = $qtyjualtunai_eqp_awal+$djualtunai_eqp_awal['qty'];
	}
	$qtyutang_peralatan_eqp_awal=0;
	$qutang_peralatan_eqp_awal = mysql_query("select * from utang_peralatan where id_barang='$dgudang_eqp[id_barang]' and tgl_bon < '$all%'");
	while($dutang_peralatan_eqp_awal=mysql_fetch_assoc($qutang_peralatan_eqp_awal))
	{
		$qtyutang_peralatan_eqp_awal = $qtyutang_peralatan_eqp_awal+$dutang_peralatan_eqp_awal['qty'];
	}
	$plus_eqp=0;$min_eqp=0;
	$qpeny_eqp = mysql_query("select * from peny_barang where id_barang='$dgudang_eqp[id_barang]' and tanggal < '$all%'");
	while($dpeny_eqp=mysql_fetch_assoc($qpeny_eqp))
	{
		$plus_eqp = $plus_eqp+$dpeny_eqp['qty_plus'];
		$min_eqp = $min_eqp+$dpeny_eqp['qty_min'];
	}
	$total_peny_brg_eqp = $plus_eqp-$min_eqp;

	$Totqtyeqp_awal = $dgudang_eqp['stok_awal']+($qtyreturjual_eqp_awal+$qtybeli_eqp_awal)-($qtyutang_peralatan_eqp_awal+$qtyjualtunai_eqp_awal+$qtyjualcabang_eqp_awal+$qtyjual_eqp_awal+$qtyreturbeli_eqp_awal)+$total_peny_brg_eqp;
	$subbeli_eqp_awal = $hrgbeligudang_eqp*$Totqtyeqp_awal;
	$Totbeli_eqp_awal = $Totbeli_eqp_awal+$subbeli_eqp_awal;
	//tanggal sekarang//
	$subbeli_eqp=0;$qtybeli_eqp=0;
	$qbeli_eqp = mysql_query("select * from beli where id_barang='$dgudang_eqp[id_barang]' and tanggal like '$all%'");
	while($dbeli_eqp=mysql_fetch_assoc($qbeli_eqp))
	{
		$qtybeli_eqp = $qtybeli_eqp+$dbeli_eqp['qty'];
	}
	$qtyreturjual_eqp=0;
	$qreturjual_eqp = mysql_query("select * from retur_jual where id_barang='$dgudang_eqp[id_barang]' and tgl_rsap like '$all%'");
	while($dreturjual_eqp=mysql_fetch_assoc($qreturjual_eqp))
	{
		$qtyreturjual_eqp = $qtyreturjual_eqp+$dreturjual_eqp['qty'];
	}
	$qtyreturbeli_eqp=0;
	$qreturbeli_eqp = mysql_query("select * from retur_beli where id_barang='$dgudang_eqp[id_barang]' and tgl_rsup like '$all%'");
	while($dreturbeli_eqp=mysql_fetch_assoc($qreturbeli_eqp))
	{
		$qtyreturbeli_eqp = $qtyreturbeli_eqp+$dreturbeli_eqp['qty'];
	}
	$qtyjual_eqp=0;
	$qjual_eqp = mysql_query("select * from jual where id_barang='$dgudang_eqp[id_barang]' and tanggal like '$all%'");
	while($djual_eqp=mysql_fetch_assoc($qjual_eqp))
	{
		$qtyjual_eqp = $qtyjual_eqp+$djual_eqp['qty'];
	}
	$qtyjualcabang_eqp=0;
	$qjualcabang_eqp = mysql_query("select * from jual_cabang where id_barang='$dgudang_eqp[id_barang]' and tgl_nota like '$all%'");
	while($djualcabang_eqp=mysql_fetch_assoc($qjualcabang_eqp))
	{
		$qtyjualcabang_eqp = $qtyjualcabang_eqp+$djualcabang_eqp['qty'];
	}
	$qtyjualtunai_eqp=0;
	$qjualtunai_eqp = mysql_query("select * from jual_tunai where id_barang='$dgudang_eqp[id_barang]' and tgl_nota like '$all%'");
	while($djualtunai_eqp=mysql_fetch_assoc($qjualtunai_eqp))
	{
		$qtyjualtunai_eqp = $qtyjualtunai_eqp+$djualtunai_eqp['qty'];
	}
	$qtyutang_peralatan_eqp=0;
	$qutang_peralatan_eqp = mysql_query("select * from utang_peralatan where id_barang='$dgudang_eqp[id_barang]' and tgl_bon like '$all%'");
	while($dutang_peralatan_eqp=mysql_fetch_assoc($qutang_peralatan_eqp))
	{
		$qtyutang_peralatan_eqp = $qtyutang_peralatan_eqp+$dutang_peralatan_eqp['qty'];
	}
	$plus_eqp_now=0;$min_eqp_now=0;
	$qpeny_eqp_now = mysql_query("select * from peny_barang where id_barang='$dgudang_eqp[id_barang]' and tanggal like '$all%'");
	while($dpeny_eqp_now=mysql_fetch_assoc($qpeny_eqp_now))
	{
		$plus_eqp_now = $plus_eqp_now+$dpeny_eqp_now['qty_plus'];
		$min_eqp_now = $min_eqp_now+$dpeny_eqp_now['qty_min'];
	}
	$total_peny_brg_eqp_now = $plus_eqp_now-$min_eqp_now;

	$Totqtyeqp = ($qtyreturjual_eqp+$qtybeli_eqp)-($qtyutang_peralatan_eqp+$qtyjualtunai_eqp+$qtyjualcabang_eqp+$qtyjual_eqp+$qtyreturbeli_eqp)+$total_peny_brg_eqp_now;
	$subbeli_eqp = $hrgbeligudang_eqp*$Totqtyeqp;
	$Totbeli_eqp = $Totbeli_eqp+$subbeli_eqp;
}
$Totbeli_eqp3=$Totbeli_eqp+$Totbeli_eqp_awal;
$Totbeli_eqp2=ribuan($Totbeli_eqp3);

/* OTHER */
$qgudang_oth = mysql_query("select * from barang where id_barang like 'O-%' order by id_barang");
while($dgudang_oth = mysql_fetch_assoc($qgudang_oth))
{
	$hrgbeligudang_oth = $dgudang_oth['hrg_beli'];
	//tanggal sebelumnya//
	$subbeli_oth_awal=0;$qtybeli_oth_awal=0;
	$qbeli_oth_awal = mysql_query("select * from beli where id_barang='$dgudang_oth[id_barang]' and tanggal < '$all%'");
	while($dbeli_oth_awal=mysql_fetch_assoc($qbeli_oth_awal))
	{
		$qtybeli_oth_awal = $qtybeli_oth_awal+$dbeli_oth_awal['qty'];
	}
	$qtyreturjual_oth_awal=0;
	$qreturjual_oth_awal = mysql_query("select * from retur_jual where id_barang='$dgudang_oth[id_barang]' and tgl_rsap < '$all%'");
	while($dreturjual_oth_awal=mysql_fetch_assoc($qreturjual_oth_awal))
	{
		$qtyreturjual_oth_awal = $qtyreturjual_oth_awal+$dreturjual_oth_awal['qty'];
	}
	$qtyreturbeli_oth_awal=0;
	$qreturbeli_oth_awal = mysql_query("select * from retur_beli where id_barang='$dgudang_oth[id_barang]' and tgl_rsup < '$all%'");
	while($dreturbeli_oth_awal=mysql_fetch_assoc($qreturbeli_oth_awal))
	{
		$qtyreturbeli_oth_awal = $qtyreturbeli_oth_awal+$dreturbeli_oth_awal['qty'];
	}
	$qtyjual_oth_awal=0;
	$qjual_oth_awal = mysql_query("select * from jual where id_barang='$dgudang_oth[id_barang]' and tanggal < '$all%'");
	while($djual_oth_awal=mysql_fetch_assoc($qjual_oth_awal))
	{
		$qtyjual_oth_awal = $qtyjual_oth_awal+$djual_oth_awal['qty'];
	}
	$qtyjualcabang_oth_awal=0;
	$qjualcabang_oth_awal = mysql_query("select * from jual_cabang where id_barang='$dgudang_oth[id_barang]' and tgl_nota < '$all%'");
	while($djualcabang_oth_awal=mysql_fetch_assoc($qjualcabang_oth_awal))
	{
		$qtyjualcabang_oth_awal = $qtyjualcabang_oth_awal+$djualcabang_oth_awal['qty'];
	}
	$qtyjualtunai_oth_awal=0;
	$qjualtunai_oth_awal = mysql_query("select * from jual_tunai where id_barang='$dgudang_oth[id_barang]' and tgl_nota < '$all%'");
	while($djualtunai_oth_awal=mysql_fetch_assoc($qjualtunai_oth_awal))
	{
		$qtyjualtunai_oth_awal = $qtyjualtunai_oth_awal+$djualtunai_oth_awal['qty'];
	}
	$qtyutang_peralatan_oth_awal=0;
	$qutang_peralatan_oth_awal = mysql_query("select * from utang_peralatan where id_barang='$dgudang_oth[id_barang]' and tgl_bon < '$all%'");
	while($dutang_peralatan_oth_awal=mysql_fetch_assoc($qutang_peralatan_oth_awal))
	{
		$qtyutang_peralatan_oth_awal = $qtyutang_peralatan_oth_awal+$dutang_peralatan_oth_awal['qty'];
	}
	$plus_oth=0;$min_oth=0;
	$qpeny_oth = mysql_query("select * from peny_barang where id_barang='$dgudang_oth[id_barang]' and tanggal < '$all%'");
	while($dpeny_oth=mysql_fetch_assoc($qpeny_oth))
	{
		$plus_oth = $plus_oth+$dpeny_oth['qty_plus'];
		$min_oth = $min_oth+$dpeny_oth['qty_min'];
	}
	$total_peny_brg_oth = $plus_oth-$min_oth;

	$Totqtyoth_awal = $dgudang_oth['stok_awal']+($qtyreturjual_oth_awal+$qtybeli_oth_awal)-($qtyutang_peralatan_oth_awal+$qtyjualtunai_oth_awal+$qtyjualcabang_oth_awal+$qtyjual_oth_awal+$qtyreturbeli_oth_awal)+$total_peny_brg_oth;
	$subbeli_oth_awal = $hrgbeligudang_oth*$Totqtyoth_awal;
	$Totbeli_oth_awal = $Totbeli_oth_awal+$subbeli_oth_awal;
	//tanggal sekarang//
	$subbeli_oth=0;$qtybeli_oth=0;
	$qbeli_oth = mysql_query("select * from beli where id_barang='$dgudang_oth[id_barang]' and tanggal like '$all%'");
	while($dbeli_oth=mysql_fetch_assoc($qbeli_oth))
	{
		$qtybeli_oth = $qtybeli_oth+$dbeli_oth['qty'];
	}
	$qtyreturjual_oth=0;
	$qreturjual_oth = mysql_query("select * from retur_jual where id_barang='$dgudang_oth[id_barang]' and tgl_rsap like '$all%'");
	while($dreturjual_oth=mysql_fetch_assoc($qreturjual_oth))
	{
		$qtyreturjual_oth = $qtyreturjual_oth+$dreturjual_oth['qty'];
	}
	$qtyreturbeli_oth=0;
	$qreturbeli_oth = mysql_query("select * from retur_beli where id_barang='$dgudang_oth[id_barang]' and tgl_rsup like '$all%'");
	while($dreturbeli_oth=mysql_fetch_assoc($qreturbeli_oth))
	{
		$qtyreturbeli_oth = $qtyreturbeli_oth+$dreturbeli_oth['qty'];
	}
	$qtyjual_oth=0;
	$qjual_oth = mysql_query("select * from jual where id_barang='$dgudang_oth[id_barang]' and tanggal like '$all%'");
	while($djual_oth=mysql_fetch_assoc($qjual_oth))
	{
		$qtyjual_oth = $qtyjual_oth+$djual_oth['qty'];
	}
	$qtyjualcabang_oth=0;
	$qjualcabang_oth = mysql_query("select * from jual_cabang where id_barang='$dgudang_oth[id_barang]' and tgl_nota like '$all%'");
	while($djualcabang_oth=mysql_fetch_assoc($qjualcabang_oth))
	{
		$qtyjualcabang_oth = $qtyjualcabang_oth+$djualcabang_oth['qty'];
	}
	$qtyjualtunai_oth=0;
	$qjualtunai_oth = mysql_query("select * from jual_tunai where id_barang='$dgudang_oth[id_barang]' and tgl_nota like '$all%'");
	while($djualtunai_oth=mysql_fetch_assoc($qjualtunai_oth))
	{
		$qtyjualtunai_oth = $qtyjualtunai_oth+$djualtunai_oth['qty'];
	}
	$qtyutang_peralatan_oth=0;
	$qutang_peralatan_oth = mysql_query("select * from utang_peralatan where id_barang='$dgudang_oth[id_barang]' and tgl_bon like '$all%'");
	while($dutang_peralatan_oth=mysql_fetch_assoc($qutang_peralatan_oth))
	{
		$qtyutang_peralatan_oth = $qtyutang_peralatan_oth+$dutang_peralatan_oth['qty'];
	}
	$plus_oth_now=0;$min_oth_now=0;
	$qpeny_oth_now = mysql_query("select * from peny_barang where id_barang='$dgudang_oth[id_barang]' and tanggal like '$all%'");
	while($dpeny_oth_now=mysql_fetch_assoc($qpeny_oth_now))
	{
		$plus_oth_now = $plus_oth_now+$dpeny_oth_now['qty_plus'];
		$min_oth_now = $min_oth+$dpeny_oth_now['qty_min'];
	}
	$total_peny_brg_oth_now = $plus_oth_now-$min_oth_now;

	$Totqtyoth = ($qtyreturjual_oth+$qtybeli_oth)-($qtyutang_peralatan_oth+$qtyjualtunai_oth+$qtyjualcabang_oth+$qtyjual_oth+$qtyreturbeli_oth)+$total_peny_brg_oth_now;
	$subbeli_oth = $hrgbeligudang_oth*$Totqtyoth;
	$Totbeli_oth = $Totbeli_oth+$subbeli_oth;
}
$Totbeli_oth3=$Totbeli_oth_awal+$Totbeli_oth;
$Totbeli_oth2=ribuan($Totbeli_oth3);

$Total_persediaan_gudang = $Totbeli_doc3+$Totbeli_pkn3+$Totbeli_ovk3+$Totbeli_eqp3+$Totbeli_oth3;
$Total_persediaan_gudang2=ribuan($Total_persediaan_gudang);
?>
<?
//===========================================PERSEDIAAN GD.COMPANY FARM===========================================\\
/* DOC */ 
$qprod_cf = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL.KK' order by produksi.id_produksi");
while($dprod_cf = mysql_fetch_assoc($qprod_cf))
{
	$id_produksi_cf = $dprod_cf['id_produksi'];
	//Memfilter id produksi
	$qpja_cf = mysql_query("select * from pja where id_produksi='$id_produksi_cf' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_cf = mysql_fetch_assoc($qpja_cf);
	$bpja_cf = mysql_num_rows($qpja_cf);
	if(($bpja_cf == '')or($bpja_cf == 0))
	{
		//jual
		$tot_doc_cf_awal=0;
		$qjual_doc_cf_awal = mysql_query("select * from jual where id_produksi='$id_produksi_cf' and id_barang like 'D-%' and tanggal < '$all%' ");
		while($djual_doc_cf_awal=mysql_fetch_assoc($qjual_doc_cf_awal))
		{
			$id_barang_doc_cf_awal = $djual_doc_cf_awal['id_barang'];
			$qty_doc_cf_awal = $djual_doc_cf_awal['qty'];
			//cari harga
			$qbarang_doc_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_doc_cf_awal'");
			$dbarang_doc_cf_awal = mysql_fetch_assoc($qbarang_doc_cf_awal);
			$hrg_barang_doc_cf_awal = $dbarang_doc_cf_awal['hrg_beli'];
			
			$tot_doc_cf_awal = $hrg_barang_doc_cf_awal*$qty_doc_cf_awal;
			$Ttot_doc_cf_awal= $Ttot_doc_cf_awal+$tot_doc_cf_awal; 
		}
		$tot_doc_cf=0;
		$qjual_doc_cf = mysql_query("select * from jual where id_produksi='$id_produksi_cf' and id_barang like 'D-%' and tanggal like '$all%' ");
		while($djual_doc_cf=mysql_fetch_assoc($qjual_doc_cf))
		{
			$id_barang_doc_cf = $djual_doc_cf['id_barang'];
			$qty_doc_cf = $djual_doc_cf['qty'];
			//cari harga
			$qbarang_doc_cf = mysql_query("select * from barang where id_barang='$id_barang_doc_cf'");
			$dbarang_doc_cf = mysql_fetch_assoc($qbarang_doc_cf);
			$hrg_barang_doc_cf = $dbarang_doc_cf['hrg_beli'];
			
			$tot_doc_cf = $hrg_barang_doc_cf*$qty_doc_cf;
			$Ttot_doc_cf= $Ttot_doc_cf+$tot_doc_cf; 
		}
		//jual_berjangka
		$tot_jangka_doc_cf_awal=0;
		$qjualjangka_doc_cf_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_cf' and approve != '' and id_barang like 'D-%' and tgl_bon < '$all%' ");
		while($djualjangka_doc_cf_awal=mysql_fetch_assoc($qjualjangka_doc_cf_awal))
		{
			$id_barang_jangka_doc_cf_awal = $djualjangka_doc_cf_awal['id_barang'];
			$qty_jangka_doc_cf_awal = $djualjangka_doc_cf_awal['qty'];
			//cari harga
			$qbarang_jangka_doc_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_cf_awal'");
			$dbarang_jangka_doc_cf_awal = mysql_fetch_assoc($qbarang_jangka_doc_cf_awal);
			$hrg_barang_jangka_doc_cf_awal = $dbarang_jangka_doc_cf_awal['hrg_beli'];
			
			$tot_jangka_doc_cf_awal = $hrg_barang_jangka_doc_cf_awal*$qty_jangka_doc_cf_awal;
			$Ttot_jangka_doc_cf_awal= $Ttot_jangka_doc_cf_awal+$tot_jangka_doc_cf_awal; 
			
		}
		$tot_jangka_doc_cf=0;
		$qjualjangka_doc_cf = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_cf' and approve != '' and id_barang like 'D-%' and tgl_bon like '$all%' ");
		while($djualjangka_doc_cf=mysql_fetch_assoc($qjualjangka_doc_cf))
		{
			$id_barang_jangka_doc_cf = $djualjangka_doc_cf['id_barang'];
			$qty_jangka_doc_cf = $djualjangka_doc_cf['qty'];
			//cari harga
			$qbarang_jangka_doc_cf = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_cf'");
			$dbarang_jangka_doc_cf = mysql_fetch_assoc($qbarang_jangka_doc_cf);
			$hrg_barang_jangka_doc_cf = $dbarang_jangka_doc_cf['hrg_beli'];
			
			$tot_jangka_doc_cf = $hrg_barang_jangka_doc_cf*$qty_jangka_doc_cf;
			$Ttot_jangka_doc_cf= $Ttot_jangka_doc_cf+$tot_jangka_doc_cf; 
		}
		//retur
		$tot_retur_doc_cf_awal=0;
		$qjualretur_doc_cf_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_cf' and id_barang like 'D-%' and tgl_rsap < '$all%' ");
		while($djualretur_doc_cf_awal=mysql_fetch_assoc($qjualretur_doc_cf_awal))
		{
			$id_barang_retur_doc_cf_awal = $djualretur_doc_cf_awal['id_barang'];
			$qty_retur_doc_cf_awal = $djualretur_doc_cf_awal['qty'];
			//cari harga
			$qbarang_retur_doc_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_cf_awal'");
			$dbarang_retur_doc_cf_awal = mysql_fetch_assoc($qbarang_retur_doc_cf_awal);
			$hrg_barang_retur_doc_cf_awal = $dbarang_retur_doc_cf_awal['hrg_beli'];
			
			$tot_retur_doc_cf_awal = $hrg_barang_retur_doc_cf_awal*$qty_retur_doc_cf_awal;
			$Ttot_retur_doc_cf_awal= $Ttot_retur_doc_cf_awal+$tot_retur_doc_cf_awal; 
		}
		$tot_retur_doc_cf=0;
		$qjualretur_doc_cf = mysql_query("select * from retur_jual where id_produksi='$id_produksi_cf' and id_barang like 'D-%' and tgl_rsap like '$all%'");
		while($djualretur_doc_cf=mysql_fetch_assoc($qjualretur_doc_cf))
		{
			$id_barang_retur_doc_cf = $djualretur_doc_cf['id_barang'];
			$qty_retur_doc_cf = $djualretur_doc_cf['qty'];
			//cari harga
			$qbarang_retur_doc_cf = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_cf'");
			$dbarang_retur_doc_cf = mysql_fetch_assoc($qbarang_retur_doc_cf);
			$hrg_barang_retur_doc_cf = $dbarang_retur_doc_cf['hrg_beli'];
			
			$tot_retur_doc_cf = $hrg_barang_retur_doc_cf*$qty_retur_doc_cf;
			$Ttot_retur_doc_cf= $Ttot_retur_doc_cf+$tot_retur_doc_cf; 
		}
		$Total_doc_cf = ($Ttot_doc_cf+$Ttot_doc_cf_awal)+($Ttot_jangka_doc_cf+$Ttot_jangka_doc_cf_awal)-($Ttot_retur_doc_cf+$Ttot_retur_doc_cf_awal);
	}
}
$Total_doc_cf2=ribuan($Total_doc_cf);

/* PAKAN */
$qprod_pkn_cf = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL.KK' order by produksi.id_produksi");
while($dprod_pkn_cf = mysql_fetch_assoc($qprod_pkn_cf))
{
	$id_produksi_pkn_cf = $dprod_pkn_cf['id_produksi'];
	//Memfilter id produksi
	$qpja_pkn_cf = mysql_query("select * from pja where id_produksi='$id_produksi_pkn_cf' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_pkn_cf = mysql_fetch_assoc($qpja_pkn_cf);
	$bpja_pkn_cf = mysql_num_rows($qpja_pkn_cf);
	if(($bpja_pkn_cf == '')or($bpja_pkn_cf == 0))
	{
		//jual
		$tot_pkn_cf_awal=0;
		$qjual_pkn_cf_awal = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_cf' and id_barang like 'F-%' and tanggal < '$all%' ");
		while($djual_pkn_cf_awal=mysql_fetch_assoc($qjual_pkn_cf_awal))
		{
			$id_barang_pkn_cf_awal = $djual_pkn_cf_awal['id_barang'];
			$qty_pkn_cf_awal = $djual_pkn_cf_awal['qty'];
			//cari harga
			$qbarang_pkn_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_pkn_cf_awal'");
			$dbarang_pkn_cf_awal = mysql_fetch_assoc($qbarang_pkn_cf_awal);
			$hrg_barang_pkn_cf_awal = $dbarang_pkn_cf_awal['hrg_beli'];
			
			$tot_pkn_cf_awal = $hrg_barang_pkn_cf_awal*$qty_pkn_cf_awal;
			$Ttot_pkn_cf_awal= $Ttot_pkn_cf_awal+$tot_pkn_cf_awal; 
		}
		$tot_pkn_cf=0;
		$qjual_pkn_cf = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_cf' and id_barang like 'F-%' and tanggal like '$all%' ");
		while($djual_pkn_cf=mysql_fetch_assoc($qjual_pkn_cf))
		{
			$id_barang_pkn_cf = $djual_pkn_cf['id_barang'];
			$qty_pkn_cf = $djual_pkn_cf['qty'];
			//cari harga
			$qbarang_pkn_cf = mysql_query("select * from barang where id_barang='$id_barang_pkn_cf'");
			$dbarang_pkn_cf = mysql_fetch_assoc($qbarang_pkn_cf);
			$hrg_barang_pkn_cf = $dbarang_pkn_cf['hrg_beli'];
			
			$tot_pkn_cf = $hrg_barang_pkn_cf*$qty_pkn_cf;
			$Ttot_pkn_cf= $Ttot_pkn_cf+$tot_pkn_cf; 
		}
		//jual_berjangka
		$tot_jangka_pkn_cf_awal=0;
		$qjualjangka_pkn_cf_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_cf' and approve != '' and id_barang like 'F-%' and tgl_bon < '$all%'");
		while($djualjangka_pkn_cf_awal=mysql_fetch_assoc($qjualjangka_pkn_cf_awal))
		{
			$id_barang_jangka_pkn_cf_awal = $djualjangka_pkn_cf_awal['id_barang'];
			$qty_jangka_pkn_cf_awal = $djualjangka_pkn_cf_awal['qty'];
			//cari harga
			$qbarang_jangka_pkn_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_cf_awal'");
			$dbarang_jangka_pkn_cf_awal = mysql_fetch_assoc($qbarang_jangka_pkn_cf_awal);
			$hrg_barang_jangka_pkn_cf_awal = $dbarang_jangka_pkn_cf_awal['hrg_beli'];
			
			$tot_jangka_pkn_cf_awal = $hrg_barang_jangka_pkn_cf_awal*$qty_jangka_pkn_cf_awal;
			$Ttot_jangka_pkn_cf_awal= $Ttot_jangka_pkn_cf_awal+$tot_jangka_pkn_cf_awal; 
		}
		$tot_jangka_pkn_cf=0;
		$qjualjangka_pkn_cf = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_cf' and approve != '' and id_barang like 'F-%' and tgl_bon like '$all%'");
		while($djualjangka_pkn_cf=mysql_fetch_assoc($qjualjangka_pkn_cf))
		{
			$id_barang_jangka_pkn_cf = $djualjangka_pkn_cf['id_barang'];
			$qty_jangka_pkn_cf = $djualjangka_pkn_cf['qty'];
			//cari harga
			$qbarang_jangka_pkn_cf = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_cf'");
			$dbarang_jangka_pkn_cf = mysql_fetch_assoc($qbarang_jangka_pkn_cf);
			$hrg_barang_jangka_pkn_cf = $dbarang_jangka_pkn_cf['hrg_beli'];
			
			$tot_jangka_pkn_cf = $hrg_barang_jangka_pkn_cf*$qty_jangka_pkn_cf;
			$Ttot_jangka_pkn_cf= $Ttot_jangka_pkn_cf+$tot_jangka_pkn_cf; 
		}
		//retur
		$tot_retur_pkn_cf_awal=0;
		$qjualretur_pkn_cf_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_cf' and id_barang like 'F-%' and tgl_rsap < '$all%'");
		while($djualretur_pkn_cf_awal=mysql_fetch_assoc($qjualretur_pkn_cf_awal))
		{
			$id_barang_retur_pkn_cf_awal = $djualretur_pkn_cf_awal['id_barang'];
			$qty_retur_pkn_cf_awal = $djualretur_pkn_cf_awal['qty'];
			//cari harga
			$qbarang_retur_pkn_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_cf_awal'");
			$dbarang_retur_pkn_cf_awal = mysql_fetch_assoc($qbarang_retur_pkn_cf_awal);
			$hrg_barang_retur_pkn_cf_awal = $dbarang_retur_pkn_cf_awal['hrg_beli'];
			
			$tot_retur_pkn_cf_awal = $hrg_barang_retur_pkn_cf_awal*$qty_retur_pkn_cf_awal;
			$Ttot_retur_pkn_cf_awal= $Ttot_retur_pkn_cf_awal+$tot_retur_pkn_cf_awal; 
		}
		$tot_retur_pkn_cf=0;
		$qjualretur_pkn_cf = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_cf' and id_barang like 'F-%' and tgl_rsap like '$all%'");
		while($djualretur_pkn_cf=mysql_fetch_assoc($qjualretur_pkn_cf))
		{
			$id_barang_retur_pkn_cf = $djualretur_pkn_cf['id_barang'];
			$qty_retur_pkn_cf = $djualretur_pkn_cf['qty'];
			//cari harga
			$qbarang_retur_pkn_cf = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_cf'");
			$dbarang_retur_pkn_cf = mysql_fetch_assoc($qbarang_retur_pkn_cf);
			$hrg_barang_retur_pkn_cf = $dbarang_retur_pkn_cf['hrg_beli'];
			
			$tot_retur_pkn_cf = $hrg_barang_retur_pkn_cf*$qty_retur_pkn_cf;
			$Ttot_retur_pkn_cf= $Ttot_retur_pkn_cf+$tot_retur_pkn_cf; 
		}
		$Total_pkn_cf = ($Ttot_pkn_cf+$Ttot_pkn_cf_awal)+($Ttot_jangka_pkn_cf+$Ttot_jangka_pkn_cf_awal)-($Ttot_retur_pkn_cf+$Ttot_retur_pkn_cf_awal);
	}
}
$Total_pkn_cf2=ribuan($Total_pkn_cf);

/* OVK */
$qprod_ovk_cf = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL.KK' order by produksi.id_produksi");
while($dprod_ovk_cf = mysql_fetch_assoc($qprod_ovk_cf))
{
	$id_produksi_ovk_cf = $dprod_ovk_cf['id_produksi'];
	//Memfilter id produksi
	$qpja_ovk_cf = mysql_query("select * from pja where id_produksi='$id_produksi_ovk_cf' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_ovk_cf = mysql_fetch_assoc($qpja_ovk_cf);
	$bpja_ovk_cf = mysql_num_rows($qpja_ovk_cf);
	if(($bpja_ovk_cf == '')or($bpja_ovk_cf == 0))
	{
		//jual
		$tot_ovk_cf_awal=0;
		$qjual_ovk_cf_awal = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_cf' and id_barang like 'M-%' and tanggal < '$all%'");
		while($djual_ovk_cf_awal=mysql_fetch_assoc($qjual_ovk_cf_awal))
		{
			$id_barang_ovk_cf_awal = $djual_ovk_cf_awal['id_barang'];
			$qty_ovk_cf_awal = $djual_ovk_cf_awal['qty'];
			//cari harga
			$qbarang_ovk_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_ovk_cf_awal'");
			$dbarang_ovk_cf_awal = mysql_fetch_assoc($qbarang_ovk_cf_awal);
			$hrg_barang_ovk_cf_awal = $dbarang_ovk_cf_awal['hrg_beli'];
			
			$tot_ovk_cf_awal = $hrg_barang_ovk_cf_awal*$qty_ovk_cf_awal;
			$Ttot_ovk_cf_awal= $Ttot_ovk_cf_awal+$tot_ovk_cf_awal; 
		}
		$tot_ovk_cf=0;
		$qjual_ovk_cf = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_cf' and id_barang like 'M-%' and tanggal like '$all%'");
		while($djual_ovk_cf=mysql_fetch_assoc($qjual_ovk_cf))
		{
			$id_barang_ovk_cf = $djual_ovk_cf['id_barang'];
			$qty_ovk_cf = $djual_ovk_cf['qty'];
			//cari harga
			$qbarang_ovk_cf = mysql_query("select * from barang where id_barang='$id_barang_ovk_cf'");
			$dbarang_ovk_cf = mysql_fetch_assoc($qbarang_ovk_cf);
			$hrg_barang_ovk_cf = $dbarang_ovk_cf['hrg_beli'];
			
			$tot_ovk_cf = $hrg_barang_ovk_cf*$qty_ovk_cf;
			$Ttot_ovk_cf= $Ttot_ovk_cf+$tot_ovk_cf; 
		}
		//jual_berjangka
		$tot_jangka_ovk_cf_awal=0;
		$qjualjangka_ovk_cf_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_cf' and approve != '' and id_barang like 'M-%' and tgl_bon < '$all%'");
		while($djualjangka_ovk_cf_awal=mysql_fetch_assoc($qjualjangka_ovk_cf_awal))
		{
			$id_barang_jangka_ovk_cf_awal = $djualjangka_ovk_cf_awal['id_barang'];
			$qty_jangka_ovk_cf_awal = $djualjangka_ovk_cf_awal['qty'];
			//cari harga
			$qbarang_jangka_ovk_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_cf_awal'");
			$dbarang_jangka_ovk_cf_awal = mysql_fetch_assoc($qbarang_jangka_ovk_cf_awal);
			$hrg_barang_jangka_ovk_cf_awal = $dbarang_jangka_ovk_cf_awal['hrg_beli'];
			
			$tot_jangka_ovk_cf_awal = $hrg_barang_jangka_ovk_cf_awal*$qty_jangka_ovk_cf_awal;
			$Ttot_jangka_ovk_cf_awal= $Ttot_jangka_ovk_cf_awal+$tot_jangka_ovk_cf_awal; 
		}
		$tot_jangka_ovk_cf=0;
		$qjualjangka_ovk_cf = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_cf' and approve != '' and id_barang like 'M-%' and tgl_bon like '$all%'");
		while($djualjangka_ovk_cf=mysql_fetch_assoc($qjualjangka_ovk_cf))
		{
			$id_barang_jangka_ovk_cf = $djualjangka_ovk_cf['id_barang'];
			$qty_jangka_ovk_cf = $djualjangka_ovk_cf['qty'];
			//cari harga
			$qbarang_jangka_ovk_cf = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_cf'");
			$dbarang_jangka_ovk_cf = mysql_fetch_assoc($qbarang_jangka_ovk_cf);
			$hrg_barang_jangka_ovk_cf = $dbarang_jangka_ovk_cf['hrg_beli'];
			
			$tot_jangka_ovk_cf = $hrg_barang_jangka_ovk_cf*$qty_jangka_ovk_cf;
			$Ttot_jangka_ovk_cf= $Ttot_jangka_ovk_cf+$tot_jangka_ovk_cf; 
		}
		//retur
		$tot_retur_ovk_cf_awal=0;
		$qjualretur_ovk_cf_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_cf' and id_barang like 'M-%' and tgl_rsap < '$all%'");
		while($djualretur_ovk_cf_awal=mysql_fetch_assoc($qjualretur_ovk_cf_awal))
		{
			$id_barang_retur_ovk_cf_awal = $djualretur_ovk_cf_awal['id_barang'];
			$qty_retur_ovk_cf_awal = $djualretur_ovk_cf_awal['qty'];
			//cari harga
			$qbarang_retur_ovk_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_cf_awal'");
			$dbarang_retur_ovk_cf_awal = mysql_fetch_assoc($qbarang_retur_ovk_cf_awal);
			$hrg_barang_retur_ovk_cf_awal = $dbarang_retur_ovk_cf_awal['hrg_beli'];
			
			$tot_retur_ovk_cf_awal = $hrg_barang_retur_ovk_cf_awal*$qty_retur_ovk_cf_awal;
			$Ttot_retur_ovk_cf_awal= $Ttot_retur_ovk_cf_awal+$tot_retur_ovk_cf_awal; 
		}
		$tot_retur_ovk_cf=0;
		$qjualretur_ovk_cf = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_cf' and id_barang like 'M-%' and tgl_rsap like '$all%'");
		while($djualretur_ovk_cf=mysql_fetch_assoc($qjualretur_ovk_cf))
		{
			$id_barang_retur_ovk_cf = $djualretur_ovk_cf['id_barang'];
			$qty_retur_ovk_cf = $djualretur_ovk_cf['qty'];
			//cari harga
			$qbarang_retur_ovk_cf = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_cf'");
			$dbarang_retur_ovk_cf = mysql_fetch_assoc($qbarang_retur_ovk_cf);
			$hrg_barang_retur_ovk_cf = $dbarang_retur_ovk_cf['hrg_beli'];
			
			$tot_retur_ovk_cf = $hrg_barang_retur_ovk_cf*$qty_retur_ovk_cf;
			$Ttot_retur_ovk_cf= $Ttot_retur_ovk_cf+$tot_retur_ovk_cf; 
		}
		$Total_ovk_cf = ($Ttot_ovk_cf+$Ttot_ovk_cf_awal)+($Ttot_jangka_ovk_cf+$Ttot_jangka_ovk_cf_awal)-($Ttot_retur_ovk_cf+$Ttot_retur_ovk_cf_awal);
	}
}
$Total_ovk_cf2=ribuan($Total_ovk_cf);

/* EQUIPMENT */
$qprod_eqp_cf = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL.KK' order by produksi.id_produksi");
while($dprod_eqp_cf = mysql_fetch_assoc($qprod_eqp_cf))
{
	$id_produksi_eqp_cf = $dprod_eqp_cf['id_produksi'];
	//Memfilter id produksi
	$qpja_eqp_cf = mysql_query("select * from pja where id_produksi='$id_produksi_eqp_cf' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_eqp_cf = mysql_fetch_assoc($qpja_eqp_cf);
	$bpja_eqp_cf = mysql_num_rows($qpja_eqp_cf);
	if(($bpja_eqp_cf == '')or($bpja_eqp_cf == 0))
	{
		//jual
		$tot_eqp_cf_awal=0;
		$qjual_eqp_cf_awal = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_cf' and id_barang like 'E-%' and tanggal < '$all%'");
		while($djual_eqp_cf_awal=mysql_fetch_assoc($qjual_eqp_cf_awal))
		{
			$id_barang_eqp_cf_awal = $djual_eqp_cf_awal['id_barang'];
			$qty_eqp_cf_awal = $djual_eqp_cf_awal['qty'];
			//cari harga
			$qbarang_eqp_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_eqp_cf_awal'");
			$dbarang_eqp_cf_awal = mysql_fetch_assoc($qbarang_eqp_cf_awal);
			$hrg_barang_eqp_cf_awal = $dbarang_eqp_cf_awal['hrg_beli'];
			
			$tot_eqp_cf_awal = $hrg_barang_eqp_cf_awal*$qty_eqp_cf_awal;
			$Ttot_eqp_cf_awal= $Ttot_eqp_cf_awal+$tot_eqp_cf_awal; 
		}
		$tot_eqp_cf=0;
		$qjual_eqp_cf = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_cf' and id_barang like 'E-%' and tanggal like '$all%'");
		while($djual_eqp_cf=mysql_fetch_assoc($qjual_eqp_cf))
		{
			$id_barang_eqp_cf = $djual_eqp_cf['id_barang'];
			$qty_eqp_cf = $djual_eqp_cf['qty'];
			//cari harga
			$qbarang_eqp_cf = mysql_query("select * from barang where id_barang='$id_barang_eqp_cf'");
			$dbarang_eqp_cf = mysql_fetch_assoc($qbarang_eqp_cf);
			$hrg_barang_eqp_cf = $dbarang_eqp_cf['hrg_beli'];
			
			$tot_eqp_cf = $hrg_barang_eqp_cf*$qty_eqp_cf;
			$Ttot_eqp_cf= $Ttot_eqp_cf+$tot_eqp_cf; 
		}
		//jual_berjangka
		$tot_jangka_eqp_cf_awal=0;
		$qjualjangka_eqp_cf_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_cf' and approve != '' and id_barang like 'E-%' and tgl_bon < '$all%'");
		while($djualjangka_eqp_cf_awal=mysql_fetch_assoc($qjualjangka_eqp_cf_awal))
		{
			$id_barang_jangka_eqp_cf_awal = $djualjangka_eqp_cf_awal['id_barang'];
			$qty_jangka_eqp_cf_awal = $djualjangka_eqp_cf_awal['qty'];
			//cari harga
			$qbarang_jangka_eqp_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_cf_awal'");
			$dbarang_jangka_eqp_cf_awal = mysql_fetch_assoc($qbarang_jangka_eqp_cf_awal);
			$hrg_barang_jangka_eqp_cf_awal = $dbarang_jangka_eqp_cf_awal['hrg_beli'];
			
			$tot_jangka_eqp_cf_awal = $hrg_barang_jangka_eqp_cf_awal*$qty_jangka_eqp_cf_awal;
			$Ttot_jangka_eqp_cf_awal= $Ttot_jangka_eqp_cf_awal+$tot_jangka_eqp_cf_awal; 
		}
		$tot_jangka_eqp_cf=0;
		$qjualjangka_eqp_cf = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_cf' and approve != '' and id_barang like 'E-%' and tgl_bon like '$all%'");
		while($djualjangka_eqp_cf=mysql_fetch_assoc($qjualjangka_eqp_cf))
		{
			$id_barang_jangka_eqp_cf = $djualjangka_eqp_cf['id_barang'];
			$qty_jangka_eqp_cf = $djualjangka_eqp_cf['qty'];
			//cari harga
			$qbarang_jangka_eqp_cf = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_cf'");
			$dbarang_jangka_eqp_cf = mysql_fetch_assoc($qbarang_jangka_eqp_cf);
			$hrg_barang_jangka_eqp_cf = $dbarang_jangka_eqp_cf['hrg_beli'];
			
			$tot_jangka_eqp_cf = $hrg_barang_jangka_eqp_cf*$qty_jangka_eqp_cf;
			$Ttot_jangka_eqp_cf= $Ttot_jangka_eqp_cf+$tot_jangka_eqp_cf; 
		}
		//retur
		$tot_retur_eqp_cf_awal=0;
		$qjualretur_eqp_cf_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_cf' and id_barang like 'E-%' and tgl_rsap < '$all%' ");
		while($djualretur_eqp_cf_awal=mysql_fetch_assoc($qjualretur_eqp_cf_awal))
		{
			$id_barang_retur_eqp_cf_awal = $djualretur_eqp_cf_awal['id_barang'];
			$qty_retur_eqp_cf_awal = $djualretur_eqp_cf_awal['qty'];
			//cari harga
			$qbarang_retur_eqp_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_cf_awal'");
			$dbarang_retur_eqp_cf_awal = mysql_fetch_assoc($qbarang_retur_eqp_cf_awal);
			$hrg_barang_retur_eqp_cf_awal = $dbarang_retur_eqp_cf_awal['hrg_beli'];
			
			$tot_retur_eqp_cf_awal = $hrg_barang_retur_eqp_cf_awal*$qty_retur_eqp_cf_awal;
			$Ttot_retur_eqp_cf_awal= $Ttot_retur_eqp_cf_awal+$tot_retur_eqp_cf_awal; 
		}
		$tot_retur_eqp_cf=0;
		$qjualretur_eqp_cf = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_cf' and id_barang like 'E-%' and tgl_rsap like '$all%' ");
		while($djualretur_eqp_cf=mysql_fetch_assoc($qjualretur_eqp_cf))
		{
			$id_barang_retur_eqp_cf = $djualretur_eqp_cf['id_barang'];
			$qty_retur_eqp_cf = $djualretur_eqp_cf['qty'];
			//cari harga
			$qbarang_retur_eqp_cf = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_cf'");
			$dbarang_retur_eqp_cf = mysql_fetch_assoc($qbarang_retur_eqp_cf);
			$hrg_barang_retur_eqp_cf = $dbarang_retur_eqp_cf['hrg_beli'];
			
			$tot_retur_eqp_cf = $hrg_barang_retur_eqp_cf*$qty_retur_eqp_cf;
			$Ttot_retur_eqp_cf= $Ttot_retur_eqp_cf+$tot_retur_eqp_cf; 
		}
		$Total_eqp_cf = ($Ttot_eqp_cf+$Ttot_eqp_cf_awal)+($Ttot_jangka_eqp_cf+$Ttot_jangka_eqp_cf_awal)-($Ttot_retur_eqp_cf+$Ttot_retur_eqp_cf_awal);
	}
}
$Total_eqp_cf2=ribuan($Total_eqp_cf);

/* OTHER */
$qprod_oth_cf = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL.KK' order by produksi.id_produksi");
while($dprod_oth_cf = mysql_fetch_assoc($qprod_oth_cf))
{
	$id_produksi_oth_cf = $dprod_oth_cf['id_produksi'];
	//Memfilter id produksi
	$qpja_oth_cf = mysql_query("select * from pja where id_produksi='$id_produksi_oth_cf' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_oth_cf = mysql_fetch_assoc($qpja_oth_cf);
	$bpja_oth_cf = mysql_num_rows($qpja_oth_cf);
	if(($bpja_oth_cf == '')or($bpja_oth_cf == 0))
	{
		//jual
		$tot_oth_cf_awal=0;
		$qjual_oth_cf_awal = mysql_query("select * from jual where id_produksi='$id_produksi_oth_cf' and id_barang like 'O-%' and tanggal < '$all%'");
		while($djual_oth_cf_awal=mysql_fetch_assoc($qjual_oth_cf_awal))
		{
			$id_barang_oth_cf_awal = $djual_oth_cf_awal['id_barang'];
			$qty_oth_cf_awal = $djual_oth_cf_awal['qty'];
			//cari harga
			$qbarang_oth_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_oth_cf_awal'");
			$dbarang_oth_cf_awal = mysql_fetch_assoc($qbarang_oth_cf_awal);
			$hrg_barang_oth_cf_awal = $dbarang_oth_cf_awal['hrg_beli'];
			
			$tot_oth_cf_awal = $hrg_barang_oth_cf_awal*$qty_oth_cf_awal;
			$Ttot_oth_cf_awal= $Ttot_oth_cf_awal+$tot_oth_cf_awal; 
		}
		$tot_oth_cf=0;
		$qjual_oth_cf = mysql_query("select * from jual where id_produksi='$id_produksi_oth_cf' and id_barang like 'O-%' and tanggal like '$all%'");
		while($djual_oth_cf=mysql_fetch_assoc($qjual_oth_cf))
		{
			$id_barang_oth_cf = $djual_oth_cf['id_barang'];
			$qty_oth_cf = $djual_oth_cf['qty'];
			//cari harga
			$qbarang_oth_cf = mysql_query("select * from barang where id_barang='$id_barang_oth_cf'");
			$dbarang_oth_cf = mysql_fetch_assoc($qbarang_oth_cf);
			$hrg_barang_oth_cf = $dbarang_oth_cf['hrg_beli'];
			
			$tot_oth_cf = $hrg_barang_oth_cf*$qty_oth_cf;
			$Ttot_oth_cf= $Ttot_oth_cf+$tot_oth_cf; 
		}
		//jual_berjangka
		$tot_jangka_oth_cf_awal=0;
		$qjualjangka_oth_cf_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_cf' and approve != '' and id_barang like 'O-%' and tgl_bon < '$all%'");
		while($djualjangka_oth_cf_awal=mysql_fetch_assoc($qjualjangka_oth_cf_awal))
		{
			$id_barang_jangka_oth_cf_awal = $djualjangka_oth_cf_awal['id_barang'];
			$qty_jangka_oth_cf_awal = $djualjangka_oth_cf_awal['qty'];
			//cari harga
			$qbarang_jangka_oth_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_cf_awal'");
			$dbarang_jangka_oth_cf_awal = mysql_fetch_assoc($qbarang_jangka_oth_cf_awal);
			$hrg_barang_jangka_oth_cf_awal = $dbarang_jangka_oth_cf_awal['hrg_beli'];
			
			$tot_jangka_oth_cf_awal = $hrg_barang_jangka_oth_cf_awal*$qty_jangka_oth_cf_awal;
			$Ttot_jangka_oth_cf_awal= $Ttot_jangka_oth_cf_awal+$tot_jangka_oth_cf_awal; 
		}
		$tot_jangka_oth_cf=0;
		$qjualjangka_oth_cf = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_cf' and approve != '' and id_barang like 'O-%' and tgl_bon like '$all%'");
		while($djualjangka_oth_cf=mysql_fetch_assoc($qjualjangka_oth_cf))
		{
			$id_barang_jangka_oth_cf = $djualjangka_oth_cf['id_barang'];
			$qty_jangka_oth_cf = $djualjangka_oth_cf['qty'];
			//cari harga
			$qbarang_jangka_oth_cf = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_cf'");
			$dbarang_jangka_oth_cf = mysql_fetch_assoc($qbarang_jangka_oth_cf);
			$hrg_barang_jangka_oth_cf = $dbarang_jangka_oth_cf['hrg_beli'];
			
			$tot_jangka_oth_cf = $hrg_barang_jangka_oth_cf*$qty_jangka_oth_cf;
			$Ttot_jangka_oth_cf= $Ttot_jangka_oth_cf+$tot_jangka_oth_cf; 
		}
		//retur
		$tot_retur_oth_cf_awal=0;
		$qjualretur_oth_cf_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_cf' and id_barang like 'O-%' and tgl_rsap < '$all%'");
		while($djualretur_oth_cf_awal=mysql_fetch_assoc($qjualretur_oth_cf_awal))
		{
			$id_barang_retur_oth_cf_awal = $djualretur_oth_cf_awal['id_barang'];
			$qty_retur_oth_cf_awal = $djualretur_oth_cf_awal['qty'];
			//cari harga
			$qbarang_retur_oth_cf_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_cf_awal'");
			$dbarang_retur_oth_cf_awal = mysql_fetch_assoc($qbarang_retur_oth_cf_awal);
			$hrg_barang_retur_oth_cf_awal = $dbarang_retur_oth_cf_awal['hrg_beli'];
			
			$tot_retur_oth_cf_awal = $hrg_barang_retur_oth_cf_awal*$qty_retur_oth_cf_awal;
			$Ttot_retur_oth_cf_awal= $Ttot_retur_oth_cf_awal+$tot_retur_oth_cf_awal; 
		}
		$tot_retur_oth_cf=0;
		$qjualretur_oth_cf = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_cf' and id_barang like 'O-%' and tgl_rsap like '$all%'");
		while($djualretur_oth_cf=mysql_fetch_assoc($qjualretur_oth_cf))
		{
			$id_barang_retur_oth_cf = $djualretur_oth_cf['id_barang'];
			$qty_retur_oth_cf = $djualretur_oth_cf['qty'];
			//cari harga
			$qbarang_retur_oth_cf = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_cf'");
			$dbarang_retur_oth_cf = mysql_fetch_assoc($qbarang_retur_oth_cf);
			$hrg_barang_retur_oth_cf = $dbarang_retur_oth_cf['hrg_beli'];
			
			$tot_retur_oth_cf = $hrg_barang_retur_oth_cf*$qty_retur_oth_cf;
			$Ttot_retur_oth_cf= $Ttot_retur_oth_cf+$tot_retur_oth_cf; 
		}
		$Total_oth_cf = ($Ttot_oth_cf+$Ttot_oth_cf_awal)+($Ttot_jangka_oth_cf+$Ttot_jangka_oth_cf_awal)-($Ttot_retur_oth_cf+$Ttot_retur_oth_cf_awal);
	}
}
$Total_oth_cf2=ribuan($Total_oth_cf);

/* HPP ADP CF */ 
/* DOC */
$qprod_nt = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL.KK' order by produksi.id_produksi");
while($dprod_nt = mysql_fetch_assoc($qprod_nt))
{
	$id_produksi_nt = $dprod_nt['id_produksi'];
	//Memfilter id produksi
	$qpja_nt = mysql_query("select * from pja where id_produksi='$id_produksi_nt' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_nt = @mysql_fetch_assoc($qpja_nt);
	$bpja_nt = @mysql_num_rows($qpja_nt);
	if(($bpja_nt != '')or($bpja_nt != 0))
	{
		//jual
		$tot_doc_nt_awal=0;
		$qjual_doc_nt_awal = mysql_query("select * from jual where id_produksi='$id_produksi_nt' and id_barang like 'D-%' and tanggal < '$all%' ");
		while($djual_doc_nt_awal=mysql_fetch_assoc($qjual_doc_nt_awal))
		{
			$id_barang_doc_nt_awal = $djual_doc_nt_awal['id_barang'];
			$qty_doc_nt_awal = $djual_doc_nt_awal['qty'];
			//cari harga
			$qbarang_doc_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_doc_nt_awal'");
			$dbarang_doc_nt_awal = mysql_fetch_assoc($qbarang_doc_nt_awal);
			$hrg_barang_doc_nt_awal = $dbarang_doc_nt_awal['hrg_beli'];
			
			$tot_doc_nt_awal = $hrg_barang_doc_nt_awal*$qty_doc_nt_awal;
			$Ttot_doc_nt_awal= $Ttot_doc_nt_awal+$tot_doc_nt_awal; 
		}
		$tot_doc_nt=0;
		$qjual_doc_nt = mysql_query("select * from jual where id_produksi='$id_produksi_nt' and id_barang like 'D-%' and tanggal like '$all%' ");
		while($djual_doc_nt=mysql_fetch_assoc($qjual_doc_nt))
		{
			$id_barang_doc_nt = $djual_doc_nt['id_barang'];
			$qty_doc_nt = $djual_doc_nt['qty'];
			//cari harga
			$qbarang_doc_nt = mysql_query("select * from barang where id_barang='$id_barang_doc_nt'");
			$dbarang_doc_nt = mysql_fetch_assoc($qbarang_doc_nt);
			$hrg_barang_doc_nt = $dbarang_doc_nt['hrg_beli'];
			
			$tot_doc_nt = $hrg_barang_doc_nt*$qty_doc_nt;
			$Ttot_doc_nt= $Ttot_doc_nt+$tot_doc_nt; 
		}
		//jual_berjangka
		$tot_jangka_doc_nt_awal=0;
		$qjualjangka_doc_nt_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_nt' and approve != '' and id_barang like 'D-%' and tgl_bon < '$all%' ");
		while($djualjangka_doc_nt_awal=mysql_fetch_assoc($qjualjangka_doc_nt_awal))
		{
			$id_barang_jangka_doc_nt_awal = $djualjangka_doc_nt_awal['id_barang'];
			$qty_jangka_doc_nt_awal = $djualjangka_doc_nt_awal['qty'];
			//cari harga
			$qbarang_jangka_doc_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_nt_awal'");
			$dbarang_jangka_doc_nt_awal = mysql_fetch_assoc($qbarang_jangka_doc_nt_awal);
			$hrg_barang_jangka_doc_nt_awal = $dbarang_jangka_doc_nt_awal['hrg_beli'];
			
			$tot_jangka_doc_nt_awal = $hrg_barang_jangka_doc_nt_awal*$qty_jangka_doc_nt_awal;
			$Ttot_jangka_doc_nt_awal= $Ttot_jangka_doc_nt_awal+$tot_jangka_doc_nt_awal; 
			
		}
		$tot_jangka_doc_nt=0;
		$qjualjangka_doc_nt = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_nt' and approve != '' and id_barang like 'D-%' and tgl_bon like '$all%' ");
		while($djualjangka_doc_nt=mysql_fetch_assoc($qjualjangka_doc_nt))
		{
			$id_barang_jangka_doc_nt = $djualjangka_doc_nt['id_barang'];
			$qty_jangka_doc_nt = $djualjangka_doc_nt['qty'];
			//cari harga
			$qbarang_jangka_doc_nt = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_nt'");
			$dbarang_jangka_doc_nt = mysql_fetch_assoc($qbarang_jangka_doc_nt);
			$hrg_barang_jangka_doc_nt = $dbarang_jangka_doc_nt['hrg_beli'];
			
			$tot_jangka_doc_nt = $hrg_barang_jangka_doc_nt*$qty_jangka_doc_nt;
			$Ttot_jangka_doc_nt= $Ttot_jangka_doc_nt+$tot_jangka_doc_nt; 
		}
		//retur
		$tot_retur_doc_nt_awal=0;
		$qjualretur_doc_nt_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_nt' and id_barang like 'D-%' and tgl_rsap < '$all%' ");
		while($djualretur_doc_nt_awal=mysql_fetch_assoc($qjualretur_doc_nt_awal))
		{
			$id_barang_retur_doc_nt_awal = $djualretur_doc_nt_awal['id_barang'];
			$qty_retur_doc_nt_awal = $djualretur_doc_nt_awal['qty'];
			//cari harga
			$qbarang_retur_doc_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_nt_awal'");
			$dbarang_retur_doc_nt_awal = mysql_fetch_assoc($qbarang_retur_doc_nt_awal);
			$hrg_barang_retur_doc_nt_awal = $dbarang_retur_doc_nt_awal['hrg_beli'];
			
			$tot_retur_doc_nt_awal = $hrg_barang_retur_doc_nt_awal*$qty_retur_doc_nt_awal;
			$Ttot_retur_doc_nt_awal= $Ttot_retur_doc_nt_awal+$tot_retur_doc_nt_awal; 
		}
		$tot_retur_doc_nt=0;
		$qjualretur_doc_nt = mysql_query("select * from retur_jual where id_produksi='$id_produksi_nt' and id_barang like 'D-%' and tgl_rsap like '$all%'");
		while($djualretur_doc_nt=mysql_fetch_assoc($qjualretur_doc_nt))
		{
			$id_barang_retur_doc_nt = $djualretur_doc_nt['id_barang'];
			$qty_retur_doc_nt = $djualretur_doc_nt['qty'];
			//cari harga
			$qbarang_retur_doc_nt = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_nt'");
			$dbarang_retur_doc_nt = mysql_fetch_assoc($qbarang_retur_doc_nt);
			$hrg_barang_retur_doc_nt = $dbarang_retur_doc_nt['hrg_beli'];
			
			$tot_retur_doc_nt = $hrg_barang_retur_doc_nt*$qty_retur_doc_nt;
			$Ttot_retur_doc_nt= $Ttot_retur_doc_nt+$tot_retur_doc_nt; 
		}
		$Total_doc_nt = ($Ttot_doc_nt+$Ttot_doc_nt_awal)+($Ttot_jangka_doc_nt+$Ttot_jangka_doc_nt_awal)-($Ttot_retur_doc_nt+$Ttot_retur_doc_nt_awal);
	}
}
$Total_doc_nt2=ribuan($Total_doc_nt);

/* PAKAN */
$qprod_pkn_nt = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL.KK' order by produksi.id_produksi");
while($dprod_pkn_nt = mysql_fetch_assoc($qprod_pkn_nt))
{
	$id_produksi_pkn_nt = $dprod_pkn_nt['id_produksi'];
	//Memfilter id produksi
	$qpja_pkn_nt = mysql_query("select * from pja where id_produksi='$id_produksi_pkn_nt' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_pkn_nt = @mysql_fetch_assoc($qpja_pkn_nt);
	$bpja_pkn_nt = @mysql_num_rows($qpja_pkn_nt);
	if(($bpja_pkn_nt != '')or($bpja_pkn_nt != 0))
	{
		//jual
		$tot_pkn_nt_awal=0;
		$qjual_pkn_nt_awal = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_nt' and id_barang like 'F-%' and tanggal < '$all%' ");
		while($djual_pkn_nt_awal=mysql_fetch_assoc($qjual_pkn_nt_awal))
		{
			$id_barang_pkn_nt_awal = $djual_pkn_nt_awal['id_barang'];
			$qty_pkn_nt_awal = $djual_pkn_nt_awal['qty'];
			//cari harga
			$qbarang_pkn_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_pkn_nt_awal'");
			$dbarang_pkn_nt_awal = mysql_fetch_assoc($qbarang_pkn_nt_awal);
			$hrg_barang_pkn_nt_awal = $dbarang_pkn_nt_awal['hrg_beli'];
			
			$tot_pkn_nt_awal = $hrg_barang_pkn_nt_awal*$qty_pkn_nt_awal;
			$Ttot_pkn_nt_awal= $Ttot_pkn_nt_awal+$tot_pkn_nt_awal; 
		}
		$tot_pkn_nt=0;
		$qjual_pkn_nt = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_nt' and id_barang like 'F-%' and tanggal like '$all%' ");
		while($djual_pkn_nt=mysql_fetch_assoc($qjual_pkn_nt))
		{
			$id_barang_pkn_nt = $djual_pkn_nt['id_barang'];
			$qty_pkn_nt = $djual_pkn_nt['qty'];
			//cari harga
			$qbarang_pkn_nt = mysql_query("select * from barang where id_barang='$id_barang_pkn_nt'");
			$dbarang_pkn_nt = mysql_fetch_assoc($qbarang_pkn_nt);
			$hrg_barang_pkn_nt = $dbarang_pkn_nt['hrg_beli'];
			
			$tot_pkn_nt = $hrg_barang_pkn_nt*$qty_pkn_nt;
			$Ttot_pkn_nt= $Ttot_pkn_nt+$tot_pkn_nt; 
		}
		//jual_berjangka
		$tot_jangka_pkn_nt_awal=0;
		$qjualjangka_pkn_nt_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_nt' and approve != '' and id_barang like 'F-%' and tgl_bon < '$all%'");
		while($djualjangka_pkn_nt_awal=mysql_fetch_assoc($qjualjangka_pkn_nt_awal))
		{
			$id_barang_jangka_pkn_nt_awal = $djualjangka_pkn_nt_awal['id_barang'];
			$qty_jangka_pkn_nt_awal = $djualjangka_pkn_nt_awal['qty'];
			//cari harga
			$qbarang_jangka_pkn_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_nt_awal'");
			$dbarang_jangka_pkn_nt_awal = mysql_fetch_assoc($qbarang_jangka_pkn_nt_awal);
			$hrg_barang_jangka_pkn_nt_awal = $dbarang_jangka_pkn_nt_awal['hrg_beli'];
			
			$tot_jangka_pkn_nt_awal = $hrg_barang_jangka_pkn_nt_awal*$qty_jangka_pkn_nt_awal;
			$Ttot_jangka_pkn_nt_awal= $Ttot_jangka_pkn_nt_awal+$tot_jangka_pkn_nt_awal; 
		}
		$tot_jangka_pkn_nt=0;
		$qjualjangka_pkn_nt = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_nt' and approve != '' and id_barang like 'F-%' and tgl_bon like '$all%'");
		while($djualjangka_pkn_nt=mysql_fetch_assoc($qjualjangka_pkn_nt))
		{
			$id_barang_jangka_pkn_nt = $djualjangka_pkn_nt['id_barang'];
			$qty_jangka_pkn_nt = $djualjangka_pkn_nt['qty'];
			//cari harga
			$qbarang_jangka_pkn_nt = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_nt'");
			$dbarang_jangka_pkn_nt = mysql_fetch_assoc($qbarang_jangka_pkn_nt);
			$hrg_barang_jangka_pkn_nt = $dbarang_jangka_pkn_nt['hrg_beli'];
			
			$tot_jangka_pkn_nt = $hrg_barang_jangka_pkn_nt*$qty_jangka_pkn_nt;
			$Ttot_jangka_pkn_nt= $Ttot_jangka_pkn_nt+$tot_jangka_pkn_nt; 
		}
		//retur
		$tot_retur_pkn_nt_awal=0;
		$qjualretur_pkn_nt_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_nt' and id_barang like 'F-%' and tgl_rsap < '$all%'");
		while($djualretur_pkn_nt_awal=mysql_fetch_assoc($qjualretur_pkn_nt_awal))
		{
			$id_barang_retur_pkn_nt_awal = $djualretur_pkn_nt_awal['id_barang'];
			$qty_retur_pkn_nt_awal = $djualretur_pkn_nt_awal['qty'];
			//cari harga
			$qbarang_retur_pkn_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_nt_awal'");
			$dbarang_retur_pkn_nt_awal = mysql_fetch_assoc($qbarang_retur_pkn_nt_awal);
			$hrg_barang_retur_pkn_nt_awal = $dbarang_retur_pkn_nt_awal['hrg_beli'];
			
			$tot_retur_pkn_nt_awal = $hrg_barang_retur_pkn_nt_awal*$qty_retur_pkn_nt_awal;
			$Ttot_retur_pkn_nt_awal= $Ttot_retur_pkn_nt_awal+$tot_retur_pkn_nt_awal; 
		}
		$tot_retur_pkn_nt=0;
		$qjualretur_pkn_nt = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_nt' and id_barang like 'F-%' and tgl_rsap like '$all%'");
		while($djualretur_pkn_nt=mysql_fetch_assoc($qjualretur_pkn_nt))
		{
			$id_barang_retur_pkn_nt = $djualretur_pkn_nt['id_barang'];
			$qty_retur_pkn_nt = $djualretur_pkn_nt['qty'];
			//cari harga
			$qbarang_retur_pkn_nt = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_nt'");
			$dbarang_retur_pkn_nt = mysql_fetch_assoc($qbarang_retur_pkn_nt);
			$hrg_barang_retur_pkn_nt = $dbarang_retur_pkn_nt['hrg_beli'];
			
			$tot_retur_pkn_nt = $hrg_barang_retur_pkn_nt*$qty_retur_pkn_nt;
			$Ttot_retur_pkn_nt= $Ttot_retur_pkn_nt+$tot_retur_pkn_nt; 
		}
		$Total_pkn_nt = ($Ttot_pkn_nt+$Ttot_pkn_nt_awal)+($Ttot_jangka_pkn_nt+$Ttot_jangka_pkn_nt_awal)-($Ttot_retur_pkn_nt+$Ttot_retur_pkn_nt_awal);
	}
}
$Total_pkn_nt2=ribuan($Total_pkn_nt);

/* OVK */
$qprod_ovk_nt = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL.KK' order by produksi.id_produksi");
while($dprod_ovk_nt = mysql_fetch_assoc($qprod_ovk_nt))
{
	$id_produksi_ovk_nt = $dprod_ovk_nt['id_produksi'];
	//Memfilter id produksi
	$qpja_ovk_nt = mysql_query("select * from pja where id_produksi='$id_produksi_ovk_nt' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_ovk_nt = @mysql_fetch_assoc($qpja_ovk_nt);
	$bpja_ovk_nt = @mysql_num_rows($qpja_ovk_nt);
	if(($bpja_ovk_nt != '')or($bpja_ovk_nt != 0))
	{
		//jual
		$tot_ovk_nt_awal=0;
		$qjual_ovk_nt_awal = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_nt' and id_barang like 'M-%' and tanggal < '$all%'");
		while($djual_ovk_nt_awal=mysql_fetch_assoc($qjual_ovk_nt_awal))
		{
			$id_barang_ovk_nt_awal = $djual_ovk_nt_awal['id_barang'];
			$qty_ovk_nt_awal = $djual_ovk_nt_awal['qty'];
			//cari harga
			$qbarang_ovk_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_ovk_nt_awal'");
			$dbarang_ovk_nt_awal = mysql_fetch_assoc($qbarang_ovk_nt_awal);
			$hrg_barang_ovk_nt_awal = $dbarang_ovk_nt_awal['hrg_beli'];
			
			$tot_ovk_nt_awal = $hrg_barang_ovk_nt_awal*$qty_ovk_nt_awal;
			$Ttot_ovk_nt_awal= $Ttot_ovk_nt_awal+$tot_ovk_nt_awal; 
		}
		$tot_ovk_nt=0;
		$qjual_ovk_nt = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_nt' and id_barang like 'M-%' and tanggal like '$all%'");
		while($djual_ovk_nt=mysql_fetch_assoc($qjual_ovk_nt))
		{
			$id_barang_ovk_nt = $djual_ovk_nt['id_barang'];
			$qty_ovk_nt = $djual_ovk_nt['qty'];
			//cari harga
			$qbarang_ovk_nt = mysql_query("select * from barang where id_barang='$id_barang_ovk_nt'");
			$dbarang_ovk_nt = mysql_fetch_assoc($qbarang_ovk_nt);
			$hrg_barang_ovk_nt = $dbarang_ovk_nt['hrg_beli'];
			
			$tot_ovk_nt = $hrg_barang_ovk_nt*$qty_ovk_nt;
			$Ttot_ovk_nt= $Ttot_ovk_nt+$tot_ovk_nt; 
		}
		//jual_berjangka
		$tot_jangka_ovk_nt_awal=0;
		$qjualjangka_ovk_nt_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_nt' and approve != '' and id_barang like 'M-%' and tgl_bon < '$all%'");
		while($djualjangka_ovk_nt_awal=mysql_fetch_assoc($qjualjangka_ovk_nt_awal))
		{
			$id_barang_jangka_ovk_nt_awal = $djualjangka_ovk_nt_awal['id_barang'];
			$qty_jangka_ovk_nt_awal = $djualjangka_ovk_nt_awal['qty'];
			//cari harga
			$qbarang_jangka_ovk_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_nt_awal'");
			$dbarang_jangka_ovk_nt_awal = mysql_fetch_assoc($qbarang_jangka_ovk_nt_awal);
			$hrg_barang_jangka_ovk_nt_awal = $dbarang_jangka_ovk_nt_awal['hrg_beli'];
			
			$tot_jangka_ovk_nt_awal = $hrg_barang_jangka_ovk_nt_awal*$qty_jangka_ovk_nt_awal;
			$Ttot_jangka_ovk_nt_awal= $Ttot_jangka_ovk_nt_awal+$tot_jangka_ovk_nt_awal; 
		}
		$tot_jangka_ovk_nt=0;
		$qjualjangka_ovk_nt = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_nt' and approve != '' and id_barang like 'M-%' and tgl_bon like '$all%'");
		while($djualjangka_ovk_nt=mysql_fetch_assoc($qjualjangka_ovk_nt))
		{
			$id_barang_jangka_ovk_nt = $djualjangka_ovk_nt['id_barang'];
			$qty_jangka_ovk_nt = $djualjangka_ovk_nt['qty'];
			//cari harga
			$qbarang_jangka_ovk_nt = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_nt'");
			$dbarang_jangka_ovk_nt = mysql_fetch_assoc($qbarang_jangka_ovk_nt);
			$hrg_barang_jangka_ovk_nt = $dbarang_jangka_ovk_nt['hrg_beli'];
			
			$tot_jangka_ovk_nt = $hrg_barang_jangka_ovk_nt*$qty_jangka_ovk_nt;
			$Ttot_jangka_ovk_nt= $Ttot_jangka_ovk_nt+$tot_jangka_ovk_nt; 
		}
		//retur
		$tot_retur_ovk_nt_awal=0;
		$qjualretur_ovk_nt_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_nt' and id_barang like 'M-%' and tgl_rsap < '$all%'");
		while($djualretur_ovk_nt_awal=mysql_fetch_assoc($qjualretur_ovk_nt_awal))
		{
			$id_barang_retur_ovk_nt_awal = $djualretur_ovk_nt_awal['id_barang'];
			$qty_retur_ovk_nt_awal = $djualretur_ovk_nt_awal['qty'];
			//cari harga
			$qbarang_retur_ovk_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_nt_awal'");
			$dbarang_retur_ovk_nt_awal = mysql_fetch_assoc($qbarang_retur_ovk_nt_awal);
			$hrg_barang_retur_ovk_nt_awal = $dbarang_retur_ovk_nt_awal['hrg_beli'];
			
			$tot_retur_ovk_nt_awal = $hrg_barang_retur_ovk_nt_awal*$qty_retur_ovk_nt_awal;
			$Ttot_retur_ovk_nt_awal= $Ttot_retur_ovk_nt_awal+$tot_retur_ovk_nt_awal; 
		}
		$tot_retur_ovk_nt=0;
		$qjualretur_ovk_nt = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_nt' and id_barang like 'M-%' and tgl_rsap like '$all%'");
		while($djualretur_ovk_nt=mysql_fetch_assoc($qjualretur_ovk_nt))
		{
			$id_barang_retur_ovk_nt = $djualretur_ovk_nt['id_barang'];
			$qty_retur_ovk_nt = $djualretur_ovk_nt['qty'];
			//cari harga
			$qbarang_retur_ovk_nt = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_nt'");
			$dbarang_retur_ovk_nt = mysql_fetch_assoc($qbarang_retur_ovk_nt);
			$hrg_barang_retur_ovk_nt = $dbarang_retur_ovk_nt['hrg_beli'];
			
			$tot_retur_ovk_nt = $hrg_barang_retur_ovk_nt*$qty_retur_ovk_nt;
			$Ttot_retur_ovk_nt= $Ttot_retur_ovk_nt+$tot_retur_ovk_nt; 
		}
		$Total_ovk_nt = ($Ttot_ovk_nt+$Ttot_ovk_nt_awal)+($Ttot_jangka_ovk_nt+$Ttot_jangka_ovk_nt_awal)-($Ttot_retur_ovk_nt+$Ttot_retur_ovk_nt_awal);
	}
}
$Total_ovk_nt2=ribuan($Total_ovk_nt);

/* EQUIPMENT */
$qprod_eqp_nt = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL.KK' order by produksi.id_produksi");
while($dprod_eqp_nt = mysql_fetch_assoc($qprod_eqp_nt))
{
	$id_produksi_eqp_nt = $dprod_eqp_nt['id_produksi'];
	//Memfilter id produksi
	$qpja_eqp_nt = mysql_query("select * from pja where id_produksi='$id_produksi_eqp_nt' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_eqp_nt = @mysql_fetch_assoc($qpja_eqp_nt);
	$bpja_eqp_nt = @mysql_num_rows($qpja_eqp_nt);
	if(($bpja_eqp_nt != '')or($bpja_eqp_nt != 0))
	{
		//jual
		$tot_eqp_nt_awal=0;
		$qjual_eqp_nt_awal = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_nt' and id_barang like 'E-%' and tanggal < '$all%'");
		while($djual_eqp_nt_awal=mysql_fetch_assoc($qjual_eqp_nt_awal))
		{
			$id_barang_eqp_nt_awal = $djual_eqp_nt_awal['id_barang'];
			$qty_eqp_nt_awal = $djual_eqp_nt_awal['qty'];
			//cari harga
			$qbarang_eqp_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_eqp_nt_awal'");
			$dbarang_eqp_nt_awal = mysql_fetch_assoc($qbarang_eqp_nt_awal);
			$hrg_barang_eqp_nt_awal = $dbarang_eqp_nt_awal['hrg_beli'];
			
			$tot_eqp_nt_awal = $hrg_barang_eqp_nt_awal*$qty_eqp_nt_awal;
			$Ttot_eqp_nt_awal= $Ttot_eqp_nt_awal+$tot_eqp_nt_awal; 
		}
		$tot_eqp_nt=0;
		$qjual_eqp_nt = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_nt' and id_barang like 'E-%' and tanggal like '$all%'");
		while($djual_eqp_nt=mysql_fetch_assoc($qjual_eqp_nt))
		{
			$id_barang_eqp_nt = $djual_eqp_nt['id_barang'];
			$qty_eqp_nt = $djual_eqp_nt['qty'];
			//cari harga
			$qbarang_eqp_nt = mysql_query("select * from barang where id_barang='$id_barang_eqp_nt'");
			$dbarang_eqp_nt = mysql_fetch_assoc($qbarang_eqp_nt);
			$hrg_barang_eqp_nt = $dbarang_eqp_nt['hrg_beli'];
			
			$tot_eqp_nt = $hrg_barang_eqp_nt*$qty_eqp_nt;
			$Ttot_eqp_nt= $Ttot_eqp_nt+$tot_eqp_nt; 
		}
		//jual_berjangka
		$tot_jangka_eqp_nt_awal=0;
		$qjualjangka_eqp_nt_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_nt' and approve != '' and id_barang like 'E-%' and tgl_bon < '$all%'");
		while($djualjangka_eqp_nt_awal=mysql_fetch_assoc($qjualjangka_eqp_nt_awal))
		{
			$id_barang_jangka_eqp_nt_awal = $djualjangka_eqp_nt_awal['id_barang'];
			$qty_jangka_eqp_nt_awal = $djualjangka_eqp_nt_awal['qty'];
			//cari harga
			$qbarang_jangka_eqp_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_nt_awal'");
			$dbarang_jangka_eqp_nt_awal = mysql_fetch_assoc($qbarang_jangka_eqp_nt_awal);
			$hrg_barang_jangka_eqp_nt_awal = $dbarang_jangka_eqp_nt_awal['hrg_beli'];
			
			$tot_jangka_eqp_nt_awal = $hrg_barang_jangka_eqp_nt_awal*$qty_jangka_eqp_nt_awal;
			$Ttot_jangka_eqp_nt_awal= $Ttot_jangka_eqp_nt_awal+$tot_jangka_eqp_nt_awal; 
		}
		$tot_jangka_eqp_nt=0;
		$qjualjangka_eqp_nt = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_nt' and approve != '' and id_barang like 'E-%' and tgl_bon like '$all%'");
		while($djualjangka_eqp_nt=mysql_fetch_assoc($qjualjangka_eqp_nt))
		{
			$id_barang_jangka_eqp_nt = $djualjangka_eqp_nt['id_barang'];
			$qty_jangka_eqp_nt = $djualjangka_eqp_nt['qty'];
			//cari harga
			$qbarang_jangka_eqp_nt = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_nt'");
			$dbarang_jangka_eqp_nt = mysql_fetch_assoc($qbarang_jangka_eqp_nt);
			$hrg_barang_jangka_eqp_nt = $dbarang_jangka_eqp_nt['hrg_beli'];
			
			$tot_jangka_eqp_nt = $hrg_barang_jangka_eqp_nt*$qty_jangka_eqp_nt;
			$Ttot_jangka_eqp_nt= $Ttot_jangka_eqp_nt+$tot_jangka_eqp_nt; 
		}
		//retur
		$tot_retur_eqp_nt_awal=0;
		$qjualretur_eqp_nt_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_nt' and id_barang like 'E-%' and tgl_rsap < '$all%' ");
		while($djualretur_eqp_nt_awal=mysql_fetch_assoc($qjualretur_eqp_nt_awal))
		{
			$id_barang_retur_eqp_nt_awal = $djualretur_eqp_nt_awal['id_barang'];
			$qty_retur_eqp_nt_awal = $djualretur_eqp_nt_awal['qty'];
			//cari harga
			$qbarang_retur_eqp_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_nt_awal'");
			$dbarang_retur_eqp_nt_awal = mysql_fetch_assoc($qbarang_retur_eqp_nt_awal);
			$hrg_barang_retur_eqp_nt_awal = $dbarang_retur_eqp_nt_awal['hrg_beli'];
			
			$tot_retur_eqp_nt_awal = $hrg_barang_retur_eqp_nt_awal*$qty_retur_eqp_nt_awal;
			$Ttot_retur_eqp_nt_awal= $Ttot_retur_eqp_nt_awal+$tot_retur_eqp_nt_awal; 
		}
		$tot_retur_eqp_nt=0;
		$qjualretur_eqp_nt = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_nt' and id_barang like 'E-%' and tgl_rsap like '$all%' ");
		while($djualretur_eqp_nt=mysql_fetch_assoc($qjualretur_eqp_nt))
		{
			$id_barang_retur_eqp_nt = $djualretur_eqp_nt['id_barang'];
			$qty_retur_eqp_nt = $djualretur_eqp_nt['qty'];
			//cari harga
			$qbarang_retur_eqp_nt = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_nt'");
			$dbarang_retur_eqp_nt = mysql_fetch_assoc($qbarang_retur_eqp_nt);
			$hrg_barang_retur_eqp_nt = $dbarang_retur_eqp_nt['hrg_beli'];
			
			$tot_retur_eqp_nt = $hrg_barang_retur_eqp_nt*$qty_retur_eqp_nt;
			$Ttot_retur_eqp_nt= $Ttot_retur_eqp_nt+$tot_retur_eqp_nt; 
		}
		$Total_eqp_nt = ($Ttot_eqp_nt+$Ttot_eqp_nt_awal)+($Ttot_jangka_eqp_nt+$Ttot_jangka_eqp_nt_awal)-($Ttot_retur_eqp_nt+$Ttot_retur_eqp_nt_awal);
	}
}
$Total_eqp_nt2=ribuan($Total_eqp_nt);

/* OTHER */
$qprod_oth_nt = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL.KK' order by produksi.id_produksi");
while($dprod_oth_nt = mysql_fetch_assoc($qprod_oth_nt))
{
	$id_produksi_oth_nt = $dprod_oth_nt['id_produksi'];
	//Memfilter id produksi
	$qpja_oth_nt = mysql_query("select * from pja where id_produksi='$id_produksi_oth_nt' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_oth_nt = @mysql_fetch_assoc($qpja_oth_nt);
	$bpja_oth_nt = @mysql_num_rows($qpja_oth_nt);
	if(($bpja_oth_nt != '')or($bpja_oth_nt != 0))
	{
		//jual
		$tot_oth_nt_awal=0;
		$qjual_oth_nt_awal = mysql_query("select * from jual where id_produksi='$id_produksi_oth_nt' and id_barang like 'O-%' and tanggal < '$all%'");
		while($djual_oth_nt_awal=mysql_fetch_assoc($qjual_oth_nt_awal))
		{
			$id_barang_oth_nt_awal = $djual_oth_nt_awal['id_barang'];
			$qty_oth_nt_awal = $djual_oth_nt_awal['qty'];
			//cari harga
			$qbarang_oth_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_oth_nt_awal'");
			$dbarang_oth_nt_awal = mysql_fetch_assoc($qbarang_oth_nt_awal);
			$hrg_barang_oth_nt_awal = $dbarang_oth_nt_awal['hrg_beli'];
			
			$tot_oth_nt_awal = $hrg_barang_oth_nt_awal*$qty_oth_nt_awal;
			$Ttot_oth_nt_awal= $Ttot_oth_nt_awal+$tot_oth_nt_awal; 
		}
		$tot_oth_nt=0;
		$qjual_oth_nt = mysql_query("select * from jual where id_produksi='$id_produksi_oth_nt' and id_barang like 'O-%' and tanggal like '$all%'");
		while($djual_oth_nt=mysql_fetch_assoc($qjual_oth_nt))
		{
			$id_barang_oth_nt = $djual_oth_nt['id_barang'];
			$qty_oth_nt = $djual_oth_nt['qty'];
			//cari harga
			$qbarang_oth_nt = mysql_query("select * from barang where id_barang='$id_barang_oth_nt'");
			$dbarang_oth_nt = mysql_fetch_assoc($qbarang_oth_nt);
			$hrg_barang_oth_nt = $dbarang_oth_nt['hrg_beli'];
			
			$tot_oth_nt = $hrg_barang_oth_nt*$qty_oth_nt;
			$Ttot_oth_nt= $Ttot_oth_nt+$tot_oth_nt; 
		}
		//jual_berjangka
		$tot_jangka_oth_nt_awal=0;
		$qjualjangka_oth_nt_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_nt' and approve != '' and id_barang like 'O-%' and tgl_bon < '$all%'");
		while($djualjangka_oth_nt_awal=mysql_fetch_assoc($qjualjangka_oth_nt_awal))
		{
			$id_barang_jangka_oth_nt_awal = $djualjangka_oth_nt_awal['id_barang'];
			$qty_jangka_oth_nt_awal = $djualjangka_oth_nt_awal['qty'];
			//cari harga
			$qbarang_jangka_oth_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_nt_awal'");
			$dbarang_jangka_oth_nt_awal = mysql_fetch_assoc($qbarang_jangka_oth_nt_awal);
			$hrg_barang_jangka_oth_nt_awal = $dbarang_jangka_oth_nt_awal['hrg_beli'];
			
			$tot_jangka_oth_nt_awal = $hrg_barang_jangka_oth_nt_awal*$qty_jangka_oth_nt_awal;
			$Ttot_jangka_oth_nt_awal= $Ttot_jangka_oth_nt_awal+$tot_jangka_oth_nt_awal; 
		}
		$tot_jangka_oth_nt=0;
		$qjualjangka_oth_nt = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_nt' and approve != '' and id_barang like 'O-%' and tgl_bon like '$all%'");
		while($djualjangka_oth_nt=mysql_fetch_assoc($qjualjangka_oth_nt))
		{
			$id_barang_jangka_oth_nt = $djualjangka_oth_nt['id_barang'];
			$qty_jangka_oth_nt = $djualjangka_oth_nt['qty'];
			//cari harga
			$qbarang_jangka_oth_nt = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_nt'");
			$dbarang_jangka_oth_nt = mysql_fetch_assoc($qbarang_jangka_oth_nt);
			$hrg_barang_jangka_oth_nt = $dbarang_jangka_oth_nt['hrg_beli'];
			
			$tot_jangka_oth_nt = $hrg_barang_jangka_oth_nt*$qty_jangka_oth_nt;
			$Ttot_jangka_oth_nt= $Ttot_jangka_oth_nt+$tot_jangka_oth_nt; 
		}
		//retur
		$tot_retur_oth_nt_awal=0;
		$qjualretur_oth_nt_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_nt' and id_barang like 'O-%' and tgl_rsap < '$all%'");
		while($djualretur_oth_nt_awal=mysql_fetch_assoc($qjualretur_oth_nt_awal))
		{
			$id_barang_retur_oth_nt_awal = $djualretur_oth_nt_awal['id_barang'];
			$qty_retur_oth_nt_awal = $djualretur_oth_nt_awal['qty'];
			//cari harga
			$qbarang_retur_oth_nt_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_nt_awal'");
			$dbarang_retur_oth_nt_awal = mysql_fetch_assoc($qbarang_retur_oth_nt_awal);
			$hrg_barang_retur_oth_nt_awal = $dbarang_retur_oth_nt_awal['hrg_beli'];
			
			$tot_retur_oth_nt_awal = $hrg_barang_retur_oth_nt_awal*$qty_retur_oth_nt_awal;
			$Ttot_retur_oth_nt_awal= $Ttot_retur_oth_nt_awal+$tot_retur_oth_nt_awal; 
		}
		$tot_retur_oth_nt=0;
		$qjualretur_oth_nt = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_nt' and id_barang like 'O-%' and tgl_rsap like '$all%'");
		while($djualretur_oth_nt=mysql_fetch_assoc($qjualretur_oth_nt))
		{
			$id_barang_retur_oth_nt = $djualretur_oth_nt['id_barang'];
			$qty_retur_oth_nt = $djualretur_oth_nt['qty'];
			//cari harga
			$qbarang_retur_oth_nt = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_nt'");
			$dbarang_retur_oth_nt = mysql_fetch_assoc($qbarang_retur_oth_nt);
			$hrg_barang_retur_oth_nt = $dbarang_retur_oth_nt['hrg_beli'];
			
			$tot_retur_oth_nt = $hrg_barang_retur_oth_nt*$qty_retur_oth_nt;
			$Ttot_retur_oth_nt= $Ttot_retur_oth_nt+$tot_retur_oth_nt; 
		}
		$Total_oth_nt = ($Ttot_oth_nt+$Ttot_oth_nt_awal)+($Ttot_jangka_oth_nt+$Ttot_jangka_oth_nt_awal)-($Ttot_retur_oth_nt+$Ttot_retur_oth_nt_awal);
	}
}
$Total_oth_nt2=ribuan($Total_oth_nt);

//BOP CF
$q_ops_cf_awal = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL.KK' order by produksi.id_produksi");
while($d_ops_cf_awal=mysql_fetch_assoc($q_ops_cf_awal))
{
	$id_prod_ops_cf_awal=$d_ops_cf_awal['id_produksi']; //echo"$id_prod_ops_cf_awal<br>";
	$q_op_ins_ternak_cf_awal = mysql_query("select * from op_ins_ternak where id_produksi='$id_prod_ops_cf_awal' and tanggal < '$all%'");
	$Tjml_op_ins_ternak_cf_awal=0;
	while($d_op_ins_ternak_cf_awal=mysql_fetch_assoc($q_op_ins_ternak_cf_awal))
	{
		$jml_op_ins_ternak_cf_awal=$d_op_ins_ternak_cf_awal['jumlah'];
		$Tjml_op_ins_ternak_cf_awal=$Tjml_op_ins_ternak_cf_awal+$jml_op_ins_ternak_cf_awal;
	}
	$Totjml_op_ins_ternak_cf_awal=$Totjml_op_ins_ternak_cf_awal+$Tjml_op_ins_ternak_cf_awal;

	$q_op_ins_ternak_cf = mysql_query("select * from op_ins_ternak where id_produksi='$id_prod_ops_cf_awal' and tanggal like '$all%'");
	$Tjml_op_ins_ternak_cf=0;
	while($d_op_ins_ternak_cf=mysql_fetch_assoc($q_op_ins_ternak_cf))
	{
		$jml_op_ins_ternak_cf=$d_op_ins_ternak_cf['jumlah'];
		$Tjml_op_ins_ternak_cf=$Tjml_op_ins_ternak_cf+$jml_op_ins_ternak_cf;
	}
	$Totjml_op_ins_ternak_cf=$Totjml_op_ins_ternak_cf+$Tjml_op_ins_ternak_cf;
}

$Total_persediaan_nt = $Totjml_op_ins_ternak_cf_awal+$Totjml_op_ins_ternak_cf+$Total_oth_nt+$Total_eqp_nt+$Total_ovk_nt+$Total_pkn_nt+$Total_doc_nt;
$Total_persediaan_nt2=ribuan($Total_persediaan_nt);

$Total_persediaan_cf = $Total_persediaan_nt+$Total_oth_cf+$Total_eqp_cf+$Total_ovk_cf+$Total_pkn_cf+$Total_doc_cf;
$Total_persediaan_cf2=ribuan($Total_persediaan_cf);
?>
<?
//===========================================PERSEDIAAN GD.MAKLOON===========================================\\
/* DOC */ 
$qprod_mkl = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL%' and id_kontrak != 'MKL.KK' order by produksi.id_produksi");
while($dprod_mkl = mysql_fetch_assoc($qprod_mkl))
{
	$id_produksi_mkl = $dprod_mkl['id_produksi'];
	//Memfilter id produksi
	$qpja_mkl = mysql_query("select * from pja where id_produksi='$id_produksi_mkl' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_mkl = mysql_fetch_assoc($qpja_mkl);
	$bpja_mkl = mysql_num_rows($qpja_mkl);
	if(($bpja_mkl == '')or($bpja_mkl == 0))
	{
		//jual
		$tot_doc_mkl_awal=0;
		$qjual_doc_mkl_awal = mysql_query("select * from jual where id_produksi='$id_produksi_mkl' and id_barang like 'D-%' and tanggal < '$all%' ");
		while($djual_doc_mkl_awal=mysql_fetch_assoc($qjual_doc_mkl_awal))
		{
			$id_barang_doc_mkl_awal = $djual_doc_mkl_awal['id_barang'];
			$qty_doc_mkl_awal = $djual_doc_mkl_awal['qty'];
			//cari harga
			$qbarang_doc_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_doc_mkl_awal'");
			$dbarang_doc_mkl_awal = mysql_fetch_assoc($qbarang_doc_mkl_awal);
			$hrg_barang_doc_mkl_awal = $dbarang_doc_mkl_awal['hrg_beli'];
			
			$tot_doc_mkl_awal = $hrg_barang_doc_mkl_awal*$qty_doc_mkl_awal;
			$Ttot_doc_mkl_awal= $Ttot_doc_mkl_awal+$tot_doc_mkl_awal; 
		}
		$tot_doc_mkl=0;
		$qjual_doc_mkl = mysql_query("select * from jual where id_produksi='$id_produksi_mkl' and id_barang like 'D-%' and tanggal like '$all%' ");
		while($djual_doc_mkl=mysql_fetch_assoc($qjual_doc_mkl))
		{
			$id_barang_doc_mkl = $djual_doc_mkl['id_barang'];
			$qty_doc_mkl = $djual_doc_mkl['qty'];
			//cari harga
			$qbarang_doc_mkl = mysql_query("select * from barang where id_barang='$id_barang_doc_mkl'");
			$dbarang_doc_mkl = mysql_fetch_assoc($qbarang_doc_mkl);
			$hrg_barang_doc_mkl = $dbarang_doc_mkl['hrg_beli'];
			
			$tot_doc_mkl = $hrg_barang_doc_mkl*$qty_doc_mkl;
			$Ttot_doc_mkl= $Ttot_doc_mkl+$tot_doc_mkl; 
		}
		//jual_berjangka
		$tot_jangka_doc_mkl_awal=0;
		$qjualjangka_doc_mkl_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_mkl' and approve != '' and id_barang like 'D-%' and tgl_bon < '$all%' ");
		while($djualjangka_doc_mkl_awal=mysql_fetch_assoc($qjualjangka_doc_mkl_awal))
		{
			$id_barang_jangka_doc_mkl_awal = $djualjangka_doc_mkl_awal['id_barang'];
			$qty_jangka_doc_mkl_awal = $djualjangka_doc_mkl_awal['qty'];
			//cari harga
			$qbarang_jangka_doc_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_mkl_awal'");
			$dbarang_jangka_doc_mkl_awal = mysql_fetch_assoc($qbarang_jangka_doc_mkl_awal);
			$hrg_barang_jangka_doc_mkl_awal = $dbarang_jangka_doc_mkl_awal['hrg_beli'];
			
			$tot_jangka_doc_mkl_awal = $hrg_barang_jangka_doc_mkl_awal*$qty_jangka_doc_mkl_awal;
			$Ttot_jangka_doc_mkl_awal= $Ttot_jangka_doc_mkl_awal+$tot_jangka_doc_mkl_awal; 
		}
		$tot_jangka_doc_mkl=0;
		$qjualjangka_doc_mkl = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_mkl' and approve != '' and id_barang like 'D-%' and tgl_bon like '$all%' ");
		while($djualjangka_doc_mkl=mysql_fetch_assoc($qjualjangka_doc_mkl))
		{
			$id_barang_jangka_doc_mkl = $djualjangka_doc_mkl['id_barang'];
			$qty_jangka_doc_mkl = $djualjangka_doc_mkl['qty'];
			//cari harga
			$qbarang_jangka_doc_mkl = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_mkl'");
			$dbarang_jangka_doc_mkl = mysql_fetch_assoc($qbarang_jangka_doc_mkl);
			$hrg_barang_jangka_doc_mkl = $dbarang_jangka_doc_mkl['hrg_beli'];
			
			$tot_jangka_doc_mkl = $hrg_barang_jangka_doc_mkl*$qty_jangka_doc_mkl;
			$Ttot_jangka_doc_mkl= $Ttot_jangka_doc_mkl+$tot_jangka_doc_mkl; 
		}
		//retur
		$tot_retur_doc_mkl_awal=0;
		$qjualretur_doc_mkl_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_mkl' and id_barang like 'D-%' and tgl_rsap < '$all%'");
		while($djualretur_doc_mkl_awal=mysql_fetch_assoc($qjualretur_doc_mkl_awal))
		{
			$id_barang_retur_doc_mkl_awal = $djualretur_doc_mkl_awal['id_barang'];
			$qty_retur_doc_mkl_awal = $djualretur_doc_mkl_awal['qty'];
			//cari harga
			$qbarang_retur_doc_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_mkl_awal'");
			$dbarang_retur_doc_mkl_awal = mysql_fetch_assoc($qbarang_retur_doc_mkl_awal);
			$hrg_barang_retur_doc_mkl_awal = $dbarang_retur_doc_mkl_awal['hrg_beli'];
			
			$tot_retur_doc_mkl_awal = $hrg_barang_retur_doc_mkl_awal*$qty_retur_doc_mkl_awal;
			$Ttot_retur_doc_mkl_awal= $Ttot_retur_doc_mkl_awal+$tot_retur_doc_mkl_awal; 
		}
		$tot_retur_doc_mkl=0;
		$qjualretur_doc_mkl = mysql_query("select * from retur_jual where id_produksi='$id_produksi_mkl' and id_barang like 'D-%' and tgl_rsap like '$all%'");
		while($djualretur_doc_mkl=mysql_fetch_assoc($qjualretur_doc_mkl))
		{
			$id_barang_retur_doc_mkl = $djualretur_doc_mkl['id_barang'];
			$qty_retur_doc_mkl = $djualretur_doc_mkl['qty'];
			//cari harga
			$qbarang_retur_doc_mkl = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_mkl'");
			$dbarang_retur_doc_mkl = mysql_fetch_assoc($qbarang_retur_doc_mkl);
			$hrg_barang_retur_doc_mkl = $dbarang_retur_doc_mkl['hrg_beli'];
			
			$tot_retur_doc_mkl = $hrg_barang_retur_doc_mkl*$qty_retur_doc_mkl;
			$Ttot_retur_doc_mkl= $Ttot_retur_doc_mkl+$tot_retur_doc_mkl; 
		}
		$Total_doc_mkl = ($Ttot_doc_mkl+$Ttot_doc_mkl_awal)+($Ttot_jangka_doc_mkl+$Ttot_jangka_doc_mkl_awal)-($Ttot_retur_doc_mkl+$Ttot_retur_doc_mkl_awal);
	}
}
$Total_doc_mkl2=ribuan($Total_doc_mkl);

/* PAKAN */
$qprod_pkn_mkl = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL%' and id_kontrak != 'MKL.KK' order by produksi.id_produksi");
while($dprod_pkn_mkl = mysql_fetch_assoc($qprod_pkn_mkl))
{
	$id_produksi_pkn_mkl = $dprod_pkn_mkl['id_produksi'];
	//Memfilter id produksi
	$qpja_pkn_mkl = mysql_query("select * from pja where id_produksi='$id_produksi_pkn_mkl' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_pkn_mkl = mysql_fetch_assoc($qpja_pkn_mkl);
	$bpja_pkn_mkl = mysql_num_rows($qpja_pkn_mkl);
	if(($bpja_pkn_mkl == '')or($bpja_pkn_mkl == 0))
	{
		//jual
		$tot_pkn_mkl_awal=0;
		$qjual_pkn_mkl_awal = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_mkl' and id_barang like 'F-%' and tanggal < '$all%'");
		while($djual_pkn_mkl_awal=mysql_fetch_assoc($qjual_pkn_mkl_awal))
		{
			$id_barang_pkn_mkl_awal = $djual_pkn_mkl_awal['id_barang'];
			$qty_pkn_mkl_awal = $djual_pkn_mkl_awal['qty'];
			//cari harga
			$qbarang_pkn_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_pkn_mkl_awal'");
			$dbarang_pkn_mkl_awal = mysql_fetch_assoc($qbarang_pkn_mkl_awal);
			$hrg_barang_pkn_mkl_awal = $dbarang_pkn_mkl_awal['hrg_beli'];
			
			$tot_pkn_mkl_awal = $hrg_barang_pkn_mkl_awal*$qty_pkn_mkl_awal;
			$Ttot_pkn_mkl_awal= $Ttot_pkn_mkl_awal+$tot_pkn_mkl_awal; 
		}
		$tot_pkn_mkl=0;
		$qjual_pkn_mkl = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_mkl' and id_barang like 'F-%' and tanggal like '$all%'");
		while($djual_pkn_mkl=mysql_fetch_assoc($qjual_pkn_mkl))
		{
			$id_barang_pkn_mkl = $djual_pkn_mkl['id_barang'];
			$qty_pkn_mkl = $djual_pkn_mkl['qty'];
			//cari harga
			$qbarang_pkn_mkl = mysql_query("select * from barang where id_barang='$id_barang_pkn_mkl'");
			$dbarang_pkn_mkl = mysql_fetch_assoc($qbarang_pkn_mkl);
			$hrg_barang_pkn_mkl = $dbarang_pkn_mkl['hrg_beli'];
			
			$tot_pkn_mkl = $hrg_barang_pkn_mkl*$qty_pkn_mkl;
			$Ttot_pkn_mkl= $Ttot_pkn_mkl+$tot_pkn_mkl; 
		}
		//jual_berjangka
		$tot_jangka_pkn_mkl_awal=0;
		$qjualjangka_pkn_mkl_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_mkl' and approve != '' and id_barang like 'F-%' and tgl_bon < '$all%'");
		while($djualjangka_pkn_mkl_awal=mysql_fetch_assoc($qjualjangka_pkn_mkl_awal))
		{
			$id_barang_jangka_pkn_mkl_awal = $djualjangka_pkn_mkl_awal['id_barang'];
			$qty_jangka_pkn_mkl_awal = $djualjangka_pkn_mkl_awal['qty'];
			//cari harga
			$qbarang_jangka_pkn_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_mkl_awal'");
			$dbarang_jangka_pkn_mkl_awal = mysql_fetch_assoc($qbarang_jangka_pkn_mkl_awal);
			$hrg_barang_jangka_pkn_mkl_awal = $dbarang_jangka_pkn_mkl_awal['hrg_beli'];
			
			$tot_jangka_pkn_mkl_awal = $hrg_barang_jangka_pkn_mkl_awal*$qty_jangka_pkn_mkl_awal;
			$Ttot_jangka_pkn_mkl_awal= $Ttot_jangka_pkn_mkl_awal+$tot_jangka_pkn_mkl_awal; 
		}
		$tot_jangka_pkn_mkl=0;
		$qjualjangka_pkn_mkl = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_mkl' and approve != '' and id_barang like 'F-%' and tgl_bon like '$all%'");
		while($djualjangka_pkn_mkl=mysql_fetch_assoc($qjualjangka_pkn_mkl))
		{
			$id_barang_jangka_pkn_mkl = $djualjangka_pkn_mkl['id_barang'];
			$qty_jangka_pkn_mkl = $djualjangka_pkn_mkl['qty'];
			//cari harga
			$qbarang_jangka_pkn_mkl = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_mkl'");
			$dbarang_jangka_pkn_mkl = mysql_fetch_assoc($qbarang_jangka_pkn_mkl);
			$hrg_barang_jangka_pkn_mkl = $dbarang_jangka_pkn_mkl['hrg_beli'];
			
			$tot_jangka_pkn_mkl = $hrg_barang_jangka_pkn_mkl*$qty_jangka_pkn_mkl;
			$Ttot_jangka_pkn_mkl= $Ttot_jangka_pkn_mkl+$tot_jangka_pkn_mkl; 
		}
		//retur
		$tot_retur_pkn_mkl_awal=0;
		$qjualretur_pkn_mkl_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_mkl' and id_barang like 'F-%' and tgl_rsap < '$all%' ");
		while($djualretur_pkn_mkl_awal=mysql_fetch_assoc($qjualretur_pkn_mkl_awal))
		{
			$id_barang_retur_pkn_mkl_awal = $djualretur_pkn_mkl_awal['id_barang'];
			$qty_retur_pkn_mkl_awal = $djualretur_pkn_mkl_awal['qty'];
			//cari harga
			$qbarang_retur_pkn_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_mkl_awal'");
			$dbarang_retur_pkn_mkl_awal = mysql_fetch_assoc($qbarang_retur_pkn_mkl_awal);
			$hrg_barang_retur_pkn_mkl_awal = $dbarang_retur_pkn_mkl_awal['hrg_beli'];
			
			$tot_retur_pkn_mkl_awal = $hrg_barang_retur_pkn_mkl_awal*$qty_retur_pkn_mkl_awal;
			$Ttot_retur_pkn_mkl_awal= $Ttot_retur_pkn_mkl_awal+$tot_retur_pkn_mkl_awal; 
		}
		$tot_retur_pkn_mkl=0;
		$qjualretur_pkn_mkl = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_mkl' and id_barang like 'F-%' and tgl_rsap like '$all%' ");
		while($djualretur_pkn_mkl=mysql_fetch_assoc($qjualretur_pkn_mkl))
		{
			$id_barang_retur_pkn_mkl = $djualretur_pkn_mkl['id_barang'];
			$qty_retur_pkn_mkl = $djualretur_pkn_mkl['qty'];
			//cari harga
			$qbarang_retur_pkn_mkl = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_mkl'");
			$dbarang_retur_pkn_mkl = mysql_fetch_assoc($qbarang_retur_pkn_mkl);
			$hrg_barang_retur_pkn_mkl = $dbarang_retur_pkn_mkl['hrg_beli'];
			
			$tot_retur_pkn_mkl = $hrg_barang_retur_pkn_mkl*$qty_retur_pkn_mkl;
			$Ttot_retur_pkn_mkl= $Ttot_retur_pkn_mkl+$tot_retur_pkn_mkl; 
		}
		$Total_pkn_mkl = ($Ttot_pkn_mkl+$Ttot_pkn_mkl_awal)+($Ttot_jangka_pkn_mkl+$Ttot_jangka_pkn_mkl_awal)-($Ttot_retur_pkn_mkl+$Ttot_retur_pkn_mkl_awal);
	}
}
$Total_pkn_mkl2=ribuan($Total_pkn_mkl);

/* OVK */
$qprod_ovk_mkl = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL%' and id_kontrak != 'MKL.KK' order by produksi.id_produksi");
while($dprod_ovk_mkl = mysql_fetch_assoc($qprod_ovk_mkl))
{
	$id_produksi_ovk_mkl = $dprod_ovk_mkl['id_produksi'];
	//Memfilter id produksi
	$qpja_ovk_mkl = mysql_query("select * from pja where id_produksi='$id_produksi_ovk_mkl' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_ovk_mkl = mysql_fetch_assoc($qpja_ovk_mkl);
	$bpja_ovk_mkl = mysql_num_rows($qpja_ovk_mkl);
	if(($bpja_ovk_mkl == '')or($bpja_ovk_mkl == 0))
	{
		//jual
		$tot_ovk_mkl_awal=0;
		$qjual_ovk_mkl_awal = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_mkl' and id_barang like 'M-%' and tanggal < '$all%' ");
		while($djual_ovk_mkl_awal=mysql_fetch_assoc($qjual_ovk_mkl_awal))
		{
			$id_barang_ovk_mkl_awal = $djual_ovk_mkl_awal['id_barang'];
			$qty_ovk_mkl_awal = $djual_ovk_mkl_awal['qty'];
			//cari harga
			$qbarang_ovk_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_ovk_mkl_awal'");
			$dbarang_ovk_mkl_awal = mysql_fetch_assoc($qbarang_ovk_mkl_awal);
			$hrg_barang_ovk_mkl_awal = $dbarang_ovk_mkl_awal['hrg_beli'];
			
			$tot_ovk_mkl_awal = $hrg_barang_ovk_mkl_awal*$qty_ovk_mkl_awal;
			$Ttot_ovk_mkl_awal= $Ttot_ovk_mkl_awal+$tot_ovk_mkl_awal; 
		}
		$tot_ovk_mkl=0;
		$qjual_ovk_mkl = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_mkl' and id_barang like 'M-%' and tanggal like '$all%' ");
		while($djual_ovk_mkl=mysql_fetch_assoc($qjual_ovk_mkl))
		{
			$id_barang_ovk_mkl = $djual_ovk_mkl['id_barang'];
			$qty_ovk_mkl = $djual_ovk_mkl['qty'];
			//cari harga
			$qbarang_ovk_mkl = mysql_query("select * from barang where id_barang='$id_barang_ovk_mkl'");
			$dbarang_ovk_mkl = mysql_fetch_assoc($qbarang_ovk_mkl);
			$hrg_barang_ovk_mkl = $dbarang_ovk_mkl['hrg_beli'];
			
			$tot_ovk_mkl = $hrg_barang_ovk_mkl*$qty_ovk_mkl;
			$Ttot_ovk_mkl= $Ttot_ovk_mkl+$tot_ovk_mkl; 
		}
		//jual_berjangka
		$tot_jangka_ovk_mkl_awal=0;
		$qjualjangka_ovk_mkl_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_mkl' and approve != '' and id_barang like 'M-%' and tgl_bon < '$all%'");
		while($djualjangka_ovk_mkl_awal=mysql_fetch_assoc($qjualjangka_ovk_mkl_awal))
		{
			$id_barang_jangka_ovk_mkl_awal = $djualjangka_ovk_mkl_awal['id_barang'];
			$qty_jangka_ovk_mkl_awal = $djualjangka_ovk_mkl_awal['qty'];
			//cari harga
			$qbarang_jangka_ovk_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_mkl_awal'");
			$dbarang_jangka_ovk_mkl_awal = mysql_fetch_assoc($qbarang_jangka_ovk_mkl_awal);
			$hrg_barang_jangka_ovk_mkl_awal = $dbarang_jangka_ovk_mkl_awal['hrg_beli'];
			
			$tot_jangka_ovk_mkl_awal = $hrg_barang_jangka_ovk_mkl_awal*$qty_jangka_ovk_mkl_awal;
			$Ttot_jangka_ovk_mkl_awal= $Ttot_jangka_ovk_mkl_awal+$tot_jangka_ovk_mkl_awal; 
		}
		$tot_jangka_ovk_mkl=0;
		$qjualjangka_ovk_mkl = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_mkl' and approve != '' and id_barang like 'M-%' and tgl_bon like '$all%'");
		while($djualjangka_ovk_mkl=mysql_fetch_assoc($qjualjangka_ovk_mkl))
		{
			$id_barang_jangka_ovk_mkl = $djualjangka_ovk_mkl['id_barang'];
			$qty_jangka_ovk_mkl = $djualjangka_ovk_mkl['qty'];
			//cari harga
			$qbarang_jangka_ovk_mkl = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_mkl'");
			$dbarang_jangka_ovk_mkl = mysql_fetch_assoc($qbarang_jangka_ovk_mkl);
			$hrg_barang_jangka_ovk_mkl = $dbarang_jangka_ovk_mkl['hrg_beli'];
			
			$tot_jangka_ovk_mkl = $hrg_barang_jangka_ovk_mkl*$qty_jangka_ovk_mkl;
			$Ttot_jangka_ovk_mkl= $Ttot_jangka_ovk_mkl+$tot_jangka_ovk_mkl; 
		}
		//retur
		$tot_retur_ovk_mkl_awal=0;
		$qjualretur_ovk_mkl_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_mkl' and id_barang like 'M-%' and tgl_rsap < '$all%' ");
		while($djualretur_ovk_mkl_awal=mysql_fetch_assoc($qjualretur_ovk_mkl_awal))
		{
			$id_barang_retur_ovk_mkl_awal = $djualretur_ovk_mkl_awal['id_barang'];
			$qty_retur_ovk_mkl_awal = $djualretur_ovk_mkl_awal['qty'];
			//cari harga
			$qbarang_retur_ovk_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_mkl_awal'");
			$dbarang_retur_ovk_mkl_awal = mysql_fetch_assoc($qbarang_retur_ovk_mkl_awal);
			$hrg_barang_retur_ovk_mkl_awal = $dbarang_retur_ovk_mkl_awal['hrg_beli'];
			
			$tot_retur_ovk_mkl_awal = $hrg_barang_retur_ovk_mkl_awal*$qty_retur_ovk_mkl_awal;
			$Ttot_retur_ovk_mkl_awal= $Ttot_retur_ovk_mkl_awal+$tot_retur_ovk_mkl_awal; 
		}
		$tot_retur_ovk_mkl=0;
		$qjualretur_ovk_mkl = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_mkl' and id_barang like 'M-%' and tgl_rsap like '$all%' ");
		while($djualretur_ovk_mkl=mysql_fetch_assoc($qjualretur_ovk_mkl))
		{
			$id_barang_retur_ovk_mkl = $djualretur_ovk_mkl['id_barang'];
			$qty_retur_ovk_mkl = $djualretur_ovk_mkl['qty'];
			//cari harga
			$qbarang_retur_ovk_mkl = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_mkl'");
			$dbarang_retur_ovk_mkl = mysql_fetch_assoc($qbarang_retur_ovk_mkl);
			$hrg_barang_retur_ovk_mkl = $dbarang_retur_ovk_mkl['hrg_beli'];
			
			$tot_retur_ovk_mkl = $hrg_barang_retur_ovk_mkl*$qty_retur_ovk_mkl;
			$Ttot_retur_ovk_mkl= $Ttot_retur_ovk_mkl+$tot_retur_ovk_mkl; 
		}
		$Total_ovk_mkl = ($Ttot_ovk_mkl+$Ttot_ovk_mkl_awal)+($Ttot_jangka_ovk_mkl+$Ttot_jangka_ovk_mkl_awal)-($Ttot_retur_ovk_mkl+$Ttot_retur_ovk_mkl_awal);
	}
}
$Total_ovk_mkl2=ribuan($Total_ovk_mkl);

/* EQUIPMENT */
$qprod_eqp_mkl = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL%' and id_kontrak != 'MKL.KK' order by produksi.id_produksi");
while($dprod_eqp_mkl = mysql_fetch_assoc($qprod_eqp_mkl))
{
	$id_produksi_eqp_mkl = $dprod_eqp_mkl['id_produksi'];
	//Memfilter id produksi
	$qpja_eqp_mkl = mysql_query("select * from pja where id_produksi='$id_produksi_eqp_mkl' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_eqp_mkl = mysql_fetch_assoc($qpja_eqp_mkl);
	$bpja_eqp_mkl = mysql_num_rows($qpja_eqp_mkl);
	if(($bpja_eqp_mkl == '')or($bpja_eqp_mkl == 0))
	{
		//jual
		$tot_eqp_mkl_awal=0;
		$qjual_eqp_mkl_awal = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_mkl' and id_barang like 'E-%' and tanggal < '$all%'");
		while($djual_eqp_mkl_awal=mysql_fetch_assoc($qjual_eqp_mkl_awal))
		{
			$id_barang_eqp_mkl_awal = $djual_eqp_mkl_awal['id_barang'];
			$qty_eqp_mkl_awal = $djual_eqp_mkl_awal['qty'];
			//cari harga
			$qbarang_eqp_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_eqp_mkl_awal'");
			$dbarang_eqp_mkl_awal = mysql_fetch_assoc($qbarang_eqp_mkl_awal);
			$hrg_barang_eqp_mkl_awal = $dbarang_eqp_mkl_awal['hrg_beli'];
			
			$tot_eqp_mkl_awal = $hrg_barang_eqp_mkl_awal*$qty_eqp_mkl_awal;
			$Ttot_eqp_mkl_awal= $Ttot_eqp_mkl_awal+$tot_eqp_mkl_awal; 
		}
		$tot_eqp_mkl=0;
		$qjual_eqp_mkl = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_mkl' and id_barang like 'E-%' and tanggal like '$all%'");
		while($djual_eqp_mkl=mysql_fetch_assoc($qjual_eqp_mkl))
		{
			$id_barang_eqp_mkl = $djual_eqp_mkl['id_barang'];
			$qty_eqp_mkl = $djual_eqp_mkl['qty'];
			//cari harga
			$qbarang_eqp_mkl = mysql_query("select * from barang where id_barang='$id_barang_eqp_mkl'");
			$dbarang_eqp_mkl = mysql_fetch_assoc($qbarang_eqp_mkl);
			$hrg_barang_eqp_mkl = $dbarang_eqp_mkl['hrg_beli'];
			
			$tot_eqp_mkl = $hrg_barang_eqp_mkl*$qty_eqp_mkl;
			$Ttot_eqp_mkl= $Ttot_eqp_mkl+$tot_eqp_mkl; 
		}
		//jual_berjangka
		$tot_jangka_eqp_mkl_awal=0;
		$qjualjangka_eqp_mkl_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_mkl' and approve != '' and id_barang like 'E-%' and tgl_bon < '$all%'");
		while($djualjangka_eqp_mkl_awal=mysql_fetch_assoc($qjualjangka_eqp_mkl_awal))
		{
			$id_barang_jangka_eqp_mkl_awal = $djualjangka_eqp_mkl_awal['id_barang'];
			$qty_jangka_eqp_mkl_awal = $djualjangka_eqp_mkl_awal['qty'];
			//cari harga
			$qbarang_jangka_eqp_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_mkl_awal'");
			$dbarang_jangka_eqp_mkl_awal = mysql_fetch_assoc($qbarang_jangka_eqp_mkl_awal);
			$hrg_barang_jangka_eqp_mkl_awal = $dbarang_jangka_eqp_mkl_awal['hrg_beli'];
			
			$tot_jangka_eqp_mkl_awal = $hrg_barang_jangka_eqp_mkl_awal*$qty_jangka_eqp_mkl_awal;
			$Ttot_jangka_eqp_mkl_awal= $Ttot_jangka_eqp_mkl_awal+$tot_jangka_eqp_mkl_awal; 
		}
		$tot_jangka_eqp_mkl=0;
		$qjualjangka_eqp_mkl = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_mkl' and approve != '' and id_barang like 'E-%' and tgl_bon like '$all%'");
		while($djualjangka_eqp_mkl=mysql_fetch_assoc($qjualjangka_eqp_mkl))
		{
			$id_barang_jangka_eqp_mkl = $djualjangka_eqp_mkl['id_barang'];
			$qty_jangka_eqp_mkl = $djualjangka_eqp_mkl['qty'];
			//cari harga
			$qbarang_jangka_eqp_mkl = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_mkl'");
			$dbarang_jangka_eqp_mkl = mysql_fetch_assoc($qbarang_jangka_eqp_mkl);
			$hrg_barang_jangka_eqp_mkl = $dbarang_jangka_eqp_mkl['hrg_beli'];
			
			$tot_jangka_eqp_mkl = $hrg_barang_jangka_eqp_mkl*$qty_jangka_eqp_mkl;
			$Ttot_jangka_eqp_mkl= $Ttot_jangka_eqp_mkl+$tot_jangka_eqp_mkl; 
		}
		//retur
		$tot_retur_eqp_mkl_awal=0;
		$qjualretur_eqp_mkl_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_mkl' and id_barang like 'E-%' and tgl_rsap < '$all%'");
		while($djualretur_eqp_mkl_awal=mysql_fetch_assoc($qjualretur_eqp_mkl_awal))
		{
			$id_barang_retur_eqp_mkl_awal = $djualretur_eqp_mkl_awal['id_barang'];
			$qty_retur_eqp_mkl_awal = $djualretur_eqp_mkl_awal['qty'];
			//cari harga
			$qbarang_retur_eqp_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_mkl_awal'");
			$dbarang_retur_eqp_mkl_awal = mysql_fetch_assoc($qbarang_retur_eqp_mkl_awal);
			$hrg_barang_retur_eqp_mkl_awal = $dbarang_retur_eqp_mkl_awal['hrg_beli'];
			
			$tot_retur_eqp_mkl_awal = $hrg_barang_retur_eqp_mkl_awal*$qty_retur_eqp_mkl_awal;
			$Ttot_retur_eqp_mkl_awal= $Ttot_retur_eqp_mkl_awal+$tot_retur_eqp_mkl_awal; 
		}
		$tot_retur_eqp_mkl=0;
		$qjualretur_eqp_mkl = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_mkl' and id_barang like 'E-%' and tgl_rsap like '$all%'");
		while($djualretur_eqp_mkl=mysql_fetch_assoc($qjualretur_eqp_mkl))
		{
			$id_barang_retur_eqp_mkl = $djualretur_eqp_mkl['id_barang'];
			$qty_retur_eqp_mkl = $djualretur_eqp_mkl['qty'];
			//cari harga
			$qbarang_retur_eqp_mkl = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_mkl'");
			$dbarang_retur_eqp_mkl = mysql_fetch_assoc($qbarang_retur_eqp_mkl);
			$hrg_barang_retur_eqp_mkl = $dbarang_retur_eqp_mkl['hrg_beli'];
			
			$tot_retur_eqp_mkl = $hrg_barang_retur_eqp_mkl*$qty_retur_eqp_mkl;
			$Ttot_retur_eqp_mkl= $Ttot_retur_eqp_mkl+$tot_retur_eqp_mkl; 
		}
		$Total_eqp_mkl = ($Ttot_eqp_mkl+$Ttot_eqp_mkl_awal)+($Ttot_jangka_eqp_mkl+$Ttot_jangka_eqp_mkl_awal)-($Ttot_retur_eqp_mkl+$Ttot_retur_eqp_mkl_awal);
	}
}
$Total_eqp_mkl2=ribuan($Total_eqp_mkl);

/* OTHER */
$qprod_oth_mkl = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL%' and id_kontrak != 'MKL.KK' order by produksi.id_produksi");
while($dprod_oth_mkl = mysql_fetch_assoc($qprod_oth_mkl))
{
	$id_produksi_oth_mkl = $dprod_oth_mkl['id_produksi'];
	//Memfilter id produksi
	$qpja_oth_mkl = mysql_query("select * from pja where id_produksi='$id_produksi_oth_mkl' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_oth_mkl = mysql_fetch_assoc($qpja_oth_mkl);
	$bpja_oth_mkl = mysql_num_rows($qpja_oth_mkl);
	if(($bpja_oth_mkl == '')or($bpja_oth_mkl == 0))
	{
		//jual
		$tot_oth_mkl_awal=0;
		$qjual_oth_mkl_awal = mysql_query("select * from jual where id_produksi='$id_produksi_oth_mkl' and id_barang like 'O-%' and tanggal < '$all%' ");
		while($djual_oth_mkl_awal=mysql_fetch_assoc($qjual_oth_mkl_awal))
		{
			$id_barang_oth_mkl_awal = $djual_oth_mkl_awal['id_barang'];
			$qty_oth_mkl_awal = $djual_oth_mkl_awal['qty'];
			//cari harga
			$qbarang_oth_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_oth_mkl_awal'");
			$dbarang_oth_mkl_awal = mysql_fetch_assoc($qbarang_oth_mkl_awal);
			$hrg_barang_oth_mkl_awal = $dbarang_oth_mkl_awal['hrg_beli'];
			
			$tot_oth_mkl_awal = $hrg_barang_oth_mkl_awal*$qty_oth_mkl_awal;
			$Ttot_oth_mkl_awal= $Ttot_oth_mkl_awal+$tot_oth_mkl_awal; 
		}
		$tot_oth_mkl=0;
		$qjual_oth_mkl = mysql_query("select * from jual where id_produksi='$id_produksi_oth_mkl' and id_barang like 'O-%' and tanggal like '$all%' ");
		while($djual_oth_mkl=mysql_fetch_assoc($qjual_oth_mkl))
		{
			$id_barang_oth_mkl = $djual_oth_mkl['id_barang'];
			$qty_oth_mkl = $djual_oth_mkl['qty'];
			//cari harga
			$qbarang_oth_mkl = mysql_query("select * from barang where id_barang='$id_barang_oth_mkl'");
			$dbarang_oth_mkl = mysql_fetch_assoc($qbarang_oth_mkl);
			$hrg_barang_oth_mkl = $dbarang_oth_mkl['hrg_beli'];
			
			$tot_oth_mkl = $hrg_barang_oth_mkl*$qty_oth_mkl;
			$Ttot_oth_mkl= $Ttot_oth_mkl+$tot_oth_mkl; 
		}
		//jual_berjangka
		$tot_jangka_oth_mkl_awal=0;
		$qjualjangka_oth_mkl_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_mkl' and approve != '' and id_barang like 'O-%' and tgl_bon < '$all%' ");
		while($djualjangka_oth_mkl_awal=mysql_fetch_assoc($qjualjangka_oth_mkl_awal))
		{
			$id_barang_jangka_oth_mkl_awal = $djualjangka_oth_mkl_awal['id_barang'];
			$qty_jangka_oth_mkl_awal = $djualjangka_oth_mkl_awal['qty'];
			//cari harga
			$qbarang_jangka_oth_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_mkl_awal'");
			$dbarang_jangka_oth_mkl_awal = mysql_fetch_assoc($qbarang_jangka_oth_mkl_awal);
			$hrg_barang_jangka_oth_mkl_awal = $dbarang_jangka_oth_mkl_awal['hrg_beli'];
			
			$tot_jangka_oth_mkl_awal = $hrg_barang_jangka_oth_mkl_awal*$qty_jangka_oth_mkl_awal;
			$Ttot_jangka_oth_mkl_awal= $Ttot_jangka_oth_mkl_awal+$tot_jangka_oth_mkl_awal; 
		}
		$tot_jangka_oth_mkl=0;
		$qjualjangka_oth_mkl = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_mkl' and approve != '' and id_barang like 'O-%' and tgl_bon like '$all%' ");
		while($djualjangka_oth_mkl=mysql_fetch_assoc($qjualjangka_oth_mkl))
		{
			$id_barang_jangka_oth_mkl = $djualjangka_oth_mkl['id_barang'];
			$qty_jangka_oth_mkl = $djualjangka_oth_mkl['qty'];
			//cari harga
			$qbarang_jangka_oth_mkl = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_mkl'");
			$dbarang_jangka_oth_mkl = mysql_fetch_assoc($qbarang_jangka_oth_mkl);
			$hrg_barang_jangka_oth_mkl = $dbarang_jangka_oth_mkl['hrg_beli'];
			
			$tot_jangka_oth_mkl = $hrg_barang_jangka_oth_mkl*$qty_jangka_oth_mkl;
			$Ttot_jangka_oth_mkl= $Ttot_jangka_oth_mkl+$tot_jangka_oth_mkl; 
		}
		//retur
		$tot_retur_oth_mkl_awal=0;
		$qjualretur_oth_mkl_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_mkl' and id_barang like 'O-%' and tgl_rsap < '$all%'");
		while($djualretur_oth_mkl_awal=mysql_fetch_assoc($qjualretur_oth_mkl_awal))
		{
			$id_barang_retur_oth_mkl_awal = $djualretur_oth_mkl_awal['id_barang'];
			$qty_retur_oth_mkl_awal = $djualretur_oth_mkl_awal['qty'];
			//cari harga
			$qbarang_retur_oth_mkl_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_mkl_awal'");
			$dbarang_retur_oth_mkl_awal = mysql_fetch_assoc($qbarang_retur_oth_mkl_awal);
			$hrg_barang_retur_oth_mkl_awal = $dbarang_retur_oth_mkl_awal['hrg_beli'];
			
			$tot_retur_oth_mkl_awal = $hrg_barang_retur_oth_mkl_awal*$qty_retur_oth_mkl_awal;
			$Ttot_retur_oth_mkl_awal= $Ttot_retur_oth_mkl_awal+$tot_retur_oth_mkl_awal; 
		}
		$tot_retur_oth_mkl=0;
		$qjualretur_oth_mkl = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_mkl' and id_barang like 'O-%' and tgl_rsap like '$all%'");
		while($djualretur_oth_mkl=mysql_fetch_assoc($qjualretur_oth_mkl))
		{
			$id_barang_retur_oth_mkl = $djualretur_oth_mkl['id_barang'];
			$qty_retur_oth_mkl = $djualretur_oth_mkl['qty'];
			//cari harga
			$qbarang_retur_oth_mkl = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_mkl'");
			$dbarang_retur_oth_mkl = mysql_fetch_assoc($qbarang_retur_oth_mkl);
			$hrg_barang_retur_oth_mkl = $dbarang_retur_oth_mkl['hrg_beli'];
			
			$tot_retur_oth_mkl = $hrg_barang_retur_oth_mkl*$qty_retur_oth_mkl;
			$Ttot_retur_oth_mkl= $Ttot_retur_oth_mkl+$tot_retur_oth_mkl; 
		}
		$Total_oth_mkl = ($Ttot_oth_mkl+$Ttot_oth_mkl_awal)+($Ttot_jangka_oth_mkl+$Ttot_jangka_oth_mkl_awal)-($Ttot_retur_oth_mkl+$Ttot_retur_oth_mkl_awal);
	}
}
$Total_oth_mkl2=ribuan($Total_oth_mkl);

/* HPP ADP MKL */ 
/* DOC */
$qprod_nl = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL%' and id_kontrak != 'MKL.KK' order by produksi.id_produksi");
while($dprod_nl = mysql_fetch_assoc($qprod_nl))
{
	$id_produksi_nl = $dprod_nl['id_produksi'];
	//Memfilter id produksi
	$qpja_nl = mysql_query("select * from pja where id_produksi='$id_produksi_nl' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_nl = mysql_fetch_assoc($qpja_nl);
	$bpja_nl = mysql_num_rows($qpja_nl);
	if(($bpja_nl != '')or($bpja_nl != 0))
	{
		//jual
		$tot_doc_nl_awal=0;
		$qjual_doc_nl_awal = mysql_query("select * from jual where id_produksi='$id_produksi_nl' and id_barang like 'D-%' and tanggal < '$all%' ");
		while($djual_doc_nl_awal=mysql_fetch_assoc($qjual_doc_nl_awal))
		{
			$id_barang_doc_nl_awal = $djual_doc_nl_awal['id_barang'];
			$qty_doc_nl_awal = $djual_doc_nl_awal['qty'];
			//cari harga
			$qbarang_doc_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_doc_nl_awal'");
			$dbarang_doc_nl_awal = mysql_fetch_assoc($qbarang_doc_nl_awal);
			$hrg_barang_doc_nl_awal = $dbarang_doc_nl_awal['hrg_beli'];
			
			$tot_doc_nl_awal = $hrg_barang_doc_nl_awal*$qty_doc_nl_awal;
			$Ttot_doc_nl_awal= $Ttot_doc_nl_awal+$tot_doc_nl_awal; 
		}
		$tot_doc_nl=0;
		$qjual_doc_nl = mysql_query("select * from jual where id_produksi='$id_produksi_nl' and id_barang like 'D-%' and tanggal like '$all%' ");
		while($djual_doc_nl=mysql_fetch_assoc($qjual_doc_nl))
		{
			$id_barang_doc_nl = $djual_doc_nl['id_barang'];
			$qty_doc_nl = $djual_doc_nl['qty'];
			//cari harga
			$qbarang_doc_nl = mysql_query("select * from barang where id_barang='$id_barang_doc_nl'");
			$dbarang_doc_nl = mysql_fetch_assoc($qbarang_doc_nl);
			$hrg_barang_doc_nl = $dbarang_doc_nl['hrg_beli'];
			
			$tot_doc_nl = $hrg_barang_doc_nl*$qty_doc_nl;
			$Ttot_doc_nl= $Ttot_doc_nl+$tot_doc_nl; 
		}
		//jual_berjangka
		$tot_jangka_doc_nl_awal=0;
		$qjualjangka_doc_nl_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_nl' and approve != '' and id_barang like 'D-%' and tgl_bon < '$all%' ");
		while($djualjangka_doc_nl_awal=mysql_fetch_assoc($qjualjangka_doc_nl_awal))
		{
			$id_barang_jangka_doc_nl_awal = $djualjangka_doc_nl_awal['id_barang'];
			$qty_jangka_doc_nl_awal = $djualjangka_doc_nl_awal['qty'];
			//cari harga
			$qbarang_jangka_doc_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_nl_awal'");
			$dbarang_jangka_doc_nl_awal = mysql_fetch_assoc($qbarang_jangka_doc_nl_awal);
			$hrg_barang_jangka_doc_nl_awal = $dbarang_jangka_doc_nl_awal['hrg_beli'];
			
			$tot_jangka_doc_nl_awal = $hrg_barang_jangka_doc_nl_awal*$qty_jangka_doc_nl_awal;
			$Ttot_jangka_doc_nl_awal= $Ttot_jangka_doc_nl_awal+$tot_jangka_doc_nl_awal; 
			
		}
		$tot_jangka_doc_nl=0;
		$qjualjangka_doc_nl = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_nl' and approve != '' and id_barang like 'D-%' and tgl_bon like '$all%' ");
		while($djualjangka_doc_nl=mysql_fetch_assoc($qjualjangka_doc_nl))
		{
			$id_barang_jangka_doc_nl = $djualjangka_doc_nl['id_barang'];
			$qty_jangka_doc_nl = $djualjangka_doc_nl['qty'];
			//cari harga
			$qbarang_jangka_doc_nl = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_nl'");
			$dbarang_jangka_doc_nl = mysql_fetch_assoc($qbarang_jangka_doc_nl);
			$hrg_barang_jangka_doc_nl = $dbarang_jangka_doc_nl['hrg_beli'];
			
			$tot_jangka_doc_nl = $hrg_barang_jangka_doc_nl*$qty_jangka_doc_nl;
			$Ttot_jangka_doc_nl= $Ttot_jangka_doc_nl+$tot_jangka_doc_nl; 
		}
		//retur
		$tot_retur_doc_nl_awal=0;
		$qjualretur_doc_nl_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_nl' and id_barang like 'D-%' and tgl_rsap < '$all%' ");
		while($djualretur_doc_nl_awal=mysql_fetch_assoc($qjualretur_doc_nl_awal))
		{
			$id_barang_retur_doc_nl_awal = $djualretur_doc_nl_awal['id_barang'];
			$qty_retur_doc_nl_awal = $djualretur_doc_nl_awal['qty'];
			//cari harga
			$qbarang_retur_doc_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_nl_awal'");
			$dbarang_retur_doc_nl_awal = mysql_fetch_assoc($qbarang_retur_doc_nl_awal);
			$hrg_barang_retur_doc_nl_awal = $dbarang_retur_doc_nl_awal['hrg_beli'];
			
			$tot_retur_doc_nl_awal = $hrg_barang_retur_doc_nl_awal*$qty_retur_doc_nl_awal;
			$Ttot_retur_doc_nl_awal= $Ttot_retur_doc_nl_awal+$tot_retur_doc_nl_awal; 
		}
		$tot_retur_doc_nl=0;
		$qjualretur_doc_nl = mysql_query("select * from retur_jual where id_produksi='$id_produksi_nl' and id_barang like 'D-%' and tgl_rsap like '$all%'");
		while($djualretur_doc_nl=mysql_fetch_assoc($qjualretur_doc_nl))
		{
			$id_barang_retur_doc_nl = $djualretur_doc_nl['id_barang'];
			$qty_retur_doc_nl = $djualretur_doc_nl['qty'];
			//cari harga
			$qbarang_retur_doc_nl = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_nl'");
			$dbarang_retur_doc_nl = mysql_fetch_assoc($qbarang_retur_doc_nl);
			$hrg_barang_retur_doc_nl = $dbarang_retur_doc_nl['hrg_beli'];
			
			$tot_retur_doc_nl = $hrg_barang_retur_doc_nl*$qty_retur_doc_nl;
			$Ttot_retur_doc_nl= $Ttot_retur_doc_nl+$tot_retur_doc_nl; 
		}
		$Total_doc_nl = ($Ttot_doc_nl+$Ttot_doc_nl_awal)+($Ttot_jangka_doc_nl+$Ttot_jangka_doc_nl_awal)-($Ttot_retur_doc_nl+$Ttot_retur_doc_nl_awal);
	}
}
$Total_doc_nl2=ribuan($Total_doc_nl);

/* PAKAN */
$qprod_pkn_nl = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL%' and id_kontrak != 'MKL.KK' order by produksi.id_produksi");
while($dprod_pkn_nl = mysql_fetch_assoc($qprod_pkn_nl))
{
	$id_produksi_pkn_nl = $dprod_pkn_nl['id_produksi'];
	//Memfilter id produksi
	$qpja_pkn_nl = mysql_query("select * from pja where id_produksi='$id_produksi_pkn_nl' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_pkn_nl = mysql_fetch_assoc($qpja_pkn_nl);
	$bpja_pkn_nl = mysql_num_rows($qpja_pkn_nl);
	if(($bpja_pkn_nl != '')or($bpja_pkn_nl != 0))
	{
		//jual
		$tot_pkn_nl_awal=0;
		$qjual_pkn_nl_awal = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_nl' and id_barang like 'F-%' and tanggal < '$all%' ");
		while($djual_pkn_nl_awal=mysql_fetch_assoc($qjual_pkn_nl_awal))
		{
			$id_barang_pkn_nl_awal = $djual_pkn_nl_awal['id_barang'];
			$qty_pkn_nl_awal = $djual_pkn_nl_awal['qty'];
			//cari harga
			$qbarang_pkn_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_pkn_nl_awal'");
			$dbarang_pkn_nl_awal = mysql_fetch_assoc($qbarang_pkn_nl_awal);
			$hrg_barang_pkn_nl_awal = $dbarang_pkn_nl_awal['hrg_beli'];
			
			$tot_pkn_nl_awal = $hrg_barang_pkn_nl_awal*$qty_pkn_nl_awal;
			$Ttot_pkn_nl_awal= $Ttot_pkn_nl_awal+$tot_pkn_nl_awal; 
		}
		$tot_pkn_nl=0;
		$qjual_pkn_nl = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_nl' and id_barang like 'F-%' and tanggal like '$all%' ");
		while($djual_pkn_nl=mysql_fetch_assoc($qjual_pkn_nl))
		{
			$id_barang_pkn_nl = $djual_pkn_nl['id_barang'];
			$qty_pkn_nl = $djual_pkn_nl['qty'];
			//cari harga
			$qbarang_pkn_nl = mysql_query("select * from barang where id_barang='$id_barang_pkn_nl'");
			$dbarang_pkn_nl = mysql_fetch_assoc($qbarang_pkn_nl);
			$hrg_barang_pkn_nl = $dbarang_pkn_nl['hrg_beli'];
			
			$tot_pkn_nl = $hrg_barang_pkn_nl*$qty_pkn_nl;
			$Ttot_pkn_nl= $Ttot_pkn_nl+$tot_pkn_nl; 
		}
		//jual_berjangka
		$tot_jangka_pkn_nl_awal=0;
		$qjualjangka_pkn_nl_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_nl' and approve != '' and id_barang like 'F-%' and tgl_bon < '$all%'");
		while($djualjangka_pkn_nl_awal=mysql_fetch_assoc($qjualjangka_pkn_nl_awal))
		{
			$id_barang_jangka_pkn_nl_awal = $djualjangka_pkn_nl_awal['id_barang'];
			$qty_jangka_pkn_nl_awal = $djualjangka_pkn_nl_awal['qty'];
			//cari harga
			$qbarang_jangka_pkn_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_nl_awal'");
			$dbarang_jangka_pkn_nl_awal = mysql_fetch_assoc($qbarang_jangka_pkn_nl_awal);
			$hrg_barang_jangka_pkn_nl_awal = $dbarang_jangka_pkn_nl_awal['hrg_beli'];
			
			$tot_jangka_pkn_nl_awal = $hrg_barang_jangka_pkn_nl_awal*$qty_jangka_pkn_nl_awal;
			$Ttot_jangka_pkn_nl_awal= $Ttot_jangka_pkn_nl_awal+$tot_jangka_pkn_nl_awal; 
		}
		$tot_jangka_pkn_nl=0;
		$qjualjangka_pkn_nl = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_nl' and approve != '' and id_barang like 'F-%' and tgl_bon like '$all%'");
		while($djualjangka_pkn_nl=mysql_fetch_assoc($qjualjangka_pkn_nl))
		{
			$id_barang_jangka_pkn_nl = $djualjangka_pkn_nl['id_barang'];
			$qty_jangka_pkn_nl = $djualjangka_pkn_nl['qty'];
			//cari harga
			$qbarang_jangka_pkn_nl = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_nl'");
			$dbarang_jangka_pkn_nl = mysql_fetch_assoc($qbarang_jangka_pkn_nl);
			$hrg_barang_jangka_pkn_nl = $dbarang_jangka_pkn_nl['hrg_beli'];
			
			$tot_jangka_pkn_nl = $hrg_barang_jangka_pkn_nl*$qty_jangka_pkn_nl;
			$Ttot_jangka_pkn_nl= $Ttot_jangka_pkn_nl+$tot_jangka_pkn_nl; 
		}
		//retur
		$tot_retur_pkn_nl_awal=0;
		$qjualretur_pkn_nl_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_nl' and id_barang like 'F-%' and tgl_rsap < '$all%'");
		while($djualretur_pkn_nl_awal=mysql_fetch_assoc($qjualretur_pkn_nl_awal))
		{
			$id_barang_retur_pkn_nl_awal = $djualretur_pkn_nl_awal['id_barang'];
			$qty_retur_pkn_nl_awal = $djualretur_pkn_nl_awal['qty'];
			//cari harga
			$qbarang_retur_pkn_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_nl_awal'");
			$dbarang_retur_pkn_nl_awal = mysql_fetch_assoc($qbarang_retur_pkn_nl_awal);
			$hrg_barang_retur_pkn_nl_awal = $dbarang_retur_pkn_nl_awal['hrg_beli'];
			
			$tot_retur_pkn_nl_awal = $hrg_barang_retur_pkn_nl_awal*$qty_retur_pkn_nl_awal;
			$Ttot_retur_pkn_nl_awal= $Ttot_retur_pkn_nl_awal+$tot_retur_pkn_nl_awal; 
		}
		$tot_retur_pkn_nl=0;
		$qjualretur_pkn_nl = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_nl' and id_barang like 'F-%' and tgl_rsap like '$all%'");
		while($djualretur_pkn_nl=mysql_fetch_assoc($qjualretur_pkn_nl))
		{
			$id_barang_retur_pkn_nl = $djualretur_pkn_nl['id_barang'];
			$qty_retur_pkn_nl = $djualretur_pkn_nl['qty'];
			//cari harga
			$qbarang_retur_pkn_nl = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_nl'");
			$dbarang_retur_pkn_nl = mysql_fetch_assoc($qbarang_retur_pkn_nl);
			$hrg_barang_retur_pkn_nl = $dbarang_retur_pkn_nl['hrg_beli'];
			
			$tot_retur_pkn_nl = $hrg_barang_retur_pkn_nl*$qty_retur_pkn_nl;
			$Ttot_retur_pkn_nl= $Ttot_retur_pkn_nl+$tot_retur_pkn_nl; 
		}
		$Total_pkn_nl = ($Ttot_pkn_nl+$Ttot_pkn_nl_awal)+($Ttot_jangka_pkn_nl+$Ttot_jangka_pkn_nl_awal)-($Ttot_retur_pkn_nl+$Ttot_retur_pkn_nl_awal);
	}
}
$Total_pkn_nl2=ribuan($Total_pkn_nl);

/* OVK */
$qprod_ovk_nl = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL%' and id_kontrak != 'MKL.KK' order by produksi.id_produksi");
while($dprod_ovk_nl = mysql_fetch_assoc($qprod_ovk_nl))
{
	$id_produksi_ovk_nl = $dprod_ovk_nl['id_produksi'];
	//Memfilter id produksi
	$qpja_ovk_nl = mysql_query("select * from pja where id_produksi='$id_produksi_ovk_nl' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_ovk_nl = mysql_fetch_assoc($qpja_ovk_nl);
	$bpja_ovk_nl = mysql_num_rows($qpja_ovk_nl);
	if(($bpja_ovk_nl != '')or($bpja_ovk_nl != 0))
	{
		//jual
		$tot_ovk_nl_awal=0;
		$qjual_ovk_nl_awal = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_nl' and id_barang like 'M-%' and tanggal < '$all%'");
		while($djual_ovk_nl_awal=mysql_fetch_assoc($qjual_ovk_nl_awal))
		{
			$id_barang_ovk_nl_awal = $djual_ovk_nl_awal['id_barang'];
			$qty_ovk_nl_awal = $djual_ovk_nl_awal['qty'];
			//cari harga
			$qbarang_ovk_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_ovk_nl_awal'");
			$dbarang_ovk_nl_awal = mysql_fetch_assoc($qbarang_ovk_nl_awal);
			$hrg_barang_ovk_nl_awal = $dbarang_ovk_nl_awal['hrg_beli'];
			
			$tot_ovk_nl_awal = $hrg_barang_ovk_nl_awal*$qty_ovk_nl_awal;
			$Ttot_ovk_nl_awal= $Ttot_ovk_nl_awal+$tot_ovk_nl_awal; 
		}
		$tot_ovk_nl=0;
		$qjual_ovk_nl = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_nl' and id_barang like 'M-%' and tanggal like '$all%'");
		while($djual_ovk_nl=mysql_fetch_assoc($qjual_ovk_nl))
		{
			$id_barang_ovk_nl = $djual_ovk_nl['id_barang'];
			$qty_ovk_nl = $djual_ovk_nl['qty'];
			//cari harga
			$qbarang_ovk_nl = mysql_query("select * from barang where id_barang='$id_barang_ovk_nl'");
			$dbarang_ovk_nl = mysql_fetch_assoc($qbarang_ovk_nl);
			$hrg_barang_ovk_nl = $dbarang_ovk_nl['hrg_beli'];
			
			$tot_ovk_nl = $hrg_barang_ovk_nl*$qty_ovk_nl;
			$Ttot_ovk_nl= $Ttot_ovk_nl+$tot_ovk_nl; 
		}
		//jual_berjangka
		$tot_jangka_ovk_nl_awal=0;
		$qjualjangka_ovk_nl_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_nl' and approve != '' and id_barang like 'M-%' and tgl_bon < '$all%'");
		while($djualjangka_ovk_nl_awal=mysql_fetch_assoc($qjualjangka_ovk_nl_awal))
		{
			$id_barang_jangka_ovk_nl_awal = $djualjangka_ovk_nl_awal['id_barang'];
			$qty_jangka_ovk_nl_awal = $djualjangka_ovk_nl_awal['qty'];
			//cari harga
			$qbarang_jangka_ovk_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_nl_awal'");
			$dbarang_jangka_ovk_nl_awal = mysql_fetch_assoc($qbarang_jangka_ovk_nl_awal);
			$hrg_barang_jangka_ovk_nl_awal = $dbarang_jangka_ovk_nl_awal['hrg_beli'];
			
			$tot_jangka_ovk_nl_awal = $hrg_barang_jangka_ovk_nl_awal*$qty_jangka_ovk_nl_awal;
			$Ttot_jangka_ovk_nl_awal= $Ttot_jangka_ovk_nl_awal+$tot_jangka_ovk_nl_awal; 
		}
		$tot_jangka_ovk_nl=0;
		$qjualjangka_ovk_nl = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_nl' and approve != '' and id_barang like 'M-%' and tgl_bon like '$all%'");
		while($djualjangka_ovk_nl=mysql_fetch_assoc($qjualjangka_ovk_nl))
		{
			$id_barang_jangka_ovk_nl = $djualjangka_ovk_nl['id_barang'];
			$qty_jangka_ovk_nl = $djualjangka_ovk_nl['qty'];
			//cari harga
			$qbarang_jangka_ovk_nl = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_nl'");
			$dbarang_jangka_ovk_nl = mysql_fetch_assoc($qbarang_jangka_ovk_nl);
			$hrg_barang_jangka_ovk_nl = $dbarang_jangka_ovk_nl['hrg_beli'];
			
			$tot_jangka_ovk_nl = $hrg_barang_jangka_ovk_nl*$qty_jangka_ovk_nl;
			$Ttot_jangka_ovk_nl= $Ttot_jangka_ovk_nl+$tot_jangka_ovk_nl; 
		}
		//retur
		$tot_retur_ovk_nl_awal=0;
		$qjualretur_ovk_nl_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_nl' and id_barang like 'M-%' and tgl_rsap < '$all%'");
		while($djualretur_ovk_nl_awal=mysql_fetch_assoc($qjualretur_ovk_nl_awal))
		{
			$id_barang_retur_ovk_nl_awal = $djualretur_ovk_nl_awal['id_barang'];
			$qty_retur_ovk_nl_awal = $djualretur_ovk_nl_awal['qty'];
			//cari harga
			$qbarang_retur_ovk_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_nl_awal'");
			$dbarang_retur_ovk_nl_awal = mysql_fetch_assoc($qbarang_retur_ovk_nl_awal);
			$hrg_barang_retur_ovk_nl_awal = $dbarang_retur_ovk_nl_awal['hrg_beli'];
			
			$tot_retur_ovk_nl_awal = $hrg_barang_retur_ovk_nl_awal*$qty_retur_ovk_nl_awal;
			$Ttot_retur_ovk_nl_awal= $Ttot_retur_ovk_nl_awal+$tot_retur_ovk_nl_awal; 
		}
		$tot_retur_ovk_nl=0;
		$qjualretur_ovk_nl = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_nl' and id_barang like 'M-%' and tgl_rsap like '$all%'");
		while($djualretur_ovk_nl=mysql_fetch_assoc($qjualretur_ovk_nl))
		{
			$id_barang_retur_ovk_nl = $djualretur_ovk_nl['id_barang'];
			$qty_retur_ovk_nl = $djualretur_ovk_nl['qty'];
			//cari harga
			$qbarang_retur_ovk_nl = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_nl'");
			$dbarang_retur_ovk_nl = mysql_fetch_assoc($qbarang_retur_ovk_nl);
			$hrg_barang_retur_ovk_nl = $dbarang_retur_ovk_nl['hrg_beli'];
			
			$tot_retur_ovk_nl = $hrg_barang_retur_ovk_nl*$qty_retur_ovk_nl;
			$Ttot_retur_ovk_nl= $Ttot_retur_ovk_nl+$tot_retur_ovk_nl; 
		}
		$Total_ovk_nl = ($Ttot_ovk_nl+$Ttot_ovk_nl_awal)+($Ttot_jangka_ovk_nl+$Ttot_jangka_ovk_nl_awal)-($Ttot_retur_ovk_nl+$Ttot_retur_ovk_nl_awal);
	}
}
$Total_ovk_nl2=ribuan($Total_ovk_nl);

/* EQUIPMENT */
$qprod_eqp_nl = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL%' and id_kontrak != 'MKL.KK' order by produksi.id_produksi");
while($dprod_eqp_nl = mysql_fetch_assoc($qprod_eqp_nl))
{
	$id_produksi_eqp_nl = $dprod_eqp_nl['id_produksi'];
	//Memfilter id produksi
	$qpja_eqp_nl = mysql_query("select * from pja where id_produksi='$id_produksi_eqp_nl' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_eqp_nl = mysql_fetch_assoc($qpja_eqp_nl);
	$bpja_eqp_nl = mysql_num_rows($qpja_eqp_nl);
	if(($bpja_eqp_nl != '')or($bpja_eqp_nl != 0))
	{
		//jual
		$tot_eqp_nl_awal=0;
		$qjual_eqp_nl_awal = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_nl' and id_barang like 'E-%' and tanggal < '$all%'");
		while($djual_eqp_nl_awal=mysql_fetch_assoc($qjual_eqp_nl_awal))
		{
			$id_barang_eqp_nl_awal = $djual_eqp_nl_awal['id_barang'];
			$qty_eqp_nl_awal = $djual_eqp_nl_awal['qty'];
			//cari harga
			$qbarang_eqp_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_eqp_nl_awal'");
			$dbarang_eqp_nl_awal = mysql_fetch_assoc($qbarang_eqp_nl_awal);
			$hrg_barang_eqp_nl_awal = $dbarang_eqp_nl_awal['hrg_beli'];
			
			$tot_eqp_nl_awal = $hrg_barang_eqp_nl_awal*$qty_eqp_nl_awal;
			$Ttot_eqp_nl_awal= $Ttot_eqp_nl_awal+$tot_eqp_nl_awal; 
		}
		$tot_eqp_nl=0;
		$qjual_eqp_nl = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_nl' and id_barang like 'E-%' and tanggal like '$all%'");
		while($djual_eqp_nl=mysql_fetch_assoc($qjual_eqp_nl))
		{
			$id_barang_eqp_nl = $djual_eqp_nl['id_barang'];
			$qty_eqp_nl = $djual_eqp_nl['qty'];
			//cari harga
			$qbarang_eqp_nl = mysql_query("select * from barang where id_barang='$id_barang_eqp_nl'");
			$dbarang_eqp_nl = mysql_fetch_assoc($qbarang_eqp_nl);
			$hrg_barang_eqp_nl = $dbarang_eqp_nl['hrg_beli'];
			
			$tot_eqp_nl = $hrg_barang_eqp_nl*$qty_eqp_nl;
			$Ttot_eqp_nl= $Ttot_eqp_nl+$tot_eqp_nl; 
		}
		//jual_berjangka
		$tot_jangka_eqp_nl_awal=0;
		$qjualjangka_eqp_nl_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_nl' and approve != '' and id_barang like 'E-%' and tgl_bon < '$all%'");
		while($djualjangka_eqp_nl_awal=mysql_fetch_assoc($qjualjangka_eqp_nl_awal))
		{
			$id_barang_jangka_eqp_nl_awal = $djualjangka_eqp_nl_awal['id_barang'];
			$qty_jangka_eqp_nl_awal = $djualjangka_eqp_nl_awal['qty'];
			//cari harga
			$qbarang_jangka_eqp_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_nl_awal'");
			$dbarang_jangka_eqp_nl_awal = mysql_fetch_assoc($qbarang_jangka_eqp_nl_awal);
			$hrg_barang_jangka_eqp_nl_awal = $dbarang_jangka_eqp_nl_awal['hrg_beli'];
			
			$tot_jangka_eqp_nl_awal = $hrg_barang_jangka_eqp_nl_awal*$qty_jangka_eqp_nl_awal;
			$Ttot_jangka_eqp_nl_awal= $Ttot_jangka_eqp_nl_awal+$tot_jangka_eqp_nl_awal; 
		}
		$tot_jangka_eqp_nl=0;
		$qjualjangka_eqp_nl = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_nl' and approve != '' and id_barang like 'E-%' and tgl_bon like '$all%'");
		while($djualjangka_eqp_nl=mysql_fetch_assoc($qjualjangka_eqp_nl))
		{
			$id_barang_jangka_eqp_nl = $djualjangka_eqp_nl['id_barang'];
			$qty_jangka_eqp_nl = $djualjangka_eqp_nl['qty'];
			//cari harga
			$qbarang_jangka_eqp_nl = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_nl'");
			$dbarang_jangka_eqp_nl = mysql_fetch_assoc($qbarang_jangka_eqp_nl);
			$hrg_barang_jangka_eqp_nl = $dbarang_jangka_eqp_nl['hrg_beli'];
			
			$tot_jangka_eqp_nl = $hrg_barang_jangka_eqp_nl*$qty_jangka_eqp_nl;
			$Ttot_jangka_eqp_nl= $Ttot_jangka_eqp_nl+$tot_jangka_eqp_nl; 
		}
		//retur
		$tot_retur_eqp_nl_awal=0;
		$qjualretur_eqp_nl_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_nl' and id_barang like 'E-%' and tgl_rsap < '$all%' ");
		while($djualretur_eqp_nl_awal=mysql_fetch_assoc($qjualretur_eqp_nl_awal))
		{
			$id_barang_retur_eqp_nl_awal = $djualretur_eqp_nl_awal['id_barang'];
			$qty_retur_eqp_nl_awal = $djualretur_eqp_nl_awal['qty'];
			//cari harga
			$qbarang_retur_eqp_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_nl_awal'");
			$dbarang_retur_eqp_nl_awal = mysql_fetch_assoc($qbarang_retur_eqp_nl_awal);
			$hrg_barang_retur_eqp_nl_awal = $dbarang_retur_eqp_nl_awal['hrg_beli'];
			
			$tot_retur_eqp_nl_awal = $hrg_barang_retur_eqp_nl_awal*$qty_retur_eqp_nl_awal;
			$Ttot_retur_eqp_nl_awal= $Ttot_retur_eqp_nl_awal+$tot_retur_eqp_nl_awal; 
		}
		$tot_retur_eqp_nl=0;
		$qjualretur_eqp_nl = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_nl' and id_barang like 'E-%' and tgl_rsap like '$all%' ");
		while($djualretur_eqp_nl=mysql_fetch_assoc($qjualretur_eqp_nl))
		{
			$id_barang_retur_eqp_nl = $djualretur_eqp_nl['id_barang'];
			$qty_retur_eqp_nl = $djualretur_eqp_nl['qty'];
			//cari harga
			$qbarang_retur_eqp_nl = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_nl'");
			$dbarang_retur_eqp_nl = mysql_fetch_assoc($qbarang_retur_eqp_nl);
			$hrg_barang_retur_eqp_nl = $dbarang_retur_eqp_nl['hrg_beli'];
			
			$tot_retur_eqp_nl = $hrg_barang_retur_eqp_nl*$qty_retur_eqp_nl;
			$Ttot_retur_eqp_nl= $Ttot_retur_eqp_nl+$tot_retur_eqp_nl; 
		}
		$Total_eqp_nl = ($Ttot_eqp_nl+$Ttot_eqp_nl_awal)+($Ttot_jangka_eqp_nl+$Ttot_jangka_eqp_nl_awal)-($Ttot_retur_eqp_nl+$Ttot_retur_eqp_nl_awal);
	}
}
$Total_eqp_nl2=ribuan($Total_eqp_nl);

/* OTHER */
$qprod_oth_nl = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL%' and id_kontrak != 'MKL.KK' order by produksi.id_produksi");
while($dprod_oth_nl = mysql_fetch_assoc($qprod_oth_nl))
{
	$id_produksi_oth_nl = $dprod_oth_nl['id_produksi'];
	//Memfilter id produksi
	$qpja_oth_nl = mysql_query("select * from pja where id_produksi='$id_produksi_oth_nl' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_oth_nl = mysql_fetch_assoc($qpja_oth_nl);
	$bpja_oth_nl = mysql_num_rows($qpja_oth_nl);
	if(($bpja_oth_nl != '')or($bpja_oth_nl != 0))
	{
		//jual
		$tot_oth_nl_awal=0;
		$qjual_oth_nl_awal = mysql_query("select * from jual where id_produksi='$id_produksi_oth_nl' and id_barang like 'O-%' and tanggal < '$all%'");
		while($djual_oth_nl_awal=mysql_fetch_assoc($qjual_oth_nl_awal))
		{
			$id_barang_oth_nl_awal = $djual_oth_nl_awal['id_barang'];
			$qty_oth_nl_awal = $djual_oth_nl_awal['qty'];
			//cari harga
			$qbarang_oth_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_oth_nl_awal'");
			$dbarang_oth_nl_awal = mysql_fetch_assoc($qbarang_oth_nl_awal);
			$hrg_barang_oth_nl_awal = $dbarang_oth_nl_awal['hrg_beli'];
			
			$tot_oth_nl_awal = $hrg_barang_oth_nl_awal*$qty_oth_nl_awal;
			$Ttot_oth_nl_awal= $Ttot_oth_nl_awal+$tot_oth_nl_awal; 
		}
		$tot_oth_nl=0;
		$qjual_oth_nl = mysql_query("select * from jual where id_produksi='$id_produksi_oth_nl' and id_barang like 'O-%' and tanggal like '$all%'");
		while($djual_oth_nl=mysql_fetch_assoc($qjual_oth_nl))
		{
			$id_barang_oth_nl = $djual_oth_nl['id_barang'];
			$qty_oth_nl = $djual_oth_nl['qty'];
			//cari harga
			$qbarang_oth_nl = mysql_query("select * from barang where id_barang='$id_barang_oth_nl'");
			$dbarang_oth_nl = mysql_fetch_assoc($qbarang_oth_nl);
			$hrg_barang_oth_nl = $dbarang_oth_nl['hrg_beli'];
			
			$tot_oth_nl = $hrg_barang_oth_nl*$qty_oth_nl;
			$Ttot_oth_nl= $Ttot_oth_nl+$tot_oth_nl; 
		}
		//jual_berjangka
		$tot_jangka_oth_nl_awal=0;
		$qjualjangka_oth_nl_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_nl' and approve != '' and id_barang like 'O-%' and tgl_bon < '$all%'");
		while($djualjangka_oth_nl_awal=mysql_fetch_assoc($qjualjangka_oth_nl_awal))
		{
			$id_barang_jangka_oth_nl_awal = $djualjangka_oth_nl_awal['id_barang'];
			$qty_jangka_oth_nl_awal = $djualjangka_oth_nl_awal['qty'];
			//cari harga
			$qbarang_jangka_oth_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_nl_awal'");
			$dbarang_jangka_oth_nl_awal = mysql_fetch_assoc($qbarang_jangka_oth_nl_awal);
			$hrg_barang_jangka_oth_nl_awal = $dbarang_jangka_oth_nl_awal['hrg_beli'];
			
			$tot_jangka_oth_nl_awal = $hrg_barang_jangka_oth_nl_awal*$qty_jangka_oth_nl_awal;
			$Ttot_jangka_oth_nl_awal= $Ttot_jangka_oth_nl_awal+$tot_jangka_oth_nl_awal; 
		}
		$tot_jangka_oth_nl=0;
		$qjualjangka_oth_nl = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_nl' and approve != '' and id_barang like 'O-%' and tgl_bon like '$all%'");
		while($djualjangka_oth_nl=mysql_fetch_assoc($qjualjangka_oth_nl))
		{
			$id_barang_jangka_oth_nl = $djualjangka_oth_nl['id_barang'];
			$qty_jangka_oth_nl = $djualjangka_oth_nl['qty'];
			//cari harga
			$qbarang_jangka_oth_nl = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_nl'");
			$dbarang_jangka_oth_nl = mysql_fetch_assoc($qbarang_jangka_oth_nl);
			$hrg_barang_jangka_oth_nl = $dbarang_jangka_oth_nl['hrg_beli'];
			
			$tot_jangka_oth_nl = $hrg_barang_jangka_oth_nl*$qty_jangka_oth_nl;
			$Ttot_jangka_oth_nl= $Ttot_jangka_oth_nl+$tot_jangka_oth_nl; 
		}
		//retur
		$tot_retur_oth_nl_awal=0;
		$qjualretur_oth_nl_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_nl' and id_barang like 'O-%' and tgl_rsap < '$all%'");
		while($djualretur_oth_nl_awal=mysql_fetch_assoc($qjualretur_oth_nl_awal))
		{
			$id_barang_retur_oth_nl_awal = $djualretur_oth_nl_awal['id_barang'];
			$qty_retur_oth_nl_awal = $djualretur_oth_nl_awal['qty'];
			//cari harga
			$qbarang_retur_oth_nl_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_nl_awal'");
			$dbarang_retur_oth_nl_awal = mysql_fetch_assoc($qbarang_retur_oth_nl_awal);
			$hrg_barang_retur_oth_nl_awal = $dbarang_retur_oth_nl_awal['hrg_beli'];
			
			$tot_retur_oth_nl_awal = $hrg_barang_retur_oth_nl_awal*$qty_retur_oth_nl_awal;
			$Ttot_retur_oth_nl_awal= $Ttot_retur_oth_nl_awal+$tot_retur_oth_nl_awal; 
		}
		$tot_retur_oth_nl=0;
		$qjualretur_oth_nl = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_nl' and id_barang like 'O-%' and tgl_rsap like '$all%'");
		while($djualretur_oth_nl=mysql_fetch_assoc($qjualretur_oth_nl))
		{
			$id_barang_retur_oth_nl = $djualretur_oth_nl['id_barang'];
			$qty_retur_oth_nl = $djualretur_oth_nl['qty'];
			//cari harga
			$qbarang_retur_oth_nl = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_nl'");
			$dbarang_retur_oth_nl = mysql_fetch_assoc($qbarang_retur_oth_nl);
			$hrg_barang_retur_oth_nl = $dbarang_retur_oth_nl['hrg_beli'];
			
			$tot_retur_oth_nl = $hrg_barang_retur_oth_nl*$qty_retur_oth_nl;
			$Ttot_retur_oth_nl= $Ttot_retur_oth_nl+$tot_retur_oth_nl; 
		}
		$Total_oth_nl = ($Ttot_oth_nl+$Ttot_oth_nl_awal)+($Ttot_jangka_oth_nl+$Ttot_jangka_oth_nl_awal)-($Ttot_retur_oth_nl+$Ttot_retur_oth_nl_awal);
	}
}
$Total_oth_nl2=ribuan($Total_oth_nl);

//BOP makloon
$q_ops_mkl_awal = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'MKL%' and id_kontrak != 'MKL.KK' order by produksi.id_produksi");
while($d_ops_mkl_awal=mysql_fetch_assoc($q_ops_mkl_awal))
{
	$id_prod_ops_mkl_awal=$d_ops_mkl_awal['id_produksi']; //echo"$id_prod_ops_mkl_awal<br>";
	$q_op_ins_ternak_mkl_awal = mysql_query("select * from op_ins_ternak where id_produksi='$id_prod_ops_mkl_awal' and tanggal < '$all%'");
	$Tjml_op_ins_ternak_mkl_awal=0;
	while($d_op_ins_ternak_mkl_awal=mysql_fetch_assoc($q_op_ins_ternak_mkl_awal))
	{
		$jml_op_ins_ternak_mkl_awal=$d_op_ins_ternak_mkl_awal['jumlah'];
		$Tjml_op_ins_ternak_mkl_awal=$Tjml_op_ins_ternak_mkl_awal+$jml_op_ins_ternak_mkl_awal;
	}
	$Totjml_op_ins_ternak_mkl_awal=$Totjml_op_ins_ternak_mkl_awal+$Tjml_op_ins_ternak_mkl_awal;

	$q_op_ins_ternak_mkl = mysql_query("select * from op_ins_ternak where id_produksi='$id_prod_ops_mkl_awal' and tanggal like '$all%'");
	$Tjml_op_ins_ternak_mkl=0;
	while($d_op_ins_ternak_mkl=mysql_fetch_assoc($q_op_ins_ternak_mkl))
	{
		$jml_op_ins_ternak_mkl=$d_op_ins_ternak_mkl['jumlah'];
		$Tjml_op_ins_ternak_mkl=$Tjml_op_ins_ternak_mkl+$jml_op_ins_ternak_mkl;
	}
	$Totjml_op_ins_ternak_mkl=$Totjml_op_ins_ternak_mkl+$Tjml_op_ins_ternak_mkl;
}

$Total_persediaan_nl = $Totjml_op_ins_ternak_mkl_awal+$Totjml_op_ins_ternak_mkl+$Total_oth_nl+$Total_eqp_nl+$Total_ovk_nl+$Total_pkn_nl+$Total_doc_nl;
$Total_persediaan_nl2=ribuan($Total_persediaan_nl);

$Total_persediaan_mkl = $Total_persediaan_nl+$Total_oth_mkl+$Total_eqp_mkl+$Total_ovk_mkl+$Total_pkn_mkl+$Total_doc_mkl;
$Total_persediaan_mkl2=ribuan($Total_persediaan_mkl);
?>
<?
//===========================================PERSEDIAAN GD.KEMITRAAN===========================================\\
/* DOC */ 
$qprod_kmt = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'KMT%' order by produksi.id_produksi");
while($dprod_kmt = mysql_fetch_assoc($qprod_kmt))
{
	$id_produksi_kmt = $dprod_kmt['id_produksi'];
	//Memfilter id produksi
	$qpja_kmt = mysql_query("select * from pja where id_produksi='$id_produksi_kmt' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_kmt = mysql_fetch_assoc($qpja_kmt);
	$bpja_kmt = mysql_num_rows($qpja_kmt);
	if(($bpja_kmt == '')or($bpja_kmt == 0))
	{
		//jual
		$tot_doc_kmt_awal=0;
		$qjual_doc_kmt_awal = mysql_query("select * from jual where id_produksi='$id_produksi_kmt' and id_barang like 'D-%' and tanggal < '$all%' ");
		while($djual_doc_kmt_awal=mysql_fetch_assoc($qjual_doc_kmt_awal))
		{
			$id_barang_doc_kmt_awal = $djual_doc_kmt_awal['id_barang'];
			$qty_doc_kmt_awal = $djual_doc_kmt_awal['qty'];
			//cari harga
			$qbarang_doc_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_doc_kmt_awal'");
			$dbarang_doc_kmt_awal = mysql_fetch_assoc($qbarang_doc_kmt_awal);
			$hrg_barang_doc_kmt_awal = $dbarang_doc_kmt_awal['hrg_beli'];
			
			$tot_doc_kmt_awal = $hrg_barang_doc_kmt_awal*$qty_doc_kmt_awal;
			$Ttot_doc_kmt_awal= $Ttot_doc_kmt_awal+$tot_doc_kmt_awal; 
			
		}
		$tot_doc_kmt=0;
		$qjual_doc_kmt = mysql_query("select * from jual where id_produksi='$id_produksi_kmt' and id_barang like 'D-%' and tanggal like '$all%' ");
		while($djual_doc_kmt=mysql_fetch_assoc($qjual_doc_kmt))
		{
			$id_barang_doc_kmt = $djual_doc_kmt['id_barang'];
			$qty_doc_kmt = $djual_doc_kmt['qty'];
			//cari harga
			$qbarang_doc_kmt = mysql_query("select * from barang where id_barang='$id_barang_doc_kmt'");
			$dbarang_doc_kmt = mysql_fetch_assoc($qbarang_doc_kmt);
			$hrg_barang_doc_kmt = $dbarang_doc_kmt['hrg_beli'];
			
			$tot_doc_kmt = $hrg_barang_doc_kmt*$qty_doc_kmt;
			$Ttot_doc_kmt= $Ttot_doc_kmt+$tot_doc_kmt; 
			
		}
		//jual_berjangka
		$tot_jangka_doc_kmt_awal=0;
		$qjualjangka_doc_kmt_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_kmt' and approve != '' and id_barang like 'D-%' and tgl_bon < '$all%' ");
		while($djualjangka_doc_kmt_awal=mysql_fetch_assoc($qjualjangka_doc_kmt_awal))
		{
			$id_barang_jangka_doc_kmt_awal = $djualjangka_doc_kmt_awal['id_barang'];
			$qty_jangka_doc_kmt_awal = $djualjangka_doc_kmt_awal['qty'];
			//cari harga
			$qbarang_jangka_doc_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_kmt_awal'");
			$dbarang_jangka_doc_kmt_awal = mysql_fetch_assoc($qbarang_jangka_doc_kmt_awal);
			$hrg_barang_jangka_doc_kmt_awal = $dbarang_jangka_doc_kmt_awal['hrg_beli'];
			
			$tot_jangka_doc_kmt_awal = $hrg_barang_jangka_doc_kmt_awal*$qty_jangka_doc_kmt_awal;
			$Ttot_jangka_doc_kmt_awal= $Ttot_jangka_doc_kmt_awal+$tot_jangka_doc_kmt_awal; 
			
		}

		$tot_jangka_doc_kmt=0;
		$qjualjangka_doc_kmt = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_kmt' and approve != '' and id_barang like 'D-%' and tgl_bon like '$all%' ");
		while($djualjangka_doc_kmt=mysql_fetch_assoc($qjualjangka_doc_kmt))
		{
			$id_barang_jangka_doc_kmt = $djualjangka_doc_kmt['id_barang'];
			$qty_jangka_doc_kmt = $djualjangka_doc_kmt['qty'];
			//cari harga
			$qbarang_jangka_doc_kmt = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_kmt'");
			$dbarang_jangka_doc_kmt = mysql_fetch_assoc($qbarang_jangka_doc_kmt);
			$hrg_barang_jangka_doc_kmt = $dbarang_jangka_doc_kmt['hrg_beli'];
			
			$tot_jangka_doc_kmt = $hrg_barang_jangka_doc_kmt*$qty_jangka_doc_kmt;
			$Ttot_jangka_doc_kmt= $Ttot_jangka_doc_kmt+$tot_jangka_doc_kmt; 
			
		}
		//retur
		$tot_retur_doc_kmt_awal=0;
		$qjualretur_doc_kmt_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_kmt' and id_barang like 'D-%' and tgl_rsap < '$all%'");
		while($djualretur_doc_kmt_awal=mysql_fetch_assoc($qjualretur_doc_kmt_awal))
		{
			$id_barang_retur_doc_kmt_awal = $djualretur_doc_kmt_awal['id_barang'];
			$qty_retur_doc_kmt_awal = $djualretur_doc_kmt_awal['qty'];
			//cari harga
			$qbarang_retur_doc_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_kmt_awal'");
			$dbarang_retur_doc_kmt_awal = mysql_fetch_assoc($qbarang_retur_doc_kmt_awal);
			$hrg_barang_retur_doc_kmt_awal = $dbarang_retur_doc_kmt_awal['hrg_beli'];
			
			$tot_retur_doc_kmt_awal = $hrg_barang_retur_doc_kmt_awal*$qty_retur_doc_kmt_awal;
			$Ttot_retur_doc_kmt_awal= $Ttot_retur_doc_kmt_awal+$tot_retur_doc_kmt_awal; 
		}
		$tot_retur_doc_kmt=0;
		$qjualretur_doc_kmt = mysql_query("select * from retur_jual where id_produksi='$id_produksi_kmt' and id_barang like 'D-%' and tgl_rsap like '$all%'");
		while($djualretur_doc_kmt=mysql_fetch_assoc($qjualretur_doc_kmt))
		{
			$id_barang_retur_doc_kmt = $djualretur_doc_kmt['id_barang'];
			$qty_retur_doc_kmt = $djualretur_doc_kmt['qty'];
			//cari harga
			$qbarang_retur_doc_kmt = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_kmt'");
			$dbarang_retur_doc_kmt = mysql_fetch_assoc($qbarang_retur_doc_kmt);
			$hrg_barang_retur_doc_kmt = $dbarang_retur_doc_kmt['hrg_beli'];
			
			$tot_retur_doc_kmt = $hrg_barang_retur_doc_kmt*$qty_retur_doc_kmt;
			$Ttot_retur_doc_kmt= $Ttot_retur_doc_kmt+$tot_retur_doc_kmt; 
		}
		$Total_doc_kmt = ($Ttot_doc_kmt+$Ttot_doc_kmt_awal)+($Ttot_jangka_doc_kmt+$Ttot_jangka_doc_kmt_awal)-($Ttot_retur_doc_kmt+$Ttot_retur_doc_kmt_awal);
	}
}
$Total_doc_kmt2=ribuan($Total_doc_kmt);

/* PAKAN */
$qprod_pkn_kmt = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'KMT%' order by produksi.id_produksi");
while($dprod_pkn_kmt = mysql_fetch_assoc($qprod_pkn_kmt))
{
	$id_produksi_pkn_kmt = $dprod_pkn_kmt['id_produksi'];
	//Memfilter id produksi
	$qpja_pkn_kmt = mysql_query("select * from pja where id_produksi='$id_produksi_pkn_kmt' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_pkn_kmt = mysql_fetch_assoc($qpja_pkn_kmt);
	$bpja_pkn_kmt = mysql_num_rows($qpja_pkn_kmt);
	if(($bpja_pkn_kmt == '')or($bpja_pkn_kmt == 0))
	{
		//jual
		$tot_pkn_kmt_awal=0;
		$qjual_pkn_kmt_awal = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_kmt' and id_barang like 'F-%' and tanggal < '$all%' ");
		while($djual_pkn_kmt_awal=mysql_fetch_assoc($qjual_pkn_kmt_awal))
		{
			$id_barang_pkn_kmt_awal = $djual_pkn_kmt_awal['id_barang'];
			$qty_pkn_kmt_awal = $djual_pkn_kmt_awal['qty'];
			//cari harga
			$qbarang_pkn_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_pkn_kmt_awal'");
			$dbarang_pkn_kmt_awal = mysql_fetch_assoc($qbarang_pkn_kmt_awal);
			$hrg_barang_pkn_kmt_awal = $dbarang_pkn_kmt_awal['hrg_beli'];
			
			$tot_pkn_kmt_awal = $hrg_barang_pkn_kmt_awal*$qty_pkn_kmt_awal;
			$Ttot_pkn_kmt_awal= $Ttot_pkn_kmt_awal+$tot_pkn_kmt_awal; 
		}
		$tot_pkn_kmt=0;
		$qjual_pkn_kmt = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_kmt' and id_barang like 'F-%' and tanggal like '$all%' ");
		while($djual_pkn_kmt=mysql_fetch_assoc($qjual_pkn_kmt))
		{
			$id_barang_pkn_kmt = $djual_pkn_kmt['id_barang'];
			$qty_pkn_kmt = $djual_pkn_kmt['qty'];
			//cari harga
			$qbarang_pkn_kmt = mysql_query("select * from barang where id_barang='$id_barang_pkn_kmt'");
			$dbarang_pkn_kmt = mysql_fetch_assoc($qbarang_pkn_kmt);
			$hrg_barang_pkn_kmt = $dbarang_pkn_kmt['hrg_beli'];
			
			$tot_pkn_kmt = $hrg_barang_pkn_kmt*$qty_pkn_kmt;
			$Ttot_pkn_kmt= $Ttot_pkn_kmt+$tot_pkn_kmt; 
		}
		//jual_berjangka
		$tot_jangka_pkn_kmt_awal=0;
		$qjualjangka_pkn_kmt_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_kmt' and approve != '' and id_barang like 'F-%' and tgl_bon < '$all%'");
		while($djualjangka_pkn_kmt_awal=mysql_fetch_assoc($qjualjangka_pkn_kmt_awal))
		{
			$id_barang_jangka_pkn_kmt_awal = $djualjangka_pkn_kmt_awal['id_barang'];
			$qty_jangka_pkn_kmt_awal = $djualjangka_pkn_kmt_awal['qty'];
			//cari harga
			$qbarang_jangka_pkn_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_kmt_awal'");
			$dbarang_jangka_pkn_kmt_awal = mysql_fetch_assoc($qbarang_jangka_pkn_kmt_awal);
			$hrg_barang_jangka_pkn_kmt_awal = $dbarang_jangka_pkn_kmt_awal['hrg_beli'];
			
			$tot_jangka_pkn_kmt_awal = $hrg_barang_jangka_pkn_kmt_awal*$qty_jangka_pkn_kmt_awal;
			$Ttot_jangka_pkn_kmt_awal= $Ttot_jangka_pkn_kmt_awal+$tot_jangka_pkn_kmt_awal; 
			
		}
		$tot_jangka_pkn_kmt=0;
		$qjualjangka_pkn_kmt = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_kmt' and approve != '' and id_barang like 'F-%' and tgl_bon like '$all%'");
		while($djualjangka_pkn_kmt=mysql_fetch_assoc($qjualjangka_pkn_kmt))
		{
			$id_barang_jangka_pkn_kmt = $djualjangka_pkn_kmt['id_barang'];
			$qty_jangka_pkn_kmt = $djualjangka_pkn_kmt['qty'];
			//cari harga
			$qbarang_jangka_pkn_kmt = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_kmt'");
			$dbarang_jangka_pkn_kmt = mysql_fetch_assoc($qbarang_jangka_pkn_kmt);
			$hrg_barang_jangka_pkn_kmt = $dbarang_jangka_pkn_kmt['hrg_beli'];
			
			$tot_jangka_pkn_kmt = $hrg_barang_jangka_pkn_kmt*$qty_jangka_pkn_kmt;
			$Ttot_jangka_pkn_kmt= $Ttot_jangka_pkn_kmt+$tot_jangka_pkn_kmt; 
			
		}
		//retur
		$tot_retur_pkn_kmt_awal=0;
		$qjualretur_pkn_kmt_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_kmt' and id_barang like 'F-%' and tgl_rsap < '$all%'");
		while($djualretur_pkn_kmt_awal=mysql_fetch_assoc($qjualretur_pkn_kmt_awal))
		{
			$id_barang_retur_pkn_kmt_awal = $djualretur_pkn_kmt_awal['id_barang'];
			$qty_retur_pkn_kmt_awal = $djualretur_pkn_kmt_awal['qty'];
			//cari harga
			$qbarang_retur_pkn_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_kmt_awal'");
			$dbarang_retur_pkn_kmt_awal = mysql_fetch_assoc($qbarang_retur_pkn_kmt_awal);
			$hrg_barang_retur_pkn_kmt_awal = $dbarang_retur_pkn_kmt_awal['hrg_beli'];
			
			$tot_retur_pkn_kmt_awal = $hrg_barang_retur_pkn_kmt_awal*$qty_retur_pkn_kmt_awal;
			$Ttot_retur_pkn_kmt_awal= $Ttot_retur_pkn_kmt_awal+$tot_retur_pkn_kmt_awal; 
		}
		$tot_retur_pkn_kmt=0;
		$qjualretur_pkn_kmt = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_kmt' and id_barang like 'F-%' and tgl_rsap like '$all%'");
		while($djualretur_pkn_kmt=mysql_fetch_assoc($qjualretur_pkn_kmt))
		{
			$id_barang_retur_pkn_kmt = $djualretur_pkn_kmt['id_barang'];
			$qty_retur_pkn_kmt = $djualretur_pkn_kmt['qty'];
			//cari harga
			$qbarang_retur_pkn_kmt = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_kmt'");
			$dbarang_retur_pkn_kmt = mysql_fetch_assoc($qbarang_retur_pkn_kmt);
			$hrg_barang_retur_pkn_kmt = $dbarang_retur_pkn_kmt['hrg_beli'];
			
			$tot_retur_pkn_kmt = $hrg_barang_retur_pkn_kmt*$qty_retur_pkn_kmt;
			$Ttot_retur_pkn_kmt= $Ttot_retur_pkn_kmt+$tot_retur_pkn_kmt; 
		}
		$Total_pkn_kmt = ($Ttot_pkn_kmt+$Ttot_pkn_kmt_awal)+($Ttot_jangka_pkn_kmt+$Ttot_jangka_pkn_kmt_awal)-($Ttot_retur_pkn_kmt+$Ttot_retur_pkn_kmt_awal);
	}
}
$Total_pkn_kmt2=ribuan($Total_pkn_kmt);

/* OVK */
$qprod_ovk_kmt = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'KMT%' order by produksi.id_produksi");
while($dprod_ovk_kmt = mysql_fetch_assoc($qprod_ovk_kmt))
{
	$id_produksi_ovk_kmt = $dprod_ovk_kmt['id_produksi'];
	//Memfilter id produksi
	$qpja_ovk_kmt = mysql_query("select * from pja where id_produksi='$id_produksi_ovk_kmt' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_ovk_kmt = mysql_fetch_assoc($qpja_ovk_kmt);
	$bpja_ovk_kmt = mysql_num_rows($qpja_ovk_kmt);
	if(($bpja_ovk_kmt == '')or($bpja_ovk_kmt == 0))
	{
		//jual
		$tot_ovk_kmt_awal=0;
		$qjual_ovk_kmt_awal = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_kmt' and id_barang like 'M-%' and tanggal < '$all%' ");
		while($djual_ovk_kmt_awal=mysql_fetch_assoc($qjual_ovk_kmt_awal))
		{
			$id_barang_ovk_kmt_awal = $djual_ovk_kmt_awal['id_barang'];
			$qty_ovk_kmt_awal = $djual_ovk_kmt_awal['qty'];
			//cari harga
			$qbarang_ovk_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_ovk_kmt_awal'");
			$dbarang_ovk_kmt_awal = mysql_fetch_assoc($qbarang_ovk_kmt_awal);
			$hrg_barang_ovk_kmt_awal = $dbarang_ovk_kmt_awal['hrg_beli'];
			
			$tot_ovk_kmt_awal = $hrg_barang_ovk_kmt_awal*$qty_ovk_kmt_awal;
			$Ttot_ovk_kmt_awal= $Ttot_ovk_kmt_awal+$tot_ovk_kmt_awal; 
		}
		$tot_ovk_kmt=0;
		$qjual_ovk_kmt = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_kmt' and id_barang like 'M-%' and tanggal like '$all%' ");
		while($djual_ovk_kmt=mysql_fetch_assoc($qjual_ovk_kmt))
		{
			$id_barang_ovk_kmt = $djual_ovk_kmt['id_barang'];
			$qty_ovk_kmt = $djual_ovk_kmt['qty'];
			//cari harga
			$qbarang_ovk_kmt = mysql_query("select * from barang where id_barang='$id_barang_ovk_kmt'");
			$dbarang_ovk_kmt = mysql_fetch_assoc($qbarang_ovk_kmt);
			$hrg_barang_ovk_kmt = $dbarang_ovk_kmt['hrg_beli'];
			
			$tot_ovk_kmt = $hrg_barang_ovk_kmt*$qty_ovk_kmt;
			$Ttot_ovk_kmt= $Ttot_ovk_kmt+$tot_ovk_kmt; 
		}
		//jual_berjangka
		$tot_jangka_ovk_kmt_awal=0;
		$qjualjangka_ovk_kmt_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_kmt' and approve != '' and id_barang like 'M-%' and tgl_bon < '$all%'");
		while($djualjangka_ovk_kmt_awal=mysql_fetch_assoc($qjualjangka_ovk_kmt_awal))
		{
			$id_barang_jangka_ovk_kmt_awal = $djualjangka_ovk_kmt_awal['id_barang'];
			$qty_jangka_ovk_kmt_awal = $djualjangka_ovk_kmt_awal['qty'];
			//cari harga
			$qbarang_jangka_ovk_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_kmt_awal'");
			$dbarang_jangka_ovk_kmt_awal = mysql_fetch_assoc($qbarang_jangka_ovk_kmt_awal);
			$hrg_barang_jangka_ovk_kmt_awal = $dbarang_jangka_ovk_kmt_awal['hrg_beli'];
			
			$tot_jangka_ovk_kmt_awal = $hrg_barang_jangka_ovk_kmt_awal*$qty_jangka_ovk_kmt_awal;
			$Ttot_jangka_ovk_kmt_awal= $Ttot_jangka_ovk_kmt_awal+$tot_jangka_ovk_kmt_awal; 
			
		}
		$tot_jangka_ovk_kmt=0;
		$qjualjangka_ovk_kmt = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_kmt' and approve != '' and id_barang like 'M-%' and tgl_bon like '$all%'");
		while($djualjangka_ovk_kmt=mysql_fetch_assoc($qjualjangka_ovk_kmt))
		{
			$id_barang_jangka_ovk_kmt = $djualjangka_ovk_kmt['id_barang'];
			$qty_jangka_ovk_kmt = $djualjangka_ovk_kmt['qty'];
			//cari harga
			$qbarang_jangka_ovk_kmt = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_kmt'");
			$dbarang_jangka_ovk_kmt = mysql_fetch_assoc($qbarang_jangka_ovk_kmt);
			$hrg_barang_jangka_ovk_kmt = $dbarang_jangka_ovk_kmt['hrg_beli'];
			
			$tot_jangka_ovk_kmt = $hrg_barang_jangka_ovk_kmt*$qty_jangka_ovk_kmt;
			$Ttot_jangka_ovk_kmt= $Ttot_jangka_ovk_kmt+$tot_jangka_ovk_kmt; 
		}
		//retur
		$tot_retur_ovk_kmt_awal=0;
		$qjualretur_ovk_kmt_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_kmt' and id_barang like 'M-%' and tgl_rsap < '$all%' ");
		while($djualretur_ovk_kmt_awal=mysql_fetch_assoc($qjualretur_ovk_kmt_awal))
		{
			$id_barang_retur_ovk_kmt_awal = $djualretur_ovk_kmt_awal['id_barang'];
			$qty_retur_ovk_kmt_awal = $djualretur_ovk_kmt_awal['qty'];
			//cari harga
			$qbarang_retur_ovk_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_kmt_awal'");
			$dbarang_retur_ovk_kmt_awal = mysql_fetch_assoc($qbarang_retur_ovk_kmt_awal);
			$hrg_barang_retur_ovk_kmt_awal = $dbarang_retur_ovk_kmt_awal['hrg_beli'];
			
			$tot_retur_ovk_kmt_awal = $hrg_barang_retur_ovk_kmt_awal*$qty_retur_ovk_kmt_awal;
			$Ttot_retur_ovk_kmt_awal= $Ttot_retur_ovk_kmt_awal+$tot_retur_ovk_kmt_awal; 
		}
		$tot_retur_ovk_kmt=0;
		$qjualretur_ovk_kmt = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_kmt' and id_barang like 'M-%' and tgl_rsap like '$all%' ");
		while($djualretur_ovk_kmt=mysql_fetch_assoc($qjualretur_ovk_kmt))
		{
			$id_barang_retur_ovk_kmt = $djualretur_ovk_kmt['id_barang'];
			$qty_retur_ovk_kmt = $djualretur_ovk_kmt['qty'];
			//cari harga
			$qbarang_retur_ovk_kmt = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_kmt'");
			$dbarang_retur_ovk_kmt = mysql_fetch_assoc($qbarang_retur_ovk_kmt);
			$hrg_barang_retur_ovk_kmt = $dbarang_retur_ovk_kmt['hrg_beli'];
			
			$tot_retur_ovk_kmt = $hrg_barang_retur_ovk_kmt*$qty_retur_ovk_kmt;
			$Ttot_retur_ovk_kmt= $Ttot_retur_ovk_kmt+$tot_retur_ovk_kmt; 
		}
		$Total_ovk_kmt = ($Ttot_ovk_kmt+$Ttot_ovk_kmt_awal)+($Ttot_jangka_ovk_kmt+$Ttot_jangka_ovk_kmt_awal)-($Ttot_retur_ovk_kmt+$Ttot_retur_ovk_kmt_awal);
	}
}
$Total_ovk_kmt2=ribuan($Total_ovk_kmt);

/* EQUIPMENT */
$qprod_eqp_kmt = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'KMT%' order by produksi.id_produksi");
while($dprod_eqp_kmt = mysql_fetch_assoc($qprod_eqp_kmt))
{
	$id_produksi_eqp_kmt = $dprod_eqp_kmt['id_produksi'];
	//Memfilter id produksi
	$qpja_eqp_kmt = mysql_query("select * from pja where id_produksi='$id_produksi_eqp_kmt' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_eqp_kmt = mysql_fetch_assoc($qpja_eqp_kmt);
	$bpja_eqp_kmt = mysql_num_rows($qpja_eqp_kmt);
	if(($bpja_eqp_kmt == '')or($bpja_eqp_kmt == 0))
	{
		//jual
		$tot_eqp_kmt_awal=0;
		$qjual_eqp_kmt_awal = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_kmt' and id_barang like 'E-%' and tanggal < '$all%' ");
		while($djual_eqp_kmt_awal=mysql_fetch_assoc($qjual_eqp_kmt_awal))
		{
			$id_barang_eqp_kmt_awal = $djual_eqp_kmt_awal['id_barang'];
			$qty_eqp_kmt_awal = $djual_eqp_kmt_awal['qty'];
			//cari harga
			$qbarang_eqp_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_eqp_kmt_awal'");
			$dbarang_eqp_kmt_awal = mysql_fetch_assoc($qbarang_eqp_kmt_awal);
			$hrg_barang_eqp_kmt_awal = $dbarang_eqp_kmt_awal['hrg_beli'];
			
			$tot_eqp_kmt_awal = $hrg_barang_eqp_kmt_awal*$qty_eqp_kmt_awal;
			$Ttot_eqp_kmt_awal= $Ttot_eqp_kmt_awal+$tot_eqp_kmt_awal; 
		}
		$tot_eqp_kmt=0;
		$qjual_eqp_kmt = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_kmt' and id_barang like 'E-%' and tanggal like '$all%' ");
		while($djual_eqp_kmt=mysql_fetch_assoc($qjual_eqp_kmt))
		{
			$id_barang_eqp_kmt = $djual_eqp_kmt['id_barang'];
			$qty_eqp_kmt = $djual_eqp_kmt['qty'];
			//cari harga
			$qbarang_eqp_kmt = mysql_query("select * from barang where id_barang='$id_barang_eqp_kmt'");
			$dbarang_eqp_kmt = mysql_fetch_assoc($qbarang_eqp_kmt);
			$hrg_barang_eqp_kmt = $dbarang_eqp_kmt['hrg_beli'];
			
			$tot_eqp_kmt = $hrg_barang_eqp_kmt*$qty_eqp_kmt;
			$Ttot_eqp_kmt= $Ttot_eqp_kmt+$tot_eqp_kmt; 
		}
		//jual_berjangka
		$tot_jangka_eqp_kmt_awal=0;
		$qjualjangka_eqp_kmt_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_kmt' and approve != '' and id_barang like 'E-%' and tgl_bon < '$all%'");
		while($djualjangka_eqp_kmt_awal=mysql_fetch_assoc($qjualjangka_eqp_kmt_awal))
		{
			$id_barang_jangka_eqp_kmt_awal = $djualjangka_eqp_kmt_awal['id_barang'];
			$qty_jangka_eqp_kmt_awal = $djualjangka_eqp_kmt_awal['qty'];
			//cari harga
			$qbarang_jangka_eqp_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_kmt_awal'");
			$dbarang_jangka_eqp_kmt_awal = mysql_fetch_assoc($qbarang_jangka_eqp_kmt_awal);
			$hrg_barang_jangka_eqp_kmt_awal = $dbarang_jangka_eqp_kmt_awal['hrg_beli'];
			
			$tot_jangka_eqp_kmt_awal = $hrg_barang_jangka_eqp_kmt_awal*$qty_jangka_eqp_kmt_awal;
			$Ttot_jangka_eqp_kmt_awal= $Ttot_jangka_eqp_kmt_awal+$tot_jangka_eqp_kmt_awal; 
		}
		$tot_jangka_eqp_kmt=0;
		$qjualjangka_eqp_kmt = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_kmt' and approve != '' and id_barang like 'E-%' and tgl_bon like '$all%'");
		while($djualjangka_eqp_kmt=mysql_fetch_assoc($qjualjangka_eqp_kmt))
		{
			$id_barang_jangka_eqp_kmt = $djualjangka_eqp_kmt['id_barang'];
			$qty_jangka_eqp_kmt = $djualjangka_eqp_kmt['qty'];
			//cari harga
			$qbarang_jangka_eqp_kmt = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_kmt'");
			$dbarang_jangka_eqp_kmt = mysql_fetch_assoc($qbarang_jangka_eqp_kmt);
			$hrg_barang_jangka_eqp_kmt = $dbarang_jangka_eqp_kmt['hrg_beli'];
			
			$tot_jangka_eqp_kmt = $hrg_barang_jangka_eqp_kmt*$qty_jangka_eqp_kmt;
			$Ttot_jangka_eqp_kmt= $Ttot_jangka_eqp_kmt+$tot_jangka_eqp_kmt; 
		}
		//retur
		$tot_retur_eqp_kmt_awal=0;
		$qjualretur_eqp_kmt_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_kmt' and id_barang like 'E-%' and tgl_rsap < '$all%'");
		while($djualretur_eqp_kmt_awal=mysql_fetch_assoc($qjualretur_eqp_kmt_awal))
		{
			$id_barang_retur_eqp_kmt_awal = $djualretur_eqp_kmt_awal['id_barang'];
			$qty_retur_eqp_kmt_awal = $djualretur_eqp_kmt_awal['qty'];
			//cari harga
			$qbarang_retur_eqp_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_kmt_awal'");
			$dbarang_retur_eqp_kmt_awal = mysql_fetch_assoc($qbarang_retur_eqp_kmt_awal);
			$hrg_barang_retur_eqp_kmt_awal = $dbarang_retur_eqp_kmt_awal['hrg_beli'];
			
			$tot_retur_eqp_kmt_awal = $hrg_barang_retur_eqp_kmt_awal*$qty_retur_eqp_kmt_awal;
			$Ttot_retur_eqp_kmt_awal= $Ttot_retur_eqp_kmt_awal+$tot_retur_eqp_kmt_awal; 
		}
		$tot_retur_eqp_kmt=0;
		$qjualretur_eqp_kmt = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_kmt' and id_barang like 'E-%' and tgl_rsap like '$all%'");
		while($djualretur_eqp_kmt=mysql_fetch_assoc($qjualretur_eqp_kmt))
		{
			$id_barang_retur_eqp_kmt = $djualretur_eqp_kmt['id_barang'];
			$qty_retur_eqp_kmt = $djualretur_eqp_kmt['qty'];
			//cari harga
			$qbarang_retur_eqp_kmt = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_kmt'");
			$dbarang_retur_eqp_kmt = mysql_fetch_assoc($qbarang_retur_eqp_kmt);
			$hrg_barang_retur_eqp_kmt = $dbarang_retur_eqp_kmt['hrg_beli'];
			
			$tot_retur_eqp_kmt = $hrg_barang_retur_eqp_kmt*$qty_retur_eqp_kmt;
			$Ttot_retur_eqp_kmt= $Ttot_retur_eqp_kmt+$tot_retur_eqp_kmt; 
		}
		$Total_eqp_kmt = ($Ttot_eqp_kmt+$Ttot_eqp_kmt_awal)+($Ttot_jangka_eqp_kmt+$Ttot_jangka_eqp_kmt_awal)-($Ttot_retur_eqp_kmt+$Ttot_retur_eqp_kmt_awal);
	}
}
$Total_eqp_kmt2=ribuan($Total_eqp_kmt);

/* OTHER */
$qprod_oth_kmt = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'KMT%' order by produksi.id_produksi");
while($dprod_oth_kmt = mysql_fetch_assoc($qprod_oth_kmt))
{
	$id_produksi_oth_kmt = $dprod_oth_kmt['id_produksi'];
	//Memfilter id produksi
	$qpja_oth_kmt = mysql_query("select * from pja where id_produksi='$id_produksi_oth_kmt' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_oth_kmt = mysql_fetch_assoc($qpja_oth_kmt);
	$bpja_oth_kmt = mysql_num_rows($qpja_oth_kmt);
	if(($bpja_oth_kmt == '')or($bpja_oth_kmt == 0))
	{
		//jual
		$tot_oth_kmt_awal=0;
		$qjual_oth_kmt_awal = mysql_query("select * from jual where id_produksi='$id_produksi_oth_kmt' and id_barang like 'O-%' and tanggal < '$all%' ");
		while($djual_oth_kmt_awal=mysql_fetch_assoc($qjual_oth_kmt_awal))
		{
			$id_barang_oth_kmt_awal = $djual_oth_kmt_awal['id_barang'];
			$qty_oth_kmt_awal = $djual_oth_kmt_awal['qty'];
			//cari harga
			$qbarang_oth_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_oth_kmt_awal'");
			$dbarang_oth_kmt_awal = mysql_fetch_assoc($qbarang_oth_kmt_awal);
			$hrg_barang_oth_kmt_awal = $dbarang_oth_kmt_awal['hrg_beli'];
			
			$tot_oth_kmt_awal = $hrg_barang_oth_kmt_awal*$qty_oth_kmt_awal;
			$Ttot_oth_kmt_awal= $Ttot_oth_kmt_awal+$tot_oth_kmt_awal; 
		}
		$tot_oth_kmt=0;
		$qjual_oth_kmt = mysql_query("select * from jual where id_produksi='$id_produksi_oth_kmt' and id_barang like 'O-%' and tanggal like '$all%' ");
		while($djual_oth_kmt=mysql_fetch_assoc($qjual_oth_kmt))
		{
			$id_barang_oth_kmt = $djual_oth_kmt['id_barang'];
			$qty_oth_kmt = $djual_oth_kmt['qty'];
			//cari harga
			$qbarang_oth_kmt = mysql_query("select * from barang where id_barang='$id_barang_oth_kmt'");
			$dbarang_oth_kmt = mysql_fetch_assoc($qbarang_oth_kmt);
			$hrg_barang_oth_kmt = $dbarang_oth_kmt['hrg_beli'];
			
			$tot_oth_kmt = $hrg_barang_oth_kmt*$qty_oth_kmt;
			$Ttot_oth_kmt= $Ttot_oth_kmt+$tot_oth_kmt; 
		}
		//jual_berjangka
		$tot_jangka_oth_kmt_awal=0;
		$qjualjangka_oth_kmt_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_kmt' and approve != '' and id_barang like 'O-%' and tgl_bon < '$all%'");
		
		while($djualjangka_oth_kmt_awal=mysql_fetch_assoc($qjualjangka_oth_kmt_awal))
		{
			$id_barang_jangka_oth_kmt_awal = $djualjangka_oth_kmt_awal['id_barang'];
			$qty_jangka_oth_kmt_awal = $djualjangka_oth_kmt_awal['qty'];
			//cari harga
			$qbarang_jangka_oth_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_kmt_awal'");
			$dbarang_jangka_oth_kmt_awal = mysql_fetch_assoc($qbarang_jangka_oth_kmt_awal);
			$hrg_barang_jangka_oth_kmt_awal = $dbarang_jangka_oth_kmt_awal['hrg_beli'];
			
			$tot_jangka_oth_kmt_awal = $hrg_barang_jangka_oth_kmt_awal*$qty_jangka_oth_kmt_awal;
			$Ttot_jangka_oth_kmt_awal= $Ttot_jangka_oth_kmt_awal+$tot_jangka_oth_kmt_awal; 
		}
		$tot_jangka_oth_kmt=0;
		$qjualjangka_oth_kmt = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_kmt' and approve != '' and id_barang like 'O-%' and tgl_bon like '$all%'");
		while($djualjangka_oth_kmt=mysql_fetch_assoc($qjualjangka_oth_kmt))
		{
			$id_barang_jangka_oth_kmt = $djualjangka_oth_kmt['id_barang'];
			$qty_jangka_oth_kmt = $djualjangka_oth_kmt['qty'];
			//cari harga
			$qbarang_jangka_oth_kmt = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_kmt'");
			$dbarang_jangka_oth_kmt = mysql_fetch_assoc($qbarang_jangka_oth_kmt);
			$hrg_barang_jangka_oth_kmt = $dbarang_jangka_oth_kmt['hrg_beli'];
			
			$tot_jangka_oth_kmt = $hrg_barang_jangka_oth_kmt*$qty_jangka_oth_kmt;
			$Ttot_jangka_oth_kmt= $Ttot_jangka_oth_kmt+$tot_jangka_oth_kmt; 
		}
		//retur
		$tot_retur_oth_kmt_awal=0;
		$qjualretur_oth_kmt_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_kmt' and id_barang like 'O-%' and tgl_rsap < '$all%' ");
		while($djualretur_oth_kmt_awal=mysql_fetch_assoc($qjualretur_oth_kmt_awal))
		{
			$id_barang_retur_oth_kmt_awal = $djualretur_oth_kmt_awal['id_barang'];
			$qty_retur_oth_kmt_awal = $djualretur_oth_kmt_awal['qty'];
			//cari harga
			$qbarang_retur_oth_kmt_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_kmt_awal'");
			$dbarang_retur_oth_kmt_awal = mysql_fetch_assoc($qbarang_retur_oth_kmt_awal);
			$hrg_barang_retur_oth_kmt_awal = $dbarang_retur_oth_kmt_awal['hrg_beli'];
			
			$tot_retur_oth_kmt_awal = $hrg_barang_retur_oth_kmt_awal*$qty_retur_oth_kmt_awal;
			$Ttot_retur_oth_kmt_awal= $Ttot_retur_oth_kmt_awal+$tot_retur_oth_kmt_awal; 
		}
		$tot_retur_oth_kmt=0;
		$qjualretur_oth_kmt = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_kmt' and id_barang like 'O-%' and tgl_rsap like '$all%' ");
		while($djualretur_oth_kmt=mysql_fetch_assoc($qjualretur_oth_kmt))
		{
			$id_barang_retur_oth_kmt = $djualretur_oth_kmt['id_barang'];
			$qty_retur_oth_kmt = $djualretur_oth_kmt['qty'];
			//cari harga
			$qbarang_retur_oth_kmt = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_kmt'");
			$dbarang_retur_oth_kmt = mysql_fetch_assoc($qbarang_retur_oth_kmt);
			$hrg_barang_retur_oth_kmt = $dbarang_retur_oth_kmt['hrg_beli'];
			
			$tot_retur_oth_kmt = $hrg_barang_retur_oth_kmt*$qty_retur_oth_kmt;
			$Ttot_retur_oth_kmt= $Ttot_retur_oth_kmt+$tot_retur_oth_kmt; 
		}
		$Total_oth_kmt = ($Ttot_oth_kmt+$Ttot_oth_kmt_awal)+($Ttot_jangka_oth_kmt+$Ttot_jangka_oth_kmt_awal)-($Ttot_retur_oth_kmt+$Ttot_retur_oth_kmt_awal);
	}
}
$Total_oth_kmt2=ribuan($Total_oth_kmt);

/* HPP ADP KMT */ 
/* DOC */
$qprod_nk = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'KMT%' order by produksi.id_produksi");
while($dprod_nk = mysql_fetch_assoc($qprod_nk))
{
	$id_produksi_nk = $dprod_nk['id_produksi'];
	//Memfilter id produksi
	$qpja_nk = mysql_query("select * from pja where id_produksi='$id_produksi_nk' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_nk = mysql_fetch_assoc($qpja_nk);
	$bpja_nk = mysql_num_rows($qpja_nk);
	if(($bpja_nk != '')or($bpja_nk != 0))
	{
		//jual
		$tot_doc_nk_awal=0;
		$qjual_doc_nk_awal = mysql_query("select * from jual where id_produksi='$id_produksi_nk' and id_barang like 'D-%' and tanggal < '$all%' ");
		while($djual_doc_nk_awal=mysql_fetch_assoc($qjual_doc_nk_awal))
		{
			$id_barang_doc_nk_awal = $djual_doc_nk_awal['id_barang'];
			$qty_doc_nk_awal = $djual_doc_nk_awal['qty'];
			//cari harga
			$qbarang_doc_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_doc_nk_awal'");
			$dbarang_doc_nk_awal = mysql_fetch_assoc($qbarang_doc_nk_awal);
			$hrg_barang_doc_nk_awal = $dbarang_doc_nk_awal['hrg_beli'];
			
			$tot_doc_nk_awal = $hrg_barang_doc_nk_awal*$qty_doc_nk_awal;
			$Ttot_doc_nk_awal= $Ttot_doc_nk_awal+$tot_doc_nk_awal; 
		}
		$tot_doc_nk=0;
		$qjual_doc_nk = mysql_query("select * from jual where id_produksi='$id_produksi_nk' and id_barang like 'D-%' and tanggal like '$all%' ");
		while($djual_doc_nk=mysql_fetch_assoc($qjual_doc_nk))
		{
			$id_barang_doc_nk = $djual_doc_nk['id_barang'];
			$qty_doc_nk = $djual_doc_nk['qty'];
			//cari harga
			$qbarang_doc_nk = mysql_query("select * from barang where id_barang='$id_barang_doc_nk'");
			$dbarang_doc_nk = mysql_fetch_assoc($qbarang_doc_nk);
			$hrg_barang_doc_nk = $dbarang_doc_nk['hrg_beli'];
			
			$tot_doc_nk = $hrg_barang_doc_nk*$qty_doc_nk;
			$Ttot_doc_nk= $Ttot_doc_nk+$tot_doc_nk; 
		}
		//jual_berjangka
		$tot_jangka_doc_nk_awal=0;
		$qjualjangka_doc_nk_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_nk' and approve != '' and id_barang like 'D-%' and tgl_bon < '$all%' ");
		while($djualjangka_doc_nk_awal=mysql_fetch_assoc($qjualjangka_doc_nk_awal))
		{
			$id_barang_jangka_doc_nk_awal = $djualjangka_doc_nk_awal['id_barang'];
			$qty_jangka_doc_nk_awal = $djualjangka_doc_nk_awal['qty'];
			//cari harga
			$qbarang_jangka_doc_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_nk_awal'");
			$dbarang_jangka_doc_nk_awal = mysql_fetch_assoc($qbarang_jangka_doc_nk_awal);
			$hrg_barang_jangka_doc_nk_awal = $dbarang_jangka_doc_nk_awal['hrg_beli'];
			
			$tot_jangka_doc_nk_awal = $hrg_barang_jangka_doc_nk_awal*$qty_jangka_doc_nk_awal;
			$Ttot_jangka_doc_nk_awal= $Ttot_jangka_doc_nk_awal+$tot_jangka_doc_nk_awal; 
			
		}
		$tot_jangka_doc_nk=0;
		$qjualjangka_doc_nk = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_nk' and approve != '' and id_barang like 'D-%' and tgl_bon like '$all%' ");
		while($djualjangka_doc_nk=mysql_fetch_assoc($qjualjangka_doc_nk))
		{
			$id_barang_jangka_doc_nk = $djualjangka_doc_nk['id_barang'];
			$qty_jangka_doc_nk = $djualjangka_doc_nk['qty'];
			//cari harga
			$qbarang_jangka_doc_nk = mysql_query("select * from barang where id_barang='$id_barang_jangka_doc_nk'");
			$dbarang_jangka_doc_nk = mysql_fetch_assoc($qbarang_jangka_doc_nk);
			$hrg_barang_jangka_doc_nk = $dbarang_jangka_doc_nk['hrg_beli'];
			
			$tot_jangka_doc_nk = $hrg_barang_jangka_doc_nk*$qty_jangka_doc_nk;
			$Ttot_jangka_doc_nk= $Ttot_jangka_doc_nk+$tot_jangka_doc_nk; 
		}
		//retur
		$tot_retur_doc_nk_awal=0;
		$qjualretur_doc_nk_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_nk' and id_barang like 'D-%' and tgl_rsap < '$all%' ");
		while($djualretur_doc_nk_awal=mysql_fetch_assoc($qjualretur_doc_nk_awal))
		{
			$id_barang_retur_doc_nk_awal = $djualretur_doc_nk_awal['id_barang'];
			$qty_retur_doc_nk_awal = $djualretur_doc_nk_awal['qty'];
			//cari harga
			$qbarang_retur_doc_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_nk_awal'");
			$dbarang_retur_doc_nk_awal = mysql_fetch_assoc($qbarang_retur_doc_nk_awal);
			$hrg_barang_retur_doc_nk_awal = $dbarang_retur_doc_nk_awal['hrg_beli'];
			
			$tot_retur_doc_nk_awal = $hrg_barang_retur_doc_nk_awal*$qty_retur_doc_nk_awal;
			$Ttot_retur_doc_nk_awal= $Ttot_retur_doc_nk_awal+$tot_retur_doc_nk_awal; 
		}
		$tot_retur_doc_nk=0;
		$qjualretur_doc_nk = mysql_query("select * from retur_jual where id_produksi='$id_produksi_nk' and id_barang like 'D-%' and tgl_rsap like '$all%'");
		while($djualretur_doc_nk=mysql_fetch_assoc($qjualretur_doc_nk))
		{
			$id_barang_retur_doc_nk = $djualretur_doc_nk['id_barang'];
			$qty_retur_doc_nk = $djualretur_doc_nk['qty'];
			//cari harga
			$qbarang_retur_doc_nk = mysql_query("select * from barang where id_barang='$id_barang_retur_doc_nk'");
			$dbarang_retur_doc_nk = mysql_fetch_assoc($qbarang_retur_doc_nk);
			$hrg_barang_retur_doc_nk = $dbarang_retur_doc_nk['hrg_beli'];
			
			$tot_retur_doc_nk = $hrg_barang_retur_doc_nk*$qty_retur_doc_nk;
			$Ttot_retur_doc_nk= $Ttot_retur_doc_nk+$tot_retur_doc_nk; 
		}
		$Total_doc_nk = ($Ttot_doc_nk+$Ttot_doc_nk_awal)+($Ttot_jangka_doc_nk+$Ttot_jangka_doc_nk_awal)-($Ttot_retur_doc_nk+$Ttot_retur_doc_nk_awal);
	}
}
$Total_doc_nk2=ribuan($Total_doc_nk);

/* PAKAN */
$qprod_pkn_nk = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'KMT%' order by produksi.id_produksi");
while($dprod_pkn_nk = mysql_fetch_assoc($qprod_pkn_nk))
{
	$id_produksi_pkn_nk = $dprod_pkn_nk['id_produksi'];
	//Memfilter id produksi
	$qpja_pkn_nk = mysql_query("select * from pja where id_produksi='$id_produksi_pkn_nk' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_pkn_nk = mysql_fetch_assoc($qpja_pkn_nk);
	$bpja_pkn_nk = mysql_num_rows($qpja_pkn_nk);
	if(($bpja_pkn_nk != '')or($bpja_pkn_nk != 0))
	{
		//jual
		$tot_pkn_nk_awal=0;
		$qjual_pkn_nk_awal = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_nk' and id_barang like 'F-%' and tanggal < '$all%' ");
		while($djual_pkn_nk_awal=mysql_fetch_assoc($qjual_pkn_nk_awal))
		{
			$id_barang_pkn_nk_awal = $djual_pkn_nk_awal['id_barang'];
			$qty_pkn_nk_awal = $djual_pkn_nk_awal['qty'];
			//cari harga
			$qbarang_pkn_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_pkn_nk_awal'");
			$dbarang_pkn_nk_awal = mysql_fetch_assoc($qbarang_pkn_nk_awal);
			$hrg_barang_pkn_nk_awal = $dbarang_pkn_nk_awal['hrg_beli'];
			
			$tot_pkn_nk_awal = $hrg_barang_pkn_nk_awal*$qty_pkn_nk_awal;
			$Ttot_pkn_nk_awal= $Ttot_pkn_nk_awal+$tot_pkn_nk_awal; 
		}
		$tot_pkn_nk=0;
		$qjual_pkn_nk = mysql_query("select * from jual where id_produksi='$id_produksi_pkn_nk' and id_barang like 'F-%' and tanggal like '$all%' ");
		while($djual_pkn_nk=mysql_fetch_assoc($qjual_pkn_nk))
		{
			$id_barang_pkn_nk = $djual_pkn_nk['id_barang'];
			$qty_pkn_nk = $djual_pkn_nk['qty'];
			//cari harga
			$qbarang_pkn_nk = mysql_query("select * from barang where id_barang='$id_barang_pkn_nk'");
			$dbarang_pkn_nk = mysql_fetch_assoc($qbarang_pkn_nk);
			$hrg_barang_pkn_nk = $dbarang_pkn_nk['hrg_beli'];
			
			$tot_pkn_nk = $hrg_barang_pkn_nk*$qty_pkn_nk;
			$Ttot_pkn_nk= $Ttot_pkn_nk+$tot_pkn_nk; 
		}
		//jual_berjangka
		$tot_jangka_pkn_nk_awal=0;
		$qjualjangka_pkn_nk_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_nk' and approve != '' and id_barang like 'F-%' and tgl_bon < '$all%'");
		while($djualjangka_pkn_nk_awal=mysql_fetch_assoc($qjualjangka_pkn_nk_awal))
		{
			$id_barang_jangka_pkn_nk_awal = $djualjangka_pkn_nk_awal['id_barang'];
			$qty_jangka_pkn_nk_awal = $djualjangka_pkn_nk_awal['qty'];
			//cari harga
			$qbarang_jangka_pkn_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_nk_awal'");
			$dbarang_jangka_pkn_nk_awal = mysql_fetch_assoc($qbarang_jangka_pkn_nk_awal);
			$hrg_barang_jangka_pkn_nk_awal = $dbarang_jangka_pkn_nk_awal['hrg_beli'];
			
			$tot_jangka_pkn_nk_awal = $hrg_barang_jangka_pkn_nk_awal*$qty_jangka_pkn_nk_awal;
			$Ttot_jangka_pkn_nk_awal= $Ttot_jangka_pkn_nk_awal+$tot_jangka_pkn_nk_awal; 
		}
		$tot_jangka_pkn_nk=0;
		$qjualjangka_pkn_nk = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_pkn_nk' and approve != '' and id_barang like 'F-%' and tgl_bon like '$all%'");
		while($djualjangka_pkn_nk=mysql_fetch_assoc($qjualjangka_pkn_nk))
		{
			$id_barang_jangka_pkn_nk = $djualjangka_pkn_nk['id_barang'];
			$qty_jangka_pkn_nk = $djualjangka_pkn_nk['qty'];
			//cari harga
			$qbarang_jangka_pkn_nk = mysql_query("select * from barang where id_barang='$id_barang_jangka_pkn_nk'");
			$dbarang_jangka_pkn_nk = mysql_fetch_assoc($qbarang_jangka_pkn_nk);
			$hrg_barang_jangka_pkn_nk = $dbarang_jangka_pkn_nk['hrg_beli'];
			
			$tot_jangka_pkn_nk = $hrg_barang_jangka_pkn_nk*$qty_jangka_pkn_nk;
			$Ttot_jangka_pkn_nk= $Ttot_jangka_pkn_nk+$tot_jangka_pkn_nk; 
		}
		//retur
		$tot_retur_pkn_nk_awal=0;
		$qjualretur_pkn_nk_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_nk' and id_barang like 'F-%' and tgl_rsap < '$all%'");
		while($djualretur_pkn_nk_awal=mysql_fetch_assoc($qjualretur_pkn_nk_awal))
		{
			$id_barang_retur_pkn_nk_awal = $djualretur_pkn_nk_awal['id_barang'];
			$qty_retur_pkn_nk_awal = $djualretur_pkn_nk_awal['qty'];
			//cari harga
			$qbarang_retur_pkn_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_nk_awal'");
			$dbarang_retur_pkn_nk_awal = mysql_fetch_assoc($qbarang_retur_pkn_nk_awal);
			$hrg_barang_retur_pkn_nk_awal = $dbarang_retur_pkn_nk_awal['hrg_beli'];
			
			$tot_retur_pkn_nk_awal = $hrg_barang_retur_pkn_nk_awal*$qty_retur_pkn_nk_awal;
			$Ttot_retur_pkn_nk_awal= $Ttot_retur_pkn_nk_awal+$tot_retur_pkn_nk_awal; 
		}
		$tot_retur_pkn_nk=0;
		$qjualretur_pkn_nk = mysql_query("select * from retur_jual where id_produksi='$id_produksi_pkn_nk' and id_barang like 'F-%' and tgl_rsap like '$all%'");
		while($djualretur_pkn_nk=mysql_fetch_assoc($qjualretur_pkn_nk))
		{
			$id_barang_retur_pkn_nk = $djualretur_pkn_nk['id_barang'];
			$qty_retur_pkn_nk = $djualretur_pkn_nk['qty'];
			//cari harga
			$qbarang_retur_pkn_nk = mysql_query("select * from barang where id_barang='$id_barang_retur_pkn_nk'");
			$dbarang_retur_pkn_nk = mysql_fetch_assoc($qbarang_retur_pkn_nk);
			$hrg_barang_retur_pkn_nk = $dbarang_retur_pkn_nk['hrg_beli'];
			
			$tot_retur_pkn_nk = $hrg_barang_retur_pkn_nk*$qty_retur_pkn_nk;
			$Ttot_retur_pkn_nk= $Ttot_retur_pkn_nk+$tot_retur_pkn_nk; 
		}
		$Total_pkn_nk = ($Ttot_pkn_nk+$Ttot_pkn_nk_awal)+($Ttot_jangka_pkn_nk+$Ttot_jangka_pkn_nk_awal)-($Ttot_retur_pkn_nk+$Ttot_retur_pkn_nk_awal);
	}
}
$Total_pkn_nk2=ribuan($Total_pkn_nk);

/* OVK */
$qprod_ovk_nk = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'KMT%' order by produksi.id_produksi");
while($dprod_ovk_nk = mysql_fetch_assoc($qprod_ovk_nk))
{
	$id_produksi_ovk_nk = $dprod_ovk_nk['id_produksi'];
	//Memfilter id produksi
	$qpja_ovk_nk = mysql_query("select * from pja where id_produksi='$id_produksi_ovk_nk' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_ovk_nk = mysql_fetch_assoc($qpja_ovk_nk);
	$bpja_ovk_nk = mysql_num_rows($qpja_ovk_nk);
	if(($bpja_ovk_nk != '')or($bpja_ovk_nk != 0))
	{
		//jual
		$tot_ovk_nk_awal=0;
		$qjual_ovk_nk_awal = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_nk' and id_barang like 'M-%' and tanggal < '$all%'");
		while($djual_ovk_nk_awal=mysql_fetch_assoc($qjual_ovk_nk_awal))
		{
			$id_barang_ovk_nk_awal = $djual_ovk_nk_awal['id_barang'];
			$qty_ovk_nk_awal = $djual_ovk_nk_awal['qty'];
			//cari harga
			$qbarang_ovk_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_ovk_nk_awal'");
			$dbarang_ovk_nk_awal = mysql_fetch_assoc($qbarang_ovk_nk_awal);
			$hrg_barang_ovk_nk_awal = $dbarang_ovk_nk_awal['hrg_beli'];
			
			$tot_ovk_nk_awal = $hrg_barang_ovk_nk_awal*$qty_ovk_nk_awal;
			$Ttot_ovk_nk_awal= $Ttot_ovk_nk_awal+$tot_ovk_nk_awal; 
		}
		$tot_ovk_nk=0;
		$qjual_ovk_nk = mysql_query("select * from jual where id_produksi='$id_produksi_ovk_nk' and id_barang like 'M-%' and tanggal like '$all%'");
		while($djual_ovk_nk=mysql_fetch_assoc($qjual_ovk_nk))
		{
			$id_barang_ovk_nk = $djual_ovk_nk['id_barang'];
			$qty_ovk_nk = $djual_ovk_nk['qty'];
			//cari harga
			$qbarang_ovk_nk = mysql_query("select * from barang where id_barang='$id_barang_ovk_nk'");
			$dbarang_ovk_nk = mysql_fetch_assoc($qbarang_ovk_nk);
			$hrg_barang_ovk_nk = $dbarang_ovk_nk['hrg_beli'];
			
			$tot_ovk_nk = $hrg_barang_ovk_nk*$qty_ovk_nk;
			$Ttot_ovk_nk= $Ttot_ovk_nk+$tot_ovk_nk; 
		}
		//jual_berjangka
		$tot_jangka_ovk_nk_awal=0;
		$qjualjangka_ovk_nk_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_nk' and approve != '' and id_barang like 'M-%' and tgl_bon < '$all%'");
		while($djualjangka_ovk_nk_awal=mysql_fetch_assoc($qjualjangka_ovk_nk_awal))
		{
			$id_barang_jangka_ovk_nk_awal = $djualjangka_ovk_nk_awal['id_barang'];
			$qty_jangka_ovk_nk_awal = $djualjangka_ovk_nk_awal['qty'];
			//cari harga
			$qbarang_jangka_ovk_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_nk_awal'");
			$dbarang_jangka_ovk_nk_awal = mysql_fetch_assoc($qbarang_jangka_ovk_nk_awal);
			$hrg_barang_jangka_ovk_nk_awal = $dbarang_jangka_ovk_nk_awal['hrg_beli'];
			
			$tot_jangka_ovk_nk_awal = $hrg_barang_jangka_ovk_nk_awal*$qty_jangka_ovk_nk_awal;
			$Ttot_jangka_ovk_nk_awal= $Ttot_jangka_ovk_nk_awal+$tot_jangka_ovk_nk_awal; 
		}
		$tot_jangka_ovk_nk=0;
		$qjualjangka_ovk_nk = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_ovk_nk' and approve != '' and id_barang like 'M-%' and tgl_bon like '$all%'");
		while($djualjangka_ovk_nk=mysql_fetch_assoc($qjualjangka_ovk_nk))
		{
			$id_barang_jangka_ovk_nk = $djualjangka_ovk_nk['id_barang'];
			$qty_jangka_ovk_nk = $djualjangka_ovk_nk['qty'];
			//cari harga
			$qbarang_jangka_ovk_nk = mysql_query("select * from barang where id_barang='$id_barang_jangka_ovk_nk'");
			$dbarang_jangka_ovk_nk = mysql_fetch_assoc($qbarang_jangka_ovk_nk);
			$hrg_barang_jangka_ovk_nk = $dbarang_jangka_ovk_nk['hrg_beli'];
			
			$tot_jangka_ovk_nk = $hrg_barang_jangka_ovk_nk*$qty_jangka_ovk_nk;
			$Ttot_jangka_ovk_nk= $Ttot_jangka_ovk_nk+$tot_jangka_ovk_nk; 
		}
		//retur
		$tot_retur_ovk_nk_awal=0;
		$qjualretur_ovk_nk_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_nk' and id_barang like 'M-%' and tgl_rsap < '$all%'");
		while($djualretur_ovk_nk_awal=mysql_fetch_assoc($qjualretur_ovk_nk_awal))
		{
			$id_barang_retur_ovk_nk_awal = $djualretur_ovk_nk_awal['id_barang'];
			$qty_retur_ovk_nk_awal = $djualretur_ovk_nk_awal['qty'];
			//cari harga
			$qbarang_retur_ovk_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_nk_awal'");
			$dbarang_retur_ovk_nk_awal = mysql_fetch_assoc($qbarang_retur_ovk_nk_awal);
			$hrg_barang_retur_ovk_nk_awal = $dbarang_retur_ovk_nk_awal['hrg_beli'];
			
			$tot_retur_ovk_nk_awal = $hrg_barang_retur_ovk_nk_awal*$qty_retur_ovk_nk_awal;
			$Ttot_retur_ovk_nk_awal= $Ttot_retur_ovk_nk_awal+$tot_retur_ovk_nk_awal; 
		}
		$tot_retur_ovk_nk=0;
		$qjualretur_ovk_nk = mysql_query("select * from retur_jual where id_produksi='$id_produksi_ovk_nk' and id_barang like 'M-%' and tgl_rsap like '$all%'");
		while($djualretur_ovk_nk=mysql_fetch_assoc($qjualretur_ovk_nk))
		{
			$id_barang_retur_ovk_nk = $djualretur_ovk_nk['id_barang'];
			$qty_retur_ovk_nk = $djualretur_ovk_nk['qty'];
			//cari harga
			$qbarang_retur_ovk_nk = mysql_query("select * from barang where id_barang='$id_barang_retur_ovk_nk'");
			$dbarang_retur_ovk_nk = mysql_fetch_assoc($qbarang_retur_ovk_nk);
			$hrg_barang_retur_ovk_nk = $dbarang_retur_ovk_nk['hrg_beli'];
			
			$tot_retur_ovk_nk = $hrg_barang_retur_ovk_nk*$qty_retur_ovk_nk;
			$Ttot_retur_ovk_nk= $Ttot_retur_ovk_nk+$tot_retur_ovk_nk; 
		}
		$Total_ovk_nk = ($Ttot_ovk_nk+$Ttot_ovk_nk_awal)+($Ttot_jangka_ovk_nk+$Ttot_jangka_ovk_nk_awal)-($Ttot_retur_ovk_nk+$Ttot_retur_ovk_nk_awal);
	}
}
$Total_ovk_nk2=ribuan($Total_ovk_nk);

/* EQUIPMENT */
$qprod_eqp_nk = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'KMT%' order by produksi.id_produksi");
while($dprod_eqp_nk = mysql_fetch_assoc($qprod_eqp_nk))
{
	$id_produksi_eqp_nk = $dprod_eqp_nk['id_produksi'];
	//Memfilter id produksi
	$qpja_eqp_nk = mysql_query("select * from pja where id_produksi='$id_produksi_eqp_nk' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_eqp_nk = mysql_fetch_assoc($qpja_eqp_nk);
	$bpja_eqp_nk = mysql_num_rows($qpja_eqp_nk);
	if(($bpja_eqp_nk != '')or($bpja_eqp_nk != 0))
	{
		//jual
		$tot_eqp_nk_awal=0;
		$qjual_eqp_nk_awal = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_nk' and id_barang like 'E-%' and tanggal < '$all%'");
		while($djual_eqp_nk_awal=mysql_fetch_assoc($qjual_eqp_nk_awal))
		{
			$id_barang_eqp_nk_awal = $djual_eqp_nk_awal['id_barang'];
			$qty_eqp_nk_awal = $djual_eqp_nk_awal['qty'];
			//cari harga
			$qbarang_eqp_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_eqp_nk_awal'");
			$dbarang_eqp_nk_awal = mysql_fetch_assoc($qbarang_eqp_nk_awal);
			$hrg_barang_eqp_nk_awal = $dbarang_eqp_nk_awal['hrg_beli'];
			
			$tot_eqp_nk_awal = $hrg_barang_eqp_nk_awal*$qty_eqp_nk_awal;
			$Ttot_eqp_nk_awal= $Ttot_eqp_nk_awal+$tot_eqp_nk_awal; 
		}
		$tot_eqp_nk=0;
		$qjual_eqp_nk = mysql_query("select * from jual where id_produksi='$id_produksi_eqp_nk' and id_barang like 'E-%' and tanggal like '$all%'");
		while($djual_eqp_nk=mysql_fetch_assoc($qjual_eqp_nk))
		{
			$id_barang_eqp_nk = $djual_eqp_nk['id_barang'];
			$qty_eqp_nk = $djual_eqp_nk['qty'];
			//cari harga
			$qbarang_eqp_nk = mysql_query("select * from barang where id_barang='$id_barang_eqp_nk'");
			$dbarang_eqp_nk = mysql_fetch_assoc($qbarang_eqp_nk);
			$hrg_barang_eqp_nk = $dbarang_eqp_nk['hrg_beli'];
			
			$tot_eqp_nk = $hrg_barang_eqp_nk*$qty_eqp_nk;
			$Ttot_eqp_nk= $Ttot_eqp_nk+$tot_eqp_nk; 
		}
		//jual_berjangka
		$tot_jangka_eqp_nk_awal=0;
		$qjualjangka_eqp_nk_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_nk' and approve != '' and id_barang like 'E-%' and tgl_bon < '$all%'");
		while($djualjangka_eqp_nk_awal=mysql_fetch_assoc($qjualjangka_eqp_nk_awal))
		{
			$id_barang_jangka_eqp_nk_awal = $djualjangka_eqp_nk_awal['id_barang'];
			$qty_jangka_eqp_nk_awal = $djualjangka_eqp_nk_awal['qty'];
			//cari harga
			$qbarang_jangka_eqp_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_nk_awal'");
			$dbarang_jangka_eqp_nk_awal = mysql_fetch_assoc($qbarang_jangka_eqp_nk_awal);
			$hrg_barang_jangka_eqp_nk_awal = $dbarang_jangka_eqp_nk_awal['hrg_beli'];
			
			$tot_jangka_eqp_nk_awal = $hrg_barang_jangka_eqp_nk_awal*$qty_jangka_eqp_nk_awal;
			$Ttot_jangka_eqp_nk_awal= $Ttot_jangka_eqp_nk_awal+$tot_jangka_eqp_nk_awal; 
		}
		$tot_jangka_eqp_nk=0;
		$qjualjangka_eqp_nk = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_eqp_nk' and approve != '' and id_barang like 'E-%' and tgl_bon like '$all%'");
		while($djualjangka_eqp_nk=mysql_fetch_assoc($qjualjangka_eqp_nk))
		{
			$id_barang_jangka_eqp_nk = $djualjangka_eqp_nk['id_barang'];
			$qty_jangka_eqp_nk = $djualjangka_eqp_nk['qty'];
			//cari harga
			$qbarang_jangka_eqp_nk = mysql_query("select * from barang where id_barang='$id_barang_jangka_eqp_nk'");
			$dbarang_jangka_eqp_nk = mysql_fetch_assoc($qbarang_jangka_eqp_nk);
			$hrg_barang_jangka_eqp_nk = $dbarang_jangka_eqp_nk['hrg_beli'];
			
			$tot_jangka_eqp_nk = $hrg_barang_jangka_eqp_nk*$qty_jangka_eqp_nk;
			$Ttot_jangka_eqp_nk= $Ttot_jangka_eqp_nk+$tot_jangka_eqp_nk; 
		}
		//retur
		$tot_retur_eqp_nk_awal=0;
		$qjualretur_eqp_nk_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_nk' and id_barang like 'E-%' and tgl_rsap < '$all%' ");
		while($djualretur_eqp_nk_awal=mysql_fetch_assoc($qjualretur_eqp_nk_awal))
		{
			$id_barang_retur_eqp_nk_awal = $djualretur_eqp_nk_awal['id_barang'];
			$qty_retur_eqp_nk_awal = $djualretur_eqp_nk_awal['qty'];
			//cari harga
			$qbarang_retur_eqp_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_nk_awal'");
			$dbarang_retur_eqp_nk_awal = mysql_fetch_assoc($qbarang_retur_eqp_nk_awal);
			$hrg_barang_retur_eqp_nk_awal = $dbarang_retur_eqp_nk_awal['hrg_beli'];
			
			$tot_retur_eqp_nk_awal = $hrg_barang_retur_eqp_nk_awal*$qty_retur_eqp_nk_awal;
			$Ttot_retur_eqp_nk_awal= $Ttot_retur_eqp_nk_awal+$tot_retur_eqp_nk_awal; 
		}
		$tot_retur_eqp_nk=0;
		$qjualretur_eqp_nk = mysql_query("select * from retur_jual where id_produksi='$id_produksi_eqp_nk' and id_barang like 'E-%' and tgl_rsap like '$all%' ");
		while($djualretur_eqp_nk=mysql_fetch_assoc($qjualretur_eqp_nk))
		{
			$id_barang_retur_eqp_nk = $djualretur_eqp_nk['id_barang'];
			$qty_retur_eqp_nk = $djualretur_eqp_nk['qty'];
			//cari harga
			$qbarang_retur_eqp_nk = mysql_query("select * from barang where id_barang='$id_barang_retur_eqp_nk'");
			$dbarang_retur_eqp_nk = mysql_fetch_assoc($qbarang_retur_eqp_nk);
			$hrg_barang_retur_eqp_nk = $dbarang_retur_eqp_nk['hrg_beli'];
			
			$tot_retur_eqp_nk = $hrg_barang_retur_eqp_nk*$qty_retur_eqp_nk;
			$Ttot_retur_eqp_nk= $Ttot_retur_eqp_nk+$tot_retur_eqp_nk; 
		}
		$Total_eqp_nk = ($Ttot_eqp_nk+$Ttot_eqp_nk_awal)+($Ttot_jangka_eqp_nk+$Ttot_jangka_eqp_nk_awal)-($Ttot_retur_eqp_nk+$Ttot_retur_eqp_nk_awal);
	}
}
$Total_eqp_nk2=ribuan($Total_eqp_nk);

/* OTHER */
$qprod_oth_nk = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'KMT%' order by produksi.id_produksi");
while($dprod_oth_nk = mysql_fetch_assoc($qprod_oth_nk))
{
	$id_produksi_oth_nk = $dprod_oth_nk['id_produksi'];
	//Memfilter id produksi
	$qpja_oth_nk = mysql_query("select * from pja where id_produksi='$id_produksi_oth_nk' and ((tanggal like '$all%')or(tanggal < '$all%'))");
	$dpja_oth_nk = mysql_fetch_assoc($qpja_oth_nk);
	$bpja_oth_nk = mysql_num_rows($qpja_oth_nk);
	if(($bpja_oth_nk != '')or($bpja_oth_nk != 0))
	{
		//jual
		$tot_oth_nk_awal=0;
		$qjual_oth_nk_awal = mysql_query("select * from jual where id_produksi='$id_produksi_oth_nk' and id_barang like 'O-%' and tanggal < '$all%'");
		while($djual_oth_nk_awal=mysql_fetch_assoc($qjual_oth_nk_awal))
		{
			$id_barang_oth_nk_awal = $djual_oth_nk_awal['id_barang'];
			$qty_oth_nk_awal = $djual_oth_nk_awal['qty'];
			//cari harga
			$qbarang_oth_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_oth_nk_awal'");
			$dbarang_oth_nk_awal = mysql_fetch_assoc($qbarang_oth_nk_awal);
			$hrg_barang_oth_nk_awal = $dbarang_oth_nk_awal['hrg_beli'];
			
			$tot_oth_nk_awal = $hrg_barang_oth_nk_awal*$qty_oth_nk_awal;
			$Ttot_oth_nk_awal= $Ttot_oth_nk_awal+$tot_oth_nk_awal; 
		}
		$tot_oth_nk=0;
		$qjual_oth_nk = mysql_query("select * from jual where id_produksi='$id_produksi_oth_nk' and id_barang like 'O-%' and tanggal like '$all%'");
		while($djual_oth_nk=mysql_fetch_assoc($qjual_oth_nk))
		{
			$id_barang_oth_nk = $djual_oth_nk['id_barang'];
			$qty_oth_nk = $djual_oth_nk['qty'];
			//cari harga
			$qbarang_oth_nk = mysql_query("select * from barang where id_barang='$id_barang_oth_nk'");
			$dbarang_oth_nk = mysql_fetch_assoc($qbarang_oth_nk);
			$hrg_barang_oth_nk = $dbarang_oth_nk['hrg_beli'];
			
			$tot_oth_nk = $hrg_barang_oth_nk*$qty_oth_nk;
			$Ttot_oth_nk= $Ttot_oth_nk+$tot_oth_nk; 
		}
		//jual_berjangka
		$tot_jangka_oth_nk_awal=0;
		$qjualjangka_oth_nk_awal = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_nk' and approve != '' and id_barang like 'O-%' and tgl_bon < '$all%'");
		while($djualjangka_oth_nk_awal=mysql_fetch_assoc($qjualjangka_oth_nk_awal))
		{
			$id_barang_jangka_oth_nk_awal = $djualjangka_oth_nk_awal['id_barang'];
			$qty_jangka_oth_nk_awal = $djualjangka_oth_nk_awal['qty'];
			//cari harga
			$qbarang_jangka_oth_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_nk_awal'");
			$dbarang_jangka_oth_nk_awal = mysql_fetch_assoc($qbarang_jangka_oth_nk_awal);
			$hrg_barang_jangka_oth_nk_awal = $dbarang_jangka_oth_nk_awal['hrg_beli'];
			
			$tot_jangka_oth_nk_awal = $hrg_barang_jangka_oth_nk_awal*$qty_jangka_oth_nk_awal;
			$Ttot_jangka_oth_nk_awal= $Ttot_jangka_oth_nk_awal+$tot_jangka_oth_nk_awal; 
		}
		$tot_jangka_oth_nk=0;
		$qjualjangka_oth_nk = mysql_query("select * from utang_peralatan where id_produksi='$id_produksi_oth_nk' and approve != '' and id_barang like 'O-%' and tgl_bon like '$all%'");
		while($djualjangka_oth_nk=mysql_fetch_assoc($qjualjangka_oth_nk))
		{
			$id_barang_jangka_oth_nk = $djualjangka_oth_nk['id_barang'];
			$qty_jangka_oth_nk = $djualjangka_oth_nk['qty'];
			//cari harga
			$qbarang_jangka_oth_nk = mysql_query("select * from barang where id_barang='$id_barang_jangka_oth_nk'");
			$dbarang_jangka_oth_nk = mysql_fetch_assoc($qbarang_jangka_oth_nk);
			$hrg_barang_jangka_oth_nk = $dbarang_jangka_oth_nk['hrg_beli'];
			
			$tot_jangka_oth_nk = $hrg_barang_jangka_oth_nk*$qty_jangka_oth_nk;
			$Ttot_jangka_oth_nk= $Ttot_jangka_oth_nk+$tot_jangka_oth_nk; 
		}
		//retur
		$tot_retur_oth_nk_awal=0;
		$qjualretur_oth_nk_awal = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_nk' and id_barang like 'O-%' and tgl_rsap < '$all%'");
		while($djualretur_oth_nk_awal=mysql_fetch_assoc($qjualretur_oth_nk_awal))
		{
			$id_barang_retur_oth_nk_awal = $djualretur_oth_nk_awal['id_barang'];
			$qty_retur_oth_nk_awal = $djualretur_oth_nk_awal['qty'];
			//cari harga
			$qbarang_retur_oth_nk_awal = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_nk_awal'");
			$dbarang_retur_oth_nk_awal = mysql_fetch_assoc($qbarang_retur_oth_nk_awal);
			$hrg_barang_retur_oth_nk_awal = $dbarang_retur_oth_nk_awal['hrg_beli'];
			
			$tot_retur_oth_nk_awal = $hrg_barang_retur_oth_nk_awal*$qty_retur_oth_nk_awal;
			$Ttot_retur_oth_nk_awal= $Ttot_retur_oth_nk_awal+$tot_retur_oth_nk_awal; 
		}
		$tot_retur_oth_nk=0;
		$qjualretur_oth_nk = mysql_query("select * from retur_jual where id_produksi='$id_produksi_oth_nk' and id_barang like 'O-%' and tgl_rsap like '$all%'");
		while($djualretur_oth_nk=mysql_fetch_assoc($qjualretur_oth_nk))
		{
			$id_barang_retur_oth_nk = $djualretur_oth_nk['id_barang'];
			$qty_retur_oth_nk = $djualretur_oth_nk['qty'];
			//cari harga
			$qbarang_retur_oth_nk = mysql_query("select * from barang where id_barang='$id_barang_retur_oth_nk'");
			$dbarang_retur_oth_nk = mysql_fetch_assoc($qbarang_retur_oth_nk);
			$hrg_barang_retur_oth_nk = $dbarang_retur_oth_nk['hrg_beli'];
			
			$tot_retur_oth_nk = $hrg_barang_retur_oth_nk*$qty_retur_oth_nk;
			$Ttot_retur_oth_nk= $Ttot_retur_oth_nk+$tot_retur_oth_nk; 
		}
		$Total_oth_nk = ($Ttot_oth_nk+$Ttot_oth_nk_awal)+($Ttot_jangka_oth_nk+$Ttot_jangka_oth_nk_awal)-($Ttot_retur_oth_nk+$Ttot_retur_oth_nk_awal);
	}
}
$Total_oth_nk2=ribuan($Total_oth_nk);

//BOP kemitraan
$q_ops_kmt_awal = mysql_query("select * from produksi join rhpp on (produksi.id_produksi=rhpp.id_produksi) where ((panenbulan='0000-00-00')or(panenbulan > '$all2')) and id_kontrak like 'KMT%' order by produksi.id_produksi");
while($d_ops_kmt_awal=mysql_fetch_assoc($q_ops_kmt_awal))
{
	$id_prod_ops_kmt_awal=$d_ops_kmt_awal['id_produksi']; //echo"$id_prod_ops_kmt_awal<br>";
	$q_op_ins_ternak_kmt_awal = mysql_query("select * from op_ins_ternak where id_produksi='$id_prod_ops_kmt_awal' and tanggal < '$all%'");
	$Tjml_op_ins_ternak_kmt_awal=0;
	while($d_op_ins_ternak_kmt_awal=mysql_fetch_assoc($q_op_ins_ternak_kmt_awal))
	{
		$jml_op_ins_ternak_kmt_awal=$d_op_ins_ternak_kmt_awal['jumlah'];//echo"$jml_op_ins_ternak_kmt_awal<br>";
		$Tjml_op_ins_ternak_kmt_awal=$Tjml_op_ins_ternak_kmt_awal+$jml_op_ins_ternak_kmt_awal;
	}
	$Totjml_op_ins_ternak_kmt_awal=$Totjml_op_ins_ternak_kmt_awal+$Tjml_op_ins_ternak_kmt_awal;

	$q_op_ins_ternak_kmt = mysql_query("select * from op_ins_ternak where id_produksi='$id_prod_ops_kmt_awal' and tanggal like '$all%'");
	$Tjml_op_ins_ternak_kmt=0;
	while($d_op_ins_ternak_kmt=mysql_fetch_assoc($q_op_ins_ternak_kmt))
	{
		$jml_op_ins_ternak_kmt=$d_op_ins_ternak_kmt['jumlah'];
		$Tjml_op_ins_ternak_kmt=$Tjml_op_ins_ternak_kmt+$jml_op_ins_ternak_kmt;
	}
	$Totjml_op_ins_ternak_kmt=$Totjml_op_ins_ternak_kmt+$Tjml_op_ins_ternak_kmt;
}

$Total_persediaan_nk = $Totjml_op_ins_ternak_kmt_awal+$Totjml_op_ins_ternak_kmt+$Total_oth_nk+$Total_eqp_nk+$Total_ovk_nk+$Total_pkn_nk+$Total_doc_nk;
$Total_persediaan_nk2=ribuan($Total_persediaan_nk);

$Total_persediaan_kmt = $Total_persediaan_nk+$Total_oth_kmt+$Total_eqp_kmt+$Total_ovk_kmt+$Total_pkn_kmt+$Total_doc_kmt;
$Total_persediaan_kmt2=ribuan($Total_persediaan_kmt);
?>
<?
//===========================================HT.TIDAK DISUSUTKAN===========================================\\
$x_7=1;
$query_7 = mysql_query("select * from rules_akun where id_akun like '120%' order by id_akun");
while($data_7 = mysql_fetch_assoc($query_7))
{
	$id_akun_7 = $data_7['id_akun'];
	$t1_7 = $data_7['debet'];
	$t2_7 = $data_7['kredit'];
	$normal_7 = $data_7['normal'];
	$q1_7 = mysql_query("select * from akun where id_akun = '$id_akun_7' ");
	$d2_7 = mysql_fetch_assoc($q1_7);
//cari saldo awal
$Tawal_7 =0;	$Totawal_7 =0; $T_7 = 0;
$qawal_7 = @mysql_query("select * from jurnal where tgl < '$all' ");
$bawal_7 = @mysql_num_rows($qawal_7);
if($bawal_7>0)
{
	while($dawal_7 = @mysql_fetch_assoc($qawal_7))
	{
		if($dawal_7['akun1']== $id_akun_7)
		{
		$tanggal_awal_7 = tgl_indo($dawal_7['tgl']);
		$debet_awal_7 = ribuan($dawal_7['debet1']); 	
		$kredit_awal_7 = ribuan($dawal_7['kredit1']);
		$debet_awal9_7 = $dawal_7['debet1']; 	
		$kredit_awal9_7 = $dawal_7['kredit1'];
		
		//mencari nama akun//
		$qakun_awal_7 = @mysql_query("select * from akun where id_akun='$dawal_7[akun1]' ");
		$dakun_awal_7 = @mysql_fetch_assoc($qakun_awal_7);
		
		//mengatur operator
		if(($t1_7 == '+')and($t2_7 == '-'))
		{
		$awal_7 = ($Tawal_7+$debet_awal9_7)-$kredit_awal9_7;
		}else
		if(($t1_7 == '-')and($t2_7 == '+'))
		{
		$awal_7 = ($Tawal_7-$debet_awal9_7)+$kredit_awal9_7;
		}
		
		$Tawal_7 = $awal_7;
		$Tawalribuan_7 = ribuan($Tawal_7);
		
		}else
		if($dawal_7['akun2']== $id_akun_7)
		{
		$tanggal_awal_7 = tgl_indo($dawal_7['tgl']);
		$debet_awal_7 = ribuan($dawal_7['debet2']); 	
		$kredit_awal_7 = ribuan($dawal_7['kredit2']);
		$debet_awal9_7 = $dawal_7['debet2']; 	
		$kredit_awal9_7 = $dawal_7['kredit2'];

		//mencari nama akun//
		$qakun_awal_7 = @mysql_query("select * from akun where id_akun='$dawal_7[akun2]' ");
		$dakun_awal_7 = @mysql_fetch_assoc($qakun_awal_7);

		if(($t1_7 == '+')and($t2_7 == '-'))
		{
		$awal_7 = ($Tawal_7+$debet_awal9_7)-$kredit_awal9_7;
		}else
		if(($t1_7 == '-')and($t2_7 == '+'))
		{
		$awal_7 = ($Tawal_7-$debet_awal9_7)+$kredit_awal9_7;
		}

		$Tawal_7 = $awal_7;
		$Tawalribuan_7 = ribuan($Tawal_7);

		}
	}
}
if($Tawal_7 != '')
{
$T_7 = $Tawal_7;
$Tribuan_7= ribuan($T_7);
}else
{
$T_7 = 0;
$Tribuan_7= ribuan($T_7);
}

$q_7 = @mysql_query("select * from jurnal where tgl like '%$all%' order by tgl ");
$b_7 = @mysql_num_rows($q_7);
	while($d_7 = @mysql_fetch_assoc($q_7))
	{

		if($d_7['akun1']==$id_akun_7)
		{
		$tanggal_7 = tgl_indo($d_7['tgl']);
		$debet_7 = ribuan($d_7['debet1']); 	
		$kredit_7 = ribuan($d_7['kredit1']);
		$debet9_7 = $d_7['debet1']; 	
		$kredit9_7 = $d_7['kredit1'];

		//mencari nama akun//
		$qakun_7 = @mysql_query("select * from akun where id_akun='$d_7[akun1]' ");
		$dakun_7 = @mysql_fetch_assoc($qakun_7);

		//mengatur operator
		if(($t1_7 == '+')and($t2_7 == '-'))
		{
		$k_7 = ($T_7+$debet9_7)-$kredit9_7;
		}else
		if(($t1_7 == '-')and($t2_7 == '+'))
		{
		$k_7 = ($T_7-$debet9_7)+$kredit9_7;
		}
		$T_7 = $k_7;
		$Tribuan_7 = ribuan($T_7);

		}else
		if($d_7['akun2']==$id_akun_7)
		{
		$tanggal_7 = tgl_indo($d_7['tgl']);
		$debet_7 = ribuan($d_7['debet2']); 	
		$kredit_7 = ribuan($d_7['kredit2']);
		$debet9_7 = $d_7['debet2']; 	
		$kredit9_7 = $d_7['kredit2'];

		//mencari nama akun//
		$qakun_7 = @mysql_query("select * from akun where id_akun='$d_7[akun2]' ");
		$dakun_7 = @mysql_fetch_assoc($qakun_7);

		//mengatur operator
		if(($t1_7 == '+')and($t2_7 == '-'))
		{
		$k_7 = ($T_7+$debet9_7)-$kredit9_7;
		}else
		if(($t1_7 == '-')and($t2_7 == '+'))
		{
		$k_7 = ($T_7-$debet9_7)+$kredit9_7;
		}
		$T_7 = $k_7;
		$Tribuan_7 = ribuan($T_7);
		}
	}
	$TotalT_7 = $TotalT_7+$T_7;
	if($normal_7=='DEBET')
	{
	}else
	{
	}

	$x_7++;
}
$TotalT2_7=ribuan($TotalT_7);
?>
<?
//===========================================HT.DISUSUTKAN===========================================\\
$x_8=1;
$query_8 = mysql_query("select * from rules_akun where id_akun like '121%' order by id_akun");
while($data_8 = mysql_fetch_assoc($query_8))
{
	$id_akun_8 = $data_8['id_akun'];
	$t1_8 = $data_8['debet'];
	$t2_8 = $data_8['kredit'];
	$normal_8 = $data_8['normal'];
	$q1_8 = mysql_query("select * from akun where id_akun = '$id_akun_8' ");
	$d2_8 = mysql_fetch_assoc($q1_8);
//cari saldo awal
$Tawal_8 =0;	$Totawal_8 =0; $T_8 = 0;
$qawal_8 = @mysql_query("select * from jurnal where tgl < '$all' ");
$bawal_8 = @mysql_num_rows($qawal_8);
if($bawal_8>0)
{
	while($dawal_8 = @mysql_fetch_assoc($qawal_8))
	{
		if($dawal_8['akun1']== $id_akun_8)
		{
		$tanggal_awal_8 = tgl_indo($dawal_8['tgl']);
		$debet_awal_8 = ribuan($dawal_8['debet1']); 	
		$kredit_awal_8 = ribuan($dawal_8['kredit1']);
		$debet_awal9_8 = $dawal_8['debet1']; 	
		$kredit_awal9_8 = $dawal_8['kredit1'];
		
		//mencari nama akun//
		$qakun_awal_8 = @mysql_query("select * from akun where id_akun='$dawal_8[akun1]' ");
		$dakun_awal_8 = @mysql_fetch_assoc($qakun_awal_8);
		
		//mengatur operator
		if(($t1_8 == '+')and($t2_8 == '-'))
		{
		$awal_8 = ($Tawal_8+$debet_awal9_8)-$kredit_awal9_8;
		}else
		if(($t1_8 == '-')and($t2_8 == '+'))
		{
		$awal_8 = ($Tawal_8-$debet_awal9_8)+$kredit_awal9_8;
		}
		
		$Tawal_8 = $awal_8;
		$Tawalribuan_8 = ribuan($Tawal_8);
		
		}else
		if($dawal_8['akun2']== $id_akun_8)
		{
		$tanggal_awal_8 = tgl_indo($dawal_8['tgl']);
		$debet_awal_8 = ribuan($dawal_8['debet2']); 	
		$kredit_awal_8 = ribuan($dawal_8['kredit2']);
		$debet_awal9_8 = $dawal_8['debet2']; 	
		$kredit_awal9_8 = $dawal_8['kredit2'];

		//mencari nama akun//
		$qakun_awal_8 = @mysql_query("select * from akun where id_akun='$dawal_8[akun2]' ");
		$dakun_awal_8 = @mysql_fetch_assoc($qakun_awal_8);

		if(($t1_8 == '+')and($t2_8 == '-'))
		{
		$awal_8 = ($Tawal_8+$debet_awal9_8)-$kredit_awal9_8;
		}else
		if(($t1_8 == '-')and($t2_8 == '+'))
		{
		$awal_8 = ($Tawal_8-$debet_awal9_8)+$kredit_awal9_8;
		}

		$Tawal_8 = $awal_8;
		$Tawalribuan_8 = ribuan($Tawal_8);

		}
	}
}
if($Tawal_8 != '')
{
$T_8 = $Tawal_8;
$Tribuan_8= ribuan($T_8);
}else
{
$T_8 = 0;
$Tribuan_8= ribuan($T_8);
}

$q_8 = @mysql_query("select * from jurnal where tgl like '%$all%' order by tgl ");
$b_8 = @mysql_num_rows($q_8);
	while($d_8 = @mysql_fetch_assoc($q_8))
	{

		if($d_8['akun1']==$id_akun_8)
		{
		$tanggal_8 = tgl_indo($d_8['tgl']);
		$debet_8 = ribuan($d_8['debet1']); 	
		$kredit_8 = ribuan($d_8['kredit1']);
		$debet9_8 = $d_8['debet1']; 	
		$kredit9_8 = $d_8['kredit1'];

		//mencari nama akun//
		$qakun_8 = @mysql_query("select * from akun where id_akun='$d_8[akun1]' ");
		$dakun_8 = @mysql_fetch_assoc($qakun_8);

		//mengatur operator
		if(($t1_8 == '+')and($t2_8 == '-'))
		{
		$k_8 = ($T_8+$debet9_8)-$kredit9_8;
		}else
		if(($t1_8 == '-')and($t2_8 == '+'))
		{
		$k_8 = ($T_8-$debet9_8)+$kredit9_8;
		}
		$T_8 = $k_8;
		$Tribuan_8 = ribuan($T_8);

		}else
		if($d_8['akun2']==$id_akun_8)
		{
		$tanggal_8 = tgl_indo($d_8['tgl']);
		$debet_8 = ribuan($d_8['debet2']); 	
		$kredit_8 = ribuan($d_8['kredit2']);
		$debet9_8 = $d_8['debet2']; 	
		$kredit9_8 = $d_8['kredit2'];

		//mencari nama akun//
		$qakun_8 = @mysql_query("select * from akun where id_akun='$d_8[akun2]' ");
		$dakun_8 = @mysql_fetch_assoc($qakun_8);

		//mengatur operator
		if(($t1_8 == '+')and($t2_8 == '-'))
		{
		$k_8 = ($T_8+$debet9_8)-$kredit9_8;
		}else
		if(($t1_8 == '-')and($t2_8 == '+'))
		{
		$k_8 = ($T_8-$debet9_8)+$kredit9_8;
		}
		$T_8 = $k_8;
		$Tribuan_8 = ribuan($T_8);
		}
	}
	$TotalT_8 = $TotalT_8+$T_8;
	if($normal_8=='DEBET')
	{
	}else
	{
	}

	$x_8++;
}
$TotalT2_8=ribuan($TotalT_8);
?>
<?
$total_aktiva = $TotalT_8+$TotalT_7+$Total_persediaan_kmt+$Total_persediaan_mkl+$Total_persediaan_cf+$Total_persediaan_gudang+$TotalT_4+$TotalPiutang+$TotalT_2+$TotalT;
$total_aktiva2=ribuan($total_aktiva);
?>
<?
$total_pasiva = ($TotalT_9+$Tsaldo_akhir+$Totps22+($Totppa_awal+$Totppa)+$totallb)+($TotalT_10+$Tsa+$total_hutang_leasing_hl+$total_hutang_leasing)+$TotalT_11+$total_rl_semuanya;
$total_pasiva2=ribuan($total_pasiva);
?>
<?
$selisih = $total_aktiva-$total_pasiva;
$selisih2=ribuan($selisih);
echo"$selisih2";
?>
