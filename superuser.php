<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="JS_MODS/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="JS_MODS/jquery-ui/jquery-ui.min.css" />
    <link rel="stylesheet" href="css/style2.css" />
    <link rel="stylesheet" href="css/orderdetailstyle.css" />
    <script type="text/javascript" src="JS_MODS/jquery_library.min.js"></script>
    <script type="text/javascript" src="JS_MODS/jquery.dataTables.min.js"></script>
    <!-- <script type="text/javascript" src="JS_MODS/jquery-ui/external/jquery/jquery.js"></script> -->
    <script type="text/javascript" src="JS_MODS/jquery-ui/jquery-ui.min.js"></script>

    <title>Dashboard</title>
</head>
<?php
session_start();
error_reporting(0); // Suppress errors and warnings
include("connection/dbconnection.php");

if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
if (isset($_SESSION['return_qr'])) {
    unset($_SESSION['return_qr']);
}
if (isset($_SESSION['out_qr'])) {
    unset($_SESSION['out_qr']);
}
$logquery = "DELETE FROM logdb WHERE rollid = 0 AND norolls = 0";
mysqli_query($con, $logquery);
$logquery2 = "DELETE FROM logdb WHERE inward_meters = 0 AND outward_meters = 0 AND return_meters = 0";
mysqli_query($con, $logquery2);
$skus = "SELECT * FROM main";
$skus_list = mysqli_query($con, $skus);
$acc = "SELECT * FROM creds";
$acc_list = mysqli_query($con, $acc);
$query = "SELECT * FROM datadb";
$result = mysqli_query($con, $query);
$rolls = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rolls[] = $row;
}
?>
<?php
if(isset($_SESSION['skureport'])) {
    echo '<body onload="skureportfunc()">';
}
else {
    echo '<body onload="startup()">';
}
?>
<?php
    // echo '<script>';
    // echo 'console.log(' . json_encode($_SESSION) . ');';
    // echo '</script>';
    require('superuser_components/backgroundmenu.php');
?>
    <div id="maindiv">
<?php
    require_once('superuser_components/skuform.php');
    require_once('superuser_components/skuview.php');
    require_once('superuser_components/inwardform.php');
    require_once('superuser_components/outwardform.php');
    require_once('superuser_components/returnform.php');
    require_once('superuser_components/accview.php');
    require_once('superuser_components/skureportview.php');
    require_once('superuser_components/orderdetailform_checklistitems.php');
    require_once('superuser_components/orderdetailform_productdetails.php');
?>
    
</div>
    
</body>
<script>
    $('form').on('submit', function(event) {
        event.preventDefault();
        if ($(this).find('.salesorderno').length) {
            var salesOrderNo = $('.salesorderno').val().trim();
            if (salesOrderNo.startsWith('S')) {
            salesOrderNo = salesOrderNo.substring(1).trim();
            }
            $('.salesorderno').val(parseInt(salesOrderNo, 10));
        }
        var form = $(this);
        var action = form.attr('action');
        form.attr('action', 'form_process/' + action);
        form.off('submit').submit();
    });
    $(document).ready(function() {
            $('.skuField').attr({
                'title': "SKU must start with 'KJB' or 'H' or 'B' or 'SA'.",
                'pattern': "^(KJB|H|SA|B)[0-9]+$",
                'onchange': "this.reportValidity();",
                'oninput': "this.value = this.value.toUpperCase()",
                'type': "text",
                'required': "required",
                'placeholder': "SKU"

            });
            $('.salesorderexists').dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    Ok: function() {
                        $(this).dialog('close');
                    }
                }
            });
            $('.salesorderexists').attr({
                'hidden': false
            });
            $('.salesorderno').attr({
                'title': "Sales Order No. must start with 'S'.",
                'pattern': "^(S)[1-9][0-9]*$",
                'onchange': "this.reportValidity();",
                'oninput': "this.value = this.value.toUpperCase()",
                'type': "text",
                'required': "required",
                'placeholder': "Sales Order No."
                }).on('change', function() {
                    // Check if sales order no exists and update hidden field
                    //Hidden field updates primary field:
                    // Product details: Give a tick mark to show sales order no exists
                    // Checklist items: Give an error to say sales order no already exists
                    if (this.reportValidity()) {
                        var salesorderno = $(this).val();
                        // console.log(salesorderno);
                        salesorderno = salesorderno.substring(1).trim();
                        salesorderno = parseInt(salesorderno, 10)
                        // console.log(salesorderno);
                        $.get('fetchsalesorderno.php', {
                            salesorderno: salesorderno
                        }, function(data) {
                            // $('.salesorderexists').val(data.exists);
                            // console.log(data);
                            // console.log(data.exists);
                            if (data.exists) {
                                $('#sales_order_no_exists').dialog('option', 'title', 'Error').dialog('option','content','Sales Order No. already exists.').dialog('open');
                                $('#form_orderdetail_checklistitems input[type="submit"]').prop('disabled', true);
                            } else {
                                $('#sales_order_no_exists').dialog('close');
                                $('#form_orderdetail_checklistitems input[type="submit"]').prop('disabled', false);
                            }
                            // Any other data to be filled
                        });
                    }
                    
                });

            
    });
    function startup() {
        $("#skuform").hide();
        $("#skuview").hide();
        $("#inwardform").hide();
        $("#outwardform").hide();
        $("#returnform").hide();
        $("#accview").hide();
        $("#skuReportview").hide();
        $("#orderdetail_checklistitemsform").hide();
        $("#orderdetail_productdetailsform").hide();
        resetforms();
    }
    function addsku() {
        startup();
        $("#skuform").show();
    }
    function viewsku() {
        startup();
        $("#skuview").show();
    }
    function addinward() {
        startup();
        $("#inwardform").show();
        }

    function addoutward() {
        startup()
        $("#outwardform").show();
        
    }
    function addreturn() {
        startup();
        $("#returnform").show();
        }

    function viewacc() {
        startup();
        $("#accview").show();
        }
    function skureportfunc() {
        startup();
        $("#skuReportview").show();
        }
    function orderdetail_checklistitemsfunc() {
        startup();
        $("#orderdetail_checklistitemsform").show();
    }
    function orderdetail_productdetailsfunc() {
        startup();
        $("#orderdetail_productdetailsform").show();
    }
    function resetforms() {
        document.getElementById("form_sku").reset();
        document.getElementById("form_inward").reset();
        document.getElementById("form_outward").reset();
        document.getElementById("form_return").reset();
        document.getElementById("form_sku_report").reset();
        document.getElementById("form_orderdetail_checklistitems").reset();
        document.getElementById("form_orderdetail_productdetails").reset();

    } 
</script>
<?php
if (isset($_SESSION['dashboarderror'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['dashboarderror'], ENT_QUOTES, 'UTF-8') . "');</script>";
    unset($_SESSION['dashboarderror']);
}
if ($_SESSION['userdets'][1] != "Manav") {
    echo "<script>document.getElementById('accview').remove();</script>";
    echo "<script>document.getElementById('accviewbtn').remove();</script>";
}
?>
</html>