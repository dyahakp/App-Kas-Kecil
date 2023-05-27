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
$usrvalid = '0';
$today = getdate();
$pcdate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
$pctime = date("H:i:s");

$sql = "insert into usrtable (usrcode,usrtopc,usrlevel,usrlimdb,usrlimcr,usrvalid,usrusrinp,usrtglinp,usrjaminp) values('$usrcode','$usrtopc','$usrlevel','$usrlimdb','$usrlimcr','$usrvalid','$userid','$pcdate','$pctime')";

$result = @sqlsrv_query($conn2, $sql);

if ($result) {
   $txtLogDesc = "Add a record (" . $usrcode . ") to table : USRTABLE";

   $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$pcdate', '$pctime', '$txtLogDesc')";
   $result = sqlsrv_query($conn2, $query);

   echo json_encode(array('success' => true));
} else {
   echo json_encode(array('msg' => 'Simpan Data Gagal'));
}
sqlsrv_close($conn2);
