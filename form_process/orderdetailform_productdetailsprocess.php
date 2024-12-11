<?php

session_start();
error_reporting(0); // Suppress errors and warnings

include("connection/dbconnection.php");
if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$username = $_SESSION['userdets'][1];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sales_order_no = $_POST['sales_order_no'];
}