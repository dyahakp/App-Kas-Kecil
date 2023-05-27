<?php
include "kk_konek2.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userid = $_SESSION['User'];
$tglval = $_SESSION['Today'];
$kdkas = $_SESSION['Kdkas'];
$trstgl = $_SESSION['tglquery'];
$result = array();

if (!empty($trstgl)) {
    $tglprs = substr($trstgl, 6, 4) . "-" . substr($trstgl, 3, 2) . "-" . substr($trstgl, 0, 2);
} else {
    $tglprs = substr($tglval, 0, 4) . "-" . substr($tglval, 4, 2) . "-" . substr($tglval, 6, 2);
}

$sql = "select trstopc, trsnota, trscode, trsvaluta, trsdesc, trsdbcr, trsreff, convert(varchar, convert(MONEY, trsnilai), 1) as trsnilai, trstorf, trsusrinp, trsusraut from trmaster where trstopc = '$kdkas' and trstglinp = '$tglprs'";

$hasil = sqlsrv_query($conn2, $sql);

while ($rows = sqlsrv_fetch_object($hasil)) {
    array_push($result, $rows);
}

// print_r($result);
echo json_encode($result);

sqlsrv_close($conn2);
