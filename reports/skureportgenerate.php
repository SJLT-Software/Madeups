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
$date = date("d-m-Y");
$sku = $_POST['skureportsku'];
$query = "SELECT * from main where SKU = '" . $sku . "'";
$skus = mysqli_query($con, $query);
$skus = mysqli_fetch_array($skus);
$query = "SELECT * from datadb where sku = '" . $sku . "' order by lotno,rollno";
$rolls = mysqli_query($con, $query);
$content = "";
$query = "SELECT SUM(currentmeters) as totalmeters from datadb where sku = '" . $sku . "'";
$totalmeters = mysqli_fetch_array(mysqli_query($con, $query))['totalmeters'];
$_SESSION['skureport'] = [];
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
#addheight{
    height: 20px;
}
</style>
<body>
<div class = "heading"><h1>SKU Overview as on '. $date .'</h1></div>
<div class = "heading"><h2>SKU Details</h2></div>
<div id="tablediv">
<table>
    <tr>
        <th> SKU</th><td>' . $skus['SKU'] . '</td>
        <th> Name</th><td>' . $skus['Name'] . '</td>
        <th> Thread Count</th><td>' . $skus['ThreadCount'] . '</td>
        <th> Total Meters </th><td>' .$totalmeters. '</td>
    </tr>
</table>
</div>
<div id="addheight"></div>
<div id="tablediv">
<table>
    <tr>
        <th> Lot no</th>
        <th> Width</th>
        <th> Construction</th>
        <th> Roll no </th>        
        <th> Roll meters </th>
        <th> Status </th>

    </tr>';
while ($roll = mysqli_fetch_array($rolls)) {
    $_SESSION['skureport'][] = $roll;
    $content .= '<tr>
    <td>' . $roll['lotno'] . '</td>
    <td>' . $roll['width'] . '</td>
    <td>' . $roll['construction'] . '</td>
    <td>' . $roll['rollno'] . '</td>
    <td>' . $roll['currentmeters'] . '</td>
    <td>' . $roll['status'] . '</td>
    </tr>';

    }
    


$content .= '</table>
</div>
</body>
</html>
';

$_SESSION['skureport_pdfgenerate_content'] = $content;
$_SESSION['skureport_pdfgenerate_date'] = $date;
$_SESSION['skureport_pdfgenerate'] = true;
header("Location: ../superuser.php");
exit();
?>