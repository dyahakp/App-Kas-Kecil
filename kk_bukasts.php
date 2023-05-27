<?php
session_start();
$userid = $_SESSION['User'];
$trstopc = $_SESSION['Kdkas'];
$tglval = $_SESSION['Today'];

include "kk_ceklogin.php";
include "kk_ceklevel2.php";
include "kk_konek2.php";

$today = getdate();
$txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
$txtLogTime = date("H:i:s");
$txtLogDesc = "Accessing : Buka Status";

$query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
$result = sqlsrv_query($conn2, $query);

$tglprs = substr($tglval, 0, 4) . "-" . substr($tglval, 4, 2) . "-" . substr($tglval, 6, 2);
$sldawal = 0;
$sldbon = 0;
$trsjam = date("H:i:s");
$result = array();
$tglada = $tglval;

$sql = "select top 1 bldate, blclval, blclbon from blmaster where bltopc = '$trstopc' and bldate < '$tglprs' order by bldate desc";
$hasil = sqlsrv_query($conn2, $sql);

if ($hasil) {
    while ($record = (sqlsrv_fetch_array($hasil))) {
        //$tglada = substr($record['bldate'], 0, 4)."-".substr($record['bldate'], 4, 2)."-".substr($record['bldate'], 6, 2);
        $tglada = $record['bldate']->format('Y-m-d');
        $sldawal = $record['blclval'];
        $sldbon = $record['blclbon'];
    }
}

$sdhada = 0;
$sql = "select count(*) as ADA from blmaster where bltopc = '$trstopc' and bldate = '$tglprs'";
$hasil = sqlsrv_query($conn2, $sql);

if ($hasil) {
    while ($record = (sqlsrv_fetch_array($hasil))) {
        $sdhada = $record['ADA'];
    }

    if ($sdhada == 0) {
        $sql = "insert into blmaster (bldate, bltopc, blopval, blclval, blopjam, blopusr, blopbon, blclbon) 
		        values ('$tglprs', '$trstopc', '$sldawal', '$sldawal', '$trsjam', '$userid', '$sldbon', '$sldbon')";
        $hasil = sqlsrv_query($conn2, $sql);

        if ($hasil) {
            $sql = "select bltopc, bldate, blopval from blmaster where bltopc = '$trstopc' and bldate = '$tglprs'";
            $hasil = sqlsrv_query($conn2, $sql);

            if ($hasil) {
                while ($rows = sqlsrv_fetch_array($hasil)) {
                    echo ("Kode Kas   : " . $rows['bltopc'] . "<br>");
                    echo "Tanggal    : " . $rows['bldate']->format('Y-m-d') . "<br>";
                    echo ("Saldo Awal : " . number_format($rows['blopval'], 2, '.', ',') . "<br>");
                }
            }
        }
    } else {
        $sql = "select bltopc, bldate, blopval from blmaster where bltopc = '$trstopc' and bldate = '$tglprs'";
        $hasil = sqlsrv_query($conn2, $sql);

        if ($hasil) {
            while ($rows = sqlsrv_fetch_array($hasil)) {
                echo ("Kode Kas   : " . $rows['bltopc'] . "<br>");
                echo "Tanggal    : " . $rows['bldate']->format('Y-m-d') . "<br>";
                echo ("Saldo Awal : " . number_format($rows['blopval'], 2, '.', ',') . "<br>");
            }
        }
    }

    $sql = "select isnull(blopusr, '   ') as blopusr from blmaster where bltopc = '$trstopc' and bldate = '$tglprs'";
    $hasil = sqlsrv_query($conn2, $sql);

    if ($hasil) {
        while ($record = (sqlsrv_fetch_array($hasil))) {
            $sdhada = $record['blopusr'];
        }

        if ($sdhada == '   ') {
            $sql = "update blmaster set blopjam = '$trsjam', blopusr = '$userid' where bltopc = '$trstopc' and bldate = '$tglprs'";
            $hasil = sqlsrv_query($conn2, $sql);

            if ($hasil) {
                echo ("<br>" . "Buka Status Kas Sukses !");
            } else {
                echo ("<br>" . "Buka Status Kas Gagal !");
            }
        } else {
            echo ("<br>" . "Status Kas Sudah Terbuka !");
        }
    }
}
sqlsrv_close($conn2);
