<?php
session_start();
include("../connection/dbconnection.php");
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['username'];
    $stmt = $con->prepare("SELECT * FROM creds WHERE userid = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
	if (mysqli_num_rows($result) === 1) {
        $_SESSION['error'] = "User already exists";
        header("Location: register.php");
        exit();
    }
    else {
        $name = $_POST['name'];
        $pass = $_POST['password'];
        $stmt = $con->prepare("INSERT INTO creds (name, userid, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $userid, $pass);
        $stmt->execute();
        $stmt->close();
        $_SESSION['message'] = "User Successfully Created!!";
        header("Location: index.php");
        exit();
    }
}