<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$userid = $_SESSION['User'];
$trstopc = $_SESSION['Kdkas'];

include "kk_konek2.php";
include "kk_padzero.php";

$txttgl = $_REQUEST['txtTgl'];
$filteks = $_REQUEST['txtFile'];
$trsdate = substr($txttgl, 6, 4) . substr($txttgl, 3, 2) . substr($txttgl, 0, 2);

$today = getdate();
$txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
$txtLogTime = date("H:i:s");
$txtLogDesc = "Accessing: Create Text-File Jurnal Otomatis";

$query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
$result = sqlsrv_query($conn2, $query);

$sql = "SELECT PCBRANCH, PCDEPT, PCREGION, PCABREV FROM PCMASTER WHERE PCCODE = '$trstopc'";
$result = sqlsrv_query($conn2, $sql);

while ($row = sqlsrv_fetch_array($result)) {
	$kdcab = $row['PCBRANCH'];
	$kddep = $row['PCDEPT'];
	$kdwil = $row['PCREGION'];
	$singk = $row['PCABREV'];
}

$sql = "SELECT TRSNOTA, TRSCODE, TRSVALUTA, TRSDESC, TRSDBCR, TRSNILAI, TRSREFF, 
        CASE WHEN TRSDBCR = 'K' THEN PCMASTER.PCNOSL ELSE TRTABLE.TRNOSL END AS KREDIT 
        FROM TRMASTER  
        LEFT OUTER JOIN PCMASTER ON TRMASTER.TRSTOPC = PCMASTER.PCCODE 
        LEFT OUTER JOIN TRTABLE ON TRMASTER.TRSCODE = TRTABLE.TRCODE 
        WHERE TRSVALUTA = '$trsdate' AND TRSTOPC = '$trstopc' AND TRSCODE != '(19607) KA' AND (TRSDESC LIKE '%BY%' OR TRSDESC LIKE '%BIAYA%')";

$result = sqlsrv_query($conn2, $sql);

if ($result) {
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Type: text/plain; charset=us-ascii");
	header("Content-Disposition: attachment; filename='" . $filteks . "'");
	header("Content-Transfer-Encoding: 7bit ");

	while ($row = sqlsrv_fetch_array($result)) {
		$cnota = $row['TRSNOTA'];
		$ckode = $row['TRSCODE'];
		$ctggl = $row['TRSVALUTA'];
		$cdesk = $row['TRSDESC'];
		$cdbcr = $row['TRSDBCR'];
		$cjmlh = number_format($row['TRSNILAI'] * 100, 0, '', '');
		$creff = $row['TRSREFF'];
		$cslcr = $row['KREDIT'];
		$bikin = '1';

		if (substr($cslcr, 0, 5) == '     ') {
			$bikin = '0';
		}

		if ($bikin == '1') {
			if (strlen(rtrim($cslcr)) == 7) {
				$tulis = substr($ctggl->format('Y-m-d'), 0, 4) . substr($ctggl->format('Y-m-d'), 5, 2) . substr($ctggl->format('Y-m-d'), 8, 2);
				$tulis .= substr($ctggl->format('Y-m-d'), 0, 4) . substr($ctggl->format('Y-m-d'), 5, 2) . substr($ctggl->format('Y-m-d'), 8, 2);
				$tulis .= substr($kdwil, 0, 2) . $kdcab . substr($cslcr, 0, 7) . "IDR K" . $singk . substr($ckode, 0, 3) . substr($cnota, 0, 15) . " ";
				$tulis .= pad_zero_18($cjmlh);
				$tulis .= pad_zero_19($cjmlh);
				$tulis .= " " . str_pad($cdesk, 30) . "\r\n";

				print_r($tulis);
			} else {
				$tulis = substr($ctggl->format('Y-m-d'), 0, 4) . substr($ctggl->format('Y-m-d'), 5, 2) . substr($ctggl->format('Y-m-d'), 8, 2);
				$tulis .= substr($ctggl->format('Y-m-d'), 0, 4) . substr($ctggl->format('Y-m-d'), 5, 2) . substr($ctggl->format('Y-m-d'), 8, 2);
				$tulis .= substr($kdwil, 0, 2) . $kdcab . substr($cslcr, 0, 5) . "IDR   K" . $singk . substr($ckode, 0, 3) . substr($cnota, 0, 15) . " ";
				$tulis .= pad_zero_18($cjmlh);
				$tulis .= pad_zero_19($cjmlh);
				$tulis .= " " . str_pad($cdesk, 30) . "\r\n";

				print_r($tulis);
			}
		}
	}
}
sqlsrv_close($conn2);
