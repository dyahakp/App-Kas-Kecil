<?php
$serverName = "desktop-at7mpm7"; //serverName\instanceName
$connectionInfo = array(
    "Database" => "SECURE",
    "UID" => "",
    "PWD" => ""
);

$conn1 = sqlsrv_connect($serverName, $connectionInfo);
if (!$conn1) {
    echo "Connection could not be established.<br />";
    die(print_r(sqlsrv_errors(), true));
} else {
    $stmt2 = sqlsrv_connect($serverName, $connectionInfo);

    if (!$stmt2) {
        echo ("Database Gagal Dibuka !");
    }
}
