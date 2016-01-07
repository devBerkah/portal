<?php
$act = htmlspecialchars(mysql_escape_string($_GET["act"]));
$mod = htmlspecialchars(mysql_escape_string($_GET['m']));
?>
<?php 
$jabatan = $_SESSION['jabatan'];
$db= "berkahgl_".strtolower($_SESSION['unit']);
?>
<h1><label class="headlabel"><i class="fa fa-tasks"></i> <b>PRODUKSI</b></label></h1>
<div class="subMenu">
    <ul>
        <a href='stokayam'><li <?php echo subaktif($act, "stokayam");?>><i class="fa fa-database"></i><label> Stok Ayam</label></li></a>
        <a href='inputbop'><li <?php echo subaktif($act, "inputbop");?>><i class="fa fa-database"></i><label> Input BOP</label></li></a>
        <a href='karyawan'><li><i class="fa fa-print"></i><label> Cetak RHPP FARM</label></li></a>
        <a href='karyawan'><li><i class="fa fa-print"></i><label> Cetak RHPP COMPANY</label></li></a>
        <a href='karyawan'><li><i class="fa fa-file"></i><label> Resume Laporan</label></li></a>
        <a href='piutangsap'><li><i class="fa fa-check"></i><label> Fix & Pot. Sapronak</label></li></a>
    </ul>
</div>
<div class="box-data">
    <!--data karyawan-->
    <?php
    if ($act == "") {
        
    } else {
        include "$act-produksi.php";
    }
    ?>
</div>