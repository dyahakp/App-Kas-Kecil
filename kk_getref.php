<?php
include "kk_konek2.php";

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

$kodepc = $_SESSION['Kdkas'];

$result = array();
$sql = sqlsrv_query($conn2, "select rfcode from rftable where rftopc = '$kodepc' and rfvalid = '1' order by rfcode");

while ($rows = sqlsrv_fetch_object($sql)) {
   array_push($result, $rows);
}

//print_r($result);   
echo json_encode($result);

sqlsrv_close($conn2);
