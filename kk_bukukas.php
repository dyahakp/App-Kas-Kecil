<?php
include "kk_ceklogin.php";
// session_start();
$userid = $_SESSION['User'];
$trstopc = $_SESSION['Kdkas'];

?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Basic Form - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="jquery-easyui-1.3.4/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="jquery-easyui-1.3.4/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="jquery-easyui-1.3.4/demo/demo.css">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/bootstrap5/bootstrap.min.css" />

</head>

<body style="background: #F5F5F5;">
    <?php
    include "kk_konek2.php";
    $namakas = " ";

    $sql = "SELECT PCNAME, PCBRANCH, PCDEPT FROM PCMASTER WHERE PCCODE = '$trstopc'";
    $result = sqlsrv_query($conn2, $sql);

    while ($row = sqlsrv_fetch_array($result)) {
        $namakas = $row['PCNAME'];
        $kdcab = $row['PCBRANCH'];
        $kddep = $row['PCDEPT'];
    }
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4>Buku Kas Kecil</h4>
                        <table border="0" cellspacing="0">
                            <?php
                            echo ("<tr><td><font face='verdana' size='2' color='black'><b>Kode Kas :</b></font></td>");
                            echo ("<td><font face='verdana' size='2' color='black'><b>$trstopc</b></font></td></tr>");
                            echo ("<tr><td><font face='verdana' size='2' color='black'><b>Keterangan :</b></font></td>");
                            echo ("<td><font face='verdana' size='2' color='black'><b>$namakas</b></font></td></tr>");
                            echo ("<tr><td><font face='verdana' size='2' color='black'><b>Kode Dept. :</b></font></td>");
                            echo ("<td><font face='verdana' size='2' color='black'><b>$kddep</b></font></td></tr>");
                            echo ("<tr><td><font face='verdana' size='2' color='black'><b>Kode Cabang :</b></font></td>");
                            echo ("<td><font face='verdana' size='2' color='black'><b>$kdcab</b></font></td></tr>");
                            echo ("<tr><td><font face='verdana' size='2' color='black'><b>Periode :</b></font></td>");

                            ?>
                        </table>
                    </div>
                    <div class="card-body">

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tanggal Awal</label>
                                        <input type="date" name="txtTgl1" class="datepicker form-control" id="txtTgl1" value="<?php echo isset($_GET['txtTgl1']) ? date('Y-m-d', strtotime($_GET['txtTgl1'])) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <input type="date" name="txtTgl2" class="datepicker form-control" id="txtTgl2" value="<?php echo isset($_GET['txtTgl2']) ? date('Y-m-d', strtotime($_GET['txtTgl2'])) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <br>
                                    <div class="form-group">
                                        <button type="submit" name="submit-date" id="submit-date" class="btn btn-primary">Lihat Tanggal</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                    <?php
                    @$txttgl1 = $_GET['txtTgl1'];
                    @$txttgl2 = $_GET['txtTgl2'];

                    $sld = 0;

                    $sql = "SELECT TOP 1 BLCLVAL FROM BLMASTER WHERE BLTOPC = '$trstopc' AND BLDATE < '$txttgl1' ORDER BY BLDATE DESC";
                    $result = sqlsrv_query($conn2, $sql);

                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        $sld = $row['BLCLVAL'];
                    }
                    ?>

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" class="form-cari">
                        <div class="row mx-auto p-1">
                            <div class="col-md-8">

                                <input class="form-control" type="text" name="keyword" value="<?php if (isset($_GET['keyword'])) {
                                                                                                    echo $_GET['keyword'];
                                                                                                } ?>" size="40" autofocus placeholder="Masukkan keyword pencarian.." autocomplete="off" id="keyword">
                                <input type="date" name="txtTgl1" class="datepicker form-control" id="txtTgl1" value="<?php echo $txttgl1; ?>" hidden readonly>
                                <input type="date" name="txtTgl2" class="datepicker form-control" id="txtTgl2" value="<?php echo $txttgl2; ?>" hidden readonly>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary mb-2" name="cari" id="tombol-cari">Mencari</button>
                                <label class="dropdown">

                                    <div class="dd-button"><img src="src/filter.png" width="10" height="10" alt=""> Filter</div>

                                    <input type="checkbox" class="dd-input" id="test" />

                                    <ul class="dd-menu">
                                        <li>
                                            <button class="btn btn-light" style="background-color: transparent;" type="submit" name="filter-kredit" id="filter-kredit"> Filter by Kredit</button>
                                        </li>
                                        <li>
                                            <button class="btn btn-light" style="background-color: transparent;" type="submit" name="filter-debit" id="filter-debit"> Filter by Debit</button>
                                        </li>
                                    </ul>
                                </label>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mx-auto p-2">
        <div id="result">

            <?php

            if (isset($_GET['cari'])) {
                $keyword = $_GET['keyword'];
                @$txttgl1 = $_GET['txtTgl1'];
                @$txttgl2 = $_GET['txtTgl2'];

                $sql = "SELECT TRSNOTA, TRSCODE, TRSVALUTA, TRSDESC, TRSDBCR, TRSNILAI, TRSREFF, TRSTORF, TRSUSRINP, TRSUSRAUT
                    FROM TRMASTER  
                    WHERE TRSVALUTA >= '$txttgl1' AND TRSVALUTA <= '$txttgl2' AND TRSTOPC = '$trstopc' AND TRSUSRAUT != '          ' 
                    AND (TRSDESC LIKE '%$keyword%' OR TRSREFF LIKE '%$keyword%' OR TRSCODE LIKE '%$keyword%')
                    ORDER BY TRSVALUTA, TRSREFF";
            } elseif (isset($_GET['submit-date'])) {
                $sql = "SELECT TRSNOTA, TRSCODE, TRSVALUTA, TRSDESC, TRSDBCR, TRSNILAI, TRSREFF, TRSTORF, TRSUSRINP, TRSUSRAUT
                    FROM TRMASTER  
                    WHERE TRSVALUTA >= '$txttgl1' AND TRSVALUTA <= '$txttgl2' AND TRSTOPC = '$trstopc' AND TRSUSRAUT != '          ' 
                    ORDER BY TRSVALUTA, TRSREFF";
            } elseif (isset($_GET['filter-kredit'])) {

                $sql = "SELECT TRSNOTA, TRSCODE, TRSVALUTA, TRSDESC, TRSDBCR, TRSNILAI, TRSREFF, TRSTORF, TRSUSRINP, TRSUSRAUT
                FROM TRMASTER  
                WHERE TRSVALUTA >= '$txttgl1' AND TRSVALUTA <= '$txttgl2' AND TRSTOPC = 'KASLOG' AND TRSUSRAUT != '          ' 
                AND (TRSDBCR LIKE '%k%')
                ORDER BY TRSVALUTA, TRSREFF";
            } elseif (isset($_GET['filter-debit'])) {

                $sql = "SELECT TRSNOTA, TRSCODE, TRSVALUTA, TRSDESC, TRSDBCR, TRSNILAI, TRSREFF, TRSTORF, TRSUSRINP, TRSUSRAUT
                FROM TRMASTER  
                WHERE TRSVALUTA >= '$txttgl1' AND TRSVALUTA <= '$txttgl2' AND TRSTOPC = 'KASLOG' AND TRSUSRAUT != '          ' 
                AND (TRSDBCR LIKE '%d%')
                ORDER BY TRSVALUTA, TRSREFF";
            }

            $result = sqlsrv_query($conn2, $sql, array(), array("Scrollable" => 'keyset'));

            if ($result) {
                if (sqlsrv_num_rows($result) == 0) {
                    echo ("<b>" . "Data Tidak Ditemukan!" . "</b>");
                } else {
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

                    echo ("<table class='table' border='1' cellspacing='0'>");
                    echo ("<tr>");
                    for ($i = 0; $i < 11; $i++) {
                        echo ("<th><font face='verdana' size='2' color='black'>" . $heder[$i] . "</font></th>");
                    }
                    echo ("</tr>");

                    $tmpnil = number_format(abs($sld), 2, '.', ',');

                    echo ("<tr>");
                    echo ("<th align='right'><font face='verdana' size='2' color='black'> </font></th>");
                    echo ("<th align='right'><font face='verdana' size='2' color='black'> </font></th>");
                    echo ("<th align='right'><font face='verdana' size='2' color='black'> </font></th>");
                    echo ("<th align='left'><font face='verdana' size='2' color='black'> Saldo Awal </font></th>");
                    echo ("<th align='right'><font face='verdana' size='2' color='black'> </font></th>");
                    echo ("<th align='right'><font face='verdana' size='2' color='black'> $tmpnil </font></th>");
                    echo ("<th align='right'><font face='verdana' size='2' color='black'> </font></th>");
                    echo ("<th align='right'><font face='verdana' size='2' color='black'> </font></th>");
                    echo ("<th align='right'><font face='verdana' size='2' color='black'> </font></th>");
                    echo ("<th align='right'><font face='verdana' size='2' color='black'> </font></th>");
                    echo ("<th align='right'><font face='verdana' size='2' color='black'> </font></th>");
                    echo ("</tr>");

                    while ($row = sqlsrv_fetch_array($result)) {
                        echo ("<tr>");
                        echo ("<td align='left'><font face='verdana' size='2' color='black'>" . $row['TRSNOTA'] . "</font></td>");
                        echo ("<td align='left'><font face='verdana' size='2' color='black'>" . $row['TRSCODE'] . "</font></td>");

                        $tglvaluta = $row['TRSVALUTA']->format('d/m/Y');
                        echo ("<td align='left'><font face='verdana' size='2' color='black'>" . $tglvaluta . "</font></td>");

                        echo ("<td align='left'><font face='verdana' size='2' color='black'>" . $row['TRSDESC'] . "</font></td>");
                        echo ("<td align='center'><font face='verdana' size='2' color='black'>" . $row['TRSDBCR'] . "</font></td>");

                        $nil = number_format(abs($row['TRSNILAI']), 2, '.', ',');
                        echo ("<td align='right'><font face='verdana' size='2' color='black'>" . $nil . "</font></td>");

                        if ($row['TRSDBCR'] == "D") {
                            $sld = $sld + $row['TRSNILAI'];
                        } else {
                            $sld = $sld - $row['TRSNILAI'];
                        }
                        $tmpnil = number_format(abs($sld), 2, '.', ',');

                        echo ("<td align='right'><font face='verdana' size='2' color='black'>" . $tmpnil . "</font></td>");
                        echo ("<td align='left'><font face='verdana' size='2' color='black'>" . $row['TRSTORF'] . "</font></td>");
                        echo ("<td align='left'><font face='verdana' size='2' color='black'>" . $row['TRSREFF'] . "</font></td>");
                        echo ("<td align='left'><font face='verdana' size='2' color='black'>" . $row['TRSUSRINP'] . "</font></td>");
                        echo ("<td align='left'><font face='verdana' size='2' color='black'>" . $row['TRSUSRAUT'] . "</font></td>");
                        echo ("</tr>");
                    }
                    echo ("</table>");
                }
            } else {
                echo ("<b>" . "Query Error!" . "</b>");
            }

            ?>
            <?php
            sqlsrv_free_stmt($result);
            sqlsrv_close($conn2);
            ?>
        </div>

    </div>
    </div>
    </div>
    <!-- Menyisipkan JQuery dan Javascript Bootstrap -->
    <script src="js/bootstrap5/bootstrap.min.js"></script>
</body>

</html>