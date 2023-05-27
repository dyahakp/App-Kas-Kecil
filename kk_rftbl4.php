<?php
session_start();
$userid = $_SESSION['User'];

// include "kk_ceklevel9.php";
include "kk_konek2.php";

$rfcode = $_REQUEST['rfcode'];
$rfdesc = $_REQUEST['rfdesc'];
$rftopc = $_REQUEST['rftopc'];

$sql = "update rftable set rfdesc='$rfdesc',rftopc='$rftopc' where rfcode='$rfcode' and rftopc='$rftopc'";
$result = @sqlsrv_query($conn2, $sql);

if ($result) {
    $today = getdate();
    $txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
    $txtLogTime = date("H:i:s");
    $txtLogDesc = "Edit a record (" . $rfcode . ") in table : RFTABLE";

    $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
    $result = sqlsrv_query($conn2, $query);

    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('msg' => 'Koreksi Data Gagal'));
}
sqlsrv_close($conn2);
