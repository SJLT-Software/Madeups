<?php
session_start();

include("connection/dbconnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $norolls = $_POST['rollschoosenreturn'];
    for ($i = 0; $i < $norolls; $i++) {
        $id = $_POST['selectedrollreturn' . $i];
        $meters = $_POST['rollmetersreturn' . $i];
        $query = "SELECT currentmeters FROM datadb WHERE id = '$id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $meters = $row['currentmeters'] - $meters;
        $query = "UPDATE datadb SET status = 'in', currentmeters = '$meters' WHERE id = '$id'";
        mysqli_query($con, $query);
    }
    $sku = $_POST['skureturn'];
    $lotno = $_POST['lotnoreturn'];
    $query = "UPDATE datadb SET totalmeters = (SELECT SUM(currentmeters) FROM datadb WHERE sku = '$sku' AND lotno = '$lotno') WHERE sku = '$sku' AND lotno = '$lotno'";
    mysqli_query($con, $query);

    header('Location: superuser.php');
    exit();
}
?>
