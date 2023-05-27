<?php
session_start();
$userid = $_SESSION['User'];

// include "kk_ceklevel9.php";
include "kk_konek2.php";

$trcode = $_REQUEST['trcode'];
$trdesc = $_REQUEST['trdesc'];
$trtopc = $_REQUEST['trtopc'];
$trnosl = $_REQUEST['trnosl'];

$sql = "delete from trtable where trcode = '$trcode'";
$result = @sqlsrv_query($conn2, $sql);

if ($result) {
    $today = getdate();
    $txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
    $txtLogTime = date("H:i:s");
    $txtLogDesc = "Delete a record (" . $trcode . ") from table : TRTABLE";

    $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
    $result = sqlsrv_query($conn2, $query);

    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('msg' => 'Hapus Data Gagal'));
}
sqlsrv_close($conn2);
