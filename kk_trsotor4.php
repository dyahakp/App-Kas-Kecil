<?php
session_start();


include "kk_ceklevel2.php";
include "kk_cekstatus.php";
include "kk_konek2.php";

$hariini = getdate();

$userid = $_SESSION['User'];
$trstopc = $_SESSION['Kdkas'];

$hariini = getdate();
$trsnow = $hariini["year"] . "-" . $hariini["mon"] . "-" . $hariini["mday"];
$trsjam = date("H:i:s");
$kasbon = '          ';

$sql = "SELECT PCKASBON FROM pcmaster WHERE pccode = '$trstopc'";
$result = sqlsrv_query($conn2, $sql);

if ($result) {
    while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $kasbon = $record['PCKASBON'];
    }
} else {
    echo "Error: " . sqlsrv_errors($conn2);
    exit;
}
$notaList = "select trsnota from trmaster where trstopc = '$trstopc' and trstglinp = '$trsnow' and isnull(trsusraut,'          ') = '          '";
$resultNota = sqlsrv_query($conn2, $notaList);

$trsnota = sqlsrv_fetch_array($resultNota, SQLSRV_FETCH_ASSOC);

$sql = "SELECT TRSUSRINP FROM TRMASTER WHERE TRSNOTA IN ($notaList)";
$result = sqlsrv_query($conn2, $sql);


if (!$result) {
    echo json_encode(array('msg' => 'Gagal Membuka Database'));
    exit;
} else {
    $oper = "";

    while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $oper = $record['TRSUSRINP'];
    }

    if (trim($oper) == trim($userid)) {
        echo json_encode(array('msg' => 'User Otorisasi = User Input'));
        exit;
    } else {
        $sldakh = 0;
        $sldbon = 0;

        $sql = "SELECT BLCLVAL, BLCLBON FROM BLMASTER WHERE BLTOPC = '$trstopc' AND BLDATE = '$trsnow'";
        $result = sqlsrv_query($conn2, $sql);

        if ($result) {
            while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $sldakh = $record['BLCLVAL'];
                $sldbon = $record['BLCLBON'];
            }

            foreach ($trsnota as $nota) {
                $sql = "SELECT TRSDBCR,TRSCODE, TRSNILAI FROM TRMASTER WHERE TRSNOTA = '$nota'";
                $result = sqlsrv_query($conn2, $sql);

                if ($result) {
                    while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        $trsdbcr = $record['TRSDBCR'];
                        $trsnilai = $record['TRSNILAI'];
                        $trscode = $record['TRSCODE'];

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
                    }
                } else {
                    echo json_encode(array('msg' => 'Otorisasi Data Gagal'));
                    exit;
                }
            }

            $sql = "UPDATE BLMASTER SET BLCLVAL = '$sldakh', BLCLBON = '$sldbon' WHERE BLTOPC = '$trstopc' AND BLDATE = '$trsnow'";
            $result = sqlsrv_query($conn2, $sql);

            if ($result) {
                $sql = "UPDATE TRMASTER SET TRSUSRAUT = '$userid', TRSTGLAUT = '$trsnow', TRSJAMAUT = '$trsjam' WHERE TRSNOTA IN ($notaList)";
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
