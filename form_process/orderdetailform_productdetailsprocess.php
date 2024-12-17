<?php

session_start();
// error_reporting(0); // Suppress errors and warnings

include("../connection/dbconnection.php");
if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$username = $_SESSION['userdets'][1];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sales_order_no = $_POST['sales_order_no'];
    foreach ($_POST['product_details'] as $product) {
        $query = "INSERT INTO product_details (user,sales_order_no, po_no, buyer_product_code, internal_product_code, product_type, tc, design_weave, color, size, order_qty, cut_size, cut_plan_direction, cut_width_in_inches, cutting_comments, consumption, thread_code, label, elastic, label_placement) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssssssssssssss",$username, $sales_order_no, $product['po_no'], $product['buyer_product_code'], $product['internal_product_code'], $product['product_type'], $product['tc'], $product['design_weave'], $product['color'], $product['size'], $product['order_qty'], $product['cut_size'], $product['cut_plan_direction'], $product['cut_width_in_inches'], $product['cutting_comments'], $product['consumption'], $product['thread_code'], $product['label'], $product['elastic'], $product['label_placement']);
        $stmt->execute();
    }
    $_SESSION['dashboraderror'] = "Product details processed successfully.";
    $stmt->close();
    $conn->close();
    header("Location: superuser.php");
    exit();
}