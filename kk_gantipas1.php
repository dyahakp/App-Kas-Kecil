<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userid = $_SESSION['User'];

include "kk_konek2.php";

$today = getdate();
$txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
$txtLogTime = date("H:i:s");
$txtLogDesc = "Accessing: Ganti Password";

$query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES (?, ?, ?, ?)";
$params = array($userid, $txtLogDate, $txtLogTime, $txtLogDesc);
$result = sqlsrv_query($conn2, $query, $params);

sqlsrv_close($conn2);

include "kk_konek1.php";

$txtlama = $_POST['txtLama'];
$txtbar1 = $_POST['txtBaru1'];
$txtbar2 = $_POST['txtBaru2'];
$lanjut = 0;
$tmpresult = 0;

$query = "EXEC spCekPassPHP ?, ?, ?";
$params = array($userid, $txtlama, &$tmpresult);
$result = sqlsrv_query($konek1, $query, $params);

if ($result) {
    $rows = sqlsrv_has_rows($result);
    if ($rows !== false) {
        while ($obj = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $lanjut = $obj['TMPRESULT'];
        }

        if ($lanjut == 0) {
            echo ('Password Lama Salah!');
        } else {
            if ($txtbar1 != $txtbar2) {
                echo ('Password Baru Tidak Sama!');
            } else {
                $query = "EXEC uspChangePassPHP ?, ?, ?";
                $params = array($userid, $txtbar1, &$tmpresult);
                $result = sqlsrv_query($konek1, $query, $params);

                if ($result) {
                    $rows = sqlsrv_has_rows($result);
                    if ($rows !== false) {
                        while ($obj = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                            $txtHasil = $obj['TMPRESULT'];
                        }

                        if ($txtHasil == 0) {
                            echo ('Simpan Password Baru Gagal!');
                        } else {
                            echo ('Ganti Password Berhasil!');
                        }
                    } else {
                        echo ('Ganti Password Tidak Berhasil!');
                    }
                } else {
                    echo ('Ganti Password Tidak Berhasil!');
                }
            }
        }
    } else {
        echo ('Password Lama Salah!');
    }
} else {
    echo ('Ganti Password Tidak Berhasil!');
}

sqlsrv_close($konek1);
