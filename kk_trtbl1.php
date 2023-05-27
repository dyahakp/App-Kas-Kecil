<?php
session_start();
$userid = $_SESSION['User'];
$trstopc = $_SESSION['Kdkas'];

include "kk_konek2.php";

$restr = array();
$sql = sqlsrv_query($conn2, "select trcode,trdesc,trtopc,trnosl,trvalid from trtable where trtopc = '$trstopc' order by trcode");

while ($rows = sqlsrv_fetch_object($sql)) {
   array_push($restr, $rows);
}

echo json_encode($restr);

sqlsrv_close($conn2);
