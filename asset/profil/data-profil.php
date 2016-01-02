<div class="box-img bg-pth pd-reg">
    <div class="box-foto">
        <a href="profil"><img src="./asset/img-user/user1.jpg"></a>
    </div>
    <a href="dp-change"><button class="btn-reg"><i class="fa fa-image"></i> Ubah Foto Tampilan</button></a>
    <a href="pass-change"><button class="btn-ok"><i class="fa fa-edit"></i> Ubah Kata Sandi</button></a>
</div>
<div>
    <!--main-->
    <?php
    $main=  htmlspecialchars(mysql_escape_string($_GET["main"]));
        if($main != ""){
            include "$main-profil.php";
        }else{
            include "detail-profil.php";
        }
    ?>

</div>