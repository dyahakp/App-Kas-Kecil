<?php
session_start();
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
	$trsnow = substr($txttgl, 6, 4) . "-" . substr($txttgl, 3, 2) . "-" . substr($txttgl, 0, 2);
	$sldakh = 0;

	$sql = "SELECT PCBRANCH, PCDEPT FROM PCMASTER WHERE PCCODE = '$trstopc'";
	$result = sqlsrv_query($conn2, $sql);

	while ($row = sqlsrv_fetch_array($result)) {
		$kdcab = $row['PCBRANCH'];
		$kddep = $row['PCDEPT'];
	}

	$sql = "SELECT BLOPVAL FROM BLMASTER WHERE BLTOPC = '$trstopc' AND BLDATE = '$trsnow'";
	$result = @sqlsrv_query($conn2, $sql);

	while ($record = (sqlsrv_fetch_array($result))) {
		$sldakh = $record['BLOPVAL'];
	}
	?>
	<h2><u>Rekap Transaksi Harian Kas Kecil</u></h2>
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
	$sql = "SELECT  TRSVALUTA, TRSCODE, TRSDBCR, TRTABLE.TRDESC, SUM(TRSNILAI) AS TRSNILAI, ISNULL(TRSUSRAUT, SPACE(10)) AS TRSUSRAUT
		FROM TRMASTER  
		LEFT OUTER JOIN TRTABLE ON TRMASTER.TRSCODE = TRTABLE.TRCODE 
		WHERE TRSVALUTA = '$trsdate' AND TRSTOPC = '$trstopc' AND TRSUSRAUT != SPACE(10) 
		GROUP BY TRSVALUTA, TRSCODE, TRSDBCR, TRTABLE.TRDESC, TRSUSRAUT 
		ORDER BY TRSCODE";

	$result = sqlsrv_query($conn2, $sql);

	if ($result) {
		if (sqlsrv_num_rows($result) == 0) {
			echo ("<B>Data Tidak Ditemukan !</B>");
		} else {
			$heder[0] = "TGL. VALUTA";
			$heder[1] = "KODE TRANS.";
			$heder[2] = "D/K";
			$heder[3] = "DESKRIPSI";
			$heder[4] = "NILAI";
	?>
			<table border="1" cellspacing="0">
				<tr>
					<?php
					for ($i = 0; $i < 5; $i++) {
						echo ("<th><font face = verdana size = 2 color = black>" . $heder[$i] . "</font></th>");
					}
					?>
				</tr>
		<?php
			$tmptgl = substr($txttgl, 0, 2) . "/" . substr($txttgl, 3, 2) . "/" . substr($txttgl, 6, 4);
			$tmpnil = number_format(abs($sldakh), 2, '.', ',');

			echo ("<tr>");
			echo ("<th align = left><font face = verdana size = 2 color = blue>" . $tmptgl . "</font></th>");
			echo ("<th align = center><font face = verdana size = 2 color = blue>" . "   " . "</font></th>");
			echo ("<th align = center><font face = verdana size = 2 color = blue>" . "-" . "</font></th>");
			echo ("<th align = left><font face = verdana size = 2 color = blue>" . "Saldo Awal" . "</font></th>");
			echo ("<th align = right><font face = verdana size = 2 color = blue>" . $tmpnil . "</font></th>");
			echo ("</tr>");

			while ($row = sqlsrv_fetch_array($result)) {
				$tmptgl = substr($row['TRSVALUTA'], 8, 2) . "/" . substr($row['TRSVALUTA'], 5, 2) . "/" . substr($row['TRSVALUTA'], 0, 4);
				$tmpnil = number_format(abs($row['TRSNILAI']), 2, '.', ',');
				$tmpdbcr = $row['TRSDBCR'];
				$isotor = $row['TRSUSRAUT'];

				if ($isotor != '          ') {
					if ($tmpdbcr == "D") {
						$sldakh += abs($row['TRSNILAI']);
					} else {
						$sldakh -= abs($row['TRSNILAI']);
					}
				}

				echo ("<tr>");
				echo ("<th align = left><font face = verdana size = 2 color = blue>" . $tmptgl . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSCODE'] . "</font></th>");
				echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSDBCR'] . "</font></th>");
				echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['TRDESC'] . "</font></th>");
				echo ("<th align = right><font face = verdana size = 2 color = blue>" . $tmpnil . "</font></th>");
				echo ("</tr>");
			}

			$tmptgl = substr($txttgl, 0, 2) . "/" . substr($txttgl, 3, 2) . "/" . substr($txttgl, 6, 4);
			$tmpakh = number_format($sldakh, 2, '.', ',');

			echo ("<tr>");
			echo ("<th align = left><font face = verdana size = 2 color = blue>" . $tmptgl . "</font></th>");
			echo ("<th align = center><font face = verdana size = 2 color = blue>" . "   " . "</font></th>");
			echo ("<th align = center><font face = verdana size = 2 color = blue>" . "-" . "</font></th>");
			echo ("<th align = left><font face = verdana size = 2 color = blue>" . "Saldo Akhir" . "</font></th>");
			echo ("<th align = right><font face = verdana size = 2 color = blue>" . $tmpakh . "</font></th>");
			echo ("</tr>");
			echo ("</table>");
		}
		$today = getdate();
		$txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
		$txtLogTime = date("H:i:s");
		$txtLogDesc = "Displaying Report : Rekap Transaksi Harian";

		$query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
		$result = sqlsrv_query($conn2, $query);
	}
	sqlsrv_close($conn2);
		?>
</body>

</html>