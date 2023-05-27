<?php
$hostmssql = "desktop-at7mpm7";
$username = "";
$password = "";
$database = "MIS_CBS";

$conn3 = mysqli_connect($hostmssql, $username, $password, $database);
if (!$conn3) {
    echo "Koneksi Gagal!";
} else {
    echo "Koneksi Berhasil!";
    // Perform database operations here...
    mysqli_close($conn3);
}
