<?php
session_start();
$userid = $_SESSION['User'];

// include "kk_ceklevel9.php";
include "kk_konek2.php";

$today = getdate();
$pccode = $_REQUEST['pccode'];
$pcname = $_REQUEST['pcname'];
$pcbranch = $_REQUEST['pcbranch'];
$pcabrev = $_REQUEST['pcabrev'];
$pcdept = $_REQUEST['pcdept'];
$pcregion = $_REQUEST['pcregion'];
$pcnosl = $_REQUEST['pcnosl'];
$pckasbon = $_REQUEST['pckasbon'];
$pcstatus = '0';
$pcdate = (new DateTime())->format('Y-m-d'); // Current date in the format YYYY-MM-DD
$pctime = (new DateTime())->format('H:i:s'); // Current time in the format HH:MM:SS
$pcvalid = '0';

$sql = "INSERT INTO pcmaster (pccode, pcname, pcbranch, pcabrev, pcdept, pcregion, pcdate, pcnosl, pcvalid, pcusrinp, pctglinp, pcjaminp, pckasbon) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$params = array(
    $pccode,
    $pcname,
    $pcbranch,
    $pcabrev,
    $pcdept,
    $pcregion,
    $pcdate,
    $pcnosl,
    $pcvalid,
    $userid,
    $pcdate,
    $pctime,
    $pckasbon
);

$result = sqlsrv_prepare($conn2, $sql, $params);

if ($result && sqlsrv_execute($result)) {
    $txtLogDesc = "Add a record (" . $pccode . ") to table : PCMASTER";

    $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES (?, ?, ?, ?)";
    $logParams = array($userid, $pcdate, $pctime, $txtLogDesc);
    $logresult = sqlsrv_prepare($conn2, $query, $logParams);

    if ($logresult && sqlsrv_execute($logresult)) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('msg' => 'Simpan Data Gagal'));
    }
} else {
    echo json_encode(array('msg' => 'Simpan Data Gagal'));
}

sqlsrv_close($conn2);
