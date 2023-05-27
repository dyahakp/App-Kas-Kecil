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
$pcdate = (new DateTime())->format('Y-m-d'); // Current date in the format YYYY-MM-DD
$pctime = (new DateTime())->format('H:i:s'); // Current time in the format HH:MM:SS
$input = " ";

$sql = "select pcusrinp from pcmaster where pccode = '$pccode'";
$result = @sqlsrv_query($conn2, $sql);

if ($result) {
    while ($record = (sqlsrv_fetch_array($result))) {
        $input = trim($record['pcusrinp']);
    }

    if ($userid == $input) {
        echo json_encode(array('msg' => 'User sama dengan Input'));
    } else {
        $sql = "update pcmaster set pcvalid = '1', pcusraut = '$userid', pctglaut = '$pcdate', pcjamaut = '$pctime' where pccode='$pccode'";
        $result = @sqlsrv_query($conn2, $sql);

        if ($result) {
            $tmpHasil = 0;

            $sql = "select count(*) as ada from blmaster where bltopc='$pccode'";
            $result = @sqlsrv_query($conn2, $sql);

            while ($record = (sqlsrv_fetch_array($result))) {
                $tmpHasil = trim($record['ADA']);
            }

            if ($tmpHasil == 0) {
                $sql = "insert into blmaster (bldate, bltopc, blopval, blclval, blopjam, blcljam, blopusr, blclusr) values (getdate(), '$pccode', 0, 0, '00:00:00', '00:00:00', 'AUTO', 'AUTO')";
                $result = @sqlsrv_query($conn2, $sql);

                if ($result) {
                    $txtLogDesc = "Authorize a record (" . $pccode . ") in table : PCMASTER";

                    $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$pcdate', '$pctime', '$txtLogDesc')";
                    $result = sqlsrv_query($conn2, $query);

                    echo json_encode(array('success' => true));
                } else {
                    echo json_encode(array('msg' => 'Proses Otorisasi Data Gagal'));
                }
            }
        } else {
            echo json_encode(array('msg' => 'Otorisasi Data Gagal'));
        }
    }
}
sqlsrv_close($conn2);
