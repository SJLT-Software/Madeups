<?php
session_start();

include("connection/dbconnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $norolls = $_POST['rollschoosen'];
    for ($i = 0; $i < $norolls; $i++) {
        $id = $_POST['selectedroll' . $i];
        $query = "UPDATE datadb SET status = 'out' WHERE id = '$id'";
        mysqli_query($con, $query);
    }
    $sku = $_POST['skuoutward'];
    $lotno = $_POST['lotnooutward'];
    $query = "UPDATE datadb SET totalmeters = (SELECT SUM(currentmeters) FROM datadb WHERE sku = '$sku' AND lotno = '$lotno') WHERE sku = '$sku' AND lotno = '$lotno'";
    mysqli_query($con, $query);
    
    header('Location: superuser.php');
    exit();
}