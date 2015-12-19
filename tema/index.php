<?php
session_start();
include "../include/fungsi-std.php";
include "../include/koneksi.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
        <title>Portal</title>
        <link rel="stylesheet" href="./style/fa/font-awesome.css">
        <link rel="stylesheet/less" href="./style/layout.less">
        <script type="text/javascript" src="./js/less.min.js"></script>
        <script type="text/javascript" src="./include/src-jquery.js"></script>
    </head>
    <body>
        <div id="kiri">
            <?php self_dir("konten-kiri"); ?>
        </div>
        <div id="main">
            <?php
            $dir = $_GET['m'];
            $f = $_GET['f'];
            if($dir != NULL){
            //memanggil  fungsi direktori
            r_dir($dir, $f);}else{
                echo "awal";
            }
            ?>
        </div>
    </body>
</html>