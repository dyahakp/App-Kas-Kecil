<?php
session_start();
$userid = $_SESSION['User'];

// include "kk_ceklevel9.php";
include "kk_konek2.php";

$trcode = $_REQUEST['trcode'];
$trdesc = $_REQUEST['trdesc'];
$trtopc = $_REQUEST['trtopc'];
$trnosl = $_REQUEST['trnosl'];
$trvalid = '0';

$sql = "insert into trtable (trcode,trdesc,trtopc,trnosl,trvalid,trusrinp,trtglinp,trjaminp) values('$trcode','$trdesc','$trtopc','$trnosl','$trvalid','$userid','$pcdate','$pctime')";

$result = @sqlsrv_query($konek2, $sql);

if ($result) {
   $today = getdate();
   $pcdate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
   $pctime = date("H:i:s");
   $txtLogDesc = "Add a record (" . $trcode . ") to table : TRTABLE";

   $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$pcdate', '$pctime', '$txtLogDesc')";
   $result = sqlsrv_query($konek2, $query);

   echo json_encode(array('success' => true));
} else {
   echo json_encode(array('msg' => 'Simpan Data Gagal'));
}
sqlsrv_close($konek2);
