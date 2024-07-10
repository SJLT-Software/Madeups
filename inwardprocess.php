<?php
include("connection/dbconnection.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lotno = $_POST['lotno'];
    $sku = $_POST['skuinward'];
    $query = "SELECT * FROM main WHERE sku = '$sku'";
    $skuresult = mysqli_query($con, $query);
    $query = "SELECT * FROM datadb WHERE lotno = '$lotno' and sku = '$sku'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['dashboarderror'] = "Lotno already exists!!";
        header("Location: superuser.php");
        exit();
    } else if(mysqli_num_rows($skuresult) === 0) {
        $_SESSION['dashboarderror'] = "Incorrect SKU!!";
        header("Location: superuser.php");
        exit();
    } 
    else {
        $norolls = $_POST['qty'];
        $totalmeters = $_POST['totalmetersfield'];
        $date = date('Y-m-d', strtotime($_POST['date']));
        $sku = $_POST['skuinward'];
        $name = $_POST['namevalidationField'];
        $construction = $_POST['construction'];
        $width = $_POST['width'];
        for ($i = 1; $i <= $norolls; $i++) {
            $rollnumber = $_POST['rollnumber' . $i];
            $rollmeters = $_POST['rollmeters' . $i];

            $insertQuery = "INSERT INTO datadb (date, sku, name, width, lotno, construction, norolls, totalmeters, rollno, rollmeters, currentmeters) VALUES ('$date', '$sku', '$name', '$width', '$lotno', '$construction', '$norolls', '$totalmeters', '$rollnumber', '$rollmeters', '$rollmeters')";
            mysqli_query($con, $insertQuery);
        }

        $_SESSION['dashboarderror'] = "Data inserted successfully!!";
        header("Location: superuser.php");
        exit();
    }
}
?>