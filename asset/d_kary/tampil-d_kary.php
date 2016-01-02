<?php
$act = htmlspecialchars(mysql_escape_string($_GET["act"]));
$mod = htmlspecialchars(mysql_escape_string($_GET['m']));
?>
<h1><label class="headlabel"><i class="fa fa-users"></i> <b>DATA KARYAWAN</b></label></h1>
<div class="subMenu">
    <ul>
        <a href='karyawan'><li <?php echo subaktif($act, "");?>><i class="fa fa-database"></i><label> Tampil Karyawan</label></li></a>
        <a href='add_karyawan'><li <?php echo subaktif($act, "input");?>><i class="fa fa-plus-circle"></i><label> Tambah Karyawan</label></li></a>
        <li class="inp"><input type="text" class="inp-mx mx f-inline" placeholder="cari disini..."></li>
    </ul>
</div>
<div class="box-data">
    <!--data karyawan-->
    <?php
    if ($act == "") {
        include("data-d_kary.php");
    } else {
        include "$act-d_kary.php";
    }
    ?>
</div>