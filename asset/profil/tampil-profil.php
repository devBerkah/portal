<?php
$act = htmlspecialchars(mysql_escape_string($_GET["act"]));
$mod = htmlspecialchars(mysql_escape_string($_GET['m']));
?>
<label class="headlabel"><i class="fa fa-user"></i> <b>Profil</b></label><br><br>
<div class="box-data">
    <!--data karyawan-->
    <?php
    if ($act == "") {
        include("data-profil.php");
    } else {
        include "$act-profil.php";
    }
    ?>
</div>