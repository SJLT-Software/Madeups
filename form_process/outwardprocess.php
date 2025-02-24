<?php
error_reporting(0); // Suppress errors and warnings

session_start();

include("../connection/dbconnection.php");

if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$username = $_SESSION['userdets'][1];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['outward_qr'])) {
        $id = $_POST['selectedrolloutward'];
        // $orderdetail = $_POST['orderdetail'];
        $date = date("Y-m-d");
        // $query = "UPDATE datadb SET status = 'out', date = '$date', order_detail = '$orderdetail' WHERE id = '$id'";
        $query = "UPDATE datadb SET status = 'out', date = '$date' WHERE id = '$id'";
        mysqli_query($con, $query);
        unset($_POST['outward_qr']);
        $rollinfoquery = "SELECT * FROM datadb WHERE id = '$id'";
        $result = mysqli_query($con, $rollinfoquery);
        $row = mysqli_fetch_assoc($result);
        $sku = $row['sku'];
        $lotno = $row['lotno'];
        $norolls = $row['norolls'];
        $rollnumber = $row['rollno'];
        $rollmeters = $row['currentmeters'];
        // $id = $row['id'];
        $logquery = "INSERT INTO logdb (date, username, sku, lotno, norolls, rollno, rollid, outward_meters) VALUES ('$date', '$username', '$sku', '$lotno', '$norolls', '$rollnumber', '$id', '$rollmeters')";
        mysqli_query($con, $logquery);
    }
    else {
    $date = date('Y-m-d', strtotime($_POST['dateoutward']));
    $norolls = $_POST['rollschoosen'];
    for ($i = 0; $i < $norolls; $i++) {
        $id = $_POST['selectedroll' . $i];
        $orderdetail = $_POST['orderdetail'];
        $query = "UPDATE datadb SET status = 'out', date = '$date', order_detail = '$orderdetail' WHERE id = '$id'";
        mysqli_query($con, $query);
        $rollinfoquery = "SELECT * FROM datadb WHERE id = '$id'";
        $result = mysqli_query($con, $rollinfoquery);
        $row = mysqli_fetch_assoc($result);
        $sku = $row['sku'];
        $lotno = $row['lotno'];
        $norolls = $row['norolls'];
        $rollnumber = $row['rollno'];
        $rollmeters = $row['currentmeters'];
        // $id = $row['id'];
        $logquery = "INSERT INTO logdb (date, username, sku, lotno, norolls, rollno, rollid, outward_meters) VALUES ('$date', '$username', '$sku', '$lotno', '$norolls', '$rollnumber', '$id', '$rollmeters')";
        mysqli_query($con, $logquery);
        
    }
}
    $sku = $_POST['skuoutward'];
    $lotno = $_POST['lotnooutward'];
    $query = "UPDATE datadb SET totalmeters = (SELECT SUM(currentmeters) FROM datadb WHERE sku = '$sku' AND lotno = '$lotno' AND status = 'in') WHERE sku = '$sku' AND lotno = '$lotno'";
    mysqli_query($con, $query);
    $_SESSION['dashboarderror'] = "Roll is now out!!";
    header('Location: superuser.php');
    exit();

}