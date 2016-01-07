<?php
session_start();
error_reporting(0);
include "../include/paging.php";
include "../include/fungsi-std.php";
$jabatan = $_SESSION['jabatan'];
$unit= $_SESSION['unit'];
//$db="berkahgl_".strtolower($unit);
$db=strtolower($unit);
//open koneksi
konOpen($db);
$dir = $_GET['m'];
$f = $_GET['f'];
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
        <link rel="stylesheet" type="text/css" href="./style/imgareaselect/imgareaselect-animated.css" />
        <script type="text/javascript" src="./js/less.min.js"></script>
        <script type="text/javascript" src="./js/src-jquery.js"></script>
        <script type="text/javascript" src="./js/script.js"></script>
        <script type="text/javascript" src="./js/jquery.imgareaselect.pack.js"></script>
        <script>
            $(document).ready(function () {
                $(".btn-def").click(function () {
                    $("#kiri").toggleClass("kiri-sm");
                });
            });
        </script>
    </head>
    <body>
        <div id="kiri">
            <?php 
            self_dir("konten-kiri"); 
            ?>
        </div>
        <div id="main">
            <div id="main_menu">
                <?php self_dir("miniheader"); ?>
            </div>
            <div id="main_content">
            <?php
            if ($dir != NULL) {
                //memanggil  fungsi direktori
                r_dir($dir, $f);
            } else {
                echo "awal";
            }
            ?>
            </div>
        </div>
</html>