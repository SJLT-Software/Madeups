<!DOCTYPE html>
<html lang="en" style="width: 75mm; height: 50mm; overflow: hidden;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inward Process</title>
    <script type="text/javascript" src="JS_MODS/html2canvas.js"></script>
    <script type="text/javascript" src="JS_MODS/jquery_library.min.js"></script>

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
include("vendor/phpqrcode/qrlib.php");
if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$username = $_SESSION['userdets'][1];
// function downloadImage($url,$saveto) {
//     $ch = curl_init($url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//     $imageData = curl_exec($ch);
//     curl_close($ch);
//     file_put_contents($saveto, $imageData);
// }
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
        $width = $_POST['width'];
        for ($i = 1; $i <= $norolls; $i++) {
            $rollnumber = $_POST['rollnumber' . $i];
            $rollmeters = $_POST['rollmeters' . $i];

            $insertQuery = "INSERT INTO datadb (date, sku, name, width, lotno, construction, norolls, totalmeters, rollno, rollmeters, currentmeters) VALUES ('$date', '$sku', '$name', '$width', '$lotno', '$construction', '$norolls', '$totalmeters', '$rollnumber', '$rollmeters', '$rollmeters')";
            mysqli_query($con, $insertQuery);
            $id = mysqli_insert_id($con);
            $logquery = "INSERT INTO logdb (date, username, sku, lotno, norolls, rollno, rollid, inward_meters) VALUES ('$date', '$username', '$sku', '$lotno', '$norolls', '$rollnumber', '$id', '$rollmeters')";
            mysqli_query($con, $logquery);
            
            // ---------------------------------------------------------

            define('WIDTH_PIXELS', 280);
            define('HEIGHT_PIXELS', 150);

            $finalImage = imagecreatetruecolor(WIDTH_PIXELS, HEIGHT_PIXELS);
            $white = imagecolorallocate($finalImage, 255, 255, 255);
            imagefill($finalImage, 0, 0, $white);

            $filename = $id . '_' . $sku . '_' . $lotno . '_' . $rollnumber . '.png';
            $qrSize = min(WIDTH_PIXELS, HEIGHT_PIXELS) / 2; // Example size, adjust as needed
            $qrCode = 'tempdump/' . $filename;
            QRcode::png($id . '_' . $sku . '_' . $name .  '_' . $lotno . '_' . $rollnumber, $qrCode, QR_ECLEVEL_L, $qrSize / 25);

            $qrImage = imagecreatefrompng($qrCode);
            $padding = 20; // 20 pixels padding
            $qrX = $padding; // Left padding
            $qrY = (HEIGHT_PIXELS - imagesy($qrImage)) - $padding; // Positioning it a bit higher to leave space for text

            imagecopy($finalImage, $qrImage, $qrX, $qrY, 0, 0, imagesx($qrImage), imagesy($qrImage));
            $fontSize = 10; // Adjust font size as needed
            $fontPath = 'fonts/Roboto-Bold.ttf';
            $fontColor = imagecolorallocate($finalImage, 0, 0, 0);
            $text = $sku . '_' . $name;
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
            $textWidth = $bbox[2] - $bbox[0];
            $textX = 25;
            $textY = $qrY + imagesy($qrImage) + 10; // Adjust Y position based on QR code height and desired padding
            imagettftext($finalImage, $fontSize, 0, $textX, $textY, $fontColor, $fontPath, $text);
    $rightPadding = 10; // Padding from the right edge of the QR code
    $textXRight = imagesx($qrImage) + $qrX + $rightPadding;

    $lineHeight = 25; // Height of each line of text
    $textYStart = $qrY + 25; // Start at the same Y position as the QR code

    $lines = [
        "SKU: " . $sku,
        "Lot no.: " . $lotno,
        "Roll no.: " . $rollnumber,
    ];
    $fontSize = 11;
    foreach ($lines as $index => $line) {
        $textY = $textYStart + ($lineHeight * $index);
        imagettftext($finalImage, $fontSize, 0, $textXRight, $textY, $fontColor, $fontPath, $line);
    }
            $filepath = 'tempdump/' . $filename;
            imagepng($finalImage, $filepath);
            imagedestroy($finalImage);
            imagedestroy($qrImage);
                        // ---------------------------------------------------------



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