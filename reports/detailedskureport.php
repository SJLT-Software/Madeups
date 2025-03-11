<?php
// error_reporting(0);
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

</style>
<body>
<div class = "heading">  <h1>Warehouse Overview as on '. $date .'</h1></div>
<div id="tablediv">
<table>
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
        <th> Finished Width </th>
        <th> Greige Width </th>
    </tr>';
    while ($row = mysqli_fetch_array($rolls)) {
        $finishedFabricConstruction = 0; //Warp_count*Weft_count \n EPI*PPI \n Warp_Composition Weft _Composition 
        $greigeFabricConstruction = 0;
        $content.= '<tr>
        <td><?php static $i = 1; echo $i++; ?></td>
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
    $dompdf->stream("Madeups SKU list as on ". $date .".pdf");
    
    header("Location: ../superuser.php");
    exit();  
?>