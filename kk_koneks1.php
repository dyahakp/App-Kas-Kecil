<?php
session_start();
?>
<html>

<head>
   <meta charset="UTF-8">
   <title>Basic Form - jQuery EasyUI Demo</title>
   <link rel="stylesheet" type="text/css" href="jquery-easyui-1.10.16/themes/default/easyui.css">
   <link rel="stylesheet" type="text/css" href="jquery-easyui-1.10.16/themes/icon.css">
   <link rel="stylesheet" type="text/css" href="jquery-easyui-1.10.16/demo/demo.css">
   <script type="text/javascript" src="jquery-easyui-1.10.16/jquery.min.js"></script>
   <script type="text/javascript" src="jquery-easyui-1.10.16/jquery.easyui.min.js"></script>
   <style type="text/css">
      .style1 {
         font-family: Verdana, Arial, Helvetica, sans-serif;
         font-weight: bold;
      }
   </style>
</head>

<body>
   <?php

   if (trim($_POST['textUserid']) == "") {
      echo ('User-id. tidak boleh kosong !');
   } elseif (trim($_POST['textPassword']) == "") {
      echo ('Password tidak boleh kosong !');
   } else {
      include "kk_konek1.php";
      $serverName = "desktop-at7mpm7";
      $connectionOptions = array(
         "Database" => "SECURE",
         "UID" => "",
         "PWD" => "",
         "CharacterSet" => "UTF-8"
      );

      $konek1 = sqlsrv_connect($serverName, $connectionOptions);

      $txtUserid = $_POST['textUserid'];
      $txtPassword = $_POST['textPassword'];
      $txtNamaUser = ' ';
      $txtLevel = '0';
      $txtToday = '20000101';
      $tmpHasil = 0;
      $txtLimitDb = 0;
      $txtLimitCr = 0;

      $query = "SELECT COUNT(*) AS ADA FROM t_usraplikasi WHERE userid = '$txtUserid' AND kodeaplikasi = '00007'";
      $result = sqlsrv_query($konek1, $query);

      while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
         $tmpHasil = trim($record['ADA']);
      }

      if ($tmpHasil == 0) {
         echo ('User-id. Tidak Terdaftar !');
         sqlsrv_close($konek1);
      } else {
         $query = "SELECT USERNAME, CONVERT(char(1), LEVEL) AS LEVEL, EXPIRE, CONVERT(INT, EXPIRE - GETDATE()) + 1 AS HARI, CONVERT(char, GETDATE(), 112)  AS HARIINI FROM t_users WHERE userid = '$txtUserid'";
         $result = sqlsrv_query($konek1, $query);

         if ($result === false) {
            echo ('SQL Query Error!');
            sqlsrv_close($konek1);
         } else {
            $sisahari = -1;

            while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
               $txtNamaUser = $record['USERNAME'];
               $sisahari = $record['HARI'];
               $txtToday = $record['HARIINI'];
               $txtLevel = $record['LEVEL'];
            }

            if ($sisahari > 0 && $sisahari < 15) {
               echo ('Password hampir Kadaluarsa');

               $query = "EXEC uspChangePassPHP @userid=?, @pass=?, @result=?";

               $params = array(
                  array(&$txtUserid, SQLSRV_PARAM_IN),
                  array(&$txtPassword, SQLSRV_PARAM_IN),
                  array(&$txtPassword, SQLSRV_PARAM_OUT)
               );

               $stmt = sqlsrv_prepare($konek1, $query, $params);
               $result = sqlsrv_execute($stmt);

               if ($result === false) {
                  echo ('Failed to execute the stored procedure.');
               }

               sqlsrv_free_stmt($stmt);
            }

            $tmpresult = '99                                                  ';
            $txtKdApl = '00007';
            $txtHasil = '';

            $query = "EXEC uspLogonPHP @userid=?, @kode_aplikasi=?, @pass=?, @result=?";

            $params = array(
               array(&$txtUserid, SQLSRV_PARAM_IN),
               array(&$txtKdApl, SQLSRV_PARAM_IN),
               array(&$txtPassword, SQLSRV_PARAM_IN),
               array(&$tmpresult, SQLSRV_PARAM_OUT)
            );

            $stmt = sqlsrv_prepare($konek1, $query, $params);
            $result = sqlsrv_execute($stmt);

            if ($result === false) {
               echo ('Failed to execute the stored procedure.');
            }

            while ($obj = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
               $txtHasil = $obj['TMPRESULT'];
            }

            sqlsrv_free_stmt($stmt);
            sqlsrv_close($konek1);

            $kondisi = substr($txtHasil, 0, 1);

            switch ($kondisi):
               case '6':
                  echo ('Password Salah!');
                  break;
               case '5':
                  echo ('Password Kadaluwarsa!');

                  $conn = sqlsrv_connect($konek1);

                  $query = "EXEC uspChangePassPHP @userid=?, @pass=?, @result=?";
                  $params = array(
                     array(&$txtUserid, SQLSRV_PARAM_IN),
                     array(&$txtPassword, SQLSRV_PARAM_IN),
                     array(&$txtPassword, SQLSRV_PARAM_OUT)
                  );
                  $stmt = sqlsrv_prepare($konek1, $query, $params);
                  $result = sqlsrv_execute($stmt);

                  if ($result === false) {
                     echo ('Failed to execute the stored procedure.');
                  }

                  sqlsrv_free_stmt($stmt);
                  sqlsrv_close($conn);

                  break;

               case '4':

                  $serverName = "desktop-at7mpm7";
                  $connectionOptions = array(
                     "Database" => "SECURE",
                     "UID" => "",
                     "PWD" => "",
                     "CharacterSet" => "UTF-8"
                  );

                  echo ("User Aktif di Tempat Lain");

                  $conn = sqlsrv_connect($serverName, $connectionOptions);

                  $query = "UPDATE t_users SET status = 0 where userid = '$txtUserid'";
                  $result = sqlsrv_query($conn, $query);

                  if ($result === false) {
                     echo ('Failed to execute the query.');
                  }

                  sqlsrv_close($conn);

                  break;

               case '3':
                  echo ('User-id. Tidak Aktif !');
                  break;
               case '2':
                  echo ('User Tidak Bisa Akses Aplikasi Ini...');
                  break;
               default:
                  if (session_status() === PHP_SESSION_NONE) {
                     session_start();
                  }

                  $_SESSION['User'] = $txtUserid;
                  $_SESSION['Nama'] = $txtNamaUser;
                  $_SESSION['Level'] = $txtLevel;
                  $_SESSION['Today'] = $txtToday;
                  $_SESSION['Kdkas'] = " ";
                  $_SESSION['tglquery'] = " ";
                  $_SESSION['LimitDb'] = 0;
                  $_SESSION['LimitCr'] = 0;

                  $serverName = "desktop-at7mpm7";
                  $connectionOptions = array(
                     "Database" => "KASKECIL",
                     "UID" => "",
                     "PWD" => "",
                     "CharacterSet" => "UTF-8"
                  );
                  $connection = sqlsrv_connect($serverName, $connectionOptions);
                  $query = "SELECT USRTOPC,USRLIMDB,USRLIMCR FROM USRTABLE WHERE USRCODE = '$txtUserid' AND USRVALID = '1'";

                  $result = sqlsrv_query($connection, $query);

                  if ($result == false) {
                     echo ('User belum memiliki Kode Kas Kecil !');
                  } else {
                     while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        $_SESSION['Kdkas'] = $record['USRTOPC'];
                        $_SESSION['LimitDb'] = $record['USRLIMDB'];
                        $_SESSION['LimitCr'] = $record['USRLIMCR'];
                     }
                  }

                  $kodepc = $_SESSION['Kdkas'];
                  $txtUserid = $_SESSION['User'];
                  $txtNamaUser = $_SESSION['Nama'];
                  $txtLevel = $_SESSION['Level'];
                  $txtToday = substr($_SESSION['Today'], 6, 2) . "/" . substr($_SESSION['Today'], 4, 2) . "/" . substr($_SESSION['Today'], 0, 4);
                  $txtLimDb = $_SESSION['LimitDb'];
                  $txtLimCr = $_SESSION['LimitCr'];

                  if ($txtLevel === "1") {
                     $txtLevelNew = "User Operator";
                  } elseif ($txtLevel === "2") {
                     $txtLevelNew = "User Supervisor";
                  }


                  echo ("User-Id. : " . $txtUserid . "<br>");
                  echo ("Nama     : " . $txtNamaUser . "<br>");
                  echo ("Level    : " . $txtLevelNew . "<br>");
                  echo ("Hari Ini : " . $txtToday . "<br>");
                  echo ("Result   : " . $txtHasil . "<br>");
                  echo ("Kode Kas : " . $kodepc . "<br>");
                  echo ("Limit Db : " . number_format($txtLimDb, 2, '.', ',') . "<br>");
                  echo ("Limit Cr : " . number_format($txtLimCr, 2, '.', ',') . "<br><br>");

                  $today = getdate();
                  $txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
                  $txtLogTime = date("H:i:s");
                  $txtLogDesc = "User Logging-in";

                  $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES (?, ?, ?, ?)";
                  $params = array($txtUserid, $txtLogDate, $txtLogTime, $txtLogDesc);

                  $stmt = sqlsrv_query($connection, $query, $params);

                  if ($stmt === false) {
                     echo ('Failed to execute the query.');
                  }

                  sqlsrv_close($connection);
   ?>
                  <p class="style1">Selamat Datang, Silahkan pilih menu disebelah kiri...</p>
   <?php
            endswitch;
         }
      }
   }
   ?>
</body>

</html>