<?php
error_reporting(0);
session_start();

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
require_once('../vendor/autoload.php');
$date = date("d-m-Y");
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$query = "SELECT * FROM main ORDER BY 
          LEFT(SKU, LENGTH(SKU) - LENGTH(REGEXP_REPLACE(SKU, '[0-9]', ''))), 
          CAST(REGEXP_REPLACE(SKU, '[^0-9]', '') AS UNSIGNED)";
$rolls = mysqli_query($con, $query);
$content = "";
$content .= '<html>
<style>
@page{
    margin: 5;
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
    font-size: 12px;
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
    padding: 6px;
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
thead {
    display: table-header-group;
}
</style>
<body>
<div class = "heading">  <h1>SKU Detailed List Report as on '. $date .'</h1></div>
<div id="tablediv">
<table>
    <thead>
    <tr>
        <th>SNo</th>
        <th> SKU </th>
        <th> Name</th>
        <th> TC </th>
        <th> Fabric Content </th>
        <th> Weave Design </th>
        <th> Finished Fabric Construction </th>
        <th> Greige Fabric Construction </th>
        <th> GSM </th>
        <th> Color </th>
    </tr>
    </thead>';
    while ($row = mysqli_fetch_array($rolls)) {
        //Warp_count Warp_Composition * Weft_count Weft _Composition\n EPI*PPI \n Ply-Width 
        $finishedFabricConstruction = $row['Finished_WarpCount'] . " " . $row['Finished_WarpComposition'] . " * " . $row['Finished_WeftCount'] . " " . $row['Finished_WeftComposition'] . "/" . $row['Finished_EPI'] . "*" . $row['Finished_PPI'] . "/" . $row['Finished_Ply'] . "-" . $row['Finished_Width'];
        $greigeFabricConstruction = $row['Greige_WarpCount'] . " " . $row['Greige_WarpComposition'] . " * " . $row['Greige_WeftCount'] . " " . $row['Greige_WeftComposition'] . "/" . $row['Greige_EPI'] . "*" . $row['Greige_PPI'] . "/" . $row['Greige_Ply'] . "-" . $row['Greige_Width'];
        static $i = 1;
        $content.= '<tr>
        <td>'. $i++ .'</td>
        <td>' . $row['SKU'] . '</td>
        <td>' . $row['Name'] . '</td>
        <td>' . $row['ThreadCount'] . '</td>
        <td>' . $row['FabricContent'] . '</td>
        <td>' . $row['WeaveDesign'] . '</td>
        <td>' .$finishedFabricConstruction . '</td>
        <td>' .$greigeFabricConstruction .'</td>
        <td>' . $row['GSM'] . '</td>
        <td>' . $row['Color'] . '</td>
        </tr>';
    
    }
    
    $content .= '</table></div></body></html>';
    $dompdf->loadHtml($content);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream("Madeups SKU detailed list report as on ". $date .".pdf");
    
    header("Location: ../superuser.php");
    exit();  
?>