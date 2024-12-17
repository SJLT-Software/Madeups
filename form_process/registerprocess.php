<?php
session_start();
include("../connection/dbconnection.php");
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['username'];
	$stmt = "SELECT * FROM creds WHERE userid = '$userid'";
    $result = mysqli_query($con, $stmt);
	if (mysqli_num_rows($result) === 1) {
        $_SESSION['error'] = "User already exists";
        header("Location: register.php");
        exit();
    }
    else {
        $name = $_POST['name'];
        $pass = $_POST['password'];
        $stmt = "INSERT INTO creds (name, userid, password) VALUES ('$name', '$userid', '$pass')";
        mysqli_query($con,$stmt);
        $_SESSION['message'] = "User Successfully Created!!";
        header("Location: index.php");
        exit();
    }
}