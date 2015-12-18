<?php

@session_start();

if (isset($_SESSION['username']) && isset($_SESSION['password']))
{
   if ($_SESSION['nik'] == "HumanResource And Development")
   {
		include("../koneksi.php");
		mysql_query("update user set aktiv='1' where leveluser='HumanResource And Development' ");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HRD</title>
</head>

<frameset rows="140,*" cols="*" frameborder="no" border="0" framespacing="0">
  <frame src="top.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
  <frameset rows="*" cols="192,*" framespacing="0" frameborder="no" border="0">
    <frame src="left2.html" name="leftFrame" scrolling="No" noresize="noresize" id="leftFrame" title="leftFrame" />
    <frame src="right2.php" name="mainFrame" id="mainFrame" title="mainFrame" />
  </frameset>
</frameset>
<noframes>
</noframes></html>
<?php
   }
   else
   {
		mysql_query("update user set aktiv='' where leveluser='HumanResource And Development' ");
		echo "<body style=\"background-image:url(../gambar/bg2.png); text-align:center\"><br><br><br><br><br><br><br><br><br><br>
		<h1>Maaf.. Anda bukan user berlevel Human Resource And Development</h1><br>Silahkan Login kembali...!!!<br>=== <a href=\"../index.php\"><b>LOGIN</b></a> ===";
   } 

}
else
{
   echo "<body style=\"background-image:url(../gambar/bg2.png); text-align:center\"><br><br><br><br><br><br><br><br><br><br>
   <h1>Maaf, Anda Harus Login Terlebih Dahulu...!!!</h1>
   <br>Silahkan Login kembali...!!!<br>=== <a href=\"../index.php\">LOGIN</a> ===";
}
?>