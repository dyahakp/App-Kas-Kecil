<?php
$serverName = "desktop-at7mpm7"; //serverName\instanceName
$connectionInfo = array(
    "Database" => "KASKECIL",
    "UID" => "",
    "PWD" => ""
);

$conn2 = sqlsrv_connect($serverName, $connectionInfo);
if (!$conn2) {
    echo "Connection could not be established.<br />";
    die(print_r(sqlsrv_errors(), true));
} else {
    $stmt2 = sqlsrv_connect($serverName, $connectionInfo);

    if (!$stmt2) {
        echo ("Database Gagal Dibuka !");
    }
}

// <?php
// $serverName = "desktop-at7mpm7"; //serverName\instanceName
// $username = "";
// $password = "";
// $database = "KASKECIL";

// $conn2 = mysqli_connect("$serverName", "$username", "$password");
// if (!$conn2) {
//     echo ("Koneksi Gagal !");
// } else {
//     $stmt = mysqli_select_db($conn2, $database);

//     if (!$stmt) {
//         echo ("Database Gagal Dibuka !");
//     }
// }