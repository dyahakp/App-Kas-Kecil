<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
?>
<html>

<head>
	<title></title>
</head>

<script language=JavaScript>
	function loadprint() {
		window.print();
	}
</script>
<style type="text/css" media="print">
	.page-break {
		display: block;
		page-break-before: always;
	}
</style>

<body onload="loadprint();">
	<?php
	include "kk_konek2.php";

	$userid = $_SESSION['User'];
	$trstopc = $_SESSION['Kdkas'];
	$txttgl = $_REQUEST['txtTgl'];
	$trsdate = substr($txttgl, 6, 4) . substr($txttgl, 3, 2) . substr($txttgl, 0, 2);

	$sql = "SELECT PCBRANCH, PCDEPT, PCREGION FROM PCMASTER WHERE PCCODE = '$trstopc'";
	$result = sqlsrv_query($conn2, $sql);

	while ($row = sqlsrv_fetch_array($result)) {
		$kdcab = $row['PCBRANCH'];
		$kddep = $row['PCDEPT'];
		$kdwil = $row['PCREGION'];
	}
	?>
	<h2><u>Daftar Jurnal Otomatis</u></h2>
	<table border="0" cellspacing="0">
		<?php
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Kas :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$trstopc</b></font></td></tr>");
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Dept. :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$kddep</b></font></td></tr>");
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Cabang :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$kdcab</b></font></td></tr>");
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Regional :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$kdwil</b></font></td></tr>");
		echo ("<tr><td><font face = verdana size = 2 color = black><b>Tanggal :</b></font></td>");
		echo ("<td><font face = verdana size = 2 color = blue><b>$txttgl</b></font></td></tr>");
		?>
	</table>
	<table border="1" cellspacing="0">
		<?php
		$sql = "SELECT TRSNOTA, TRSCODE, TRSVALUTA, TRSDESC, TRSDBCR, TRSNILAI, 
        CASE WHEN TRSDBCR = 'D' THEN PCMASTER.PCNOSL ELSE TRTABLE.TRNOSL END AS DEBET, 
		CASE WHEN TRSDBCR = 'K' THEN PCMASTER.PCNOSL ELSE TRTABLE.TRNOSL END AS KREDIT 
		FROM TRMASTER  
		LEFT OUTER JOIN PCMASTER ON TRMASTER.TRSTOPC = PCMASTER.PCCODE 
		LEFT OUTER JOIN TRTABLE ON TRMASTER.TRSCODE = TRTABLE.TRCODE
		WHERE TRSVALUTA = '$trsdate' AND TRSTOPC = '$trstopc'";

		$result = sqlsrv_query($conn2, $sql);

		if ($result) {
			if (sqlsrv_num_rows($result) != 0) {
				$heder[0] = "NO. NOTA";
				$heder[1] = "KODE TRANS.";
				$heder[2] = "TGL. VALUTA";
				$heder[3] = "DESKRIPSI";
				$heder[4] = "D/K";
				$heder[5] = "NILAI";
				$heder[6] = "DEBET";
				$heder[7] = "KREDIT";

				$nPage = 0;
				$nRows = 0;

				while ($row = sqlsrv_fetch_array($result)) {
					if ($nRows == 0) {
						echo ("<tr>");
						for ($i = 0; $i < 8; $i++) {
							echo ("<th><font face = verdana size = 2 color = black>" . $heder[$i] . "</font></th>");
						}
						echo ("</tr>");
					}

					$ctggl = substr($row['TRSVALUTA'], 8, 2) . "/" . substr($row['TRSVALUTA'], 5, 2) . "/" . substr($row['TRSVALUTA'], 0, 4);
					$cjmlh = number_format(abs($row['TRSNILAI']), 2, '.', ',');
					$csldb = $row['DEBET'];
					$cslcr = $row['KREDIT'];
					$bikin = '1';

					if (substr($csldb, 0, 5) == '     ') {
						$bikin = '0';
					}
					if (substr($cslcr, 0, 5) == '     ') {
						$bikin = '0';
					}

					if ($bikin == '1') {
						echo ("<tr>");
						echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['TRSNOTA'] . "</font></th>");
						echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSCODE'] . "</font></th>");
						echo ("<th align = center><font face = verdana size = 2 color = blue>" . $ctggl . "</font></th>");
						echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['TRSDESC'] . "</font></th>");
						echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSDBCR'] . "</font></th>");
						echo ("<th align = right><font face = verdana size = 2 color = blue>" . $cjmlh . "</font></th>");
						echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['DEBET'] . "</font></th>");
						echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['KREDIT'] . "</font></th>");
						echo ("</tr>");

						$nRows++;

						if ($nRows > 40) {
							$nPage++;

							echo ("<tr>");
							echo ("<th align = left><font face = verdana size = 2 color = black>" . "Hal. " . $nPage . "</font></th>");
							echo ("</tr>");
		?>
							<div class="page-break"></div>
		<?php
							$nRows = 0;
						}
					}
				}

				if ($nRows > 0) {
					$nPage++;

					echo ("<tr>");
					echo ("<th align = left><font face = verdana size = 2 color = black>" . "Hal. " . $nPage . "</font></th>");
					echo ("</tr>");
				}
			}
			$today = getdate();
			$txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
			$txtLogTime = date("H:i:s");
			$txtLogDesc = "Printing Report : Daftar Jurnal Otomatis " . $txttgl;

			$query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
			$result = sqlsrv_query($conn2, $query);
		}
		sqlsrv_close($conn2);
		?>
	</table>
</body>

</html>