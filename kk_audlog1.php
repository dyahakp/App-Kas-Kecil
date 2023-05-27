<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userid = $_SESSION['User'];
?>
<html>

<head>
    <title></title>
</head>

<body>
    <?php
    include "kk_konek2.php";

    $txttgl = $_REQUEST['txtTgl'];
    $txtusr = $_REQUEST['txtusr'];
    $trsdate = substr($txttgl, 6, 4) . substr($txttgl, 3, 2) . substr($txttgl, 0, 2);
    ?>
    <h2><u>Audit Trail Log-Activity</u></h2>
    <table border="0" cellspacing="0">
        <?php
        echo ("<tr><td><font face = verdana size = 2 color = black><b>User-Id. :</b></font></td>");
        echo ("<td><font face = verdana size = 2 color = blue><b>$txtusr</b></font></td></tr>");
        echo ("<tr><td><font face = verdana size = 2 color = black><b>Tanggal :</b></font></td>");
        echo ("<td><font face = verdana size = 2 color = blue><b>$txttgl</b></font></td></tr>");
        ?>
    </table>
    <?php
    $sql = "SELECT LOGTIME, LOGDESC
		FROM LOGACTIVITY
		WHERE LOGUSER = '$txtusr' AND LOGDATE = '$trsdate' 
		ORDER BY LOGTIME";

    $result = sqlsrv_query($conn2, $sql);

    if ($result) {
        if (sqlsrv_num_rows($result) == 0) {
            echo ("<B>Data Tidak Ditemukan !</B>");
        } else {
            $heder[0] = "WAKTU";
            $heder[1] = "KETERANGAN";
    ?>
            <table border="1" cellspacing="0">
                <tr>
                    <?php
                    for ($i = 0; $i < 2; $i++) {
                        echo ("<th><font face = verdana size = 2 color = black>" . $heder[$i] . "</font></th>");
                    }
                    ?>
                </tr>
        <?php
            while ($row = sqlsrv_fetch_array($result)) {
                echo ("<tr>");
                echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['LOGTIME'] . "</font></th>");
                echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['LOGDESC'] . "</font></th>");
                echo ("</tr>");
            }
            echo ("</table>");
        }
        $today = getdate();
        $txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
        $txtLogTime = date("H:i:s");
        $txtLogDesc = "Displaying Report : Audit Trail Log-Activity " . $txttgl;

        $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
        $result = sqlsrv_query($conn2, $query);
    }
    sqlsrv_close($conn2);
        ?>
</body>

</html>