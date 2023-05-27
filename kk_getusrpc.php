<?php
include "kk_konek2.php";

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

$userid = $_SESSION['User'];

$result = array();
$sql = sqlsrv_query($conn2, "select usrtopc from usrtable where usrcode = '$userid' and usrlevel = '1' order by usrtopc");

while ($rows = sqlsrv_fetch_object($sql)) {
   array_push($result, $rows);
}

echo json_encode($result);

sqlsrv_close($conn2);
