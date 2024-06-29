<?php
session_start();
if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['reporterror'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['dashboarderror'], ENT_QUOTES, 'UTF-8') . "');</script>";
    unset($_SESSION['reporterror']);
}
include("connection/dbconnection.php");
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$query = "SELECT * from main";
$rolls = mysqli_query($con, $query);
$content = "";
$content .= '<html>
<style>
@page{
    margin: 15;
}
.row{
    margin-left: 5px;
    width: 100%;
}
.column{
    float:left;
    width: 50%;
}
.row::after{
    content: "";
    clear: both;
    display: table;
}

table{
    border-collapse: collapse;
}
td{
    border:1px solid #444;
    font-size: 85%;
    width: auto;
    overflow: hidden;
    word-wrap: break-word;
    text-align: left;
    line-height: 95%;
}
th{
    border:1px solid #444;
    font-size: 85%;
    word-wrap: break-word;
    margin: 0px;
}
.bshift {page-break-before: always;}

.heading{
font-size: 12px;
text-align: centre;
font-weight: bold;
margin-top: 10px;
margin-bottom: 10px;
}
h1{
    text-align: center;
    font-weight: bold;
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
<div class = "row">
<div class = "column">
<div class = "heading">  <h1>Warehouse Overview</h1></div>
<table>
    <tr><th> SKU </th>
        <th> Name</th>
        <th> Construction </th>
        <th> TC </th>
        <th> No. of lots</th>
        <th> Total Rolls</th>
        <th> Total Meters</th>
    </tr>';
while ($row = mysqli_fetch_array($rolls)) {
    $query = "SELECT count(*) from datadb where SKU = '" . $row['SKU'] . "'";
    $norolls = mysqli_query($con, $query);
    $query = "SELECT totalmeters from datadb where SKU = '" . $row['SKU'] . "' and GROUP BY lotno";
    $totalmeters = mysqli_query($con, $query);
    $query = "SELECT count(distinct lotno) from datadb where SKU = '" . $row['SKU'] . "'";
    $nolots = mysqli_query($con, $query);
    $nolots = mysqli_fetch_array($nolots)[0];
    $norolls = mysqli_fetch_array($norolls)[0];
    $grandtotalmeters = 0;
    while ($sum = mysqli_fetch_assoc($totalmeters)) {
        $grandtotalmeters += $sum['totalmeters'];
    }
    $totalmeters = $grandtotalmeters;
    $content.= '<tr>
    <td>' . $row['SKU'] . '</td>
    <td>' . $row['Name'] . '</td>
    <td>' . $row['Construction'] . '</td>
    <td>' . $row['ThreadCount'] . '</td>
    <td>' . $nolots . '</td>
    <td>' . $norolls . '</td>
    <td>' . $totalmeters . '</td>
    </tr>';

}


$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("madeups_rollinfo.pdf");

header("Location: superuser.php");
exit();
?>