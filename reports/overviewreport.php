<?php
session_start();
error_reporting(0);
if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: ../index.php");
    exit();
}

if (isset($_SESSION['reporterror'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['dashboarderror'], ENT_QUOTES, 'UTF-8') . "');</script>";
    unset($_SESSION['reporterror']);
}
include("../connection/dbconnection.php");
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$date = date("d-m-Y");
$query = "SELECT * FROM main ORDER BY 
          LEFT(SKU, LENGTH(SKU) - LENGTH(REGEXP_REPLACE(SKU, '[0-9]', ''))), 
          CAST(REGEXP_REPLACE(SKU, '[^0-9]', '') AS UNSIGNED)";
$rolls = mysqli_query($con, $query);
$content = "";
$content .= '<html>
<style>
@page{
    margin: 15;
    size: A4 landscape;
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
    border-spacing: 0;

}
#tablediv {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}
td, th {
    border: 1px solid #444;
    font-size: 85%;
    padding: 8px;
    text-align: center;
    vertical-align: middle;
    word-wrap: nowrap;
}
.bshift {page-break-before: always;}

.heading{
font-size: 12px;
text-align: center;
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
<body>
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
    $query = "SELECT count(*) from datadb where SKU = '" . $row['SKU'] . "'";
    $norolls = mysqli_query($con, $query);
    $query = "SELECT totalmeters from datadb where SKU = '" . $row['SKU'] . "' GROUP BY lotno";
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
    <td>' . $row['ThreadCount'] . '</td>
    <td>' . $nolots . '</td>
    <td>' . $norolls . '</td>
    <td>' . $totalmeters . '</td>
    </tr>';

}

$content .= '</table></div></body></html>';

$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Madeups warehouse overview as on ". $date .".pdf");

header("Location: ../superuser.php");
exit();
?>