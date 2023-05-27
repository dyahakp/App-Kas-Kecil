<?php
include "kk_konek2.php";

$sql = sqlsrv_query($conn2, "select glcode, glname from gltable");
$result = array();

while ($rows = sqlsrv_fetch_object($sql)) {
   array_push($result, $rows);
}

echo json_encode($result);

sqlsrv_close($conn2);
