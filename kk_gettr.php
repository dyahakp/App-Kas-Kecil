<?php
include "kk_konek2.php";

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

$kodetrs = $_SESSION['Kdkas'];

$result = array();
$sql = sqlsrv_query($conn2, "select trcode from trtable where trtopc = '$kodetrs' and trvalid = '1' order by trcode");

while ($rows = sqlsrv_fetch_object($sql)) {
   array_push($result, $rows);
}

echo json_encode($result);

sqlsrv_close($conn2);
