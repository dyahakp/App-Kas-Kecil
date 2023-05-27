<?php
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

$userid = $_SESSION['User'];

include "kk_ceklogin.php";
include "kk_konek3.php";

$query = "SELECT FACNO, FNAMA FROM GLMACC WHERE FTYPE = 'D' AND FKDCAB = '999'";
$result = sqlsrv_query($conn3, $query);

if ($result) {
   $hasil = array();

   while ($record = (sqlsrv_fetch_array($result))) {
      array_push($hasil, array($record[0], $record[1]));
   }

   sqlsrv_close($conn3);
   include "kk_konek2.php";

   $query = "TRUNCATE TABLE GLTABLE";
   $result = sqlsrv_query($conn2, $query);

   if ($result) {
      for ($i = 0, $c = count($hasil); $i < $c; $i++) {
         $stmt = sqlsrv_prepare($konek2, "EXEC sp_append_gltable ?, ?");
         $param1 = $hasil[$i][0];
         $param2 = $hasil[$i][1];
         $params = array(&$param1, &$param2);
         if (sqlsrv_execute($stmt, $params)) {
            // Execution successful
            echo "Stored procedure executed successfully";
         } else {
            // Execution failed
            echo "Error executing stored procedure: ";
            die(print_r(sqlsrv_errors(), true));
         }
      }
   }

   $today = getdate();
   $txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
   $txtLogTime = date("H:i:s");
   $txtLogDesc = "Accessing table : GLTABLE";

   $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
   $result = sqlsrv_query($conn2, $query);

   sqlsrv_close($conn2);

   include "kk_gltbl1.php";
}
