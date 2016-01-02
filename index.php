<html>
    <head>
        <meta charset="utf-8">
        <title>BERKAH</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
        <link href="style/grid.less" rel="stylesheet/less" type="text/css" />
        <link href="style/form-base.less" rel="stylesheet/less" type="text/css" />
        <script src="js/less.js" type="text/javascript"></script>
        <style>
            [class*="colom-"],
            [class^="colom-"]{
                border:0px solid #434454;
            }
        </style>
    </head>
    <body class="bg-b1">
        <div class="container">
            <div class="row">
                <div class="colom-12 cntr-top">
                    <div class="colom-5 center">
                        <div class="colom-3 center"><img src="asset/img/big-logo.png" class="img-fix"></div>
<!--                    <div class="colom-9 center bg-kng">alert</div>-->
                    <div class="colom-9 center">
                        <form method="post" action="cek_login.php">
                            <input type="text" name="username" required="required" placeholder="Nama Pengguna" class="inp-mx"/>
                            <input type="password" name="password" required="required" placeholder="Kata Sandi" class="inp-mx"/>
                            <button type="submit" name="fSubmit" class="btn-mx bg-hj">Login</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
</html>
