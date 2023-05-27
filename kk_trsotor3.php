<?php
session_start();

include "kk_ceklevel2.php";
include "kk_cekstatus.php";
include "kk_konek2.php";

$hariini = getdate();
$trsnota = $_REQUEST['trsnota'];
$trscode = $_REQUEST['trscode'];
$trsvaluta = $_REQUEST['trsvaluta'];
$trsdesc = $_REQUEST['trsdesc'];
$trsdbcr = $_REQUEST['trsdbcr'];
$trsnilai = $_REQUEST['trsnilai'];
$trsreff = $_REQUEST['trsreff'];
$trstorf = $_REQUEST['trstorf'];

$userid = $_SESSION['User'];
$trstopc = $_SESSION['Kdkas'];

$hariini = getdate();
$trsnow = $hariini["year"] . "-" . $hariini["mon"] . "-" . $hariini["mday"];
$trsjam = date("H:i:s");
$kasbon = '          ';


$sql = "select PCKASBON from pcmaster where pccode = '$trstopc'";
$result = sqlsrv_query($conn2, $sql);

if ($result) {
    while ($record = (sqlsrv_fetch_array($result))) {
        $kasbon = $record['PCKASBON'];
    }
} else {
    echo "Error: " . sqlsrv_errors($conn2);
}

$sql = "select TRSUSRINP from TRMASTER where TRSNOTA = '$trsnota'";
$result = sqlsrv_query($conn2, $sql);

if (!$result) {
    echo json_encode(array('msg' => 'Gagal Membuka Database'));
} else {
    $oper = "";

    while ($record = sqlsrv_fetch_array($result)) {
        $oper = $record['TRSUSRINP'];
    }

    if (trim($oper) == trim($userid)) {
        echo json_encode(array('msg' => 'User Otorisasi = User Input'));
    } else {
        $sldakh = 0;
        $sldbon = 0;

        $sql = "select BLCLVAL,BLCLBON from BLMASTER where BLTOPC = '$trstopc' and BLDATE = '$trsnow'";
        $result = sqlsrv_query($conn2, $sql);

        if ($result) {
            while ($record = (sqlsrv_fetch_array($result))) {
                $sldakh = $record['BLCLVAL'];
                $sldbon = $record['BLCLBON'];
            }

            if ($trsdbcr == 'D') {
                $sldakh += $trsnilai;
            } else {
                $sldakh -= $trsnilai;
            }

            if ($trscode == $kasbon) {
                if ($trsdbcr == 'D') {
                    $sldbon -= $trsnilai;
                } else {
                    $sldbon += $trsnilai;
                }
            }

            $sql = "update BLMASTER set BLCLVAL = '$sldakh',BLCLBON = '$sldbon' where BLTOPC = '$trstopc' and BLDATE = '$trsnow'";

            $result = sqlsrv_query($conn2, $sql);

            if ($result) {
                $sql = "update TRMASTER set TRSUSRAUT = '$userid', TRSTGLAUT = '$trsnow', TRSJAMAUT = '$trsjam' where TRSNOTA = '$trsnota'";

                $result = sqlsrv_query($conn2, $sql);

                if ($result) {
                    echo json_encode(array('success' => true));
                } else {
                    echo json_encode(array('msg' => 'Proses Otorisasi Data Gagal'));
                }
            } else {
                echo json_encode(array('msg' => 'Proses Otorisasi Data Gagal'));
            }
        } else {
            echo json_encode(array('msg' => 'Otorisasi Data Gagal'));
        }
    }
}
sqlsrv_close($conn2);
