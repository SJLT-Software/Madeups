<?php
session_start();
error_reporting(0);
require_once('../vendor/autoload.php');
use Dompdf\Dompdf;
$dompdf = new Dompdf();
if (isset($_SESSION['skureport_pdfgenerate'])) {
    $content = $_SESSION['skureport_pdfgenerate_content'];
    $date = $_SESSION['skureport_pdfgenerate_date'];
    $dompdf->loadHtml($content);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream("SKU overview as on " . $date . ".pdf");
    unset($_SESSION['skureport_pdfgenerate']);
    unset($_SESSION['skureport_pdfgenerate_content']);
    unset($_SESSION['skureport_pdfgenerate_date']);
    unset($_SESSION['skureport']);
}
header("Location: ../superuser.php");
exit();
?>