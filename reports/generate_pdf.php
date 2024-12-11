<?php
session_start();
include("../connection/dbconnection.php");
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$date = date("d-m-Y");

// Generate HTML content
$content = $_POST['content'];
$filename = $_POST['filename'];

$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$pdfOutput = $dompdf->output();
file_put_contents($filename, $pdfOutput);
?>

<!-- download_pdf.php -->
<?php
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="'. $filename .'"');
readfile($filename);
?>
