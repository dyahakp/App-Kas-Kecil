<?php
session_start();

// echo ($_SESSION['User']);
?>
<html>

<head>
   <title>Untitled Document</title>
   <style type="text/css">
      .style1 {
         font-family: Verdana, Arial, Helvetica, sans-serif;
         font-weight: bold;
      }
   </style>
</head>

<body>
   <?php
   // session_start();
   if (session_status() === PHP_SESSION_NONE) {
      session_start();
   }

   include "kk_konek1.php";

   if (isset($_SESSION['User'])) {
      $userid = $_SESSION['User'];
      $tmpresult = 0;

      $query = "EXEC uspLogoffPHP @userid = ?, @result = ?";

      $params = array(&$userid, &$tmpresult);
      $stmt = sqlsrv_prepare($conn1, $query, $params);

      if ($stmt) {
         if (sqlsrv_execute($stmt)) {
            $txtHasil = 0;
            while ($obj = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
               $txtHasil = $obj['TMPRESULT'];
            }

            if ($txtHasil == 1) {
               $query = "UPDATE t_users SET status = 0 WHERE userid = '$userid'";
               $result = sqlsrv_query($conn1, $query);

               $_SESSION = array();
               session_destroy();

               sqlsrv_close($conn1);
   ?>
               <p class="style1">Terima kasih,</p>
               <p class="style1">Untuk kembali Login, silahkan klik <a href="kk_login.php"><em>disini</em></a>. </p>
   <?php
               include "kk_konek2.php";

               $today = getdate();
               $txtLogDate = $today['year'] . "-" . $today['mon'] . "-" . $today['mday'];
               $txtLogTime = date("H:i:s");
               $txtLogDesc = "User Loging-out";

               $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";

               $result = sqlsrv_query($conn2, $query);

               sqlsrv_close($conn2);
            } else {
               echo ('Logout Tidak Berhasil !');
               sqlsrv_close($conn1);
            }
         } else {
            echo ('Logout Gagal !');
            sqlsrv_close($conn1);
         }
      }
   }
   exit;
   ?>
</body>

</html>