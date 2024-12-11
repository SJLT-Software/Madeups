<?php

use FontLib\Table\Type\head;

session_start();
error_reporting(0); // Suppress errors and warnings

include("connection/dbconnection.php");
if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$username = $_SESSION['userdets'][1];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sales_order_no = $_POST['sales_order_no'];
    $buyer_code = $_POST['buyer_code'];
    $work_order_number = $_POST['work_order_number'];
    $tech_pack = $_FILES['tech_pack'];
    $sample_code = $_POST['sample_code'];
    $first_piece_inspection = $_POST['first_piece_inspection'];
    $trim_accessories = $_POST['trim_accessories'];
    $thread_code = $_POST['thread_code'];
    $washcare_label = $_POST['washcare_label'];
    $elastic = $_POST['elastic'];
    $duvet_button = $_POST['duvet_button'];
    $embroidery_design = $_POST['embroidery_design'];
    $embroidery_thread = $_POST['embroidery_thread'];
    $insert_card = $_POST['insert_card'];
    $tag = $_POST['tag'];
    $poly_bag = $_POST['poly_bag'];
    $carton_box = $_POST['carton_box'];
    $carton_box_sticker = $_POST['carton_box_sticker'];

    // Handle file upload
    $upload_dir = 'uploads/orderdetails_techpacks/';
    $tech_pack_path = $upload_dir . basename($tech_pack['name']);
    if (!move_uploaded_file($tech_pack['tmp_name'], $tech_pack_path)) {
        $_SESSION['dashboraderror'] = ('Failed to upload tech pack.');
        header("Location: superuser.php");
        exit();
    }

    // Insert data into database
    $sql = "INSERT INTO order_details (sales_order_no, buyer_code, work_order_number, tech_pack, sample_code, first_piece_inspection, trim_accessories, thread_code, washcare_label, elastic, duvet_button, embroidery_design, embroidery_thread, insert_card, tag, poly_bag, carton_box, carton_box_sticker, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssssssssssssss', $sales_order_no, $buyer_code, $work_order_number, $tech_pack_path, $sample_code, $first_piece_inspection, $trim_accessories, $thread_code, $washcare_label, $elastic, $duvet_button, $embroidery_design, $embroidery_thread, $insert_card, $tag, $poly_bag, $carton_box, $carton_box_sticker, $username);

    if ($stmt->execute()) {
        $_SESSION['dashboraderror'] = "Order details submitted successfully.";
    } else {
        $_SESSION['dashboraderror'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: superuser.php");
    exit();
}
?>