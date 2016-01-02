<?php
  session_start();
  session_destroy();
  echo "<script>alert('Anda Telah Keluar dari Halaman Administrator'); window.location = 'index.php'</script>";
?>