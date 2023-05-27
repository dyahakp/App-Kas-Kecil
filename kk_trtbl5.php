<?php
session_start();
$userid = $_SESSION['User'];

// include "kk_ceklevel9.php";
include "kk_konek2.php";

$trcode = $_REQUEST['trcode'];
$trdesc = $_REQUEST['trdesc'];
$trtopc = $_REQUEST['trtopc'];
$trnosl = $_REQUEST['trnosl'];
$today = getdate();
$pcdate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
$pctime = date("H:i:s");
$input = " ";

$sql = "select trusrinp from trtable where trcode = '$trcode'";
$result = @sqlsrv_query($conn2, $sql);

if ($result) {
    while ($record = (sqlsrv_fetch_array($result))) {
        $input = trim($record['trusrinp']);
    }

    if ($userid == $input) {
        echo json_encode(array('msg' => 'User sama dengan Input'));
    } else {
        $sql = "update trtable set trvalid = '1', trusraut = '$userid', trtglaut = '$pcdate', trjamaut = '$pctime' where trcode = '$trcode'";
        $result = @sqlsrv_query($conn2, $sql);

        if ($result) {
            $txtLogDesc = "Authorize a record (" . $trcode . ") in table : TRTABLE";

            $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$pcdate', '$pctime', '$txtLogDesc')";
            $result = sqlsrv_query($conn2, $query);

            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => 'Otorisasi Data Gagal'));
        }
    }
}
sqlsrv_close($conn2);
