<?php
session_start();
include("connection/dbconnection.php");
$sku = $_GET['sku']; // Use a more secure method to handle input in production

$stmt = "SELECT * FROM main WHERE SKU = '$sku'";
$result = mysqli_query($con, $stmt);
$result = mysqli_fetch_assoc($result);
if ($result) {
    echo $result['Name'];
} else {
    echo 'SKU not found';
}?>