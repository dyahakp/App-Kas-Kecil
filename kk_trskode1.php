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

	$txtKode = $_REQUEST['txtKode'];
	$txtTgl1 = $_REQUEST['txtTgl1'];
	$txtTgl2 = $_REQUEST['txtTgl2'];
	$trsdat1 = substr($txtTgl1, 6, 4) . substr($txtTgl1, 3, 2) . substr($txtTgl1, 0, 2);
	$trsdat2 = substr($txtTgl2, 6, 4) . substr($txtTgl2, 3, 2) . substr($txtTgl2, 0, 2);
	$trsnow = substr($txtTgl1, 0, 2) . "/" . substr($txtTgl1, 3, 2) . "/" . substr($txtTgl1, 6, 4) . " - " . substr($txtTgl2, 0, 2) . "/" . substr($txtTgl2, 3, 2) . "/" . substr($txtTgl2, 6, 4);

	$sql = "SELECT PCBRANCH, PCDEPT FROM PCMASTER WHERE PCCODE = '$trstopc'";
	$result = sqlsrv_query($conn2, $sql);

	while ($row = sqlsrv_fetch_array($result)) {
		$kdcab = $row['PCBRANCH'];
		$kddep = $row['PCDEPT'];
	}
	?>
	<h2><u>Daftar Transaksi per Kode Transaksi</u></h2>
	<table border="0" cellspacing="0">
		<?php
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Kas :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$trstopc</b></font></td></tr>");
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Dept. :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$kddep</b></font></td></tr>");
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Cabang :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$kdcab</b></font></td></tr>");
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Tanggal :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$trsnow</b></font></td></tr>");
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Trans. :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$txtKode</b></font></td></tr>");
		?>
	</table>
	<?php
	$sql = "SELECT TRSVALUTA, (TRSCODE + ' - ' + TRTABLE.TRDESC) AS TRANSAKSI, TRSDBCR, TRSNILAI, TRSDESC, TRSUSRINP, TRSUSRAUT
		FROM TRMASTER  
		LEFT OUTER JOIN TRTABLE ON TRMASTER.TRSCODE = TRTABLE.TRCODE 
		WHERE TRSVALUTA >= '$trsdat1' AND TRSVALUTA <= '$trsdat2' AND TRSTOPC = '$trstopc' AND TRSCODE = '$txtKode' 
		ORDER BY TRSVALUTA";

	$result = sqlsrv_query($conn2, $sql);

	if ($result) {
		if (sqlsrv_num_rows($result) == 0) {
			echo ("<B>Data Tidak Ditemukan !</B>");
		} else {
			$heder[0] = "TGL. VALUTA";
			$heder[1] = "TRANSAKSI";
			$heder[2] = "DESKRIPSI";
			$heder[3] = "NILAI";
			$heder[4] = "USER INPUT";
			$heder[5] = "USER AUTH.";
	?>
			<table border="1" cellspacing="0">
				<tr>
					<?php
					for ($i = 0; $i < 6; $i++) {
						echo ("<th><font face = verdana size = 2 color = black>" . $heder[$i] . "</font></th>");
					}
					?>
				</tr>
		<?php
			$sldakh = 0;

			while ($row = sqlsrv_fetch_array($result)) {
				$tmptgl = substr($row['TRSVALUTA'], 8, 2) . "/" . substr($row['TRSVALUTA'], 5, 2) . "/" . substr($row['TRSVALUTA'], 0, 4);
				$tmpnil = number_format(abs($row['TRSNILAI']), 2, '.', ',');
				$tmpdbcr = $row['TRSDBCR'];

				if ($tmpdbcr == "D") {
					$sldakh += $row['TRSNILAI'];
				} else {
					$sldakh -= $row['TRSNILAI'];
				}

				echo ("<tr>");
				echo ("<th align = left><font face = verdana size = 2 color = blue>" . $tmptgl . "</font></th>");
				echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['TRANSAKSI'] . "</font></th>");
				echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['TRSDESC'] . "</font></th>");
				echo ("<th align = right><font face = verdana size = 2 color = blue>" . $tmpnil . "</font></th>");
				echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['TRSUSRINP'] . "</font></th>");
				echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['TRSUSRAUT'] . "</font></th>");
				echo ("</tr>");
			}

			$tmptgl = " ";
			$tmpnil = number_format(abs($sldakh), 2, '.', ',');

			echo ("<tr>");
			echo ("<th align = left><font face = verdana size = 2 color = blue>" . $tmptgl . "</font></th>");
			echo ("<th align = left><font face = verdana size = 2 color = blue>" . "TOTAL" . "</font></th>");
			echo ("<th align = left><font face = verdana size = 2 color = blue>" . "   " . "</font></th>");
			echo ("<th align = right><font face = verdana size = 2 color = blue>" . $tmpnil . "</font></th>");
			echo ("<th align = left><font face = verdana size = 2 color = blue>" . "   " . "</font></th>");
			echo ("<th align = left><font face = verdana size = 2 color = blue>" . "   " . "</font></th>");
			echo ("</tr>");
			echo ("</table>");
		}
		$today = getdate();
		$txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
		$txtLogTime = date("H:i:s");
		$txtLogDesc = "Displaying Report : Daftar Transaksi per Kode Trans.";

		$query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
		$result = sqlsrv_query($conn2, $query);
	}
	sqlsrv_close($conn2);
		?>
</body>

</html>