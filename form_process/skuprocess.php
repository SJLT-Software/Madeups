<?php
session_start();
include("connection/dbconnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sku = $_POST['sku'];

    $query = "SELECT * FROM main WHERE sku = '$sku'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['dashboarderror'] = "SKU already exists";
        header("Location: superuser.php");
        exit();
    } else {
        $name = $_POST['Name'];
        // $construction = $_POST['construction'];
        $tc = $_POST['tc'];

        $insertQuery = "INSERT INTO main (sku, name, threadcount) VALUES ('$sku', '$name', '$tc')";
        mysqli_query($con, $insertQuery);

        $_SESSION['dashboarderror'] = "SKU added successfully!!";
        header("Location: superuser.php");
        exit();
    }
}
?>