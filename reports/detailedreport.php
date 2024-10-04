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

</style>
<body>
<div class = "heading">  <h1>Warehouse Report as on '. $date .'</h1></div>
<div id="tablediv">
<table border="1">
    <tr><th> SKU </th>
        <th> Name</th>
        <th> TC </th>
        <th> Lot no</th>
        <th> Width</th>
        <th> Construction</th>
        <th> Roll no </th>
        <th> Date </th>
        <th> Inward </th>
        <th> Outward </th>
        <th> Return </th>
        <th> Remarks </th>

    </tr>';
    $query = "SELECT * from logdb order by sku,lotno,rollno,date desc";
    $logs = mysqli_query($con, $query);
    $lot_info = true;
    $lotno_info = "";
    $sku_info = true;
    $skuno_info = "";
    $roll_info = true;
    $rollno_info = "";
    while ($log = mysqli_fetch_array($logs)) {
        $content .= '<tr>';
        if($skuno_info != $log['sku']) {
            $sku_info = true;
        }
        if($sku_info) {
        $query = "SELECT * from main where SKU = '" . $log['sku'] . "'";
        $sku_data = mysqli_query($con, $query);
        $skudata = mysqli_fetch_array($sku_data);
        $query = "SELECT count(*) as count from logdb where sku = '" . $log['sku'] . "'";
        $count_skus = mysqli_fetch_array(mysqli_query($con, $query))['count'];
        $content .= '<td rowspan=' .$count_skus. '>' . $log['sku'] . '</td>
        <td rowspan=' .$count_skus. '>' . $skudata['Name'] . '</td>
        <td rowspan=' .$count_skus. '>' . $skudata['ThreadCount'] . '</td>';
        $skuno_info = $log['sku'];
        $sku_info = false;
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
        $content .= '<td rowspan=' .$count_lots. '>' . $log['lotno'] . '</td>
        <td rowspan=' .$count_lots. '>' . $lotdata['width'] . '</td>
        <td rowspan=' .$count_lots. '>' . $lotdata['construction'] . '</td>';
        $lotno_info = $log['lotno'];
        $lot_info = false;
        }
        if($rollno_info != $log['rollno']) {
            $roll_info = true;
        }
        if($roll_info) {
        $query = "SELECT count(*) as count from logdb where rollno = '" . $log['rollno'] . "' and lotno = '" . $log['lotno'] . "' and sku = '" . $log['sku'] . "'";
        $count_rolls = mysqli_fetch_array(mysqli_query($con, $query))['count'];
        $content .= '<td rowspan=' .$count_rolls. '>' . $log['rollno'] . '</td>';
        $rollno_info = $log['rollno'];
        $roll_info = false;
        }
        $date_log = DateTime::createFromFormat('Y-m-d', $log['date'])->format('d-m-Y');
        $content .= '
        <td>' . $date_log . '</td>
        <td>' . $log['inward_meters'] . '</td>
        <td>' . $log['outward_meters'] . '</td>
        <td>' . $log['return_meters'] . '</td>
        <td>' . $log['remarks'] . '</td></tr>';
    }
    

$content .= '</table>

</div>
</body>
</html>';




$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Madeups warehouse report as on ". $date .".pdf");

header("Location: ../superuser.php");
exit();
?>