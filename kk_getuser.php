<?php
include "kk_konek2.php";

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

$kdkas = $_SESSION['Kdkas'];

$result = array();
$sql = sqlsrv_query($conn2, "select usrcode from usrtable where usrtopc = '$kdkas' order by usrcode");

while ($rows = sqlsrv_fetch_object($sql)) {
   array_push($result, $rows);
}

echo json_encode($result);

sqlsrv_close($conn2);
