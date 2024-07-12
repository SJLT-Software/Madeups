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
$date = date("d-m-Y");
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
    width: 100%;

}
tablediv {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
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
<div class = "heading">  <h1>Warehouse Overview as on '. $date .'</h1></div>
<div id="tablediv">
<table>
    <tr><th> SKU </th>
        <th> Name</th>
        <th> TC </th>
        <th> No. of lots</th>
        <th> Total Rolls</th>
        <th> Total Meters</th>
    </tr>';
while ($row = mysqli_fetch_array($rolls)) {
    $query = "SELECT count(*) from datadb where SKU = '" . $row['SKU'] . "' AND status='in'";
    $norolls = mysqli_query($con, $query);
    $query = "SELECT SUM(currentmeters) AS totmeters from datadb where SKU = '" . $row['SKU'] . "' AND status='in' GROUP BY lotno";
    $totalmeters = mysqli_query($con, $query);
    $query = "SELECT count(distinct lotno) from datadb where SKU = '" . $row['SKU'] . "'";
    $nolots = mysqli_query($con, $query);
    $nolots = mysqli_fetch_array($nolots)[0];
    $norolls = mysqli_fetch_array($norolls)[0];
    $grandtotalmeters = 0;
    while ($sum = mysqli_fetch_assoc($totalmeters)) {
        $grandtotalmeters += $sum['totmeters'];
    }
    $totalmeters = $grandtotalmeters;
    $content.= '<tr>
    <td>' . $row['SKU'] . '</td>
    <td>' . $row['Name'] . '</td>
    <td>' . $row['ThreadCount'] . '</td>
    <td>' . $nolots . '</td>
    <td>' . $norolls . '</td>
    <td>' . $totalmeters . '</td>
    </tr>';

}
$content .= '</table>
</div>';

$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("madeups warehouse overview as on ". $date .".pdf");

header("Location: superuser.php");
exit();
?>