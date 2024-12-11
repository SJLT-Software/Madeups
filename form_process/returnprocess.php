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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['return_qr'])) {
        $id = $_POST['selectedrollreturn'];
        $meters = $_POST['rollmetersreturn'];
        $date = date("Y-m-d");
        $query = "SELECT currentmeters FROM datadb WHERE id = '$id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $meters = $row['currentmeters'] - $meters;
        $query = "UPDATE datadb SET status = 'in', currentmeters = '$meters', date = '$date' WHERE id = '$id'";
        mysqli_query($con, $query);
        unset($_POST['return_qr']);
        $rollinfoquery = "SELECT * FROM datadb WHERE id = '$id'";
        $result = mysqli_query($con, $rollinfoquery);
        $row = mysqli_fetch_assoc($result);
        $sku = $row['sku'];
        $lotno = $row['lotno'];
        $norolls = $row['norolls'];
        $rollnumber = $row['rollno'];
        $rollmeters = $row['currentmeters'];
        // $id = $row['id'];
        $logquery = "INSERT INTO logdb (date, username, sku, lotno, norolls, rollno, rollid, return_meters) VALUES ('$date', '$username', '$sku', '$lotno', '$norolls', '$rollnumber', '$id', '$rollmeters')";
        mysqli_query($con, $logquery);
            }
    else {
    $date = date('Y-m-d', strtotime($_POST['datereturn']));
    $norolls = $_POST['rollschoosenreturn'];
    for ($i = 0; $i < $norolls; $i++) {
        $id = $_POST['selectedrollreturn' . $i];
        $meters = $_POST['rollmetersreturn' . $i];
        $query = "SELECT currentmeters FROM datadb WHERE id = '$id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $meters = $row['currentmeters'] - $meters;
        $query = "UPDATE datadb SET status = 'in', currentmeters = '$meters', date = '$date' WHERE id = '$id'";
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
        $logquery = "INSERT INTO logdb (date, username, sku, lotno, norolls, rollno, rollid, return_meters) VALUES ('$date', '$username', '$sku', '$lotno', '$norolls', '$rollnumber', '$id', '$rollmeters')";
        mysqli_query($con, $logquery);
        
    }
}
    $sku = $_POST['skureturn'];
    $lotno = $_POST['lotnoreturn'];
    // echo "<script>";
    // echo "console.log('$id');";
    // echo "console.log('$sku');";
    // echo "console.log('$lotno');";
    // echo "console.log('$meters');";
    // echo "</script>";
    $query = "UPDATE datadb SET totalmeters = (SELECT SUM(currentmeters) FROM datadb WHERE sku = '$sku' AND lotno = '$lotno' AND status = 'in') WHERE sku = '$sku' AND lotno = '$lotno'";
    mysqli_query($con, $query);
    $_SESSION['dashboarderror'] = "Roll succefully returned!!";
    header('Location: superuser.php');
    exit();
}
?>
