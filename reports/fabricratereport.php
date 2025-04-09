<?php
// Table: SNO,SKU,Name,TC,Fabric Content,Weave Design,Color,Finished Width,Dyeing Unit,Location,Lot no,GSM,Rate/kg,Rate/meter,roll no,meters
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
    <tr><th>SNO</th>
    <th>SKU</th>
    <th>Name</th>
    <th>TC</th>
    <th>Fabric Content</th>
    <th>Weave Design</th>
    <th>Color</th>
    <th>Finished Width</th>
    <th>Dyeing Unit</th>
    <th>Location</th>
    <th>Lot no</th>
    <th>GSM</th>
    <th>Rate/kg</th>
    <th>Rate/meter</th>
    <th>Roll no</th>
    <th>Meters</th>

    </tr>
    </thead>
    <tbody>';
    $query = "SELECT * from datadb order by sku, lotno, rollno";
    $data = mysqli_query($con, $query);
    $i = 1;

    while ($row = mysqli_fetch_array($data)) {
        $content .= '<tr><td>' . $i . '</td>';
        $i++;
        
        $mainquery = "SELECT * from main where SKU = '" . $row['sku'] . "'";
        $main_data = mysqli_query($con, $mainquery);
        $maindata = mysqli_fetch_array($main_data);

        $content .= '<td class="sku">' . $row['sku'] . '</td>
        <td class="skuname">' . $maindata['Name'] . '</td>
        <td class="tc">' . $maindata['ThreadCount'] . '</td>
        <td>' . $maindata['FabricContent'] . '</td>
        <td>' . $maindata['WeaveDesign'] . '</td>
        <td>' . $maindata['Color'] . '</td>
        <td>' . $row['finished_width'] . '</td>
        <td>' . $row['dyeing_unit'] . '</td>
        <td>' . $row['location'] . '</td>
        <td class="lotno">' . $row['lotno'] . '</td>
        <td>' . $row['actual_gsm'] . '</td>
        <td>' . $row['rate_kg'] . '</td>
        <td></td>
        <td class="rollno">' . $row['rollno'] . '</td>
        <td>' . $row['currentmeters'] . '</td></tr>';
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