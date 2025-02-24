<div id="returnform" class="container" hidden>
    <h1>Return Form</h1>
    <input type="text" id="qrtext" class="form-field" placeholder="QR Text">
    <button onclick="read_qr_return()">Read QR</button>
    <div id="addheight"></div>
    <form id="form_return" action="returnprocess.php" method="post">
        <div id="form_return_elements">
            <label for="date">Date:</label>
            <input type="date" name="datereturn" id="datereturn" class="form-field" required>

            <label for="skureturn">SKU:</label>
            <input id="skureturn" name="skureturn" type="text" class="form-field skuField">

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

              

            <div id="pickedrollsreturn"></div>
            <input type="hidden" name="rollschoosenreturn" id="rollschoosenreturn" value="0" required>
        </div>
        <input type="submit" value="Submit">
        <button type="button" onclick="reset_return()" id="return_form_clearbtn">Clear Form</button>
    </form>
    <script>
        function read_qr_return() {
            if ($('#qrtext').val() == '') {
                alert('Enter QR Text');
                return;
            }
            var qrtext = $('#qrtext').val();
            var qrtextsplit = qrtext.split('_');
            if (qrtextsplit.length != 5) {
                alert('Invalid QR Text');
                $('#qrtext').val('');
                return;
            }
            $.get('fetchRollInfo.php', {
                type: 'QR',
                id: qrtextsplit[0]
            }, function (data) {
                if (data === 'Not Found') {
                    alert('QR code not found in Database');
                    $('#qrtext').val('');
                    return;
                } else {
                    var roll = JSON.parse(data);
                    if (roll.sku != qrtextsplit[1] || roll.name != qrtextsplit[2] || roll.lotno != qrtextsplit[3] || roll.rollno != qrtextsplit[4]) {
                        alert('QR code does not match with Roll');
                        $('#qrtext').val('');
                        return;
                    }
                    if (roll.status == 'in') {
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
                        })
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
                    $('#form_return_elements').append(
                        $('<label>').attr({
                            for: 'returnlocation',
                            class: 'form-label'
                        }).text('Location:'),
                        $('<input>').attr({
                            type: 'text',
                            name: 'returnlocation',
                            id: 'returnlocation',
                            class: 'form-field',
                            required: true
                        })
                    );
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

        $(document).ready(function () {
            $('#skureturn').on('change', function () {
                var skuNumber = $(this).val();
                $.get('fetchName.php', {
                    sku: skuNumber
                }, function (data) {
                    $('#namereturn').val(data);
                    $('#returnvalidationField').val(data);
                });
            });

            $('#form_return').submit(function (e) {
                var nameValidationValue = $('#returnvalidationField').val();
                var pattern = /^(?!.*SKU not found).*$/;
                if (!pattern.test(nameValidationValue)) {
                    e.preventDefault();
                    alert('Invalid SKU!!');
                }
            });

            $('#skureturn').on('change', function () {
                var skuNumber = $(this).val();
                $.get('fetchLotNumber.php', {
                    sku: skuNumber,
                    type: 'out'
                }, function (data) {
                    var lots = JSON.parse(data);
                    var $lotNumberSelect = $('#lotnoreturn');
                    $lotNumberSelect.empty();
                    $lotNumberSelect.append($('<option>', {
                        value: '-',
                        text: 'Choose lot number',
                        disabled: true,
                        selected: true
                    }));
                    $.each(lots, function (index, lot) {
                        $lotNumberSelect.append($('<option>', {
                            value: lot.lotno,
                            text: lot.lotno + ' - ' + lot.totalmeters
                        }));
                    });
                });
            });

            $('#lotnoreturn').on('change', function () {
                var lotNumber = $(this).val();
                var skuNumber = $('#skureturn').val();
                $.get('fetchRollInfo.php', {
                    lotno: lotNumber,
                    sku: skuNumber,
                    type: 'out'
                }, function (data) {
                    var rolls = JSON.parse(data);
                    var $rollInfoSelect = $('#rollinforeturn');
                    $rollInfoSelect.empty();
                    $rollInfoSelect.append($('<option>', {
                        value: '-',
                        text: 'Choose roll',
                        disabled: true,
                        selected: true
                    }));
                    $.each(rolls, function (index, roll) {
                        $rollInfoSelect.append($('<option>', {
                            value: roll.id,
                            text: roll.rollno
                        }));
                    });
                });
            });
        });

        $('#rollinforeturn').on('change', function () {
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
