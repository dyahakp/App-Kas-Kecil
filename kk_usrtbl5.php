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
$pcdate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
$pctime = date("H:i:s");
$input = " ";

$sql = "select usrusrinp from usrtable where usrcode = '$usrcode'";
$result = @sqlsrv_query($conn2, $sql);

if ($result) {
    while ($record = (sqlsrv_fetch_array($result))) {
        $input = trim($record['usrusrinp']);
    }

    if ($userid == $input) {
        echo json_encode(array('msg' => 'User sama dengan Input'));
    } else {
        $sql = "update usrtable set usrvalid = '1', usrusraut = '$userid', usrtglaut = '$pcdate', usrjamaut = '$pctime' where usrcode = '$usrcode'";
        $result = @sqlsrv_query($conn2, $sql);

        if ($result) {
            $txtLogDesc = "Authorize a record (" . $usrcode . ") in table : USRTABLE";

            $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$pcdate', '$pctime', '$txtLogDesc')";
            $result = sqlsrv_query($conn2, $query);

            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => 'Otorisasi Data Gagal'));
        }
    }
}
sqlsrv_close($conn2);
