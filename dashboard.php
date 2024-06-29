<?php
session_start();
if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
else {
    if ($_SESSION['userdets'][1] === "Manav") {
        header("Location: superuser.php");
        exit();
    }
}

if (isset($_SESSION['dashboarderror'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['dashboarderror'], ENT_QUOTES, 'UTF-8') . "');</script>";
    unset($_SESSION['dashboarderror']);
}
include("connection/dbconnection.php");
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="JS_MODS/jquery.dataTables.min.css">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="JS_MODS/jquery_library.min.js"></script>
    <script type="text/javascript" src="JS_MODS/jquery.dataTables.min.js"></script>
    <title>Dashboard</title>
</head>

<body onload="startup()">
    <a href="overviewreport.php">Generate Overview</a>
    <a href="overviewreport.php">Generate Detailed Report</a>
    <a href="logout.php">Logout</a>
    <div id="btns">
        <button onclick="addinward()">Inward Form</button>
        <button onclick="addoutward()">Outward Form</button>
        <button onclick="addreturn()">Return Form</button>
    </div>
    
    <div id="inwardform" hidden>
        <h1>Inward Form</h1>
        <form id="form_inward" action="inwardprocess.php" method="post">

            <label for="date">Date:</label>
            <input type="date" name="date" id="date" class="form-field">

            <label for="skuinward">SKU:</label>
            <input id="skuinward" name="skuinward" type="text" class="form-field" required pattern="^(KJB|H)[0-9]+$"
                title="SKU must start with 'KJB' or 'H'." onchange="this.reportValidity();"
                oninput="this.value = this.value.toUpperCase()" placeholder="SKU">

            <label for="nameinward">Name:</label>
            <input type="text" name="nameinward" id="nameinward" class="form-field" placeholder="Name" disabled>
            <input type="hidden" id="namevalidationField" name="namevalidationField"
                pattern="^(?!.*SKU not found).*$" required>

            <label for="lotno">Lot Number:</label>
            <input type="text" name="lotno" placeholder="Lot Number" id="lotno" class="form-field" required>

            <label for="qty">No. of rolls:</label>
            <input type="number" placeholder="No. of rolls" name="qty" id="qty" class="form-field" min=0 max=10
                placeholder="Enter no. of Rolls" required>

            <div id="fieldsContainer">

            </div>
            <label for="totalmeters">Total Meters:</label>
            <input type="number" name="totalmeters" placeholder="Total meters" id="totalmeters" disabled min="0"
                step="0.0001" class="form-field">
            <input type="hidden" id="totalmetersfield" name="totalmetersfield" required>

            <input type="submit" value="Submit">

        </form>
        <script>
            $(document).ready(function() {
                $('#qty').change(function() {
                    var qty = $('#qty').val();
                    var container = $('#fieldsContainer');
                    container.empty(); // Clear previous fields

                    for (var i = 1; i <= qty; i++) {
                        var div = $('<div id="inwardpair"></div>');
                        var labelRollNumber = $('<label for="rollnumber' + i + '" class="form-label">Roll Number:</label>');
                        var inputRollNumber = $('<input id="rollnumber' + i + '" name="rollnumber' + i + '" type="text" class="form-field" placeholder="Roll Number" required>');
                        var labelRollMeters = $('<label for="rollmeters' + i + '" class="form-label2">Roll Meters:</label>');
                        var inputRollMeters = $('<input id="rollmeters' + i + '" name="rollmeters' + i + '" type="number" class="form-field roll-meters" min="0" step="0.0001" placeholder="Roll Meters" required>');

                        div.append(labelRollNumber, inputRollNumber, labelRollMeters, inputRollMeters);
                        container.append(div);
                    }
                    $('.roll-meters').on('change', function() {
                        var totalMeters = 0;
                        $('.roll-meters').each(function() {
                            var meters = parseFloat($(this).val()) || 0;
                            totalMeters += meters;
                        });
                        $('#totalmeters').val(totalMeters); // Update the total meters field
                        $('#totalmetersfield').val(totalMeters);
                    });
                });
                $('#skuinward').on('change', function() {
                    var skuNumber = $(this).val();

                    $.get('fetchName.php', {
                        sku: skuNumber
                    }, function(data) {
                        $('#nameinward').val(data);
                        $('#namevalidationField').val(data);
                    });
                });
                $('#form_inward').submit(function(e) {
                    var nameValidationValue = $('#namevalidationField').val();
                    var pattern = /^(?!.*SKU not found).*$/;

                    if (!pattern.test(nameValidationValue)) {
                        e.preventDefault();
                        alert('Invalid SKU!!');
                    }
                });
            });
        </script>
    </div>
    <div id="outwardform" class="container" hidden>
        <h1>Outward Form</h1>
        <form id="form_outward" action="outwardprocess.php" method="post">

            <label for="date">Date:</label>
            <input type="date" name="dateoutward" id="dateoutward" class="form-field">

            <label for="skuoutward">SKU:</label>
            <input id="skuoutward" name="skuoutward" type="text" class="form-field" required pattern="^(KJB|H)[0-9]+$"
                title="SKU must start with 'KJB' or 'H'." onchange="this.reportValidity();"
                oninput="this.value = this.value.toUpperCase()" placeholder="SKU">

            <label for="nameoutward">Name:</label>
            <input type="text" name="nameoutward" id="nameoutward" class="form-field" placeholder="Name" disabled>
            <input type="hidden" id="outwardvalidationField" name="outwardvalidationField"
                pattern="^(?!.*SKU not found).*$" required>

            <label for="lotnooutward">Lot Number:</label>
            <input type="text" name="lotnooutward" placeholder="Lot Number" id="lotnooutward" class="form-field"
                required>

            <select name="rollinfo" id="rollinfo" class="form-field-department" onselect="pickroll()" required>
                <option value="-" selected disabled>Choose roll</option>
            </select>
            <div id="pickedrolls">
            </div>
            <input type="hidden" name="rollschoosen" id="rollschoosen" value="0" min="0" step="1" required>

            <label for="totalmetersout">Total Meters Selected:</label>
            <input type="number" name="totalmetersout" placeholder="Total meters" id="totalmetersout" disabled min="0"
                value="0" class="form-field">

            <input type="submit" value="Submit">

        </form>
        <script>
            $(document).ready(function() {

                $('#skuoutward').on('change', function() {
                    var skuNumber = $(this).val();

                    $.get('fetchName.php', {
                        sku: skuNumber
                    }, function(data) {
                        $('#nameoutward').val(data);
                        $('#outwardvalidationField').val(data);
                    });
                });
                $('#form_outward').submit(function(e) {
                    var nameValidationValue = $('#outwardvalidationField').val();
                    var pattern = /^(?!.*SKU not found).*$/;

                    if (!pattern.test(nameValidationValue)) {
                        e.preventDefault();
                        alert('Invalid SKU!!');
                    }
                });

                // ------------------------------------

                $('#lotnooutward, #skuoutward').on('change', function() {
                    var lotNumber = $('#lotnooutward').val();
                    var skuNumber = $('#skuoutward').val();
                    
                    if (lotNumber && skuNumber) {
                        $.get('fetchRollInfo.php', {
                            lotno: lotNumber,
                            sku: skuNumber
                        }, function(data) {
                            var rolls = JSON.parse(data); // Assuming the data is returned in JSON format
                            var $rollInfoSelect = $('#rollinfo');
                            $rollInfoSelect.empty();
                            $rollInfoSelect.append($('<option>', {
                                value: '-',
                                text: 'Choose roll',
                                disabled: true,
                                selected: true
                            }));
                            $.each(rolls, function(index, roll) {
                                $rollInfoSelect.append($('<option>', {
                                    value: roll.id,
                                    text: roll.rollno + ' - ' + roll.currentmeters + ' meters'
                                }));
                            });
                        });
                    
                    }
                });
            //         var lotNumber = $(this).val();
            //         var skuNumber = $('#skuoutward').val();
            //         $.get('fetchRollInfo.php', {
            //             lotno: lotNumber,
            //             sku: skuNumber
            //         }, function(data) {
            //             var rolls = JSON.parse(data); // Assuming the data is returned in JSON format
            //             var $rollInfoSelect = $('#rollinfo');
            //             $rollInfoSelect.empty();
            //             $rollInfoSelect.append($('<option>', {
            //                 value: '-',
            //                 text: 'Choose roll',
            //                 disabled: true,
            //                 selected: true
            //             }));
            //             // Populate the select with new options
            //             $.each(rolls, function(index, roll) {
            //                 $rollInfoSelect.append($('<option>', {
            //                     value: roll.id,
            //                     text: roll.rollno + ' - ' + roll.currentmeters + ' meters'
            //                 }));
            //             });
            //         });
            //     });
            // });
            $('#rollinfo').on('change', function() {
                var roll = $(this).val();
                var container = $('#pickedrolls');
                var rollschoosen = $('#rollschoosen').val();
                var hiddenField = $('<input>').attr({
                    type: 'hidden',
                    name: 'selectedroll' + rollschoosen,
                    value: roll,
                    id: 'selectedroll' + rollschoosen,
                    required: true
                });
                container.append(hiddenField);
                rollschoosen++;
                $('#rollschoosen').val(rollschoosen);
                var selectedRollMeters = parseFloat($(this).find('option:selected').text().split(' - ')[1].split(' ')[0]);
                console.log(selectedRollMeters);
                var totalMeters = parseFloat($('#totalmetersout').val());
                console.log(totalMeters);
                totalMeters += selectedRollMeters;
                console.log(totalMeters);
                $('#totalmetersout').val(totalMeters);
                $(this).find('option:selected').remove();
                $('#rollinfo').val($('#rollinfo option:first').val());
            });
            });
        </script>
    </div>

    <div id="returnform" class="container" hidden>
        <form id="form_return" action="returnprocess.php" method="post">

            <label for="date">Date:</label>
            <input type="date" name="datereturn" id="datereturn" class="form-field">

            <label for="skureturn">SKU:</label>
            <input id="skureturn" name="skureturn" type="text" class="form-field" required pattern="^(KJB|H)[0-9]+$"
                title="SKU must start with 'KJB' or 'H'." onchange="this.reportValidity();"
                oninput="this.value = this.value.toUpperCase()" placeholder="SKU">

            <label for="namereturn">Name:</label>
            <input type="text" name="namereturn" id="namereturn" class="form-field" placeholder="Name" disabled>
            <input type="hidden" id="returnvalidationField" name="returnvalidationField"
                pattern="^(?!.*SKU not found).*$" required>

            <label for="lotnoreturn">Lot Number:</label>
            <input type="text" name="lotnoreturn" placeholder="Lot Number" id="lotnoreturn" class="form-field"
                required>

            <select name="rollinforeturn" id="rollinforeturn" class="form-field-department" required>
                <option value="-" selected disabled>Choose roll</option>
            </select>
            <div id="pickedrollsreturn">
            </div>
            <input type="hidden" name="rollschoosenreturn" id="rollschoosenreturn" value="0" required>

            <!-- <label for="totalmetersin">Total Meters Selected:</label>
            <input type="number" name="totalmetersin" placeholder="Total meters" id="totalmetersin" disabled min="0"
                value="0" class="form-field"> -->

            <input type="submit" value="Submit">

        </form>
        <script>
            $(document).ready(function() {

                $('#skureturn').on('change', function() {
                    var skuNumber = $(this).val();

                    $.get('fetchName.php', {
                        sku: skuNumber
                    }, function(data) {
                        $('#namereturn').val(data);
                        $('#returnvalidationField').val(data);
                    });
                });
                $('#form_return').submit(function(e) {
                    var nameValidationValue = $('#returnvalidationField').val();
                    var pattern = /^(?!.*SKU not found).*$/;

                    if (!pattern.test(nameValidationValue)) {
                        e.preventDefault();
                        alert('Invalid SKU!!');
                    }
                });

                // ------------------------------------

                $('#lotnoreturn').on('change', function() {
                    var lotNumber = $(this).val();
                    var skuNumber = $('#skureturn').val();
                    $.get('fetchRollInfo.php', {
                        lotno: lotNumber,
                        sku: skuNumber,
                        type: 'out'
                    }, function(data) {
                        var rolls = JSON.parse(data); // Assuming the data is returned in JSON format
                        var $rollInfoSelect = $('#rollinforeturn');
                        $rollInfoSelect.empty();
                        $rollInfoSelect.append($('<option>', {
                            value: '-',
                            text: 'Choose roll',
                            disabled: true,
                            selected: true
                        }));
                        // Populate the select with new options
                        $.each(rolls, function(index, roll) {
                            $rollInfoSelect.append($('<option>', {
                                value: roll.id,
                                text: roll.rollno
                            }));
                        });
                    });
                });
            });
            $('#rollinforeturn').on('change', function() {
                var roll = $(this).val();
                var container = $('#pickedrollsreturn');
                var rollschoosen = $('#rollschoosenreturn').val();
                var selectedRollname = $(this).find('option:selected').text().split(' - ')[0].split(' ')[0];
                var hiddenField = $('<input>').attr({
                    type: 'hidden',
                    name: 'selectedrollreturn' + rollschoosen,
                    value: roll,
                    id: 'selectedrollreturn' + rollschoosen,
                    required: true
                });
                var labelRollMeters = $('<label>').attr({
                    for: 'rollmetersreturn' + rollschoosen,
                    class: 'form-label'
                }).text(' Roll No.: ' + selectedRollname);
                var inputRollMeters = $('<input>').attr({
                    id: 'rollmetersreturn' + rollschoosen,
                    name: 'rollmetersreturn' + rollschoosen,
                    type: 'number',
                    class: 'form-field',
                    min: '0',
                    step: '0.0001',
                    placeholder: 'Roll Meters',
                    required: true
                });

                
                container.append(hiddenField, labelRollMeters, inputRollMeters);
                rollschoosen++;
                $('#rollschoosenreturn').val(rollschoosen);


                $(this).find('option:selected').remove();
                $('#rollinforeturn').val($('#rollinforeturn option:first').val());
            });
        </script>
    </div>

</body>
<script>
    function startup() {
        $("#inwardform").hide();
        $("#outwardform").hide();
        $("#returnform").hide();
        resetforms();
    }

    

    function addinward() {
        $("#inwardform").show();
        $("#outwardform").hide();
        $("#returnform").hide();
        resetforms();
    }

    function addoutward() {
        $("#inwardform").hide();
        $("#outwardform").show();
        $("#returnform").hide();
        resetforms();
    }

    function addreturn() {
        $("#inwardform").hide();
        $("#outwardform").hide();
        $("#returnform").show();
        resetforms();
    }

    function viewacc() {
        $("#inwardform").hide();
        $("#outwardform").hide();
        $("#returnform").hide();
        resetforms();
    }

    function resetforms() {
        document.getElementById("form_inward").reset();
        document.getElementById("form_outward").reset();
        document.getElementById("form_return").reset();
    }
</script>

</html>