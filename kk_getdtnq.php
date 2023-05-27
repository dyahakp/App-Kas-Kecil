<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['tglquery'] = $_REQUEST['trsvaluta'];

//print_r($_SESSION['tglquery']);
