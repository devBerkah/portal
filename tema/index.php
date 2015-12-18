<?php
session_start();
//include "cek_session.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
        <title>Portal</title>
        <link rel="stylesheet" href="../style/fa/font-awesome.css">
        <link rel="stylesheet/less" href="../style/layout.less">
        <script type="text/javascript" src="../js/less.min.js"></script>
        <script type="text/javascript" src="../include/src-jquery.js"></script>
    </head>
    <body>
        <div id="kiri">
            <?php include 'konten-kiri.php';?>
        </div>
        <div id="main">
            <h1 class="headlabel">JUDUL <i class="fa fa-android"></i></h1>
            <div class="subMenu">
                <ul>
                    <li>sub</li>
                    <li>sub</li>
                    <li>sub</li>
                    <li>sub</li>
                    <li>sub</li>
                </ul>
            </div>
            <span class="labdev"></span>
        </div>
    </body>
</html>