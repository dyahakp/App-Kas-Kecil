<?php
session_start();
$userid = $_SESSION['User'];

// include "kk_ceklevel9.php";
include "kk_konek2.php";

$usrcode = $_REQUEST['usrcode'];
$usrtopc = $_REQUEST['usrtopc'];
$usrlevel = $_REQUEST['usrlevel'];
$usrlimdb = $_REQUEST['usrlimdb'];
$usrlimcr = $_REQUEST['usrlimcr'];

$sql = "update usrtable set usrtopc='$usrtopc',usrlevel='$usrlevel',usrlimdb='$usrlimdb',usrlimcr='$usrlimcr' where usrcode='$usrcode'";
$result = @sqlsrv_query($conn2, $sql);

if ($result) {
    $today = getdate();
    $txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
    $txtLogTime = date("H:i:s");
    $txtLogDesc = "Edit a record (" . $usrcode . ") in table : USRTABLE";

    $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
    $result = sqlsrv_query($conn2, $sql);

    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('msg' => 'Koreksi Data Gagal'));
}
sqlsrv_close($conn2);
