<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
include("connection/dbconnection.php");
$sku = $_GET['sku'];
if(isset($_GET['type'])) {
    if($_GET['type'] == 'out') {
        $query = "SELECT distinct lotno, totalmeters FROM datadb WHERE sku = '$sku' AND status = 'out'";
        $result = mysqli_query($con, $query);
        $rolls = [];
        while($row = mysqli_fetch_assoc($result)){
            $rolls[] = $row;
        }
        echo json_encode($rolls);
        exit();
    }
}

$query = "SELECT distinct lotno, totalmeters FROM datadb WHERE sku = '$sku' AND status = 'in'";
$result = mysqli_query($con, $query);
$rolls = [];

while($row = mysqli_fetch_assoc($result)){
    $rolls[] = $row;
}

echo json_encode($rolls);
