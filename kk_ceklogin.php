<?php
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

// echo ($_SESSION['User']);

if (!isset($_SESSION['User']))
{
   echo ("<h2>Maaf Akses Anda Ditolak !<br>Silahkan LOGIN terlebih dahulu. <br></h2>");
		  
   include_once "kk_login.php";
   exit;
}
?>