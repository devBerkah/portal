<?php

	include "include/koneksi.php";
	
	$username=$_POST['username'];
	$password=md5($_POST['password']);

	$login=mysql_query("Select * from login where username='$username' AND password='$password'");
	
	$ada=mysql_num_rows($login);
	$data=mysql_fetch_array($login);

	if ($ada > 0) {
		session_start();
		$_SESSION['username'] = $data['username'];
		$_SESSION['password'] = $data['password'];
		$_SESSION['nik'] = $data['nik'];
		
?>
	
	<input type=hidden name=nik value=<?php $data['nik'] ?>>
	
<?php
			header('location:beranda');
		}
		else
		{
			echo"<script>alert('Username atau Password yang anda masukan salah');</script>";
			echo"<script>window.location.href='index.php#!/page_Login'</script>";
		}
?>