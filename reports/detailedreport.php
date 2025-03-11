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
td.mergetd {
    border-bottom: 0;
    border-top: 0;
}
td.notop {
    border-bottom: 0;
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
    $rows_per_page = 25;
    $lot_info = true;
    $lotno_info = "";
    $count_lots = 0;
    $sku_info = true;
    $skuno_info = "";
    $count_skus = 0;
    $roll_info = true;
    $rollno_info = "";
    $count_rolls = 0;
    $i = 1;
    while ($log = mysqli_fetch_array($logs)) {
        $content .= '<tr><td>' . $i . '</td>';
        $i++;
        if($skuno_info != $log['sku']) {
            $sku_info = true;
        }
        if($sku_info) {
        $query = "SELECT * from main where SKU = '" . $log['sku'] . "'";
        $sku_data = mysqli_query($con, $query);
        $skudata = mysqli_fetch_array($sku_data);
        $query = "SELECT count(*) as count from logdb where sku = '" . $log['sku'] . "'";
        $count_skus = mysqli_fetch_array(mysqli_query($con, $query))['count'];
        $content .= '<td class="notop">' . $log['sku'] . '</td>
        <td class="notop">' . $skudata['Name'] . '</td>
        <td class="notop">' . $skudata['ThreadCount'] . '</td>
        <td class="notop">' . $skudata['WeaveDesign'] . '</td>';
        $skuno_info = $log['sku'];
        $sku_info = false;
        }
        else {
            $content .= '<td class="mergetd"></td>
        <td class="mergetd"></td>
                <td class="mergetd"></td>

        <td class="mergetd"></td>';
            
        }
        if($lotno_info != $log['lotno']) {
            $lot_info = true;
        }
        if($lot_info) {
        $query = "SELECT * from datadb where lotno = '" . $log['lotno'] . "'";
        $lot_data = mysqli_query($con, $query);
        $lotdata = mysqli_fetch_array($lot_data);
        $query = "SELECT count(*) as count from logdb where lotno = '" . $log['lotno'] . "' and sku = '" . $log['sku'] . "'";
        $count_lots = mysqli_fetch_array(mysqli_query($con, $query))['count'];
        $content .= 
        '<td class="notop">' . $lotdata['finished_width'] . '</td>
        <td class="notop">' . $lotdata['construction'] . '</td>
        <td class="notop">' . $lotdata['dyeing_unit'] . '</td>
        <td class="notop">' . $log['lotno'] . '</td>';
        $lotno_info = $log['lotno'];
        $lot_info = false;
        }
        else {
            $content .= '<td class="mergetd"></td>
        <td class="mergetd"></td>
                <td class="mergetd"></td>
        <td class="mergetd"></td>';
        }

        if($rollno_info != $log['rollno']) {
            $roll_info = true;
        }
        if($roll_info) {
        $query = "SELECT count(*) as count from logdb where rollno = '" . $log['rollno'] . "' and lotno = '" . $log['lotno'] . "' and sku = '" . $log['sku'] . "'";
        $count_rolls = mysqli_fetch_array(mysqli_query($con, $query))['count'];
        $content .= '<td class="notop">' . $log['location'] . '</td>
        <td class="notop">' . $log['rollno'] . '</td>';
        $rollno_info = $log['rollno'];
        $roll_info = false;
        }
        else {
            $content .= '<td class="mergetd"></td>
                    <td class="mergetd"></td>';
        }
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