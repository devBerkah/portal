<html>
<head>
	<meta charset="utf-8">
	<title>main base</title>
    <link href="../style/grid.less" rel="stylesheet/less" type="text/css" />
    <script src="../js/less.js" type="text/javascript"></script>
    <style>
		[class*="colom-"],
		[class^="colom-"]{
			border:1px solid #434454;
		}
	</style>
</head>
<body>
<div class="container">
   <div class="row">
    	<div class="colom-12">
            <div class="colom-11 center">
                head
            </div>
            <div class="colom-11 center">
                <?php include 'menu.php';?>
            </div>
            <div class="colom-11 center">
                body
            </div>
            <div class="colom-11 center">
                footer
            </div>
        </div>
   </div>
</div>
</body>
</html>
