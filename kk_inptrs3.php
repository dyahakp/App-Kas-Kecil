<?php
include "kk_ceklevel1.php";
include "kk_cekstatus.php";
include "kk_konek2.php";

$hariini = getdate();
$trsnota = $_REQUEST['trsnota'];
$trstopc = $_REQUEST['trstopc'];
$trscode = $_REQUEST['trscode'];
$trsvaluta = $_REQUEST['trsvaluta'];
$trsdesc = $_REQUEST['trsdesc'];
$trsdbcr = $_REQUEST['trsdbcr'];
$trsnilai = $_REQUEST['trsnilai'];
$trsreff = $_REQUEST['trsreff'];
$trstorf = $_REQUEST['trstorf'];

$sql = "select isnull(trsusraut, '          ') as trsusraut from trmaster where trsnota = '$trsnota'";
$result = @sqlsrv_query($conn2, $sql);

if (!$result) {
	echo json_encode(array('msg' => 'Gagal Membuka Database'));
} else {
	$autor = "";

	while ($record = (sqlsrv_fetch_array($result))) {
		$autor = $record['trsusraut'];
	}

	if (trim($autor) != "") {
		echo json_encode(array('msg' => 'Sudah Otorisasi, tidak bisa dihapus'));
	} else {
		$sql = "delete from trmaster where trsnota = '$trsnota'";
		$result = @sqlsrv_query($conn2, $sql);

		if ($result) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('msg' => 'Hapus Data Gagal'));
		}
	}
}
sqlsrv_close($conn2);
