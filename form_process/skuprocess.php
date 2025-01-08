<?php
session_start();
include("../connection/dbconnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sku = $_POST['sku'];

    $query = "SELECT * FROM main WHERE sku = '$sku'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['dashboarderror'] = "SKU already exists";
        header("Location: superuser.php");
        exit();
    } else {
        $name = $_POST['Name'];
        $tc = $_POST['tc'];
        $fabricContent = $_POST['FabricContent'];
        $weaveDesign = $_POST['WeaveDesign'];
        $finishedWarpCount = $_POST['Finished_WarpCount'];
        $finishedWarpComposition = $_POST['Finished_WarpComposition'];
        $finishedWeftCount = $_POST['Finished_WeftCount'];
        $finishedWeftComposition = $_POST['Finished_WeftComposition'];
        $finishedEPI = $_POST['Finished_EPI'];
        $finishedPPI = $_POST['Finished_PPI'];
        $finishedPly = $_POST['Finished_Ply'];
        $greigeWarpCount = $_POST['Greige_WarpCount'];
        $greigeWarpComposition = $_POST['Greige_WarpComposition'];
        $greigeWeftCount = $_POST['Greige_WeftCount'];
        $greigeWeftComposition = $_POST['Greige_WeftComposition'];
        $greigeEPI = $_POST['Greige_EPI'];
        $greigePPI = $_POST['Greige_PPI'];
        $greigePly = $_POST['Greige_Ply'];
        $gsm = $_POST['GSM'];
        $color = $_POST['Color'];
        $finishedWidth = $_POST['Finished_Width'];
        $greigeWidth = $_POST['Greige_Width'];

        $insertQuery = "INSERT INTO main (sku, name, threadcount, fabriccontent, weavedesign, finished_warpcount, finished_warpcomposition, finished_weftcount, finished_weftcomposition, finished_epi, finished_ppi, finished_ply, greige_warpcount, greige_warpcomposition, greige_weftcount, greige_weftcomposition, greige_epi, greige_ppi, greige_ply, gsm, color, finished_width, greige_width) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($stmt, 'sssssssssssssssssssssss', $sku, $name, $tc, $fabricContent, $weaveDesign, $finishedWarpCount, $finishedWarpComposition, $finishedWeftCount, $finishedWeftComposition, $finishedEPI, $finishedPPI, $finishedPly, $greigeWarpCount, $greigeWarpComposition, $greigeWeftCount, $greigeWeftComposition, $greigeEPI, $greigePPI, $greigePly, $gsm, $color, $finishedWidth, $greigeWidth);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['dashboarderror'] = "SKU added successfully!!";
        header("Location: superuser.php");
        exit();
    }
}
?>