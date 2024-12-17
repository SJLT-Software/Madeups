<?php

use FontLib\Table\Type\head;

session_start();
error_reporting(0); // Suppress errors and warnings

include("../connection/dbconnection.php");
if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$username = $_SESSION['userdets'][1];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sales_order_no = $_POST['sales_order_no'];
    echo $sales_order_no;
    $buyer_code = $_POST['buyer_code'];
    $work_order_number = $_POST['work_order_number'];
    $tech_pack = $_FILES['tech_pack'];
    $sample_code = $_POST['sample_code'];
    $first_piece_inspection = $_POST['first_piece_inspection'];
    $trim_accessories = $_POST['trim_accessories'];

    $thread_code = isset($_POST['thread_code']) ? $_POST['thread_code'] : 'N/A';
    $washcare_label = isset($_POST['washcare_label']) ? $_POST['washcare_label'] : 'N/A';
    $elastic = isset($_POST['elastic']) ? $_POST['elastic'] : 'N/A';
    $duvet_button = isset($_POST['duvet_button']) ? $_POST['duvet_button'] : 'N/A';
    $embroidery_design = isset($_POST['embroidery_design']) ? $_POST['embroidery_design'] : 'N/A';
    $embroidery_thread = isset($_POST['embroidery_thread']) ? $_POST['embroidery_thread'] : 'N/A';
    $insert_card = isset($_POST['insert_card']) ? $_POST['insert_card'] : 'N/A';
    $tag = isset($_POST['tag']) ? $_POST['tag'] : 'N/A';
    $poly_bag = isset($_POST['poly_bag']) ? $_POST['poly_bag'] : 'N/A';
    $carton_box = isset($_POST['carton_box']) ? $_POST['carton_box'] : 'N/A';
    $carton_box_sticker = isset($_POST['carton_box_sticker']) ? $_POST['carton_box_sticker'] : 'N/A';

    // Handle file upload
    $upload_dir = '../uploads/orderchecklistitems_techpacks/';
    $date = date('d-m-Y');
    $tech_pack_name = "{$sales_order_no}_{$buyer_code}_{$date}.pdf";
    $tech_pack_path = $upload_dir . $tech_pack_name;
    if (!move_uploaded_file($tech_pack['tmp_name'], $tech_pack_path)) {
        $_SESSION['dashboraderror'] = ('Failed to upload tech pack.');
        header("Location: superuser.php");
        exit();
    }

    // Insert data into database

    $sql = "INSERT INTO orderchecklistitems (sales_order_no, buyer_code, work_order_no, tech_pack, sample_code, first_piece_inspection, trim_accessories, thread_code, washcare_label, elastic, duvet_button, embroidery_design, embroidery_thread, insert_card, tag, poly_bag, carton_box, carton_box_sticker, user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('issssssssssssssssss', $sales_order_no, $buyer_code, $work_order_number, $tech_pack_path, $sample_code, $first_piece_inspection, $trim_accessories, $thread_code, $washcare_label, $elastic, $duvet_button, $embroidery_design, $embroidery_thread, $insert_card, $tag, $poly_bag, $carton_box, $carton_box_sticker, $username);

    if ($stmt->execute()) {
        $_SESSION['dashboraderror'] = "Order details submitted successfully.";
    } else {
        $_SESSION['dashboraderror'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    header("Location: superuser.php");
    exit();
}
?>