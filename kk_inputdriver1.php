<?php
include "kk_konek2.php";

session_start();
$userid = $_SESSION['User'];

$result = array();

$query = "SELECT iddriver, namadriver, nominalkasbon, date_updated FROM tbdriver";
$sql = sqlsrv_query($conn2, $query);

if ($sql === false) {
    die(print_r(sqlsrv_errors(), true));
}


while ($rows = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {

    if($rows['date_updated'] != NUll) {
    // Konversi tanggal ke format yang diinginkan, misalnya "Y-m-d H:i:s"
    $rows['date_updated'] = $rows['date_updated']->format("Y-m-d");
} else {
    $row['date_updated'] = "";
}
array_push($result, $rows);
}

echo json_encode($result);

sqlsrv_close($conn2);
?>
