<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$userid = $_SESSION['User'];
$trstopc = $_SESSION['Kdkas'];
$tglval = $_SESSION['Today'];
$tglprs = substr($tglval, 0, 4) . "-" . substr($tglval, 4, 2) . "-" . substr($tglval, 6, 2);
$sdhada = 0;
$usropen = " ";
$usrclose = " ";

include "kk_konek2.php";

$sql = "select count(*) as ADA from blmaster where bltopc = '$trstopc' and bldate = '$tglprs'";
$hasil = sqlsrv_query($conn2, $sql);

if ($hasil) {
	while ($record = sqlsrv_fetch_array($hasil, SQLSRV_FETCH_ASSOC)) {
		$sdhada = $record['ADA'];
	}

	if ($sdhada == 0) {
		echo ("<h2>Kas Kecil Belum Dibuka !</h2>");
		exit;
	} else {
		$sql = "select isnull(blopusr, ' ') as blopusr, isnull(blclusr, ' ') as blclusr from blmaster where bltopc = '$trstopc' and bldate = '$tglprs'";
		$hasil = sqlsrv_query($conn2, $sql);

		if ($hasil) {
			while ($record = sqlsrv_fetch_array($hasil, SQLSRV_FETCH_ASSOC)) {
				$usropen = $record['blopusr'];
				$usrclose = $record['blclusr'];
			}

			if ($usropen == " ") {
				echo ("<h2>Status Kas Kecil Belum Dibuka !</h2>");
				exit;
			} elseif ($usrclose != " ") {
				echo ("<h2>Status Kas Kecil Sudah Ditutup !</h2>");
				exit;
			}
		}
	}
}
sqlsrv_close($conn2);
