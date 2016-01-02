<?php
$dir = htmlspecialchars(mysql_escape_string($_GET['m']));
$f = htmlspecialchars(mysql_escape_string($_GET['f']));
?>
<div class="logo-kiri"><button class="btn-def"><i class="fa fa-ellipsis-h" id="tray"></i></button></div>
<div class="subMainMenu">
    <ul>
        <li <?php echo menuaktif($dir, ""); ?>><a href='beranda' ><i class="fa fa-home"></i> <label>Beranda</label> </a></li>
        <li <?php echo menuaktif($dir, "d_kary"); ?> ><a href='karyawan' ><i class="fa fa-users"></i> <label>Karyawan</label> </a></li>
        <li><a href='#'><i class="fa fa-exchange"></i> <label>Mutasi</label> </a></li>
        <li><a href='#'><i class="fa fa-calendar"></i> <label>Absensi</label> </a></li>
        <li><a href='#'><i class="fa fa-credit-card"></i> <label>Penggajian</label> </a></li>
        <li><a href='keluar'><i class="fa fa-sign-out"></i> <label>Keluar</label></a></li>
    </ul>    
</div>