<?php
session_start();
error_reporting(0); // Suppress errors and warnings
include("../connection/dbconnection.php");
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['username'];
    $stmt = $con->prepare("SELECT * FROM creds WHERE userid = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
	if (mysqli_num_rows($result) === 1) {
        $result = mysqli_fetch_assoc($result);
        if($result['password'] === $_POST['password']) {
            $_SESSION['userdets'] = [$result['name'], $result['userid']];
            header("Location: superuser.php");
            exit(); 
        }
        else {
            $_SESSION['message'] = "Invalid Credentials!!";
            header("Location: ../index.php");
            exit();
        }
} 
else {
    $_SESSION['message'] = "User does not exist!!";
    header("Location: index.php");
    exit();
}
}

?>