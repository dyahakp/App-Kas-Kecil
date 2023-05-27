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
$trsnota = $_REQUEST['trsnota'];
$trstopc = $_REQUEST['trstopc'];
$trscode = $_REQUEST['trscode'];
$today = $_REQUEST['trsvaluta'];
$trsdesc = $_REQUEST['trsdesc'];
$trsdbcr = $_REQUEST['trsdbcr'];
$trsreff = $_REQUEST['trsreff'];
$trsnilai = $_REQUEST['trsnilai'];
$trstorf = $_REQUEST['trstorf'];
$trsdate = substr($today, 6, 4) . "-" . substr($today, 3, 2) . "-" . substr($today, 0, 2);
$autor = "";

$sql = "select isnull(trsusraut, '          ') as trsusraut from trmaster where trsnota = '$trsnota'";
$result = @sqlsrv_query($conn2, $sql);

if (!$result) {
	echo json_encode(array('msg' => 'Gagal Membuka Database'));
} else {
	while ($record = (sqlsrv_fetch_array($result))) {
		$autor = $record['trsusraut'];
	}

	if (trim($autor) != "") {
		echo json_encode(array('msg' => 'Sudah Otorisasi, tidak bisa diubah'));
	} else {
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
			$sql = "update trmaster set trscode='$trscode', trsdesc='$trsdesc', trsdbcr='$trsdbcr', trsreff='$trsreff', trsnilai='$trsnilai', trstorf='$trstorf' where trsnota='$trsnota'";

			$result = @sqlsrv_query($conn2, $sql);

			if ($result) {
				echo json_encode(array('success' => true));
			} else {
				echo json_encode(array('msg' => 'Koreksi Data Gagal'));
			}
		} else {
			echo json_encode(array('msg' => 'Melewati Batas Limit !'));
		}
	}
}
sqlsrv_close($conn2);
