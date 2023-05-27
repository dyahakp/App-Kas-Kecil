<?php
session_start();
$userid = $_SESSION['User'];

// include "kk_ceklevel9.php";
include "kk_konek2.php";

$pccode = $_REQUEST['pccode'];
$pcname = $_REQUEST['pcname'];
$pcbranch = $_REQUEST['pcbranch'];
$pcabrev = $_REQUEST['pcabrev'];
$pcdept = $_REQUEST['pcdept'];
$pcregion = $_REQUEST['pcregion'];
$pcnosl = $_REQUEST['pcnosl'];
$pckasbon = $_REQUEST['pckasbon'];
			   			   
$sql = "UPDATE pcmaster SET pcname=?, pcbranch=?, pcabrev=?, pcdept=?, pcregion=?, pcnosl=?, pckasbon=? WHERE pccode=?";
$params = array($pcname, $pcbranch, $pcabrev, $pcdept, $pcregion, $pcnosl, $pckasbon, $pccode);
$result = sqlsrv_query($conn2, $sql, $params);

if ($result)
{
    $today = getdate();
    $txtLogDate = (new DateTime())->format('Y-m-d'); 
    $txtLogTime = (new DateTime())->format('H:i:s');
    $txtLogDesc = "Edit a record (" . $pccode . ") in table : PCMASTER";
    
    $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES (?, ?, ?, ?)";
    $params = array($userid, $txtLogDate, $txtLogTime, $txtLogDesc);
    $result = sqlsrv_query($conn2, $query, $params);
	
    echo json_encode(array('success'=>true));
} 
else 
{
    echo json_encode(array('msg'=>'Koreksi Data Gagal'));
}
sqlsrv_close($conn2);
