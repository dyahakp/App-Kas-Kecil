<?php
// include "kk_ceklevel9.php";
include "kk_konek2.php";

$usrcode = $_REQUEST['usrcode'];
$usrtopc = $_REQUEST['usrtopc'];
$usrlevel = $_REQUEST['usrlevel'];
$usrlimdb = $_REQUEST['usrlimdb'];
$usrlimcr = $_REQUEST['usrlimcr'];

$sql = "delete from usrtable where usrcode = '$usrcode'";
$result = @sqlsrv_query($conn2, $sql);

if ($result) {
    $today = getdate();
    $txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
    $txtLogTime = date("H:i:s");
    $txtLogDesc = "Delete a record (" . $usrcode . ") from table : USRTABLE";

    $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
    $result = sqlsrv_query($conn2, $query);

    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('msg' => 'Hapus Data Gagal'));
}
sqlsrv_close($conn2);
