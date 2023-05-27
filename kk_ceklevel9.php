<?php
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

$txtLevel = $_SESSION['Level'];

if ($txtLevel != "9") 
{
   echo ("<h2>Maaf Akses Anda Ditolak !</h2>");
   exit;
}
?>