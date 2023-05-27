<?php
include "kk_konek2.php";

$result = array();
$sql = sqlsrv_query($conn2, "select pccode, pcname, pcbranch, pcabrev, pcdept, pcregion, pcdate, pcnosl, pckasbon, pcvalid from pcmaster order by pccode");

while ($rows = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
   array_push($result, $rows);
}

echo json_encode($result);

sqlsrv_close($conn2);
