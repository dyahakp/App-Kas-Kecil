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

  $txttgl1 = $_REQUEST['txtTgl1'];
  $txttgl2 = $_REQUEST['txtTgl2'];
  $trsdat1 = substr($txttgl1, 6, 4) . substr($txttgl1, 3, 2) . substr($txttgl1, 0, 2);
  $trsdat2 = substr($txttgl2, 6, 4) . substr($txttgl2, 3, 2) . substr($txttgl2, 0, 2);
  $txtprd = substr($txttgl1, 0, 2) . "/" . substr($txttgl1, 3, 2) . "/" . substr($txttgl1, 6, 4) . " - " . substr($txttgl2, 0, 2) . "/" . substr($txttgl2, 3, 2) . "/" . substr($txttgl2, 6, 4);
  $namakas = " ";
  $kasbon = " ";

  $sql = "SELECT PCNAME, PCBRANCH, PCDEPT, PCKASBON FROM PCMASTER WHERE PCCODE = '$trstopc'";
  $result = sqlsrv_query($conn2, $sql);

  while ($row = sqlsrv_fetch_array($result)) {
    $namakas = $row['PCNAME'];
    $kdcab = $row['PCBRANCH'];
    $kddep = $row['PCDEPT'];
    $kasbon = $row['PCKASBON'];
  }

  $sld = 0;

  $sql = "SELECT TOP 1 BLCLBON FROM BLMASTER WHERE BLTOPC = '$trstopc' AND BLDATE < '$trsdat1' ORDER BY BLDATE DESC";
  $result = sqlsrv_query($conn2, $sql);

  while ($row = sqlsrv_fetch_array($result)) {
    $sld = $row['BLCLBON'];
  }
  ?>
  <h2><u>Buku Kas Bon</u></h2>
  <table border="0" cellspacing="0">
    <?php
    echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Kas :</b></font></td>");
    echo ("<td><font face = verdana size = 2 color = blue><b>$trstopc</b></font></td></tr>");
    echo ("<tr><td><font face = verdana size = 2 color = black><b>Keterangan :</b></font></td>");
    echo ("<td><font face = verdana size = 2 color = blue><b>$namakas</b></font></td></tr>");
    echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Dept. :</b></font></td>");
    echo ("<td><font face = verdana size = 2 color = blue><b>$kddep</b></font></td></tr>");
    echo ("<tr><td><font face = verdana size = 2 color = black><b>Kode Cabang :</b></font></td>");
    echo ("<td><font face = verdana size = 2 color = blue><b>$kdcab</b></font></td></tr>");
    echo ("<tr><td><font face = verdana size = 2 color = black><b>Periode :</b></font></td>");
    echo ("<td><font face = verdana size = 2 color = blue><b>$txtprd</b></font></td></tr>");
    ?>
  </table>
  <table border="1" cellspacing="0">
    <?php
    $sql = "SELECT TRSNOTA, TRSCODE, TRSVALUTA, TRSDESC, TRSDBCR, TRSNILAI, TRSREFF, TRSTORF, TRSUSRINP, TRSUSRAUT
      FROM TRMASTER
      WHERE TRSVALUTA >= '$trsdat1' AND TRSVALUTA <= '$trsdat2' AND TRSCODE = '$kasbon' AND TRSTOPC = '$trstopc' AND ISNULL(TRSUSRAUT, SPACE(10)) != SPACE(10)
      ORDER BY TRSVALUTA, TRSREFF";

    $result = sqlsrv_query($conn2, $sql);

    if ($result) {
      if (sqlsrv_num_rows($result) != 0) {
        $heder[0] = "NO. NOTA";
        $heder[1] = "KODE TRANS.";
        $heder[2] = "TGL. VALUTA";
        $heder[3] = "DESKRIPSI";
        $heder[4] = "D/K";
        $heder[5] = "NILAI";
        $heder[6] = "SALDO";
        $heder[7] = "NO. BUKTI";
        $heder[8] = "REFERENSI";
        $heder[9] = "USER INPUT";
        $heder[10] = "USER AUTH.";

        $nPage = 0;
        $nRows = 1;

        echo ("<tr>");
        for ($i = 0; $i < 11; $i++) {
          echo ("<th><font face = verdana size = 2 color = black>" . $heder[$i] . "</font></th>");
        }
        echo ("</tr>");

        $tmpnil = number_format(abs($sld), 2, '.', ',');

        echo ("<tr>");
        echo ("<th align = left><font face = verdana size = 2 color = blue>" . " " . "</font></th>");
        echo ("<th align = center><font face = verdana size = 2 color = blue>" . " " . "</font></th>");
        echo ("<th align = center><font face = verdana size = 2 color = blue>" . " " . "</font></th>");
        echo ("<th align = left><font face = verdana size = 2 color = blue>" . "SALDO AWAL" . "</font></th>");
        echo ("<th align = center><font face = verdana size = 2 color = blue>" . " " . "</font></th>");
        echo ("<th align = right><font face = verdana size = 2 color = blue>" . " " . "</font></th>");
        echo ("<th align = right><font face = verdana size = 2 color = blue>" . $tmpnil . "</font></th>");
        echo ("<th align = center><font face = verdana size = 2 color = blue>" . " " . "</font></th>");
        echo ("<th align = center><font face = verdana size = 2 color = blue>" . " " . "</font></th>");
        echo ("<th align = center><font face = verdana size = 2 color = blue>" . " " . "</font></th>");
        echo ("<th align = center><font face = verdana size = 2 color = blue>" . " " . "</font></th>");
        echo ("</tr>");

        while ($row = sqlsrv_fetch_array($result)) {
          if ($nRows == 0) {
            echo ("<tr>");
            for ($i = 0; $i < 11; $i++) {
              echo ("<th><font face = verdana size = 2 color = black>" . $heder[$i] . "</font></th>");
            }
            echo ("</tr>");
          }

          $tmptgl = substr($row['TRSVALUTA'], 8, 2) . "/" . substr($row['TRSVALUTA'], 5, 2) . "/" . substr($row['TRSVALUTA'], 0, 4);
          $tmpnil = number_format(abs($row['TRSNILAI']), 2, '.', ',');
          $trsdbcr = $row['TRSDBCR'];
          $trsnilai = abs($row['TRSNILAI']);

          if ($trsdbcr == 'D') {
            $sld -= $trsnilai;
          } else {
            $sld += $trsnilai;
          }
          $tmpsld = number_format($sld, 2, '.', ',');

          echo ("<tr>");
          echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['TRSNOTA'] . "</font></th>");
          echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSCODE'] . "</font></th>");
          echo ("<th align = center><font face = verdana size = 2 color = blue>" . $tmptgl . "</font></th>");
          echo ("<th align = left><font face = verdana size = 2 color = blue>" . $row['TRSDESC'] . "</font></th>");
          echo ("<th align = center><font face = verdana size = 2 color = blue>" . $trsdbcr . "</font></th>");
          echo ("<th align = right><font face = verdana size = 2 color = blue>" . $tmpnil . "</font></th>");
          echo ("<th align = right><font face = verdana size = 2 color = blue>" . $tmpsld . "</font></th>");
          echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSREFF'] . "</font></th>");
          echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSTORF'] . "</font></th>");
          echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSUSRINP'] . "</font></th>");
          echo ("<th align = center><font face = verdana size = 2 color = blue>" . $row['TRSUSRAUT'] . "</font></th>");
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
      $txtLogDesc = "Printing Report : Buku Kas " . $trstopc;

      $query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
      $result = sqlsrv_query($conn2, $query);
    }
    sqlsrv_close($conn2);
    ?>
  </table>
</body>

</html>