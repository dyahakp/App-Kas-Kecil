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
$txtLogDesc = "Acessing : Tutup Status";

$query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES (?, ?, ?, ?)";
$params = array($userid, $txtLogDate, $txtLogTime, $txtLogDesc);
$result = sqlsrv_query($conn2, $query, $params);

$tglprs = substr($tglval, 0, 4) . "-" . substr($tglval, 4, 2) . "-" . substr($tglval, 6, 2);
$sldakhir = 0;
$usrclose = '   ';
$usropen = '   ';
$trsjam = date("H:i:s");
$result = array();
$tglada = $tglval;
$sdhada = 0;
$kasbon = " ";

$sql = "SELECT PCKASBON FROM PCMASTER WHERE PCCODE = ?";
$params = array($trstopc);
$result = sqlsrv_query($conn2, $sql, $params);

if ($result) {
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $kasbon = $row['PCKASBON'];
    }
}

$sql = "select count(*) as ADA from blmaster where bltopc = ? and bldate = ?";
$params = array($trstopc, $tglprs);
$hasilQuery = sqlsrv_query($conn2, $sql, $params);

if ($hasilQuery) {
    while ($record = sqlsrv_fetch_array($hasilQuery, SQLSRV_FETCH_ASSOC)) {
        $sdhada = $record['ADA'];
    }

    if ($sdhada == 0) {
        echo ("Kas Kecil Belum Dibuka !");
    } else {
        $sql = "select isnull(BLOPUSR, '   ') as BLOPUSR from blmaster where bltopc = ? and bldate = ?";
        $params = array($trstopc, $tglprs);
        $hasilQuery = sqlsrv_query($conn2, $sql, $params);

        if ($hasilQuery) {
            while ($record = sqlsrv_fetch_array($hasilQuery, SQLSRV_FETCH_ASSOC)) {
                $usropen = $record['BLOPUSR'];
            }

            if ($usropen == '   ') {
                echo ("Status Kas Kecil Belum Dibuka !");
            } else {
                $sql = "select bltopc, bldate, blopval, blclval, blopbon from blmaster where bltopc = ? and bldate = ?";
                $params = array($trstopc, $tglprs);
                $hasilQuery = sqlsrv_query($conn2, $sql, $params);

                if ($hasilQuery) {
                    while ($rows = sqlsrv_fetch_array($hasilQuery, SQLSRV_FETCH_ASSOC)) {
                        echo ("Kode Kas    : " . $rows['bltopc'] . "<br>");
                        echo ("Tanggal     : " . $rows['bldate']->format('Y-m-d') . "<br>");
                        echo ("Saldo Awal  : " . number_format($rows['blopval'], 2, '.', ',') . "<br>");
                
                        $sld = $rows['blopval'];
                        $bon = $rows['blopbon'];
                    }
                
                    $sql = "SELECT TRSDBCR, TRSNILAI, TRSCODE
                            FROM TRMASTER
                            WHERE TRSVALUTA = ? AND TRSTOPC = ? AND TRSUSRAUT != '          '
                            ORDER BY TRSVALUTA, TRSREFF";
                
                    $params = array($tglprs, $trstopc);
                    $result = sqlsrv_query($conn2, $sql, $params);
                
                    if ($result) {
                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                            $trsdbcr = $row['TRSDBCR'];
                            $trsnilai = abs($row['TRSNILAI']);
                            $trskode = $row['TRSCODE'];
                
                            if ($trsdbcr == 'D') {
                                $sld += $trsnilai;
                            } else {
                                $sld -= $trsnilai;
                            }
                
                            if ($trskode == $kasbon) {
                                if ($trsdbcr == 'D') {
                                    $bon -= $trsnilai;
                                } else {
                                    $bon += $trsnilai;
                                }
                            }
                        }
                    }
                
                    echo ("Saldo Akhir : " . number_format($sld, 2, '.', ',') . "<br>");
                
                    $sql = "update blmaster set blclval = ?, blclbon = ?, blcljam = ?, blclusr = ? where bltopc = ? and bldate = ?";
                    $params = array($sld, $bon, $trsjam, $userid, $trstopc, $tglprs);
                    $hasilQuery = sqlsrv_query($conn2, $sql, $params);
                
                    if ($hasilQuery) {
                        echo ("<br>" . "Tutup Status Kas Sukses !");
                    } else {
                        echo ("<br>" . "Tutup Status Kas Gagal !");
                    }
                } else {
                    echo ("<br>" . "Status Kas Sudah Tertutup !");
                }
                
                sqlsrv_close($conn2);
            }
        }
    }
}