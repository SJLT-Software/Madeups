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
thead {
    display: table-header-group;
}
tr.page-break {
    page-break-before: always;
}

</style>
<body>
<div class = "heading">  <h1>Warehouse Stock Report as on '. $date .'</h1></div>
<div id="tablediv">
<table border="1">
    <thead>
    <tr><th> SNo </th>
    <th> SKU </th>
        <th> Name</th>
        <th> TC </th>
        <th> Weave Design </th>
        <th> Finished Width</th>
        <th> Construction</th>
        <th> Dyeing Unit </th>
        <th> Lot no</th>
        <th> Location </th>
        <th> Roll no </th>
        <th> Date </th>
        <th> Inward </th>
        <th> Outward </th>
        <th> Return </th>
        <th> Remarks </th>

    </tr>
    </thead>
    <tbody>';
    $query = "SELECT * from logdb order by sku,lotno,rollno,date desc";
    $logs = mysqli_query($con, $query);
    
    $i = 1;
    while ($log = mysqli_fetch_array($logs)) {
        $content .= '<tr><td>' . $i . '</td>';
        $i++;
        
        
        $query = "SELECT * from main where SKU = '" . $log['sku'] . "'";
        $sku_data = mysqli_query($con, $query);
        $skudata = mysqli_fetch_array($sku_data);

       
        $content .= '<td >' . $log['sku'] . '</td>
        <td >' . $skudata['Name'] . '</td>
        <td >' . $skudata['ThreadCount'] . '</td>
        <td >' . $skudata['WeaveDesign'] . '</td>';
        
        $constructionquery = "SELECT * from main where SKU = '" . $log['sku'] . "'";
        $construction_data = mysqli_query($con, $constructionquery);
        $construction = mysqli_fetch_array($construction_data);
        //Construdction = Warp_count Warp_Composition * Weft_count Weft _Composition\n EPI*PPI \n Ply-Width 
        $finishedFabricConstruction = $construction['Finished_WarpCount'] . " " . $construction['Finished_WarpComposition'] . " * " . $construction['Finished_WeftCount'] . " " . $construction['Finished_WeftComposition'] . "/<br>" . $construction['Finished_EPI'] . "*" . $construction['Finished_PPI'] . "/<br>" . $construction['Finished_Ply'];
        
        
        $query = "SELECT * from datadb where lotno = '" . $log['lotno'] . "'";
        $lot_data = mysqli_query($con, $query);
        $lotdata = mysqli_fetch_array($lot_data);

        
        $dyeingunitQuery = "SELECT dyeing_unit from datadb where lotno = '" . $log['lotno'] . "' and sku = '" . $log['sku'] . "'";
        $dyeingunit_data = mysqli_query($con, $dyeingunitQuery);
        $dyeingunit = mysqli_fetch_array($dyeingunit_data);
        $dyeingunit = $dyeingunit['dyeing_unit'];

        $content .= 
        '<td >' . $lotdata['finished_width'] . '</td>
        <td >' . $finishedFabricConstruction . '</td>
        <td >' . $dyeingunit . '</td>
        <td >' . $log['lotno'] . '</td>';
        
        $locationQuery = "SELECT location from datadb where lotno = '" . $log['lotno'] . "' and rollno = '" . $log['rollno'] . "' and sku = '" . $log['sku'] . "'";
        $location_data = mysqli_query($con, $locationQuery);
        $location = mysqli_fetch_array($location_data);

        $content .= '<td >' . $location['location'] . '</td>
        <td >' . $log['rollno'] . '</td>';
        
        $date_log = DateTime::createFromFormat('Y-m-d', $log['date'])->format('d-m-Y');
        $content .= '
        <td>' . $date_log . '</td>
        <td>' . $log['inward_meters'] . '</td>
        <td>' . $log['outward_meters'] . '</td>
        <td>' . $log['return_meters'] . '</td>
        <td>' . $log['remarks'] . '</td></tr>';
    }
    

$content .= '</tbody></table>

</div>
</body>
<script type="text/javascript" src="../JS_MODS/jquery_library.min.js"></script>
<script type=text/javascript>
$(document).ready(function() {
    function mergeCells(selector) {
        var prevText = "";
        var rowspan = 1;
        var prevCell = null;

        $(selector).each(function() {
            var currentCell = $(this);
            var currentText = currentCell.text();

            if (prevText === currentText) {
                rowspan++;
                currentCell.remove();
                prevCell.attr("rowspan", rowspan);
            } else {
                prevText = currentText;
                prevCell = currentCell;
                rowspan = 1;
            }
        });
    }

    mergeCells("td.sku");
    mergeCells("td.skuname");
    mergeCells("td.tc");
    mergeCells("td.lotno");
    mergeCells("td.rollno");
 
});    
</script>
</html>';




$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Madeups warehouse report as on ". $date .".pdf");
header("Location: ../superuser.php");
exit();
?>