<!DOCTYPE html>
<html lang="en" style="width: 75mm; height: 50mm; overflow: hidden;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inward Process</title>
    <script type="text/javascript" src="../JS_MODS/html2canvas.js"></script>
    <script type="text/javascript" src="../JS_MODS/jquery_library.min.js"></script>

    <style>
        #downloads {
            display: none;
        }
        a {
            display: none;
        }
        #loading-page {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
            

<?php
error_reporting(E_ERROR); 
include("../connection/dbconnection.php");
session_start();
require_once '../vendor/autoload.php';
// include("../vendor/phpqrcode/qrlib.php");
require_once 'generate_qr.php';
if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$username = $_SESSION['userdets'][1];
use QRGenerator\QRGenerator;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lotno = $_POST['lotno'];
    $sku = $_POST['skuinward'];
    $query = "SELECT * FROM main WHERE sku = '$sku'";
    $skuresult = mysqli_query($con, $query);
    $query = "SELECT * FROM datadb WHERE lotno = '$lotno' and sku = '$sku'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['dashboarderror'] = "Lotno already exists!!";
        header("Location: superuser.php");
        exit();
    } else if(mysqli_num_rows($skuresult) === 0) {
        $_SESSION['dashboarderror'] = "Incorrect SKU!!";
        header("Location: superuser.php");
        exit();
    } 
    else {
        $norolls = $_POST['qty'];
        $totalmeters = $_POST['totalmetersfield'];
        $date = date('Y-m-d', strtotime($_POST['date']));
        $sku = $_POST['skuinward'];
        $name = $_POST['namevalidationField'];
        $construction = $_POST['construction'];
        $finishedwidth = $_POST['finished_width'];
        $greigewidth = $_POST['greige_width'];
        $dcno = $_POST['dcno'];
        $dyeingunit = $_POST['dyeing_unit'];
        $actualgsm = $_POST['actual_GSM'];
        $ratekg = $_POST['rate_kg'];

        for ($i = 1; $i <= $norolls; $i++) {
            $rollnumber = $_POST['rollnumber' . $i];
            $rollmeters = $_POST['rollmeters' . $i];
            $rolllocation = $_POST['location' . $i];

            $query = "INSERT INTO `datadb` (`date`, `sku`, `name`, `greige_width`, `finished_width`, `dcno`, `lotno`, `construction`, `dyeing_unit`, `actual_gsm`, `rate_kg`, `norolls`, `totalmeters`, `rollno`, `rollmeters`, `location`, `currentmeters`) VALUES ('$date', '$sku', '$name', '$greigewidth', '$finishedwidth', '$dcno', '$lotno', '$construction', '$dyeingunit', '$actualgsm', '$ratekg', '$norolls', '$totalmeters', '$rollnumber', '$rollmeters', '$rolllocation', '$rollmeters')";
            mysqli_query($con, $query);
            $id = mysqli_insert_id($con);
            $logquery = "INSERT INTO logdb (date, username, sku, lotno, norolls, rollno, rollid, inward_meters) VALUES ('$date', '$username', '$sku', '$lotno', '$norolls', '$rollnumber', '$id', '$rollmeters')";
            mysqli_query($con, $logquery);
            
            // ---------------------------------------------------------

           
            $filename = $id . '_' . $sku . '_' . $lotno . '_' . $rollnumber . '.png';
            $text = $sku . '_' . $name;        
            $lines = [
                "SKU: " . $sku,
                "Lot no.: " . $lotno,
                "Roll no.: " . $rollnumber,
            ];
            $filepath = QRGenerator::generateQR($filename, $text, $lines);
            $downloadLinks[] = $filepath;


            
        }
            echo '<div id="downloads"">';
        foreach ($downloadLinks as $link) {
            echo '<a href="' . htmlspecialchars($link) . '" download id="downloadLink' . htmlspecialchars(basename($link)) . '" hidden >Download ' . basename($link) . '</a><br>';
            // $saveto = basename($link);
            // downloadImage($link, $saveto);
        }
        echo '</div>';
        $_SESSION['dashboarderror'] = "Roll added successfully and qr has been generated!!";
        ?>

<div id="loading-page">
        <div class="loader"></div>
        <p>QR's are being generated</p>
    </div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        // Trigger all download links
        var links = document.querySelectorAll('#downloads a');
        for (var i = 0; i < links.length; i++) {
            (function(link) {
                setTimeout(function() { link.click(); }, i * 1000); // Stagger downloads if necessary
            })(links[i]);
        }
<?php
    $content = 'setTimeout(function() {
        $("#loading-page").hide();
        window.location.href = "superuser.php";
    }, '. ($norolls*1010) .');
    ';
    echo $content;
// ?>
    // window.location.href = "superuser.php";
    });
    </script>
</body>
</html>

<?php
        exit();
    }
}
?>