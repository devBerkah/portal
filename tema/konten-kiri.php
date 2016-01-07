<?php
$jabatan = $_SESSION['jabatan'];
$unit= $_SESSION['unit'];
echo $unit."-".$jabatan;
$dir = htmlspecialchars(mysql_escape_string($_GET['m']));
$f = htmlspecialchars(mysql_escape_string($_GET['f']));
?>
<div class="logo-kiri"><button class="btn-def"><i class="fa fa-ellipsis-h" id="tray"></i></button></div>
<div class="box-user">
    <?php include 'user-data.php'; ?>
</div>
<div id='cssmenu'>
    <?php
    switch ($jabatan) {
        case "FIN":
            include_once 'menu/menu-finunit.php';
            break;
        default :
            include_once 'menu-hrd.php';
    }
    ?>
</div>