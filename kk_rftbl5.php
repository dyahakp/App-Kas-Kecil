<?php
session_start();
$userid = $_SESSION['User'];

// include "kk_ceklevel9.php";
include "kk_konek2.php";

$rfcode = $_REQUEST['rfcode'];
$rfdesc = $_REQUEST['rfdesc'];
$rftopc = $_REQUEST['rftopc'];
$today = getdate();
$pcdate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
$pctime = date("H:i:s");
$input = " ";

$sql = "select rfusrinp from rftable where rfcode = '$rfcode'";
$result = @sqlsrv_query($conn2, $sql);

if ($result) {
    while ($record = (sqlsrv_fetch_array($result))) {
        $input = trim($record['rfusrinp']);
    }

    if ($userid == $input) {
        echo json_encode(array('msg' => 'User sama dengan Input'));
    } else {
        $sql = "update rftable set rfvalid = '1', rfusraut = '$userid', rftglaut = '$pcdate', rfjamaut = '$pctime' where rfcode = '$rfcode' and rftopc = '$rftopc'";
        $result = @sqlsrv_query($conn2, $sql);

        if ($result) {
            $txtLogDesc = "Authorize a record (" . $pccode . ") in table : TRTABLES";

            $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$pcdate', '$pctime', '$txtLogDesc')";
            $result = sqlsrv_query($conn2, $query);

            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => 'Otorisasi Data Gagal'));
        }
    }
}
sqlsrv_close($conn2);
