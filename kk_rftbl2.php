<?php
session_start();
$userid = $_SESSION['User'];

// include "kk_ceklevel9.php";
include "kk_konek2.php";

$rfcode = $_REQUEST['rfcode'];
$rfdesc = $_REQUEST['rfdesc'];
$rftopc = $_REQUEST['rftopc'];
$rfvalid = '0';
$today = getdate();
$pcdate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
$pctime = date("H:i:s");

$sql = "insert into rftable (rfcode,rfdesc,rftopc,rfvalid,rfusrinp,rftglinp,rfjaminp) values ('$rfcode','$rfdesc','$rftopc','$rfvalid','$userid','$pcdate','$pctime')";

$result = @sqlsrv_query($conn2, $sql);

if ($result) {
   $txtLogDesc = "Add a record (" . $rfcode . ") to table : RFTABLE";

   $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$pcdate', '$pctime', '$txtLogDesc')";
   $result = sqlsrv_query($conn2, $query);

   echo json_encode(array('success' => true));
} else {
   echo json_encode(array('msg' => $sql));
}
sqlsrv_close($conn2);
