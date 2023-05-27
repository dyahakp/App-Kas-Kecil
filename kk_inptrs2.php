<?php
session_start();
$userid = $_SESSION['User'];
$trstopc = $_SESSION['Kdkas'];
$limitdb = $_SESSION['LimitDb'];
$limitcr = $_SESSION['LimitCr'];

include "kk_ceklevel1.php";
include "kk_cekstatus.php";
include "kk_konek2.php";

$hariini = getdate();
$trscode = $_REQUEST['trscode'];
$trstgl = $_REQUEST['trsvaluta'];
$trsdesc = $_REQUEST['trsdesc'];
$trsdbcr = $_REQUEST['trsdbcr'];
$trsreff = $_REQUEST['trsreff'];
$trsnilai = $_REQUEST['trsnilai'];
$trstorf = $_REQUEST['trstorf'];
$trsdate = substr($trstgl, 6, 4) . "-" . substr($trstgl, 3, 2) . "-" . substr($trstgl, 0, 2);
$trsnow = $hariini["year"] . "-" . $hariini["mon"] . "-" . $hariini["mday"];
$trsjam = date("H:i:s");
$base1 = "ABCDEFGHKLMNOPQRSTWXYZABCDEFGHKLMNOPQRSTWXYZABCDEFGHK";
$base2 = "01234567890123456789012345678901234567890123456789012";
$max = strlen($base1) - 1;
$acak = "";
$lanjut = "T";


if ($trsdbcr == "D") {
    if ($trsnilai <= $limitdb) {
        $lanjut = "Y";
    }
} else {
    if ($trsnilai <= $limitcr) {
        $lanjut = "Y";
    }
}

if ($lanjut == "Y") {
    mt_srand((float)microtime() * 1000000);

    while (strlen($acak) < 3) {
        $acak .= $base1[mt_rand(0, $max)];
    }

    while (strlen($acak) < 8) {

        $acak .= $base2[mt_rand(0, $max)];
    }

    $sql = "insert into trmaster (trstopc,trsnota,trscode,trsvaluta,trsdesc, trsdbcr,trsreff,trsnilai,trstorf,trsusrinp,trstglinp,trsjaminp)  values('$trstopc','$acak','$trscode','$trsdate','$trsdesc','$trsdbcr','$trsreff','$trsnilai','$trstorf','$userid','$trsnow','$trsjam')";

    print_r($sql);

    $result = @sqlsrv_query($conn2, $sql);

    if ($result) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('msg' => 'Simpan Data Gagal !'));
    }
} else {
    echo json_encode(array('msg' => 'Melewati Batas Limit !'));
}
sqlsrv_close($conn2);

// <?php
// session_start();
// $userid = $_SESSION['User'];
// $trstopc = $_SESSION['Kdkas'];
// $limitdb = $_SESSION['LimitDb'];
// $limitcr = $_SESSION['LimitCr'];

// include "kk_ceklevel1.php";
// include "kk_cekstatus.php";
// include "kk_konek2.php";

// $trscode = $_REQUEST['trscode'];
// $trstgl = $_REQUEST['trsvaluta'];
// $trsdesc = $_REQUEST['trsdesc'];
// $trsdbcr = $_REQUEST['trsdbcr'];
// $trsreff = $_REQUEST['trsreff'];
// $trsnilai = $_REQUEST['trsnilai'];
// $trstorf = $_REQUEST['trstorf'];

// $trsdate = date('Y-m-d', strtotime($trstgl));
// $trsnow = date('Y-m-d');
// $trsjam = date('H:i:s');
// $acak = substr(str_shuffle('ABCDEFGHKLMNOPQRSTWXYZ01234567890123456789012345678901234567890123456789012'), 0, 11);

// $lanjut = ($trsdbcr == "D" && $trsnilai <= $limitdb) || ($trsdbcr != "D" && $trsnilai <= $limitcr);

// if ($lanjut) {
//     $sql = "INSERT INTO trmaster (trstopc, trsnota, trscode, trsvaluta, trsdesc, trsdbcr, trsreff, trsnilai, trstorf, trsusrinp, trstglinp, trsjaminp)
//             VALUES ('$trstopc', '$acak', '$trscode', '$trsdate', '$trsdesc', '$trsdbcr', '$trsreff', '$trsnilai', '$trstorf', '$userid', '$trsnow', '$trsjam')";

//     $result = @sqlsrv_query($conn2, $sql);

//     if ($result) {
//         echo json_encode(array('success' => true));
//     } else {
//         echo json_encode(array('msg' => 'Simpan Data Gagal!'));
//     }
// } else {
//     echo json_encode(array('msg' => 'Melewati Batas Limit!'));
// }

// sqlsrv_close($conn2);
