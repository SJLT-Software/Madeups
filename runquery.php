<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
include("connection/dbconnection.php");
$query = $_GET['query'];
$result = mysqli_query($con, $query);
$list = [];
while($row = mysqli_fetch_assoc($result)){
    $list[] = $row;
}
echo json_encode($list);