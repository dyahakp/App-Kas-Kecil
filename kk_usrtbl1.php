<?php
session_start();
$userid = $_SESSION['User'];
$trstopc = $_SESSION['Kdkas'];

include "kk_konek2.php";

$result = array();
sqlsrv_query($conn2, "use kaskecil");
$sql = sqlsrv_query($conn2, "select usrcode,usrtopc,usrlevel,convert(varchar, convert(MONEY, usrlimdb), 1) as usrlimdb,convert(varchar, convert(MONEY, usrlimcr), 1) as usrlimcr,usrvalid from usrtable where usrtopc='$trstopc' order by usrcode");

while ($rows = sqlsrv_fetch_object($sql)) {
   array_push($result, $rows);
}

echo json_encode($result);
sqlsrv_close($conn2);
