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
<?php
session_start();
if (!isset($_SESSION['userdets']) || empty($_SESSION['userdets'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
else {
    if ($_SESSION['userdets'][1] == "Manav") {
        header("Location: superuser.php");
        exit();
    }
}
if (isset($_SESSION['return_qr'])) {
    unset($_SESSION['return_qr']);
}
if (isset($_SESSION['out_qr'])) {
    unset($_SESSION['out_qr']);
}
include("connection/dbconnection.php");
$skus = "SELECT * FROM main";
$skus_list = mysqli_query($con, $skus);
$query = "SELECT * FROM datadb";
$result = mysqli_query($con, $query);
$rolls = [];

while ($row = mysqli_fetch_assoc($result)) {
    $rolls[] = $row;
}
?>


<body onload="startup()">
    <div id="headerdiv">
    <div id="reportsdiv">
    <a href="overviewreport.php">Generate Overview</a>
    <a href="overviewreport.php">Generate Detailed Report</a>
    </div>
    <div id="logoutbtndiv">
    <a href="logout.php" id="logoutbtn">Logout</a>
    </div>
    </div>
    <div id="btns">
        <button onclick="viewsku()">View SKU</button>
        <button onclick="addinward()">Inward Form</button>
        <button onclick="addoutward()">Outward Form</button>
        <button onclick="addreturn()">Return Form</button>
    </div>
    <div id="skuview" hidden>
        <div id="skutablediv">
            <table id="skutable" border="1">
                <thead>
                    <th>SKU</th>
                    <th>Name</th>
                    <!-- <th>Construction</th> -->
                    <th>Thread Count</th>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($skus_list)) {
                        echo "<tr>";
                        echo "<td>" . $row['SKU'] . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        // echo "<td>" . $row['Construction'] . "</td>";
                        echo "<td>" . $row['ThreadCount'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#skutable').DataTable({
                    "order": [
                        [0, "asc"]
                    ],
                    "paging": false,
                });
            });
        </script>
    </div>
    <div id="inwardform" hidden>
        <h1>Inward Form</h1>
        <form id="form_inward" action="inwardprocess.php" method="post">

            <label for="date">Date:</label>
            <input type="date" name="date" id="date" class="form-field" required>

            <label for="skuinward">SKU:</label>
            <input id="skuinward" name="skuinward" type="text" class="form-field" required pattern="^(KJB|H|SA|B)[0-9]+$"
            title="SKU must start with 'KJB' or 'H' or 'B' or 'SA'." onchange="this.reportValidity();"
                oninput="this.value = this.value.toUpperCase()" placeholder="SKU">

            <label for="nameinward">Name:</label>
            <input type="text" name="nameinward" id="nameinward" class="form-field" placeholder="Name" disabled>
            <input type="hidden" id="namevalidationField" name="namevalidationField"
                pattern="^(?!.*SKU not found).*$" required>

                <label for="width">Width:</label>
                <input id="width" name="width" type="text" class="form-field" required>
            
                <label for="lotno">Lot Number:</label>
            <input type="text" name="lotno" placeholder="Lot Number" id="lotno" class="form-field" required>



            <label for="construction">Construction:</label>
            <input id="construction" name="construction" type="text" class="form-field" required>


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
        <input type="text" id="qrtext_outward" class="form-field" placeholder="QR Text">
        <button onclick=read_qr_outward()>Read QR</button>

        <form id="form_outward" action="outwardprocess.php" method="post">
            <div id="form_outward_elements">
            <label for="date">Date:</label>
            <input type="date" name="dateoutward" id="dateoutward" class="form-field">

            <label for="skuoutward">SKU:</label>
            <input id="skuoutward" name="skuoutward" type="text" class="form-field" required pattern="^(KJB|H|SA|B)[0-9]+$"
            title="SKU must start with 'KJB' or 'H' or 'B' or 'SA'." onchange="this.reportValidity();"
                oninput="this.value = this.value.toUpperCase()" placeholder="SKU">

            <label for="nameoutward">Name:</label>
            <input type="text" name="nameoutward" id="nameoutward" class="form-field" placeholder="Name" disabled>
            <input type="hidden" id="outwardvalidationField" name="outwardvalidationField"
                pattern="^(?!.*SKU not found).*$" required>

            <label for="lotnooutward">Lot Number:</label>
            <input type="text" name="lotnooutward" placeholder="Lot Number" id="lotnooutward" class="form-field"
                required>

            <div id="rollinfo">
                <input type="checkbox" name="selectedroll" id="selectedrolldefault" value="0" disabled hidden>
            </div>
            <div id="pickedrolls">
            </div>
            <input type="hidden" name="rollschoosen" id="rollschoosen" value="0" min="0" step="1" required>

            <label for="totalmetersout">Total Meters Selected:</label>
            <input type="number" name="totalmetersout" placeholder="Total meters" id="totalmetersout" disabled min="0"
                value="0" class="form-field">
            </div>
            <input type="submit" value="Submit">

        </form>
        <script>
            function read_qr_outward() {
                if($('#qrtext_outward').val() == ''){
                    alert('Enter QR Text');
                    return;
                }
                var qrtext = $('#qrtext_outward').val();
                var qrtextsplit = qrtext.split('_');
                if(qrtextsplit.length != 5){
                    alert('Invalid QR Text');
                    $('#qrtext_outward').val('');
                    return;
                }
                $.get('fetchRollInfo.php', {
                    type: 'QR',
                    id: qrtextsplit[0]
                }, function(data) {
                    if (data === 'Not Found') {
                        alert('QR code not found in Database');
                        $('#qrtext_outward').val('');
                        return;
                    } else {
                        var roll = JSON.parse(data); 
                        // console.log(roll);
                        if(roll.sku != qrtextsplit[1] || roll.name != qrtextsplit[2] || roll.lotno != qrtextsplit[3] || roll.rollno != qrtextsplit[4]){
                            alert('QR code does not match with Roll Information');
                            $('#qrtext_outward').val('');
                            return;
                        }
                        if(roll.status == 'out'){
                            alert('Roll is already out');
                            $('#qrtext_outward').val('');
                            return;
                        }
                        
                        $('#form_outward_elements').empty();
                        $('#form_outward_elements').append(
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'outward_qr',
                                id: 'outward_qr',
                                value: $('#qrtext_outward').val(),
                                required: true
                            }),
                            $('<label>').attr({
                                for: 'skuoutward',
                                class: 'form-label'
                            }).text('SKU:'),
                            $('<input>').attr({
                                type: 'text',
                                name: 'skuoutward',
                                id: 'skuoutward',
                                class: 'form-field',
                                value: roll.sku,
                                required: true,
                                readonly: true,
                            }),
                            $('<label>').attr({
                                for: 'nameoutward',
                                class: 'form-label'
                            }).text('Name:'),
                            $('<input>').attr({
                                type: 'text',
                                name: 'nameoutward',
                                id: 'nameoutward',
                                class: 'form-field',
                                value: roll.name,
                                required: true,
                                readonly: true,
                            }),
                            $('<label>').attr({
                                for: 'lotnooutward',
                                class: 'form-label'
                            }).text('Lot Number:'),
                            $('<input>').attr({
                                name: 'lotnooutward',
                                id: 'lotnooutward',
                                class: 'form-field',
                                required: true,
                                value: roll.lotno,
                                readonly: true
                            }),
                            $('<input>').attr({
                            type: 'hidden',
                            name: 'selectedrolloutward',
                            id: 'selectedrolloutward',
                            value: roll.id,
                            required: true
                            }),
            
                        );
                    }
                });
            }


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
                    else if ($('#rollschoosen').val() == 0){
                        e.preventDefault();
                        alert('No rolls selected!!');
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
                            
                            $.each(rolls, function(index, roll) {
                                $rollInfoSelect.append($('<input>', {
                                    type: 'checkbox',
                                    value: roll.id,
                                    id: roll.id,
                                    name: 'selectedroll',
                                    checked: false
                                }));
                                $rollInfoSelect.append($('<label>', {
                                    for: roll.id,
                                    text: roll.rollno + ' - ' + roll.currentmeters + ' meters'
                                }));
                                $rollInfoSelect.append($('<br>'));
                            });
                        });
                    
                    }
                });
                $('#rollinfo').on('click', 'input[name="selectedroll"]', function() {
                var totalmeters = 0;
                var rollschoosen = 0;
                var checkeddiv = $('#pickedrolls');
                var is_checked = $('input[name="selectedroll"]:checked').length;

                $('input[name="selectedroll"]:checked').each(function() {
                    var meters = parseFloat($(this).next('label').text().split(' ')[2]) || 0;
                    totalmeters += meters;
                    checkeddiv.append($('<input>').attr({
                        type: 'hidden',
                        name: 'selectedroll' + rollschoosen,
                        value: $(this).attr('id'),
                        required: true
                    }));
                    rollschoosen++;
                });
                $('#totalmetersout').val(totalmeters);
                $('#rollschoosen').val(is_checked);
            });
        });
        </script>
    </div>

    <div id="returnform" class="container" hidden>
        <input type="text" id="qrtext" class="form-field" placeholder="QR Text">
        <button onclick=read_qr_return()>Read QR</button>

        <form id="form_return" action="returnprocess.php" method="post">
            <div id="form_return_elements">
            <label for="date">Date:</label>
            <input type="date" name="datereturn" id="datereturn" class="form-field">

            <label for="skureturn">SKU:</label>
            <input id="skureturn" name="skureturn" type="text" class="form-field" required pattern="^(KJB|H|SA|B)[0-9]+$"
            title="SKU must start with 'KJB' or 'H' or 'B' or 'SA'." onchange="this.reportValidity();"
                oninput="this.value = this.value.toUpperCase()" placeholder="SKU">

            <label for="namereturn">Name:</label>
            <input type="text" name="namereturn" id="namereturn" class="form-field" placeholder="Name" disabled>
            <input type="hidden" id="returnvalidationField" name="returnvalidationField"
                pattern="^(?!.*SKU not found).*$" required>

            <label for="lotnoreturn">Lot Number:</label>
            <select name="lotnoreturn" id="lotnoreturn" class="form-field-department" required>
                <option value="-" selected disabled>Choose Lot</option>

            </select>
            <label for="rollinforeturn">Roll Number:</label>
            <select name="rollinforeturn" id="rollinforeturn" class="form-field-department" required>
                <option value="-" selected disabled>Choose roll</option>
            </select>
            <div id="pickedrollsreturn">
            </div>
            <input type="hidden" name="rollschoosenreturn" id="rollschoosenreturn" value="0" required>

            </div>
            <input type="submit" value="Submit">
            <button type="button" onclick="reset_return()" id="return_form_clearbtn">Clear Form</button>
        </form>
        <script>
            function read_qr_return() {
                if($('#qrtext').val() == ''){
                    alert('Enter QR Text');
                    return;
                }
                var qrtext = $('#qrtext').val();
                var qrtextsplit = qrtext.split('_');
                if(qrtextsplit.length != 5){
                    alert('Invalid QR Text');
                    $('#qrtext').val('');
                    return;
                }
                $.get('fetchRollInfo.php', {
                    type: 'QR',
                    id: qrtextsplit[0]
                }, function(data) {
                    if (data === 'Not Found') {
                        alert('QR code not found in Database');
                        $('#qrtext').val('');
                        return;
                    } else {
                        var roll = JSON.parse(data); 
                        // console.log(roll);
                        if(roll.sku != qrtextsplit[1] || roll.name != qrtextsplit[2] || roll.lotno != qrtextsplit[3] || roll.rollno != qrtextsplit[4]){
                            alert('QR code does not match with Roll');
                            $('#qrtext').val('');
                            return;
                        }
                        if(roll.status == 'in'){
                            alert('Roll is not out');
                            $('#qrtext').val('');
                            return;
                        }
                        
                        $('#form_return_elements').empty();
                        $('#return_form_clearbtn').hide();
                        $('#form_return_elements').append(
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'return_qr',
                                id: 'return_qr',
                                value: $('#qrtext').val(),
                                required: true
                            }),
                            $('<label>').attr({
                                for: 'skureturn',
                                class: 'form-label'
                            }).text('SKU:'),
                            $('<input>').attr({
                                type: 'text',
                                name: 'skureturn',
                                id: 'skureturn',
                                class: 'form-field',
                                value: roll.sku,
                                required: true,
                                readonly: true,
                            }),
                            $('<label>').attr({
                                for: 'namereturn',
                                class: 'form-label'
                            }).text('Name:'),
                            $('<input>').attr({
                                type: 'text',
                                name: 'namereturn',
                                id: 'namereturn',
                                class: 'form-field',
                                value: roll.name,
                                required: true,
                                readonly: true,
                            }),
                            $('<label>').attr({
                                for: 'lotnoreturn',
                                class: 'form-label'
                            }).text('Lot Number:'),
                            $('<input>').attr({
                                name: 'lotnoreturn',
                                id: 'lotnoreturn',
                                class: 'form-field',
                                required: true,
                                value: roll.lotno,
                                readonly: true
                            }),
                            $('<input>').attr({
                            type: 'hidden',
                            name: 'selectedrollreturn',
                            id: 'selectedrollreturn',
                            value: roll.id,
                            required: true
                            }),
            
                        );
                        $('#form_return_elements').append(
                            $('<label>').attr({
                                for: 'rollmetersreturn',
                                class: 'form-label'
                            }).text(' Roll No.: ' + roll.rollno)
                        );
                        $('#form_return_elements').append(
                            $('<input>').attr({
                                id: 'rollmetersreturn',
                                name: 'rollmetersreturn',
                                type: 'number',
                                class: 'form-field',
                                min: '0',
                                step: '0.0001',
                                placeholder: 'Meters Consumed',
                                required: true
                            })
                        );
                        
                        // $('form_return').append($('<input>').attr({
                        //     type: 'submit',
                        //     value: "Submit",
                        // }));
                    }
                });
                
            }
            function reset_return() {
                document.getElementById("form_return").reset();
                $('#pickedrollsreturn').empty();
                $('#rollschoosenreturn').val(0);
                $('#rollinforeturn').empty();
                $('#rollinforeturn').append($('<option>', {
                    value: '-',
                    text: 'Choose roll',
                    disabled: true,
                    selected: true
                }));
                $('#lotnoreturn').empty();
                $('#lotnoreturn').append($('<option>', {
                    value: '-',
                    text: 'Choose lot number',
                    disabled: true,
                    selected: true
                }));
            }
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

                $('#skureturn').on('change', function() {
                    var skuNumber = $(this).val();
                    $.get('fetchLotNumber.php', {
                        sku: skuNumber,
                        type: 'out'
                    }, function(data) {
                        var lots = JSON.parse(data); 
                        var $lotNumberSelect = $('#lotnoreturn');
                        $lotNumberSelect.empty();
                        $lotNumberSelect.append($('<option>', {
                            value: '-',
                            text: 'Choose lot number',
                            disabled: true,
                            selected: true
                        }));
                        $.each(lots, function(index, lot) {
                            $lotNumberSelect.append($('<option>', {
                                value: lot.lotno,
                                text: lot.lotno + ' - ' + lot.totalmeters
                            }));
                        });
                    });
                });

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
                    placeholder: 'Meters Consumed',
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
        $("#skuview").hide();
        $("#inwardform").hide();
        $("#outwardform").hide();
        $("#returnform").hide();
        resetforms();
    }

    
    function viewsku() {
        $("#skuview").show();
        $("#inwardform").hide();
        $("#outwardform").hide();
        $("#returnform").hide();
        resetforms();
    }

    function addinward() {
        $("#skuview").hide();
        $("#inwardform").show();
        $("#outwardform").hide();
        $("#returnform").hide();
        resetforms();
    }

    function addoutward() {
        $("#skuview").hide();
        $("#inwardform").hide();
        $("#outwardform").show();
        $("#returnform").hide();
        resetforms();
    }

    function addreturn() {
        $("#skuview").hide();
        $("#inwardform").hide();
        $("#outwardform").hide();
        $("#returnform").show();
        resetforms();
    }

    

    function resetforms() {
        document.getElementById("form_inward").reset();
        document.getElementById("form_outward").reset();
        document.getElementById("form_return").reset();
    }
</script>
<?php
if (isset($_SESSION['dashboarderror'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['dashboarderror'], ENT_QUOTES, 'UTF-8') . "');</script>";
    unset($_SESSION['dashboarderror']);
}
?>
</html>