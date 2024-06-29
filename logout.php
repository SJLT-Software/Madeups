<?php
session_start();
if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    unset($_SESSION['userdets']);
    session_destroy();
    header("Location: index.php");
    
    exit();
}
else {
    session_destroy();  
    header("Location: index.php");
    exit();
}

?>
