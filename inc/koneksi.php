<?php
$koneksi = mysqli_connect($xhostname, $xusername, $xpassword, $xdatabase);


// Check connection
if (mysqli_connect_errno()) {
  echo "Koneksi ERROR: " . mysqli_connect_error();
  exit();
}




?>