<?php
session_start();
$userid = $_SESSION['User'];
$trstopc = $_SESSION['Kdkas'];

include "kk_konek2.php";

$result = array();
$sql = "SELECT rfcode, rfdesc, rftopc, rfvalid FROM rftable WHERE rftopc = '$trstopc' ORDER BY rfcode";
$query = sqlsrv_query($conn2, $sql);

while ($rows = sqlsrv_fetch_object($query)) {
   array_push($result, $rows);
}

echo json_encode($result);

sqlsrv_close($conn2);
