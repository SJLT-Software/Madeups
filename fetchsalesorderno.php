<?php

use FontLib\Table\Type\head;

session_start();
// error_reporting(0); // Suppress errors and warnings
include("connection/dbconnection.php");
$salesorderno = $_GET['salesorderno']; // Use a more secure method to handle input in production

$stmt = $con->prepare("SELECT * FROM orderchecklistitems WHERE sales_order_no = ?");
$stmt->bind_param("i", $salesorderno);
$stmt->execute();
$result = $stmt->get_result();
$result = $result->fetch_assoc();
$response = [];
if ($result) {
    $response['exists'] = true;
    $response['data'] = $result;
} else {
    $response['exists'] = false;
} 
$stmt->close();
header('Content-Type: application/json');
echo json_encode($response);
// echo $response;
exit();
?>