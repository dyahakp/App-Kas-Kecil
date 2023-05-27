<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$userid = $_SESSION['User'];
$trstopc = $_SESSION['Kdkas'];
?>
<html>

<head>
	<title></title>
</head>

<body>
	<?php
	include "kk_konek2.php";

	$txttgl = $_REQUEST['txtTgl'];
	$trsdate = substr($txttgl, 6, 4) . substr($txttgl, 3, 2) . substr($txttgl, 0, 2);

	$sql = "SELECT PCBRANCH, PCDEPT FROM PCMASTER WHERE PCCODE = '$trstopc'";
	$result = sqlsrv_query($conn2, $sql);

	while ($row = sqlsrv_fetch_array($result)) {
		$kdcab = $row['PCBRANCH'];
		$kddep = $row['PCDEPT'];
	}
	?>
	<h2><u>Audit Trail Transaksi Harian</u></h2>
	<table border="0" cellspacing="0">
		<?php
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Kas :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$trstopc</b></font></td></tr>");
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Dept. :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$kddep</b></font></td></tr>");
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Cabang :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$kdcab</b></font></td></tr>");
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Tanggal :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$txttgl</b></font></td></tr>");
		?>
	</table>
	<?php
	$sql = "SELECT TRSNOTA, TRSCODE, TRSVALUTA, TRSDESC, TRSDBCR, TRSNILAI, TRSREFF, TRSTORF, 
        TRSUSRINP, TRSTGLINP, TRSJAMINP, TRSUSRAUT, TRSTGLAUT, TRSJAMAUT
		FROM TRMASTER  
		WHERE TRSVALUTA = '$trsdate' AND TRSTOPC = '$trstopc' 
		ORDER BY TRSNOTA";

	$result = sqlsrv_query($conn2, $sql);

	if ($result) {
		if (sqlsrv_num_rows($result) == 0) {
			echo ("<B>Data Tidak Ditemukan !</B>");
		} else {
			$heder[0] = "NO. NOTA";
			$heder[1] = "KODE TRANS.";
			$heder[2] = "TGL. VALUTA";
			$heder[3] = "DESKRIPSI";
			$heder[4] = "D/K";
			$heder[5] = "NILAI";
			$heder[6] = "NO. BUKTI";
			$heder[7] = "REFERENSI";
			$heder[8] = "USER INPUT";
			$heder[9] = "TGL. INPUT";
			$heder[10] = "JAM INPUT";
			$heder[11] = "USER AUTH.";
			$heder[12] = "TGL. AUTH.";
			$heder[13] = "JAM AUTH.";
	?>
			<table border="1" cellspacing="0">
				<tr>
					<?php
					for ($i = 0; $i < 14; $i++) {
						echo ("<th><font face = verdana size = 2 color = black>" . $heder[$i] . "</font></th>");
					}
					?>
				</tr>
		<?php
			while ($row = sqlsrv_fetch_array($result)) {
				$tmptgl = substr($row['TRSVALUTA'], 8, 2) . "/" . substr($row['TRSVALUTA'], 5, 2) . "/" . substr($row['TRSVALUTA'], 0, 4);
				$tmpnil = number_format(abs($row['TRSNILAI']), 2, '.', ',');

				echo ("<tr>");
				echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['TRSNOTA'] . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSCODE'] . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $tmptgl . "</font></th>");
				echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['TRSDESC'] . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSDBCR'] . "</font></th>");
				echo ("<th align = right><font face = verdana size = 2 color = blue>" . $tmpnil . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSREFF'] . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSTORF'] . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSUSRINP'] . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSTGLINP'] . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSJAMINP'] . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSUSRAUT'] . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSTGLAUT'] . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSJAMAUT'] . "</font></th>");
				echo ("</tr>");
			}
			echo ("</table>");
		}
		$today = getdate();
		$txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
		$txtLogTime = date("H:i:s");
		$txtLogDesc = "Displaying Report : Audit Trail Transaksi " . $txttgl;

		$query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
		$result = sqlsrv_query($conn2, $query);
	}
	sqlsrv_close($conn2);
		?>
</body>

</html>