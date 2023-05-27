<?php
include "kk_konek2.php";

session_start();
$userid = $_SESSION['User'];
$tglval = $_SESSION['Today'];
$result = array();

$sql = sqlsrv_query($conn2, "select trstopc,trsnota,trscode,convert(nvarchar(10), trsvaluta, 103) as trsvaluta,trsdesc,trsdbcr,trsreff,convert(varchar, convert(MONEY, trsnilai), 1) as trsnilai,trstorf from trmaster where trsusrinp = '$userid' and trstglinp = '$tglval' and isnull(trsusraut,'          ') = '          ' order by trsreff");

while ($rows = sqlsrv_fetch_object($sql)) {
   array_push($result, $rows);
}

// print_r($result);
echo json_encode($result);

sqlsrv_close($conn2);
